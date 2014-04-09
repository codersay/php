<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="__PUBLIC__/admin/style/base.css" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/common/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
</head>
<body>

<div class="main">
<table width="98%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="background:#CFCFCF;">
    <tr>
      <td height="20" colspan="6" bgcolor="#F0FBBD" background="__PUBLIC__/admin/images/wbg.gif">
      	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="left" style="padding-left:10px;"><strong>标签管理</strong></td>
                        <form name='form1' action="__URL__/index" method="post" id="form1">
            <td width="40%" align="right">
   	        搜索：
   	          <input type='text' name='tagkey' size='20' value="<?php echo ($searchkey); ?>" />
              <input type="hidden" name="search" value="search"/>
   	        	<input type='submit' name='sb' value='搜索' class="np coolbg" />
   	        	&nbsp; </td>
</form>
          </tr>
      </table></td>
    </tr>
    <tr align="center" bgcolor="#FBFCE2" height="26">
      <td width="5%">选择</td>
      <td width="30%">标签名称</td>
      <td width="15%">数量</td>
      <td width="15%">所属栏目</td>
	  <td width="20%">添加时间</td>
    <td>管理操作</td>
    </tr>
	<form name='form2' method="post" id="form2">
	<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
		<td height="24">
			<input type="checkbox" name="tagid[]" id="tag_<?php echo ($data["tagid"]); ?>" value="<?php echo ($data["tagid"]); ?>" class='np' />
		</td>
		<td>
			<a href="#" target="_blank"><?php echo ($data["tagname"]); ?></a>
		</td>
		<td>
			<?php echo ($data["num"]); ?>
		</td>
        <td>
        <?php echo ($data["colname"]); ?>
        </td>
		<td>
			<?php echo (date("Y-m-d",$data["addtime"])); ?>
		</td>
		<td>
		 <a href='__URL__/del/tagid/<?php echo ($data["tagid"]); ?>'><img src="__PUBLIC__/admin/images/gtk-del.png" title="删除" alt="删除"/></a>
		</td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<tr bgcolor="#F0FBBD">
	
	<td height="28" colspan="6" align="center" bgcolor="#F8FEE0" id="pages">
		<?php echo ($page); ?>
  </td>
	</tr>
		<tr align="left" bgcolor="#FAFDF0">
	<td height="40" colspan="6">
    <a href="javascript:selOrNoSel('tagid[]')" class="coolbg">全选/反选</a>
	<input type="submit" value="删除" onclick="del('__URL__/delall','form2')"/>
	</td>
	</tr>
    </form>

	</table>
</div>
</body>
</html>