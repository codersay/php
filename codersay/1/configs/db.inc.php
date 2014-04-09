<?php
	/**
	 +=========================================================
	 * NDlog 个人单用户博客系统
	 * mysql.inc.php 数据库配置
	 +=========================================================
	 * @copyright © 2012 nickdraw.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.nickdraw.com/license
	 +=========================================================
	 */
	return array(
		'DB_TYPE'               => 'mysql',     // 数据库类型
		'DB_HOST'               => 'localhost', // 服务器地址
		'DB_NAME'               => 'codersay_20131212',          // 数据库名
		'DB_USER'               => 'root',      // 用户名
		'DB_PWD'                => '',          // 密码
		'DB_PORT'               => '3306',        	// 端口
		'DB_PREFIX'             => 'codersay_',    // 数据库表前缀
	    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
	    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
	    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
	);
?>