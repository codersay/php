<?php
/**
 * @分类管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class ColumnsAction extends CommonAction{
	public function index(){
		$this->assign('datalist',D('Columns')->getList());
		$this->display();
	}

	//新增显示
	public function add(){
		//获取分类
		$this->assign('mlist',D('Model')->getMolList());

		$mid = $this->getMidId('Article');
		$this->assign('collist', D('Columns')->getColList($mid));

		$this->display();
	}

	//保存新增分类
	public function addsave(){
		$colobj = D('Columns');
		$form = $colobj->create();
		if(!$form){
			$this->error(($colobj->getError()));
		}
		//处理分类级别
		if($_POST['[pid'] != 0){
			$colmid = explode('-',$_POST['pid']);
			$colobj->pid = $colmid[0];
			$colobj->mid = $colmid[1];
		}
		$return = $colobj->add();
		$this->message($return,'__GROUP__/Columns/index','新增成功！','新增失败！');
	}

	//ajax处理select的onchange事件
	public function getValByAjax(){
		$mid = $_GET['mid'];
		$collist = "<option value='0' selected>作为顶级分类</option>";
		$collist .= D('Columns')->getColList($mid);
		C('DEFAULT_AJAX_RETURN','EVAL');
		$this->ajaxReturn($collist);
	}

	//编辑显示
	public function edit(){
		$colid = trim($_GET['colid']);
		if(empty($colid)){
			$this->error('编辑项不存在！');
		}
		$data = D('Columns')->where(array('colid'=>$colid))->find();
		if($data){
			//获取模型
			$this->assign('mlist',D('Model')->getMolList($data['mid']));
			//处理父分类
			if($data['pid'] == 0){
				$this->assign('collist', D('Columns')->getColList($data['mid']));
			}
			else{
				$this->assign('collist', D('Columns')->getColList($data['mid'],$data['pid']));
			}
			$this->assign('data',$data);
		}
		
		$this->display();
	}

	//更新分类
	public function update(){
		$colobj = D('Columns');
		$form = $colobj->create();
		if(!$form){
			$this->error(($colobj->getError()));
		}
		//处理分类级别
		if($_POST['[pid'] != 0){
			$colmid = explode('-',$_POST['pid']);
			$colobj->pid = $colmid[0];
			$colobj->mid = $colmid[1];
		}
		$return = $colobj->save();
		$this->message($return,'__GROUP__/Columns/index','更新成功！','更新失败！');
	}

	//添加子分类显示
	public function addsun(){
		$selid = trim($_GET['selid']);
		if(empty($selid)){
			$this->error('选中项不存在！');
		}
		$data = D('Columns')->where(array('colid'=>$selid))->find();
		if($data){
			$data['mname'] = D('Model')->getMname($data['mid']);
			$this->assign('data',$data);
		}
		$this->display();
	}

	//添加子分类保存
	public function sunsave(){
		$colobj = D('Columns');
		$form = $colobj->create();
		if(!$form){
			$this->error(($colobj->getError()));
		}

		$return = $colobj->add();
		$this->message($return,'__GROUP__/Columns/index','新增成功！','新增失败！');
	}

	//删除分类
	public function del(){
		$colid = trim($_GET['colid']);
		if(empty($colid)){
			$this->error('该项不存在！');
		}
		if(D('Columns')->sunNum($colid) != 0){
			$this->error('请先删除子分类！');
		}
		$result = D('Columns')->where(array('colid'=>$colid))->delete();
		$this->message($result,'__GROUP__/Columns/index','删除成功！','删除失败！');
	}

	//更新分类排序
	public function updateord(){
		$colordid = $_POST['colordid'];
		$ord = $_POST['ord'];
		$colobj = D('Columns');
		foreach($colordid as $key => $val){
			$map['colid'] = $val;//一维数组
			$data['ord'] = $ord[$key];
			$result[] = $colobj->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Columns/index');
	}
}
?>