<?php
$db_config= require './Admin/Conf/db_config.inc.php';
$widget_config= require './Admin/Conf/widgetconfig.inc.php';
$siteconfig= require CONF_PATH.'siteconfig.inc.php';
$config =array(        
		'URL_MODEL'=>3, // 如果你的环境不支持PATHINFO 请设置为3
		'SESSION_AUTO_START'        =>true,
        'USER_AUTH_ON'              =>true,
        'USER_AUTH_TYPE'			=>1,		// 默认认证类型 1 登录认证 2 实时认证
        'USER_AUTH_KEY'             =>'authId',	// 用户认证SESSION标记
        'ADMIN_AUTH_KEY'			=>'administrator',
		'ADMINISTRATOR'			=>'admin',
        'USER_AUTH_MODEL'           =>'User',	// 默认验证数据表模型
        'AUTH_PWD_ENCODER'          =>'md5',	// 用户认证密码加密方式
        'USER_AUTH_GATEWAY'         =>'/Public/login',// 默认认证网关
        'NOT_AUTH_MODULE'           =>'Public',	// 默认无需认证模块
        'REQUIRE_AUTH_MODULE'       =>'',		// 默认需要认证模块
        'NOT_AUTH_ACTION'           =>'',		// 默认无需认证操作
        'REQUIRE_AUTH_ACTION'       =>'',		// 默认需要认证操作
        'GUEST_AUTH_ON'             =>false,    // 是否开启游客授权访问
        'GUEST_AUTH_ID'             =>0,        // 游客的用户ID
		'VAR_PAGE'                  =>'p',
		'CACHE_ADMIN'               =>'./Admin/Runtime/',
		'CACHE_WEB'               =>'./W3note/Runtime/',
		'TPL_PATH'               =>'W3note'.DIRECTORY_SEPARATOR.'Tpl'.DIRECTORY_SEPARATOR,
		'LANG_SWITCH_ON' => true,//开启语言包功能
		'URL_CASE_INSENSITIVE'  => true,   // 默认false 表示URL区分大小写 true则表示不区分
    );
return array_merge($db_config,$config,$siteconfig,$widget_config);
?>