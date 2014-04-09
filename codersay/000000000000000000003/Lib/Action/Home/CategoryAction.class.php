<?php
class CategoryAction extends HomeAction {
	public function index(){
		$id = isset($_GET['cid'])?$_GET['cid']:0;
		$catename = M("Category")->field("name")->where(array("id"=>$id))->find();

		$this->Nav();
		$categorylist = $this->Category();
		$linklist = $this->Link();
		$randpostlist = $this->Random();
		$newpostlist = $this->Newpost();
		$hotpostlist = $this->Hot();
		$archiveslist = $this->Archives();
			
		import("ORG.Util.Page");
		$count = M("Post")->where(array("cid"=>$id))->count();
		$page = new page($count,5);
		$page -> setConfig('header', '条记录');//设置分页显示的样式
    	$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
		$show = $page->show2(5);
		$list = M("Post")->Table("post a")->field("a.id,a.title,a.content,a.create_time,b.name as categoryname")->join("left join category b on b.id=a.cid")->where(array("cid"=>$id))->order("create_time desc")->limit($page->firstRow.','.$page->listRows)->select();		
			
		$this->assign("categorylist",$categorylist);
		$this->assign("linklist",$linklist);
		$this->assign("randpostlist",$randpostlist);
		$this->assign("newpostlist",$newpostlist);
		$this->assign("hotpostlist",$hotpostlist);
		$this->assign("archiveslist",$archiveslist);
		$this->assign("list",$list);
		$this->assign("catename",$catename);
		$this->assign("page",$show);
		$this->display();
	}
}
?>