<?php
// 首页
class RandWidget extends Widget {
	public function render($data) {
		$data['rand']=M('News')->field('id,title,hits')->order("rand()")->limit(12)->select();
		return $this->renderFile('',$data);
	}
	
}
?>