<?php
	/**
	 * 
	 */
	class AlbumAction extends CommonAction {
		
		
		
		public function itemlist(){
			$data = S('up_cache_'.$_SESSION['AUTH']['last_login_time']);
			//$uploadfilepath = __ROOT__.'/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH');
			if (empty($data)){
				echo "还没有上传图片";
			}else{
				$themes_path = C('TMPL_PARSE_STRING');
				$html = '<ul class="updone">';
				foreach ($data AS $key=>$val){
					$filenamearr = explode('/',$val['savename']);
					$filename = $filenamearr[1];
	          		$html .= '<li class="dlist">';
	              	$html .= '<img views="'.$themes_path['__UPLOAD__'].'/'.$filenamearr[0].'/resize_'.$filename.'" src="'.$themes_path['__UPLOAD__'].'/'.$filenamearr[0].'/mini_'.$filename.'" id="img_'.$key.'" />';
					$html .= '<a href="javascript:;" rel="'.$filenamearr[0]."/thumb_".$filename.'" vkey="'.$key.'" class="setThumb" id="link_'.$key.'" title="设置此图片为组图缩略图"></a>';
					$html .= '<a href="javascript:deluppic('.$key.');" rel="'.$key.'" class="deluppic" id="deluppic_'.$key.'" title="删除此图片"></a>';
					$html .= '<input name="pics['.$key.'][keep]" type="hidden" value="'.$key.'" />';
					$html .= '<input name="pics['.$key.'][folder]" type="hidden" value="'.$filenamearr[0].'" />';
					$html .= '<input name="pics['.$key.'][extension]" type="hidden" value="'.$val['extension'].'" />';
					$html .= '<input name="pics['.$key.'][size]" type="hidden" value="'.$val['size'].'" />';
					$html .= '<input name="pics['.$key.'][name]" type="hidden" value="'.$filename.'" />';
					$html .= '<input name="pics['.$key.'][text]" type="hidden" value="'.$val['name'].'" />';
					$html .= '</li>';
	          		
	            }
				$html .= '<div class="clear"></div>';
				$html .= '<li class="delall"><a href="javascript:delalluppic()" class="submit">清空并删除所有已上传图片</a></li>';
				$html .= '</ul>';
				echo $html;
			}
		}

		public function delpic(){
			$fileID = $_GET['file'];
			$fileArray = S('up_cache_'.$_SESSION['AUTH']['last_login_time']);
			$uploadfilepath = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH');
			
			if (!empty($fileID) && !empty($fileArray[$fileID])){
				$filearr = explode('/',$fileArray[$fileID]['savename']);
				$array = $this->_setPicType( $filearr[1] );
				$folder = $filearr[0];
				$dir = $uploadfilepath.'/'.$folder.'/';
				foreach ($array as $value) {
					if ( is_file( $dir . $value ) ) @unlink( $dir . $value );
				}
				
				if ( count( $fileArray ) <= 1 ){
					unset( $_SESSION['picture_list_file'] );
				}
				unset($fileArray[$fileID]);
				
				if ($_GET['type'] == 'edit'){
					S('up_edit_cache_'.$_SESSION['AUTH']['last_login_time'],$fileArray);
				}else{
					S('up_cache_'.$_SESSION['AUTH']['last_login_time'],$fileArray);
				}
				
				//echo $fileArray[$fileID]['savename'];
			}
			
		}

		public function delalluppic(){
			$fileArray = S('up_cache_'.$_SESSION['AUTH']['last_login_time']);
			$uploadfilepath = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH');
			foreach ($fileArray AS $key=>$val){
				$filearr = explode('/',$fileArray[$key]['savename']);
				$array = $this->_setPicType( $filearr[1] );
				$folder = $filearr[0];
				$dir = $uploadfilepath.'/'.$folder.'/';
				foreach ($array as $value) {
					if ( is_file( $dir . $value ) ) @unlink( $dir . $value );
				}
				unset($_SESSION['picture_list_file']);
				S('up_cache_'.$_SESSION['AUTH']['last_login_time'],NULL);
			}
		}
		
		public function upload(){
			//$file = $_POST['Filedata'];
			import("ORG.Net.UploadFile");
			$upload = new UploadFile();
			$uploadfilepath = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH');
			$upload->savePath = $uploadfilepath."/";
			$upload->maxSize = 3145728;
			$upload->allowExts = array('jpg','gif','png','jpeg');
			$upload->saveRule = 'uniqid';
			$upload->autoSub = true;
			$upload->subType = 'date';
			$upload->dateFormat = "Ymd";
			
			$upload->thumb = true;
			$upload->imageClassPath = 'ORG.Util.Image';
			/*$upload->thumbMaxWidth = C("PIC_RESIZE_WIDTH").','.C("PIC_THUMB_WIDTH").','.C("PIC_MINI_WIDTH");
			$upload->thumbMaxHeight = C("PIC_RESIZE_HEIGHT").','.C("PIC_THUMB_HEIGHT").','.C("PIC_MINI_HEIGHT");
			$upload->thumbPrefix = 'resize_,thumb_,mini_';*/
			$upload->thumbMaxWidth = C("PIC_RESIZE_WIDTH");
			$upload->thumbMaxHeight = C("PIC_RESIZE_HEIGHT");
			$upload->thumbPrefix = 'resize_';
			$upload->thumbPath = $uploadfilepath."/".date("Ymd")."/";
			
			if(!$upload->upload()){
				$err = $this->error($upload->getErrorMsg());
			}else{
				$info = $upload->getUploadFileInfo();
				import('ORG.Net.Thumb');
				$file_array_i = explode('/',$info[0]["savename"]);
				$i_file_name = $file_array_i[count($file_array_i)-1];
				//生成缩略图
				$thumb = new ThumbHandler();
				$thumb->setSrcImg( $uploadfilepath.'/'.$info[0]["savename"], 0, 0 );
				$thumb->setDstImg( $uploadfilepath.'/'.$file_array_i[count($file_array_i)-2].'/thumb_'.$i_file_name, 0, "#000000");
				$thumb->setDstImgSize( 1, C('PIC_THUMB_WIDTH'), C('PIC_THUMB_HEIGHT') );
				$thumb->createImg(95, 0);
				
				$mini = new ThumbHandler();
				$mini->setSrcImg( $uploadfilepath.'/'.$info[0]["savename"], 0, 0 );
				$mini->setDstImg( $uploadfilepath.'/'.$file_array_i[count($file_array_i)-2].'/mini_'.$i_file_name, 0, "#000000");
				$mini->setDstImgSize( 1, C('PIC_MINI_WIDTH'), C('PIC_MINI_HEIGHT') );
				$mini->createImg(95, 0);

				if ( $_POST['setFix'] == 'create' ){
					$this->createFixThumb( $i_file_name, $file_array_i[count($file_array_i)-2] );
				}
			}
			
			//self::upCache('ADD',$info[]);
			if (!isset($_SESSION['picture_list_file'])){
				$_SESSION['picture_list_file'] = array();
			}
			if (!isset($_SESSION['picture_list_file_id'])){
				$_SESSION['picture_list_file_id'] = 1;
			}else{
				$_SESSION['picture_list_file_id']++;
			}
			$_SESSION['picture_list_file'][$_SESSION['picture_list_file_id']] = $info[0];
			
			/*$cache_list = S('up_cache');
			if (!empty($cache_list)){
				$data_list = array_merge($cache_list,$_SESSION['picture_list_file']);
			}else{
				$data_list = $_SESSION['picture_list_file'];
			}
			*/
			S('up_cache_'.$_SESSION['AUTH']['last_login_time'],$_SESSION['picture_list_file']);
		}

		private function createFixThumb($files,$folder){
			$_path = __ROOT_PATH__ . '/' . C( 'WEB_PUBLIC_PATH' ) . '/' . C( 'DIR_UPLOAD_PATH' ) . '/' . $folder;
			$_org = $_path . '/' . $files;
			$_width = C('PIC_FIX_WIDTH');
			$create = $_path . '/fix_' . $files;
			if ( !$_width ){
				$_width = C('PIC_THUMB_WIDTH');
			}
			//获取原图信息
			$_info = getimagesize($_org);
			$_o_width = $_info[0];
			$_o_height = $_info[1];

			$_n_width = $_width; //--
			$_n_height = $_width * $_o_height / $_o_width; //--
			
			$_return = '';
			if($_info[0] > $_n_width && $_info[1] > $_n_height) {
				switch($_info[2]) {
					case 1 :
						$im = imagecreatefromgif($_org);
						break;
					case 2 :
						$im = imagecreatefromjpeg($_org);
						break;
					case 3 :
						$im = imagecreatefrompng($_org);
						break;
				}
				$ni = imagecreatetruecolor($_n_width, $_n_height);
				imagecopyresampled($ni, $im, 0, 0, 0, 0, $_n_width, $_n_height, $_info[0], $_info[1]);
				if ( $_info[2] == 2 ){
					imagejpeg($ni, $create, 95);
				}else{
					imagejpeg($ni, $create);
				}
				imagedestroy($im);
				imagedestroy($ni);
			}
		}

		//
	}
	
?>