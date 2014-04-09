<?php

class CommentAction extends CommonAction{
	//保存评论
	public function saveComment(){
		$this->saveCF('Comment','评论',U('Article/index',array('arcid'=>$_POST['arcid'])).'#comments');
	}

	//获取评论
	public function getComment(){
		$list = $this->getCFContent('Comment');
		$this->ajaxReturn($list);
	}
}
?>