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
    <td height="19" colspan="7" background="__PUBLIC__/admin/images/tbg.gif" bgcolor="#E7E7E7">
    	<table width="96%" border="0" cellspacing="1" cellpadding="1">
        <tr> 
          <td width="24%" style="padding-left:10px;"><strong>数据备份</strong></td>
          <td width="76%" align="right">
          	
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <form name="form1" action="__URL__/backup" method="post" >
  <tr bgcolor="#FBFCE2" align="center"> 
    <td height="24" width="5%">选择</td>
    <td width="20%">表名</td>
    <td width="8%">记录数</td>
    <td width="10%">大小</td>
    <td width="15%">创建时间</td>
    <td width="15%">编码类型</td>
    <td width="10%">引擎类型</td>
  </tr>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align='center'  bgcolor='#FFFFFF' height='24'>
    <td>
    	<input type="checkbox" name="tables[]" value="<?php echo ($data["name"]); ?>" class="np" checked="checked" /> 
    </td>
    <td> 
      <?php echo ($data["name"]); ?>
    </td>
    <td> 
      <?php echo ($data["rows"]); ?>
    </td>
    <td>
    <?php echo ($data["data_length"]); ?>
    </td>
    <td>
    	<?php echo ($data["create_time"]); ?>
    </td>
    <td> 
      <?php echo ($data["collation"]); ?>
    </td>
    <td> 
      <?php echo ($data["engine"]); ?>
    </td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    <tr bgcolor="#ffffff"> 
      <td height="24" colspan="7">
      	&nbsp; 
       <a href="javascript:selOrNoSel('tables[]')" class="coolbg">全选/反选</a>
       &nbsp;
       每个分卷的大小：<input type="text" name="filesize" value="2048" size="5" style="color:red"/> K 
       &nbsp;
       <input type="submit" name="Submit" value="备份" class="coolbg np" />
      </td>
  </tr>
   </form>

</table>
</body>
</html>