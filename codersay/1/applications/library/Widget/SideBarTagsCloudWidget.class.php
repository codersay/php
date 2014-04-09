<?php
	/*
		Widget Name: SideBarTagsCloud
		Widget URI: http://www.ndlog.com/
		Remark: 侧边栏标签云。
		Title: 侧边栏标签云
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: sidebar
		Param: {"total":"30","title":"标签云"}
	*/
	class SideBarTagsCloudWidget extends Widget{
		public function render($data) {
			$var = array();
			$list = M('Tag')->order('count DESC')->limit($data['total'])->select();
			$var['list'] = $list;
			$var = array_merge( $data, $var );
			// 渲染模版
	        $content = $this->renderFile('list', $var);
	        // 输出数据
	        return $content;
		}

	}