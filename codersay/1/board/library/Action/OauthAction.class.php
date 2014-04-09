<?php
	class OauthAction extends Action{
		public function login(){
			$this->setSessionQQlogin();
		}

		public function getUserOpenID(){
			if ( !$_SESSION['openid'] ){
				$this->setSessionQQlogin(1);
			}else{
				echo $_SESSION['openid'];
			}
		}

		public function getOpenIDOne(){
			if ( !$_SESSION['openid'] ){
				$this->getAccessToken();
		    	$this->getOpenID();
			}
			echo $_SESSION['openid'];
		}

		public function chklogin()
		{
			
			$this->getAccessToken();
		    $this->getOpenID();
		    //dump($_SESSION);
		    //echo "<script>window.opener.location.reload();window.close();</script>";
		    echo "<script>window.opener.location.href='".U('chkmyinfo')."';window.close();</script>";
		}

		public function chkmyinfo()
		{
			if ( $_SESSION['openid'] !== '' )
			{
				$model = M('User');
				$where['bind_account'] = $_SESSION['openid'];
				$user = $model->where($where)->find();
				if ( empty( $user ) ){
					$this->error('无此用户！');
				}else{
					unset( $user['password'] );
					$_SESSION['AUTH'] = $user;
					if ( empty( $_SESSION['AUTH']['last_login_time'] ) ) $_SESSION['AUTH']['last_login_time'] = time();
		            $data = array();
					$data['id']	=	$user['id'];
					$data['last_login_time']	=	time();
					$data['login_count']	=	array('exp','(login_count+1)');
					$data['last_login_ip']	=	get_client_ip();
					$model->save($data);
					$this->redirect(__APP__);
				}
			}
		}

		public function getUserInfo()
		{
		    $get_user_info = "https://graph.qq.com/user/get_user_info?"
		        . "access_token=" . $_SESSION['access_token']
		        . "&oauth_consumer_key=" . $_SESSION["appid"]
		        . "&openid=" . $_SESSION["openid"]
		        . "&format=json";

		    $info = file_get_contents($get_user_info);
		    $arr = json_decode($info, true);

		    return $arr;
		}

		private function getAccessToken(){
			if($_REQUEST['state'] == $_SESSION['state']) //csrf
		    {
		        $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
		            . "client_id=" . $_SESSION["appid"]. "&redirect_uri=" . urlencode($_SESSION["callback"])
		            . "&client_secret=" . $_SESSION["appkey"]. "&code=" . $_REQUEST["code"];

		        $response = file_get_contents($token_url);
		        if (strpos($response, "callback") !== false)
		        {
		            $lpos = strpos($response, "(");
		            $rpos = strrpos($response, ")");
		            $response  = substr($response, $lpos + 1, $rpos - $lpos -1);
		            $msg = json_decode($response);
		            if (isset($msg->error))
		            {
		                echo "<h3>error:</h3>" . $msg->error;
		                echo "<h3>msg  :</h3>" . $msg->error_description;
		                exit;
		            }
		        }

		        $params = array();
		        parse_str($response, $params);

		        //debug
		        //dump($params);

		        //set access token to session
		        $_SESSION["access_token"] = $params["access_token"];

		    }
		    else 
		    {
		        echo("The state does not match. You may be a victim of CSRF.");
		    }
		}

		private function getOpenID()
		{
		    $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" 
		        . $_SESSION['access_token'];

		    $str  = file_get_contents($graph_url);
		    if (strpos($str, "callback") !== false)
		    {
		        $lpos = strpos($str, "(");
		        $rpos = strrpos($str, ")");
		        $str  = substr($str, $lpos + 1, $rpos - $lpos -1);
		    }

		    $user = json_decode($str);
		    if (isset($user->error))
		    {
		        echo "<h3>error:</h3>" . $user->error;
		        echo "<h3>msg  :</h3>" . $user->error_description;
		        exit;
		    }

		    //debug
		    //echo("Hello " . $user->openid);

		    //set openid to session
		    $_SESSION["openid"] = $user->openid;
		}

		private function setSessionQQlogin( $type = 0 ){
			if ( $type == 0 ){
				$parse_str = U('chklogin');
			}else{
				$parse_str = U('getOpenIDOne');
			}
			$_SESSION["appid"]    	= C('QQ_ZONE_ID');
			$_SESSION["appkey"]   	= C('QQ_ZONE_KEY');
			$_SESSION["callback"] 	= C('QQ_RETURN_DOMAIN') . $parse_str;
			$_SESSION["scope"] 		= "get_user_info,add_share,list_album,add_album,upload_pic,add_topic,add_one_blog,add_weibo,add_t,add_pic_t";
			$this->QQlogin( $_SESSION["appid"], $_SESSION["scope"], $_SESSION["callback"] );
		}

		private function QQlogin($appid, $scope, $callback)
		{
		    $_SESSION['state'] = md5(uniqid(rand(), TRUE)); //CSRF protection
		    $login_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id=" 
		        . $appid . "&redirect_uri=" . urlencode($callback)
		        . "&state=" . $_SESSION['state']
		        . "&scope=".$scope;
		    header("Location:$login_url");
		}
	}