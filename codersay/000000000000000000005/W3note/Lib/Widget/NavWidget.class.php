<?php
// 首页
class NavWidget extends Widget {
	public function render($data) {
		$data['nav']=D('Columns')->menu();
		return $this->renderFile('',$data);
	}
	
}
?>