<?php
	class IndexAction extends CommonAction {
		public function _before_index(){
			//文章列表
			$this->getArchives();
		}
		
		private function getArchives(){
			$model = M('Archives');
			$where = array(
				'status'	=> 1,
				'type'		=> array( 'neq', 'picture' )
			);
			import( 'ORG.Util.Page' );
			$total = $model->where( $where )->count();
			
			$p = new Page($total,C('LIST_VIEW_NUMBER'));
			$list = $model
				->where( $where )
				->order('set_top DESC, recommend DESC, id DESC')
				->limit($p->firstRow . ',' . $p->listRows)
				->select();
			$this->assign('i_model',$model);
			$this->assign('list',$list);
			$this->assign('page',$p->show());
		}

	}