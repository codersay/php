<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>栏目管理</title>
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Js/jquery-1.4.3.min.js"></script>
</head>
<body>
<div class="location">
   <span>当前位置:常用操作&nbsp;>&nbsp;栏目管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>|
   <a href="__URL__/insert" target="main" title="添加栏目">添加栏目</a>
   <div class="line"/></div>
</div>
<div class="table-list">
   <form name="myform"  id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            
            <th align="center">排序</th>
            <th align="center">catid</th>
            <th align="center">栏目名称</th>
		    <th align="center">所属模型</th>
            <th align="center">数据量</th>
            <th align="center">管理操作</th>
            </tr>
        </thead>
    <tbody> 
     <?php if(is_array($catarray)): $i = 0; $__LIST__ = $catarray;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if(is_array($vo)): $i = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type=hidden name="ids[]" value="<?php echo ($sub['colId']); ?>"><input type="text" name="ord[]" size="1" value="<?php echo ($sub['ord']); ?>"></td>
	<td align="center"><?php echo ($sub['colId']); ?></td>
	<td align="left"><?php echo ($sub['space']); echo ($sub['colTitle']); ?></td>
	<td align="center"><?php echo ($sub['model']); ?></td>
    <td align="center">[<?php echo ($sub['total']); ?>]</td>
	<td align="center">
      <a href="__URL__/addcol/colId/<?php echo ($sub['colId']); ?>">添加子栏目</a>|<a href="__URL__/edit/colId/<?php echo ($sub['colId']); ?>">修改</a>|
	  <a href="__URL__/del/colId/<?php echo ($sub['colId']); ?>" onclick="return confirm('确定删除该记录吗?')">删除</a>
    </td>
	</tr><?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
	<input type="submit" name="act" style="margin-left: 45px;" value="排序" class="coolbg" onClick="document.myform.action='?m=Columns&a=act&action=order';"/>
	   </div>
</form>
</div>
</div>
</div>
</body>
</html>