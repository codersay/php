<?php
class LinkModel extends Model{	 
	/* ำัว้มดฝำ*/
	function Linklist() {
		$Linklist = $this->field('id,name,url')->order('id desc')->select();
		return $Linklist;
	}
}
?>