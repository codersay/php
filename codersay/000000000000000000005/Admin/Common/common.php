<?php
/***********************************************************
    [w3note] (C)2013 w3note
	@function 后台函数库
    @Filename common.php $
    @Author WBlog $(http://www.w3note.com)
*************************************************************/
/**
* 转换字节数为其他单位
*/
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
//删除目录函数
function deldir($dirname){
	if(file_exists($dirname)){
		$dir = opendir($dirname);
		while($filename = readdir($dir)){
		 if($filename != "." && $filename != ".."){
			$file = $dirname."/".$filename;
			if(is_dir($file)){
				deldir($file); //使用递归删除子目录	
			}else{
			  @unlink($file);
			}
		  }
	    }
			closedir($dir);
			rmdir($dirname);
	}
}
//判断文件夹是否为空，空则返回真
function empty_dir($directory){

$handle = opendir($directory);
while (($file = readdir($handle)) !== false){

if ($file != "." && $file != ".."){

closedir($handle);
return false;
}
}
closedir($handle);
return true;
} 

//加密算法
function pwdHash($password) {
	 return md5(md5(trim($password)).C('KEYCODE'));
	 //return md5(trim($password));
}
	

//返回目录的大小
function dirSize($directory) {     	
		$dir_size=0;              	

		if($dir_handle=@opendir($directory)) {           		
			while($filename=readdir($dir_handle)) {      		
				if($filename!="." && $filename!="..") {  	
				    $subFile=$directory."/".$filename;   	
					if(is_dir($subFile))               	
						$dir_size+=dirSize($subFile);   
					if(is_file($subFile))               	
						$dir_size+=filesize($subFile);  
				}
			}
			closedir($dir_handle);                    
			return $dir_size;                        
		}
	}
//返回彩色的字符
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
//随机获取颜色
function rcolor() {
$rand = rand(0,255);
return sprintf("%02X","$rand");
}
function rand_color(){

	return '#'.rcolor().rcolor().rcolor();
}
function getTitleSize($count){

    $size = (ceil($count/10)+11).'px';
    return $size;
}

//截取字符串
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
    if(function_exists("mb_substr")) {
      if($suffix) {
   
         if($str==mb_substr($str, $start, $length, $charset)) { 
        
            return mb_substr($str, $start, $length, $charset); 
         }
         else {
        
            return mb_substr($str, $start, $length, $charset)."..."; 
         }  
    }
        else  { 

     return mb_substr($str, $start, $length, $charset);
    }
    }
    elseif(function_exists('iconv_substr')) {
      if($suffix) {
   
         if($str==iconv_substr($str,$start,$length,$charset))  {
        
            return iconv_substr($str,$start,$length,$charset); 
         }
         else {
        
            return iconv_substr($str,$start,$length,$charset)."..."; 
         } 
     }
        else { 
 
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
function is_badword($string) {
	$badwords = array("\\",'&',' ',"'",'"','/','*',',','<','>',"\r","\t","\n","#");
	foreach($badwords as $value){
		if(strpos($string, $value) !== FALSE) {
			return TRUE;
		}
	}
	return FALSE;
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
 * 检查密码长度是否符合规定
 */
function is_password($password) {
	$strlen = strlen($password);
	if($strlen >= 6 && $strlen <= 20) return true;
	return false;
}

function create_keycode($lenth) {
	return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}

function random($length, $chars = '0123456789') {
	$hash = '';
	$max = strlen($chars) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	return $hash;
}
?>