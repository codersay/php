<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en-us"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<title><?php echo C('SITE_TITLE');?></title>
<link rel="icon" href="http://www.w3schools.com/favicon.ico" type="image/x-icon">
<meta name="keywords" content="<?php echo C('SITE_KEYWORDS');?>" />
<meta name="description" content="<?php echo C('SITE_DESCRIPTION');?>" />
<meta name="robots" content="all" />
<meta name="author" content="<?php echo C('SITE_DP_AUTHOR');?>" />
<meta name="viewport" content="width=device-width"> 
<link rel="stylesheet" type="text/css" media="all" href="__STATIC_URL__/style/basic.css" />
<link rel="stylesheet" type="text/css" media="all" href="__STATIC_URL__/js/UEDTinkerShare.js" />
<link rel="stylesheet" type="text/css" media="all" href="http://doc.codersay.net/php/syntaxhighlighter/styles/shCoreDefault.css" />
 </head>
 <body>
  <div id="top"><div id="top_left"><a href="__SITE_URL__"><img style="border:0;" alt="W3Schools.com" src="__STATIC_URL__/images/logo.png"></a></div>
  <div id="top_right">  
  <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$level1): $mod = ($i % 2 );++$i; if(( $level1['level'] == 1 ) && ( $level1['status'] == 1 ) && ( $level1['nav'] == 'nav' )): if(( $level1['type'] == 'url' ) && ( $level1['level'] != '' )): ?><a href="<?php echo ($level1["url"]); ?>" target="_blank"><?php echo ($level1["name"]); ?></a>
                <?php else: ?>
                <a href="<?php echo URL($level1['id'],$level1['channel'],'category');?>"><?php echo ($level1["name"]); ?></a><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?> 
  </div>
</div>
<div id="page">
	<div id="leftcol">
	<?php if(is_array($category)): $key = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$level1): $mod = ($key % 2 );++$key; if( ( $level1['status'] == 1 ) && ( $level1['nav'] == 'nav' )): if(($level1['level'] == 1)): ?><h3><?php echo ($level1["name"]); ?></h3>
				<?php $tmppid = $level1['id']; endif; ?>				
				<?php if(($level1['level'] == 2) && ($level1['pid'] == $tmppid)): ?><a href="<?php echo ($level1["url"]); ?>" target="_blank"><?php echo ($level1["name"]); ?></a><br><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>					
	</div>
	<div id="maincol"> 
			<?php if($list != ''): if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="box1">
					<a href="<?php if(!empty($vo['url_name'])){ echo U('/'.$vo['url_name']); } elseif(!empty($vo['outurl'])){echo $vo['outurl'];} else{ echo U('/views/'.$vo['id']); } ?>" class="box"  target="_blank">
						<div class="image color<?php echo ($key); ?>"></div>
						<h1><?php echo ($vo["title"]); ?></h1>
					</a>
					<div style="clear:both;"></div>
				</div><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div style="clear:both;"></div>
