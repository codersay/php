<?php
// 首页
class NewscommentsWidget extends Widget {
	public function render($data) {
		$data['newscomments']=D('Comment')->limit(9)->order('id desc')->select();
		return $this->renderFile('',$data);
	}
	
}
?>
