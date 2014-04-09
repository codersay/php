<?php
//2012.5.21
class EmptyAction extends Action{
	public function index(){
		$this->assign('jumpUrl', '__APP__/Public/error404');
		$this->assign('waitSecond',3);
		$this->error("请求的页面不存在");
	}
}
?>