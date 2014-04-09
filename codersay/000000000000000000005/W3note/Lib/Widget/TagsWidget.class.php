<?php
// 首页
class TagsWidget extends Widget {
	public function render($data) {
		$data['tags']=D('Tag')->TagList('News');
		return $this->renderFile('',$data);
	}
	
}
?>