<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html><html><head><meta charset="utf-8"><link rel="stylesheet" type="text/css" href="../Public/style/layout.css" /><script type="text/javascript" src="__JS__/jQuery/jquery.js"></script><script type="text/javascript">			$(function(){
			
				__checkpress('#custom_width');
				__checkpress('#custom_height');
			
				$('#chk_upload').click(function(){
					var c_width = $.trim($('#custom_width').val());
					var c_height = $.trim($('#custom_height').val());
					if ( c_width != '' ){
						if ( __checkinput('#custom_width','自定义裁切图片的宽度必须为数字！') == false ) return false;
					}
					if ( c_height != '' ){
						if ( __checkinput('#custom_height','自定义裁切图片的高度必须为数字！') == false ) return false;
					}
				});
			});
			
			function __checkinput( element, message ){
				var value = $(element).val();
				if ( !/^\d+$/.test(value) ){
					if ($(element).hasClass('error_input') == false){
						$(element).addClass('error_input').after('<span class="error_info">'+message+'</span>');
					}
					$(element).focus();
					return false;
				}
			}
			
			function __checkpress(e){
				$(e).keyup(function(){
					if ( $.trim($(e).val()) == '' ){
						if ($(this).hasClass('error_input')){
			        		$(this).removeClass('error_input').next('.error_info').remove();
			        	}
					}
				});
			
		    	$(e).keypress(function(){
		        	if ($(this).hasClass('error_input')){
		        		$(this).removeClass('error_input').next('.error_info').remove();
		        	}
		        });
		    }
		</script><style type="text/css">        	body			{text-align:left;background:#fff; font-size:14px;}
        	ul				{ list-style:none; }
        	ul li			{ margin:10px; }
        	.inputpadding	{ padding:5px; }
        	.error_input	{ border: 1px solid #e46c6e; background : #f4ebec; }
    		.error_info		{ color: #e46c6e; margin-left : 10px; }
        </style></head><body><form name="photo" enctype="multipart/form-data" action="<?php echo U('uploadpost');?>" method="post" style="padding:25px 0px 0px 25px;"><ul><li>自定义裁切大小：（如果不填写自定义裁切大小则默认宽：“<?php echo C('PIC_THUMB_WIDTH');?>px”，高：“<?php echo C('PIC_THUMB_HEIGHT');?>px”。）</li><li>要裁切的宽度 <input type="text" name="custom_width" id="custom_width" size="20" class="t_input inputpadding" /> px</li><li>要裁切的高度 <input type="text" name="custom_height" id="custom_height" size="20" class="t_input inputpadding" /> px</li><li>要上传的文件 <input type="file" name="image" size="30" class="t_input" /></li><li style="padding-left:88px;"><input type="submit" name="upload" id="chk_upload" value="开始上传" class="submit" /></li></ul></form></body></html>