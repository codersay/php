<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__PUBLIC__/admin/style/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
</head>
<body leftmargin="8" topmargin="8" background='__PUBLIC__/admin/images/allbg.gif'>  
<!--  内容列表   -->
<form name="form1" id="form1" method="post">
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
<tr bgcolor="#E7E7E7" >
	<td height="28" colspan="8" background="__PUBLIC__/admin/images/tbg.gif" style="padding-left:10px;">
	<strong>节点列表</strong>
	</td>
</tr>
<tr align="center" bgcolor="#FBFCE2" height="25">
	<td width="4%">ID</td>
	<td width="15%">应用名</td>
	<td width="15%">显示名</td>
	<td width="15%">备注</td>
	<td width="10%">上级节点</td>
    <td width="10%">类型</td>
    <td width="10%">状态</td>
    <td width="8%">排序</td>
	<!--<td width="10%">操作</td>-->
</tr>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align='center' bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
	<td>
		<?php echo ($data["id"]); ?>
	</td>
	<td>
   		<?php echo ($data["name"]); ?>
	</td>
	<td><?php echo ($data["title"]); ?></td>
	<td><?php echo ($data["remark"]); ?></td>
	<td><?php echo ($data["pidname"]); ?></td>
    <td><?php echo ($data["levelname"]); ?></td>
    <td><?php if(($data["status"]) == "1"): ?><img src="__PUBLIC__/admin/images/ok.png"/><?php else: ?><img src="__PUBLIC__/admin/images/no.png"/><?php endif; ?></td>
    <td><input type="hidden" name="idord[]" value="<?php echo ($data["id"]); ?>"/><input name="nodeord[]" id="order_<?php echo ($data["id"]); ?>" value="<?php echo ($data["sort"]); ?>" style="width:25px" type="text"/></td>
	<!--<td>
		<a href="__URL__/edit/arcid/<?php echo ($data["arcid"]); ?>"><img src='__PUBLIC__/admin/images/gtk-edit.png' title="修改" alt="修改" width='16' height='16' /></a>
        
	</td>-->
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<tr bgcolor="#ffffff">
<td height="36" colspan="8" align="right">
	&nbsp;
	<!--<a href="javascript:selOrNoSel('id[]')" class="coolbg">全选/反选</a>-->
     <input type="submit" value="更新排序" onclick="document.form1.action='__URL__/updateord'"/>
    <!--<input type="submit" value="审核" onclick="document.form1.action='__URL__/check'"/>
	<input type="submit" value="删除" onclick="del('__URL__/del','form1')"/>-->
</td>
</tr>

<tr align="right" bgcolor="#F9FCEF">
	<td height="36" colspan="8" align="center" id="pages">
		<?php echo ($page); ?>
	</td>
</tr>
</table>
</form>
<!--  搜索表单  -->
<form name='form2' method='post' id="form2" action="__URL__/index">
<input type="hidden" name="search" value="search"/>
<table width='98%'  border='0' cellpadding='1' cellspacing='1' bgcolor='#cfcfcf' align="center" style="margin-top:8px">
  <tr bgcolor='#EEF4EA'>
    <td background='__PUBLIC__/admin/images/wbg.gif' align='center'>
      <table border='0' cellpadding='0' cellspacing='0' height="32">
        <tr>
          <td width='160'>
          <select name='level' style='width:150px'>
          <option value='0' <?php if($sellevel == '') echo "selected" ?>>选择级别...</option>
           <option value='1' <?php if($sellevel == 1) echo "selected" ?>>项目</option>
            <option value='2' <?php if($sellevel == 2) echo "selected" ?>>模块</option>
             <option value='3' <?php if($sellevel == 3) echo "selected" ?>>操作</option>	
          </select>
        </td >
        <td nowrap>
          关键字：
        </td>
        <td width='130'>
          	<input type='text' name='keysearch' style='width:120px' value="<?php echo ($searchkey); ?>"/>
        </td>
       <td>
          <input type="image" src="__PUBLIC__/admin/images/button_search.gif" width="60" height="22" border="0" class="np" />
       </td>
      </tr>
     </table>
   </td>
  </tr>
</table>
</form>

</body>
</html>