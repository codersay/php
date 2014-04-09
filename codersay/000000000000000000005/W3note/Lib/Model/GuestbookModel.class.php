<?php
class GuestbookModel extends BcModel{	 
	    protected $_validate  = array(
			    array('email','require','请填写您的邮箱!'),
                array('email','email','邮箱格式错误！'), 
				
               );
         
		protected $_auto=array(
		             array('status','1'),  
		             array('content','content',1,'callback'),
					 array('url','geturl',1,'callback'),				
		             array ('inputtime','time',1,'function'),
			         array('path','path',3,'callback'),	
					 array('username','getusername',3,'callback'),				       
	               );
				
		/* 留言总数*/
	function Gknum() {
		return $this->field('id')->count();
	}
	
}
?>