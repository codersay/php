<?php
	class ToolsAction extends CommonAction{
		private $folder = '/backup/';
		
		public function index(){
			$this->assign('folder',$this->checkFolder());
			$this->display();
		}
		public function backup(){
			$this->dataAction(__FUNCTION__);
		}
		public function del(){
			$this->dataAction(__FUNCTION__);
		}
		public function download(){
			$this->dataAction(__FUNCTION__);
		}
		public function reduction(){
			$this->dataAction(__FUNCTION__);
		}
		public function sqlrun(){
			$this->display();
		}
		public function counts(){
			$data = M('Counts')->find();
			$this->assign('vo',$data);
			$this->display();
		}
		public function checkCounts(){
			$archives_model = M('Archives');
			$archives = $archives_model->count();
			$article = $archives_model->where("type='article'")->count();
			$picture = $archives_model->where("type='picture'")->count();
			$music = $archives_model->where("type='music'")->count();
			$video = $archives_model->where("type='video'")->count();
			$broken = $archives_model->where("type='broken'")->count();
			$comment = M('Comment')->count();
			$guestbook = M('Guestbook')->count();
			$update = D('Counts')->execute( "UPDATE __TABLE__ SET `archives`='$archives', `article`='$article', `picture`='$picture', `music`='$music', `video`='$video', `broken`='$broken', `comment`='$comment', `guestbook`='$guestbook' LIMIT 1;" );
			if ( $update ){
				$this->success('数据修复完成！');
			}else{
				$this->error('数据无需修复！');
			}
		}
		public function advs(){
			$this->model = M('Adv');
			$type = $this->_get('type');
			if ( $type ){
				$map['type'] = $type;
			}else{
				$map['type'] = 'focus';
			}
			import( 'ORG.Util.Page' );
			$count = $this->model
				->where( $map )
				->count();
			$p = new Page( $count, C('LIST_BOARD_NUMBER') );
			$list = $this->model
				->where( $map )
				->order( 'id DESC' )
				->limit( $p->firstRow . ',' . $p->listRows )
				->select();
			$this->assign('type',$map['type']);
			$this->assign('list',$list);
			$this->assign('page',$p->show());
			$this->display();
		}
		public function advadd(){
			$this->assign('type',$this->_get('type'));
			$this->display();
		}
		public function insert(){
			foreach ($_POST as $key => $value) {
				$_POST[$key] = trim( $value );
			}
			if ( D('Adv')->add( $_POST ) ){
				if ( $_SESSION['other_upload_list'] ) {
		        	unset( $_SESSION['other_upload_list'], $_SESSION["other_upload_list_id"] );
		        }
                $this->success ('新增成功!');
            }else{
                $this->error ('新增失败!');
            }
		}
		public function customdata(){
			$this->display();
		}
		public function cache(){
			$this->display();
		}
		public function clear(){
			$d = $_POST;
			//$_root_dir = str_replace ( "\\", "/", dirname(dirname(dirname(dirname(__FILE__)))) );
			
			$success = '<h2>清除结果：</h2><br />';
			if ($d['boards']){
				$_cache_path = RUNTIME_PATH;
				
				$success .= $this->exaction( $_cache_path, $d['board'] );
				if ( $d['board_runtime'] ){
					$success .= $this->delAppRuntime( $_cache_path );
				}
			}
			
			if ($d['applications']){
				$_cache_path = __ROOT_PATH__ . '/cache/applications/';
				$success .= $this->exaction( $_cache_path, $d['app'] );
				if ( $d['app_runtime'] ){
					$success .= $this->delAppRuntime( $_cache_path );
				}
			}
			
			$this->assign( "success", $success );
			$this->display();
		}
		public function clearall(){
			$_root_dir = __ROOT_PATH__ . '/cache/';
			if ( $this->deleteFile( $_root_dir ) === false ){
				$this->error('清除失败');
			}else{
				$this->success('清除缓存完成');
			}
		}
		public function sqlruning(){
			$sql = trim( $_POST['sqltext'] );
			if ( !empty( $sql ) ){
				$pre = C('DB_PREFIX');
				$sql = stripslashes( $sql );
				$sql = preg_replace("/(.*?)__(.*?)__(.*?)/", "\\1$pre\\2\\3", $sql);
				$model = new Model();
				if ( $model->execute($sql) ){
					$this->success('SQL 查询完成！');
				}else{
					$this->error('查询失败，请检查SQL语句！');
				}
			}else{
				$this->error('SQL语句为空，查询失败！');
			}
		}

		public function anyreadpost(){
			$prex = C('CUSTOM_URL_DEPR');
			$post = $where = array();

			$where['status'] = 1;
			$limit = '';
			$urlstr = 'getAnyFree' . $prex . 'defaults';

			foreach ($_POST as $key => $value) {
				$post[$key] = trim( $value );
			}

			if ( empty( $post['orderby'] ) ){
				$post['orderby'] = 'id';
			}

			if ( !empty( $post['arctype'] ) ){
				$where['type'] = $post['arctype'];
				$urlstr .= $prex . 'types' . $prex . $post['arctype'];
			}

			if ( $post['orderby'] == 'rand' ){
				$order = 'rand()';
			}else{
				$order = $post['orderby'] . ' ' . $post['order'];
			}

			if ( $post['qty'] > 0 ){
				$limit = $post['qty'];
				$urlstr .= $prex . 'qty' . $prex . $post['qty'];
			}else{
				$limit = 10;
				$urlstr .= $prex . 'qty' . $prex . '10';
			}

			if ( $post['model'] == 'Archives' ){

				if ( $post['summary'] ){
					$where['summary'] = array( 'neq', 0 );
					$urlstr .= $prex . 'summary' . $prex . $post['summary'];
				}
				if ( $post['thumb'] ){
					$where['thumb'] = array( 'neq', 0 );
					$urlstr .= $prex . 'thumb' . $prex . $post['thumb'];
				}
				
				if ( $post['title_len'] > 0 ){
					$urlstr .= $prex . 'title_len' . $prex . $post['title_len'];
				}else{
					$urlstr .= $prex . 'title_len' . $prex . '30';
				}
				
			}elseif( $post['model'] == 'Flink' ){
				
				if ( $post['logo'] ){
					$where['logo'] = array( 'neq', 0 );
					$urlstr .= $prex . 'logo' . $prex . $post['logo'];
				}

			}

			$urlstr .= $prex . 'orderby' . $prex . $post['orderby'] . $prex . 'order' . $prex . $post['order'] . $prex . 'style' . $prex . $post['style'] . $prex . 'model' . $prex . $post['model'];

			$return['where'] = $where;
			$return['order'] = $order;
			$return['limit'] = $limit;
			$return['jsstr'] = $urlstr;
			$return['model'] = $post['model'];
			$return['style'] = $post['style'];
			$return['title_len'] = $post['title_len'];
			$this->ajaxReturn($return,$post['style'],1);
			
		}

		public function edit()
		{
			$id   = $this->_get('id');
			$type = $this->_get('type');
			$mod  = $this->_get('mod');
			$vo = M('Adv')->find($id);
			$this->assign('vo',$vo);
			$this->assign('type',$type);
			$this->display();
		}

		public function update()
		{
			foreach ($_POST as $key => $value) {
				$_POST[$key] = trim( $value );
			}
			$where['id'] = $this->_post('id');
			if ( D('Adv')->where($where)->save( $_POST ) ){
				if ( $_SESSION['other_upload_list'] ) {
		        	unset( $_SESSION['other_upload_list'], $_SESSION["other_upload_list_id"] );
		        }
                $this->success ('修改成功!');
            }else{
                $this->error ('修改失败!');
            }
		}

		public function removeBanner()
		{
			if ( D('Adv')->where("id='".$this->_post('id')."'")->setField('banner','') ){
				@unlink( __ROOT_PATH__ . $this->_post('file') ); $this->success( '删除完成！', 1, 1 );
			}else{
				$this->error( '删除失败！', 0, 0 );
			}
		}

		public function delete()
		{
			$mod = $this->_get('mod');
			$id = $this->_get('id');
			if ( $mod == 'advs' ) $mod = 'Adv';
			$status = false;
			switch ( $mod ) {
				case 'Adv':
					$model = D('Adv');
					$adv = $model->find( $id );
					if ( $model->delete( $id ) ){
						@unlink( __ROOT_PATH__ . $adv['banner'] );
						$status = true;
					}
					break;
			}
			if ( $status ){
				$this->success('删除完成！');
			}else{
				$this->error('删除失败！');
			}
		}

		public function forbid()
		{
			$this->_setStatus( 0, $this->_get('id'), 'Adv' );
		}

		public function resume()
		{
			$this->_setStatus( 1, $this->_get('id'), 'Adv' );
		}
		
		private function exaction($path, $array){
			$success = '';
			foreach ($array as $key => $val) {
				if ( $this->deleteFile( $path . $val ) === false ){
					$success .= '<p>清除缓存 <em class="nv">»</em> <span style="color:red;">' . $val . '失败!</span></p>'."\r\n";
				}else{
					$success .= '<p>清除缓存 <em class="nv">»</em> <span style="color:green;">' . $val . '成功!</span></p>'."\r\n";
				}
			}
			return $success;
		}
		
		private function delAppRuntime($path){
			$success = '';
			if ( unlink( $path . '~runtime.php' ) ){
				$success .= '<p>清除缓存 <em class="nv">»</em> <span style="color:green;">项目配置缓存文件成功!</span></p>'."\r\n";
			}else{
				$success .= '<p>清除缓存 <em class="nv">»</em> <span style="color:red;">项目配置缓存文件失败!</span></p>'."\r\n";
			}
			return $success;
		}
		private function dataAction($action){
			$data_dir = $this->checkFolder();
			if ( $action ){
				import( 'ORG.Net.MySQLReback' );
				$config = array(
					'host'			=> C('DB_HOST'),
					'port'			=> C('DB_PORT'),
					'userName'		=> C('DB_USER'),
					'userPassword'	=> C('DB_PWD'),
					'dbprefix'		=> C('DB_PREFIX'),
					'charset'		=> C('DB_CHARSET'),
					'path'			=> $data_dir,
					'isCompress'	=> 0,
					'isDownload'	=> 0
				);
				
				$mr = new MySQLReback( $config );
				$mr->setDBName( C('DB_NAME') );
				
				$param = array('node'=>$_GET['node']);
				switch ( $action ) {
					case 'backup':
						$mr->backup();
						$this->success( '数据备份完成' );
					break;
					
					case 'reduction':
						$mr->recover( $_GET['file'] );
						$this->success( '数据库还原成功' );
					break;
						
					case 'del':
						if ( @unlink( $data_dir . $_GET['file'] ) ){
							$this->success( '删除完成' );
						}else{
							$this->error( '删除失败' );
						}
					break;
						
					case 'download':
						$file_name = __ROOT__  . $this->folder . $_GET['file'];
						function downloadFile( $file_name ){
							ob_end_clean();
							header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
							header( "Content-Description: File Transfer" );
							header( "Content-Type: application/octet-stream" );
							header( "Content-Length: " . filesize( $file_name ) );
							header( "Content-Disposition: attachment; filename=" . basename( $file_name ) );
							readfile( $file_name );
						}
						downloadFile( $file_name );
						exit();
					break;
				}
			}
		}
		private function checkFolder(){
			$folder = __ROOT_PATH__ . $this->folder;
			if( !is_dir( $folder ) ){
				@mkdir( $folder, 0777 );
			}
			return $folder;
		}
	}