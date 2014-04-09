<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>『WBlog博客管理平台』<?php echo (THINK_VERSION); ?></title>
<link href="__PUBLIC__/admin/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__PUBLIC__/Js/jquery-1.4.3.min.js"></script>
<?php if($tpl != 'index'): ?><script language="javascript" type="text/javascript" src="__PUBLIC__/Js/formvalidator.js" charset="UTF-8"></script>
<script charset="UTF-8" src="__PUBLIC__/kindeditor/kindeditor-min.js"></script>
<script charset="UTF-8" src="__PUBLIC__/kindeditor/lang/zh_CN.js"></script>
<script>
	var editor;
	KindEditor.ready(function(K) {
	editor = K.create('textarea[name="content"]', {
				cssPath : '__PUBLIC__/kindeditor/plugins/code/prettify.css',
					 allowFileManager : true
				});
            });
</script>
<script type="text/javascript">
$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#modelid").formValidator({onshow:"请选择模型",onfocus:"请选择模型"}).inputValidator({min:1,max:50,onerror:"请选择模型"});
	$("#catid").formValidator({onshow:"请选择栏目",onfocus:"请选择栏目"}).inputValidator({min:1,max:50,onerror:"请选择栏目"});
	$("#title").formValidator({onshow:"标题不能为空",onfocus:"标题不能为空"}).inputValidator({min:1,max:50,onerror:"标题不能为空"});
	
	
});
</script>
<?php else: ?>
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
</script><?php endif; ?>
</head>
<script language="Javascript">
function delet()
{
  if(confirm("确定删除该记录吗?")){
    return document.myform.action='?m=Attach&a=act&action=delete';
	
  }else{
   return false;
  }
} 
</script>
<body>
<div class="location">
   <span>当前位置:常用操作&nbsp;>&nbsp;
  <?php if($modules == 'News'): ?>附件管理&nbsp;>&nbsp;文章图片
        <?php elseif($modules == 'Download'): ?>
        附件管理&nbsp;>&nbsp;下载附件
        <?php else: ?>
          >>上传附件<?php endif; ?> 
   </span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>|
   <a href="<?php echo U('/Attach/add/',array('module'=>$modules,'id'=>$recordId));?>" target="main" title="添加图片"><?php if(($modules == 'News') and ($recordId != '0')): ?>添加图片
   <?php elseif(($modules == 'Download') and ($recordId != '0')): ?>添加附件<?php endif; ?></a>
   <div class="line"/></div>
</div>
<div id="search">
   <table width="100%" cellspacing="0" class="search-form">
    <tbody>
	  <tr>
		<td>
		<div class="search">
		<form action="__URL__/index" method="POST">
             所属模型:
            <select name="module" onChange="document.all.dosubmit.click()">
			<option value="p">请选择模型</option>
			<?php if(is_array($Modelist)): $i = 0; $__LIST__ = $Modelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mo): $mod = ($i % 2 );++$i; if($modules == $mo['module']): ?><option value="<?php echo ($mo['module']); ?>" selected>
				<?php echo ($mo['module']); ?>
			</option>
			<?php else: ?>
			
            <option value="<?php echo ($mo['module']); ?>">
				<?php echo ($mo['module']); ?>
			</option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		  </select>	
		
          <input  type="submit"  name='dosubmit' class="button" value="搜索" />
           </form>
		</div>
		</td>
	 </tr>
    </tbody>
  </table>
</div>

<div class="table-list">
    <form name="myform"  id="myform" method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
			
			<th align="center">ID</th>
            <th align="center">附件名称</th>
			<th align="center">保存名称</th>
			<th  align="center">所属文章</th>	
			<th  align="center">附件大小</th>												
			<th align="center">所属模型</th>
			<th  align="center">上传时间</th>	
            </tr>
        </thead>
    <tbody> 
       <?php if(is_array($Attachlist)): $i = 0; $__LIST__ = $Attachlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
	<td align="center"><?php echo ($vo['id']); ?></td>
	<td align="center"><?php echo ($vo['name']); ?></td>
	<td align="center"><a href="__PUBLIC__/Uploads/File/<?php echo ($vo['savename']); ?>"><?php echo ($vo['savename']); ?></a></td>
	<td align="center"><?php echo ($vo['title']); ?></td>		
	<td align="center"><?php echo (sizecount($vo['size'])); ?></td>
    <td align="center"><?php echo ($vo['module']); ?></td>
	<td align="center"><?php echo (date("Y-m-d H:i:s",$vo['uploadTime'])); ?></td>	
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
    <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label>  &nbsp;&nbsp;     
        <input type="submit" name="act" value="删除" class="coolbg" onClick="delet()"/>&nbsp;
        <input  type="button" onClick="history.back()" class="button" style="margin-left: 400px;" value="返回" alt="返回" />	
        &nbsp;&nbsp;
	   </div>
</form>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>