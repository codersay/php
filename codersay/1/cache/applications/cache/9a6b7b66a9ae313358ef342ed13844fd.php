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
						<?php if(($level1['level'] == 2) && ($level1['pid'] == $tmppid)): ?><a href="<?php echo ($level1["url"]); ?>" target="_top"><?php echo ($level1["name"]); ?></a><br><?php endif; endif; endforeach; endif; else: echo "" ;endif; ?>						
	</div>
	<div id="maincol">		        
		        <div id="content">
                <h1 class="title"><?php echo ($vo["title"]); ?></h1>
                <p class="tinfo">
                    <span class="time" title="发布日期"><?php echo (date(C('DEFAULT_DATE_FORMAT'),$vo["create_time"])); ?></span>
                    <span class="d_line">/</span>
                    <span class="author" title="作者"><?php echo (getauthorname($vo["author"])); ?></span>
                    <span class="d_line">/</span>
                    <span class="click" title="围观"><?php echo ($vo["click"]); ?></span>
                    <span class="d_line">/</span>
                    <span class="comment" title="评论"><?php echo ($vo["count"]); ?></span>
                    <span class="d_line">/</span>
                    <span class="category" title="目录类别"><?php echo (getcategoryname($vo["cid"])); ?></span>
                </p>
                <p class="share">
                    <a href="javascript:;" onClick="share.doShare('t_sina');" id="weibo" title="分享到新浪微博"></a>
                    <a href="javascript:;" onClick="share.doShare('qzone');" id="QQ_space" title="分享到QQ空间"></a>
                    <a href="javascript:;" onClick="share.doShare('t_qq');" id="QQ_weibo" title="分享到腾讯微博"></a>
                    <a href="javascript:;" onClick="share.doShare('renren');" id="renren" title="分享到人人网"></a>
                    <a href="javascript:;" onClick="share.doShare('msn');" id="msn" title="分享到MSN"></a>
                    <a href="javascript:;" onClick="share.doShare('douban');" id="douban" title="分享到豆瓣"></a>
                    <a href="javascript:;" onClick="share.doShare('twitter');" id="twitter" title="分享到Twitter"></a>
                    <a href="javascript:;" onClick="share.doShare('digg');" id="digg" title="分享到Digg"></a>
                    <a href="javascript:;" onClick="share.doShare('vimeo');" id="vimeo" title="分享到Vimeo"></a>
                    <a href="javascript:;" onClick="share.doShare('skype');" id="skyp" title="分享到Skype"></a>
                    <a href="javascript:;" onClick="share.doShare('facebook');" id="facebook" title="分享到Facebook"></a>
                    <a href="javascript:;" onClick="share.doShare('neteasy_weibo');" id="wy_weibo" title="分享到网易微博"></a>
                    <a href="javascript:;" onClick="share.doShare('rss');" id="rss" title="RSS"></a>
                    <a href="javascript:;" onClick="share.doShare('kaixin');" id="kaixin" title="分享到开心网"></a>
                </p>
                <div class="li">
                    <?php
 $content = str_replace( '[separator]', '', $vo['content'] ); echo $content; ?>
                </div>
                <?php echo addFreeWidget('ViewsAdmin',array('page'=>'views','id'=>$vo['id'],'cid'=>$vo['cid'],'type'=>$vo['type']));?>
                
	<script src="__JS__/jQuery/jquery.js"></script>

	<script type="text/javascript">
		<?php
 if ( empty( $class['type'] ) ){ $type = $vo['type']; }else{ $type = $class['type']; } ?>
		function getComment(p){
			$('#commentlist').before("<div id='loading_comment'>loading...</div>");
			$.ajax({
				url : "<?php echo U('comment/index');?>",
				data : { comment : <?php echo ($vo["id"]); ?>, p : p, fst : "<?php echo ($type); ?>" },
				dataType : "json",
				type : "GET",
				success : function(c){
					var element = '<ul>';
					if (c.status == 0){
						element += '<li>' + c.data + '</li>';
					}else{
						for( i = 0; i < c.data.length; i++ ){
							if ((i%2) == 0){
								element += "<li class='even'>";
							}else{
								element += "<li>";
							}
							element += "<div class='r_box'>";
							element += "<h5 class='r_tit'><span>" + c.data[i].username + "</span> &nbsp; " + c.data[i].dtime + " &nbsp; / &nbsp; <a href='javascript:;' rel='"+c.data[i].id+"' class='reply_comment'>回复</a></h5>";
							element += "<div class='msgcot'>";
							element += c.data[i].msg;
							if (typeof(c.data[i].sondata) != 'undefined' && c.data[i].sondata != null){
								for (var e = 0; e < c.data[i].sondata.length; e++){
									element += "<div class='replycom'>";
									element += "<img src='http://www.gravatar.com/avatar/" + c.data[i].sondata[e].email + "?s=40&r=g' />";
									element += "<div class='rightbox'>";
									element += "<h4><span class='repname'>"+c.data[i].sondata[e].username+"</span> 于 <span class='reptime'>"+c.data[i].sondata[e].dtime+"</span> 回复 <span class='urname'>"+c.data[i].username+"</span></h4>";
									element += "<div class='repmsg'>"+c.data[i].sondata[e].msg+"</div>";
									element += "</div>";
									element += "<div class='clear'></div>";
									element += "</div>";
								}
							}
							element += "</div>";
							element += "</div>";
							element += "<img src='http://www.gravatar.com/avatar/" + c.data[i].email + "?s=40' />";
							element += "<div class='clear'></div>";
							element += "</li>";	
						}
						if ( c.info != '' ){
							$('#comment_page').html('<div class="page" style="margin:0!important;">'+ c.info +'<div class="clear"></div></div>');
						}
					}
					element += '</ul>';
					
					$("#comment_list").html(element);
					$('#loading_comment').remove();
				},
				cache : false
			});
		}

		$(function(){

			function checkForm(){
				if($.trim($("#e_textarea").val()) == ''){
					alert("评论内容不能为空");
					$("#e_textarea").focus();
					return false;
				}
			}
			
			function complete(msg){
			    if(msg.status == 0){
			        alert(msg.info);
                    return false;
			    }else{
					getComment(1);
                    fleshVerify();
                    $("#username").attr("value",'');
                    $("#e_textarea").attr("value",'');
                    $("#verify").attr("value",'');
                }
			}

			getComment(1);
			
			$('#postcomment').submit(function(){
				
				var username = $.trim($("#username").val());
				var email = $.trim($("#email").val());
				var verify = $.trim($("#verify").val());
				var e_textarea = $.trim($("#e_textarea").val());
				
				$.ajax({
					url : '<?php echo U("comment/insert");?>',
					dataType : 'json',
					data : {
						username : username, 
						email : email, 
						msg : e_textarea, 
						verify : verify, 
						cid : '<?php echo ($vo["id"]); ?>', 
						arctitle : '<?php echo ($vo["title"]); ?>',
						type : '<?php echo ($type); ?>'
					},
					type : 'POST',
					beforeSend : checkForm,
					success : complete,
					cache : false
				});
				
				return false;
			});
			$("#reply_post").live('click',function(){
			
				var usernameReply = $.trim($("#usernameReply").val());
				var emailReply = $.trim($("#emailReply").val());
				var e_textareaReply = $.trim($("#e_textareaReply").val());
				var verifyReply = $.trim($('#verifyReply').val());
				var reply_pid	= $('#reply_pid').val();
				var e_url = '<?php echo U("comment/reply");?>';
				
				if(e_textareaReply == ''){
					alert("评论内容不能为空");
					$("#e_textareaReply").focus();
					return false;
				}
				
				$.ajax({
					url : e_url,
					dataType : 'json',
					data : { username : usernameReply, email : emailReply, msg : e_textareaReply, verify : verifyReply, pid : reply_pid, cid : '<?php echo ($vo["id"]); ?>', arctitle : '<?php echo ($vo["title"]); ?>' },
					type : 'POST',
					success : function (e){
						if(e.status == 0){
				        	alert(e.info);
	                        return false;
					    }else{
					    	$("#reply_comment").remove();
	    					getComment(1);
	                    }
					},
					cache : false
				});
				return false;
			});
			$(".reply_comment").live('click',function(){
				var id = $(this).attr("rel");
				var isreply = $("#reply_comment").length;
				if ($("#reply_pid").val() == id){
					$("#reply_comment").remove();
					return false;
				}
				if (isreply > 0){
					$("#reply_comment").remove();
				}
				
				var html = '<div id="close_reply" style="cursor: pointer;">关闭</div>';
				html += '<form method="post" id="reply_comment_post">';
				html += '<table border="0" cellpadding="0" cellspacing="0" style="width:100%;">';
				html += '	<tr>';
				html += '		<td><input name="username" id="usernameReply" class="txt" value="" style="width:280px;" /> &nbsp; *用户名</td>';
				html += '	</tr>';
				html += '	<tr>';
				html += '		<td><input name="email" id="emailReply" class="txt" value="" style="width:280px;" /> &nbsp; *邮箱</td>';
				html += '	</tr>';
				<?php if( C('COMMENT_VERIFY') == 1 ){ ?>
				html += '	<tr>';
				html += '		<td><input type="text" name="verify" id="verifyReply" class="txt" style="width:200px;" /> &nbsp; <img id="verifyImgReply" SRC="index.php?m=comment&a=verify" onClick="fleshVerifyReply()" BORDER="0" ALT="点击刷新验证码" style="cursor:pointer;" align="absmiddle"></td>';
				html += '	</tr>';
				<?php } ?>
				html += '	<tr>';
				html += '		<td class="tdpd"><textarea class="txtarea" name="msg" id="e_textareaReply" class="txt" style="height:120px; width:97%;"></textarea></td>';
				html += '	</tr>';
				html += '	<tr>';
				html += '		<td class="tdpd"><input type="submit" class="do_post_com" id="reply_post" value="Reply" /></td>';
				html += '	</tr>';
				html += '</table>';
				html += '<input type="hidden" value="'+id+'" name="pid" id="reply_pid" />';
				html += '</form>';
				
				$(this).parent().parent().parent().after("<div id='reply_comment'>"+html+"</div>");
				fleshVerifyReply();
			});
			$("#close_reply").live('click',function(){
				$(this).parent().remove();
			});
		});

		function fleshVerify(type){ 
			var timenow = new Date().getTime();
			$("#verifyImg").attr("src","index.php?m=comment&a=verify&"+timenow);
		}
		
		function fleshVerifyReply(){
			var timenow = new Date().getTime();
			$("#verifyImgReply").attr("src","index.php?m=comment&a=verify&"+timenow);
		}
	</script>
	<div id="comment">

		<h3 class="comment_title">评论</h3>
		<div id="comment_list"></div>
		<div id="comment_page"></div>
		<?php if( C('COMMENT_ON_OFF') == 1 ){ ?>
		<div id="comment_form" class="efbox">
			<form method="post" id="postcomment">
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td><input name="username" id="username" class="txt" value="" style="width:280px;" /> &nbsp; *用户名</td>
					</tr>
					<tr>
						<td><input name="email" id="email" class="txt" value="" style="width:280px;" /> &nbsp; *邮箱</td>
					</tr>
					<?php if( C('COMMENT_VERIFY') == 1 ){ ?>
					<tr>
						<td><input type="text" name="verify" id="verify" class="txt" style="width:200px;" /> &nbsp; <img id="verifyImg" SRC="<?php echo U("comment/verify");?>" onClick="fleshVerify()" BORDER="0" ALT="点击刷新验证码" style="cursor:pointer;" align="absmiddle"></td>
					</tr>
					<?php } ?>
					<tr>
						<td><textarea class="txtarea" name="msg" id="e_textarea" class="txt" style="height:120px;"></textarea></td>
					</tr>
					<tr>
						<td><input type="submit" class="do_post_com" value="提交评论" /></td>
					</tr>
				</table>
			</form>
		</div>
		<?php } ?>
	</div>

            </div>
	</div>
	<div style="clear:both;"></div>
</div>
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