<?php
	if(!file_exists('./install/installed.lock') && is_dir('./install/')){
		header('location:install/index.php');
		exit();
	}
	//开启调试模式
	define('APP_DEBUG',true);
	define('APP_NAME','Home');
	//引入入口文件
	define('APP_PATH','./Home/');
	//项目模板目录
	//define('TMPL_PATH','./Public/tpl/'); 

	define('RUI_PATH','./ThinkPHP/');
	require(RUI_PATH.'ThinkPHP.php');
?>