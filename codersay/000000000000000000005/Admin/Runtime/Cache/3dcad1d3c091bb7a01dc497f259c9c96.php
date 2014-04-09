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
<body>
<div class="location">
   <span>当前位置:常用操作&nbsp;>&nbsp;标签管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>
   <div class="line"/></div>
</div>
<div class="table-list">
     <form name="myform" action="__URL__/act" id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            
			<th width="50" align="center">选取</th>
			<th align="center">ID</th>
            <th align="center">标签名称</th>
													
			<th align="center">所属模型</th>
			
			<th  align="center">管理操作</th>			
			
            </tr>
        </thead>
    <tbody> 
       <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
	<td align="center"><?php echo ($vo['id']); ?></td>
	<td align="center"><a href="<?php echo (C("rooturl")); ?>web/tag/name/<?php echo (urlencode($vo['name'])); ?>"><span style="font-size:{16|getTitleSize};color:<?php echo (rand_color($vo['id'])); ?>">&nbsp;&nbsp;<?php echo ($vo['name']); ?>[<?php echo ($vo['count']); ?>]</span></a></td>

    <td align="center"><?php echo ($vo['module']); ?></td>

	<td align="center"> 
    <a  href="__URL__/del/id/<?php echo ($vo['id']); ?>" onClick="return confirm('确定删除该标签吗?')">删除</a>   
      
    </td>	
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
      <label for="check_box" id ="CheckedRev">
       <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	   <a href="javascript:noSelAll()" class="coolbg">取消</a> 
       </label> &nbsp;&nbsp;
     <input type="submit" name="act" value="删除" class="coolbg" onClick="return confirm('确定删除该记录吗?')"/>
	   
</form>
</div>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>