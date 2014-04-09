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
    return document.myform.action='?m=Node&a=act&action=delete';
	
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
      <span>当前位置:用户管理&nbsp;>&nbsp;节点管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>|
   <a href="__URL__/insert" target="main" title="添加节点">添加节点</a>
   <div class="line"/></div>
</div>
<div class="table-list">
    <form name="myform"  id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
            <th align="center">排序</th>
			<th align="center">显示名称</th>
            <th align="center">应用名</th>
             <th align="center">上级节点</th>
             <th align="center">类型</th>
			<th align="center">状态</th>
            <th align="center">备注</th>
			<th align="center">管理操作</th>
					
			
            </tr>
        </thead>
    <tbody> 
     <?php if(is_array($Nodelist)): $i = 0; $__LIST__ = $Nodelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
    <td align="center"><input type=hidden name="ids[]" value="<?php echo ($vo['id']); ?>"><input type="text" name="ord[]" size="1" value="<?php echo ($vo['ord']); ?>"></td>
	<td align="center"><?php echo ($vo['title']); ?></td>
    <td align="center"><?php echo ($vo['name']); ?> </td>
    <td align="center"><?php echo ($vo['class']); ?> </td>
    <td align="center">
    <?php if($vo['level'] == 1): ?>项目
    <?php elseif($vo['level'] == 2): ?>模块
    <?php else: ?>操作<?php endif; ?>
     </td>
    <td align="center"><?php if(($vo['status'] == 1)): ?><span style="color:green;font-weight:bold;">√</span><?php else: ?>ㄨ<?php endif; ?></td>
	
    <td align="center"><?php echo ($vo['remark']); ?></td>
	<td align="center">
      <a href="__URL__/edit/id/<?php echo ($vo['id']); ?>">修改</a>
    </td>
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
   <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label> &nbsp;&nbsp;
        
         
       <input type="submit" name="act" value="排序" class="coolbg" onClick="document.myform.action='?m=Node&a=act&action=order';"/>&nbsp;
        <input type="submit" name="act" value="删除" class="coolbg" onClick="delet()"/>
        &nbsp;&nbsp;
	   </div>
</form>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>