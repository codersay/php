<?php
	/**
	 +=========================================================
	 * DBloger 个人单用户博客系统
	 * config.php 项目配置文件
	 +=========================================================
	 * @copyright © 2012 nickdraw.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.dbloger.com/license
	 +=========================================================
	 */
	
	if (!defined("APP_NAME")) exit();
	
    $config 	= require ("./configs/config.inc.php");
    $mysql 		= require ("./configs/db.inc.php");
	$settings	= require ("./configs/settings.inc.php");
	
	$admin_theme = 'NDlog';
	
    $array  = array(
    	
		'URL_DISPATCH_ON'    =>1,
	    'URL_MODEL'          =>0,
	    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
		
		'DEFAULT_THEME'		=> $admin_theme,
		
	    'LIKE_MATCH_FIELDS'  =>'title|remark',
	    'TAG_NESTED_LEVEL'   =>3,
	    'UPLOAD_FILE_RULE'	 =>'uniqid',                //  文件上传命名规则 例如 time uniqid com_create_guid 等 支持自定义函数 仅适用于内置的UploadFile类
	    'LOAD_EXT_FILE'		=> 'custom,extend,message', 		//自动加载扩展函数库
    		
		//模板路径规则
		'TMPL_PARSE_STRING'	=> array(
			'__PUBLIC__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'],						//
			'__JS__'		=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/js',					//网站公用脚本目录
			'__UPLOAD__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_UPLOAD_PATH'],				//附件路径
			'__THEMES__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/themes/'.APP_NAME.'/'.$admin_theme,	//主题默认路径
			'__RESIZE__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_RESIZE_PATH'],
			'__PMINI__'		=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_MINI_PATH'],
			'__PTHUMB__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_THUMB_PATH'],
			'__ATTACH__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_ATTCH_PATH'],
		)
    );
	
    return array_merge( $config, $settings, $array, $mysql );
?>