<?php

class PageModel extends RelationModel{
	protected $_validate  =  array(
     array('title','require','标题不能为空！'),
	 array('content','require','内容不能为空！'),
     //array('title','','标题名称已经存在！',0,’unique’,1), // 在新增的时候验证title字段是否唯一
	 //array('title','','标题名称已经存在!',self::EXISTS_VAILIDATE,'unique',self::MODEL_INSERT),
     
    );
	/*protected $_link = array(
       'Attach'=>array(
           'mapping_type'=>HAS_MANY,
           'class_name'=>'Attach',
           'foreign_key'=>'recordId',//与上面的外键不同？
           'mapping_fields'=>'downCount,name,recordId',
       ),
    );*/
	
	protected $_auto=array(
		             array('status','1'),  
		             array('inputtime','time',1,'function'),
		             array('udatetime','time',2,'function'),
		             array('username','getusername',3,'callback'),
	               );
		
    
	 public function getusername(){
		$data=$_SESSION['loginUserName'];
		$data=isset($data)?$data:" ";
		return $data;
	}

	
}
?>