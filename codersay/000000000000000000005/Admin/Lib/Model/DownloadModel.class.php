<?php

class DownloadModel extends CommonModel{
	protected $_validate  =  array(
     array('title','require','标题不能为空！'),
	 //array('content','require','内容不能为空！'),
     //array('title','','标题名称已经存在！',0,’unique’,1), // 在新增的时候验证title字段是否唯一
	 array('title','','标题名称已经存在!',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
     
);
   protected $_auto=array(
		array('status','1'),  
		array('posid','posid',3,'callback'),
		array('inputtime','time',1,'function'),		
		array('updatetime','time',2,'function'),
		array('thumb','getthumb',3,'callback'),
		array('username','getusername',1,'callback'),
	);
	
}
?>