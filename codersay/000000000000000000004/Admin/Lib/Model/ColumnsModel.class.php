<?php
/**
 * @分类模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/22
 * @Copyright: www.iqishe.com
 */

class ColumnsModel extends Model{
	protected $_validate = array(
		array('mid','checkMol','请选择模型！',1,callback),
		array('colname','require','分类名称不能为空！')
	);

	public function checkMol($data){
		if($data == 0){
			return false;
		}
		else{
			return true;
		}
	}
	//获取select分类列表
	public function getColList($mid,$selid=0){
		if($mid != 0){
			$condition['mid'] = $mid;
		}
		$condition['pid'] = 0;
		$rlist = '';
		
		/*if($selid > 0){
			$sellist = $this->field("colid,mid,colname,pid")->where(array('colid'=>$selid))->find();
			$rlist .= "<option value='".$sellist['colid'].'-'.$sellist['mid']."' selected='selected'>".$sellist['colname']."</option>\r\n";
		}*/

		$list = $this->field("colid,mid,colname,pid")->where($condition)->select();
		foreach($list as $key => $val){
			if($val['colid'] == $selid){
				$rlist .= "<option value='".$val['colid'].'-'.$val['mid']."' selected>".$val['colname']."</option>\r\n";
			}
			else{
				$rlist .= "<option value='".$val['colid'].'-'.$val['mid']."'>".$val['colname']."</option>\r\n";
			}
			$sunlist = '';
			$this->getSunColList($val['colid'],$val['mid'],'&nbsp;&nbsp;',$sunlist,$selid);
			$rlist .= $sunlist;
		}
		return $rlist;
	}

	//获取select子分类列表
	private function getSunColList($colid,$mid,$step,&$sunlist,$selid){
		$condition['mid'] = $mid;
		$condition['pid'] = $colid;
		$row = $this->field("colid,mid,colname,pid")->where($condition)->select();
		foreach($row as $key => $val){
			if($val['colid'] == $selid){
				$sunlist .= "<option value='".$val['colid'].'-'.$val['mid']."' selected>".$step.$val['colname']."</option>\r\n";
			}
			else{
				$sunlist .= "<option value='".$val['colid'].'-'.$val['mid']."'>".$step.$val['colname']."</option>\r\n";
			}
			$this->getSunColList($val['colid'],$val['mid'],$step.'&nbsp;&nbsp;',$sunlist,$selid);
		}
	}

	//根据colid获取分类名
	public function getColName($colid){
		$map['colid'] = $colid;
		$result = $this->field("colname")->where($map)->find();
		return $result['colname'];
	}

	//获得分类管理列表
	public function getList(){
		$list = $this->where(array('pid'=>0))->order('ord ASC,colid ASC')->select();
		$rlist = '';
		foreach($list as $key => $val){
			$rlist .= "<table width='100%' border='0' cellspacing='0' cellpadding='2'>";
			$rlist .= "<tr onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">";
			$rlist .= "<td class='bline' style='background-color:#FBFCE2;'><table width='98%' cellspacing='0' cellpadding='0' border='0'><tr><td width='50%'>";
			$rlist .= $val['colid'].'.'.$val['colname'].' 【子分类：'.$this->sunNum($val['colid']);
			if($this->sunNum($val['colid']) != 0){
				$rlist .= " <a href='javascript:void(0);' target='_self' id='pid".$val['colid']."' onclick=\"showHide('sun".$val['colid']."','pid".$val['colid']."');\" style='color:red'>展开</a>";
			}
			$rlist .= " / 文档：".D('Article')->getArcNumByColid($val['colid']);
			if(D('Article')->getArcNumByColid($val['colid']) != 0){
				$rlist .= " <a href='__GROUP__/Article/index/colid/".$val['colid']."' style='color:red'>查看</a>";
			}
			$rlist .= " / 模型：".D('Model')->getMname($val['mid'])."】";
			if($val['isshow'] == 0){
				$rlist .= "<img  src='__PUBLIC__/admin/images/yincang.gif' />";
			}
			$rlist .= '</td>';
			$rlist .= "<td align='right'><a href='__URL__/edit/colid/".$val['colid']."'>编辑</a>|<a href='__URL__/addsun/selid/".$val['colid']."'>添加子分类</a>";
			//if($this->sunNum($val['colid']) == 0){
			$rlist .= "|<a href='__URL__/del/colid/".$val['colid']."'>删除</a>";
			//}
			$rlist .= "&nbsp; <input type='text' style='width:25px;height:20px' value='".$val['ord']."' name='ord[]'/>";
			$rlist .= "<input type='hidden' name='colordid[]' value='".$val['colid']."'/>";
			$rlist .= "</td></tr></table></td></tr>";
			$rlist .= "<tr><td colspan='2'>";
			$rlist .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='display:none' id='sun".$val['colid']."'>";
			$rlist .= $this->getSunList($val['colid'],"&nbsp;&nbsp;");
			$rlist .= "</table>";
			$rlist .= "</td></tr></table>";
		}
		return $rlist;
	}

