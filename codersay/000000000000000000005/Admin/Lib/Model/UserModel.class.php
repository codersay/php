<?php
// 用户模型
class UserModel extends CommonModel {
	public $_validate	=	array(
		array('username','/^[a-z]\w{3,}$/i','帐号格式错误'),
		array('nickname','require','昵称必须'),
		array('password','require','密码必须'),
		array('repassword','require','确认密码必须'),
		array('repassword','password','确认密码不一致',self::EXISTS_VALIDATE,'confirm'),
		array('username','','帐号已经存在',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
		);

	public $_auto		=	array(
	    array('status','1'), 
		array('password','pwdHash',self::MODEL_BOTH,'callback'),
		array('createtime','time',self::MODEL_INSERT,'function'),
		array('updatetime','time',self::MODEL_UPDATE,'function'),
		);

	protected function pwdHash() {
		if(isset($_POST['password'])) {
			$password = md5(md5(trim($_POST['password'])).C('KEYCODE'));
			return $password;
		}else{
			return false;
		}
	}
	
}
?>