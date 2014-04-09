<?php
class GuestbookModel extends BcModel{	 
        protected $_auto=array(
		    array('isreply','1'),  
		    array ('inputtime','time',1,'function'),
			array('path','path',3,'callback'),	
			array('username','getusername',3,'callback'),
			);	
}
?>