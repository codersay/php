<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><title><?php echo C('SITE_TITLE');?></title><meta charset="utf-8" /><script type="text/javascript"> var module = '<?php echo strtolower(MODULE_NAME); ?>'; var action = '<?php echo ACTION_NAME;?>'; var tag_id = '<?php echo ($_GET["tag"]); ?>'; var node = '<?php echo ($_GET["node"]); ?>'; </script><link rel="stylesheet" type="text/css" href="../Public/style/layout.css" /><script type="text/javascript" src="__JS__/jQuery/jquery.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/cookie.js"></script><script type="text/javascript" src="__JS__/NDlogpublic.js"></script><script type="text/javascript" src="../Public/js/common.js"></script><script type="text/javascript">			$(function(){
				NDlog._setTableStyle( 'input[name="all"]', 'input[name="ids[]"]', '.rows_style' );
				$('.esort').dblclick(function(){
					var id = $(this).attr('rel');
					var ovalue = $(this).text();
					$(this).html('<input type="text" name="sort_one" id="edit_'+id+'" class="t_input" style="width:24px;" value="'+ovalue+'" />');
					$('#edit_'+id).focus().live('blur',function(){
						var value = $(this).val();
						if ( !/^\d+$/.test(value) ){
							alert('排序必须为正整数！');
							return false;
						}else{
							$(this).parent().html(value);
							if ( ovalue != value ){
								$.post('<?php echo U("updateOneSort");?>',{id:id,sort:value});
							}
						}
					});
				});
				$('.ename').dblclick(function(){
					var tis = $(this);
					var id = tis.attr('rel');
					var val = tis.text();
					tis.html('<input type="text" name="name_one" id="edit_name_'+id+'" class="t_input" value="'+val+'" />');
					$('#edit_name_'+id).focus().live('blur',function(){
						var value = $(this).val();
						tis.html( value );
						if ( value != val ){
							$.post('<?php echo U("updateOneName");?>',{id:id,name:value});
						}
					});
				});
			})
		</script><style type="text/css">			.cat_display	{ display: block; width:16px; height:16px; background:url(/board/themes/DBloger/Public/images/display.gif) no-repeat; }
			.cat_hidden		{ display: block; width:16px; height:16px; background:url(/board/themes/DBloger/Public/images/hidden.gif) no-repeat; }
			.left_c			{ width:60px; display: block; float: left; line-height: 26px; text-align:right; padding-right:10px; }
		</style></head><body><div id="wrap"><div id="header"><ul class="nav"><li class="home" rel="index"><a href="__APP__">首页</a></li><?php if(is_array($root_node)): $i = 0; $__LIST__ = $root_node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$root): $mod = ($i % 2 );++$i; $action = $root['action']; if( empty( $root['action'] ) ){ $action = 'index'; } ?><li class="li <?php echo ($root["module"]); ?>" rel="<?php echo ($root["module"]); ?>"><a href="<?php echo U($root['module'].'/'.$action,array('node'=>$root['id']));?>"><?php echo ($root["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="li logout" rel="logout"><a href="<?php echo U('public/logout');?>">注销</a></li></ul></div><div id="container"><div id="sidebar_switch"></div><div id="content"><div id="c_warp"><div class="button">提示：标题或排序可双击即时更改。</div><table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_list mt"><tr style="background: #f0f7ff; font-weight: bold;"><th width="30" align="center" class="left_text">排序</th><th width="60" align="center" class="left_text">编号</th><th width="20" class="left_text"></th><th align="center" class="left_text">分类名称</th><th align="center" class="left_text">上级分类</th><th align="center" class="left_text">类型</th><th width="80" align="center" class="left_text">操作</th></tr><?php echo ($list); ?></table></div></div><div id="sidebar"><div id="user_info"><div class="avatar"><img src="<?php echo (getuseravatar($_SESSION['AUTH']['id'])); ?>" width="45" /></div><dl class="info"><dt><?php echo ($_SESSION['AUTH']['nickname']); ?><dt><dd><?php echo ($_SESSION['AUTH']['remark']); ?></dd></dl><div class="clear"></div></div><?php if( $sidebar ){ ?><ol class="action_list"><?php if(is_array($sidebar)): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sidebar): $mod = ($i % 2 );++$i; if ( !empty( $sidebar['type_name'] ) ){ $json = json_decode($sidebar['type_name'],true); }else{ $json = array(); } $node['node'] = $sidebar['pid']; $node['tag'] = $sidebar['id']; $param = array_merge( $json, $node ); ?><li rel="<?php echo ($sidebar["module"]); ?>_<?php echo ($sidebar["action"]); ?>" tag="<?php echo ($sidebar["id"]); ?>"><a href="<?php echo U($sidebar['module'].'/'.$sidebar['action'],$param);?>"><?php echo ($sidebar["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol><?php }else{ ?><div id="a_list"></div><?php } ?></div></div></div></body></html>