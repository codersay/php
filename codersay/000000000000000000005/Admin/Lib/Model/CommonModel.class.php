<?php
class CommonModel extends RelationModel{
	    protected $_link = array(
				'Comment' => array(
				'mapping_type' => HAS_MANY,
				'class_name' => 'Comment',//要关联的模型类名
				'mapping_name' => 'Comment',//关联的映射名称，用于获取数据用
				'foreign_key' => 'nid',//关联的外键名称，这里是评论表里的nid字段对应News表的id字段
				'mapping_fields' => 'id',//关联要查询的字段，这里指评论的ID
				'as_fields' => 'id',
				)
			   
	          );
		protected $_auto=array(
		             array('status','1'),  
					 array('posid','posid',3,'callback'),
		             array('inputtime','time',1,'function'),
		             array('udatetime','time',2,'function'),
		             array('thumb','getthumb',3,'callback'),
		             array('username','getusername',1,'callback'),
			         array('ctime','ctime',1,'callback'),
	               );
		
     public function ctime(){
		$data=date("Y-m-d",time());
		return $data;
	}
	public function posid(){
		$posid=isset($_POST['posid'])?(int)$_POST['posid']:0;
		$data=$posid;
		return $data;
	}
	public function getthumb(){
		
		if($_FILES['thumb']['name'] && $_FILES['thumb']['name'] !==''){
		   $thumb=D('Attach')->upload(null,'thumb');
		  
		}else{
		    $thumb=isset($_POST['thumb'])?$_POST['thumb']:'';
		}
		 return $thumb;
		
	}
	 public function getusername(){
		$data=$_SESSION['loginUserName'];
		return $data;
	}
	
}

?>

