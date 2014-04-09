<?php
	/*
		Widget Name: NewComment
		Widget URI: http://www.ndlog.com/
		Remark: 侧边栏最新评论，条目及字符数可定制。
		Title: 侧边栏最新评论
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: sidebar
		Param: {"total":"10","strlen":"12","title":"最新评论"}
	*/
	class NewCommentWidget extends Widget{
		public function render($data) {
			$model = M('Comment');
			$list = $model
				->where("status='1' AND pid='0' AND (type='video' OR type='article' OR type='picture' OR type='music' OR type='video')")
				->order('id DESC')
				->limit($data['total'])
				->select();
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