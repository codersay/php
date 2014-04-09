<?php

class ColumnsModel extends Model{
	//获取子分类
	public function getSubMenu($colid){
		$num = $this->haveSubmenu($colid);
		if($num){
			$where['pid'] = $colid;
			$where['isshow'] = 1;
			$list = $this->field('colid,colname')->where($where)->order('ord asc')->select();
			if(!($list)){
				return '';
			}
			$submenu = "<ul class='sub-menu'>";
			foreach ($list as $k => $v){
				$submenu .= "<li><a href='".U('Index/columns',array('colid'=>$v['colid']))."' >".$v['colname']."</a>";
				$submenu .= $this->getSubMenu($v['colid']);
				$submenu .= "</li>";
			}
			$submenu .= '</ul>';
			return $submenu;
		}
		else{
			return '';
		}
	}

	//判断是否有子分类
	private function haveSubMenu($colid){
		$where['pid'] = $colid;
		$num = $this->where($where)->count();
		if($num){
			return $num;
		}
		else{
			return false;
		}
	}
}
?>