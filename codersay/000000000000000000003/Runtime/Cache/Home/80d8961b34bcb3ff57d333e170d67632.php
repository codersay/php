<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD profile=http://gmpg.org/xfn/11>
<TITLE><?php echo ($postinfo["title"]); ?></TITLE>
<META content=PHP博客是一个以PHP学习,PHP技术,PHP网站开发为核心的PHP技术交流博客,真实记录PHPer在学习PHP过程中遇到的各种PHP问题和解决方法-PHP技术博客站 name=description>
<META content=PHP,PHP博客,PHP学习,PHP技术,PHP网站,PHP学习博客,PHP技术博客 name=keywords>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<LINK media=screen href="__PUBLIC__/css/style.css" type=text/css rel=stylesheet>
<LINK media=print href="__PUBLIC__/css/print.css" type=text/css rel=stylesheet>

<script type="text/javascript" src="__PUBLIC__/js/jquery.js" ></script> 
<script type="text/javascript">
DD_belatedPNG.fix('.imgA');
DD_belatedPNG.fix('.liA');

function addCheck() {
	if( $("#message").val() == "" ) {
		$("#msgTip").html("请填写留言内容！");
		$("#message").focus();
		return false;
	}else{
		$("#msgTip").html("");
	}

	if( $("#corp").val() == "" ) {
		$("#corpTip").html("请填写公司名称！");
		$("#corp").focus();
		return false;
	}else{
		$("#corpTip").html("");
	}

	if( $("#man").val() == "" ) {
		$("#manTip").html("请填写联系人姓名！");
		$("#man").focus();
		return false;
	}else{
		$("#manTip").html("");
	}

	if( $("#phone").val() == "" ) {
		$("#phoneTip").html("请填写联系人姓名！");
		$("#phone").focus();
		return false;
	}else{
		$("#phoneTip").html("");
	}

	if( $("#verify").val() == "" ) {
		$("#verifyTip").html("请输入验证码！");
		$("#verify").focus();
		return false;
	}else{
		$("#verifyTip").html("");
	}

	return true;
}

function refreshVerify(){
	var timenow = new Date().getTime();
	$("#verifyImg").attr("src", '/Admin/Login/verify/'+timenow);
}

function incorrectCode() {
	$("#verifyTip").html("验证码错误");
	$("#verify").focus();
}

function success() {
	alert("留言成功，我们会尽快与您联系！");
	$("#button2").click();
}

function fail() {
	alert("留言失败，请拨打我们的联系电话！");
}
</script>
</HEAD>
<BODY>

<DIV id=page>
 <!--header start-->
  <DIV id=header>
    <DIV id=headerimg>
      <H1><A href="http://wordpress/">PHP博客-专注于PHP技术</A></H1>
      <DIV class=description>php学习交流博客phpboke.com</DIV>
    </DIV>
    <UL id=nav>
      <LI class=page_item><A href="/">Home</A> </LI>
  <?php if(is_array($pagelist)): $i = 0; $__LIST__ = $pagelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="page_item page-item-170"><A title=<?php echo ($vo["name"]); ?> href="/Home/Page/Content/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></A> </LI><?php endforeach; endif; else: echo "" ;endif; ?>
    </UL>
  </DIV>
  <!--/header end-->

  <!--content start-->
  <DIV id=content>
    <DIV class=post id=post-436>
      
 
        <H2><A title=""><?php echo ($postinfo["title"]); ?></A></H2>
        <SPAN class=post-cat><A href="/Home/Category/index/cid/<?php echo ($cateinfo["id"]); ?>"><?php echo ($cateinfo["name"]); ?></A></SPAN>
        <span class="post-calendar"><?php echo ($date[1]); ?> <?php echo ($date[2]); ?>th, <?php echo ($date[0]); ?></span>
        
        <DIV class=post-content>
		<?php echo ($postinfo["content"]); ?>
        </DIV>

<!-- 
<h3 id="respond">Leave a Reply</h3>
<form action="/Home/Post/sendMsg" method="post" id="commentform" onsubmit="return addCheck();">
<p><input type="text" name="author" id="author" value="" size="22" tabindex="1" />
<label for="author"><strong>Name</strong> (required)</label></p>
<p><input type="text" name="email" id="email" value="" size="22" tabindex="2" />
<label for="email"><strong>Mail</strong> (will not be published) (required)</label></p>
<p><input type="text" name="url" id="url" value="" size="22" tabindex="3" />
<label for="url"><strong>Website</strong></label></p>
<p><textarea name="content" id="content" cols="100%" rows="10" tabindex="4"></textarea></p>
<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" />
<input type="hidden" name="id" value="<?php echo ($postinfo["id"]); ?>" />
</p>
</form>
 -->
    </DIV>
  </DIV>
  <!--/content end-->
  
  <!--sidebar start-->
    <DIV id=sidebar>
    <UL>
    <LI>      <LI>
        <H2 class=sidebartitle>最新文章</H2>
        <UL class=list-cat>
        <?php if(is_array($newpostlist)): $i = 0; $__LIST__ = $newpostlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A>
    	</LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      <LI></LI>
    <LI>      <LI>
        <H2 class=sidebartitle>热点话题排行榜</H2>
        <UL class=list-cat>
        <?php if(is_array($hotpostlist)): $i = 0; $__LIST__ = $hotpostlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A>&nbsp;(<?php echo ($vo["hits"]); ?>view)
    		</LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      <LI></LI>
    <LI>      <LI>
        <H2 class=sidebartitle>分类目录</H2>
        <UL class=list-cat>
        <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Category/index/cid/<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></A>
    	 </LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      </LI></LI>
    </UL>
  </DIV>
  <!--/sidebar end-->
  
<!--footer start-->
  <!--footer start-->
  <DIV id=footer>
    <HR class=clear>
  </DIV>
</DIV>

<DIV id=credits>
  <DIV class=alignleft> <A href="http://www.phpboke.com/">kenblog</A> Powered by ken</DIV>
  <DIV class=alignright><A class=rss href="#">Entries 
    RSS</A> <A class=rss href="#">Comments RSS</A> <SPAN class=loginout></SPAN></DIV>
</DIV>
  <!--footer end-->
<!--footer end-->

</DIV>
</body>
</html>