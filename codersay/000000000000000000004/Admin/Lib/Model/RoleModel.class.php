<?php
/**
 * @角色模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/25
 * @Copyright: www.iqishe.com
 */

class RoleModel extends Model{
	//自动验证
	protected $_validate = array(
		array('name','require','角色名不能为空！'),
		array('name','','角色名已存在!',0,'unique',1)
	);

	//获得角色列表
	public function getRoleList($selid=0){
		$condition['pid'] = 0;
		$condition['status'] = 1;
		$rlist = '';
		$list = $this->field('id,name,pid')->where($condition)->select();
		foreach($list as $key => $val){
			if($val['id'] == $selid){
				$rlist .= "<option value='".$val['id']."' selected>".$val['name']."</option>\r\n";
			}
			else{
				$rlist .= "<option value='".$val['id']."'>".$val['name']."</option>\r\n";
			}
			$sunlist = '';
			$this->getSunRoleList($val['id'],'&nbsp;&nbsp;',$sunlist,$selid);
			$rlist .= $sunlist;
		}
		return $rlist;
	}

	//获得子角色列表
	private function getSunRoleList($id,$step,&$sunlist,$selid){
		$condition['pid'] = $id;
		$condition['status'] = 1;
		$row = $this->field("id,name,pid")->where($condition)->select();
		foreach($row as $key => $val){
			if($val['colid'] == $selid){
				$sunlist .= "<option value='".$val['id']."' selected>".$step.$val['name']."</option>\r\n";
			}
			else{
				$sunlist .= "<option value='".$val['id']."'>".$step.$val['name']."</option>\r\n";
			}
			$this->getSunRoleList($val['id'],$step.'&nbsp;&nbsp;',$sunlist.$selid);
		}
	}
}
?>