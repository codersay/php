<?php
class IndexAction extends CommonAction {
    public function index(){
		$listarr=$this->listinfo('News');
		$this->assign('ance', D('Announce')->announce());
		$this->assign('newslist', D('Blog')->newsinfo());
		$this->assign('Newsnum', D('News')->Artnums());
		$this->assign('Gknum', D('Guestbook')->Gknum());
		$this->assign('Cmnum', D('Comment')->Cmnum());
		$this->assign('Visitnum', $this->visitNum('count.txt'));
		$this->assign('title', $title='index');
		$this->assign('info', $listarr['info']);
		$this->assign('page', $listarr['page']);
        $this->display();
    }
}