<?php

class FeedbackAction extends CommonAction{
	public function index(){
		$this->display();
	}
	//保存留言
	public function saveFeedback(){
		$this->saveCF('Feedback','留言', U('Feedback/index'));
	}

	//获取留言
	public function getFeedback(){
		$list = $this->getCFContent('Feedback');
		$this->ajaxReturn($list);
	}
}
?>