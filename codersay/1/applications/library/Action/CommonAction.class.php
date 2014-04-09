<?php
	class CommonAction extends Action{
		
		protected static $model = null; //数据模型model
		protected $theme;
		protected $items;
		protected $itemType;
		protected $title;
		protected $catLevel;
		protected $category;
		protected $catCache;
		protected $channel;
		public $lang = 'zh-cn';
		public $sessionID;
		public $userID;
		public $userInfo;
		
		public function _initialize(){
			@header("Content-type: text/html; charset=utf-8");

			//加载模板插件
			templatePlugin();
			
			//get Navigation
			$this->catCache = $nav_data = $this->getNavigation();		
			$url_name = $_GET['_URL_'][0];
			$utype = '';
			$is_category = false;
			if ( strtolower( $url_name ) == 'views' ){
				$where['id'] = intval( $_GET['_URL_'][1] );
			}elseif( strtolower( $url_name ) == 'category' ){
				foreach ($nav_data as $key => $value) {
					if ( $value['id'] == intval( $_GET['_URL_'][1] ) ){
						$is_category = true;
						$utype = 'Category';
						$this->category = $value;
					}
				}
				unset( $key, $value );
			}else{
				foreach( $nav_data as $key => $value ){
					if ( $value['channel'] == $url_name ) {
						$is_category = true;
						$utype = 'Category';
						$this->category = $value;
					}
				}
				unset( $key, $value );
				$where['url_name'] = trim( $url_name );
			}

			if ( !$is_category ){
				if ( strtolower( MODULE_NAME ) != 'index' ){
					$model = M('Archives');
					$item = $model->where( $where )->find();
					if ( !empty( $item ) ){
						$model->where( $where )->setInc('click');
						$utype = 'Views';
						$this->items = $item;
						$currentID = $this->items['cid'];
					}else{
						$utype = $url_name;
					}
				}
			}else{
				$currentID = $this->category['id'];
			}
 
			$_GET['catalog'] = $currentID; //当前分类ID
			foreach ($nav_data as $key => $value) {
				if ( $value['id'] == $currentID ) $this->category = $value;
			}
			if ( !empty( $this->category ) ){
				$this->assign( 'class', $this->category );
			}

			$this->assign( 'ROOTID', $this->getRootID( $nav_data, $currentID ) ); //获取根ID并赋予模板
			$position = '<a href="/">Home</a>';
			if ( strtolower( MODULE_NAME ) != 'index' ){
				$position .= $this->getParent( $nav_data, $currentID );
			}
			if ( strtolower( MODULE_NAME ) == 'tags' ){
				$position .= 'tags<em>&raquo;</em>' . ACTION_NAME;
			}
			$this->assign( 'position', '' . $position );

			$this->itemType = $utype;

			$this->setTplPlugin('sidebar');
			$this->setTplPlugin('topbar');
			$this->setTplPlugin('bottom');
			$this->setTplPlugin('navigation');
			$this->setTplPlugin('other');

		}
		
		public function index(){
			$this->display();
		}


		
		//面包屑递归函数
		private function getParent($m,$pid){
			$position = '';
			$d = '';
			foreach ( $m as $key => $val ){
				if ( $val['id'] == $pid ) $d = $val;
			}
			if($d['pid'] != 0){//
				$position .= $this->getParent($m,$d['pid']);
				$position .= "<em>&raquo;</em><a href='".URL($d['id'],$d['channel'],'category')."'>".$d['name']."</a>";
			}else{
				$position .= "<em>&raquo;</em><a href='".URL($d['id'],$d['channel'],'category')."'>".$d['name']."</a>";
			}
			return $position;
		}
		
		/**
		 +====================================
		 * 获得根分类ID 
		 * @access private
		 * @param model $model
		 * @param int $pid 父级ID
		 * @return int 根分类ID
		 +====================================
		 */
		private function getRootID($category,$pid){
			foreach ($category as $key => $value) {
				if ( $value['id'] == $pid ){
					if ( $value['pid'] == 0 ){
						$pid = $value['id'];
					}else{
						$pid = $this->getRootID($category, $value['pid']);
					}
				}
			}
			return $pid;
		}
		
		
		private function getNavigation(){
			$list = S('CategoryList');
			if ( !$list ){
				$this->Model = M('Category');
				$where = array(
						'status'		=> 1
				);
				$list = $this->Model->where($where)->order('sort')->select();
				S('CategoryList',$list);
			}
			$this->assign('category',$list);
			return $list;
		}

		/**
		 +====================================
		 * 获得当前分类相关所有分类ID 
		 * @access public
		 * @return string 分类ID组合(1,20,17,112)
		 +====================================
		 */
		protected function getCategoryIDlist( $id ){
			$model = M('Category');
			$nodeName = $id;
			$checkSon = $model->where("pid='".$nodeName."'")->select();
			if (empty($checkSon)){
				return 0;
			}else{
				$listID = $model->where("pid='".$nodeName."'")->field('id,pid')->select();
				foreach ($listID as $key => $val) {
					$nodeName .= ','.$val['id'];
					$nodeName .= $this->checkNodeSon($model, $val['id']);
				}
				return $nodeName;
			}
			
		}
		
		/**
		 +====================================
		 * 递归检查当前分类相关分类ID
		 * @access private
		 * @return string 分类ID组合(1,20,17,112)
		 +====================================
		 */
		private function checkNodeSon($model,$pid){
			$nodeName = '';
			$list = $model->where("pid='".$pid."'")->field('id,pid')->select();
			if (!empty($list)){
				foreach ($list as $key => $val) {
					$nodeName .= ','.$val['id'];
					$nodeName .= $this->checkNodeSon($model, $val['id']);
				}
			}
			return $nodeName;
		}
		
		private function setTplPlugin( $position ){
			$list = checkPluginCache();
			$array = array();
			foreach ($list as $key => $value) {
				if ( $value['position'] == $position && $value['status'] == 1 ) $array[] = $value;
			}
			$this->assign($position,$array);
		}
		
	}
