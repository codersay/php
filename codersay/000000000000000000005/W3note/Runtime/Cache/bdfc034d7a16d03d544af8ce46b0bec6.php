<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php if($title == 'index'): echo (C("sitename")); elseif($title != ''): echo ($title); else: echo ($vo['title']); endif; ?></title>
<?php if($title == 'index'): ?><meta name="keywords" content="<?php echo (C("metakeys")); ?>" /><?php endif; ?>
<?php if($title == 'index'): ?><meta name="description" content="<?php echo (C("metadesc")); ?>"/>
<?php else: ?>
<meta name="description" content="<?php echo ($vo["description"]); ?>"/><?php endif; ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="zh-CN" />
<link href="<?php echo (C("cssurl")); ?>style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div id="header"><img src="<?php echo (C("rooturl")); ?>Public/Images/logo.gif" title="wbLOG" alt="wblog" width="189" height="65" border="0"/>
  <ul>   
     <?php echo W('Nav');?>	
  </ul>
</div>
<div class="container">
<!--<div class="container">container-begin -->
  <div class="pagebody"> <!--pagebody-begin -->
    <div class="leftpage"> <!--leftpage-begin -->
      <div class="ance"> <!-- anoun-begin -->      
        <?php if($ance['url'] != ''): ?><a title="<?php echo ($ance['title']); ?>" href="<?php echo ($ance['url']); ?>"><?php echo ($ance['title']); ?></a> 
        <?php else: ?>
         <?php echo ($ance['title']); endif; ?>      
        </div> <!-- anoun-end -->
	  <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$info): $mod = ($i % 2 );++$i;?><div class="info"> <!-- info-begin -->
        <div class="postinfo">
          <div class="date"> <!-- date-begin -->
            <div class="t"><?php echo (date("m",$info['inputtime'])); ?>月</div>
            <div class="d"><strong><?php echo (date("d",$info['inputtime'])); ?></strong></div>
          </div> <!-- date-end -->
          <div class="title"><strong><a title="<?php echo ($info['title']); ?>" href="<?php echo U('/read/'.$info['id']);?>"><?php echo ($info['title']); ?></a></strong></div>
		  <div class="tinfo">
          <div class="author">作者:<?php echo ($info['author']); ?></div>
          <div class="cat">分类:<a title="<?php echo ($info['colTitle']); ?>" href="<?php echo U('/cat/'.$info['catid']);?>"><?php echo ($info['colTitle']); ?></a></div>
          <div class="brownum">浏览<?php echo ($info['hits']); ?></div>
          <div class="comnum"><a href="#"><?php echo (count($info['Comment'])); ?>人评论</a></div>
		  </div><!--tinfo end-->
          <div class="line"></div>
        </div>
        <!-- postinfo-end -->
        <div class="post"><?php echo ($info['description']); ?>...</div>
        <div class="tag">标签:<?php echo (webtags($info['keywords'])); ?></div>
        <div class="comnum">评论人数<?php echo (count($info['Comment'])); ?><a href="<?php echo U('/read/'.$info['id']);?>#comment">【我来说两句】</a></div>
      </div>
      <!-- info-end --><?php endforeach; endif; else: echo "" ;endif; ?>
      <div class="pages"><div class="page"><?php echo ($page); ?></div></div>
    </div>
    <!--leftpage-end -->
    <div class="rightpage">
     <div class="l_tit"><a href="http://www.w3note.com/Feed" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_sub_c1s16.gif" alt="feedsky" vspace="2"  style="margin-bottom:3px" ></a></div>
    <div class="about"> 什么是RSS订阅？<a href="http://baike.baidu.com/view/736401.htm" target="_blank">查看解释</a><br/>订阅到您的在线阅读器

     </div>
     <div class="share">
      <!-- Feedsky FEED发布代码开始 -->
      <!-- FEED自动发现标记开始 -->
     <link title="RSS 2.0" type="application/rss+xml" href="http://feed.feedsky.com/w3note" rel="alternate" />
     <!-- FEED自动发现标记结束 -->

     <a href="http://www.zhuaxia.com/add_channel.php?url=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_zhuaxia.gif" alt="抓虾" vspace="2" style="margin-bottom:3px" ></a>    
     <a href="http://fusion.google.com/add?feedurl=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_google.gif" alt="google reader" vspace="2" style="margin-bottom:3px" ></a><br />
     <a href="http://add.my.yahoo.com/rss?url=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_yahoo.gif" alt="my yahoo" vspace="2" style="margin-bottom:3px" ></a>    
     <a href="http://www.xianguo.com/subscribe.php?url=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_xianguo.gif" alt="鲜果" vspace="2" style="margin-bottom:3px" ></a><br />
     <a href="http://inezha.com/add?url=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_nazha.gif" alt="哪吒" vspace="2" style="margin-bottom:3px" ></a>    
     <a href="http://mail.qq.com/cgi-bin/feed?u=http://feed.feedsky.com/w3note" target="_blank"><img border="0" src="http://img.feedsky.com/images/icon_subshot01_qq.gif" alt="QQ邮箱" vspace="2" style="margin-bottom:3px" ></a><br />
     <!-- Feedsky FEED发布代码结束 -->
      </div>
      <div class="search">
        
        <form method="get" action="http://www.google.com/search" target="_blank">
        <input type="text" name="q" size="26" />
        <input type="submit" value="搜索" name="btnG" id="btnG" />
        <input type="hidden" name="ie" value="UTF-8" />
        <input type="hidden" name="oe" value="UTF-8" />
        <input type="hidden" name="hl" value="zh-CN" />
        <input type="hidden" name="domains" value="w3note.com" />
        <input type="hidden" name="sitesearch" value="w3note.com" />
        </form>


       </div>
      <!--search-end -->
      <div class="barnner"> </div><!--barnner-end -->
      <div class="l_tit">关于博客</div>
      <div class="about"><?php echo (C("metadesc")); ?></div>
      <!--about-end -->
	  <div class="share">
	    <!-- Baidu Button BEGIN -->
    <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare">
        <span class="bds_more">分享到：</span>
        <a class="bds_qzone"></a>
        <a class="bds_tsina"></a>
        <a class="bds_tqq"></a>
        <a class="bds_renren"></a>
		<a class="shareCount"></a>
    </div>
     <script type="text/javascript" id="bdshare_js" data="type=tools&mini=1" ></script>
     <script type="text/javascript" id="bdshell_js"></script>
     <script type="text/javascript">
	    document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + new Date().getHours();
     </script>
   <!-- Baidu Button END -->
	  </div>
	   <div class="l_tit">主博客分类</div>
      <div class="catlist">
        <ul>
		<?php echo W('Cate');?>
        </ul>
      </div>
      <div class="l_tit">微博最新文章</div>
      <div class="month">
        <ul>
        <?php if(is_array($newslist)): $i = 0; $__LIST__ = $newslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$news): $mod = ($i % 2 );++$i;?><li>  <a title="<?php echo ($news["title"]); ?>" href="<?php echo U('/blog/'.$news['id']);?>"><?php echo ($news['title']); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
      </div>
      
      <div class="l_tit">随机文章</div>
      <div class="rand">
        <ul>
		 <?php echo W('Rand');?>
        </ul>
      </div>
      <div class="l_tit">最新评论及回复</div>
        <?php echo W('Newscomments');?>
	   <div class="l_tit">站点统计</div>
      <div class="total">
        <ul>
          <li>日记总数:<?php echo ($Newsnum); ?></li>
		  <li>评论总数:<?php echo ($Cmnum); ?></li>
		  <li>浏览总数:<?php echo ($Visitnum); ?></li>
		  <li>留言总数:<?php echo ($Gknum); ?></li>
		  <li>当前主题：常春藤</li>
		  <li>当前样式:w3note</li>
        </ul>
      </div>
	  <div class="l_tit">分类标签【<a title="更多分类标签" href="<?php echo U('/read','tag=name');?>">更多</a>】</div>
      <div class="tags">
        <ul>
        <?php echo W('Tags');?>
        </ul>
      </div>
      <div class="l_tit">文章归档</div>
      <div class="month">
        <ul>
       <?php echo W('Date');?>
        </ul>
      </div>
      <div class="l_tit">友情链接</div>
      <div class="links">
        <ul>
          <?php echo W('Link');?>
        </ul>
      </div><!--links-end -->
      
    </div><!--rightpage-end -->
  </div> <!--pagebody-end -->
  <!-- <div class="clear"></div>-->
 <div id="footer">
<li style="width: 900px;height:30px;"><h4 style="float: left;margin:0px 10px 0px 10px;"><?php echo (C("icp")); ?></h4><h4 style="float: right;margin:0px 10px 0px 10px;"><a href="<?php echo (C("rooturl")); ?>page/about">【关于我们】</a></h4></li>
<li style="width: 900px;"><h4 style="float: right;margin:0px 10px 0px 10px;"></h4></li>
<h3 style="margin-left:10px;">Designed By w3note.com Powered By WBlog3.1.2_2 <script src="http://s84.cnzz.com/stat.php?id=4639431&web_id=4639431&show=pic" language="JavaScript"></script>
</h3>
</div>
<div id="bootom">&nbsp;</div>
  </body>
</html>