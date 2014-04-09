<?php if (!defined('THINK_PATH')) exit();?><!doctype html><html><head><title><?php echo C('SITE_TITLE');?></title><meta charset="utf-8" /><script type="text/javascript"> var module = '<?php echo strtolower(MODULE_NAME); ?>'; var action = '<?php echo ACTION_NAME;?>'; var tag_id = '<?php echo ($_GET["tag"]); ?>'; var node = '<?php echo ($_GET["node"]); ?>'; </script><link rel="stylesheet" type="text/css" href="../Public/style/layout.css" /><script type="text/javascript" src="__JS__/jQuery/jquery.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/cookie.js"></script><script type="text/javascript" src="__JS__/jQuery/plugin/ajaxUpload.js"></script><script type="text/javascript" src="__JS__/NDlogpublic.js"></script><script type="text/javascript" src="../Public/js/common.js"></script><script type="text/javascript">
			jQuery(document).ready(function($){
				$('form').submit(function(){
					var title = $('#title');
					var titval = $.trim(title.val());
			       	if ( titval == '' ){
			           	NDlog._showErrorInfo( title, '标题必须填写！' );
			           	return false;
			       	}
			       	if ( $('form').find('input[name="banner"]').length == 0 ){
			           	alert('未上传广告图片！')
			           	return false;
			       	}
			       	var url = $('input[name="url"]');
					var url_val = $.trim( url.val() );
					var exp = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
					var objExp = new RegExp(exp);
					if ( url_val == '' ){
						NDlog._showErrorInfo(url,'URL链接地址必须填写！');
						return false;
					}
					if( objExp.test(url_val) === false ){
						NDlog._showErrorInfo(url,'无效的链接地址，请正确填写！');
						return false;
					}
			   	});
			});
			function ajaxFileUpload(){
                if ($("#filedata").val() == ''){
                    alert('请选择要上传的文件！');
                    return false;
                }
                //starting setting some animation when the ajax starts and completes
                $("#loading").ajaxStart(function(){ $(this).show(); }).ajaxComplete(function(){ $(this).hide(); });
        
                $.ajaxFileUpload({
                    url:'<?php echo U("uploadfile/upfile");?>', 
                    secureuri:false,
                    fileElementId:'filedata',
                    dataType: 'json',
                    success: function (data, status){
                        //alert(data.msg.url);
                        if(typeof(data.error) != 'undefined'){
                            if(data.error != ''){
                                alert(data.error);
                            }else{
                                alert(data.msg);
                            }
                        }
                        $("#set_banner").after("<tr id='img_display'><td align='left'><img src='"+data.msg.url+"' width=\"600\" /><input type='hidden' name='banner' value='"+data.msg.url+"' /></td></tr>");
                        $("#buttonUpload").attr("disabled","disabled");
                        $("#filedata").attr("disabled","disabled");
                        $("#buttonUpload").after(" &nbsp;&nbsp;&nbsp; <input type='button' class='attButton submit' id='removebanner' onclick=\"return removeFile();\" value='删除' />");
                    },
                    error: function (data, status, e){
                        alert(e);
                    }
                });
                return false;
            }
            function removeFile(){
				$.post("<?php echo U('uploadfile/removefile');?>",function(data){
					if ( data.status == 1 ){
						$("#buttonUpload").removeAttr("disabled");
						$("#filedata").removeAttr("disabled");
						$("#img_display").remove();
						$("#removebanner").remove();
					}
				},'json');
				return false;
			}
		</script><style type="text/css" media="all">
			.t_input	{ padding: 6px; }
		</style></head><body><div id="wrap"><div id="header"><ul class="nav"><li class="home" rel="index"><a href="__APP__">首页</a></li><?php if(is_array($root_node)): $i = 0; $__LIST__ = $root_node;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$root): $mod = ($i % 2 );++$i; $action = $root['action']; if( empty( $root['action'] ) ){ $action = 'index'; } ?><li class="li <?php echo ($root["module"]); ?>" rel="<?php echo ($root["module"]); ?>"><a href="<?php echo U($root['module'].'/'.$action,array('node'=>$root['id']));?>"><?php echo ($root["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?><li class="li logout" rel="logout"><a href="<?php echo U('public/logout');?>">注销</a></li></ul></div><div id="container"><div id="sidebar_switch"></div><div id="content"><div id="c_warp"><form action="<?php echo U('insert');?>" method="post"><?php if( $type == 'free' ) { ?><input type="hidden" name="type" id="type" value="<?php echo ($type); ?>" /><?php } ?><table class="table_form" cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td align="left"><input type="text" name="title" id="title" class="t_input w480" /><p class="remark">广告标题</p></td></tr><tr><td align="left"><input type="text" name="url" class="t_input w480" /><p class="remark">广告链接URL地址</p></td></tr><?php if( $type == 'focus' ) { ?><tr><td align="left"><input type="text" name="type" class="t_input w280" value="<?php echo ($type); ?>" /><p class="remark">自定义标识符，可用于读取某标识组图。</p></td></tr><?php  } if( $_SESSION["other_upload_list"] ){ ?><tr><td><span class="file_d_Upload"><input id="filedata" type="file" class="attText t_input" style="padding:2px;" name="filedata" disabled="disabled" />
									 &nbsp;&nbsp; 
									<input class="submit" type="button" id="buttonUpload" onclick="return ajaxFileUpload();" disabled="disabled" value="点击上传图片" />
									 &nbsp;&nbsp; 
									<input class='submit' type="button" id='removebanner' onclick="return removeFile();" value="删除" /></span></td></tr><tr id='img_display'><td><?php
 foreach ( $_SESSION["other_upload_list"] as $key => $value ){ ?><p><img src='__ATTACH__/<?php echo ($value["savename"]); ?>' width="600" /><input type='hidden' name='img[<?php echo ($key); ?>]' value='__ATTACH__/<?php echo ($value["savename"]); ?>' /></p><?php
 } ?></td></tr><?php
 }else{ ?><tr id="set_banner"><td align="left"><span class="file_d_Upload"><input id="filedata" type="file" class="attText t_input" style="padding:2px;" name="filedata"> &nbsp;&nbsp;&nbsp; 
											<input type="button" class="attButton submit" id="buttonUpload" onclick="return ajaxFileUpload();" value="点击上传图片" /></span></td></tr><?php
 } ?><tr style="display:none;" id="loading"><td></td><td align='left'><img src="__THEMES__/images/loading.gif" /></td></tr><tr><td align="left"><input type="radio" name="status" value="1" checked="checked" /> 显示 &nbsp;&nbsp;
			                        <input type="radio" name="status" value="0" /> 隐藏 &nbsp;&nbsp;
			                    </td></tr><tr><td align="left"><textarea name="dsp" id="dsp" style="width: 90%; height:160px;" class="t_input"></textarea><p class="remark">详细说明</p></td></tr><tr><td align="left"><input type="submit" class="submit" value="提交表单" />
			                    	&nbsp;&nbsp;&nbsp;
			                    	<input type="button" class="submit" value="返回" onclick="window.location.href='<?php echo U('advs',array('type'=>$type,'node'=>$_GET['node']));?>';" /></td></tr></table></form></div></div><div id="sidebar"><div id="user_info"><div class="avatar"><img src="<?php echo (getuseravatar($_SESSION['AUTH']['id'])); ?>" width="45" /></div><dl class="info"><dt><?php echo ($_SESSION['AUTH']['nickname']); ?><dt><dd><?php echo ($_SESSION['AUTH']['remark']); ?></dd></dl><div class="clear"></div></div><?php if( $sidebar ){ ?><ol class="action_list"><?php if(is_array($sidebar)): $i = 0; $__LIST__ = $sidebar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sidebar): $mod = ($i % 2 );++$i; if ( !empty( $sidebar['type_name'] ) ){ $json = json_decode($sidebar['type_name'],true); }else{ $json = array(); } $node['node'] = $sidebar['pid']; $node['tag'] = $sidebar['id']; $param = array_merge( $json, $node ); ?><li rel="<?php echo ($sidebar["module"]); ?>_<?php echo ($sidebar["action"]); ?>" tag="<?php echo ($sidebar["id"]); ?>"><a href="<?php echo U($sidebar['module'].'/'.$sidebar['action'],$param);?>"><?php echo ($sidebar["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?></ol><?php }else{ ?><div id="a_list"></div><?php } ?></div></div></div></body></html>