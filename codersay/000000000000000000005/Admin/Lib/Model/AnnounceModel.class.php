<?php

class AnnounceModel extends Model{
	protected $_validate  =  array(
     array('title','require','标题不能为空！'),
	  array('title','','标题名称已经存在!',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),  
    );
	
	protected $_auto=array(		              
		             array('inputtime','time',1,'function'),		            		             
		             array('username','getusername',1,'callback'),
	               );
	   
	 public function getusername(){
		$data=$_SESSION['loginUserName'];
		return $data;
	}

	
}
?>