	//获得分类管理子列表
	private function getSunList($colid,$step){
		$row = $this->where(array('pid'=>$colid))->order('ord ASC,colid ASC')->select();
		$sunlist = '';
		
		foreach($row as $key => $val){
			$sunlist .= "<tr height='24' onMouseMove=\"javascript:this.bgColor='#FCFDEE';\" onMouseOut=\"javascript:this.bgColor='#FFFFFF';\">";
			$sunlist .= "<td class='nbline'>";
			$sunlist .= "<table width='98%' border='0' cellspacing='0' cellpadding='0'>";
			$sunlist .= "<tr><td width='50%'>";
			$sunlist .= $step.$val['colid'].'.'.$val['colname'].' 【子分类：'.$this->sunNum($val['colid']);
			if($this->sunNum($val['colid']) != 0){
				$sunlist .= " <a href='javascript:void(0);' target='_self' id='pid".$val['colid']."'onclick=\"showHide('sun".$val['colid']."','pid".$val['colid']."')\" style='color:red'>展开</a>";
			}
			$sunlist .= " / 文档：".D('Article')->getArcNumByColid($val['colid']);
			if(D('Article')->getArcNumByColid($val['colid']) != 0){
				$sunlist .= " <a href='__GROUP__/Article/index/colid/".$val['colid']."' style='color:red'>查看</a>";
			}
			$sunlist .= " / 模型：".D('Model')->getMname($val['mid'])."】";
			if($val['isshow'] == 0){
				$sunlist .= "<img  src='__PUBLIC__/admin/images/yincang.gif' />";
			}
			$sunlist .= '</td>';
			$sunlist .= "<td align='right'><a href='__URL__/edit/colid/".$val['colid']."'>编辑</a>|<a href='__URL__/addsun/selid/".$val['colid']."'>添加子分类</a>";
			//if($this->sunNum($val['colid']) == 0 ){
			$sunlist .= "|<a href='__URL__/del/colid/".$val['colid']."'>删除</a>";
			//}
			$sunlist .= "&nbsp; <input type='text' style='width:25px;height:20px' value='".$val['ord']."' name='ord[]'/>";
			$sunlist .= "<input type='hidden' name='colordid[]' value='".$val['colid']."'/>";
			$sunlist .= "</td></tr></table></td></tr>";
			$sunlist .= "<tr><td>";
			$sunlist .= "<table width='100%' border='0' cellspacing='0' cellpadding='0' style='display:none' id='sun".$val['colid']."'>";
			$sunlist .= $this->getSunList($val['colid'],$step."&nbsp;&nbsp;");
			$sunlist .= "</table></td></tr>";
		}
		return $sunlist;
	}

	//子分类数量
	public function sunNum($colid){
		$num = $this->where(array('pid'=>$colid))->count();
		return $num;
	}
}
?>