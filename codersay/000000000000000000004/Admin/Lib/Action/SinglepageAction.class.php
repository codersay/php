<?php
/**
 * @单页管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class SinglepageAction extends CommonAction{
	public function index(){
		$sgobj = D('Singlepage');
		$map['1'] = 1;
		$page = $this->paging($sgobj,$map);
		$list = $sgobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('sgid DESC')->select();
		$this->assign('page', $page->show());
		$this->assign('list', $list);
		$this->display();
	}

	//新增单页显示
	public function add(){
		$this->display();
	}

	//新增
	public function addsave(){
		$sgobj = D('Singlepage');
		$form = $sgobj->create();
		if(!$form){
			$this->error(($sgobj->getError()));
		}
		
		//发布人
		$sgobj->username = $_SESSION['loginUserName'];
		$return = $sgobj->add();
		$this->message($return,'__GROUP__/Singlepage/index','新增成功！','新增失败！');
	}

	//编辑显示
	public function edit(){
		$sgid = trim($_GET['sgid']);
		if(empty($sgid)){
			$this->error('编辑项不存在！');
		}
		$map['sgid'] = $sgid;
		$data = D('Singlepage')->where($map)->find();
		$this->assign('data',$data);
		$this->display();
	}

	//更新
	public function update(){
		$sgobj = D('Singlepage');
		$form = $sgobj->create();
		if(!$form){
			$this->error(($sgobj->getError()));
		}
		$return = $sgobj->save();
		$this->message($return,'__GROUP__/Singlepage/index','更新成功！','更新失败！');
	}

	//删除
	public function del(){
		$sgid = trim($_GET['sgid']);
		if(empty($sgid)){
			$this->error('该项不存在！');
		}
		$result = D('Singlepage')->where(array('sgid'=>$sgid))->delete();
		$this->message($result,'__GROUP__/Singlepage/index','删除成功！','删除失败！');
	}
}
?>