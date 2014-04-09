<?php
class BannerModel extends Model{
	protected $_validate  =  array(
     array('name','require','标题不能为空！'),
	  array('name','','标题名称已经存在!',self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),  
    );
	
	protected $_auto=array(		              
		             array('inputtime','time',1,'function'),		            		             
		             array('username','getusername',1,'callback'),
					  array('banner','getbanner',3,'callback'),	
	               );
	   
	 public function getusername(){
		$data=$_SESSION['loginUserName'];
		return $data;
	}
	public function getbanner(){
		
		if($_FILES['banner']['name'] && $_FILES['banner']['name'] !==''){
		   $thumb=D('Attach')->upload(null,'thumb');
		  
		}else{
		    $thumb=isset($_POST['banner'])?$_POST['banner']:'';
		}
		 return $thumb;
		
	}

	
}
?>