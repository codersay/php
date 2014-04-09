<?php
$db_config= require './Admin/Conf/db_config.inc.php';
$widget_config= require './Admin/Conf/widgetconfig.inc.php';
$siteconfig= require './Admin/Conf/siteconfig.inc.php';
$config =array(        
		'URL_MODEL'=>2, // 如果你的环境不支持PATHINFO 请设置为3
		'URL_ROUTER_ON'=> true,
		'URL_HTML_SUFFIX'=>'.html',
		'URL_ROUTE_RULES'=> array( 
        'blog/:id\d'=>'blog/read',
		'read/:id\d'=>'read/read',
		'page/:id\d'=>'page/index',
		'index/:catid\d'=>'Index/index',
		'cat/:catid\d'=>'cat/index',
		'blog/:catid\d'=>'Blog/index',
		'tag/:name\[a-z]'=>'tag/index',
		'blog/:catid\d'=>'Blog/category',
		//'index/:t\([0-9]{4})-([0-9]{2})'=>'Index/index',
		'date/:t'     =>'w3note/Date/index',
        ), 
		'URL_CASE_INSENSITIVE'      => true,   // 默认false 表示URL区分大小写 true则表示不区分大
		'SESSION_AUTO_START'        =>true,
        'USER_AUTH_ON'              =>true,
        'USER_AUTH_TYPE'			=>1,		// 默认认证类型 1 登录认证 2 实时认证
		'VAR_PAGE'                  =>'p',
		'USER_AUTH_KEY'             =>'userid',
		'SHOW_PAGE_TRACE'           =>  1,//显示调试信息
		'DEFAULT_FILTER'            => 'htmlspecialchars',//过滤方法
		'WORD_FILE'           =>  './W3note/Common/',//显示调试信息
    );
	return array_merge($config,$db_config,$siteconfig,$widget_config);
?>