<?php
	class CommonAction extends Action{
		
		protected static $model = null; //数据模型model
		protected $theme;
		protected $items;
		protected $utype = array('article','picture','music','video','broken','alone');
		public $lang = 'zh-cn';
		public $sessionID;
		public $userID;
		public $userInfo;
		
		public function _initialize(){
			header("Content-type: text/html; charset=utf-8");
			if(!isset($_SESSION['AUTH'])){
				$reuri = ( IS_HTTPS ) ? 'https:' : 'http:';
				$reuri .= '//' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
				$reuri = urlencode( base64_encode( $reuri ) );
				$this->redirect('public/login',array('reuri'=>$reuri));
			}
			import("ORG.Util.Input");
			$catmod = M('Node');
			$catlist = $catmod->where("status=1 AND pid=0")->order('sort')->select();
			$this->assign('root_node',$catlist);

			if ( isset( $_GET['node'] ) ){
				$sidebar = $catmod->where("status=1 AND pid='".$this->_get('node')."'")->order('sort')->select();
				$this->assign('sidebar',$sidebar);
			}
		}
		
		public function index(){
			$this->display();
		}
		
		public function edit() {
			$model = $this->getActionName();
			$_per = '';
			switch( strtolower( $model ) ){
				case 'archiver' :
					$_name = 'Archives';
					$_per = '_' . strtolower( trim( $_GET['type'] ) );
					break;
				case 'catalog' :
					$_name = 'Category';
					break;
				default :
					$_name = $model;
					break;
			}
			
			if ( isset( $_GET['cid'] ) ){
				if ( strtolower( MODULE_NAME ) == 'archiver' ){
					$this->getCategoryOption( $_GET['type'], $_GET['cid'] );
				}
			}
			
			$this->model = M( $_name );
			if ( $_name == 'Alone' ){
				$where['cid'] = $this->_get('id');
			}else{
				$where['id'] = $this->_get('id');
			}
	        $vo = $this->model->where($where)->find();
	        $this->assign('vo', $vo);
	        $this->display('edit' . $_per);
		}
		
		public function update() {
			$this->model = D( $this->_getCommonModelName() );
	        if ( false === $this->model->create() ) {
	            $this->error( $this->model->getError() );
	        }
	        // 更新数据
	        if ( false !== $this->model->save() ) {
	            // 回调接口
	            if ( method_exists( $this, '_tigger_update' ) ) {
	                $this->_tigger_update( $this->model );
	            }
	            //成功提示
	            $this->success('更新成功');
	        } else {
	            //错误提示
	            $this->error('更新失败');
	        }
		}
		
		/**
	     +----------------------------------------------------------
		 * 默认禁用操作
		 *
	     +----------------------------------------------------------
		 * @access public
	     +----------------------------------------------------------
		 * @return string
	     +----------------------------------------------------------
		 * @throws FcsException
	     +----------------------------------------------------------
		 */
		public function forbid() {
			$this->model = D( $this->_getCommonModelName() );
	        $pk = $this->model->getPk();
	        $id = $_GET[$pk];
	        $condition = array( $pk => array( 'in', $id ) );
	        if ( $this->model->forbid( $condition ) ) {
	            $this->success('状态禁用成功！');
	        } else {
	            $this->error('状态禁用失败！');
	        }
			
		}
		
		/**
	     +----------------------------------------------------------
		 * 默认恢复操作
		 *
	     +----------------------------------------------------------
		 * @access public
	     +----------------------------------------------------------
		 * @return string
	     +----------------------------------------------------------
		 * @throws FcsException
	     +----------------------------------------------------------
		 */
		function resume() {
			//恢复指定记录
			$model = D( $this->_getCommonModelName() );
	        $pk = $model->getPk();
	        $id = $_GET[$pk];
	        $condition = array( $pk => array( 'in', $id ) );
	        if ( $model->resume( $condition ) ) {
	            $this->success('状态恢复成功！');
	        } else {
	            $this->error('状态恢复失败！');
	        }
		}
		
		protected function _getCommonModelName(){
			$model = $this->getActionName();
			switch( strtolower( $model ) ){
				case 'archiver' :
					$_name = 'Archives';
					break;
				case 'catalog' :
					$_name = 'Category';
					break;
				default :
					$_name = $model;
					break;
			}
			return $_name;
		}
		
		protected function checkPublishType( $type ){
			foreach ( $this->utype as $val) {
				if ( $type == $val ) return true;
			}
			return false;
		}
		
		protected function catTypeOption( $type='' ){
			$html = '<option value=""> 选择类型 </option>';
			$selected = '';
			foreach($this->utype as $val){
				if ( isset( $_GET['type'] ) ){
					if ( $_GET['type'] == $val ){
						$selected = ' selected="selected"';
					}else{
						$selected = '';
					}
				}
				$html .= '<option value="'.$val.'"'.$selected.'>'.$this->catTypeText($val).'('.$val.')</option>';
			}
			//return $html;
			$this->assign('typeOption',$html);
		}
		
		private function catTypeText($type){
			$text = '';
			switch( $type ){
				case 'article' :
					$text = '文章';
					break;
				case 'picture' :
					$text = '图集';
					break;
				case 'music' :
					$text = '音乐';
					break;
				case 'video' :
					$text = '视频';
					break;
				case 'broken' :
					$text = '碎语';
					break;
				case 'alone' :
					$text = '单页面';
					break;
			}
			return $text;
		}
		
		//获取Select option分类列表
		protected function getCategoryOption($type='',$curID=0,$this_model='Category'){
			
			$model = M( $this_model );
			$sql = '';
			/*if ( !empty( $type ) ){
				$sql .= "type='".$type."'";
			}*/
			$list = $model->field('id,pid,name,type')->select();
			$html = '';
			
			import('ORG.Util.Trees');
			$tree = new tree($list);
			
			$str = "<option value=\$id \$selected \$disabled>\$spacer \$name</option>";
			if ($curID != 0){
				$html .= $tree->getTreelist(0, $str, $curID, '', $_GET['type']);
			}else{
				$html .= $tree->getTreelist(0, $str, 0, '', $_GET['type']);
			}
			if ( empty( $html ) ){
				$html = '<option value="0" selected="selected"> -- 请选择分类 -- </option>';
			}
			$this->assign("option",$html);
		}
		
		protected function saveTag($tags, $id, $module = MODULE_NAME) {
	        if (!empty($tags) && !empty($id)) {
	            $Tag = M("Tag");
	            $Tagged = M("Tagged");
	            // 记录已经存在的标签
	            $exists_tags = $Tagged->where("module='{$module}' and record_id={$id}")->getField("id,tag_id");
	            $Tagged->where("module='{$module}' and record_id={$id}")->delete();
	            $tags = explode(' ', $tags);
	            foreach ($tags as $key => $val) {
	                $val = trim($val);
	                if (!empty($val)) {
	                    $tag = $Tag->where("module='{$module}' and name='{$val}'")->find();
	                    if ($tag) {
	                        // 标签已经存在
	                        if (!in_array($tag['id'], $exists_tags)) {
	                            $Tag->where('id=' . $tag['id'])->setInc('count');
	                        }
	                    } else {
	                        // 不存在则添加
	                        $_tag = array();
	                        $_tag['name'] = $val;
	                        $_tag['count'] = 1;
	                        $_tag['module'] = $module;
	                        $result = $Tag->add($_tag);
	                        $_tag['id'] = $result;
	                    }
	                    // 记录tag关联信息
	                    $t = array();
	                    $t['user_id'] = $_SESSION['AUTH']['id'];
	                    $t['module'] = $module;
	                    $t['record_id'] = $id;
	                    $t['create_time'] = time();
	                    $t['tag_id'] = $_tag['id'];
	                    $Tagged->add($t);
	                }
	            }
	        }
	    }

		protected function checkSession(){
			if ( isset( $_SESSION["crop_zoom"] ) ){
				if ( file_exists( $_SESSION["crop_zoom"]['large_path'] ) ){
					@unlink( $_SESSION["crop_zoom"]['large_path'] );
				}
				unset( $_SESSION["crop_zoom"] );
			}
		}
		
		protected function checkAlbumSession(){
			if (isset($_SESSION['picture_list_file_id'])) unset($_SESSION['picture_list_file_id']);
			if (isset($_SESSION['picture_list_file'])) unset($_SESSION['picture_list_file']);
			S('up_cache_'.$_SESSION['AUTH']['last_login_time'],NULL);
		}
		
		/*
		 * ====================================================
		 * 文档以及图集公用删除方法
		 * 
		 * ====================================================
		 */
		protected function eDelete( $id ){
			$model = D( 'Archives' );
			$data = $model->where("id='".$id."'")->find();
			$return = 0;
			switch ( $data['type'] ){
				case 'picture' : 
					$p_model = D('Picture');
					$p_list = $p_model->where("cid='".$id."'")->select();
					foreach ( $p_list as $key => $val ){
						$file_path = __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_UPLOAD_PATH') . '/' . $val['folder'] . '/';
						if ( file_exists( $file_path  ) ){
							@unlink( $file_path . $val['file'] );
							@unlink( $file_path . 'resize_' . $val['file'] );
							@unlink( $file_path . 'mini_' . $val['file'] );
							@unlink( $file_path . 'thumb_' . $val['file'] );
						}
					}
					$p_model->where("cid='".$id."'")->delete(); //删除图片数据
					$return = 1;
					break;
					
				case 'video' :
					$this->checkDelAttach( $data['attach'] );
					$this->checkDelThumb( $data['thumb'] );
					@unlink ( __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH') . '/' . $archives['video_path'] );
					$return = 1;
					break;
					
				default :
					$this->checkDelAttach( $data['attach'] );
					$this->checkDelThumb( $data['thumb'] );
					$return = 1;
					break;
					
			}
			$model->where("id='".$id."'")->delete();
			if ( $return == 0 ){
				$this->error( '删除失败！' );
			}else{
				D('Category')->where("id='".$catelog."'")->setDec('count'); //更新分类内容数目
				$this->success( '删除完成' );
			}
			
		}
		
		protected function checkDelThumb( $file ){
			if ( !empty( $file ) ){
				$mini_file = str_replace( 'thumb_' , 'mini_', $file );
				@unlink ( __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH') . '/' . $file );
				@unlink ( __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH') . '/' . $mini_file );
			}
		}
		
		protected function checkDelAttach( $id, $fileStr ){
			$model = M('Attach');
			$list = $model->where("cid='".$id."'")->select();
			if ( !empty( $list ) ) {
				$_root = __ROOT_PATH__ . '/' . C('WEB_PUBLIC_PATH') . '/' . C('DIR_ATTCH_PATH');
				$IDs = array();
				foreach ($list as $key => $value) {
					$IDs[] = $value['id'];
					$_file = $_root . '/' . $value['folder'] . '/' . $value['name'];
					//若文件存在则删除
					if ( is_file( $_file ) ) @unlink( $_file ); 
				}
				$where['id'] = array( 'in', $IDs );
				$model->where($where)->delete(); //删除附件数据
			}
			//兼容老版本
			if ( !empty( $fileStr ) ){
				$root = __ROOT_PATH__;
				$file_array = explode( '|', $fileStr );
				if ( !empty( $file_array ) ){
					foreach ( $file_array as $key => $val ){
						@unlink( $root . $val );
					}
				}
			}

		}
		
		protected function _setPicType( $name )
		{
			return array( $name, 'fix_' . $name, 'resize_' . $name, 'thumb_' . $name, 'mini_' . $name );
		}

		protected function deleteFile($path){
			$text = '';
			if ( is_dir( $path ) ){
				$handle = opendir( $path );			
				while ( $list = readdir( $handle ) ){
					if ($list == '.' || $list == '..'){
						//do nothing
					}else{
						$list = $path.'/'.$list;
					}
					switch ($list){
						case $list == '.' || $list == '..':
							//echo $list.' this is  special directory ';
							continue;
						case is_file($list):
							if (unlink($list)){
								$text = $text.'<SPAN>delete file</SPAN> '.$list.'';
							}else {
								$text = $text. 'delete file failure';
							}
							break;
						case is_dir($list):
							$text = '<p>' . $text. 'open directory '.$list.'</p>';
							$this->deleteFile($list);
							break;
						default:
							//$text=$text.'default action '.$list.'';
							continue;
					}
				}
			}else{
				$text = $text. $path.' sorry the path is not directory';
			}
			return  $text;
		}

		protected function _setStatus($status,$id,$model=null){
			if ( $model == null ){
				$model = $this->getActionName();
			}
			$model = D($model);
			$map['id'] = $id;
			if ( $model->where( $map )->setField( 'status', $status ) ){
				$this->success('操作完成！');
			}else{
				$this->error('操作失败！');
			}
		}

		public function checkURLName(){
			$model = M('Archives');
			$value = $this->_post('value');
			if ( $value ){
				$dbpre = C('DB_PREFIX');
				$data = $model->table($dbpre."archives archives, ".$dbpre."category category")
					->field("archives.url_name, category.channel")
					->where("archives.url_name='".$value."' OR category.channel='".$value."'")
					->find();
				if ( !empty($data['url_name']) || !empty($data['channel']) ){
					$this->ajaxReturn('已存在！',0,0);
				}else{
					$this->ajaxReturn(1,1,1);
				}
			}
		}
		
	}