<?php
class LinkModel extends Model{
	protected $_auto=array(		             
		             array('inputtime','time',1,'function'),	
					 array('logo','getlogo',3,'callback'),	       
		             
	               );
   public function getlogo(){
		
		if($_FILES['logo']['name'] && $_FILES['logo']['name'] !==''){
		   $thumb=D('Attach')->upload(null,'thumb');
		  
		}else{
		    $thumb=isset($_POST['logo'])?$_POST['logo']:'';
		}
		 return $thumb;
		
	}
}
?>