<div class="footer">
  <br>
  <table id="bottomlinks"><tbody><tr>
  <td style="vertical-align:top;">
  <h3>Top 10 基础教程</h3>
  <a href="http://www.w3schools.com/html/default.asp"><span class="bottomlinksraquo">»</span> HTML Tutorial</a><br>
  <a href="http://www.w3schools.com/html/html5_intro.asp"><span class="bottomlinksraquo">»</span> HTML5 Tutorial</a><br>
  <a href="http://www.w3schools.com/css/default.asp"><span class="bottomlinksraquo">»</span> CSS Tutorial</a><br>
  <a href="http://www.w3schools.com/css/css3_intro.asp"><span class="bottomlinksraquo">»</span> CSS3 Tutorial</a><br>
  <a href="http://www.w3schools.com/js/default.asp"><span class="bottomlinksraquo">»</span> JavaScript Tutorial</a><br>
  <a href="http://www.w3schools.com/jquery/default.asp"><span class="bottomlinksraquo">»</span> jQuery Tutorial</a><br>
  <a href="http://www.w3schools.com/sql/default.asp"><span class="bottomlinksraquo">»</span> SQL Tutorial</a><br>
  <a href="http://www.w3schools.com/php/default.asp"><span class="bottomlinksraquo">»</span> PHP Tutorial</a><br>
  <a href="http://www.w3schools.com/aspnet/default.asp"><span class="bottomlinksraquo">»</span> ASP.NET Tutorial</a><br>
  <a href="http://www.w3schools.com/xml/default.asp"><span class="bottomlinksraquo">»</span> XML Tutorial</a><br>
  </td>
  <td style="vertical-align:top;">
  <h3>Top 10 进级实例</h3>
  <a href="http://www.w3schools.com/tags/default.asp"><span class="bottomlinksraquo">»</span> HTML/HTML5 Reference</a><br>
  <a href="http://www.w3schools.com/cssref/default.asp"><span class="bottomlinksraquo">»</span> CSS 1,2,3 Reference</a><br>
  <a href="http://www.w3schools.com/cssref/css3_browsersupport.asp"><span class="bottomlinksraquo">»</span> CSS 3 Browser Support</a><br>
  <a href="http://www.w3schools.com/jsref/default.asp"><span class="bottomlinksraquo">»</span> JavaScript</a><br>
  <a href="http://www.w3schools.com/jsref/default.asp"><span class="bottomlinksraquo">»</span> HTML DOM</a><br>
  <a href="http://www.w3schools.com/dom/dom_nodetype.asp"><span class="bottomlinksraquo">»</span> XML DOM</a><br>
  <a href="http://www.w3schools.com/php/php_ref_array.asp"><span class="bottomlinksraquo">»</span> PHP Reference</a><br>
  <a href="http://www.w3schools.com/jquery/jquery_ref_selectors.asp"><span class="bottomlinksraquo">»</span> jQuery Reference</a><br>
  <a href="http://www.w3schools.com/aspnet/webpages_ref_classes.asp"><span class="bottomlinksraquo">»</span> ASP.NET Reference</a><br>
  <a href="http://www.w3schools.com/tags/ref_colornames.asp"><span class="bottomlinksraquo">»</span> HTML Colors</a><br>
  </td>
  <td style="vertical-align:top;">
  <h3>Top 10 参考文档</h3>
  <a href="http://www.w3schools.com/html/html_examples.asp"><span class="bottomlinksraquo">»</span> HTML Examples</a><br>
  <a href="http://www.w3schools.com/css/css_examples.asp"><span class="bottomlinksraquo">»</span> CSS Examples</a><br>
  <a href="http://www.w3schools.com/xml/xml_examples.asp"><span class="bottomlinksraquo">»</span> XML Examples</a><br>
  <a href="http://www.w3schools.com/js/js_examples.asp"><span class="bottomlinksraquo">»</span> JavaScript Examples</a><br>
  <a href="http://www.w3schools.com/js/js_dom_examples.asp"><span class="bottomlinksraquo">»</span> HTML DOM Examples</a><br>
  <a href="http://www.w3schools.com/jquery/jquery_examples.asp"><span class="bottomlinksraquo">»</span> jQuery Examples</a><br>
  <a href="http://www.w3schools.com/dom/dom_examples.asp"><span class="bottomlinksraquo">»</span> XML DOM Examples</a><br>
  <a href="http://www.w3schools.com/ajax/ajax_examples.asp"><span class="bottomlinksraquo">»</span> AJAX Examples</a><br>
  <a href="http://www.w3schools.com/asp/asp_examples.asp"><span class="bottomlinksraquo">»</span> ASP Examples</a><br>
  <a href="http://www.w3schools.com/svg/svg_examples.asp"><span class="bottomlinksraquo">»</span> SVG Examples</a>
  </td>
  <td style="vertical-align:top;">
  <h3>Top 10 开源程序</h3>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> HTML Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> HTML5 Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> CSS Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> JavaScript Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> jQuery Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> XML Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> ASP Certificate</a><br>
  <a href="http://www.w3schools.com/cert/default.asp"><span class="bottomlinksraquo">»</span> PHP Certificate</a><br>
  </td>
  <td style="vertical-align:top;">
  <h3>Color Picker</h3>
  <a href="http://www.w3schools.com/tags/ref_colorpicker.asp">
  <img src="__STATIC_URL__/images/colormap_80.gif" alt="colorpicker" style="width:80px;height:68px;"></a>
  </td>
  </tr></tbody></table>
</div>
<hr style="height:5px;">
<div class="footer">
  <div id="footerImg"><a href="http://www.w3schools.com/">
    <img style="width:150px;height:28px;border:0" src="__STATIC_URL__/images/w3schoolscom_gray.gif" alt="W3Schools.com"></a>
  </div>
</div>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shCore.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushCSharp.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushPhp.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushJScript.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushJava.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushVb.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushSql.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushXml.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushDelphi.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushPython.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushRuby.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushCss.js"></script>
<script class="javascript" src="http://doc.codersay.net/php/syntaxhighlighter/scripts/shBrushCpp.js"></script>
<script class="javascript">
dp.syntaxhighlighter.HighlightAll('code');
</script>
</body></html>