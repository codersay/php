<?php
	/*
		Widget Name: SideBarLogin
		Widget URI: http://www.ndlog.com/
		Remark: 侧边栏自由定制ajax用户登录及管理员信息及操作挂件。
		Title: 侧边栏用户登录
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: sidebar
		Param: 
	*/
	class SideBarLoginWidget extends Widget{
		public function render($data) {
			$var = array();
			if ( isset( $_SESSION['AUTH'] ) ){
				$var['tpl'] = 'sidebar_admin_info';
			}else{
				$var['tpl'] = 'sidebar_login';
			}
			// 渲染模版
	        $content = $this->renderFile($var['tpl'], $var);
	        // 输出数据
	        return $content;
		}
	}