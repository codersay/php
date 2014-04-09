<?php
	function createTempImage( $type, $img='', $width=0, $height=0 ){
		if ( !$width ) {
			$max_width = C('PIC_THUMB_WIDTH');
		}else{
			$max_width = $width;
		}
		
		if ( !$height ) {
			$max_height = C('PIC_THUMB_HEIGHT');
		}else{
			$max_height = $height;
		}

		if ( $type == 'url' ){
			$path = __ROOT_PATH__ . $img;
		}

		if ( $type == 'session' ){
			$path = $_SESSION['editor_upload_list'][$img]['savepath'] . $_SESSION['editor_upload_list'][$img]['savename'];
		}

		if ( $type ){
			$img = $path;

			$info = getimagesize( $img );
			$mime = $info['mime'];
			$width = $info[0];
			$height = $info[1];
			
			$x_ratio = $max_width / $width;
			$y_ratio = $max_height / $height;

			if ( ($width <= $max_width) && ($height <= $max_height) ) {
			    $tn_width = $width;
			    $tn_height = $height;
			}elseif (($x_ratio * $height) < $max_height) {
			    $tn_height = ceil($x_ratio * $height);
			    $tn_width = $max_width;
			}else {
			    $tn_width = ceil($y_ratio * $width);
			    $tn_height = $max_height;
			}
			
			$createFun = str_replace('/', 'createfrom', $mime);
			
			$ImageFun = str_replace('/', '', $mime);
			$typeic = strtolower( $ImageFun );

			$src = $createFun($img);
			$dst = imagecreatetruecolor($tn_width,$tn_height);
			
			imagecopyresampled($dst, $src, 0, 0, 0, 0, $tn_width,$tn_height,$width,$height);
			if ($typeic == 'imagepng' || $typeic == 'imagegif') {
	            imagealphablending($src, FALSE); //取消默认的混色模式
	            imagesavealpha($src, TRUE); //设定保存完整的 alpha 通道信息
	        }
			header('Content-type: '.$mime);
			if ( $typeic == 'imagejpeg' ){
				$ImageFun($dst, null, 100);
			}else{
				$ImageFun($dst, null);
			}
			ImageDestroy($src);
			ImageDestroy($dst);
		}
		
	}

	function getUserAvatar($id){
		$cfg_path = C('TMPL_PARSE_STRING');
		$folder_path = $cfg_path['__ATTACH__'];
		$default_img = $cfg_path['__PUBLIC__'] . '/images/avatar.png';
		if ($list = F('AuthorAvatar')) {
			if ( !empty( $list[$id]['avatar'] ) ){
				$avatar = $folder_path . '/' . $list[$id]['avatar'];
			}else{
				$avatar = $default_img;
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
			$avatar = $folder_path . '/' . $nameList[$id]['avatar'];
		}else{
			$avatar = $default_img;
		}
		
		F('AuthorAvatar', $nameList);
		return $avatar;
	}

	function checkEmptyDir($directory){
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

	/**
	 +----------------------------------------------------------
	 * 读取插件
	 +----------------------------------------------------------
	 * @param string $path 插件目录
	 * @param string $app 所属项目名
	 +----------------------------------------------------------
	 * @return Array
	 +----------------------------------------------------------
	 */
	function getPluginsDir($path=PLUGIN_PATH,$app=APP_NAME,$ext='.php'){
	    static $plugins = array();
	    if(isset($plugins[$app])) {
	        return $plugins[$app];
	    }
	    // 如果插件目录为空 返回空数组
	    if(checkEmptyDir($path)) {
	        return array();
	    }
	    $path = realpath($path);
	    $dir = dir($path);
	    if($dir) {
	        $plugin_files = array();
	        while (false !== ($file = $dir->read())) {
	            if($file == "." || $file == "..")   continue;
	            if(is_dir($path.'/'.$file)){
	                    $subdir =  dir($path.'/'.$file);
	                    if ($subdir) {
	                        while (($subfile = $subdir->read()) !== false) {
	                            if($subfile == "." || $subfile == "..")   continue;
	                            if (preg_match('/\.php$/', $subfile))
	                                $plugin_files[] = "$file/$subfile";
	                        }
	                        $subdir->close();
	                    }
	            }else{
	                $plugin_files[] = $file;
	            }
	        }
	        $dir->close();
	        //对插件文件排序
	        if(count($plugin_files)>1) {
	            sort($plugin_files);
	        }
	        $plugins[$app] = array();
	        foreach ($plugin_files as $plugin_file) {
	            if ( !is_readable("$path/$plugin_file"))        continue;
	            //取得插件文件的信息
	            $plugin_data = getPluginInfos("$path/$plugin_file");
	            if (empty ($plugin_data['name'])) {
	                continue;
	            }
	            $plugins[$app][] = $plugin_data;
	        }
	       	return $plugins[$app];
	    }else {
	        return array();
	    }
	}

	/**
	 +----------------------------------------------------------
	 * 获取插件信息
	 +----------------------------------------------------------
	 * @param string $plugin_file 插件文件名
	 +----------------------------------------------------------
	 * @return Array
	 +----------------------------------------------------------
	 */
	function getPluginInfos($plugin_file) {

	    $plugin_data = file_get_contents($plugin_file);
	    preg_match("/Widget Name:(.*)/i", $plugin_data, $plugin_name);
	    if(empty($plugin_name)) {
	        return false;
	    }
	    preg_match("/Widget URI:(.*)/i", $plugin_data, $plugin_uri);
	    preg_match("/Remark:(.*)/i", $plugin_data, $remark);
	    preg_match("/Title:(.*)/i", $plugin_data, $title);
	    preg_match("/Author:(.*)/i", $plugin_data, $author_name);
	    preg_match("/Author URI:(.*)/i", $plugin_data, $author_uri);
	    preg_match("/Param:(.*)/i", $plugin_data, $param);
	    preg_match("/Position:(.*)/i", $plugin_data, $position);
	    if (preg_match("/Version:(.*)/i", $plugin_data, $version))
	        $version = trim($version[1]);
	    else
	        $version = '';
	    if(!empty($author_name)) {
	        if(!empty($author_uri)) {
	            $author_name = '<a href="'.trim($author_uri[1]).'" target="_blank">'.trim($author_name[1]).'</a>';
	        }else {
	            $author_name = $author_name[1];
	        }
	    }else {
	        $author_name = '';
	    }
	    return array (
	    	'name' 			=> trim($plugin_name[1]), 
	    	'author' 		=> trim($author_name), 
	    	'title'			=> trim($title[1]),
	    	'uri' 			=> trim($plugin_uri[1]), 
	    	'remark' 		=> trim($remark[1]), 
	    	'type'			=> 'widget',
	    	'version' 		=> $version,
	    	'position'		=> trim($position[1]),
	    	'param'			=> trim($param[1])
	    );
	}

	/**
	 * 用于过滤标签，输出没有html的干净的文本
	 * @param string text 文本内容
	 * @return string 处理后内容
	 */
	function replaceHtmls($text){
	    $text = nl2br($text);
	    $text = real_strip_tags($text);
	    $text = str_ireplace(array("\r","\n","\t","&nbsp;"),'',$text);
	    $text = htmlspecialchars($text,ENT_QUOTES);
	    $text = trim($text);
	    return $text;
	}

	function real_strip_tags($str, $allowable_tags="") {
	    $str = stripslashes(htmlspecialchars_decode($str));
	    return strip_tags($str, $allowable_tags);
	}
	
?>