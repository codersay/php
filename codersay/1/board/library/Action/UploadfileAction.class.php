<?php
	/**
	 * 公共上传类
	 */
	class UploadfileAction extends CommonAction {
		public function upfile(){
			$type = array('jpg','gif','png','jpeg');
			self::commupload($type);
		}
		
		public function uploadflash(){
			$type = array('swf','flv');
			self::commupload($type);
		}
		
		public function uploadlink(){
			$type = array('zip','rar','7z','gz');
			self::commupload($type);
		}
		
		public function uploadmov(){
			$type = array('wmv','avi','wma','mp3','mid');
			self::commupload($type);
		}
		
		public function uploadvideo(){
			if ( !empty( $_FILES ) ){
				if ( isset( $_SESSION['video_info'] ) ) {
					$o_file = $_SESSION['video_info']['savepath'] . $_SESSION['video_info']['savename'];
					if ( file_exists( $o_file ) ){
						unlink( $o_file );
					}
					unset( $_SESSION['video_info'] );
				}
				$type = array('mp4','wmv','flv','f4v','3gp');
				$this->commupload($type,'video');
			}else{
				$this->error('上传失败');
			}
			
		}

		//上传头像
		public function uploadAvatar()
		{
			$folder = date('Ymd');
			$_avatar = "/".C('WEB_PUBLIC_PATH')."/".C('DIR_ATTCH_PATH');
			$_save_path = __ROOT_PATH__ . $_avatar . '/' . $folder;

			import('@.ORG.Avatar');
			$avatar = new Avatar("filedata");
			$avatar->saveDir = $_save_path;
			$result = $avatar->move_uploaded();

			$_url = __ROOT__ . $_avatar . '/' . $folder . '/';

			$err = '';
			if ( $result['status'] == 0 ){
				$err = $result['error'];
			}else{
				$info = $result['success'];

				$this->setAvatarSessionInfo( 'avatar', $info );
				$userID = '';
				if ( isset( $_SESSION['AUTH'] ) ){
					$userID = '_' . $_SESSION['AUTH']['id'];
				}
				$msg = array(
					'url'		=> $_url . $info['savename'],
					'localname'	=> $info['name'],
					'id'		=> $_SESSION['avatar_upload_manager_id'.$userID],
					'key'		=> $_SESSION['avatar_upload_manager_id'.$userID],
					'field'		=> $info['savename']
				);
			}
			echo json_encode( array('err' => $err, 'msg' => $msg ) );
		}

		public function uploadeditor(){
			$type = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'zip', 'rar', '7z', 'gz', 'wmv', 'avi', 'wma', 'mp3', 'mid', 'mp4', 'flv', 'f4v', '3gp', 'swf', 'doc', 'docx', 'xsl', 'xslx', 'ppt', 'pptx', 'pdf', 'psd', 'ai', 'eps', 'cdr' );
			$this->commupload( $type, 'editor' );
		}
		
		private function commupload($type=array(),$succ=''){

			$_attach = "/".C('WEB_PUBLIC_PATH')."/".C('DIR_ATTCH_PATH')."/";

			if ( $succ == 'video' ){
				$uploadsize = 102400000;
			}else{
				$uploadsize = 3145728;
			}
			import("ORG.Net.UploadFile");
			$upload = new UploadFile();
			$upload->savePath = __ROOT_PATH__ . $_attach;
			$upload->maxSize = $uploadsize;
			$upload->allowExts = $type;
			$upload->saveRule = 'uniqid';
			$upload->autoSub = true;
			$upload->subType = 'date';
			$upload->dateFormat = "Ymd";

			$_url = __ROOT__ . $_attach;

			if(!$upload->upload()){
				if ( $succ == 'editor' ){
					$this->setAlert( $upload->getErrorMsg() );
				}else{
					$err = $this->error( $upload->getErrorMsg() );
				}
			}else{
				$info = $upload->getUploadFileInfo();
				if ( $succ == '' ){
					$this->setSessionInfo( 'other', $info[0] );
					$msg = array(
						'url'		=> $_url . $info[0]['savename'],
						'localname'	=> $info[0]['name'],
						'id'		=> $_SESSION['other_upload_list_id'],
						'key'		=> $_SESSION['other_upload_list_id']
					);
					echo json_encode( array('err' => $err, 'msg' => $msg ) );
				}else{
					switch ( $succ ) {
						case 'video':
							$_SESSION['video_info'] = $info[0];
							$this->ajaxReturn( 1,1,1 );
							break;
						
						case 'editor':
							$this->setSessionInfo( 'editor', $info[0] );
							echo json_encode( array('error' => 0, 'url' => $_url . $info[0]['savename'] ) );
							exit;
							break;
					}
				}
			}
		}
		
		

		private function setSessionInfo( $type='', $array ){
			if ( $type == '' ) $type = 'other';
			if (!isset($_SESSION[$type.'_upload_list'])) $_SESSION[$type.'_upload_list'] = array();
			if (!isset($_SESSION[$type.'_upload_list_id'])){
				$_SESSION[$type.'_upload_list_id'] = 1;
			}else{
				$_SESSION[$type.'_upload_list_id']++;
			}
			$_SESSION[$type.'_upload_list'][$_SESSION[$type.'_upload_list_id']] = $array;
		}

		private function setAvatarSessionInfo( $type='', $array ){
			if ( $type == '' ) $type = 'other';
			$userID = '';
			if ( isset( $_SESSION['AUTH'] ) ){
				$userID = '_' . $_SESSION['AUTH']['id'];
			}
			if ( !$_SESSION[$type.'_upload_manager'.$userID] ){
				$_SESSION[$type.'_upload_manager'.$userID] = array();
			}
			if ( !$_SESSION[$type.'_upload_manager_id'.$userID] ){
				$_SESSION[$type.'_upload_manager_id'.$userID] = 1;
			}else{
				$_SESSION[$type.'_upload_manager_id'.$userID]++;
			}
			$_SESSION[$type.'_upload_manager'.$userID][$_SESSION[$type.'_upload_manager_id'.$userID]] = $array;
		}

		private function setAlert($msg) {
			echo json_encode(array('error' => 1, 'message' => $msg));
			exit;
		}
		
		
		public function removefile(){
			if ( !empty( $_POST['file'] ) ){
				if ( $_POST['video_info'] ){
					$file = $_POST['file']; unset( $_SESSION['video_info'] );
				}else{
					$file = __ROOT_PATH__ . $_POST['file'];
				}
				if ( file_exists( $file ) ){ @unlink( $file ); }
				$this->ajaxReturn(1,1,1);
			}elseif( $_SESSION['other_upload_list'] ){
				if ( $_POST['key'] ){
					$path = $_SESSION['other_upload_list'][$_POST['key']]['savepath'] . $_SESSION['other_upload_list'][$_POST['key']]['savename'];
					if ( unlink( $path ) ){
						unset( $_SESSION['other_upload_list'][$_POST['key']] );
					}
					$_SESSION['other_upload_list_id'] = $_SESSION['other_upload_list_id'] - 1;
				}else{
					foreach ( $_SESSION['other_upload_list'] as $key => $value ) {
						@unlink( $value['savepath'] . $value['savename'] );
					}
					unset( $_SESSION['other_upload_list'], $_SESSION['other_upload_list_id'] );
				}
				$this->ajaxReturn(1,1,1);
			}else{
				$this->ajaxReturn(0,0,0);
			}
		}

		public function removeAvatar()
		{
			$userID = '';
			if ( isset( $_SESSION['AUTH'] ) ){
				$userID = '_' . $_SESSION['AUTH']['id'];
			}
			if( $_SESSION['avatar_upload_manager'.$userID] ){
				//
				$root_path = __ROOT_PATH__ . "/" . C('WEB_PUBLIC_PATH') . "/".C('DIR_ATTCH_PATH')."/";
				if ( $_POST['key'] ){
					$arr = explode('/', $_SESSION['avatar_upload_manager'.$userID][$_POST['key']]['savepath']);
					$folder = $arr[count($arr)-2];
					@unlink( $root_path . $folder . '/' . $_SESSION['avatar_upload_manager'.$userID][$_POST['key']]['savename'] );
					unset( $_SESSION['avatar_upload_manager'.$userID][$_POST['key']] );
					$_SESSION['avatar_upload_manager_id'.$userID] = $_SESSION['avatar_upload_manager_id'.$userID] - 1;
				}else{
					foreach ( $_SESSION['avatar_upload_manager'.$userID] as $key => $value ) {
						$arr = explode('/', $value['savepath']);
						$folder = $arr[count($arr)-2];
						@unlink( $root_path . $folder . '/' . $value['savename'] );
					}
					unset( $_SESSION['avatar_upload_manager'.$userID], $_SESSION['avatar_upload_manager_id'.$userID] );
				}
				$this->ajaxReturn(1,1,1);
			}else{
				$this->ajaxReturn(0,0,0);
			}
		}

		/*
		 * 获取编辑器swfupload上传后的图片

		*/
		public function getEditorUploadImage(){
			if ( isset( $_GET['imgurl'] ) ){
				$size = $this->_get('size');
				$width = $height = 120;
				if ( $size ){
					$_size = explode('x', $size);
					$width = $_size[0];
					$height = $_size[1];
				}
				$img = $this->_get('imgurl');
				createTempImage( 'url', $img, $width, $height );
			}

			if ( isset( $_GET['key'] ) ){
				$img = $this->_get('key');
				createTempImage( 'session', $img, 75, 75 );
			}
		}

		public function getUpedEditorAttach(){
			$html = '';
			$type = $this->_get('type');
			if ( !empty( $_SESSION['editor_upload_list'] ) ){
				$path = C('TMPL_PARSE_STRING');
				foreach ($_SESSION['editor_upload_list'] as $key => $value) {
					$ext = strtolower( end( explode( '.', $value['savename'] ) ) );
					if ( $type == 'image' && ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'bmp' || $ext == 'gif') ){
						$html .= '<li class="ke-item" style="height:90px; overflow:hidden; width:91px; position: relative;"><div class="ke-photo" style="height:78px; overflow:hidden; width:79px;"><img src="' . U('uploadfile/getEditorUploadImage', array('key'=>$key)) . '" class="editorupedImg" rel="'.$path['__ATTACH__'].'/'.$value['savename'].'" /></div><div class="delete_editor_img"></div></li>'; 
					}
					if ( $type == 'other' && ($ext !== 'jpg' && $ext !== 'jpeg' && $ext !== 'png' && $ext !== 'bmp' && $ext !== 'gif') ){
						$html .= '<li class="other_item"><table width="100%" cellpadding="0" cellspacing="0" border="0" class="table_list" bgcolor="#ffffff"><tr><td><a href="javascript:;" class="editorupedother" rel="'.$path['__ATTACH__'].'/'.$value['savename'].'">'.$value['name'].'</a></td><td align="center" width="40"><a href="javascript:;" class="delete_other_attach" rel="'.$key.'" type="key">删除</a></td></tr></table></li>';
					}
				}
				$html .= '<div class="clear"></div>';
			}
			echo $html;
		}

		public function removeEditorUpedAttach(){
			$type = $this->_post('type');
			$array = $_SESSION['editor_upload_list'];
			switch ( $type ) {
				case 'deleteOne':
					$_type = $this->_post('deltype');
					switch ($_type) {
						case 'key':
							$key = $this->_post('key');
							$path = $_SESSION['editor_upload_list'][$key]['savepath'] . $_SESSION['editor_upload_list'][$key]['savename'];
							if ( unlink( $path ) ){
								unset( $_SESSION['editor_upload_list'][$key] );
								$this->ajaxReturn('删除成功！',1,1);
							}else{
								$this->ajaxReturn('删除失败！',0,0);
							}
							break;
						
						case 'url':
							$img = $this->_post('imgurl');
							if ( $img ){
								$imgpath = '';
								$imgkey = '';
								$imgname = end( explode( '/', $img ) );
								foreach ($array as $key => $val) {
									$_imgname = end( explode( '/', $val['savename'] ) );
									if ( $_imgname == $imgname ) {
										$imgpath = $val['savepath'] . $val['savename'];
										$imgkey = $key;
									}
								}
								if ( !empty( $imgpath ) && $imgkey !== '' ){
									if ( unlink( $imgpath ) ){
										unset($_SESSION['editor_upload_list'][$imgkey]);
									}
								}
								$this->ajaxReturn('删除成功！',1,1);
							}else{
								$this->ajaxReturn('删除失败！',0,0);
							}
							break;
					}
					break;

				case 'deleteAll' :
					$file = $this->_post('file');
					$status = 0;
					switch ( $file ) {
						case 'image':
							foreach ($array as $key => $value) {
								$ext = strtolower( end( explode( '.', $value['savename'] ) ) );
								if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'bmp' || $ext == 'gif' ){
									$path = $value['savepath'] . $value['savename'];
									if ( unlink( $path ) ){
										unset( $_SESSION['editor_upload_list'][$key] );
										$status = 1;
									}
								}
							}
							break;
						
						case 'other':
							foreach ($array as $key => $value) {
								$ext = strtolower( end( explode( '.', $value['savename'] ) ) );
								if ( $ext != 'jpg' && $ext != 'jpeg' && $ext != 'png' && $ext != 'bmp' && $ext != 'gif' ){
									$path = $value['savepath'] . $value['savename'];
									if ( unlink( $path ) ){
										unset( $_SESSION['editor_upload_list'][$key] );
										$status = 1;
									}
								}
							}
							break;
					}
					if ( $status == 1 ){
						if( empty( $_SESSION['editor_upload_list'] ) ){
							unset( $_SESSION['editor_upload_list'], $_SESSION['editor_upload_list_id'] );
						}
						$this->ajaxReturn('删除成功！',1,1);
					}else{
						$this->ajaxReturn('删除失败！',0,0);
					}
					break;
			}
		}

	}

	