<?php
	class TagsAction extends CommonAction{
		public function _empty(){
			if ( isset( $_GET['catalog'] ) ) unset( $_GET['catalog'] );
			if ( isset( $_GET['type'] ) ) unset( $_GET['type'] );
			$tag = urldecode( ACTION_NAME );
			$this->model = M('Archives');
			$where = array(
				'status' 	=> 1,
				'tags'		=> array( 'like', '%'.$tag.'%' ),
			);
			$total = $this->model->where($where)->count();
			$p = new Page($total,C('LIST_VIEW_NUMBER'));
			$list = $this->model->where($where)->order('id DESC')->limit($p->firstRow.','.$p->listRows)->select();
				
			$this->assign('list',$list);
			$this->assign('page',$p->show());
			$this->display("Category:".strtolower( MODULE_NAME ));
		}
	}