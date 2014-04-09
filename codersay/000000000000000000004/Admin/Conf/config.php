<?php
/**
 * @主配置
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/21
 * @Copyright: www.iqishe.com
 */

$dbconfig = require('./Public/config/dbconfig.inc.php');
$webconfig = require('./Public/config/webconfig.inc.php');
$config = array(
	'URL_MODEL' => 3, //PATHINFO设置为3，为兼容模式
	'URL_CASE_INSENSITIVE' => true, //表示url不区分大小写
	'CACHE_ADMIN' => './Admin/Runtime/',
	'CACHE_WEB' => './Home/Runtime/',
	'USER_AUTH_ON' => true,
	'USER_AUTH_TYPE' => 2, // 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY' => 'authId', // 用户认证SESSION标记
	'ADMIN_AUTH_KEY' => 'administrator',
	'USER_AUTH_MODEL' => 'Users', // 默认验证数据表模型
	'AUTH_PWD_ENCODER' => 'md5', // 用户认证密码加密方式
	'USER_AUTH_GATEWAY' => '/Public/login',// 默认认证网关
	'NOT_AUTH_MODULE' => 'Public', // 默认无需认证模块
	'REQUIRE_AUTH_MODULE' => '', // 默认需要认证模块
	'NOT_AUTH_ACTION' => '', // 默认无需认证操作
	'REQUIRE_AUTH_ACTION' => '', // 默认需要认证操作
	'GUEST_AUTH_ON' => false, // 是否开启游客授权访问
	'GUEST_AUTH_ID' => 0,// 游客的用户ID
	'SHOW_PAGE_TRACE' => true,//显示调试信息
);
return array_merge($dbconfig,$webconfig,$config);
?>