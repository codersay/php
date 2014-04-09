<?php
	/**
	 +=========================================================
	 * NDlog(NDesign) 个人单用户博客系统
	 * common.php 公共函数库
	 +=========================================================
	 * @copyright © 2012 ndlog.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.ndlog.com/license
	 +=========================================================
	*/
	 
    //邮箱检测
	function checkEmail($val,$domain=""){
        if(!$domain){
            return preg_match("/^[a-z0-9-_.]+@[\da-z][\.\w-]+\.[a-z]{2,4}$/i", $val);
        }else{
            return preg_match("/^[a-z0-9-_.]+@".$domain."$/i", $val);
        }
    }

    /**
	 * 如果没有非法字符，返回true  否则返回false
	 */
	
	function checkSafe($value){
		return preg_match( '/^[\w'.chr(0x80).'-'.chr(0xff).']'.'{1,30}$/', $value);
	}

	function toDate($time, $format = 'Y-m-d H:i:s') {
		if (empty($time)) {
			return '';
		}
		$format = str_replace('#', ':', $format);
		return date($format, $time);
	}

	function getArrayValue( $array, $id, $field, $aid ){
		foreach ( $array as $key => $val ){
			if ( $aid == 0 ){
				if ( $val[$field] == $id && $val['pid'] == 0 ){
					return $val;
				}
			}else{
				if ( $val[$field] == $id && $val['id'] == $aid ){
					return $val;
				}
			}
		}
		return;
	}
	
	function getAuthorAvatar( $id ){
		$folder_path = __ROOT__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH') . '/';
		if ($list = F('AuthorAvatar')) {
			if ( !empty( $list[$id]['avatar'] ) ){
				$avatar = $folder_path . $list[$id]['avatar'];
			}else{
				$avatar = 'http://www.gravatar.com/avatar/'.md5( $list[$id]['email'] ).'?s=40';
			}
			return $avatar;
		}
		$dao = D("User");
		$list = $dao->field('id,nickname,email,avatar')->select();
		foreach ($list as $vo) {
			$nameList[$vo['id']]['email'] = $vo['email'];
			$nameList[$vo['id']]['avatar'] = $vo['avatar'];
		}
		if ( !empty( $nameList[$id]['avatar'] ) ){
			$avatar = $folder_path . $nameList[$id]['avatar'];
		}else{
			$avatar = 'http://www.gravatar.com/avatar/'.md5( $nameList[$id]['email'] ).'?s=40';
		}
		
		F('AuthorAvatar', $nameList);
		return $avatar;
	}
	
	/**
	 +-------------------------------------------------
	 * 获取用户名, 并缓存数据
	 * @param int $id 用户ID
	 * @return string 返回用户名
	 +-------------------------------------------------
	 */
	function getAuthorName($id){
		if ($list = F('AuthorName')) {
			return $list[$id];
		}
		$dao = D("User");
		$list = $dao->field('id,nickname,email,avatar')->select();
		foreach ($list as $vo) {
			$nameList[$vo['id']] = $vo['nickname'];
		}
		$name = $nameList[$id];
		F('AuthorName', $nameList);
		return $name;
	}
	
	/**
	 * =============================
	 * 获得分类名称
	 * @param INT $id 分类ID
	 * =============================
	 */
	function getCategoryName($id) {
		if ($list = F('categoryName')) {
			return $list[$id];
		}
		$dao = D("Category");
		$list = $dao -> field('id,name')->select();
		foreach ($list as $vo) {
			$nameList[$vo['id']] = $vo['name'];
		}
		$name = $nameList[$id];
		F('categoryName', $nameList);
		return $name;
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
			//if (ord($match[0][$i]) > 0xa0){
			if (ord($match[0][$length_chi]) >= 230){
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
	
	function getGeneralTags( $tags ){
		if ( empty( $tags ) ){
			return '无';
		}
		$tags = explode( ' ', $tags );
		$html = '';
		foreach ($tags as $val) {
			$val = trim($val);
			if ( !empty( $val ) ){
				$html .= '<a href="'.U('/tags/'.urlencode($val)).'">'.$val.'</a> &nbsp; ';
			}
		}
		return $html;
	}

	/*
	 * 获取枚举项目
	*/
	function _getEnumOption($type){
		if ( $list = F('enum_'.$type) ){
			return $list;
		}
		$model = M('SysOption');
		$list = $model->where("type='".$type."' AND pid=0")->select();
		F('enum_'.$type,$list);
		return $list;
	}

	/*
	 * 获取上一篇下一篇
	 * $id 当前文章的ID，$action 获取条件，prev 获取上一篇，next 获取下一篇。默认为当前文章
	*/
	function getPrevNextArchive( $id, $action, $class ){
		$map['status'] = 1;
		$order = 'id';
		$IDlist = getCategoryIDlist( $class );
		$map['cid'] = $IDlist;
		if ( strpos( ',', $IDlist ) ){
			$map['cid'] = array( 'in', $IDlist );
		}
		switch ( $action ) {
			case 'prev':
				$map['id'] = array( 'lt', $id );
				$order = 'id DESC';
				break;

			case 'next':
				$map['id'] = array( 'gt', $id );
				break;
			
			default:
				$map['id'] = $id;
				break;
		}
		$model = M('Archives');
		$result = $model->where($map)->order($order)->field('id,title')->find();
		if ( !empty( $result ) ){
			return '<a href="' . U( '/views/' . $result['id'] ) . '">' . $result['title'] . '</a>';
		}else{
			return '没有了。';
		}
	}
	
	/*
	 * 获取属于当前分类以及当前分类下的所有子及分类 ID
	 * 
	 */
	function getCategoryIDlist( $class, $category='' ){
		if ( empty( $category ) ){
			$category = S('CategoryList');
		}
		$IDlist = $class;
		foreach( $category as $key => $val ){
			if ( $val['pid'] == $class && $val['status'] == 1 ){
				$IDlist .= ',' . $val['id'];
				if ( checkCategoryChild( $category, $val['id'] ) == 1 ){
					$IDlist .= ',' . getCategoryIDlist( $category, $val['id'] );
				}
			}
		}
		return $IDlist;
	}
	
	function checkCategoryChild( $category, $class ){
		$isChild = 0;
		foreach ( $category as $key => $val ){
			if ( $val['pid'] == $class && $val['status'] == 1 ) $isChild = 1;
		}
		return $isChild;
	}
	
	/*
	 * URL 重组
	 * 
	 * 
	 */
	function getParseURL( $_param, $value ){
        $url = $_SERVER['REQUEST_URI'] . ( strpos( $_SERVER['REQUEST_URI'], '?' ) ? '' : "?" );
        $parse = parse_url($url);
        if ( isset( $parse['query'] ) ) {
            parse_str( $parse['query'], $params );
            unset( $params[$_param] );
            $url = $parse['path'] . '?' . http_build_query($params);
        }
        if ( !strpos( $url, '&' ) && count( $params ) == 0 ){
        	$format = "{$_param}=" . $value;
        }else{
            $format = "&{$_param}=" . $value;
        }
        return $url . $format;
    }

    /*
	 * 获取主题列表
	 * 返回主题ul列表
    */
    function getTplURL(){
        $theme_path = APP_PATH . 'themes';
        $list = explode( ',', C('THEME_LIST') );
        $html = '';
        if ( count( $list ) >= 1 ){
            $html .= '<ul class="themes_list">';
            foreach ( $list as $value ) {
            	$infofile = $theme_path . '/' . $value . '/info.php';
            	$info = '';
            	if ( is_file( $infofile ) ){
            		$info = require_once( $infofile );
            	}
                $html .= '<li';
                $html .= ( $info['color'] ) ? ' style="background-color:'.$info['color'].';"' : '';
                $html .= ( $info['class'] ) ? ' class="'.$info['class'].'"' : '';
                $html .= '><a href="' . getParseURL( 't', $value ) . '" id="' . $value . '">' . $value . '</a></li>';
            }
            $html .= '</ul>';
        }
        return $html;
    }

    /*
     * =====================================
	 * 获取URL链接地址，分自定义URL和默认URL
	 * $id，主键ID
	 * $urls，自定义URL名称，传入的值若为空值将使用默认URL，即$type参数
	 * $type，赋予URL的默认方式，比如分类如果么有自定义URL名称，传入category即获得默认的category-$id形式的URL
	 * =====================================
    */
    function URL( $id, $urls, $type ){
    	if ( empty( $urls ) ){
    		$link = U( '/' . $type . '/' . $id );
    	}else{
    		$link = U( '/' . $urls );
    	}
    	return $link;
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

	function checkPluginCache(){
		$list = S('plugins');
		if ( !$list ){
			$model = M('Plugins');
			$list = $model->order('sort')->select();
			S('plugins',$list);
		}
		return $list;
	}
	
	/**
	 * 加载模板插件
	 * 
	 */
	function templatePlugin(){
		$plugin_path = THEME_PATH . 'plugin.php';
		if ( is_file( $plugin_path ) ) require_once ( $plugin_path );
	}

	function getOnePlugin( $name ){
		$plugins = checkPluginCache();
		foreach ($plugins as $key => $value) {
			if ( $value['name'] == $name )  $plugin = $value;
		}
		return $plugin;
	}

	function importPluginHook(){
		import("Core.Addons",CORE_PATH);
		import("addons.Hooks",CORE_PATH);
		import("addons.AbstractAddons",CORE_PATH);
		import("addons.NormalAddons",CORE_PATH);
		import("addons.SimpleAddons",CORE_PATH);
        Addons::loadAllValidAddons();
	}

	function addPlugin( $name ){
		$plugins = checkPluginCache();
		foreach ($plugins as $key => $value) {
			if ( $value['name'] == $name )  $plugin = $value;
		}
		if ( !empty( $plugin ) && $plugin['status'] == 1 ){
			switch ( $plugin['type'] ) {
				case 'widget':
					$path = LIB_PATH . 'Widget/' . $name . 'Widget.class.php';
					if ( is_file( $path ) ){
						W( $plugin['name'], json_decode( $plugin['param'], true ) );
					}
					break;
				
				case 'plugin':
					$path = ADDON_PATH . '/plugin/' .$plugin['name'] . '/' . $plugin['name'] . 'Addons.class.php';
					if ( is_file( $path ) ){
						importPluginHook();
			            $param = json_decode( $plugin['param'], true );
			            Addons::hook($plugin['hook'],$param);
					}
					break;
			}
		}
	}

	function addFreeWidget( $name, $param ){
		$plugin = getOnePlugin( $name );
		if ( !empty( $plugin ) && $plugin['status'] == 1 ){
			$path = LIB_PATH . 'Widget/' . $name . 'Widget.class.php';
			if ( is_file( $path ) ){
				W( $plugin['name'], $param );
			}
		}
	}

	function addFreePlugin( $name, $hook = '', $param='' ){
		$plugin = getOnePlugin( $name );
		if ( $hook == '' ){
			$hook = $plugin['hook'];
		}
		if ( $param = '' ){
			$param = json_decode( $plugin['param'], true );
		}
		
		if ( $plugin['status'] == 1 ){
			$path = ADDON_PATH . '/plugin/' .$plugin['name'] . '/' . $plugin['name'] . 'Addons.class.php';
			if ( is_file( $path ) ){
				importPluginHook();
	            Addons::hook($hook,$param);
			}
		}
	}


?>