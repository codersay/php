<?php
class ColumnsModel extends Model{
		//分类
	function Catlist($ModelName, $ModelId) {
		
		$List= $this->field('colId,colTitle,colPid,modelid,ord,thumb,description,model')->where(array('modelid'=>$ModelId,'colPid'=>0))->order('ord desc')->select();
		foreach ($List as $k => $v) {
		$List[$k]['total'] = M($ModelName)->field('id,catid')->where(array('catid' =>$v['colId']))->count();
		}
		return $List;
		}	
	function menu(){
		return $this->field('colId,colTitle,asmenu')->where(array('asmenu'=>1))->order('ord desc')->select();
		}		
}
?>