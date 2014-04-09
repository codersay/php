<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>『管理平台』<?php echo (THINK_VERSION); ?></title>
<script language='javascript'>
var preFrameW = '206,*';
var FrameHide = 0;
var curStyle = 1;
var totalItem = 9;
function ChangeMenu(way){
	var addwidth = 10;
	var fcol = top.document.all.btFrame.cols;
	if(way==1) addwidth = 10;
	else if(way==-1) addwidth = -10;
	else if(way==0){
		if(FrameHide == 0){
			preFrameW = top.document.all.btFrame.cols;
			top.document.all.btFrame.cols = '0,*';
			FrameHide = 1;
			return;
		}else{
			top.document.all.btFrame.cols = preFrameW;
			FrameHide = 0;
			return;
		}
	}
	fcols = fcol.split(',');
	fcols[0] = parseInt(fcols[0]) + addwidth;
	top.document.all.btFrame.cols = fcols[0]+',*';
}


function mv(selobj,moveout,itemnum)
{
   if(itemnum==curStyle) return false;
   if(moveout=='m') selobj.className = 'itemsel';
   if(moveout=='o') selobj.className = 'item';
   return true;
}

function changeSel(itemnum)
{
  curStyle = itemnum;
  for(i=1;i<=totalItem;i++)
  {
     if(document.getElementById('item'+i)) document.getElementById('item'+i).className='item';
  }
  document.getElementById('item'+itemnum).className='itemsel';
}

</script>
<style>
* {
	font-size: 12px;
	font-family: "宋体";
}
body { padding:0px; margin:0px; }
#tpa {
	color: #009933;
	margin:0px;
	padding:0px;
	float:right;
	padding-right:10px;
}

#tpa dd {
	margin:0px;
	padding:0px;
	float:left;
	margin-right:2px;
}

#tpa dd.ditem {
	margin-right:8px;
}

#tpa dd.img {
  padding-top:6px;
}

div.item
{
  text-align:center;
	background:url(__PUBLIC__/admin/images/topitembg.gif) 0px 3px no-repeat;
	width:82px;
	height:26px;
	line-height:32px;
}

.itemsel {
  width:80px;
  text-align:center;
  background:#333333;
	border-left:1px solid #ffffff;
	border-right:1px solid #ffffff;
	border-top:1px solid #ffffff;
	height:26px;
	line-height:28px;
}

*html .itemsel {
	height:26px;
	line-height:26px;
}

a:link,a:visited {
 text-decoration: underline;
}

.item a:link, .item a:visited {
	font-size: 12px;
	color: #ffffff;
	text-decoration: none;
	font-weight: bold;
}

.itemsel a:hover {
	color: #ffffff;
	font-weight: bold;
	border-bottom:2px solid #E9FC65;
}

.itemsel a:link, .itemsel a:visited {
	font-size: 12px;
	color: #ffffff;
	text-decoration: none;
	font-weight: bold;
}

.itemsel a:hover {
	color: #ffffff;
	border-bottom:2px solid #E9FC65;
}

.rmain {
  padding-left:10px;
  /* background:url(skin/images/frame/toprightbg.gif) no-repeat; */
}
.weco{
	padding-right:10px;line-height:26px;color:#fff;
	text-decoration:none; 
	}
.weco a:hover {
	color: #ffffff;
	text-decoration: underline;
}
.weco a:link{
	color:#fff;
	text-decoration:none; 
	}
	.weco a:visited{
	color:#fff;
	 text-decoration:none;
	}
</style>
</head>
<body bgColor='#ffffff'>
<table width="100%" border="0" cellpadding="0" cellspacing="0" background="__PUBLIC__/admin/images/topbg.gif">
  <tr>
    <td width='20%' height="60"><img src="__PUBLIC__/admin/images/logo.png" /></td>
    <td width='80%' align="right" valign="bottom">
    	<table width="750" border="0" cellspacing="0" cellpadding="0">
      <tr>
      <td align="right" height="26" class="weco">
        	您好<span class="username">:<?php echo (session('loginUserName')); ?></span>，欢迎使用<strong>WBlog</strong>博客管理系统！
        	[<a href="__ROOT__/" target="_blank">首页</a>]
        	[<a href="__GROUP__/Public/password"  target="main" >修改密码</a>]
        	[<a href="__GROUP__/public/logout" target="_top">注销退出</a>]&nbsp;
      </td>
      </tr>
      <tr>
        <td align="right" height="34" class="rmain">
		<dl id="tpa">
	
		<dd><div class='itemsel' id='item1' onMouseMove="mv(this,'m',1);" onMouseOut="mv(this,'o',1);"><a href="__GROUP__/Public/menu/nav/show" onclick="changeSel(1)" target="menu" title="主菜单">主菜单</a></div></dd>
		<dd><div class='item' id='item2' onMouseMove="mv(this,'m',2);" onMouseOut="mv(this,'o',2);"><a href="__GROUP__/News/index" onclick="changeSel(2)" target="main">内容发布</a></div></dd>
		<dd><div class='item' id='item8' onMouseMove="mv(this,'m',8);" onMouseOut="mv(this,'o',8);"><a href="__GROUP__/Columns/index" onclick="changeSel(8)" target="main">栏目管理</a></div></dd>
		<dd><div class='item' id='item4' onMouseMove="mv(this,'m',4);" onMouseOut="mv(this,'o',4);"><a href="__GROUP__/Clear/index" onclick="changeSel(4)" target="main" title="缓存管理">缓存管理</a></div></dd>
		<dd><div class='item' id='item5' onMouseMove="mv(this,'m',5);" onMouseOut="mv(this,'o',5);"><a href="__GROUP__/Config/config" onclick="changeSel(5)" target="main">系统设置</a></div></dd>
		<dd><div class='item' id='item9' onMouseMove="mv(this,'m',9);" onMouseOut="mv(this,'o',9);"><a href="__GROUP__/Public/main" onclick="changeSel(9)" target="main">后台主页</a></div></dd>
		</dl>
		</td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>