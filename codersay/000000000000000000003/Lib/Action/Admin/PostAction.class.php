<?php
 class PostAction extends Action{
		
		public function addPostCtg(){
			$this->display();
		}
		
		public function addPostCtgAction(){
			//获取添加表单数据
			$data['name'] = $_POST['title'];
			$data['orderid'] = $_POST['orderId'];
			
			$id = M("Category")->data($data)->add();
			if($id>0){
				$this->assign("status","ok");
			}else{
				$this->assign("status","fail");
			}
			
			$this->assign("type","add");//指定操作类型，一遍操作完成后给出必要的提示信息
			$this->display("Admin:Post:postCtgPrompt");
		}
		
		public function postCtgList(){
			$postCtg = M("Category");
			import("ORG.Util.Page");//导入分页类
			$count = $postCtg->count();//查询记录总数
			$page = new page($count,12);//实例化分页类
			$page -> setConfig('header', '条记录');//设置分页显示的样式
    		$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
			$show = $page->show2(12);//分页显示输出
			$this->assign("page",$show);//赋值分页输出
			
			//每页显示的数据
			$list = $postCtg->limit($page->firstRow.','.$page->listRows)->select();
			$p = C('VAR_PAGE');//获取当前页的页数
			$currentPage = isset($_GET[$p])?$_GET[$p]:1;
			$this->assign("list",$list);
			$this->assign("currentPage",$currentPage);
			
			$this->display();//显示模板
		}
		
		public function editPostCtg(){
			$id = $_GET['id'];
			$page = $_GET['p'];
			
			$map['id'] = intval($id);
			$postCgtInfo = M("Category")->where($map)->find();
			if($postCgtInfo==false){
				echo error("参数错误，该分类不存在！");
			}
			
			$this->assign("postCgtInfo",$postCgtInfo);
			$this->assign("page",$page);
			$this->display();
		}
		
		public function editPostCtgAction(){
			//接收表单数据.注意：在做插入操作的时候必须要有主键id,否则不能执行插入成功
			$data['id'] = $_POST['id'];
			$data['name'] = $_POST['title'];
			$data['orderid'] = $_POST['orderid'];
			$page = $_POST['page'];//这里保存当前页的目的是，当修改成功后可以直接回到修改的那个分页。
			
			$affected = M("Category")->data($data)->save();
			if($affected !=false){
				$this->assign("status","ok");
			}else{
				$this->assign("status","fail");
			}
			
			$this->assign("type","edit");
			$this->assign("page",$page);
			$this->display("Admin:Post:postCtgPrompt");
		}
		
		public function delPostCtg(){
			$map['id'] = intval($_GET['id']);//获取当条数据的id和当前页的页数
			$page = $_GET['p'];
			$sub['cid'] = $map['id'];
			$count = M("Post")->where($sub)->count();
			if($count>0){
				echo error("该分类下面有文章，不能删除！");
			}
			$status = M("Category")->where($map)->delete();
			$this->redirect("Admin-Post/postCtgList?p=".$page);
		}
		
		public function addPost(){
			$editor = getFckEditor("content","","290");
			$postCtglist = M("Category")->select();
			$this->assign("editor",$editor);
			$this->assign("postCtglist",$postCtglist);
			$this->display();
		}
		
		public function addPostAction(){
			$data['cid'] = $_POST['ctg'];
			$data['title'] = $_POST['title'];
			$data['content'] = stripslashes($_POST['content']);
			$data['show_top'] = isset($_POST['showtop'])?$_POST['showtop']:0;
			$data['create_time'] = date("Y-m-d H:i:s",time());
			$data['update_time'] = date("Y-m-d H:i:s",time());
			
			$id = M("Post")->data($data)->add();
			if($id>0){
				$this->assign("status","ok");
			}else{
				$this->assign("status","fail");
			}
			$this->assign("type","add");
			$this->display("Admin:Post:postPrompt");
			
		}
		
		public function postList(){
			$postList = M("Post");
			import("ORG.Util.Page");//导入分页类
			$count = $postList->count();//查询记录总数
			$page = new page($count,12);//实例化分页类
			$page -> setConfig('header', '条记录');//设置分页显示的样式
    		$page -> setConfig('theme', "共 %totalPage% 页/%totalRow%%header% %first% %upPage% %linkPage% %downPage% %end%");
			$show = $page->show2(12);//分页显示输出
			$this->assign("page",$show);//赋值分页输出
			
			$postList = M("Post");
			$list = $postList->Table("post a")->field("a.id, a.title, a.create_time, a.update_time, a.show_top, a.hits, a.cid, b.name as ctgName")->join("left join category b on a.cid=b.id")->order("create_time desc")->limit($page -> firstRow.','.$page -> listRows) -> select();//查询数据
			$postCtg = M("Category");
			foreach ($list as $key => $value){
				$list[$key]['show_top'] = ($value['show_top'] == '1') ? '是' : '否';
				$list[$key]['create_time'] = date("Y-m-d",strtotime($value['create_time']));
				$list[$key]['update_time'] = date("Y-m-d",strtotime($value['update_time']));
			}
		
			$p = C("VAR_PAGE");
			$currentpage = isset($_GET['p'])?$_GET['p']:1;
			$this->assign("currentpage",$currentpage);
			$this->assign("postList",$list);
			$this->display();
		}
		
		public function editPost(){
			$map['id'] = intval($_GET['id']);
			$page = $_GET['p'];
			$postInfo = M("Post")->where($map)->find();
			if(false === $postCtg){
				echo error("参数错误，不存在该贴!");
			}
			$editor = getFckEditor("content",$postInfo['content'],"290");
			
			$postCtg = M("Category")->select();
			$this->assign("postInfo",$postInfo);
			$this->assign("postCtg",$postCtg);
			$this->assign("editor",$editor);
			$this->assign("page",$page);
			$this->display();
		}
		
		public function editPostAction(){
			$data['id'] = $_POST['id'];
			$data['cid'] = $_POST['ctg'];
			$data['title'] = $_POST['title'];
			$data['content'] = $_POST['content'];
			$data['show_top'] = isset($_POST['showtop'])?$_POST['showtop']:0;
			$data['update_time'] = date("Y-m-d H:i:s",time());
			$page = $_POST['page'];
			$affected = M("Post")->data($data)->save();
			if($affected > 0){
				$this->assign("status","ok");
			}else{
				$this->assign("status","fail");
			}
			$this->assign("type","edit");
			$this->assign("page",$page);
			$this->display("Admin:Post:postPrompt");
		}
		
		public function delPost(){
			$map['id'] = $_GET['id'];
			$page = $_GET['p'];
			$del = M("Post")->where($map)->delete();
			if($del<0){
				echo "参数错误，不存在该贴!";
			}
			$this->redirect("Admin-Post/postList?p=".$page);
		}
	}
?>