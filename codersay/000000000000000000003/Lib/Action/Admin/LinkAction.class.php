<?php
class LinkAction extends Action{
	public function addLink(){
		$this->display();
	}
	
	public function addLinkAction(){
		$data['name'] = $_POST['title'];
		$data['url'] = $_POST['url'];
		$data['display'] = isset($_POST['show'])?$_POST['show']:0;
		$data['create_time'] = date("Y-m-d H:i:s",time());
		$data['update_time'] = date("Y-m-d H:i:s",time());
		$id = M("Link")->data($data)->add();
		if($id>0){
			$this->assign("status","ok");
		}else{
			$this->assign("status","fail");
		}
		$this->assign("type","add");
		$this->display("Admin:Link:linkPrompt");
	}
	
	public function linkList(){
		import("ORG.Util.Page");
		$count = M("Link")->count();
		$page = new page($count,12);
		$page -> setConfig('header', '条记录');//设置分页显示的样式
    	$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
		$show = $page->show2(12);
		$this->assign("page",$show);
		
		$linkList = M("Link")->limit($page->firstRow.','.$page->listRows)->order("create_time desc")->select();
		foreach ($linkList as $key => $value){
			$linkList[$key]['create_time'] = date("Y-m-d",strtotime($value['create_time']));
			$linkList[$key]['update_time'] = date("Y-m-d",strtotime($value['update_time']));
		}
		$p = C("VAR_PAGE");
		$currentpage = isset($_GET['p'])?$_GET['p']:1;
		$this->assign("linkList",$linkList);
		$this->assign("currentpage",$currentpage);
		$this->display();
	}
	
	public function editLink(){
		$id = $_GET['id'];
		$page = $_GET['p'];
		$map['id'] = intval($id);
		
		$linkInfo = M("Link")->where($map)->find();
		$this->assign("linkInfo",$linkInfo);
		$this->assign("id",$id);
		$this->assign("page",$page);
		$this->display();
	}
	
	public function editLinkAction(){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['title'];
		$data['url'] = $_POST['url'];
		$data['display'] = isset($_POST['show'])?1:0;
		$data['update_time'] = date("Y-m-d H:i:s",time());
		$page = $_POST['page'];
		
		$affected = M("Link")->data($data)->save();
		if(false !== $affected){
			$this->assign("status","ok");
		}else{
			$this->assign("status","fail");
		}
		$this->assign("type","edit");
		$this->assign("page",$page);
		$this->display("Admin:Link:linkPrompt");
	}
	
	public function delLink(){
		$map['id'] = intval($_GET['id']);
		$page = $_GET['page'];
		$del = M("Link")->where($map)->delete();
		if($del<0){
			echo error("参数错误，不存在该条数据！");
		}
		$this->redirect("Admin-Link/linkList?p=".$page);
	}
}
?>