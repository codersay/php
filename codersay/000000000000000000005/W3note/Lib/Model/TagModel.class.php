<?php
class TagModel extends Model{	 
	function TagList($ModuleName,$pagesize=20) {
		$Tagslist = $this->field('id,name,count')->where(array (
			'module' => $ModuleName
		))->order('count desc')->limit($pagesize)->select();
		return $Tagslist;
		
	}
}
?>