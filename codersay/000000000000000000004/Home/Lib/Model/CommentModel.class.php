<?php

class CommentModel extends RelationModel{
	protected $_link = array(
		'Article' => array(
			'mapping_type' => BELONGS_TO,
			'class_name' => 'Article',
			'foreign_key' => 'arcid',
			'mapping_name' => 'arc',
			'mapping_fields' => 'title',
			'as_fields' => 'title',
		),
	);

	protected $_validate = array(
		array('writer','require','昵称不能空！'),
		array('writer','checkName','昵称不能是"管理员"！',0,'callback',1), 
		array('content','require','内容不能为空！'),
		array('email','require','邮箱不能为空！'),
	);

	protected $_auto = array(
		array('ip','getIp',1,'callback'),
		array('isreply','0'),
		array('time','time',1,'function'),
		array('ischeck','0'),
	);

	//获取ip
	public function getIp(){
		$data = get_client_ip();
		return $data;
	}

	//验证昵称内容
	public function checkName($data){
		if($data == '管理员'){
			return false;
		}
		else{
			return true;
		}
	}
}
?>