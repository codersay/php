<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RUIBlog 博客管理系统 By RUI_iqishe</title>
<link href="__PUBLIC__/admin/style/login.css" rel="stylesheet" type="text/css" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="bookmark" href="/favicon.ico" type="image/x-icon"/>
</head>
<body>
<form method='post' name="login" id="loginform" action="__URL__/checkLogin">
<div id="login">
  <div id="content">
    <div  class="cnt_pan">
      <div class="cnt">
        <div class="bg01"></div>
        <div class="bg02"></div>
        <div class="bg03"></div>
        <div class="bg04"></div>
        <div class="container">
          <div class="copyright">
            <p>版权所有(C) RUIBlog 1.0.0</p>
          </div>
          <div class="main">
            <div class="main_pan">
              <div class="imges"><img src="__PUBLIC__/admin/images/login/login.gif" alt="登录" title="登录" /></div>
              <p class="msg"></p>
              <div class="ipt">
                <ul style="padding-left:15px;">
                  <li><span class="text">用户名:</span>
                    <input name="username" type="text" class="wth1" size="40" id="username"/>
                  </li>
                  <li><span class="text">密&nbsp;&nbsp;&nbsp;码:</span>
                    <input type="password" class="wth1" name="pwd" id="pwd" />
                  </li>
                  <li><span class="text">验证码:</span>
                    <input name="verify" type="text" class="wth2" onkeydown="keydown(event)" size="40" maxlength="4" id="verify" />
                    <span><img class="code" id="verifyImg" src="__URL__/verify/" onclick="show(this);" alt="点击刷新验证码" title="点击刷新验证码" /></span>
                  </li>
                </ul>
                <div class="but"><span><input type="submit" value="登录"/></span><span><input type="reset" value="重置" /></span></div>
              </div>
            </div>
          </div>
          <div></div>
        </div>
      </div>
    </div>
  </div>
</div>
</form>
<script language="JavaScript">
function keydown(e){
	var e = e || event;
	if (e.keyCode==13)
	{
		document.login.submit();
	}
}
function show(obj){
obj.src="__URL__/verify/random/"+Math.random();
}
document.login.username.focus();
</script>
</body>
</html>