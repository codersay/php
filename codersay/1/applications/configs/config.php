<?php
	/**
	 +=========================================================
	 * NDlog(NDesign) 个人单用户博客系统
	 * config.php 项目配置文件
	 +=========================================================
	 * @copyright © 2012 ndlog.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.ndlog.com/license
	 +=========================================================
	*/
	
	if (!defined("APP_NAME")) exit();
	
    $config 	= require ("./configs/config.inc.php");
    $mysql 		= require ("./configs/db.inc.php");
	$settings	= require ("./configs/settings.inc.php");
	
    $array  = array(
	    'URL_MODEL'          => $settings['CUSTOM_URL_MODEL'],
	    'URL_PATHINFO_DEPR'  => $settings['CUSTOM_URL_DEPR'],	// PATHINFO模式下，各参数之间的分割符号
	    'URL_HTML_SUFFIX'    => $settings['CUSTOM_URL_SUFFIX'],  // URL伪静态后缀设置
	    
	    'DEFAULT_THEME'		=> $settings['DEFAULT_THEME'],
	    'TMPL_DETECT_THEME' => true,

	    'url_router_on'		=> false,
	    'url_route_rules'	=> require( './configs/routes.app.php' ),
    		
    	'LOAD_EXT_FILE'		=> 'custom,extend', //自动加载扩展函数库
		
	    'LIKE_MATCH_FIELDS'  =>'title|remark',
	    'TAG_NESTED_LEVEL'   =>3,
    		
    		//模板路径规则
    		'TMPL_PARSE_STRING'			=> array(
    				'__SITE_URL__'=> 'http://www.codersay.net',	
    				'__STATIC_URL__'=> 'http://static.codersay.net',	
    				'__PUBLIC__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'],						//
    				'__JS__'		=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/js',					//网站公用脚本目录
    				'__UPLOAD_ALBUM__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_UPLOAD_PATH'],				//附件路径
    				'__THEMES__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/themes/'.APP_NAME,	//主题默认路径
    				'__ATTACH__'	=> __ROOT__.'/'.$settings['WEB_PUBLIC_PATH'].'/'.$settings['DIR_ATTCH_PATH'],
    		)
    );
	
    return array_merge( $config, $settings, $array, $mysql );
?>