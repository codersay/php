<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『管理平台』<?php echo (THINK_VERSION); ?></title>
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="location">
   <span>&nbsp;欢迎使用WBlog博客程序，建博的首选工具。</span>
 </div>
<div class="main">
   <div class="line"/></div>
</div>
<div>

<div class="table-list"> 
<table width="100%" align="center" border="0" cellpadding="3" cellspacing="1" class="mainbg" style="margin-bottom:8px;margin-top:8px;">
  <tr>
    <td class="mainbg" class='title'><span>个人信息</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>您好,<?php echo (session('loginUserName')); ?>!上次登录时间：<?php echo (date("y-m-d H:i:s",session('lastLoginTime'))); ?>,上次登录IP：<?php echo (session('lastloginip')); ?></td>
  </tr>
</table>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="1" class="mainbg" style="margin-bottom:8px">
  <tr>
    <td colspan="2" background="__PUBLIC__/admin/images/wbg.gif" bgcolor="#EEEEEE" class='title'>
    	<div style='float:left'><span>快捷操作</span></div>
    	<div style='float:right;padding-right:10px;'></div>
   </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="30" colspan="2" align="center" valign="bottom"><table width="100%" border="0" cellspacing="1" cellpadding="1">
        <tr>
          <td width="15%" height="31" align="center"></td>
          <td width="85%" valign="bottom"><div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/addnews.gif' width='16' height='16' /></div>
              <div class='txt'><a href='__APP__/News/index'><u>文档列表</u></a></div>
            </div>
            <div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/menuarrow.gif' width='16' height='16' /></div>
              <div class='txt'><a href='__APP__/Comment/index'><u>评论管理</u></a></div>
            </div>
            <div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/manage1.gif' width='16' height='16' /></div>
              <div class='txt'><a href='__APP__/News/insert'><u>内容发布</u></a></div>
            </div>
            <div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/file_dir.gif' width='16' height='16' /></div>
              <div class='txt'><a href='__APP__/Columns/index'><u>栏目管理</u></a></div>
            </div>
            <div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/part-index.gif' width='16' height='16' /></div>
              <div class='txt'><a href="__APP__/Clear/index" target="main" title="缓存管理"><u>缓存管理</u></a></div>
            </div>
            <div class='icoitem'>
              <div class='ico'><img src='__PUBLIC__/admin/images/manage1.gif' width='16' height='16' /></div>
              <div class='txt'><a href='__APP__/Config/config'><u>修改系统参数</u></a></div>
            </div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="1" class="mainbg" style="margin-bottom:8px">
  <tr class="mainbg">
    <td colspan="2"  class='title'><span>系统基本信息</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="25%" bgcolor="#FFFFFF">您的级别：</td>
    <td width="75%" bgcolor="#FFFFFF"><?php echo (session('loginUserName')); ?></td>
  </tr>
   <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr bgcolor="#FFFFFF">
    <td><?php echo ($key); ?>：</td>
    <td><?php echo ($v); ?></td>
  </tr><?php endforeach; endif; else: echo "" ;endif; ?>  
</table>
<table width="100%" align="center" border="0" cellpadding="4" cellspacing="1" bgcolor="#EEEEEE">
  <tr class="mainbg">
    <td colspan="2" class='title'><span>使用帮助</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="32">官方交流网站：http://www.w3note.com</td>
    <td><a href="http://www.w3note.com" target="_blank"><u>网志博客</u></a></td>
  </tr>
</table>
</div>
</div>
</body>
</html>