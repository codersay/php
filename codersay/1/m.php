<?php
	/**
	 +=========================================================
	 * NDlog(NDesign) 个人单用户博客系统
	 * index.php 入口文件
	 +=========================================================
	 * @copyright © 2012 ndlog.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.ndlog.com/license
	 +=========================================================
	 */
	
	if ( !file_exists( './install/installed.lock' ) && is_dir( './install/' ) ){
		header( "location:install/" );
		exit();
	}
	
	//调试模式
//	define( 'APP_DEBUG',		true );
//	define( 'NO_CACHE_RUNTIME',	true );
	
	//主配置项目
	define( 'APP_NAME', 		'board' );									// 项目名称
	define( 'APP_PATH', 		'./' . APP_NAME . '/' );					// 项目目录
	define( 'COMMON_PATH', 		APP_PATH . 'common/' );						// 项目公共目录
	define( 'LIB_PATH', 		APP_PATH . 'library/' );					// 项目类库目录
	define( 'CONF_PATH', 		APP_PATH . 'configs/' );					// 项目配置目录
	define( 'LANG_PATH', 		APP_PATH . 'language/' );					// 项目语言包目录
	define( 'TMPL_PATH', 		APP_PATH . 'themes/' );						// 项目模板目录
	define( 'HTML_PATH', 		APP_PATH . 'static/' );						// 项目静态目录
	define( 'RUNTIME_PATH', 	'./cache/' . APP_NAME . '/' );				// 项目临时文件主目录
	
	//网站缓存配置
	define( 'LOG_PATH', 		RUNTIME_PATH . 'logs/' );					// 项目日志目录
	define( 'TEMP_PATH', 		RUNTIME_PATH . 'temp/' );					// 项目缓存目录
	define( 'DATA_PATH', 		RUNTIME_PATH . 'data/' );					// 项目数据目录
	define( 'CACHE_PATH', 		RUNTIME_PATH . 'cache/' );					// 项目模板缓存目录

	define( '__ROOT_PATH__' , str_replace("\\", '/', dirname(__FILE__) ) );

	//运行项目
	require ( './core/core.php' );
?>