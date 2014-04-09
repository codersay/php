<?php
class BookModel extends BcModel{
		protected $_auto=array(
		    array ('inputtime','time',1,'function'),
			array('path','path',3,'callback'),	
			);
		
}
?>