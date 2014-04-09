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
    <span>当前位置:系统管理&nbsp;>&nbsp;数据备份</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="数据库备份" class="main_select"><span>数据库备份</span></a>|
   <a href="__URL__/import" target="main" title="数据库还原">数据库还原</a>
   <div class="line"/></div>
</div>
<div class="table-list">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
			<th align="center">ID</th>
			<th align="center">数据表</th>	
            <th align="center">大小</th>	
            <th align="center">编码类型</th>
            <th align="center">引擎类型</th>		
            <th align="center">创建时间</th>		
            </tr>
        </thead>
    <tbody> 
      <form name="myform" id="myform" method="post" action="__URL__/export">
       
       <?php if(is_array($tbs)): $i = 0; $__LIST__ = $tbs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$tb): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($tb['name']); ?>" id="id"></td>	
	<td align="center"><?php echo ($tb['id']); ?></td>
	<td align="center"><?php echo ($tb['name']); ?></td>
    <td align="center"><?php echo ($tb['data_length']); ?></td>
    <td align="center"><?php echo ($tb['collation']); ?></td>
    <td align="center"><?php echo ($tb['engine']); ?></td>
     <td align="center"><?php echo ($tb['create_time']); ?></td>
    
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
     <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label> &nbsp;&nbsp;   
       <input class="button" type="submit" name="sub" value="备份" onClick="return Sub(this.form)" />
	   </div>
</form>
</div>
</div>
</div>
</body>
</html>