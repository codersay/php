<?php

class HomeAction extends Action{
	function Nav(){
		$page = M("Page");
		$pagelist = $page->field("id,name")->select();
		$this->assign("pagelist",$pagelist);
	}
	
	function Category(){
		$category = M("Category");
		$categorylist = $category->field("id,name")->select();
		return $categorylist;
	}
	
	function Link(){
		$link = M("Link");
		$linklist = $link->where(array("display"=>"1"))->select();
		return $linklist;
	}
	
	function Random(){
		$post = M("Post");
		$randlist = $post->order("rand()")->limit(12)->select();
		return $randlist;
	}
	
	function Newpost(){
		$newpost = M("Post");
		$newlist = $newpost->order("create_time desc")->limit(8)->select();
		return $newlist;
	}
	
	function Hot(){
		$hot = M("Post");
		$hotlist = $hot->order("hits desc")->limit(9)->select();
		return $hotlist;
	}
	
	function Archives(){
		$archives = M("Post");
		$archiveslist = $archives->group("cid")->select();
		return $archiveslist;
	}
	

	function Page($class,$num,$where,$order){
		import("ORG.Util.Page");
		$count = M("$class")->where($where)->count();
		$page = new page($count,$num);
		$page -> setConfig('header', '条记录');//设置分页显示的样式
    	$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
		$show = $page->show2($num);
		$class = M("$class");
		if(null === $where){
		$list = $class->order($order)->limit($page->firstRow.','.$page->listRows)->select();
		}
		$list = $class->where($where)->order($order)->limit($page->firstRow.','.$page->listRows)->select();
		$result[0] = $list;
		$result[1] = $show;
		return $result;
	}
}
?>