<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="/Tpl/default/Admin/css/common.css" type="text/css" />
<title>管理区域</title>
</head>

<body>
<div id="man_zone2">
  <table width="99%" border="0" align="center"  cellpadding="3" cellspacing="1" class="table_style">
    <caption>日志列表</caption>
	<tr>
	  <th width="5%" align="center"><span class="left-title">编号</span></th>
	  <th width="10%" align="center"><span class="left-title">分类</span></th>
	  <th width="25%" align="center"><span class="left-title">标题</span></th>
	  <th width="15%" align="center"><span class="left-title">添加时间</span></th>
	  <th width="15%" align="center"><span class="left-title">最后更新时间</span></th>
	  <th width="10%" align="center"><span class="left-title">浏览次数</span></th>
	  <th width="10%" align="center">是否置顶</th>
      <th width="10%" align="center">管理项</th>
    </tr>
	<?php if(is_array($postList)): $i = 0; $__LIST__ = $postList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><tr>
	  <td width="5%" align="center"><span class="left-title"><?php echo ($vo["id"]); ?></span></td>
	  <td width="10%" align="center"><span class="left-title"><?php echo ($vo["ctgName"]); ?></span></td>
	  <td width="25%" align="center"><span class="left-title"><?php echo ($vo["title"]); ?></span></td>
	  <td width="15%" align="center"><span class="left-title"><?php echo ($vo["create_time"]); ?></span></td>
	  <td width="15%" align="center"><span class="left-title"><?php echo ($vo["update_time"]); ?></span></td>
	  <td width="10%" align="center"><?php echo ($vo["hits"]); ?></td>
	  <td width="10%" align="center"><?php echo ($vo["show_top"]); ?></td>
      <td width="10%" align="center"><a href="/Admin/Post/editPost/id/<?php echo ($vo["id"]); ?>/p/<?php echo ($currentpage); ?>">修改</a> <a href="/Admin/Post/delPost/id/<?php echo ($vo["id"]); ?>/p/<?php echo ($currentpage); ?>" onclick="return confirm('确定删除该条记录吗？');">删除</a></td>
    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	<tr>
	  <td colspan="8" height="30" id="pager"><?php echo ($page); ?></td>
	</tr>
  </table>
</div>
</body>
</html>