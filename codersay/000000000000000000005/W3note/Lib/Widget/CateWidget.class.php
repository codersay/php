<?php
// 首页
class CateWidget extends Widget {
	public function render($data) {
		$data['cate'] = D('Columns')->Catlist('News', 1);
		return $this->renderFile('',$data);
	}
	
}
?>