<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><title><?php echo C('SITE_TITLE');?></title><meta charset="utf-8" /><script type="text/javascript"> var module = '<?php echo strtolower(MODULE_NAME); ?>'; var action = '<?php echo ACTION_NAME;?>'; var tag_id = '<?php echo ($_GET["tag"]); ?>'; var node = '<?php echo ($_GET["node"]); ?>'; </script><link rel="stylesheet" type="text/css" href="../Public/style/layout.css" /><link rel="stylesheet" type="text/css" href="__JS__/jQuery/jQuery_ui/themes/base/jquery-ui.css" /><script type="text/javascript" src="__JS__/jQuery/jquery.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/cookie.js"></script><script type="text/javascript" src="__JS__/jQuery/jQuery_ui/ui/jquery-ui.js"></script><script type="text/javascript" src="__JS__/NDlogpublic.js"></script><script type="text/javascript" src="../Public/js/common.js"></script><script type="text/javascript">			(function($) {
			  	$.fn.outerHTML = function() {
			    	return $(this).clone().wrap('<div></div>').parent().html();
			  	}
			})(jQuery);
			
			jQuery(document).ready(function($){
				$('a.closeEl').bind('click', toggleContent);
				$("#offWidget, #onWidget").sortable({
					connectWith: ['.connectedSortable']
				});
			});
			var toggleContent = function(e){
				var targetContent = $('div.itemContent', this.parentNode.parentNode);
				var title = $(this).find('.title').outerHTML();
				if (targetContent.css('display') == 'none') {
					targetContent.slideDown(300);
					$(this).html(title+'[-]');
				} else {
					targetContent.slideUp(300);
					$(this).html(title+'[+]');
				}
				return false;
			};

			function serialize(){
				var offWidget='';
				$("#offWidget li").each(function(){
					offWidget += 'offWidget[]='+$(this).attr('id')+'&';
				});
				$("#off").attr("value",offWidget);

				var onWidget='';
				$("#onWidget li").each(function(){
					onWidget += 'onWidget[]='+$(this).attr('id')+'&';
				});
				$("#on").attr("value",onWidget);
				
				$("#widgetForm").submit();
			}
		</script><style type="text/css" media="all">			#offWidget, #onWidget { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; width: 32%; }
			#offWidget li, #onWidget li { margin: 0px 0px 20px 0px; width: 220px; }
			.itemHeader{ padding: 7px 11px; border-bottom: 1px solid #ddd; background: #eee; }
			.itemContent { padding:10px 13px; }
			.ui-state-default {
				background:#fff repeat-x scroll 50% 50%;
				border:1px solid #CCCCCC;
				font-weight:bold;
				outline-color:-moz-use-text-color;
				outline-style:none;
				outline-width:medium;
			}
		</style></head><body><div id="wrap"><div id="header"><ul class="nav"><li class="home" rel="index"><a href="__APP__">首页</a></li><?php if(is_array($root_node)): $i = 0; $__LIST__ = $root_node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$root): $mod = ($i % 2 );++$i; $action = $root['action']; if( empty( $root['action'] ) ){ $action = 'index'; } ?><li class="li <?php echo ($root["module"]); ?>" rel="<?php echo ($root["module"]); ?>"><a href="<?php echo U($root['module'].'/'.$action,array('node'=>$root['id']));?>"><?php echo ($root["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="li logout" rel="logout"><a href="<?php echo U('public/logout');?>">注销</a></li></ul></div><div id="container"><div id="sidebar_switch"></div><div id="content"><div id="c_warp"><div style="width: 32%; margin-left: 1%; margin:0 1% 20px 0; float: left;"><h4>未启用的Widget</h4></div><div style="width: 32%; margin-left: 1%; margin:0 1% 20px 0; float: left;"><h4>已启用的Widget</h4></div><div class="clear"></div><ul id="offWidget" class="connectedSortable"><?php if(is_array($offWidget)): $i = 0; $__LIST__ = $offWidget;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$off): $mod = ($i % 2 );++$i;?><li id="<?php echo ($off["id"]); ?>" class="ui-state-default"><div class="itemHeader"><a href="#" class="closeEl"><span class="title"><?php echo ($off["title"]); ?> - <?php echo (input::forshow($off["name"])); ?></span>[-]</a></div><div class="itemContent"><?php echo (input::forshow($off["remark"])); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><ul id="onWidget" class="connectedSortable"><?php if(is_array($onWidget)): $i = 0; $__LIST__ = $onWidget;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$on): $mod = ($i % 2 );++$i;?><li id="<?php echo ($on["id"]); ?>" class="ui-state-default"><div class="itemHeader"><a href="#" class="closeEl"><span class="title"><?php echo ($on["title"]); ?> - <?php echo (input::forshow($on["name"])); ?></span>[-]</a></div><div class="itemContent"><?php echo (input::forshow($on["remark"])); ?></div></li><?php endforeach; endif; else: echo "" ;endif; ?></ul><div class="clear"></div><form id="widgetForm" method="POST" action="<?php echo U('widgetConfig');?>"><input name="offWidget" id="off" type="hidden"><input name="onWidget" id="on" type="hidden"><input type="button" class="submit" value="保存" onclick="serialize()"></form></div></div><div id="sidebar"><div id="user_info"><div class="avatar"><img src="<?php echo (getuseravatar($_SESSION['AUTH']['id'])); ?>" width="45" /></div><dl class="info"><dt><?php echo ($_SESSION['AUTH']['nickname']); ?><dt><dd><?php echo ($_SESSION['AUTH']['remark']); ?></dd></dl><div class="clear"></div></div><?php if( $sidebar ){ ?><ol class="action_list"><?php if(is_array($sidebar)): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sidebar): $mod = ($i % 2 );++$i; if ( !empty( $sidebar['type_name'] ) ){ $json = json_decode($sidebar['type_name'],true); }else{ $json = array(); } $node['node'] = $sidebar['pid']; $node['tag'] = $sidebar['id']; $param = array_merge( $json, $node ); ?><li rel="<?php echo ($sidebar["module"]); ?>_<?php echo ($sidebar["action"]); ?>" tag="<?php echo ($sidebar["id"]); ?>"><a href="<?php echo U($sidebar['module'].'/'.$sidebar['action'],$param);?>"><?php echo ($sidebar["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol><?php }else{ ?><div id="a_list"></div><?php } ?></div></div></div></body></html>