<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>

<!-- BEGIN html -->
<html xmlns:wb="http://open.weibo.com/wb">

<!-- BEGIN head -->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- Stylesheets -->
	<link rel="stylesheet" href="__CSS__/style.css" type="text/css" media="screen" />
    <!-- Javascript -->
	<script type='text/javascript' src='__JS__/jquery-1.4.2.js'></script>
	<script type='text/javascript' src='__JS__/jquery-ui-1.8.5.custom.min.js'></script>
	<script type='text/javascript' src='__JS__/jquery.custom.js'></script>
	<script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js" type="text/javascript" charset="utf-8"></script>
	<link id="favicon" href="/favicon.ico" rel="icon" type="image/x-icon" />    
    <!-- Title -->
	<title><?php echo (C("CFG_WEBNAME")); ?></title>
    <meta name="description" content="<?php echo (C("CFG_DESCRIPTION")); ?>" />
	<meta name="keywords" content="<?php echo (C("CFG_KEYWORDS")); ?>" />
    <link rel="canonical" href="/" />
<!-- END head -->
</head>

<!-- BEGIN body -->
<body class="home blog ie layout-2cl">

	<!-- BEGIN #container -->
	<div id="container">
		
		
<!-- BEGIN #header -->
<div id="header">	
			
			<!-- BEGIN .inner -->
			<div class="inner">
			
				<p class="welcome-message"><?php echo (C("CFG_SUBTITLE")); ?></p>
                
                <div id="top-nav">
                
					<div class="menu-menu-container"><ul id="menu-menu" class="menu"><li><a href="<?php echo U('Index/index');?>">首页</a></li>
<?php if(is_array($collist)): $i = 0; $__LIST__ = $collist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($data["url"]); ?>" ><?php echo ($data["colname"]); ?></a><?php echo ($data["submenu"]); ?></li><?php endforeach; endif; else: echo "" ;endif; ?>
<li><a href="http://pan.baidu.com/share/link?shareid=548956950&uk=1846304022" target='_blank'>软件下载</a></li>
<li><a href="<?php echo U('Feedback/index');?>">给我留言</a></li>
</ul></div>                                    
				</div>
                
			<!-- END .inner -->
			</div>
		<div class="clear"></div> 
		<!--END #header-->
		</div>
        
		<!--BEGIN #content -->
		<div id="content" class="clearfix">
					
			<!-- BEGIN #content-wrap -->
			<div id="content-wrap" class="clearfix">
			
				<div id="content-top">&nbsp;</div>
				
                <script language="JavaScript">
					$(document).ready(function(){
						var i = 0;
						$(window).scroll(function(){
							if ($(document).height()-$(document).scrollTop()-$(window).height()<100){
								if($('#rui-prompt').text() == ''){
									loadArticle('__URL__/getArticle','<?php echo ($flag); ?>',++i);
								}
							}
						});
					});
		
	</script>
				<!--BEGIN #primary .hfeed-->
				<div id="primary" class="hfeed">
				
                		<!--Position-->
						<div class="clearfix" style="margin-bottom:5px"><img src="__IMG__/home.png" width='18' height='16' alt='RUI个人博客' />&nbsp;<?php echo ($position); ?></div>
		
					                    	
											
						<?php if(is_array($arclist)): $i = 0; $__LIST__ = $arclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div>				
							<h2 class="entry-title"><a href="<?php echo ($data["arcurl"]); ?>" title="<?php echo ($data["title"]); ?>"><?php echo ($data["title"]); ?></a></h2>
											
							<!--BEGIN .entry-meta .entry-header-->
							<div class="entry-meta entry-header">
								<span class="contentinfo_time"><?php echo ($data["createtime"]); ?></span> <span class="contentinfo_category"><a href="<?php echo ($data["colurl"]); ?>" title="查看 <?php echo ($data["colname"]); ?> 中的全部文章"><?php echo ($data["colname"]); ?></a></span> <span class="contentinfo_view"><?php echo ($data["click"]); ?>次点击</span> <span class="contentinfo_comment"><?php echo ($data["commentnum"]); ?>条评论</span>    							<!--END .entry-meta entry-header -->
							</div>
							
							<div class="post-thumb post-lead">
                                   <?php if($data["pic"] != ''): ?><a title="<?php echo ($data["title"]); ?>" href="<?php echo ($data["arcurl"]); ?>"><img width="570" height="140" src="<?php echo ($data["pic"]); ?>" class="attachment-archive-thumb wp-post-image" alt="<?php echo ($data["title"]); ?>" /></a><?php endif; ?>
							</div>
									
							<!--BEGIN .entry-content -->
							<div class="entry-content">
                            	<p><?php echo ($data["description"]); ?>...</p>
								 <p><a href="<?php echo ($data["arcurl"]); ?>" class="more-link">阅读全文 »</a></p>
							<!--END .entry-content -->
							</div>
		                
						<!--END .hentry-->  
						</div><?php endforeach; endif; else: echo "" ;endif; ?>
										
				<!--END #primary .hfeed-->
				</div>
				<div id="content-btm">&nbsp;</div>
                <div class="page-navigation" style="font-size:20px;display:none" id="rui-prompt"></div>
			
			<!-- END #content-wrap -->
			</div>

		
