<?php
	class PublicAction extends Action{
		
		protected function checkUser() {
			if(!isset($_SESSION['AUTH'])) {
				$this->redirect('login');
			}
		}
		
		public function index(){
			if(!isset($_SESSION['AUTH'])) {
				$this->redirect('login');
			}else{
				$this->redirect(__APP__);
			}
		}
		
		public function login(){
			if(!isset($_SESSION['AUTH'])) {
				$this->display();
			}else{
				$this->redirect(__APP__);
			}
		}
		
		public function logout(){
	        if(isset($_SESSION['AUTH'])) {
				unset($_SESSION);
				session_destroy();
	            $this->assign("jumpUrl", U('public/login') );
	            $this->success('登出成功！');
	        }else {
	            $this->error('已经登出！');
	        }
	    }
		
		public function checkLogin() {
			//登录验证
			$account = trim( $_POST['account'] );
			$password = trim( $_POST['password'] );
			$verify = trim( $_POST['verify'] );
			##$subpass = substr( md5( $password ) , 5, 8 );
			$subpass = md5( $password );

			$error = $resid = '';
			if ( md5( $verify ) != $_SESSION['verify'] ){
				$error = '验证码错误！'; $resid = 'verify';
			}
			if ( empty( $password ) ) {
				$error = '密码不能为空！'; $resid = 'password';
			}
			if ( empty( $account ) ) {
				$error = '账号不能为空！'; $resid = 'account';
			}

			if ( $error != '' ){
				if ( $this->isAjax() ){
					$this->error( $error, $resid );
				}else{
					$this->error( $error );
				}
			}
			
			$model = M('User');
			$user = $model->where( "account='".$account."'" )->find();
			if ( empty( $user ) ){
				if ( $this->isAjax() ){
					$this->error('用户名错误！','account');
				}else{
					$this->error('用户名错误！');
				}
			}else{
				if ( $subpass == $user['password'] ) {
					unset( $user['password'] );
					$_SESSION['AUTH'] = $user;
					if ( empty( $_SESSION['AUTH']['last_login_time'] ) ){
						$_SESSION['AUTH']['last_login_time'] = time();
					}
		            $data = array();
					$data['id']	=	$user['id'];
					$data['last_login_time']	=	time();
					$data['login_count']	=	array('exp','(login_count+1)');
					$data['last_login_ip']	=	get_client_ip();
					$model->save($data);
					//$this->redirect(__APP__);
					if ( $_POST['reuri'] ){
						$reuri = base64_decode( $this->_post('reuri') );
					}else{
						$reuri = __APP__;
					}
					$this->success('登录成功',$reuri);
				}else{
					if ( $this->isAjax() ){
						$this->error('密码错误！','password');
					}else{
						$this->error('密码错误！');
					}
				}
			}
		}
		
		// 验证码显示
	    public function verify(){
	        import("ORG.Util.Image");
	        Image::buildImageVerify(4);
	    }
		
	}
