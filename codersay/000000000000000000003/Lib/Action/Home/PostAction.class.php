<?php
	class PostAction extends HomeAction {
		public function index(){
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
			$postinfo = M("Post")->field("title,content,create_time,hits,cid")->where(array("id"=>$id))->find();
			if(false === $postinfo){
				$this->error("参数错误，该贴不存在！");
			}
			$datestr = date("Y-F-d",strtotime($postinfo['create_time']));
			$date = explode("-",$datestr);
			M("Post")->setInc("hits","id=$id");
			$cateinfo = M("Category")->field("id,name,orderid")->where(array("id"=>$postinfo['cid']))->find();
			$this->assign("postinfo",$postinfo);
			$this->assign("cateinfo",$cateinfo);
			$this->assign("date",$date);
			$this->display();
		}
		
		public function sendMsg(){
			$data['pid'] = $_POST['id'];
			$data['author'] = $_POST['author'];
			$data['authoremail'] = $_POST['email'];
			$data['authorurl'] = $_POST['url'];
			$data['authorip'] = "127.0.0.1";
			$data['content'] = $_POST['content'];
			$data['create_time'] = date("Y-m-d H:i:s",time());
			$data['parent'] = 0;
			$data['checked'] = 0;
			
			$status = M("Comment")->data($data)->add();
//			if( $status ) {
//			echo "<script>parent.success();</script>"; exit;
//			}else {
//			echo "<script>parent.fail();</script>"; exit;
//			}
			$this->redirect("index");
		}
	
	}
?>