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
   <span>当前位置:模块管理&nbsp;>&nbsp;Widget工具</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>
   <div class="line"/></div>
</div>
<div class="table-list">
 <form action="__URL__/save" method="post">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>		
			<th align="left">Widget名称</th>
            <th align="left">说明</th>	
			<th align="left">设置显示项数</th>										
			<th   width="150" align="center">在前台模板的调用方法</th>			
			
            </tr>
        </thead>
    <tbody>   
	<tr style="background-color:#FBFFE4;">
	
	<td align="left">Hot</td>
    <td align="left">调用文章热点排行列表</td>
	<td align="left"><input type="text" name="hot" class="inputthumb" value="<?php echo (C("hot")); ?>" /></td>
	<td align="center">
   &#123;:W&#40;'Hot'&#41;&#125;       				                      			  
    </td>
	</tr>
	<tr style="background-color:#FBFFE4;">
	
	<td align="left">Rand</td>
    <td align="left">调用文章随机列表</td>
	<td align="left"><input type="text" name="rand" class="inputthumb" value="<?php echo (C("rand")); ?>" /></td>
	<td align="center">
   &#123;:W&#40;'Rand'&#41;&#125;       				                      			  
    </td>
	</tr>
   
	<tr style="background-color:#FBFFE4;">
	
	<td align="left">Tags</td>
    <td align="left">分类标签</td>
	<td align="left"><input type="text" name="rand" class="inputthumb" value="<?php echo (C("tags")); ?>" /></td>
	<td align="center">
   &#123;:W&#40;'Tags'&#41;&#125;     				                      			  
    </td>
	</tr>
    <tr style="background-color:#FBFFE4;">
	
	<td align="left">Newscomments</td>
    <td align="left">调用最新评论</td>
	<td align="left"><input type="text" name="rand" class="inputthumb" value="<?php echo (C("newscomments")); ?>" /></td>
	<td align="center">
   &#123;:W&#40;'Newscomments'&#41;&#125;       				                      			  
    </td>
	</tr>
    <tr style="background-color:#FBFFE4;">
	
	<td align="left">Date</td>
    <td align="left">调用文章日期归档</td>
	<td align="left"></td>
	<td align="center">
   &#123;:W&#40;'Date'&#41;&#125;       				                      			  
    </td>
	</tr>
     <tr style="background-color:#FBFFE4;">
	
	<td align="left">Link</td>
    <td align="left">调用友情链接</td>
	<td align="left"></td>
	<td align="center">
   &#123;:W&#40;'Link'&#41;&#125;       				                      			  
    </td>
	</tr>
     <tr style="background-color:#FBFFE4;">
	
	<td align="left">Cate</td>
    <td align="left">调用文章分类</td>
	<td align="left"></td>
	<td align="center">
   &#123;:W&#40;'Cate'&#41;&#125;        				                      			  
    </td>
	</tr>
    <tr style="background-color:#FBFFE4;">
	
	<td align="left">Nav</td>
    <td align="left">调用导航菜单</td>
	<td align="left"></td>
	<td align="center">
   &#123;:W&#40;'Nav'&#41;&#125;        				                      			  
    </td>
	</tr>
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
   &nbsp;&nbsp;   
		<input type="hidden" name="file" value="widgetconfig.inc.php" />
        <input type="submit" value="更新配置" id="send" class="button" style="margin-left: 20px;">
		
	   </div>
</form>
</div>
<div> &nbsp;&nbsp;  &nbsp;&nbsp;  widget工具的使用方法，把相应的widget工具的调用方法复制到前台的模板上即可</div>
</div>
</body>
</html>