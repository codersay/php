<?php
/**
 * @模型管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/11
 * @Copyright: www.iqishe.com
 */

class ModelAction extends CommonAction{
	public function index(){
		$mobj = D('Model');
		$map['1'] = 1;
		$page = $this->paging($mobj,$map);
		$list = $mobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('mid asc')->select();
		$this->assign('page', $page->show());
		$this->assign('list', $list);
		$this->display();
	}

	//启用与禁用
	public function updown(){
		$isup = $_GET['isup'];
		$mid = $_GET['mid'];
		$map['mid'] = $mid;
		if($isup == 1){
			$data['status'] = 1;
			$result = D('Model')->where($map)->save($data);
		}
		else{
			$data['status'] = 0;
			$result = D('Model')->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Model/index');
	}
}
?>