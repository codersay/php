<?php
	/*
		Widget Name: NewVideo
		Widget URI: http://www.ndlog.com/
		Remark: 侧边栏最新分享视频，条目及字符数可定制。
		Title: 侧边栏最新视频
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: sidebar
		Param: {"total":"10","strlen":"12","title","最新视频"}
	*/
	class NewVideoWidget extends Widget{
		public function render($data) {
			$model = M('Archives');
			$list = $model->where("status=1 AND type='video'")->order('id DESC')->limit($data['total'])->select();
			$var['data'] = $list;
			$var['len'] = $data['strlen'];
			$var['title'] = $data['title'];
			$var = array_merge($var,$data);
			// 渲染模版
	        $content = $this->renderFile('list', $var);
	        // 输出数据
	        return $content;
		}
	}