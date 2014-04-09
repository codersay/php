<?php
/**
 * @用户管理模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/25
 * @Copyright: www.iqishe.com
 */

class UsersModel extends Model{
	//自动验证
	protected $_validate = array(
		array('username','require','用户登录ID不能为空！'),
		array('username','','用户登录ID已存在!',0,'unique',1),
		array('pwd','require','用户密码不能为空！')
	);

	//自动完成
	protected $_auto = array(
		array('createtime','time',1,'function'),
		array('updatetime','time',3,'function'),
	);
}
?>