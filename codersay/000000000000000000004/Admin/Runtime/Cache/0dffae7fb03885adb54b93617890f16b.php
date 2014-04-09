<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title></title>
<link href="__PUBLIC__/admin/style/base.css" rel="stylesheet" type="text/css" />
<!--<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>-->
</head>
<body background='__PUBLIC__/admin/images/allbg.gif' leftmargin='8' topmargin='8'>
<div style="min-width:780px">
 <table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#D6D6D6" align="center">
  <tr>
   <td height="28" background="__PUBLIC__/admin/images/tbg.gif" style="padding-left:10px;"><b>系统配置参数：</b></td>
  </tr>
  <!--<tr>
   <td height="24" bgcolor="#ffffff" align="center">
		<a href='#'>站点设置</a>|
	</td>
  </tr>-->
  
 </table>
 <table width="98%" border="0" cellpadding="0" cellspacing="0" style="margin-top:10px" bgcolor="#D6D6D6" align="center">
  <!--<tr>
   <td height="28" align="right" background="images/tbg.gif" style="border:1px solid #cfcfcf;border-bottom:none;">&nbsp;&nbsp;&nbsp;配置搜索：
    <input type="text" name="keywds" id="keywds" />
    <input name="searchBtn" type="button" value="搜索" id="searchBtn" onclick=""/>
    &nbsp;<span id="_searchback"></span></td>
  </tr>-->
  <tr>
   <td bgcolor="#FFFFFF" width="100%">
   <form action="__URL__/update" method="post" name="form1">
<div id="_mainsearch">
     
     <table width="100%" style='' id="" border="0" cellspacing="1" cellpadding="1" bgcolor="#cfcfcf">
      <tr align="center" bgcolor="#FBFCE2" height="25">
       <td width="300">名称</td>
       <td>参数值</td>
       <td width="220">说明</td>
      </tr>
      
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">网站网址： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_INDEXURL]' value="<?php echo ($config["CFG_INDEXURL"]); ?>" style='width:80%'></td>
       <td>网站域名</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">默认主题： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_DF_THEME]' value="<?php echo ($config["CFG_DF_THEME"]); ?>" style='width:80%'></td>
       <td>文件路径：./PUBLIC/tpl/</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">显示文章数： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_PAGESIZE]' value="<?php echo ($config["CFG_PAGESIZE"]); ?>" style='width:80%'></td>
       <td>一次加载多少文章</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">网站名称： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_WEBNAME]' value="<?php echo ($config["CFG_WEBNAME"]); ?>" style='width:80%'></td>
       <td>网站title信息</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">网站副标题： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_SUBTITLE]' value="<?php echo ($config["CFG_SUBTITLE"]); ?>" style='width:80%'></td>
       <td>显示在网站导航栏</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">关键字： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_KEYWORDS]' value="<?php echo ($config["CFG_KEYWORDS"]); ?>" style='width:80%'></td>
       <td>多关键字请用","分开</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">网站描述： </td>
       <td align="left" style="padding:3px;"><textarea style='width:80%' rows="4" name='conf[CFG_DESCRIPTION]'><?php echo ($config["CFG_DESCRIPTION"]); ?></textarea> </td>
       <td>网站description信息</td>
      </tr>
      <tr align="center" height="25" bgcolor="#ffffff" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
       <td width="300">版权信息： </td>
       <td align="left" style="padding:3px;"><input type='text' name='conf[CFG_POWERBY]' value="<?php echo ($config["CFG_POWERBY"]); ?>" style='width:80%'></td>
       <td>在网站尾部显示</td>
      </tr>
     </table>

</div>
     <table width="100%" border="0" cellspacing="1" cellpadding="1"  style="border:1px solid #cfcfcf;border-top:none;">
      <tr bgcolor="#F9FCEF">
       <td height="50" colspan="3"><table width="98%" border="0" cellspacing="1" cellpadding="1">
         <tr>
          <td width="11%">&nbsp;</td>
          <td width="11%"><input name="imageField" type="image" src="__PUBLIC__/admin/images/button_ok.gif" width="60" height="22" border="0" class="np"></td>
          <td width="78%"></td>
         </tr>
        </table></td>
      </tr>
     </table>
    </form></td>
  </tr>
 </table>
</div>
</body>
</html>