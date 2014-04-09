<?php
/**
 * @角色管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class RoleAction extends CommonAction{
	public function index(){
		$roleobj = M('Role');
		$map['1'] = 1;
		$page = $this->paging($roleobj,$map);
		$list = $roleobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('id desc')->select();
		foreach($list as $key => $val){
			//获取用户数量
			$list[$key]['usernum'] = M('RoleUser')->where(array('role_id'=>$val['id']))->count();
		}
		
		$this->assign('page', $page->show());
		$this->assign('list', $list);
		$this->display();
	}

	//增加角色显示
	public function add(){
		$this->display();
	}

	//保存新增角色
	public function addsave(){
		$roleobj = D('Role');
		$form = $roleobj->create();
		if(!$form){
			$this->error(($roleobj->getError()));
		}
		$return = $roleobj->add();
		$this->message($return,'__GROUP__/Role/index','新增成功，请先进行授权！','新增失败！');
	}

	//编辑显示
	public function edit(){
		$rid = $_GET['rid'];
		if(empty($rid)){
			$this->error('编辑项不存在！');
		}
		$map['id'] = $rid;
		$data = D('Role')->where($map)->find();
		$this->assign('data',$data);
		$this->display();
	}

	//更新
	public function update(){
		$roleobj = D('Role');
		$form = $roleobj->create();
		if(!$form){
			$this->error(($roleobj->getError()));
		}
		$return = $roleobj->save();
		$this->message($return,'__GROUP__/Role/index','更新成功！','更新失败！');
	}

	//删除
	public function del(){
		$rid = $_GET['rid'];

		$result1 = M('Role')->where(array('id'=>$rid))->delete();
		$result2 = M('RoleUser')->where(array('role_id'=>$rid))->delete();
		if($result1===false && $result2===false){
			$result = false;
		}
		else{
			$result = true;
		}
		$this->message($result,'__GROUP__/Role/index','删除成功！','删除失败！');
	}

	//权限设定项目
	public function project(){
		$rid = $_GET['rid'];
		$list = M('Node')->where(array('pid'=>0,'status'=>1))->select();
		$this->assign('nodelist',$this->getNodeList($list,$rid));
		$this->assign('rolelist', D('Role')->getRoleList($rid));
		$this->assign('rid',$rid);
		$this->display();
	}

	//设置项目访问权限
	public function setProject(){
		$tabs = $_POST['tables'];
		$rid = $_POST['userrole'];
		$tabstr = implode(',',$tabs);

		//清空访问权限
		M('Access')->where(array('role_id'=>$rid,'pid'=>0,'level'=>1))->delete();

		//重新增加访问权限
		$result = $this->addAccess($tabstr,$rid);

		//$this->message($result,'__GROUP__/Role/project/rid/'.$rid,'授权成功！','授权失败！');
		if($result === false){
			$this->error('授权失败！');
		}
		else{
			$this->success('授权成功！');
		}
	}

	//权限设定模块
	public function module(){
		$rid = $_GET['rid'];
		$selpro = '';
		if(!empty($_GET['nid'])){
			$list = M('Node')->where(array('pid'=>$_GET['nid']))->select();
			$this->assign('nodelist',$this->getNodeList($list,$rid));
			$selpro = $_GET['nid'];
		}
		$this->assign('rolelist', D('Role')->getRoleList($rid));
		$this->assign('projectlist',$this->getSelList(0,$selpro));
		$this->assign('rid',$rid);
		$this->display();
	}

	//设置模块访问权限
	public function setModule(){
		$tabs = $_POST['tables'];
		$rid = $_POST['userrole'];
		$pid = $_POST['project'];
		$tabstr = implode(',',$tabs);
		//清空访问权限
		M('Access')->where(array('role_id'=>$rid,'pid'=>$pid,'level'=>2))->delete();

		//重新增加访问权限
		$result = $this->addAccess($tabstr,$rid);

		//$this->message($result,'__GROUP__/Role/index','授权成功！','授权失败！');
		if($result === false){
			$this->error('授权失败！');
		}
		else{
			$this->success('授权成功！');
		}
	}

	//权限设定操作
	public function operating(){
		$rid = $_GET['rid'];
		$nid = -1;
		$selpro = '';
		if(!empty($_GET['nid'])){
			$nid = $_GET['nid'];
			$this->assign('nid',$nid);
			$selpro = $nid;
		}
		$selmod = '';
		if(!empty($_GET['mid'])){
			$list = M('Node')->where(array('pid'=>$_GET['mid']))->select();
			$this->assign('nodelist',$this->getNodeList($list,$rid));
			$selmod = $_GET['mid'];
		}
		$this->assign('rolelist', D('Role')->getRoleList($rid));
		$this->assign('projectlist',$this->getSelList(0,$selpro));
		$this->assign('modulelist',$this->getSelList($nid,$selmod));
		$this->assign('rid',$rid);
		$this->display();
	}

	//设置操作访问权限
	public function setOpt(){
		$tabs = $_POST['tables'];
		$rid = $_POST['userrole'];
		$pid = $_POST['module'];
		//$mod = $_POST['module'];
		$tabstr = implode(',',$tabs);
		//清空访问权限
		M('Access')->where(array('role_id'=>$rid,'pid'=>$pid,'level'=>3))->delete();

		//重新增加访问权限
		$result = $this->addAccess($tabstr,$rid);

		//$this->message($result,'__GROUP__/Role/index','授权成功！','授权失败！');
		if($result === false){
			$this->error('授权失败！');
		}
		else{
			$this->success('授权成功！');
		}
	}

	//获取权限设定列表
	private function getNodeList($list,$rid){
		$num = count($list);
		if($num == 0){
			return "<tr align='center'  bgcolor='#FFFFFF' height='24'><td></td><td></td><td></td><td></td><td></td><td></td></tr>";
		}
		$rlist = '';
		for($i=0;$i<$num;$i++){
			$rlist .= "<tr align='center'  bgcolor='#FFFFFF' height='24'>";
			$rlist .= "<td><input type='checkbox' name='tables[]' value='".$list[$i]['id']."' class='np' ";
			//处理选中项
			$checked1 = M('Access')->where(array('role_id'=>$rid,'node_id'=>$list[$i]['id']))->find();
			if($checked1){
				$rlist .= "checked";
			}
			$rlist .= "/></td>";
			$rlist .= "<td>".$list[$i]["title"]."</td>";

			$i++;
			if(is_array($list[$i])){
				$rlist .= "<td><input type='checkbox' name='tables[]' value='".$list[$i]['id']."' class='np' ";
				//处理选中项
				$checked2 = M('Access')->where(array('role_id'=>$rid,'node_id'=>$list[$i]['id']))->find();
				if($checked2){
					$rlist .= "checked";
				}
				$rlist .= "/></td>";
				$rlist .= "<td>".$list[$i]["title"]."</td>";
			}
			else{
				$rlist .= '<td></td><td></td>';
			}

			$i++;
			if(is_array($list[$i])){
				$rlist .= "<td><input type='checkbox' name='tables[]' value='".$list[$i]['id']."' class='np' ";
				//处理选中项
				$checked2 = M('Access')->where(array('role_id'=>$rid,'node_id'=>$list[$i]['id']))->find();
				if($checked2){
					$rlist .= "checked";
				}
				$rlist .= "/></td>";
				$rlist .= "<td>".$list[$i]["title"]."</td>";
			}
			else{
				$rlist .= '<td></td><td></td>';
			}

			$rlist .= '</tr>';
		}
		return $rlist;
	}

	//获得select列表
	private function getSelList($pid,$selid=''){
		if($pid == -1){
			return '';
		}
		$condition['pid'] = $pid;
		$condition['status'] = 1;
		$rlist = '';
		$list = M('Node')->where($condition)->select();
		foreach($list as $key => $val){
			if($val['id'] == $selid){
				$rlist .= "<option value='".$val['id']."' selected>".$val['title']."</option>\r\n";
			}
			else{
				$rlist .= "<option value='".$val['id']."'>".$val['title']."</option>\r\n";
			}
		}
		return $rlist;
	}

	//设置访问权限公共部分
	private function addAccess($liststr,$rid){
		if(!$this->isCheckBox($liststr)){
			$id = -1;
		}
		else{
			$id = $liststr;
		}
		$prefix = C('DB_PREFIX');
		$where = 'a.id ='.$rid.' AND b.id in('.$id.')';
		$result = M('Access')->execute('INSERT INTO '.$prefix.'access (role_id,node_id,pid,level) SELECT a.id, b.id,b.pid,b.level FROM '.$prefix.'role a, '.$prefix.'node b WHERE '.$where);
		if($result===false) {
			return false;
		}else {
			return true;
		}
	}

	//添加必要的角色权限
	/*private function addMustAccess(){
		$prefix = C('DB_PREFIX');
	}*/
}
?>