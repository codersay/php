<?php
// 首页
class DateWidget extends Widget {
	public function render($data) {
		$data['date'] = D('News')->DateList('News');
		return $this->renderFile('',$data);
	}
	
}
?>