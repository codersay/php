<?php
// 首页
class LinkWidget extends Widget {
	public function render($data) {
		$data['link']=M('Link')->field('id,name,url')->order('id desc')->select();
		return $this->renderFile('',$data);
	}
	
}
?>