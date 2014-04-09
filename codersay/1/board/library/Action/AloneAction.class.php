<?php
	class AloneAction extends CommonAction{
		public function _before_index(){
			$this->model = M('Category');
			$list = $this->model->where( "type='alone' AND channel<>'flink' AND channel<>'guestbook'" )->select();
			$this->assign('list',$list);
		}
		public function add(){
			$this->getCategoryOption();
			$this->display();
		}
		public function insert(){
			$cmodel = D('Category');
			$cval['name'] = $this->_post('name');
			$cval['pid'] = $this->_post('pid');
			if ( !$cval['pid'] ){
				$cval['level'] = 1;
			}else{
				$level = $cmodel->find($cval['pid']);
				$cval['level'] = $level['level'] + 1;
			}
			$cval['type'] = 'alone';
			if ( !$cval['name'] ){
				$cval['name'] = $this->_post('title');
			}
			$cval['channel'] = $this->_post('channel');
			if ( !empty( $cval['channel'] ) ){
				if ( issetURLName( $cval['channel'] ) == false ){
					$cval['channel'] .= '_' . substr(strtoupper(md5(uniqid().md5(time()))),6,10);
				}
			}else{
				$cval['channel'] = uniqid();
			}
			$cval['status'] = 1;
			$cval['nav'] = 'nav';
			$cval['lang'] = 'zh-cn';
			if ( $insert = $cmodel->add( $cval ) ){
				$val['cid'] = $insert;
				$val['title'] = $this->_post('title');
				$val['content'] = stripslashes(trim($_POST['content']));
				$val['author'] = $_SESSION['AUTH']['id'];
				$val['is_comment'] = $this->_post('is_comment');
				$val['update_time'] = time();
				D('Alone')->add($val);
			}
			$this->success('添加完成！');
		}
	}