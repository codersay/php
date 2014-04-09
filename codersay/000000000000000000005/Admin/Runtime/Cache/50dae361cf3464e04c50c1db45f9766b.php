<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>『wblog博客管理平台』<?php echo (THINK_VERSION); ?></title>
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css" />

 <script language="javascript">

function selAll()
{
	for(i=0;i<document.myform.id.length;i++)
	{
		if(!document.myform.id[i].checked)
		{
			document.myform.id[i].checked=true;
		}
	}
}
function noSelAll()
{
	for(i=0;i<document.myform.id.length;i++)
	{
		if(document.myform.id[i].checked)
		{
			document.myform.id[i].checked=false;
		}
	}
}
</script>
</head>
 <script language="Javascript">
function delet()
{
  if(confirm("确定删除该记录吗?")){
    return document.myform.action='?m=Comment&a=act&action=delete';
	
  }else{
   return false;
  }
} 
</script>
<body>
<div class="location">
   <span>当前位置:模块管理&nbsp;>&nbsp;评论管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="文章评论" class="main_select"><span>文章评论</span></a>|
   <a href="__URL__/bindex" target="main" title="博客评论">博客评论</a>
   <div class="line"/></div>
</div>
<div class="table-list">
   <form name="myform"  id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
			<th align="left">发布人</th>
			<th align="left">评论</th>
			<th  width="150" align="center">主题</th>											
			<th   width="60" align="center">管理操作</th>			
			
            </tr>
        </thead>
    <tbody> 
     <?php if(is_array($commentlist)): $i = 0; $__LIST__ = $commentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr <?php if($vo['tousername'] == ''): ?>style="background-color:#FBFFE4;"<?php endif; ?>>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
	<td align="left"><div style="width:150px;"><div style="height:50px;float:left; margin-right: 10px;"><img src="__PUBLIC__/admin/images/visitor.png" title="visitor" alt="wblog" width="32" height="32" border="0"/></div><b><?php echo (msubstr($vo['username'],0,10)); ?></b><br/>fdsf@qq.com</div></td>
	<td align="left"><li style="float:left;width:300px;">提交于<?php echo (date("Y-m-d H:i:s",$vo['inputtime'])); if($vo['tousername'] != ''): ?>&nbsp;|&nbsp;回复给&nbsp;<?php echo ($vo['tousername']); endif; ?></li><div style="float:left;width:300px;"><?php echo (msubstr($vo['content'],0,50)); ?></div></td>
	<td align="center"><?php echo ($vo['title']); ?></td>
	<td align="center">
   <?php if($vo['Reply'] != ''): ?><a href="__URL__/reply/id/<?php echo ($vo['id']); ?>">已回复</a>
	 <?php else: ?>
    <a href="__URL__/reply/id/<?php echo ($vo['id']); ?>">回复</a>|<a href="__URL__/edit/id/<?php echo ($vo['id']); ?>">编辑</a><?php endif; ?>	                 				                      			  
    </td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
      <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label> &nbsp;&nbsp;           
       <input type="submit" name="act" value="审核" class="coolbg" onClick="document.myform.action='?m=Comment&a=act&action=check';"/>&nbsp;
        <input type="submit" name="act" value="删除" class="coolbg" onClick="delet()"/>&nbsp;
		
        &nbsp;&nbsp;
	   </div>
</form>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>