	
	jQuery(document).ready(function($) {
		var window_resize = function(){
			var width = $(window).width();
			var height = $(window).height();
			var header_height = $('#header').height();
			var sidebar_width = $('#sidebar').width();
			var body_padding = 40;
			$('#wrap').css({
				'height' : height - body_padding - 2
			});
			$('#sidebar').css({
				'position' : 'absolute',
				'top' : 0,
				'left' : 0,
				'height' : height - body_padding - 35
			});
			$('#content').css({
				'height' : height - body_padding - 35
			});
		}
		window_resize();
		$(window).resize(window_resize);

		var domian = window.location.host;
		var _cookie = domian + '_sidebar_status';
		var status = $.cookie(_cookie);
		
		if ( status == null ){
			$.cookie(_cookie,'on'); var status = 'on';
		}
		switch( status ){
			case 'on' :
				$('#sidebar').css({
					'width' : '220px',
					'overflow' : 'visible'
				});
				$('#sidebar_switch').removeClass('off').addClass('on');
				$('#content').css('margin-left','220px');
				break
			case 'off' :
				$('#sidebar').css({
					'width' : '0px',
					'overflow' : 'hidden'
				});
				$('#sidebar_switch').removeClass('on').addClass('off');
				$('#content').css('margin-left','0');
				break;
		}
		$('#sidebar_switch').click(function(){
			var _status = $.cookie(_cookie);
			switch( _status ){
				case 'on' :
					$('#sidebar').css('overflow','hidden').animate({'width' : '0px'}, 200);
					$(this).removeClass('on').addClass('off');
					$('#content').css('margin-left','0px');
					$.cookie(_cookie,'off');
					break;
				case 'off' :
					$('#sidebar').css('overflow','visible').animate({'width' : '220px'}, 200);
					$(this).removeClass('off').addClass('on');
					$('#content').css('margin-left','220px');
					$.cookie(_cookie,'on');
					break;
			}
		});

		//顶部导航当前状态
		$('#header li[rel="'+module+'"]').addClass('active');
		//侧边菜单当前状态
		if ( tag_id != '' ){
			var _element = $('#sidebar li[tag="'+tag_id+'"]');
		}else{
			var _element = $('#sidebar li[rel="'+module+'_'+action+'"]');
			if ( _element.length > 1 ) {
				var _element = _element.eq( 0 );
			}
		}
		_element.addClass('active').find('a').css('width','194px');
	});