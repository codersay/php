<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "/www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="/www.w3.org/1999/xhtml">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="__PUBLIC__/admin/style/base.css" type="text/css" />
<script type="text/javascript" language="javascript" src="__PUBLIC__/common/jquery/jquery.js"></script>
<script type="text/javascript" language="javascript" src="__PUBLIC__/admin/js/common.js"></script>
</head>
<body leftmargin="8" topmargin="8" background='__PUBLIC__/admin/images/allbg.gif'>
  

<form name="form1" id="form">
<table width="98%" border="0" cellpadding="2" cellspacing="1" bgcolor="#CFCFCF" align="center" style="margin-top:8px">
<tr bgcolor="#E7E7E7" >
	<td height="28" colspan="8" background="__PUBLIC__/admin/images/tbg.gif" style="padding-left:10px;">
	<strong>评论管理</strong>
	</td>
</tr>
<tr align="center" bgcolor="#FBFCE2" height="25">
	<td width="6%">ID</td>
	<!--<td width="4%">选择</td>-->
	<td width="10%">博文标题</td>
	<td width="20%">内容</td>
	<td width="8%">发布人</td>
    <td width="15%">评论时间</td>
    <td width="10%">IP</td>
    <td width="8%">回复状态</td>
	<td width="10%">操作</td>
</tr>
<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr align='center' bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';" onMouseOut="javascript:this.bgColor='#FFFFFF';">
	<td>
    	<?php echo ($data["id"]); ?>
	</td>
	<!--<td>
		<input name="comment[]" type="checkbox" id="commentid" value="<?php echo ($data["id"]); ?>" class="np" />
	</td>-->
	<td>
   		<?php echo ($data["title"]); ?>
	</td>
	<td title="<?php echo ($data["fullcontent"]); ?>"><?php echo ($data["content"]); ?></td>
	<td><?php echo ($data["writer"]); ?></td>
    <td><?php echo (date("Y-m-d H:i:s",$data["time"])); ?></td>
    <td><?php echo ($data["ip"]); ?></td>
    <td><?php if(($data["ischeck"]) == "1"): ?><img src="__PUBLIC__/admin/images/ok.png"/><?php else: ?><img src="__PUBLIC__/admin/images/no.png"/><?php endif; ?></td>
	<td>
    <a href="__GROUP__/Comment/reply/id/<?php echo ($data["id"]); ?>"><img src="__PUBLIC__/admin/images/reply.png" title="回复" alt="回复"></a>
    <a href="__URL__/del/id/<?php echo ($data["id"]); ?>"><img src="__PUBLIC__/admin/images/gtk-del.png" title="删除" alt="删除"></a>
    <!--<a href="#"><img src="__PUBLIC__/admin/images/pass.png" title="审核" alt="审核"></a>-->
	</td>
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<!--<tr bgcolor="#ffffff">
<td height="36" colspan="10">
	&nbsp;
	<a href="javascript:selOrNoSel('comment[]')" class="coolbg">全选/反选</a>
    <input type="submit" value="审核" onclick="document.form1.action='__URL__/check'"/>
	<input type="submit" value="删除" onclick="del('__URL__/del','form1')"/>
</td>
</tr>-->

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
          <select name='colid' style='width:150px'>
          <option value='0'>选择栏目...</option>
          	<?php echo ($collist); ?>
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