<!--BEGIN #left-->
<div id="sidebar" class="aside">
		
			<!-- BEGIN #logo -->
			<div id="logo">
								<a class="logo-link" href="/" title="<?php echo (C("CFG_WEBNAME")); ?>"  style="text-indent: 0px; "></a>
							<!-- END #logo -->
			</div>
			
			
            
            			<div id="search-4" class="widget widget_search clearfix">
<form method="post" id="searchform" action="__APP__/Index/search">
	<input type="text" value="输入关键字按Enter搜索..." onfocus="if(this.value=='输入关键字按Enter搜索...')this.value='';" 
onblur="if(this.value=='')this.value='输入关键字按Enter搜索...';" name="searchkey" id="s" />
	<input type="submit" id="searchsubmit" value="Search" class="hidden"/>

</form></div>

<div id="wb_follow_btn" class="widget widget_search clearfix"><wb:follow-button uid="2587857641" type="red_3" width="100%" height="24" ></wb:follow-button></div>


<div id="tz_tab_widget-4" class="widget tz_tab_widget clearfix"><div id="tabs"><ul id="tab-items"><li><a href="#tabs-1"><span>热门</span></a></li><li><a href="#tabs-2"><span>最新</span></a></li><li><a href="#tabs-3"><span>评论</span></a></li><li><a href="#tabs-4"><span>标签</span></a></li></ul><div class="tabs-inner"><div id="tabs-1" class="tab tab-popular"><ul>		
				<?php if(is_array($hotreclist)): $i = 0; $__LIST__ = $hotreclist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="clearfix">
														<h3 class="entry-title"><a href="<?php echo ($data["arcurl"]); ?>" class="title"><?php echo ($data["title"]); ?></a></h3>
							<div class="entry-meta entry-header">
								<span class="published"><?php echo (date("Y-m-d",$data["createtime"])); ?></span>
								<span class="meta-sep">&middot;</span>
								<span class="comment-count"><a href="<?php echo ($data["arcurl"]); ?>#comments" class="ds-thread-count" title="《<?php echo ($data["title"]); ?>》上的评论"><?php echo ($data["commentnum"]); ?>条评论</a></span>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul></div><!-- #tabs-1 -->
                    <div id="tabs-2" class="tab tab-recent"><ul>	
                    <?php if(is_array($lastlist)): $i = 0; $__LIST__ = $lastlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="clearfix">
								<h3 class="entry-title"><a href="<?php echo ($data["arcurl"]); ?>" class="title"><?php echo ($data["title"]); ?></a></h3>
								<div class="entry-meta entry-header">
									<span class="published"><?php echo (date("Y-m-d",$data["createtime"])); ?></span>
									<span class="meta-sep">&middot;</span>
									<span class="comment-count"><a href="<?php echo ($data["arcurl"]); ?>#comments" class="ds-thread-count" title="《<?php echo ($data["title"]); ?>》上的评论"><?php echo ($data["commentnum"]); ?>条评论</a></span>
							</div>
							</li><?php endforeach; endif; else: echo "" ;endif; ?>					
						</ul></div><!-- #tabs-2 -->
                        <div id="tabs-3" class="tab tab-comments"><ul>		
                        <?php if(is_array($commentlist)): $i = 0; $__LIST__ = $commentlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li class="clearfix">
