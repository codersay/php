<?php
class SysAction extends AdminAction{
	public function changePwd() {
		$username = $_SESSION['username'];

		$this->assign('username', $username);
		$this->display();
	}

	public function changePwdAction() {
		$oldPwd = md5($_POST['oldPwd']);

		$map['id'] = $_SESSION['uid'];
		$map['password'] = $oldPwd;

		$list = M("Users")->where($map)->select();
		if( count($list) != 1 ) {
			echo 'error'; exit;
		}
		
		$condition['password'] = md5($_POST['newPwd']);
		$condition['id'] = $_SESSION['uid'];

		$status = M("Users")->data($condition)->save();
		if(false !== $status) {
			$_SESSION["upwd"] = $condition['password'];

			echo 'ok';
		}else {
			echo 'ĞŞ¸ÄÃÜÂëÊ§°Ü';
		}
	}
}