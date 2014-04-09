<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD profile=http://gmpg.org/xfn/11>
<TITLE>PHP博客_PHP学习_PHP技术-PHP学习博客专注于PHP技术研究及学习</TITLE>
<META content=PHP博客是一个以PHP学习,PHP技术,PHP网站开发为核心的PHP技术交流博客,真实记录PHPer在学习PHP过程中遇到的各种PHP问题和解决方法-PHP技术博客站 name=description>
<META content=PHP,PHP博客,PHP学习,PHP技术,PHP网站,PHP学习博客,PHP技术博客 name=keywords>
<META http-equiv=Content-Type content="text/html; charset=UTF-8">
<LINK media=screen href="__PUBLIC__/css/style.css" type=text/css rel=stylesheet>
<LINK media=print href="__PUBLIC__/css/print.css" type=text/css rel=stylesheet>
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
  
   <?php if(is_array($summarylist)): $i = 0; $__LIST__ = $summarylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><DIV class=post id=post-436>
      <DIV class=post-date><SPAN class=post-month><?php echo ($date[1]); ?></SPAN> <SPAN 
class=post-day><?php echo ($date[2]); ?></SPAN></DIV>
      <DIV class=entry>
        <H2><A title="<?php echo ($vo["name"]); ?>" href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A></H2>
        <SPAN class=post-cat><A ><?php echo ($vo["categoryname"]); ?></A></SPAN> <SPAN class=post-comments><A 
title="">No Comments 
        »</A></SPAN>
        <DIV class=post-content>
		<?php echo ($vo["content"]); ?>
        </DIV>
      </DIV>
    </DIV><?php endforeach; endif; else: echo "" ;endif; ?>
  
    <DIV class=navigation><?php echo ($page); ?><SPAN 
class=next-entries></SPAN></DIV>
 
 </DIV>
 
  <!--sidebar start-->
    <DIV id=sidebar>
    <UL>
     <form method="get" id="searchform" action="http://wordpress/">
<div><input type="text" value="" name="s" id="s" />
<input type="submit" id="searchsubmit" value="Search" />
</div>
</form>
          <LI>
        <H2 class=sidebartitle>随机文章</H2>
        <UL class=list-cat>
        <?php if(is_array($randpostlist)): $i = 0; $__LIST__ = $randpostlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A>
    	</LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      </LI>
          <LI>
        <H2 class=sidebartitle>最新文章</H2>
        <UL class=list-cat>
        <?php if(is_array($newpostlist)): $i = 0; $__LIST__ = $newpostlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A>
    	</LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      <LI>
          <LI>
        <H2 class=sidebartitle>热点话题排行榜</H2>
        <UL class=list-cat>
        <?php if(is_array($hotpostlist)): $i = 0; $__LIST__ = $hotpostlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Post/index/id/<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></A>&nbsp;(<?php echo ($vo["hits"]); ?>view)
    		</LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      <LI>
          <LI>
        <H2 class=sidebartitle>分类目录</H2>
        <UL class=list-cat>
        <?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI class="cat-item cat-item-9"><A title=Apache相关问题讨论 
    href="/Home/Category/index/cid/<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></A>
    	 </LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      </LI>
   <!--      <LI>
        <H2 class=sidebartitle>文章索引模板</H2>
        <UL class=list-archives>
        <?php if(is_array($archiveslist)): $i = 0; $__LIST__ = $archiveslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI><A href=""><?php echo ($vo["cid"]); ?></A>
          </LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
       </LI> -->
          <LI>
        <H2 class=sidebartitle>链接</H2>
        <UL class=list-blogroll>
        <?php if(is_array($linklist)): $i = 0; $__LIST__ = $linklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): ++$i;$mod = ($i % 2 )?><LI><A href="http://<?php echo ($vo["url"]); ?>" target=_blank title="<?php echo ($vo["name"]); ?>"><?php echo ($vo["name"]); ?></A>
          </LI><?php endforeach; endif; else: echo "" ;endif; ?>
        </UL>
      </LI>
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

</body>
</html>