<?php
/**
 * @友情链接管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class LinksAction extends CommonAction{
	public function index(){
		//获取列表
		$obj = M('Links');
		$map['1'] = 1;

		//搜索
		$issel = '';
		$searchkey = '';
		if(!empty($_POST['search']) && $_POST['search'] == 'search'){
			if(!empty($_POST['linktype'])){
				$map['linktype'] = $_POST['linktype'];
				if($_POST['linktype'] == 'writing'){
					$issel = 'w';
				}
				else{
					$issel = 'l';
				}
			}
			if(!empty($_POST['keysearch'])){
				$map['linkname'] = array('like','%'.$_POST['keysearch'].'%');
				$searchkey = $_POST['keysearch'];
			}
		}
		
		$page = $this->paging($obj,$map);
		$list = $obj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('ord asc,updatetime desc')->select();
		foreach($list as $key => $val){
			if($val['linktype'] == 'writing'){
				$list[$key]['linktype'] = '文字连接';
			}
			else{
				$list[$key]['linktype'] = '图片连接';
			}
		}

		$this->assign('page', $page->show());
		$this->assign('list', $list);

		//搜索模板变量
		$this->assign('searchkey',$searchkey);
		$this->assign('issel',$issel);

		$this->display();
	}

	//增加显示
	public function add(){
		$this->display();
	}

	public function addSave(){
		$obj = M('Links');
		$form = $obj->create();
		$obj->createtime = time();
		$obj->updatetime = time();
		$return = $obj->add();
		if($return === false){
			$this->error('新增失败');
		}
		else{
			$this->success('新增成功！');
		}
	}

	//编辑显示
	public function edit(){
		$id = $_GET['id'];
		if(empty($id)){
			$this->error('链接不存在！');
		}
		$map['id'] = $id;
		$data = M('Links')->where($map)->find();
		if($data){
			$this->assign('data',$data);
		}

		$this->display();
	}

	public function update(){
		$obj = M('Links');
		$form = $obj->create();
		$obj->updatetime = time();
		if($_POST['linktype'] === 'writing'){
			$obj->logo = '';
		}
		$return = $obj->save();
		if($return === false){
			$this->error('更新失败');
		}
		else{
			$this->success('更新成功！');
		}
	}

	//链接审核
	public function check(){
		$id = $_GET['id'];
		if(empty($id)){
			$this->error('链接不存在！');
		}
		$result=D('Links')->where(array('id'=>$id))->save(array('ischeck'=>1)); 
		$this->message($result,'__GROUP__/Links/index');
	}

	//链接删除
	public function del(){
		$id = trim($_GET['id']);
		if(empty($id)){
			$this->error('链接不存在！');
		}
		$result = M('Links')->where(array('id'=>$id))->delete();
		$this->message($result,'__GROUP__/Links/index','删除成功！','删除失败！');
	}

	//更新排序
	public function updateord(){
		$idord = $_POST['idord'];
		$ord = $_POST['order'];
		$obj = D('Links');
		foreach($idord as $key => $val){
			$map['id'] = $val;//一维数组
			$data['ord'] = $ord[$key];
			$result[] = $obj->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Links/index');
	}
}
?>