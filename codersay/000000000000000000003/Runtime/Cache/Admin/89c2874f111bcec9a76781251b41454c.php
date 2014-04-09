<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/Tpl/default/Admin/css/common.css" type="text/css" />
<title>左侧导航栏</title>
</head>
<script  type="text/javascript" src="__PUBLIC__/js/outlook.js"></script>
<body onload="initinav('系统设置')">
<div id="left_content">
     <div id="user_info">欢迎您，<strong><?php echo ($username); ?></strong><br />[系统管理员，<a href="/Admin/Login/logout" target="_parent">退出</a>]</div>
	 <div id="main_nav">
	     <div id="left_main_nav"></div>
		 <div id="right_main_nav"></div>
	 </div>
</div>
</body>
</html>