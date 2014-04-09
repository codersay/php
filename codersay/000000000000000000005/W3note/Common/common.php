<?php
	function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
		if(function_exists("mb_substr")) {
		  if($suffix){
			 if($str==mb_substr($str, $start, $length, $charset)){ 
			 
				return mb_substr($str, $start, $length, $charset); 
			 }
			 else{
			 
				return mb_substr($str, $start, $length, $charset)."..."; 
			 }  
	 }
			else{  
	 
		 return mb_substr($str, $start, $length, $charset);
		}
		}
		elseif(function_exists('iconv_substr')) {
		  if($suffix){
		
			 if($str==iconv_substr($str,$start,$length,$charset)){ 
			 
				return iconv_substr($str,$start,$length,$charset); 
			 }
			 else{
			 
				return iconv_substr($str,$start,$length,$charset)."..."; 
			 } 
		 }
			else{  
	 
		 return iconv_substr($str,$start,$length,$charset);
		}
		}
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
		if($suffix) return $slice."…";
		return $slice;
	}
	function blogTags($tags){
	
		$tags = explode(' ',$tags);
		$str = '';
		foreach($tags as $key=>$val) {
			$tag =  trim($val);
			$str  .= ' <a href="'.__APP__.'/blog/tag/name/'.urlencode($tag).'">'.$tag.'</a>  ';
			
		}
		return $str;
	}
	function webTags($tags){
	
		$tags = explode(' ',$tags);
		$str = '';
		foreach($tags as $key=>$val) {
			$tag =  trim($val);
			$str  .= ' <a href="'.__APP__.'/read/tag/name/'.urlencode($tag).'">'.$tag.'</a>  ';
			
		}
		return $str;
	}		
	/**
	* 产生随机字符串
	*/
	function random() {
		$hash = '';
		$chars = 'abcdef0123';
		$max = strlen($chars) - 1;
		for($i = 0; $i < 2; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}
	function tourl($url) {
		$url= str_replace("//","#",$url);
		$url=str_replace(":","%",$url);
		$url=str_replace(".","@",$url);
		
		for ($i=0;$i<strlen($url);$i++){ 
			$urls.= $url[$i].random();
		}
		return $urls;
	
		
		}
	function sizecount($filesize) {
		if ($filesize >= 1073741824) {
			$filesize = round($filesize / 1073741824 * 100) / 100 .' GB';
		} elseif ($filesize >= 1048576) {
			$filesize = round($filesize / 1048576 * 100) / 100 .' MB';
		} elseif($filesize >= 1024) {
			$filesize = round($filesize / 1024 * 100) / 100 . ' KB';
		} else {
			$filesize = $filesize.' Bytes';
		}
		return $filesize;
	}
	function color_txt($str){
	
		if(function_exists('iconv_strlen')) {
			$len  = iconv_strlen($str);
		}else if(function_exists('mb_strlen')) {
			$len = mb_strlen($str);
		}
		$colorTxt = '';
		for($i=0; $i<$len; $i++) {
				   $colorTxt .=  '<span style="color:'.rand_color().'">'.msubstr($str,$i,1,'utf-8','').'</span>';
		 }
	
		return $colorTxt;
	}
	function rcolor() {
	$rand = rand(0,255);
	return sprintf("%02X","$rand");
	}
	function rand_color(){
	
		return '#'.rcolor().rcolor().rcolor();
	}
	function getTitleSize(){
	
		$size = (rand(2,8)+rand(2,5)+rand(2,5)).'px';
		return $size;
	}
	function showExt($ext,$pic=true) {
		static $_extPic = array(
			'dir'=>"folder.gif",
			'doc'=>'msoffice.gif',
			'rar'=>'rar.gif',
			'zip'=>'zip.gif',
			'txt'=>'text.gif',
			'pdf'=>'pdf.gif',
			'html'=>'html.gif',
			'png'=>'image.gif',
			'gif'=>'image.gif',
			'jpg'=>'image.gif',
			'php'=>'text.gif',
		);
		static $_extTxt = array(
			'dir'=>'文件夹',
			'jpg'=>'JPEG图象',
			);
		if($pic) {
			if(array_key_exists(strtolower($ext),$_extPic)) {
				$show = "<IMG SRC='__PUBLIC__/wblog/extension/".$_extPic[strtolower($ext)]."' BORDER='0' alt='' align='absmiddle'>";
			}else{
				$show = "<IMG SRC='__PUBLIC__/wblog/extension/common.gif' WIDTH='16' HEIGHT='16' BORDER='0' alt='文件' align='absmiddle'>";
			}
		}else{
			if(array_key_exists(strtolower($ext),$_extTxt)) {
				$show = $_extTxt[strtolower($ext)];
			}else{
				$show = $ext?$ext:'文件夹';
			}
		}
	
		return $show;
	}
	function byte_format($input, $dec=0){
	
	  $prefix_arr = array("B", "K", "M", "G", "T");
	  $value = round($input, $dec);
	  $i=0;
	  while ($value>1024){
	
		 $value /= 1024;
		 $i++;
	  }
	  $return_str = round($value, $dec).$prefix_arr[$i];
	  return $return_str;
	}
	
//加密算法
function pwdHash($password) {
	 return md5(md5(trim($password)).C('KEYCODE'));
	 //return md5(trim($password));
}

/**
 * 检查用户名是否符合规定
 */
function is_username($username) {
	$strlen = strlen($username);
	if(is_badword($username) || !preg_match("/^[a-zA-Z0-9_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]+$/", $username)){
		return false;
	} elseif ( 20 < $strlen || $strlen < 2 ) {
		return false;
	}
	return true;
}
/**
 * 下面这两个方法需要用到php_curl组件，请确保你的PHP是否安装了此扩展
 */
function do_post($url, $data) {
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_POST, TRUE );
	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	$ret = curl_exec ( $ch );
	
	curl_close ( $ch );
	return $ret;
}

function get_url_contents($url) {
	if (ini_get ( "allow_url_fopen" ) == "1")
		return file_get_contents ( $url );
	
	$ch = curl_init ();
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE );
	curl_setopt ( $ch, CURLOPT_URL, $url );
	$result = curl_exec ( $ch );
	curl_close ( $ch );
	
	return $result;
}
?>