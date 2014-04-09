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
    return document.myform.action='?m=Banner&a=act&action=delete';
	
  }else{
   return false;
  }
} 
</script>
<style type="text/css"> 
<!-- 
.subnav{
	 /*padding:10px;*/
	 border-style: solid;
     border-bottom-width: 3px;
	 border-bottom-color:#EEEEEE;  
}.subnav h2{ margin-bottom:6px}
--> 
</style> 

<body>
<div class="location">
    <span>当前位置:模块管理&nbsp;>&nbsp;广告管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>|
   <a href="__URL__/insert" target="main" title="添加广告">添加广告</a>
   <div class="line"/></div>
</div>
<div class="table-list">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
			<th align="center">排序</th>
			<th align="center">ID</th>
			<th align="center">名称</th>	
            <th align="center">链接地址</th>										
			<th align="center">发布人</th>
			<th  align="center">更新时间</th>
			<th  align="center">管理操作</th>			
			
            </tr>
        </thead>
    <tbody> 
       <form name="myform"  id="myform" method="POST">
           <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
	<td align="center"><input type=hidden name="ids[]" value="<?php echo ($vo['id']); ?>"><input type="text" name="ord[]" size="1" value="<?php echo ($vo['ord']); ?>"></td>
	<td align="center"><?php echo ($vo['id']); ?></td>
	<td align="center"><?php echo ($vo['name']); ?></td>	
    <td align="center"><?php echo ($vo['url']); ?></td>	
	<td align="center"><?php echo ($vo['username']); ?></td>
	<td align="center"><?php echo (date("Y-m-d H:i:s",$vo['inputtime'])); ?></td>
	<td align="center"> <a href="__URL__/edit/id/<?php echo ($vo['id']); ?>">修改</a>
    </td>	
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
       <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label> &nbsp;&nbsp;   
         <input type="submit" name="act" value="推荐" class="coolbg" onClick="document.myform.action='?m=Banner&a=act&action=posid';"/>&nbsp;
		<input type="submit" name="act" value="审核" class="coolbg" onClick="document.myform.action='?m=Banner&a=act&action=check';"/>&nbsp;
		<input type="submit" name="act" value="排序" class="coolbg" onClick="document.myform.action='?m=Banner&a=act&action=order';"/>&nbsp;
        <input type="submit" name="act" value="删除" class="coolbg" onClick="delet()"/>
        &nbsp;&nbsp;
	   </div>
</form>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>