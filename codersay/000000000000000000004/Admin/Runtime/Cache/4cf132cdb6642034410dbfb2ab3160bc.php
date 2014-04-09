<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="__PUBLIC__/admin/style/base.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
</head>
<body leftmargin="8" topmargin="8" background='__PUBLIC__/admin/images/allbg.gif'>

<!--  快速转换位置按钮  -->
<table width="98%" border="0" cellpadding="0" cellspacing="1" bgcolor="#ccd9b9" align="center">
<tr>
 <td height="26" background="__PUBLIC__/admin/images/newlinebg3.gif">
  <table width="98%" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td align="center">
  <input type='button' class="coolbg np" onClick="location='__URL__/add'" value='添加博文' />
	<input type='button' class="coolbg np" onClick="location='__URL__/index'" value='全部博文' />
	<input type='button' class="coolbg np" onClick="location='__URL__/index/username/<?php echo ($uname); ?>'" value='我的博文' />
 </td>
 </tr>
</table>
</td>
</tr>
</table>
  
<!--  内容列表   -->
<form name="form1" id="form1" method="post">
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
<tr bgcolor="#E7E7E7" >
	<td height="28" colspan="11" background="__PUBLIC__/admin/images/tbg.gif" style="padding-left:10px;">
	<strong>博文列表</strong>
	</td>
</tr>
<tr align="center" bgcolor="#FBFCE2" height="25">
	<td width="6%">ID</td>
	<td width="4%">选择</td>
	<td width="18%">文章标题</td>
	<td width="15%">更新时间</td>
	<td width="10%">分类</td>
	<td width="8%">点击</td>
	<td width="8%">发布人</td>
    <td width="5%">评论</td>
    <td width="5%">排序</td>
    <td width="8%">审核状态</td>
	<td width="10%">操作</td>
</tr>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align='center' bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
	<td nowrap>
    	<?php echo ($data["arcid"]); ?>
	</td>
	<td>
		<input name="arcid[]" type="checkbox" id="arc_<?php echo ($data["arcid"]); ?>" value="<?php echo ($data["arcid"]); ?>" class="np" />
	</td>
	<td align="left">
   		<span id="id">
			<a href='__URL__/edit/arcid/<?php echo ($data["arcid"]); ?>'>
				<u><?php echo ($data["title"]); echo ($data["hc"]); ?></u>
			</a>
		</span>	
	</td>
	<td><?php echo (date("Y-m-d H:i:s",$data["updatetime"])); ?></td>
	<td><a href='__URL__/index/colid/<?php echo ($data["colid"]); ?>'><?php echo ($data["colname"]); ?></a></td>
	<td><?php echo ($data["click"]); ?></td>
	<td><?php echo ($data["username"]); ?></td>
    <td><?php echo ($data["comnum"]); ?></td>
    <td><input type="hidden" name="arcidord[]" value="<?php echo ($data["arcid"]); ?>"/><input name="arcorder[]" id="order_<?php echo ($data["arcid"]); ?>" value="<?php echo ($data["ord"]); ?>" style="width:25px" type="text"/></td>
    <td><?php if(($data["ischeck"]) == "1"): ?><img src="__PUBLIC__/admin/images/ok.png"/><?php else: ?><img src="__PUBLIC__/admin/images/no.png"/><?php endif; ?></td>
	<td>
		<a href="__URL__/edit/arcid/<?php echo ($data["arcid"]); ?>"><img src='__PUBLIC__/admin/images/gtk-edit.png' title="修改" alt="修改" width='16' height='16' /></a>
        <!--<img src='__PUBLIC__/admin/images/file_del.gif' title="删除" alt="删除" onClick="" style='cursor:pointer' border='0' width='16' height='16' />
        <img src='__PUBLIC__/admin/images/pass.png' title="审核" alt="审核" onClick="" style='cursor:pointer' border='0' width='16' height='16' />-->
	</td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<tr bgcolor="#ffffff">
<td height="36" colspan="11" align="right">
	&nbsp;
	<a href="javascript:selOrNoSel('arcid[]')" class="coolbg">全选/反选</a>
	<!--<input type="submit" value="推荐" onclick="document.form1.action='__URL__/recommend'"/>-->
    <input type="submit" value="审核" onclick="document.form1.action='__URL__/check'"/>
	<input type="submit" value="删除" onclick="del('__URL__/del','form1')"/>
    <input type="submit" value="更新排序" onclick="document.form1.action='__URL__/updateord'"/>
    移动到：<select name='colid1' style='width:150px' id="colid1">
          <option value='0' selected="selected">选择栏目...</option>
          	<?php echo ($collist); ?>
          </select>
          <input type="submit" value="移动" onclick="document.form1.action='__URL__/move'"/>
</td>
</tr>

<tr align="right" bgcolor="#F9FCEF">
	<td height="36" colspan="11" align="center" id="pages">
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
          <select name='colid2' style='width:150px' id="colid2">
          <option value='0' selected="selected">选择栏目...</option>
          	<?php echo ($collist2); ?>
          </select>
        </td >
        <td nowrap>
          关键字：
        </td>
        <td width='130'>
          	<input type='text' name='keysearch' style='width:120px' value="<?php echo ($searchkey); ?>"/>
        </td>
       <td>
          <input name="imageField" type="image" src="__PUBLIC__/admin/images/button_search.gif" width="60" height="22" border="0" class="np" />
       </td>
      </tr>
     </table>
   </td>
  </tr>
</table>
</form>

</body>
</html>