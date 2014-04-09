<?php
	class FlinkAction extends CommonAction{
		public function index(){
			$type = $this->_get('type');
			if ( !$type ){
				$type = 'links';
			}
			switch ($type) {
				case 'links':
					$model = 'Flink';
					break;
				case 'category':
					$model = 'CatFlink';
					break;
			}
			$this->model = M($model);
			import( 'ORG.Util.Page' );
			$count = $this->model->count();
			$p = new Page( $count, C('LIST_BOARD_NUMBER') );
			$list = $this->model
				->where( $where )
				->order( 'sort ASC, id DESC' )
				->limit( $p->firstRow . ',' . $p->listRows )
				->select();
			$this->assign('type',$type);
			$this->assign('list',$list);
			$this->assign('page',$p->show());
			$this->display($type);
		}
		public function add(){
			$type = $this->_get('type');
			if ( !$type ){
				$type = 'links';
			}
			$this->getlinkCategory();
			$this->assign('type',$type);
			$this->display('add_'.$type);
		}
		public function insert(){
			$type = $this->_post('type');
			$status = false;
			switch ($type) {
				case 'category':
					$model = D('CatFlink');
					$val['name'] = $this->_post('name');
					$val['status'] = $_POST['status'];
					if ( $model->add($val) ) $status = true;
					break;
				case 'links' :
					$model = D('Flink');
					$val['name'] = $this->_post('name');
					$val['cid'] = $this->_post('cid');
					$val['status'] = $this->_post('status');
					$val['url'] = $this->_post('url');
					$val['logo'] = $this->_post('logo');
					$val['info'] = $this->_post('info');
					if ( $insert = $model->add($val) ) {
						D('CatFlink')->where("id='".$this->_post('cid')."'")->setInc('count');
						$status = true;
					}
					break;
			}
			if ( $status ){
				$this->success('添加成功！');
			}else{
				$this->success('添加失败！');
			}
		}
		public function edit(){
			$type = $this->_get('type');
			if ( !$type ){
				$type = 'links';
			}
			switch ($type) {
				case 'links':
					$model = 'Flink';
					break;
				case 'category':
					$model = 'CatFlink';
					break;
			}
			$this->model = M($model);
			$data = $this->model->find($this->_get('id'));
			$this->getlinkCategory();
			$this->assign('type',$type);
			$this->assign('vo',$data);
			$this->display('edit_'.$type);
		}
		public function delete(){
			$type = $this->_get('type');
			if ( !$type ){
				$type = 'links';
			}
			switch ($type) {
				case 'links':
					$model = 'Flink';
					break;
				case 'category':
					$model = 'CatFlink';
					break;
			}
			if ( D($model)->delete($this->_get('id')) ){
				if ( $type == 'links' ){
					D('CatFlink')->where("id='".$this->_get('cid')."'")->setDec('count');
				}
				$this->success('删除完成！');
			}else{
				$this->error('删除失败！');
			}
		}
		public function forbid(){
			$this->_setStatus( 0, $this->_get('id'), 'Flink' );
		}
		
		public function resume(){
			$this->_setStatus( 1, $this->_get('id'), 'Flink' );
		}
		public function updateOneSort(){
        	$model = D( $this->_post('model') );
        	$id = $this->_post('id');
        	$sort = $this->_post('sort');
        	if ( $sort != '' && is_numeric( $sort ) ){
        		$model->where("id='".$id."'")->setField('sort',$sort);
        	}
        }
		private function getlinkCategory(){
			$this->model = M('CatFlink');
			$list = $this->model->where("status=1")->select();
			$this->assign('list',$list);
		}

	}