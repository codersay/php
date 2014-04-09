<?php
	/*
	 * 模板插件
	 */
	
	if ( !defined( 'THEME_PATH' ) ) exit(); //不允许独立运行
	define ( 'VAR_PLUGIN_PATH', THEME_PATH . 'plugin_define.php' );
	
	/**
	 * 管理界面获取插件状态 * 此函数必须存在
	 * 
	 * 
	 */
	function getPluginStatus( $status, $info, $keys, $key, $name ){
		$url = array();
		$url['root'] = $key;
		$url['vals'] = $keys;
		$url['name'] = $name;
		switch ( $status ){
			case 0 :
				$url['status'] = 1;
				$str = '<font color="red">关闭</font> &nbsp; <a href="'.U('themes/setPlugin',$url).'">现在开启</a>';
				break;
			case 1 :
				$url['status'] = 0;
				$str = '<font color="green">开启</font> &nbsp; <a href="'.U('themes/setPlugin',$url).'">现在关闭</a>';
				break;
			default :
				$str = '未知';
				break;
		}
		return $str;
	}
	
	/*
	 * 示例：侧边栏插件调用函数，放置在模板需要调用的位置。
	 * 例如：<?php getPluginSideBar(); ?>
	 * 根据 plugin_define.php 插件配置文件调用方法，支持后台模板设置各个功能项是否开启。
	 */
	function getPluginSideBar(){
		$define = require_once( VAR_PLUGIN_PATH );
		foreach( $define['sideBar']['value'] as $key => $val ){
			if ( $val['status'] == 1 ) $key();
		}
	}
	
	function panel_2(){
		echo '<div class="panel_content">Panel_2</div>';
	}
	
	function panel_3(){
		echo '<div class="panel_content">Panel_3</div>';
	}
	
	
	
?>