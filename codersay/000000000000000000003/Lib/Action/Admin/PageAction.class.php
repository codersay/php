<?php
class PageAction extends Action{
	public function addPage(){
		$editor = getFckEditor("content","","350");
		$this->assign("editor",$editor);
		$this->display();
	}
	
	public function addPageAction(){
		$data['name'] = $_POST['title'];
		$data['content'] = stripslashes($_POST['content']);
		$data['create_time'] = date("Y-m-d h-i-m",time());
		$id = M("Page")->data($data)->add();
		if($id>0){
			$this->assign("status","ok");
		}else{
			$this->assign("status","fail");
		}
		$this->assign("type","add");
		$this->display("Admin:Page:pagePrompt");
	}
	
	public function pageList(){
		import("ORG.Util.Page");
		$count = M("Page")->count();
		$page = new page($count,12);
		$page -> setConfig('header', '条记录');//设置分页显示的样式
    	$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
		$show = $page->show2(12);
		$this->assign("page",$show);
		
		$pageList = M("Page")->limit($page->firstRow.','.$page->listRows)->select();
		$p = C("VAR_PAGE");
		$currentpage = isset($_GET['p'])?$_GET['p']:1;
		$this->assign("currentpage",$currentpage);
		$this->assign("pageList",$pageList);
		$this->display();
	}
	
	public function editPage(){
		$id = $_GET['id'];
		$map['id'] = intval($id);
		$page = $_GET['p'];
		$pageInfo = M("Page")->where($map)->find();
		$editor = getFckEditor("content",$pageInfo['content'],"350");
		$this->assign("editor",$editor);
		$this->assign("page",$page);
		$this->assign("id",$id);
		$this->assign("pageInfo",$pageInfo);
		$this->display();
	}
	
	public function editPageAction(){
		$data['id'] = $_POST['id'];
		$data['name'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['update_time'] = date("Y-m-d H:i:s",time());
		$page = $_POST['page'];
		
		$affected = M("Page")->data($data)->save();
		if($affected !=false){
			$this->assign("status","ok");
		}else{
			$this->assign("status","fail");
		}
		$this->assign("type","edit");
		$this->assign("page",$page);
		$this->display("Admin:Page:pagePrompt");
	}
	
	public function delPage(){
		$id = $_GET['id'];
		$page = $_GET['page'];
		$map['id'] = intval($id);
		$del = M("Page")->where($map)->delete();
		if($del == false){
			echo error("删除失败！");
		}
		$this->redirect("Admin-Page/pageList?p=".$page);
	}
	
	
}
?>