<span class="recentcommentsavatar"><img alt='RUI个人博客' src='__IMG__/logo_03.jpg' class='avatar' height='32' width='32' /></span>
<a class="tabcommentlink" href="<?php echo ($data["url"]); ?>" title="评论文章《<?php echo ($data["title"]); ?>》"><?php echo ($data["content"]); ?>...  </a>
<br/>
  <span class="recentcomments_author"><?php echo ($data["writer"]); ?></span><span class="recentcomments_date"><?php echo (date("Y_m-d",$data["time"])); ?></span>
  </li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul></div><!-- #tabs-3 -->
                    <div id="tabs-4" class="tab tab-tags clearfix">
                    <?php if(is_array($taglist)): $i = 0; $__LIST__ = $taglist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><a href='<?php echo ($data["tagurl"]); ?>' title='<?php echo ($data["num"]); ?> 篇文章' style='font-size: 12px;'><?php echo ($data["tagname"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div><!-- #tabs-4 --></div><!-- .tabs-inner --></div><!-- #tabs --></div>

<div id="archives-3" class="widget widget_archive clearfix"><h3 class="widget-title">文章分类</h3>
		<ul>
			<?php if(is_array($categorylist)): $i = 0; $__LIST__ = $categorylist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href='<?php echo ($data["url"]); ?>' title='<?php echo ($data["count"]); ?> 篇文章'><?php echo ($data["colname"]); ?></a>&nbsp;(<?php echo ($data["count"]); ?>)</li><?php endforeach; endif; else: echo "" ;endif; ?>
		</ul>
</div>

    <div id="archives-2" class="widget widget_archive clearfix"><h3 class="widget-title">文章归档</h3>
            <ul>
                <?php if(is_array($datelist)): $i = 0; $__LIST__ = $datelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href='<?php echo ($data["url"]); ?>' title='<?php echo ($data["count"]); ?> 篇文章'><?php echo ($data["time"]); ?></a>&nbsp;(<?php echo ($data["count"]); ?>)</li><?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
    </div>

<div id="linkcat-2" class="widget widget_links clearfix"><h3 class="widget-title">友情链接</h3>
	<ul class='xoxo blogroll'>
    	<?php if(is_array($linklist)): $i = 0; $__LIST__ = $linklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($data["url"]); ?>" target="_blank"><?php echo ($data["linkname"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
	</ul>
</div>

<div id="bd_random_post_widget-5" class="widget widget_bd_random_post_widget clearfix"><h3 class="widget-title">随机文章</h3>
<ul class="line">
	<?php if(is_array($randlist)): $i = 0; $__LIST__ = $randlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($data["arcurl"]); ?>" title="<?php echo ($data["title"]); ?>" target="_blank"><?php echo ($data["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
</ul></div>					<div id="rollstart"></div>
		<!--END #left-->
		</div>

		
		<!-- END #content -->
		</div>
        
		<!-- BEGIN #footer -->

<div id="footer">
		
			<!-- BEGIN #footer-texture -->
			<div id="footer-texture">
			
				<!-- BEGIN #footer-inner -->
				<div id="footer-inner">
					
                    <!-- BEGIN #footer-columns -->
					<div id="footer-columns" class="clearfix">
                    
                        <!-- BEGIN .column -->
                        <div class="column">
                            
                                                    
                        <!-- END .column -->
                        </div>
                        
                        <!-- BEGIN .column -->
                        <div class="column">
                            
                                                    
                        <!-- END .column -->
                        </div>
                        
                        <!-- BEGIN .column -->
                        <div class="column">
                            
                                                    
                        <!-- END .column -->
                        </div>
                        
                        <!-- BEGIN .column -->
                        <div class="column">
                            
                                                    
                        <!-- END .column -->
                        </div>
                        
                    </div>
					<!-- END #footer-columns -->


					<p class="copyright clear">
                   本站由HTML5制作，建议使用IE8以上浏览器^_^!!!<br/>
                    Copyright 2013  <a href="/"><?php echo (C("CFG_POWERBY")); ?></a> All rights reserved.&nbsp;
					<script language="javascript" type="text/javascript" src="http://js.users.51.la/16012041.js"></script>
<noscript><a href="http://www.51.la/?16012041" target="_blank"><img alt="&#x6211;&#x8981;&#x5566;&#x514D;&#x8D39;&#x7EDF;&#x8BA1;" src="http://img.users.51.la/16012041.asp" style="border:none" /></a></noscript>
                    </p> 
				
				<!-- END #footer-inner -->
				</div>
			
			<!-- END #footer-texture -->
			</div>
		
		<!-- END #footer -->
		</div>
<!-- Baidu Button BEGIN -->
<script type="text/javascript" id="bdshare_js" data="type=slide&amp;img=5&amp;pos=right&amp;uid=6584505" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
var bds_config={"bdTop":145};
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000);
</script>
<!-- Baidu Button END -->
		
		
	<!-- END #container -->
	</div> 
		
	<!-- Theme Hook -->
	<div style="display:none;"></div>
			
<!--END body-->

</body>
<!--END html-->
</html>