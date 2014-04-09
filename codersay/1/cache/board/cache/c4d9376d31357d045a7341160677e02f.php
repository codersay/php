<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><title><?php echo C('SITE_TITLE');?></title><meta charset="utf-8" /><script type="text/javascript"> var module = '<?php echo strtolower(MODULE_NAME); ?>'; var action = '<?php echo ACTION_NAME;?>'; var tag_id = '<?php echo ($_GET["tag"]); ?>'; var node = '<?php echo ($_GET["node"]); ?>'; </script><link rel="stylesheet" type="text/css" href="../Public/style/layout.css" /><script type="text/javascript" src="__JS__/jQuery/jquery.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/cookie.js"></script><script type="text/javascript" src="__JS__/NDlogpublic.js"></script><script type="text/javascript" src="../Public/js/common.js"></script><link href="__JS__/jQuery/plugin/artDialog/skins/default.css" rel="stylesheet" /><script type="text/javascript" src="__JS__/jQuery/plugin/artDialog/artDialog.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/artDialog/artDialog.plugins.js"></script><script type="text/javascript">			$(function(){
				NDlog._setTableStyle( 'input[name="all"]', 'input[name="ids[]"]', '.rows_style' );
				$('#searchall').click(function(){
					var _self = $(this);
					var _title = _self.val();
					var _form = '\
					<form action="<?php echo U("search");?>">\
						<input type="hidden" name="a" value="search" />\
						<input type="hidden" name="m" value="<?php echo MODULE_NAME;?>" />\
						<div><input type="text" name="keyword" class="t_input w280" /> *关键字</div>\
						<div class="mt">\
							<input type="checkbox" name="title" style="vertical-align: middle;" checked="checked" /> 搜索标题 &nbsp;&nbsp;&nbsp; \
							<input type="checkbox" name="content" style="vertical-align: middle;" /> 搜索内容\
						</div>\
						<div class="mt"><input type="submit" class="submit" value="提交" /></div>\
					</form>';
					
					var _search = $.dialog({
						title : _title,
						lock : true,
						content : _form
					});
				});
				$('._publish_box').hover(function(){
				    var _p = $(this);
				    _p.find('._publish').show();
				},function(){
				    $(this).find('._publish').hide();
				});
				
				$('.select').change(function(){ $('#fts').submit(); });
				
				$('#actionOtherForm').submit(function(){
					var _checkbox = $('input[name="ids[]"]');
					var _i = 0;
					_checkbox.each(function(i){
						if ( $(this).attr('checked') ){
							_i = _i + 1;
						}
					});
					if ( _i == 0 ){
						$.alert('未选中任何信息！');
						return false;
					}
				});
				
				$('input[name="moveToCatalog"]').click(function(){
					var _select = $('#cidForm');
					if ( _select.val() == 0 ){
						$.alert('请选择移动的目标分类！');
						return false;
					}
				});
				
				$('input[name="batchAction"]').click(function(){
					var _select = $('#setBatchAction');
					if ( _select.val() == '' ){
						$.alert('请选择批量操作类型！');
						return false;
					}
				});
			})
		</script><style type="text/css">			input 			{ vertical-align: middle; }
			.ft				{ float: left; height:29px; }
			.raction		{ float: left; }
			.r_ac			{ float: right; height:29px; }
			.t_input		{ padding: 5px; }
			.icon_picture	{ display:block; float:left; width:14px; height:14px; background:url(__PUBLIC__/images/icon_picture.png) no-repeat; margin-right:6px; }
			._publish_box    { position: relative; height:30px; }
			._publish        { background:#f5f5f5; border:1px solid #ddd; position:absolute; right:0; top:28px; padding:0px 20px 20px 20px; }
			._publish a      { width:61px; height:82px; display:block; background:url(../Public/images/c4.png) no-repeat; margin-top:20px; }
			._publish .picture{ background-position-x: -61px; }
			._publish .music{ background-position-x: -122px; }
			._publish .video{ background-position-x: -183px; }
			._publish .broken{ background-position-x: -244px; }
			._publish a:hover{  }
		</style></head><body><div id="wrap"><div id="header"><ul class="nav"><li class="home" rel="index"><a href="__APP__">首页</a></li><?php if(is_array($root_node)): $i = 0; $__LIST__ = $root_node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$root): $mod = ($i % 2 );++$i; $action = $root['action']; if( empty( $root['action'] ) ){ $action = 'index'; } ?><li class="li <?php echo ($root["module"]); ?>" rel="<?php echo ($root["module"]); ?>"><a href="<?php echo U($root['module'].'/'.$action,array('node'=>$root['id']));?>"><?php echo ($root["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="li logout" rel="logout"><a href="<?php echo U('public/logout');?>">注销</a></li></ul></div><div id="container"><div id="sidebar_switch"></div><div id="content"><div id="c_warp"><div class="ft"><form action="<?php echo U('index');?>" id="fts"><input type="hidden" name="a" value="<?php echo ACTION_NAME;?>" /><input type="hidden" name="m" value="<?php echo MODULE_NAME;?>" /><input type="hidden" name="node" value="<?php echo ($_GET['node']); ?>" /><input type="hidden" name="tag" value="<?php echo ($_GET['tag']); ?>" /><?php if ( isset( $_GET['p'] ) ){ ?><input type="hidden" name="p" value="<?php echo ($_GET['p']); ?>" /><?php } ?><select name="cid" class="t_input select"><option value="0"> 筛选：选择分类 </option><?php echo ($option); ?></select>								&nbsp;&nbsp;&nbsp;
								<select name="status" class="t_input select"><option value=""<?php if(($_GET['status'] == '') OR (!isset($_GET['status']))): ?>selected="selected"<?php endif; ?>> 筛选：状态 </option><option value="0"<?php if(($_GET['status'] == '0') AND (isset($_GET['status']))): ?>selected="selected"<?php endif; ?>> 隐藏 </option><option value="1"<?php if(($_GET['status'] == '1') AND (isset($_GET['status']))): ?>selected="selected"<?php endif; ?>> 正常 </option></select>								&nbsp;&nbsp;&nbsp;
								<select name="type" class="t_input select"><?php echo ($typeOption); ?></select></form></div><form action="<?php echo U('actionOther');?>" method="post" id="actionOtherForm"><div class="r_ac"><select name="cid" class="t_input raction" style="margin-right: 5px;" id="cidForm"><option value="0"> 批量移动至 </option><?php echo ($option); ?></select><input type="submit" value="提交" name="moveToCatalog" class="submit raction" style="padding:6px 15px; margin-right: 15px;" /><select name="batch" id="setBatchAction" class="t_input raction" style="margin-right: 5px;"><option value=""> 批量操作 </option><option value="disable"> 禁用 </option><option value="enable"> 启用 </option><option value="del"> 删除 </option></select><input type="submit" value="提交" name="batchAction" class="submit raction" style="padding:6px 15px; margin-right: 15px;" /><input type="button" value="模糊搜索" id="searchall" class="submit raction" style="padding:6px 15px;" /></div><div class="clear"></div><table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_list mt"><tr><th width="20"><input type="checkbox" name="all" /></th><th align="center">名称</th><th align="center">分类</th><th width="100" align="center">状态</th><th width="160" align="center">操作</th></tr><?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr rel="<?php echo ($vo['id']); ?>" class="rows_style"<?php if( ( $i % 2 ) == 0 ){ ?> bgcolor="#f9f9f9"<?php }else{ ?> bgcolor="#ffffff"<?php } ?>><td align="center"><input type="checkbox" name="ids[]" value="<?php echo ($vo["id"]); ?>" /></td><td><?php if(!empty($vo['thumb']) && $vo['thumb'] != 'no_thumb.jpg'){ ?><span class="icon_picture" title="图集"></span><?php } ?><a href="<?php echo U('edit',array( 'id' => $vo['id'], 'cid' => $vo['cid'], 'type' => $vo['type'], 'node'=> $_GET['node'] ));?>"><?php echo ($vo['title']); ?></a></td><td align="center"><?php echo (getparentcategory($vo['cid'])); ?></td><td align="center"><?php echo (getstatus($vo['status'],false)); ?></td><td align="center"><?php echo (showstatus($vo['status'],$vo['id'],'navTabAjaxMenu')); ?><span class="c_line">|</span><a href="<?php echo U('edit',array( 'id' => $vo['id'], 'cid' => $vo['cid'], 'type' => $vo['type'], 'node'=> $_GET['node'] ));?>" class="edit_model">编辑</a><span class="c_line">|</span><a href="<?php echo U('delete',array('id' => $vo['id'],'cid' => $vo['cid']));?>" class="del_node" rel="<?php echo ($vo["id"]); ?>">删除</a></td></tr><?php endforeach; endif; else: echo "" ;endif; ?></table></form><div class="page"><?php echo ($page); ?></div></div></div><div id="sidebar"><div id="user_info"><div class="avatar"><img src="<?php echo (getuseravatar($_SESSION['AUTH']['id'])); ?>" width="45" /></div><dl class="info"><dt><?php echo ($_SESSION['AUTH']['nickname']); ?><dt><dd><?php echo ($_SESSION['AUTH']['remark']); ?></dd></dl><div class="clear"></div></div><?php if( $sidebar ){ ?><ol class="action_list"><?php if(is_array($sidebar)): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sidebar): $mod = ($i % 2 );++$i; if ( !empty( $sidebar['type_name'] ) ){ $json = json_decode($sidebar['type_name'],true); }else{ $json = array(); } $node['node'] = $sidebar['pid']; $node['tag'] = $sidebar['id']; $param = array_merge( $json, $node ); ?><li rel="<?php echo ($sidebar["module"]); ?>_<?php echo ($sidebar["action"]); ?>" tag="<?php echo ($sidebar["id"]); ?>"><a href="<?php echo U($sidebar['module'].'/'.$sidebar['action'],$param);?>"><?php echo ($sidebar["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol><?php }else{ ?><div id="a_list"></div><?php } ?></div></div></div></body></html>