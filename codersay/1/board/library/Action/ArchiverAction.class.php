<?php
	class ArchiverAction extends CommonAction{
		
		public function _before_index(){
			
			$model = M('Archives');
			$map = array();
			if ( isset( $_GET['type'] ) && !empty( $_GET['type'] ) ){
				$type = trim( $_GET['type'] );
				$map['type'] = $type;
			}else{
				$type = 0;
			}
			if ( isset( $_GET['status'] ) ){
				$status = trim( $_GET['status'] );
				if ( $status == '0' ){
					$map['status'] = 0;
				}else{
					unset( $map['status'] );
				}
			}else{
				unset( $map['status'] );
			}
			if ( isset( $_GET['cid'] ) && !empty( $_GET['cid'] ) ){
				$cid = intval( trim( $_GET['cid'] ) );
				$map['cid'] = $cid;
			}else{
				$cid = 0;
			}
			
			$this->getCategoryOption( $type, $cid );
			$this->catTypeOption();
			import( 'ORG.Util.Page' );
			$total = $model->where( $map )->count();
			$p = new Page( $total, C('LIST_BOARD_NUMBER') );
			$list = $model->where( $map )
						->order('id DESC')
						->limit($p->firstRow . ',' . $p->listRows)
						->select();
			$this->assign('list',$list);
			$this->assign('page',$p->show());
		}

		public function getBrokenLast(){
			$model = M('Archives');
			$list = $model->where("type='".$_GET['type']."'")->order('id DESC')->limit($_GET['number'])->select();
			if ( !empty( $list ) ){
				$result = array();
				foreach( $list as $key => $val ){
					$result[$key]['author'] = getAuthorName( $val['author'] );
					$result[$key]['cid'] = getParentCategory( $val['cid'] );
					$result[$key]['click'] = $val['click'];
					$result[$key]['count'] = $val['count'];
					$result[$key]['content'] = strip_tags( $val['content'] );
					if ( $val['create_time'] == 0 ){
						$result[$key]['create_time'] = '未知';
					}else{
						$result[$key]['create_time'] = date( 'Y-m-d H:i:s', $val['create_time'] );
					}
					$result[$key]['id'] = $val['id'];
					$result[$key]['status'] = $val['status'];
					$result[$key]['type'] = $val['type'];
				}
				$this->ajaxReturn( $result, 1, 1 );
			}else{
				$this->ajaxReturn( 0, 0, 0 );
			}
		}
		
		public function publish(){
			//unset( $_SESSION['other_upload_list'],$_SESSION['other_upload_list_id'],$_SESSION['editor_upload_list'],$_SESSION['editor_upload_list'],$_SESSION['video_info'] );
			$type = trim( $_GET['type'] );
			if ( $this->checkPublishType( $type ) === false ){
				$this->error( '参数类型错误！' );
			}
			
			$this->getCategoryOption( $type );
			$this->display( 'add_' . $type );
		}

		public function getVideoUrl(){
			$url = trim( $_POST['url'] );
			
			$reg_1 = array(
				'/.*tudou\.com\/listplay\/(.*?)\/(.*?)\.html/i',
				'/.*tudou\.com\/listplay\/(.*?)\.html/i',
				'/.*tudou\.com\/albumplay\/(.*?)\.html/i',
				'/.*tudou\.com\/programs\/view\/(.*?)\/.*/i',
				'/.*56\.com.*v_([^\/]+?)\.html/i',
				'/.*56\.com\/.*vid-(.*?)\.html/i',
				'/.*ku6\.com.*\/([^\/]+?)\.html/i',
				'/.*youku\.com.*id_(.*?)\.html/i',
				'/.*v\.163\.com.*\/([^\/]+?)\.html/i'
			);
			$reg_2 = array(
				'http://www.tudou.com/l/$1/&resourceId=0_04_05_99/v.swf',
				'http://www.tudou.com/l/$1/&resourceId=0_04_05_99/v.swf',
				'http://www.tudou.com/a/$1/&resourceId=0_04_05_99/v.swf',
				'http://www.tudou.com/v/$1/&resourceId=0_04_05_99/v.swf',
				'http://player.56.com/v_$1.swf',
				'http://player.56.com/v_$1.swf',
				'http://player.ku6.com/refer/$1/v.swf',
				'http://player.youku.com/player.php/sid/$1/v.swf',
				'http://img1.cache.netease.com/flvplayer081128/~false~0085_$1~.swf'
			);
			
			$str = preg_replace( $reg_1 , $reg_2, $url );
			if ( !empty( $str ) ){
				$this->ajaxReturn( $str, 1, 1 );
			}else{
				$this->ajaxReturn( 0, 0, 0 );
			}
		}

		public function _before_update(){
			//-------------------------- 检测下载远程附件
			$checkRemote = $this->checkRemote( $_POST['content'], $_POST['remoteAttach'] );
			if ( $checkRemote['remote'] ){
				$_POST['content'] = $checkRemote['body'];
			}
			//处理取消置顶和推荐
			if ( empty( $_POST['set_top'] ) ) $_POST['set_top'] = 0;
			if ( empty( $_POST['recommend'] ) ) $_POST['recommend'] = 0;
		}

		public function _tigger_update( $model ){
			switch ($this->_post('type')) {
				case 'picture':
					# code...
					break;
				
				default:
					$this->handleAttach( 'other', $_POST['id'] ); //处理附件
					$this->handleAttach( 'editor', $_POST['id'] );  //处理附件
					break;
			}
			$this->saveTag($_POST['tags'],$_POST['id'],'Archives'); //处理tags
			$this->checkSession();
		}

		public function search(){
			if ( empty( $_GET['keyword'] ) ){
				$this->error('请输入搜索关键字。');
			}
			if ( !isset( $_GET['title'] ) && !isset( $_GET['content'] ) ){
				$this->error('请选择要搜索的字段。');
			}
			$where = array();
			$keyword = trim( $_GET['keyword'] );
			$where['title'] = array( 'like', '%' . $keyword . '%' );
			if ( isset( $_GET['content'] ) ){
				$where['content'] = array( 'like', '%' . $keyword . '%' );
				$where['_logic'] = 'OR';
			}
			$model = M('Archives');
			import( 'ORG.Util.Page' );
			$total = $model->where( $where )->count();
			$p = new Page( $total, C('LIST_BOARD_NUMBER') );
			$list = $model->where( $where )
						->order('id DESC')
						->limit($p->firstRow . ',' . $p->listRows)
						->select();
			$this->assign('list',$list);
			$this->assign('page',$p->show());
			$this->display();
		}
		
		
		public function insert(){
			
			if ( isset( $_POST['url_name'] ) ){
				$_POST['url_name'] = trim( $_POST['url_name'] );
				if ( !empty( $_POST['url_name'] ) ){
					$isset = issetURLName( $_POST['url_name'] );
					if( $isset === false ){
						$_POST['url_name'] .= '_' . substr(strtoupper(md5(uniqid().md5(time()))),6,4);
					}
				}
			}
			//-------------------------- 检测下载远程附件
			$checkRemote = $this->checkRemote( $_POST['content'], $_POST['remoteAttach'] );
			if ( $checkRemote['remote'] ){
				$_POST['content'] = $checkRemote['body'];
			}
			//TAGS
			if ( trim( $_POST['tags'] ) == 'TAGS' ){
				$_POST['tags'] = '';
			}
			if ( $_POST['type'] == 'broken' ){
				//处理同步信息
				if ( $_POST['sync_QQ'] && $_SESSION['openid'] ){
					$arguments['syncflag'] = 1;
					if ( $_POST['sync_Qzone'] ) $arguments['syncflag'] = 0;
					if ( $_POST['img'] ){
						//带有图片
						$_match = array();
						foreach ( $_POST['img'] as $kimg => $kval )
						{
							$_match[] = $kval;
						}
						$img = "http://" . $_SERVER["HTTP_HOST"] . $_match[0];
					    $local_pic_url = $this->getLocalPicUrl( $img );
				        $arguments = array(
				            'access_token' => $_SESSION["access_token"],
				            'clientip' => get_client_ip(),
				            'openid' => $_SESSION['openid'],
				            'oauth_consumer_key' => $_SESSION["appid"],
				            'format' => 'json',
				            'content' => $_POST['content'],
				            'pic' => '@'.$local_pic_url
				        );

				        $url = "https://graph.qq.com/t/add_pic_t";
				        $result = $this->syncQQPost($url, $arguments);
				        @unlink($local_pic_url);
					}else{
						//纯文本提交  http://wiki.opensns.qq.com/wiki/%E3%80%90QQ%E7%99%BB%E5%BD%95%E3%80%91add_t
						$url  = "https://graph.qq.com/t/add_t";
					    $arguments = array(
					    	'access_token' => $_SESSION["access_token"],
				            'clientip' => get_client_ip(),
				            'openid' => $_SESSION['openid'],
				            'oauth_consumer_key' => $_SESSION["appid"],
				            'format' => 'json',
				            'content' => $_POST['content']
					    );
					    $result = $this->syncQQPost($url, $arguments);
					}
			        if ( $result["msg"] == 'ok' ){
			        	$_POST['sync_QQ_ID'] = $result['data']['id']; //同步ID记录
			        }
			        //dump($result); exit();
				}
				$_POST['title'] = cn_substr( strip_tags( $_POST['content'] ), 42, 0 );
			}
			
			$model = M ( 'Archives' );
			if ( false === $model->create () ) {
				$this->error ( $model->getError () );
			}

			//保存当前数据对象
			$list = $model->add ();
			if ( $list !== false ) { //保存成功
				if ( $_POST['cid'] != 0 ){
					D('Category')->where("id='".$_POST['cid']."'")->setInc('count');
				}
				switch ( $_POST['type'] ) {
					case 'broken':
						//处理图片数据存储
				        if ( $_SESSION['other_upload_list'] && $_POST['img'] ){
				        	$_insert_attach = D('Attach');
				        	foreach ( $_SESSION['other_upload_list'] as $key => $value ) {
				        		if ( strpos( $_POST['img'][$key] , $value['savename'] ) !== false ){
				        			$_array_pr = explode( '/' , $value['savename'] );
				        			$_attach['cid'] = $list;
				        			$_attach['model'] = 'Archives';
				        			$_attach['type'] = $value['extension'];
				        			$_attach['size'] = $value['size'];
				        			$_attach['name'] = $_array_pr[1];
				        			$_attach['folder'] = $_array_pr[0];
				        			$_attach['ext'] = '.'.$value['extension'];
				        			$_attach['status'] = 1;
				        			$_attach['create_time'] = time();
				        			$_attach['hash'] = $value['hash'];
				        			$_attach['title'] = $value['name'];
				        			$_attach['mime'] = $value['type'];
				        			$_insert_attach_status = $_insert_attach->add( $_attach );
				        		}
				        	}
				        }
				        if ( $_SESSION['other_upload_list'] ) {
				        	unset( $_SESSION['other_upload_list'], $_SESSION["other_upload_list_id"] );
				        }
						break;
					
					case 'picture':
						$this->checkGroupPic( $list ); //处理图集
						break;

					default :
						$this->handleAttach( 'editor', $list );  //处理附件
						break;
				}
				/* 处理远程获取的图片 */
				if ( $checkRemote['remote'] ){
					$_remote['status'] = 1;
					$_remote['cid'] = $list;
					D('Attach')->where("cid='".$_SESSION['AUTH']['last_login_time']."' AND status='0'")->save( $_remote );
				}
				
				$this->saveTag($_POST['tags'],$list,'Archives'); //处理tags
				$this->checkSession();  //处理 缩略图产生的 Session
				$this->success ('新增成功!');
			} else {
				$this->error ('新增失败!');
			}
		}

		private function handleAttach( $type, $cid ){
			if ( isset( $_SESSION[$type."_upload_list"] ) && count( $_SESSION[$type."_upload_list"] ) > 0 ){
				$_insert_attach = D('Attach');
				foreach ( $_SESSION[$type."_upload_list"] as $key => $value ) {
	        		$_array_pr = explode( '/' , $value['savename'] );
        			$_attach['cid'] = $cid;
        			$_attach['model'] = 'Archives';
        			$_attach['type'] = $value['extension'];
        			$_attach['size'] = $value['size'];
        			$_attach['name'] = $_array_pr[1];
        			$_attach['folder'] = $_array_pr[0];
        			$_attach['ext'] = '.'.$value['extension'];
        			$_attach['status'] = 1;
        			$_attach['create_time'] = time();
        			$_attach['hash'] = $value['hash'];
        			$_attach['title'] = $value['name'];
        			$_attach['mime'] = $value['type'];
        			$_insert_attach_status = $_insert_attach->add( $_attach );
	        	}
	        	unset( $_SESSION[$type."_upload_list"], $_SESSION[$type."_upload_list_id"] );
			}
		}
		
		public function updateAlbum(){
			$model = D('Archives');
			
			$d = $_POST;
			$d['update_time']		= time();
			$d['content']			= stripslashes( $d['content'] );
			
			if ( $model->where("id='".$d['id']."'")->save($d) ){
				$this->checkGroupPic();
				$this->saveTag( $d['tags'], $d['id'], 'Archives' ); //处理tags
				$this->success ('修改成功!');
			}else{
				$this->error ('修改失败!');
			}
		}
		
		private function checkGroupPic( $cid=0 ){
			if ( $cid != 0 ){
				$cid = (int)$cid;
			}else{
				$cid = (int)$_POST['id'];
			}
			
			if ( !empty( $_POST['pics'] ) ){
				$model = D('Picture');
				foreach ( $_POST['pics'] as $key => $val ){
					$p['cid'] = $cid;
					$p['create_time'] = time();
					$p['folder'] = $val['folder'];
					$p['ext'] = $val['extension'];
					$p['size'] = $val['size'];
					$p['file'] = $val['name'];
					$p['name'] = $val['text'];
					$p['status'] = 1;
					$model->add( $p );
				}
			}
			$this->checkAlbumSession();
		}

		public function delete(){
			$id = intval($_GET['id']);
			if ( $id ){
				$model = D('Archives');
				$result = $model->find($id);
				$this->checkDelAttach( $result['id'], $result['attach'] );
				$this->checkDelThumb( $result['thumb'] );
				if ( $model->delete($id) === false ){
					$this->error( '删除失败！' );
				}else{
					$cid = intval( $_GET['cid'] );
					if ( $cid !== 0 ){
						D('Category')->where("id='".$cid."'")->setDec('count');
					}
					//处理图集类
					if ( $result['type'] == 'picture' ){
						$p_model = D('Picture');
						$p_list = $p_model->where("cid='".$id."'")->select();
						if ( !empty( $p_list ) ){
							$_dir = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH').'/';
							foreach ($p_list as $key => $value) {
								$_pic_type = $this->_setPicType( $value['file'] );
								$_dirs = $_dir . $value['folder'] . '/';
								foreach ($_pic_type as $_type) {
									if ( is_file( $_dirs . $_type ) ) @unlink( $_dirs . $_type );
								}
							}
						}
						$p_model->where("cid='".$id."'")->delete();
					}else{
						$a_model = D('Attach');
						$a_list = $a_model->where("cid='".$id."'")->select();
						if ( !empty( $a_list ) ){
							$_dir = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_ATTCH_PATH').'/';
							foreach ($a_list as $key => $value) {
								$_dirs = $_dir . $value['folder'] . '/' . $value['name'];
								if ( is_file( $_dirs ) ) @unlink( $_dirs );
							}
							$p_model->where("cid='".$id."'")->delete();
						}
					}
					$this->success( '删除完成！' );
				}
			}
			
		}
		
		public function oDelpic(){
			$model = D('Picture');
			
			$list = $model->find( $_GET['item'] );
			$file_path = __ROOT_PATH__ . '/'.C('WEB_PUBLIC_PATH').'/'.C('DIR_UPLOAD_PATH').'/'.$list['folder'].'/';
			
			if ($model->where("id='".$_GET['item']."'")->delete()){
				//删除文件
				$array = $this->_setPicType( $list['file'] );
				foreach ($array as $value) {
					if ( is_file( $file_path . $value ) ) @unlink( $file_path . $value );
				}
				
				$this->ajaxReturn(1,1,1);
			}else{
				$this->ajaxReturn(0,0,0); //删除失败
			}
			
		}

		public function delOnepic(){
			$t_path = C('TMPL_PARSE_STRING');
			$id = $this->_get('id');
			$model = D('Attach');
			$file = $model->find($id);
			$file_path = __ROOT_PATH__ . '/' .C('WEB_PUBLIC_PATH').'/'.C('DIR_ATTCH_PATH') . '/' . $file['folder'] . '/' . $file['name'];
			if ( unlink( $file_path ) && $model->delete($id) ){
				$this->success('删除完成！');
			}else{
				$this->error('删除失败！');
			}
		}

		public function insertOneCatalog()
		{
			$model = D('Category');
			$catalog['name'] = $this->_post('name');
			$catalog['type'] = $this->_post('type');
			$catalog['nav'] = 'nav';
			if ( empty( $catalog['name'] ) ){
				$this->ajaxReturn( '分类名称不能为空！', 0, 0 );
			}
			$insert = $model->add($catalog);
			if ( $insert ){
				$this->ajaxReturn( array('id'=>$insert,'name'=>$catalog['name']), 1, 1 );
			}else{
				$this->ajaxReturn( '添加失败', 0, 0 );
			}
		}
		
		public function actionOther(){
			if ( empty( $_POST['ids'] ) ){
				$this->error( '为选择任何项目。' );
			}else{
				$map['id'] = array('in',$_POST['ids']);
				$this->model = D('Archives');
				
				if ( $_POST['batchAction'] ){
					switch( $_POST['batch'] ){
						case 'disable' :
							if ( $this->model->where( $map )->setField('status',0) ){
								$this->success( '禁用完成。' );
							}else{
								$this->error( '禁用失败！' );
							}
							break;
						case 'enable' :
							if ( $this->model->where( $map )->setField('status',1) ){
								$this->success( '启用完成。' );
							}else{
								$this->error( '启用失败！' );
							}
							break;
						case 'del' :
							//$catModel = D('Category');
							foreach( $_POST['ids'] as $val ){
								$data = $this->model->where("id='".$val."'")->find();
								$status = 0;
								switch( $data['type'] ){
									case 'picture' :
										//图集类批量删除处理
										$model = D('Picture');
										$list = $model->where("cid='".$val."'")->select();
										foreach ( $list as $key => $vals ){
											$file_path = __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_UPLOAD_PATH') . '/' . $vals['folder'] . '/';
											$__array = $this->_setPicType( $vals['file'] );
											foreach ($__array as $__value) {
												if ( is_file( $file_path . $__value ) ) @unlink( $file_path . $__value );
											}
										}
										$model->where("cid='".$val."'")->delete(); //删除图片数据
										$status = 1;
										break;
									default :
										//默认批量删除附件规则
										$this->checkDelAttach( $val, $data['attach'] );
										$this->checkDelThumb( $data['thumb'] );
										$status = 1;
										break;
								}
								$this->model->where("id='".$val."'")->delete();
								D('Category')->where("id='".$data['cid']."'")->setDec('count');
							}
							if ( $status === 1 ){
								$this->success( '删除完成。' );
							}else{
								$this->error( '删除失败！' );
							}
							break;
						default :
							$this->error('批量操作类型错误！');
							break;
					}
				}
				if ( $_POST['moveToCatalog'] ){
					if ( $this->model->where( $map )->setField('cid',$_POST['cid']) ){
						$this->success( '移动完成。' );
					}else{
						$this->error( '移动失败！' );
					}
				}
			}
		}

		public function deleteExistAttach(){
			$id = $this->_post('id');
			//$type = $this->_post('etype');
			$url = $this->_post('url');
			$path = __ROOT_PATH__;
			if ( $url ){
				@unlink( $path . $url );
			}
			if ( $id ){
				D('Attach')->delete($id);
			}
			$this->ajaxReturn('操作完成！',1,1);
		}

		private function syncQQPost($url, $data)
		{
		    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		    curl_setopt($ch, CURLOPT_POST, TRUE); 
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
		    curl_setopt($ch, CURLOPT_URL, $url);

		    $return = json_decode(curl_exec($ch));
		    curl_close($ch);
		    return $this->objectToArray($return);
		}

		private function objectToArray( $stdclassobject ){
			$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
			foreach ($_array as $key => $value) {
		        $value = (is_array($value) || is_object($value)) ? $this->objectToArray($value) : $value;
		        $array[$key] = $value;
		    }
		    return $array;
		}

		/*
		 * 检测是否下载远程附件
		 * $body 要检测的内容
		 * $checkbox 是否选中下载选项
		*/
		private function checkRemote( $body, $checkbox ){
			$remote = false;
			if ( $checkbox ){
				set_time_limit(0);
				$body = stripslashes( trim( $body ) );
				$_host = "http://".$_SERVER["HTTP_HOST"];
				$img_array = array();
				preg_match_all( "/src=[\"|'|\s]{0,}(http:\/\/([^>]*)\.(gif|jpg|png))/isU", $body, $img_array );
				$img_array = array_unique( $img_array[1] );
				$folder = date('Ymd');
				//*路径
				$_img_path = C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH') . '/' . $folder . '/';
				if ( !is_dir( $_img_path ) ) mk_dir( $_img_path );
				//----
				$attach_model = D('Attach');
				$tmp_cid = $_SESSION['AUTH']['last_login_time'];
				foreach ( $img_array as $key => $value ) {
					if ( preg_match( "#".$_host."#i", $value ) ) continue;
					if ( !preg_match( "#^http:\/\/#i", $value ) ) continue;
					$_new_name = md5( end( explode( '/', $value ) ) );
					$_new_path = __ROOT_PATH__ . '/' . $_img_path . $_new_name;
					$_save_result = $this->downloadImage( $value, $_new_path );
					$_insert['cid'] = $tmp_cid;
					$_insert['model'] = 'Archives';
					$_insert['type'] = $_save_result['type'];
					$_insert['size'] = $_save_result['size'];
					$_insert['name'] = $_save_result['filename'];
					$_insert['folder'] = $folder;
					$_insert['ext'] = $_save_result['ext'];
					$_insert['status'] = 0;
					$_insert['create_time'] = time();
					$_insert['hash'] = $_save_result['hash'];
					$_insert['title'] = $_save_result['orginalfilename'];
					$_insert['mime'] = $_save_result['mime'];
					$attach_model->add( $_insert );
					$body = str_replace( $value, $_img_path . $_save_result['filename'], $body );
				}
				$remote = true;
			}
			return array( 'remote' => $remote, 'body' => $body );
		}

		/**
	     * 下载远程图片
	     * @param string $url 图片的绝对url
	     * @param string $filepath 文件的完整路径（包括目录，不包括后缀名,例如/www/images/test） ，此函数会自动根据图片url和http头信息确定图片的后缀名
	     * @return mixed 下载成功返回一个描述图片信息的数组，下载失败则返回false
	     */
	    private function downloadImage($url, $filepath) {
	        //服务器返回的头信息
	        $responseHeaders = array();
	        //原始图片名
	        $originalfilename = '';
	        //图片的后缀名
	        $ext = '';
	        $ch = curl_init($url);
	        //设置curl_exec返回的值包含Http头
	        curl_setopt($ch, CURLOPT_HEADER, 1);
	        //设置curl_exec返回的值包含Http内容
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        
	        //设置抓取跳转（http 301，302）后的页面
	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	        //设置最多的HTTP重定向的数量
	        curl_setopt($ch, CURLOPT_MAXREDIRS, 2);

	        //服务器返回的数据（包括http头信息和内容）
	        $html = curl_exec($ch);
	        //获取此次抓取的相关信息
	        $httpinfo = curl_getinfo($ch);
	        curl_close($ch);
	        if ($html !== false) {
	            //分离response的header和body，由于服务器可能使用了302跳转，所以此处需要将字符串分离为 2+跳转次数 个子串
	            $httpArr = explode("\r\n\r\n", $html, 2 + $httpinfo['redirect_count']);
	            //倒数第二段是服务器最后一次response的http头
	            $header = $httpArr[count($httpArr) - 2];
	            //倒数第一段是服务器最后一次response的内容
	            $body = $httpArr[count($httpArr) - 1];
	            $header.="\r\n";

	            //获取最后一次response的header信息
	            preg_match_all('/([a-z0-9-_]+):\s*([^\r\n]+)\r\n/i', $header, $matches);
	            if (!empty($matches) && count($matches) == 3 && !empty($matches[1]) && !empty($matches[1])) {
	                for ($i = 0; $i < count($matches[1]); $i++) {
	                    if (array_key_exists($i, $matches[2])) {
	                        $responseHeaders[$matches[1][$i]] = $matches[2][$i];
	                    }
	                }
	            }
	            //获取图片后缀名
	            if (0 < preg_match('{(?:[^\/\\\\]+)\.(jpg|jpeg|gif|png|bmp)$}i', $url, $matches)) {
	                $originalfilename = $matches[0];
	                $ext = $matches[1];
	            } else {
	                if (array_key_exists('Content-Type', $responseHeaders)) {
	                    if (0 < preg_match('{image/(\w+)}i', $responseHeaders['Content-Type'], $extmatches)) {
	                        $ext = $extmatches[1];
	                    }
	                }
	            }
	            //保存文件
	            if (!empty($ext)) {
	                $filepath .= ".$ext";
	                //如果目录不存在，则先要创建目录
	                //CFiles::createDirectory(dirname($filepath));
	                $local_file = fopen($filepath, 'w');
	                if (false !== $local_file) {
	                    if (false !== fwrite($local_file, $body)) {
	                        fclose($local_file);
	                        $sizeinfo = getimagesize($filepath);
	                        $new_name = pathinfo($filepath, PATHINFO_BASENAME);
	                        $type = end(explode('.', $new_name));
	                        return array(
	                        	'filepath' => realpath($filepath), 
	                        	'width' => $sizeinfo[0], 
	                        	'height' => $sizeinfo[1], 
	                        	'orginalfilename' => $originalfilename, 
	                        	'filename' => $new_name,
	                        	'type' => $type,
	                        	'ext' => '.'.$type,
	                        	'size' => $sizeinfo['bits'],
	                        	'hash' => hash_file('md5',realpath($filepath)),
	                        	'mime' => $sizeinfo['mime']
	                        );
	                    }
	                }
	            }
	        }
	        return false;
	    }

	    private function getLocalPicUrl($pic_url){
	        $time = time();
	        $pic_local_path = __ROOT_PATH__.'/cache';
	        $pic_local = $pic_local_path.'/'.$time;

	        if(!file_exists($pic_local_path)){
	            mkdir($pic_local_path,0777);
	            @chmod($pic_local_path,0777);
	        }

	        ob_start();  //打开输出
	        readfile($pic_url);  //输出图片文件
	        $img = ob_get_contents();  //得到浏览器输出
	        ob_end_clean();  //清除输出并关闭
	        file_put_contents($pic_local, $img);
	        return $pic_local;
	    }
		
	}
