<?php
	/**
	 +----------------------------------------------------------
	 * 字符串截取，支持中文和其他编码
	 +----------------------------------------------------------
	 * @static
	 * @access public
	 +----------------------------------------------------------
	 * @param string $str 需要转换的字符串
	 * @param string $start 开始位置
	 * @param string $length 截取长度
	 * @param string $charset 编码格式
	 * @param string $suffix 截断显示字符
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
	    if(function_exists("mb_substr"))
	        $slice = mb_substr($str, $start, $length, $charset);
	    elseif(function_exists('iconv_substr')) {
	        $slice = iconv_substr($str,$start,$length,$charset);
	        if(false === $slice) {
	            $slice = '';
	        }
	    }else{
	        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
	        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
	        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
	        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
	        preg_match_all($re[$charset], $str, $match);
	        $slice = join("",array_slice($match[0], $start, $length));
	    }
	    return $suffix ? $slice.'...' : $slice;
	}
	
	/**
	 +----------------------------------------------------------
	 * 字节格式化 把字节数格式为 B K M G T 描述的大小
	 +----------------------------------------------------------
	 * @return string
	 +----------------------------------------------------------
	 */
	function byte_format($size, $dec=2) {
		$a = array("B", "KB", "MB", "GB", "TB", "PB");
		$pos = 0;
		while ($size >= 1024) {
			 $size /= 1024;
			   $pos++;
		}
		return round($size,$dec)." ".$a[$pos];
	}
	
	//输出安全的html
	function h($text, $tags = null) {
		$text	=	trim($text);
		//完全过滤注释
		$text	=	preg_replace('/<!--?.*-->/','',$text);
		//完全过滤动态代码
		$text	=	preg_replace('/<\?|\?'.'>/','',$text);
		//完全过滤js
		$text	=	preg_replace('/<script?.*\/script>/','',$text);
	
		$text	=	str_replace('[','&#091;',$text);
		$text	=	str_replace(']','&#093;',$text);
		$text	=	str_replace('|','&#124;',$text);
		//过滤换行符
		$text	=	preg_replace('/\r?\n/','',$text);
		//br
		$text	=	preg_replace('/<br(\s\/)?'.'>/i','[br]',$text);
		$text	=	preg_replace('/(\[br\]\s*){10,}/i','[br]',$text);
		//过滤危险的属性，如：过滤on事件lang js
		while(preg_match('/(<[^><]+)( lang|on|action|background|codebase|dynsrc|lowsrc)[^><]+/i',$text,$mat)){
			$text=str_replace($mat[0],$mat[1],$text);
		}
		while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
			$text=str_replace($mat[0],$mat[1].$mat[3],$text);
		}
		if(empty($tags)) {
			$tags = 'table|td|th|tr|i|b|u|strong|img|p|br|div|strong|em|ul|ol|li|dl|dd|dt|a';
		}
		//允许的HTML标签
		$text	=	preg_replace('/<('.$tags.')( [^><\[\]]*)>/i','[\1\2]',$text);
		//过滤多余html
		$text	=	preg_replace('/<\/?(html|head|meta|link|base|basefont|body|bgsound|title|style|script|form|iframe|frame|frameset|applet|id|ilayer|layer|name|script|style|xml)[^><]*>/i','',$text);
		//过滤合法的html标签
		while(preg_match('/<([a-z]+)[^><\[\]]*>[^><]*<\/\1>/i',$text,$mat)){
			$text=str_replace($mat[0],str_replace('>',']',str_replace('<','[',$mat[0])),$text);
		}
		//转换引号
		while(preg_match('/(\[[^\[\]]*=\s*)(\"|\')([^\2=\[\]]+)\2([^\[\]]*\])/i',$text,$mat)){
			$text=str_replace($mat[0],$mat[1].'|'.$mat[3].'|'.$mat[4],$text);
		}
		//过滤错误的单个引号
		while(preg_match('/\[[^\[\]]*(\"|\')[^\[\]]*\]/i',$text,$mat)){
			$text=str_replace($mat[0],str_replace($mat[1],'',$mat[0]),$text);
		}
		//转换其它所有不合法的 < >
		$text	=	str_replace('<','&lt;',$text);
		$text	=	str_replace('>','&gt;',$text);
		$text	=	str_replace('"','&quot;',$text);
		 //反转换
		$text	=	str_replace('[','<',$text);
		$text	=	str_replace(']','>',$text);
		$text	=	str_replace('|','"',$text);
		//过滤多余空格
		$text	=	str_replace('  ',' ',$text);
		return $text;
	}