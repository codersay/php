<?php
	/**
	 * =============================
	 * 获得上级分类名称
	 * @param INT $id 分类ID
	 * =============================
	 */
	function getParentCategory($id) {
		if ($id == 0) {
			return '无';
		}
		if ($list = F('categoryName')) {
			return $list[$id];
		}
		$dao = D("Category");
		$list = $dao->field('id,name')->select();
		foreach ($list as $vo) {
			$nameList[$vo['id']] = $vo['name'];
		}
		$name = $nameList[$id];
		F('categoryName', $nameList);
		return $name;
	}
	
	function getStatus($status, $imageShow = true) {
		$path = C('TMPL_PARSE_STRING');
		switch ($status) {
			case 0 :
				$showText = '禁用';
				$showImg = '&Theta;';
				break;
			case 2 :
				$showText = '待审';
				$showImg = '※';
				break;
			case - 1 :
				$showText = '删除';
				$showImg = '&Chi;';
				break;
			case 1 :
				$showText = '正常';
				$showImg = '&radic;';
		}
		return ($imageShow === true) ? $showImg : $showText;
	
	}
	
	/**
	 * =====================================================
	 * 判断状态，并按状态值返回链接
	 * @param INT $status 状态值 0 禁用 -1 已删除 1 正常 2未批准
	 * @param INT $id 数据条目ID
	 * @param string $callback JS回调值。默认空。
	 * =====================================================
	 */
	function showStatus($status, $id, $callback = "") {
		$_tag_fix = array();
		if ( isset( $_GET['tag'] ) ){
			$_tag_fix['tag'] = trim( $_GET['tag'] );
		}
		if ( isset( $_GET['node'] ) ){
			$_tag_fix['node'] = trim( $_GET['node'] );
		}
		$_tag_fix['id'] = $id;
		$info = '未知状态';

		switch ($status) {
			case 0 :
				$info = '<a href="' . U( 'resume', $_tag_fix ) .'">启用</a>';
				break;
			case 2 :
				$info = '<a href="' . U( 'pass', $_tag_fix ) . '">批准</a>';
				break;
			case 1 :
				$info = '<a href="' . U( 'forbid', $_tag_fix ) . '">禁用</a>';
				break;
			case - 1 :
				$info = '<a href="' . U( 'recycle', $_tag_fix ) . '">还原</a>';
				break;
		}
		return $info;
	}
	
	function cn_substr($str, $length, $start = 0) {
		if (strlen($str) < $start + 1) {
			return '';
		}
		preg_match_all("/./su", $str, $ar);
		$str = '';
		$tstr = '';
		//为了兼容mysql4.1以下版本,与数据库varchar一致,这里使用按字节截取
		for ($i = 0; isset($ar[0][$i]); $i++) {
			if (strlen($tstr) < $start) {
				$tstr .= $ar[0][$i];
			} else {
				if (strlen($str) < $length + strlen($ar[0][$i])) {
					$str .= $ar[0][$i];
				} else {
					break;
				}
			}
		}
		return $str;
	}
	
	/**
	 +-------------------------------------------------
	 * 获取用户名, 并缓存数据
	 * @param int $id 用户ID
	 * @return string 返回用户名
	 +-------------------------------------------------
	 */
	function getAuthorName($id){
		if ( $id == 0 ){
			return '未知';
		}
		if ($list = F('AuthorName')) {
			return $list[$id];
		}
		$dao = D("User");
		$list = $dao->field('id,nickname')->select();
		foreach ($list as $vo) {
			$nameList[$vo['id']] = $vo['nickname'];
		}
		$name = $nameList[$id];
		F('AuthorName', $nameList);
		return $name;
	}
	
	function checkSlidebar( $funs ){
		$list = '';
		if ( APP_NAME == 'applications' ){
			$slidebar = A('Index');
		}else{
			$slidebar = A('applications://Index');
		}
		$var = '';
		if ( !empty( $funs ) ){
			$var .= '$slidebar->' . $funs . '();';
			eval( "\$list = " . $var );
		}
		
		return $list;
	}
	
	function scanBackDir($filePath='./',$order=0){
        $filePath = opendir($filePath);
        while (false !== ($filename = readdir($filePath))) {
            $fileAndFolderAyy[] = $filename;
        }
        $order == 0 ? sort($fileAndFolderAyy) : rsort($fileAndFolderAyy);
        return $fileAndFolderAyy;
    }

    // UT*转GBK
	function utf8togbk($str){
		return iconv("UTF-8","GBK",$str);
	}
	// GBK转UTF8
	function gbktoutf8($str){
		return iconv("GBK","UTF-8//ignore",$str);
	}
	// 转换成JS
	function tojs($l1, $l2=1){
	    $I1 = str_replace(array("\r", "\n"), array('', '\n'), addslashes($l1));
	    return $l2 ? "document.write(\"$I1\");" : $I1;
	}
	// 去掉换行
	function removeBr($str){
		$str = str_replace(array("<nr/>","<rr/>"),array("\n","\r"),$str);
		return trim($str);
	}

	function utf8Str( $str, $length ){
		return ndsubstr( $str, 0, $length, false );
	}
	
	/**
	 * 新字符串截取
	 *	
	**/
	function ndsubstr( $str, $start=0, $length, $suffix=false ){
		return checkStr( eregi_replace('<[^>]+>','',ereg_replace("[\r\n\t ]{1,}",' ',removeEmpty($str))),$start,$length,'utf-8',$suffix );
	}
	
	//去掉连续空白
	function removeEmpty($str){
		$str = str_replace("&nbsp;",' ',$str);
		$str = str_replace("　",' ',$str);
		$str = ereg_replace("[\r\n\t ]{1,}",' ',$str);
		return trim($str);
	}
	
	function checkStr($str, $start=0, $length, $charset="utf-8", $suffix=true){
		$re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
		$re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
		$re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
		$re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$length_new = $length;
		$length_chi = 0;
		for($i=$start; $i<$length; $i++){
			if (ord($match[0][$i]) > 0xa0){
				//中文
			}else{
				$length_new++;
				$length_chi++;
			}
		}
		if($length_chi<$length){
			$length_new = $length+($length_chi/2);
		}
		$slice = join("",array_slice($match[0], $start, $length_new));
	    if($suffix && $slice != $str){
			return $slice."…";
		}
	    return $slice;
	}
	
	// 汉字转拼单
	function topinyin($str,$ishead=0,$isclose=1){
		$str = utf8togbk($str);//转成GBK
		global $pinyins;
		$restr = '';
		$str = trim($str);
		$slen = strlen($str);
		if($slen<2){
			return $str;
		}
		if(count($pinyins)==0){
			$fp = fopen(COMMON_PATH.'/pinyin.dat','r');
			while(!feof($fp)){
				$line = trim(fgets($fp));
				$pinyins[$line[0].$line[1]] = substr($line,3,strlen($line)-3);
			}
			fclose($fp);
		}
		for($i=0;$i<$slen;$i++){
			if(ord($str[$i])>0x80){
				$c = $str[$i].$str[$i+1];
				$i++;
				if(isset($pinyins[$c])){
					if($ishead==0){
						$restr .= $pinyins[$c];
					}
					else{
						$restr .= $pinyins[$c][0];
					}
				}else{
					//$restr .= "_";
				}
			}else if( eregi("[a-z0-9]",$str[$i]) ){
				$restr .= $str[$i];
			}
			else{
				//$restr .= "_";
			}
		}
		if($isclose==0){
			unset($pinyins);
		}
		return $restr;
	}

	/*======================================
	 * ---- 缩略图裁切函数 -----
	 * $src 原图路径  
	 * $width 自定义裁切宽度
	 * $height 自定义裁切高度
	 * =====================================
	 */
	function thumbCutMini($src,$width='',$height=''){
		$_src_array = explode( '/' , $src );
		if ( empty( $width ) ) {
			$width = C('PIC_MINI_WIDTH');
		}
		if ( empty( $height ) ) {
			$height = C('PIC_MINI_HEIGHT');
		}
		
		$_name_array = explode( '_' , $_src_array[count($_src_array)-1] );
		$_new_name = '';
		unset( $_name_array[0] );
		foreach ( $_name_array as $value ) {
			$_new_name .= $value;
		}
		$_name = 'tmp_' . $width . 'x' . $height . '_' . $_new_name;
		unset( $_src_array[count($_src_array)-1] );
		$_src = '';
		foreach ( $_src_array as $src_str ) {
			$_src .= $src_str . '/';
		}
		$_new_path = $_src . $_name;
		if ( !is_file( $src ) ) {
			return './' . C('WEB_PUBLIC_PATH') . '/images/default_' . $width . 'x' . $height . '_nopic.jpg';
		}else{
			if ( is_file( $_new_path ) ){
				return $_new_path;
			}else{
				import( 'ORG.Net.Thumb' );
				$thumb = new ThumbHandler();
				$thumb->setSrcImg( $src, 0, 0 );
				$thumb->setDstImg( $_new_path, 0, "#000000");
				$thumb->setDstImgSize( 1, $width, $height );
				$thumb->createImg(95, 0);
				
				return $_new_path;
			}
		}
		
	}
	
?>