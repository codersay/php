<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// $Id$

class GuestbookAction extends CommonAction{

    public function index() {
		$field="id,username,pid,inputtime,email,url,isreply,ip,content,path,concat(path,'-',id) as bpath";
		 //$where['isreply']=array('neq',1);
		$garr= D('Guestbook')->gclist($field,$where);           
		$this->assign("page", $garr['page']);
        $this->assign('guestbooklist', $garr['list']);
		$this->assign('tpl', $tpl = "index");//模板标识，用于判断是什么类型的模板以加载相应的JS和CSS
        $this->display();
    }  		   
	public function insert(){
			  $this->display(); 			
		      }
	
	
	public function answer(){ 
		$Reply = D('Guestbook');
		if($vo=$Reply->create()){
			$result=$Reply->add();
			//dump($vo);
		}
		$this->message($result);
    }
	 public function edit(){  
	    if (!isset ($_GET['id']) && empty($_GET['id'])) $this->error('该留言不存在或已删除');
		$vo = M('Guestbook')->where(array('id'=>$_GET['id']))->find();
		$this->assign('vo',$vo);
		$this->display();
    }
	public function update(){  
	    if (!isset ($_POST['id']) && empty($_POST['id'])) $this->error('该留言不存在或已删除');
        $data['username'] = $_POST['username'];
        $data['email'] = $_POST['email'];
		$data['url'] = $_POST['url'];
		$data['content'] = $_POST['content'];
        $result=M('Guestbook')->where(array('id'=>$_POST['id']))->save($data); // 根据条件保存修改的数据
        if($result)$this->success('更新成功');
    }	  			
	 public function reply(){   
		if (!empty($_GET['id'])) {
                 $vo = D('Guestbook')->where(array('id'=>$_GET['id']))->find();
				//dump($vo);
                if ($vo) {
                   $this->assign('vo', $vo);
                   $this->display();
                  } else {
                    exit('回复项不存在！');
                  }
               } else {
               exit('回复项不存在！');
              }
            
    }
	public function act(){
		$this->action();
	}
}
?>