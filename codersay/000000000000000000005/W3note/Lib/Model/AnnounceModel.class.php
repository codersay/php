<?php
class AnnounceModel extends Model{
     public function announce($pagesize=1){
		$Ance = $this->field('id,title,url,inputtime')->order('inputtime desc')->limit($pagesize)->find();
		return $Ance;
		
	}
}
?>