<?php
	/*
		Widget Name: TplChange
		Widget URI: http://www.ndlog.com/
		Remark: 模板切换列表，可随意定制，将{:W("TplChange",array())}放置在你需要的模板位置即可。
		Title: 模板切换按钮
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: other
		Param: 
	*/
	class TplChangeWidget extends Widget{
		public function render($data) {
			return getTplURL();
		}
	}