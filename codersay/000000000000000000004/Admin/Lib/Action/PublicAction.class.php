<?php
/**
 * @公用控制器，注：区别于CommonAction
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/05
 * @Copyright: www.iqishe.com
 */
class PublicAction extends Action{
	public function index(){
		$this->login();
	}
	//登陆页面
	public function login(){
		if(!isset($_SESSION[C('USER_AUTH_KEY')])) {
			$this->display();
		}else{
			$this->redirect('Index/index');
		}
	}

	//登陆检测
	public function checkLogin(){
		if(empty($_POST['username'])) {
			$this->error('请填写用户名！');
		}elseif (empty($_POST['pwd'])){
			$this->error('请填写密码！');
		}elseif (empty($_POST['verify'])){
			$this->error('请填写验证码！');
		}
		//生成认证条件
		$map = array();
		// 支持使用绑定帐号登录
		$map['username'] = $_POST['username'];
		//$map["status"] = array('gt',0);
		if(session('verify') != md5($_POST['verify'])) {
			$this->error('验证码错误！');
		}
		import ( 'ORG.Util.RBAC' );
		$authInfo = RBAC::authenticate($map);
		//使用用户名、密码和状态的方式进行认证
		if(false === $authInfo) {
			$this->error('帐号不存在！');
		}else {
			if($authInfo['pwd'] != md5($_POST['pwd'])) {
				$this->error('密码错误！');
			}
			//是否禁用
			if($authInfo['status'] == 0){
				$this->error('账号已被管理员禁用！');
			}
			$_SESSION[C('USER_AUTH_KEY')] = $authInfo['uid'];
			$_SESSION['email'] = $authInfo['email'];
			$_SESSION['loginUserName'] = $authInfo['username'];
			$_SESSION['lastLoginTime'] = $authInfo['logintime'];
			//$_SESSION['login_count'] = $authInfo['login_count'];
			//若是管理员开启管理员权限
			if($authInfo['isadmin']==1) {
				$_SESSION[C('ADMIN_AUTH_KEY')] = true;
			}
			//保存登录信息
			$User = M('Users');
			$ip = get_client_ip();
			$time = time();
			$data = array();
			$data['uid'] = $authInfo['uid'];
			$data['logintime'] = $time;
			//$data['login_count']	=	array('exp','login_count+1');
			$data['loginip'] = $ip;
			$User->save($data);

			// 缓存访问权限
			RBAC::saveAccessList();
			$this->success('登录成功！',__APP__.'/Index/index');

		}
	}

	//注销登录
	public function logOut(){
		if(isset($_SESSION[C('USER_AUTH_KEY')])) {
			unset($_SESSION[C('USER_AUTH_KEY')]);
			unset($_SESSION);
			session_destroy();
			$this->success('退出成功！',__URL__.'/login/');
		}else {
			$this->error('无需重复退出！');
		}
	}

	//生成验证码
	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,gif,48,22,'verify');
	}
}
?>