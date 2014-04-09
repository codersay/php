<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="__PUBLIC__/admin/style/base.css" type="text/css" />
<link href="__PUBLIC__/admin/style/style.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/admin/style/menu.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/common/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/leftmenu.js"></script>
<base target="main" />
</head>

<body target="main">
<table width="180" align="left" border='0' cellspacing='0' cellpadding='0' style="text-align:left;">
  <tr>
    <td valign='top' style='padding-top:10px' width='20'>
	  <a id='link1' class='mmac'>
      <div onclick="ShowMainMenu(1)">核心</div></a>
      <a id='link2' class='mm'>
      <div onclick="ShowMainMenu(2)">用户</div></a>
     <a id='link3' class='mm'>
      <div onclick="ShowMainMenu(3)">系统</div>
      </a>
      <div class='mmf'></div></td>
    <td width='160' id='mainct' valign="top">
    
    <!--核心开始-->
	<div id='ct1'>
	<dl class='bitem' id='sunitems1_1'><dt onClick='showHide("items1_1")'><b>常用操作</b></dt>
<dd style='display:block' class='sitem' id='items1_1'>
<ul class='sitemu'>
<li>        <div class='items'>
            <div class='fllct'><a href='__GROUP__/Article/index' target='main'>博文管理</a></div>

            <div class='flrct'>
                <a href='__GROUP__/Article/add' target='main'><img src='__PUBLIC__/admin/images/gtk-sadd.png' alt='创建博文' title='创建博文'/></a>
            </div>
        </div>
</li>
<li><div class='items'>
            <div class='fllct'><a href='__GROUP__/Columns/index' target='main'>分类管理</a></div>

            <div class='flrct'>
                <a href='__GROUP__/Columns/add' target='main'><img src='__PUBLIC__/admin/images/channeladd.gif' alt='创建分类' title='创建分类'/></a>
            </div>
        </div>
</li>
<li><a href='__GROUP__/Tags/index' target='main'>标签管理</a>
</li>
<li><a href='__GROUP__/Singlepage/index' target='main'>单页管理</a>
</li>
<li><a href='__GROUP__/Model/index' target='main'>模型管理</a>
</li>
</ul>
</dd>
</dl>

<dl class='bitem' id='sunitems2_1'><dt onClick='showHide("items2_1")'><b>模块操作</b></dt>
<dd style='display:block' class='sitem' id='items2_1'>
<ul class='sitemu'>
<li>        <div class='items'>
            <div class='fllct'><a href='__GROUP__/Comment/index' target='main'>评论管理</a></div>
        </div>
</li>
<li>        <div class='items'>
            <div class='fllct'><a href='__GROUP__/Feedback/index' target='main'>留言管理</a></div>
        </div>
</li>
<li>        <div class='items'>
            <div class='fllct'><a href='__GROUP__/Links/index' target='main'>友情链接</a></div>
        </div>
</li>
</ul>
</dd>
</dl>
	</div>
    <!--核心结束-->
    
    <!--用户开始-->
      <div id='ct2' style="display:none">
      <dl id="sunitems1_2" class="bitem"><dt onclick="showHide('items1_2')"><b>系统用户管理</b></dt>
<dd id="items1_2" class="sitem">
<ul class="sitemu">
<li><a target="main" href="__GROUP__/Users/index">用户列表</a>
</li>
<li><a target="main" href="__GROUP__/Users/add">添加用户</a>
</li>
<li><a target="main" href="__GROUP__/Role/index">角色管理</a>
<li><a target="main" href="__GROUP__/Node/index">节点管理</a>
<li><a target="main" href="__GROUP__/Users/pwd">修改密码</a>
</li>
</ul>
</dd>
</dl>
</div>
<!--用户结束-->

	  <!--系统开始-->
      <div id='ct3' style="display:none">
      <dl id="sunitems1_3" class="bitem"><dt onclick="showHide('items1_3')"><b>系统操作</b></dt>
<dd id="items1_3" class="sitem">
<ul class="sitemu">
<li><a target="main" href="__GROUP__/Config/index">系统设置</a>
</li>
<li><a target="main" href="__GROUP__/Clearcache/index">清理缓存</a>
<li><a target="main" href="__GROUP__/Backupdata/index">数据备份</a>
<li><a target="main" href="__GROUP__/Restoredata/index">数据还原</a>
</li>
</ul>
</dd>
</dl>
      </div>
      <!--系统结束-->
      </td>
  </tr>
  <tr>
    <td width='26'></td>
    <td width='160' valign='top'><img src='__PUBLIC__/admin/images/idnbgfoot.gif' /></td>
  </tr>
</table>

</body>
</html>