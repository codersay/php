<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// $Id$
class PublicAction extends Action {
	// 检查用户是否登录
	protected function checkUser() {
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			 $this->error('没有登录',__GROUP__.'/Public/login');
		}
	}
    public function index(){
		//如果通过认证跳转到首页
		 redirect(__GROUP__);
	}
	
 
	// 登录检测
	public function checkLogin() {
		if(!is_username($_POST['username'])) $this->error('帐号错误！');
        if(!is_password($_POST['password'])) $this->error('密码错误！');
        if(empty($_POST['verify'])) $this->error('验证码必须！');
        //生成认证条件
        $map            =   array();
		// 支持使用绑定帐号登录
		$map['username']	= $_POST['username'];
        $map["status"]	=	array('gt',0);//大于
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}
		import ( 'ORG.Util.RBAC' );
        $authInfo = RBAC::authenticate($map);
        if(false === $authInfo) {
            $this->error('帐号不存在或已禁用！');
        }elseif($authInfo['status']==0){
			$this->error('帐号已禁用！');
		
		}else {
			$password = pwdHash($_POST['password']);
            if($authInfo['password'] != $password) {
            	$this->error('密码错误！');
            }
            $_SESSION[C('USER_AUTH_KEY')]	=	$authInfo['id'];//赋值给用户认证SESSION标记
            $_SESSION['email']	=	$authInfo['email'];
            $_SESSION['loginUserName']		=	$authInfo['nickname'];
            $_SESSION['lastLoginTime']		=	$authInfo['lastlogintime'];
			$_SESSION['loginnum']	=	$authInfo['loginnum'];
			$_SESSION['lastloginip']	=	$authInfo['lastloginip'];
			//$_SESSION['verify']	=	$authInfo['verify'];
             if($authInfo['isadministrator']==1) {//判断是否管理员
            	$_SESSION['administrator']		=	true;
            }
            //保存登录信息(相当于更新信息）
			$User	=	M('User');
			$ip		=	get_client_ip();//
			$time	=	time();
            $data = array();
			$data['id']	=	$authInfo['id'];
			$data['lastlogintime']	=	$time;
			$data['loginnum']	=	array('exp','loginnum+1');//??
			$data['lastloginip']	=	$ip;
			//$data['verify']	=	$authInfo['verify'];
			$User->save($data);
			// 缓存访问权限
            RBAC::saveAccessList();
			 $this->success('登录成功！',__GROUP__.'/Index/index');

		}
	}
	
	public function main() {
        $info = array(
            '操作系统'=>PHP_OS,
            '运行环境'=>$_SERVER["SERVER_SOFTWARE"],
            'PHP运行方式'=>php_sapi_name(),
            'WBlog版本信息'=>'3.1.2_2',
            '上传附件限制'=>ini_get('upload_max_filesize'),
           
            '北京时间'=>gmdate("Y年n月j日 H:i:s",time()+8*3600),
            '服务器域名/IP'=>$_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
            
            'register_globals'=>get_cfg_var("register_globals")=="1" ? "ON" : "OFF",
            'magic_quotes_gpc'=>(1===get_magic_quotes_gpc())?'YES':'NO',
            'magic_quotes_runtime'=>(1===get_magic_quotes_runtime())?'YES':'NO',
			'host'=>gethostbyname($_SERVER['SERVER_NAME']),
            );
        $this->assign('info',$info);
		
        $this->display();
    }
	public function main_top() {
		  $this->display();
    }
	public function header() {
		  $this->display();
    }
	public function top(){
    	if($_SESSION[C('USER_AUTH_KEY')]){
    		$User	= M("User");
    		$condition['id'] = $_SESSION[C('USER_AUTH_KEY')];
    		$User = $User->where($condition)->field( 'username' )->find();
    		
    		$this->assign("id",$_SESSION['id']);
    		$this->assign("username",$User['username']);
    	}
    	
    	$this->display();
    }
	public function foot() {
		
		$this->display();
	}
	
	public function menu() {
		$var=$_GET['nav'];
		$this->assign('show', 'display:none;');
		$this->assign('show', $var);
		$this->display();
	}
	// 用户登录页面
	public function login() {
		if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			
			 $this->redirect('Index/index');
		}else{		
			$this->display();
					
		}
	}
    // 更换密码
    public function changePwd(){
		$this->checkUser();
        //对表单提交处理进行处理或者增加非表单数据
		if(md5($_POST['verify'])	!= $_SESSION['verify']) {
			$this->error('验证码错误！');
		}
		$map	=	array();
        $map['password']= pwdHash($_POST['oldpassword']);
        if(isset($_POST['username'])) {
            $map['username']	 =	 $_POST['username'];
        }elseif(isset($_SESSION[C('USER_AUTH_KEY')])) {
            $map['id']		=	$_SESSION[C('USER_AUTH_KEY')];
        }
        //检查用户
        $User    =   M("User");
        if(!$User->where($map)->field('id')->find()) {
            $this->error('旧密码不符或者用户名错误！');
        }else {
			$User->password	=	pwdHash($_POST['password']);
			$User->save();
			$this->success('密码修改成功！');
         }
    }
	public function logout(){
        if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
            $this->assign("jumpUrl",__URL__.'/login/');
            $this->success('登出成功！');
        }else {
            $this->error('已经登出！');
        }
    }
    public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,gif,48,22,'verify');	
	}	
}
?>