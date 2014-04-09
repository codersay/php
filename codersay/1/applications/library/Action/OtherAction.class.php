<?php
	class OtherAction extends CommonAction{
		public function advinfo(){
			$id = $this->_get('id');
			if ( $id > 0 ){
				$where['id'] = $id;
				$model = D('Adv');
				$link = $model->where( $where )->getField('url');
				$model->where( $where )->setInc('count');
				@header("location:".$link);
			}else{
				$this->error('非法操作！');
			}
		}
	}