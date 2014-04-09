<?php
	class IndexAction extends HomeAction{
		function index()
		{
			$this->Nav();
			$categorylist = $this->Category();
			$linklist = $this->Link();
			$randpostlist = $this->Random();
			$newpostlist = $this->Newpost();
			$hotpostlist = $this->Hot();
			$archiveslist = $this->Archives();
			
			import("ORG.Util.Page");
			$count = M("Post")->count();
			$page = new page($count,10);
			$page -> setConfig('header', '条记录');//设置分页显示的样式
    		$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
			$show = $page->show2(10);
			$summarylist = M("Post")->Table("post a")->field("a.id,a.title,a.content,a.create_time,b.name as categoryname")->join("left join category b on b.id=a.cid")->order("create_time desc")->limit($page->firstRow.','.$page->listRows)->select();

			$datestr = date("Y-M-d",strtotime($result['create_time']));
			$date = explode("-",$datestr);
			
			$this->assign("categorylist",$categorylist);
			$this->assign("linklist",$linklist);
			$this->assign("randpostlist",$randpostlist);
			$this->assign("newpostlist",$newpostlist);
			$this->assign("hotpostlist",$hotpostlist);
			$this->assign("archiveslist",$archiveslist);
			$this->assign("summarylist",$summarylist);
			$this->assign("page",$show);
			$this->assign("date",$date);
			$this->display();
		}
	}
?>