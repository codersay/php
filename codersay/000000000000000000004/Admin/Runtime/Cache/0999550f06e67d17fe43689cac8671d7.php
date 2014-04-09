<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<base target="_self" />
<link rel="stylesheet" href="__PUBLIC__/admin/style/base.css" type="text/css" />
<link href="__PUBLIC__/admin/style/main.css" rel="stylesheet" type="text/css" />
<link href="__PUBLIC__/admin/style/style.css" rel="stylesheet" type="text/css" />


</head>
<body leftmargin="8" topmargin='8' bgcolor="#FFFFFF">
<div style="min-width:780px">
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>
     <div style='float:left'>
     	欢迎使用个人博客系统【RUIBlog1.0.0】
     </div>
     <div id='' style='float:right;padding-right:8px;'>
         <!--  //保留位置（顶右）  -->
     </div>
   </td>
  </tr>
  <tr>
    <td height="1" background="__PUBLIC__/admin/images/sp_bg.gif" style='padding:0px'></td>
  </tr>
</table>
<div id="__testEvn"></div>
<div id='mainmsg'>
<!--左侧开始--> 
  <div class="column" id="column1">
  		<!--快捷操作开始-->
        <dl class='dbox' id="item3">   
            <dt class='lside'>
                <div class='l'>快捷操作</div>
            </dt>
            <dd>
                <div id='quickmenu'>
                    <div class='icoitem' style='background:url("__PUBLIC__/admin/images/addnews.gif") 10px 3px no-repeat;'><a href='__GROUP__/Article/index'>博文列表</a></div>
                    <div class='icoitem' style='background:url("__PUBLIC__/admin/images/manage1.gif") 10px 3px no-repeat;'><a href='__GROUP__/Article/add'>博文发布</a></div>
                    <div class='icoitem' style='background:url("__PUBLIC__/admin/images/menuarrow.gif") 10px 3px no-repeat;'><a href='__GROUP__/Comment/index'>评论管理</a></div>
                    <div class='icoitem' style='background:url("__PUBLIC__/admin/images/menuarrow.gif") 10px 3px no-repeat;'><a href='__GROUP__/Feedback/index'>留言管理</a></div>
                </div>
            </dd>

        </dl>
        <!--快捷操作结束-->   
        <!--系统基本信息开始-->
        <dl class="dbox" id="item4">
            <dt class='lside'><div class='l'>系统基本信息</div></dt>
            <dd class='intable'>
                <table width="98%" class="dboxtable">
                    <tr>
                        <td width="25%" class='nline' style="text-align:center">您的级别：</td>
                        <td class='nline'><font color='red'><?php echo ($role); ?></font></td>
                    </tr>
                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$voinfo): $mod = ($i % 2 );++$i;?><tr>
                        <td width="25%" class='nline' style="text-align:center"><?php echo ($key); ?>：</td>
                        <td class='nline'><?php echo ($voinfo); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
                </table>
            </dd>
        </dl>
        <!--系统基本信息结束-->
       
    </div>
    <!--左侧结束-->
    
    <!--右边的快捷消息开始 -->
    <div class="column" id="column2" >
    <!--信息统计开始-->
        <dl class='dbox' id="item6">
            <dt class='lside'><div class='l'>信息统计</div></dt>
            <dd id='listCount'>
               <table width="100%" class="dboxtable">
    <tr>
        <td width="25%" class='nline' style="text-align:center"> 博文数： </td>
        <td class='nline'> <?php echo ($blognu); ?>&nbsp;&nbsp;<?php if(($blognu) != "0"): ?><a href="__GROUP__/Article/index"><img src="__PUBLIC__/admin/images/search.png" title="查看博文"></a><?php endif; ?></td>
    </tr>
    <tr>
        <td width="25%" class='nline' style="text-align:center">留言数：</td>
        <td class='nline'><?php echo ($feednum); ?>&nbsp;&nbsp;<?php if(($feednum) != "0"): ?><a href="__GROUP__/Feedback/index"><img src="__PUBLIC__/admin/images/search.png" title="查看留言"></a><?php endif; ?></td>
    </tr>
    <tr>
        <td width="25%" class='nline' style="text-align:center"> 评论数： </td>
        <td class='nline'><?php echo ($commentnum); ?>&nbsp;&nbsp;<?php if(($commentnum) != "0"): ?><a href="__GROUP__/Comment/index"><img src="__PUBLIC__/admin/images/search.png" title="查看评论"></a><?php endif; ?></td>
    </tr>
    </table>
            </dd>
        </dl>
        <!--信息统计结束-->
        <dl class='dbox' id="item5">
            <dt class='lside'><div class='l'>使用帮助</div></dt>
            <dd class='intable'>
                <table width="98%" class="dboxtable">
                    <tr>
                        <td width='25%' class='nline' style="text-align:center"> 开发者： </td>
                        <td class='nline' style="text-align:left"><a href="http://www.zhangenrui.cn" target="_blank" style="color:blue">RUI</a></td>
                    </tr>
                    <tr>
                        <td height='36' class='nline' style="text-align:center">在线帮助：</td>
                        <td class='nline' style="text-align:left"><a href="http://www.zhangenrui.cn" target="_blank" style="color:blue">个人主页</a>&nbsp;&nbsp;<a href="http://www.iqishe.com" target="_blank" style="color:blue">官方网站</a>&nbsp;&nbsp;<a href="tencent://message/?uin=835691466&Site=www.zhangenrui.cn&Menu=yes" title="点我在线咨询" target="_blank"><img src="__PUBLIC__/admin/images/qq.png"/></a></td>
                    </tr>
                </table>
            </dd>
        </dl>
        <!--最新文档开始-->
        <dl class='dbox' id="item7">
            <dt class='lside'><div class='l'>最新博文</div></dt>
            <dd id='listNews'>

    <table width="100%" class="dboxtable">
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><tr>
            <td class='nline'  style="text-align:left">
               <a href="__GROUP__/Article/edit/arcid/<?php echo ($data["arcid"]); ?>"><?php echo ($data["title"]); ?>&nbsp;[<font color="red">点我编辑</font>]</a>
            </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
            </dd>
        </dl><!--最新文档结束-->
    </div>
</div>

</div>
</body>
</html>