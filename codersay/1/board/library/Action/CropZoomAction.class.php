<?php
	class CropZoomAction extends CommonAction{
		
		public function index(){
			//unset( $_SESSION['crop_zoom'] );
			if ( isset( $_SESSION['crop_zoom'] ) ){
				$this->redirect('CropZoom/cropzoom');
			}else{
				$this->display();
			}
		}
		
		public function uploadpost(){
			import("ORG.Net.UploadFile");
			$upload = new UploadFile();
			$upload->savePath = './'.C('WEB_PUBLIC_PATH').'/'.C('DIR_ATTCH_PATH').'/';
			$upload->maxSize = 3145728;
			$upload->allowExts = array('jpg','gif','png','jpeg');
			$upload->saveRule = 'uniqid';
			$upload->autoSub = true;
			$upload->subType = 'date';
			$upload->dateFormat = "Ymd";
			if(!$upload->upload()){
				$error = $this->error($upload->getErrorMsg());
				echo $error;
				exit();
			}else{
				$info = $upload->getUploadFileInfo();
				$user_file_name_noext = explode('/',$info[0]['savename']);
				$old_name = explode('.',$user_file_name_noext[count($user_file_name_noext)-1]);
				$file_l_path = $info[0]['savepath'].$info[0]['savename'];
				
				if ( !empty( $_POST['custom_width'] ) && is_numeric( $_POST['custom_width'] ) ){
					$_SESSION['crop_zoom']['custom_width'] = intval( $_POST['custom_width'] );
				}else{
					$_SESSION['crop_zoom']['custom_width'] = C('PIC_THUMB_WIDTH');
				}
				
				if ( !empty( $_POST['custom_height'] ) && is_numeric( $_POST['custom_height'] ) ){
					$_SESSION['crop_zoom']['custom_height'] = intval( $_POST['custom_height'] );
				}else{
					$_SESSION['crop_zoom']['custom_height'] = C('PIC_THUMB_HEIGHT');
				}
				
				$imageSize = getimagesize( $file_l_path );
				
				$_SESSION['crop_zoom']['width'] = $imageSize[0];
				$_SESSION['crop_zoom']['height'] = $imageSize[1];
				$_SESSION['crop_zoom']['mime'] = $imageSize['mime'];
				$_SESSION['crop_zoom']['foder'] = date("Ymd",time());
				$_SESSION['crop_zoom']['name'] = $user_file_name_noext[1];
				$_SESSION['crop_zoom']['ext'] = $info[0]['extension'];
				$_SESSION['crop_zoom']['name_noext'] = $old_name[0];
				$_SESSION['crop_zoom']['large_path'] = $file_l_path;
				$_SESSION['crop_zoom']['thumb_path'] = $file_l_path;
				
				$this->redirect("CropZoom/cropzoom");
			}
		}

		public function zoompost(){
			list($width, $height) = getimagesize($_POST["imageSource"]);
			$viewPortW = $_POST["viewPortW"];
			$viewPortH = $_POST["viewPortH"];
			$pWidth = $_POST["imageW"];
			$pHeight =  $_POST["imageH"];
			$ext = end(explode(".",$_POST["imageSource"]));
			$ext = strtolower($ext);
			$function = $this->returnCorrectFunction($ext);
			$image = $function($_POST["imageSource"]);
			$width = imagesx($image);
			$height = imagesy($image);
			// Resample
			$image_p = imagecreatetruecolor($pWidth, $pHeight);
			$this->setTransparency($image,$image_p,$ext);
			imagecopyresampled($image_p, $image, 0, 0, 0, 0, $pWidth, $pHeight, $width, $height);
			imagedestroy($image);
			$widthR = imagesx($image_p);
			$hegihtR = imagesy($image_p);
			
			$selectorX = $_POST["selectorX"];
			$selectorY = $_POST["selectorY"];
			
			if($_POST["imageRotate"]){
				$angle = 360 - $_POST["imageRotate"];
				$image_p = imagerotate($image_p,$angle,0);
				
				$pWidth = imagesx($image_p);
				$pHeight = imagesy($image_p);
				
				//print $pWidth."---".$pHeight;
			
				$diffW = abs($pWidth - $widthR) / 2;
				$diffH = abs($pHeight - $hegihtR) / 2;
					
				$_POST["imageX"] = ($pWidth > $widthR ? $_POST["imageX"] - $diffW : $_POST["imageX"] + $diffW);
				$_POST["imageY"] = ($pHeight > $hegihtR ? $_POST["imageY"] - $diffH : $_POST["imageY"] + $diffH);
			
				
			}
			
			
			
			$dst_x = $src_x = $dst_y = $dst_x = 0;
			
			if($_POST["imageX"] > 0){
				$dst_x = abs($_POST["imageX"]);
			}else{
				$src_x = abs($_POST["imageX"]);
			}
			if($_POST["imageY"] > 0){
				$dst_y = abs($_POST["imageY"]);
			}else{
				$src_y = abs($_POST["imageY"]);
			}
			
			
			$viewport = imagecreatetruecolor($_POST["viewPortW"],$_POST["viewPortH"]);
			$this->setTransparency($image_p,$viewport,$ext);
			
			imagecopy($viewport, $image_p, $dst_x, $dst_y, $src_x, $src_y, $pWidth, $pHeight);
			imagedestroy($image_p);
			
			
			$selector = imagecreatetruecolor($_POST["selectorW"],$_POST["selectorH"]);
			$this->setTransparency($viewport,$selector,$ext);
			imagecopy($selector, $viewport, 0, 0, $selectorX, $selectorY,$_POST["viewPortW"],$_POST["viewPortH"]);
			
			$path_array = explode( '/' , $_POST['imageSource'] );
			$o_file_name_key = count( $path_array ) - 1;
			$path_str = '';
			foreach ( $path_array as $key => $val ) {
				if ( $key != $o_file_name_key ){
					$path_str .= $val . '/';
				}
			}
			$new_file_name = 'thumb_' . $path_array[$o_file_name_key];
			
			$file = $path_str . $new_file_name;
			$this->parseImage($ext,$selector,$file);
			imagedestroy($viewport);
			//Return value
			echo $file;
		}
		
		public function overagain(){
			$file_path_o = $_SESSION['crop_zoom']['large_path'];
			if ( file_exists( $file_path_o ) ) {
				@unlink( $file_path_o );
			}
			$array_path = explode( '/', $file_path_o );
			$floder_str = '';
			$count_path = count( $array_path ) - 1;
			foreach ( $array_path as $key => $val ){
				if ( $count_path != $key ){
					$floder_str .= $val . '/';
				}
			}
			
			$thumb_path_o = $floder_str . 'thumb_' . $array_path[$count_path];
			if ( file_exists( $thumb_path_o ) ) {
				@unlink( $thumb_path_o );
			}
			
			unset( $_SESSION['crop_zoom'] );
			
			$this->redirect("CropZoom/index");
			
		}
		
		private function determineImageScale($sourceWidth, $sourceHeight, $targetWidth, $targetHeight) {
			$scalex =  $targetWidth / $sourceWidth;
			$scaley =  $targetHeight / $sourceHeight;
			return min($scalex, $scaley);
		}
		
		private function returnCorrectFunction($ext){
			$function = "";
			switch($ext){
				case "png":
					$function = "imagecreatefrompng";
					break;
				case "jpeg":
					$function = "imagecreatefromjpeg";
					break;
				case "jpg":
					$function = "imagecreatefromjpeg";
					break;
				case "gif":
					$function = "imagecreatefromgif";
					break;
			}
			return $function;
		}
		
		private function parseImage($ext,$img,$file = null){
			switch($ext){
				case "png":
					imagepng($img,($file != null ? $file : ''));
					break;
				case "jpeg":
					imagejpeg($img,($file ? $file : ''),98);
					break;
				case "jpg":
					imagejpeg($img,($file ? $file : ''),98);
					break;
				case "gif":
					imagegif($img,($file ? $file : ''));
					break;
			}
		}
		
		private function setTransparency($imgSrc,$imgDest,$ext){
		
			if($ext == "png" || $ext == "gif"){
				$trnprt_indx = imagecolortransparent($imgSrc);
				// If we have a specific transparent color
				if ($trnprt_indx >= 0) {
					// Get the original image's transparent color's RGB values
					$trnprt_color    = imagecolorsforindex($imgSrc, $trnprt_indx);
					// Allocate the same color in the new image resource
					$trnprt_indx    = imagecolorallocate($imgDest, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
					// Completely fill the background of the new image with allocated color.
					imagefill($imgDest, 0, 0, $trnprt_indx);
					// Set the background color for new image to transparent
					imagecolortransparent($imgDest, $trnprt_indx);
				}
				// Always make a transparent background color for PNGs that don't have one allocated already
				elseif ($ext == "png") {
					// Turn off transparency blending (temporarily)
					imagealphablending($imgDest, true);
					// Create a new transparent color for image
					$color = imagecolorallocatealpha($imgDest, 0, 0, 0, 127);
					// Completely fill the background of the new image with allocated color.
					imagefill($imgDest, 0, 0, $color);
					// Restore transparency blending
					imagesavealpha($imgDest, true);
				}
		
			}
		}

	}
