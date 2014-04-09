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
   <span>当前位置：常用操用&nbsp;>&nbsp;模板管理 </span>
 </div>
<div>
 <div style="margin:10px;height:10px">
     <span style="font-size:12px;margin:10px;height:12px">  当前目录：<?php echo ($tpl_dir); ?></span>
     
    </div>
   
</div>


<div class="table-list">
     <form name="myform" action="__URL__/act" id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
			<th align="left">模块名称</th>							
            </tr>
        </thead>
    <tbody> 
       <?php if(is_array($tpldir)): $i = 0; $__LIST__ = $tpldir;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="left"><span style="float:left;"><img height="14" src="__PUBLIC__/admin/images/dir.gif" width="20" /></span><span style="float:left;margin-left:10px;"><a  href="__URL__/tpl/dir/<?php echo ($vo['tplname']); ?>" ><?php echo ($vo['tplname']); ?></a></span></td>
		
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
</form>
</div>
</div>
</div>
</body>
</html>