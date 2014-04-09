<?php
	class UserAction extends CommonAction{
		
		public function _before_index(){
			
			$model = M('User');
			import( 'ORG.Util.Page' );
			$map = array(
				'level'	=> array( 'neq', 'administrator' )
			);
			$total = $model->where( $map )->count();
			$p = new Page($total,C('LIST_BOARD_NUMBER'));
			$list  = $model
				->where( $map )
				->order('id DESC')
				->limit($p->firstRow.','.$p->listRows)
				->select();
			$this->assign('list',$list);
			$this->assign('page',$p->show());
		}

		public function myinfo(){
			$this->assign("vo",M('User')->find($_SESSION['AUTH']['id']));
			$this->display();
		}

		public function checkAccount(){
			$model = M('User');
			if ( isset( $_POST['id'] ) ){
				$where['id'] = array('neq',$_POST['id']);
			}
			$where['account'] = $_POST['account'];
			$account = $model->where( $where )->find();
			if ( !empty( $account ) ){
				$this->ajaxReturn( '账号已存在！', 0 , 0 );
			}
		}
		
		public function getSelfInfo(){
			$info = M('User')->find($_SESSION['AUTH']['id']);
			$this->assign('vo',$info);
			$this->display();
		}

		public function setAvatar()
		{
			$model = M('User');
			$where['id'] = (int)$_SESSION['AUTH']['id'];
			$avatar = $model->where($where)->getField('avatar');
			$this->assign('avatar',$avatar);
			$this->display("set_avatar");
		}

		public function cropAvatar()
		{
			$userID = '';
			if ( $_SESSION['AUTH'] ){
				$userID = '_' . $_SESSION['AUTH']['id'];
			}

			//销毁原头像
			if ( $_POST['o_avatar'] ){
				@unlink( __ROOT_PATH__ . $_POST['o_avatar'] );
			}

			$target_w = C('PIC_THUMB_WIDTH');
			$target_h = C('PIC_THUMB_HEIGHT');

			$_x = $this->_post('x');
			$_y = $this->_post('y');
			$_w = $this->_post('w');
			$_h = $this->_post('h');
			
			$list = $_SESSION['avatar_upload_manager'.$userID];

			if ( $_w < $target_w || $_h < $target_h ){
				$this->error('选取过小！');
			}

			foreach ($list as $key => $value) {
				$_src = $value['savepath'] . $value['savename'];
				$_arr = explode('/', $value['savepath']);
				$info = getimagesize($_src);
				$_folder = $_arr[count($_arr)-2];

				$_src_width = $info[0]; //原始宽度
				$_src_height = $info[1]; //原始高度

				$ext = strtolower(end(explode(".",$_src)));
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

				$image = $function($_src);
				$imgDest = imagecreatetruecolor($target_w, $target_h);
				$this->setTransparency($image,$imgDest,$ext);

				imagecopyresampled( $imgDest, $image, 0, 0, $_x, $_y, $target_w, $target_h, $_w, $_h );
				//imagecopy($imgDest, $imgDest, $target_w, $target_h, $_x, $_y, $_w, $_h);
				imagedestroy($image);
				$save_name = $value['savepath'] . 'small_'.$value['savename'];
				$this->parseImage( $ext, $imgDest, $save_name );

				//储存数据
				D('User')->where("id='".$_SESSION['AUTH']['id']."'")->setField('avatar',$_folder.'/small_'.$value['savename']);
				unlink($_src);
			}
			//删除session
			unset( $_SESSION['avatar_upload_manager'.$userID] );
			$this->success('设置成功！');
		}

		public function _before_edit(){
			if( $_SESSION['AUTH']['level'] != 'administrator' ){
				$this->error('没有权限！');
			}
		}

		public function add(){
			if( $_SESSION['AUTH']['level'] != 'administrator' ){
				$this->error('没有权限！');
			}
			$this->display();
		}

		public function update(){
			$insert = array();
			foreach ( $_POST as $key => $value ) {
				$insert[$key] = trim( $value );
			}
			if ( !empty( $insert['password'] ) ){
				if ($insert['password'] != $insert['repassed']){
					$this->error( '两次输入的密码不相同，请重新正确输入！' );
				}else{
					$insert['password'] = substr( md5( $insert['password'] ) , 5, 8 );
				}
			}else{
				unset( $insert['password'] );
			}
			unset( $insert['repassed'] );
			if ( !$insert['id'] ){
				$where['id'] = $_SESSION['AUTH']['id'];
			}else{
				$where['id'] = $insert['id'];
			}
			unset($insert['id']);
			$status = D('User')->where( $where )->save( $insert );
			if ( $status !== false ){
				$this->success( '修改完成！' );
			}else{
				$this->error( '修改失败！' );
			}
		}

		public function insert(){
			$insert = array();
			foreach ($_POST as $key => $value) {
				$insert[$key] = trim( $value );
			}
			if ( empty( $insert['account'] ) ){
				$this->error( '账号不能为空！');
			}elseif(!preg_match('/^[a-z]\w{4,}$/i',$insert['account'])){
	            $this->error( '账号必须是字母，且5位以上！');
			}elseif( empty( $insert['password'] ) ){
				$this->error( '密码不能为空！');
			}elseif( $insert['password'] != $insert['repassed'] ){
				$this->error( '两次输入的密码不相同，请重新正确输入！');
			}else{
				$model = D('User');
				$user = $model->where("account='".$insert['account']."'")->find();
				if ( !empty( $user ) ){
					$this->error( '用户已存在！');
				}else{
					unset( $insert['repassed'] );
					$insert['password'] = substr( md5( $insert['password'] ) , 5, 8 );
					$status = $model->add( $insert );
					if ( $status ){
						$this->success( '添加完成！' );
					}else{
						$this->error( '添加失败！' );
					}
				}
				
			}
		}

		public function delete(){
			$status = D('User')->where("id='".intval( $_GET['id'] ) ."'")->delete();
			if ( $status ){
				$this->success ( '删除完成！' );
			}else{
				$this->error ( '删除失败！' );
			}
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
