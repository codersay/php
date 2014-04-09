<?php
class PageAction extends HomeAction {
	public function Content(){
		$this->Nav();
		$categorylist = $this->Category();
		$linklist = $this->Link();
		$randpostlist = $this->Random();
		$newpostlist = $this->Newpost();
		$hotpostlist = $this->Hot();
		$archiveslist = $this->Archives();
			
		$this->assign("categorylist",$categorylist);
		$this->assign("linklist",$linklist);
		$this->assign("randpostlist",$randpostlist);
		$this->assign("newpostlist",$newpostlist);
		$this->assign("hotpostlist",$hotpostlist);
		$this->assign("archiveslist",$archiveslist);
		
		$id = isset($_GET['id'])?$_GET['id']:0;
		$info = M("Page")->where(array("id"=>$id))->find();
		if(false === $info){
			echo error("参数错误，该贴不存在!");
		}
		$this->assign('info',$info);
		$this->display();
	}
}
?>