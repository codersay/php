<?php
class LoginAction extends Action {
	/*
	* 判断用户是否登录
	*/
	public function checkLogin() {
		if(!isset($_SESSION['username']) || $_SESSION['username'] == "" || !isset($_SESSION['upwd']) || $_SESSION['upwd'] == "") {
			$this->redirect("Admin-Login/index");
		}
		$User = M("Users");
		$condition['username'] = $_SESSION['username'];
		$condition['password'] = $_SESSION['upwd'];
		$list = $User->where($condition)->select();
		if( count($list) == 0 ) {
			$this->clearLogin();
			$this->redirect("Admin-Login/index");
		}
	}
	
	public function index() {
		$this -> display();
	}
	
	/**
	* 管理员登录，处理登录信息
	*/
	public function login() {
		C("TMPL_ACTION_ERROR", "Public:success");
		C("TMPL_ACTION_SUCCESS", "Public:success");
		if(empty($_POST['username'])) {
			$this->error('请填写用户名！');
		}elseif (empty($_POST['password'])){
			$this->error('请填写密码！');
		}elseif (empty($_POST['verify'])){
			$this->error('验证码必须！');
		}
		
		if($_SESSION['verify'] != md5($_POST['verify'])) {
			$this->error('验证码错误');
		}
		
		$url = "/Admin/Index/index";	//登录后转向到的页面

		$map['username'] = $_POST['username'];
		$map['password'] = md5($_POST['password']);
		$authInfo = M("Users")->where($map)->find();
		if( false == $authInfo ) {
			$this->error('用户名或密码错误');
		}else{
			$_SESSION["uid"] = $authInfo['id'];
			$_SESSION["username"] = $authInfo['username'];
			$_SESSION["upwd"] = $authInfo['password'];

			$this->assign('jumpUrl', $url);
			$this->assign('waitSecond', 2);
			$this->success('登陆成功');
		}
	}
	
	public function verify() {
		import('@.ORG.Image');
		Image::buildImageVerify(4, 1);
	}
	
	/**
	* 退出登录
	*/
	public function logout() {
		$this->clearLogin();

		$this->redirect("Index/index");
	}

	public function clearLogin() {
		$_SESSION['uid'] = '';
		$_SESSION['username'] = '';
		$_SESSION['upwd'] = '';
	}
}
?>