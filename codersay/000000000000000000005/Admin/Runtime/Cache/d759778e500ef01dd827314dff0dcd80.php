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
    return document.myform.action='?m=Blog&a=act&action=delete';
	
  }else{
   return false;
  }
} 
</script>
<body>
<div class="location">
   <span>当前位置:常用操用&nbsp;>&nbsp;博客管理</span>
 </div>
<div class="main">
 <div class="tags">
    <a href="__URL__/index"  target="main" title="管理列表" class="main_select"><span>管理列表</span></a>|
   <a href="__URL__/insert" target="main" title="添加内容">添加内容</a>
   <div class="line"/></div>
</div>
<div id="search">
   <table width="100%" cellspacing="0" class="search-form">
    <tbody>
	  <tr>
		<td>
		<div class="search">
		<form action="__URL__/index" method="POST">
             所属栏目:
            <select name="catid" onChange="document.all.dosubmit.click()">
			<option value="0">请选择栏目</option>
			<?php if(is_array($catlist)): $i = 0; $__LIST__ = $catlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i; if($catid == $cat['colId']): ?><option value="<?php echo ($cat['colId']); ?>" selected>
				<?php echo ($cat['space']); echo ($cat['colTitle']); ?>
			</option>
			<?php else: ?>
			
            <option value="<?php echo ($cat['colId']); ?>">
				<?php echo ($cat['space']); echo ($cat['colTitle']); ?>
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
    <form name=myform  method="POST">
    <table width="100%" cellspacing="0" style="font-size:12px;">
        <thead>
            <tr>
            <th width="50" align="center">选取</th>
			<th align="center">排序</th>
			<th align="center">ID</th>
			<th align="center">标题</th>
			<th  align="center">审核状态</th>	
			<th  align="center">点击量</th>												
			<th align="center">发布人</th>
			<th  align="center">更新时间</th>
			<th  align="center">管理操作</th>			
			
            </tr>
        </thead>
    <tbody> 
     <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
	<td align="center"><input type="checkbox" name="id[]" value="<?php echo ($vo['id']); ?>" id="id"></td>	
	<td align="center"><input type=hidden name="ids[]" value="<?php echo ($vo['id']); ?>"><input type="text" name="ord[]" size="1" value="<?php echo ($vo['ord']); ?>"></td>
	<td align="center"><?php echo ($vo['id']); ?></td>
	<td align="center"><a title="<?php echo ($vo['title']); ?>" href="<?php echo (C("rooturl")); ?>blog/<?php echo ($vo['id']); ?>.html" target="blank"><?php if(($vo['posid'] == 1)): echo ($vo['title']); ?> &nbsp;<img src="__PUBLIC__/admin/images/small_elite.gif" border="0" alt="推荐" style="cursor : pointer;width:17px;height:16px;" /><?php else: echo ($vo['title']); endif; ?></a></td>
	<td align="center"><?php if(($vo['status'] == 1)): ?><span style="color:green">√</span><?php else: ?>ㄨ<?php endif; ?></td>
	<td align="center"><?php echo ($vo['hits']); ?></td>		
	<td align="center"><?php echo ($vo['username']); ?></td>
	<td align="center"><?php echo (date("Y-m-d H:i:s",$vo['inputtime'])); ?></td>
	<td align="center"> <a href="__URL__/edit/id/<?php echo ($vo['id']); ?>">修改</a>| <a href="__APP__/Comment/index/bid/<?php echo ($vo['id']); ?>">评论</a></td>	
	</tr><?php endforeach; endif; else: echo "" ;endif; ?>	
  </tbody>
 </table>
	<div class="btn" style="font-size:12px;">
    <label for="check_box" id ="CheckedRev">
    <a href="javascript:selAll()" class="coolbg">全选</a>&nbsp;
	<a href="javascript:noSelAll()" class="coolbg">取消</a> 
    </label> &nbsp;&nbsp; 
       
          移动到：<select name="catid"">
			<option value="0">请选择栏目</option>
			<?php if(is_array($catlist)): $i = 0; $__LIST__ = $catlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i; if($catid == $cat['colId']): ?><option value="<?php echo ($cat['colId']); ?>" selected><?php echo ($cat['space']); echo ($cat['colTitle']); ?></option>							
			<?php else: ?>			
              <option value="<?php echo ($cat['colId']); ?>"><?php echo ($cat['space']); echo ($cat['colTitle']); ?></option><?php endif; endforeach; endif; else: echo "" ;endif; ?>
		  </select>
         <input type="submit" name="act" value="移动" class="coolbg" onClick="document.myform.action='?m=Blog&a=act&action=move';"/>&nbsp;
        <input type="submit" name="act" value="推荐" class="coolbg" onClick="document.myform.action='?m=Blog&a=act&action=posid';"/>&nbsp;
		<input type="submit" name="act" value="审核" class="coolbg" onClick="document.myform.action='?m=Blog&a=act&action=check';"/>&nbsp;
		<input type="submit" name="act" value="排序" class="coolbg" onClick="document.myform.action='?m=Blog&a=act&action=order';"/>&nbsp;
        <input type="submit" name="act" value="删除" class="coolbg" onClick="delet()"/>
        &nbsp;&nbsp;
	   </div>
</form>
</div>
<div id="pages"> <?php echo ($page); ?></div>
</div>
</body>
</html>