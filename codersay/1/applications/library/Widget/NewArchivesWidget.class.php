<?php
	/*
		Widget Name: NewArchives
		Widget URI: http://www.ndlog.com/
		Remark: 侧边栏最新文档，条目及字符数可定制。
		Title: 侧边栏最新文档
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: sidebar
		Param: {"total":"10","strlen":"12"}
	*/
	class NewArchivesWidget extends Widget{
		public function render($data) {
			$model = M('Archives');
			$list = $model->where("status=1")->order('id DESC')->limit($data['total'])->select();
			$var['data'] = $list;
			$var['len'] = $data['strlen'];
			$var['title'] = '最新文档';
			$var = array_merge($var,$data);
			// 渲染模版
	        $content = $this->renderFile('list', $var);
	        // 输出数据
	        return $content;
		}
	}