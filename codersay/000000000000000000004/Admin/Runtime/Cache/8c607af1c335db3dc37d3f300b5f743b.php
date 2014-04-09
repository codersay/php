<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="__PUBLIC__/admin/style/base.css" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/arclist.js"></script>
</head>
<body background='__PUBLIC__/admin/images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="99%" border="0" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr> 
    <td height="19" colspan="4" background="__PUBLIC__/admin/images/tbg.gif" bgcolor="#E7E7E7">
    	<table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td width="24%" style="padding-left:10px;"><strong>数据还原</strong></td>
          <td width="76%" align="right">
          	
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <form name="form1" action="" method="post" >
  <tr bgcolor="#FBFCE2" align="center"> 
    <td width="20%">文件名</td>
    <td width="8%">备份时间</td>
    <td height="24" width="5%">卷号</td>
    <td width="10%">操作</td>
  </tr>
  <?php if(is_array($files)): $i = 0; $__LIST__ = $files;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align='center'  bgcolor='#FFFFFF' height='24' onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
    
    <td> 
      <?php echo ($data["filename"]); ?>
    </td>
    <td> 
      <?php echo ($data["time"]); ?>
    </td>
    <td>
    	<?php echo ($data["part"]); ?>
    </td>
    <td>
    <a href='__URL__/import/file/<?php echo ($data["filename"]); ?>' ><img src='__PUBLIC__/admin/images/gtk-im.png' alt='导入' title='导入'/></a>
    <a href='__URL__/del/file/<?php echo ($data["filename"]); ?>' ><img src='__PUBLIC__/admin/images/gtk-del.png' alt='删除' title='删除'/></a>
    </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <!--<tr bgcolor="#ffffff"> 
      <td height="24" colspan="4">
      	&nbsp; 
       <a href="javascript:selOrNoSel('files[]')" class="coolbg">全选/反选</a>
       &nbsp; 
       <a href="" class="coolbg">删除备份</a>
      </td>
  </tr>-->
   </form>

</table>
</body>
</html>