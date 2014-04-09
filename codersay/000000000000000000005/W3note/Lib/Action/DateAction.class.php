<?php
// 首页
class DateAction extends CommonAction {
    public function index(){
		$listarr=$this->listinfo('News',$where['ctime'] = array (
				'like',
				$_GET['t']. '%'
			));
		$this->lists();    
		$this->assign('title', $title='文章归档');   
		$this->assign('info', $listarr['info']);
		$this->assign('page', $listarr['page']);
		
       $this->display();
    }
	 public function lists(){
		$this->assign('ance', D('Announce')->announce());
		$this->assign('newslist', D('Blog')->newsinfo());
		 
    }
	
}
?>