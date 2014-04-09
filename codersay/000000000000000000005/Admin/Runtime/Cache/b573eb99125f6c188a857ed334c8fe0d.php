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
<body>
<div>
    <div class="location">
   <span>当前位置:常用操用&nbsp;>&nbsp;博管管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" >管理列表</a>|
   <a href="__URL__/insert" target="main" title="添加内容" class="main_select"><span>添加内容</span></a>
   <div class="line"/></div>
</div>
<div class="table-list">
     <form name="myform" action="__URL__/add" method="POST"  id="myform" enctype="multipart/form-data">
    <table width="100%" cellspacing="0" style="font-size:12px;">
       <tbody>
            <tr>
            <td width="50" align="center">栏目:</td>
            <td align="left">
            <select name="catid" id="catid">
             <option value="0">所属栏目</option>
			     <?php if(is_array($catlist)): $i = 0; $__LIST__ = $catlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat['colId']); ?>"><?php echo ($cat['space']); echo ($cat['colTitle']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
            </td>	
            </tr>
            <tr>
            <td width="50" align="center">标题：</td>
            <td align="left">
            <input type="text" name="title" id="title" class="required" size="50">
            </td>	
            </tr>
            <tr>
            <td width="50" align="center">关键词：</td>
            <td align="left">
           <input type="text" name="keywords" size="50">
            </td>	
            </tr>
             <tr>
            <td width="50" align="center">缩略图：</td>
            <td align="left">
          <input  type="file" name="thumb" id="thumb"/>
            </td>	
            </tr>
             <tr>
            <td width="50" align="center">描述：</td>
            <td align="left">
           <textarea name="description" rows="3" cols="60"></textarea>
            </td>	
            </tr>
             <tr>
            <td width="50" align="center">内容：</td>
            <td align="left">
           <textarea name="content" id="content"  style="width:800px;height:250px;visibility:hidden;" class="required"></textarea>
            </td>	
            </tr>
             <tr>
            <td width="50" align="center"></td>
            <td align="left">
            推荐：<input type="checkbox" name="posid" value="1">
            </td>	
            </tr>
       </tbody>
    
 </table>
	<div class="btn" style="font-size:12px;">
          <input type="submit" value="提交" id="send" class="button" style="margin-left: 450px;">&nbsp;&nbsp;
		 <input  type="button" onClick="history.back()" class="button" value="取 消" alt="取消" />
	   </div>
</form>
</div>
</div>
</div>
</body>
</html>