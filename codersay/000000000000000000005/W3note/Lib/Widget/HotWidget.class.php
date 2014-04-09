<?php
// 首页
class HotWidget extends Widget {
	public function render($data) {
		$data['hot']=M('News')->field('id,title,hits')->order('hits desc')->limit(8)->select();
		return $this->renderFile('',$data);
	}
	
}
?>