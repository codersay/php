<?php
	 /**
	 +=========================================================
	 * DBloger 个人单用户博客系统
	 * config.inc.php 网站主配置
	 +=========================================================
	 * @copyright © 2012 nickdraw.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.dbloger.com/license
	 +=========================================================
	 */
	return array(
		'app_status'				=> 'debug',
		'show_page_trace'			=> true,
		'default_module'			=> 'Index',
		'session_atuo_start'		=> true,
		'APP_FILE_CASE'				=> true,
		'APP_AUTOLOAD_PATH' 		=> 'Think.Util,ORG.Util',
		'DB_FIELDTYPE_CHECK'		=> true,
		'TMPL_STRIP_SPACE'  		=> true,
		'VAR_PAGE'          		=> 'p',
		'URL_CASE_INSENSITIVE'  	=> true,
		'TOKEN_ON'					=> false,
		'R_VERSION'					=> '1.2 RC UTF8 Build 130603',
		'R_NAME'					=> 'NDlog',
		'TMPL_ACTION_ERROR'			=> 'Public:success',
		'TMPL_ACTION_SUCCESS'		=> 'Public:success',
		'TMPL_EXCEPTION_FILE' 		=> __ROOT_PATH__ . '/configs/exception.html',
		'SHOW_ERROR_MSG' 			=> false,
		'ERROR_MESSAGE' 			=> '大侠，您的气场导致系统发生错误！请稍后重试。',
	);
?>