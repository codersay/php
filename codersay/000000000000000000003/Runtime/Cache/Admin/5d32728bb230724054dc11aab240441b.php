<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="/Tpl/default/Admin/css/common.css" type="text/css" />
<script src="__PUBLIC__/js/jquery.js"></script>
<title>登录</title>
<script language="javascript">
function refreshVerify() {
	var timenow = new Date().getTime();
	$("#verifyImg").attr("src", '/Admin/Login/verify/'+timenow);
}
</script>
</head>

<body>
<form action="http://localhost/codersay/3/index.php?s=/Admin/Login/login" method="post">
<div id="man_zone" style="border:0; margin-top:20px; padding-top: 0px;">
  <table width="50%" border="0" align="center"  cellpadding="3" cellspacing="1" class="table_style">
    <caption><h2>用户登录</h2></caption>
    <tr>
      <td width="35%" class="left_title_1"><span class="left-title">用户名</span></td>
      <td width="65%"><input type="text" name="username" id="username" style="width:150px;"></td>
    </tr>
    <tr>
      <td class="left_title_1">密　码</td>
      <td><input type="password" name="password" id="password" style="width:150px;" ></td>
    </tr>
	<tr>
      <td class="left_title_1">验证码</td>
      <td><input type="text" name="verify" style="width:60px;" />&nbsp;&nbsp; <img id="verifyImg" src="__URL__/verify" border="0" align="absmiddle" alt="点击刷新验证码" onclick="refreshVerify();" style="cursor:pointer;" /></td>
    </tr>
    <tr>
      <td class="left_title_2">&nbsp;</td>
      <td><input type="submit" value="登录" style="width:100px;" /></td>
    </tr>
  </table>
</div>
</form>
</body>
</html>