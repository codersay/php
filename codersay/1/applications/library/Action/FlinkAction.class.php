<?php
	class FlinkAction extends CommonAction{
		public function _before_index(){
			$this->model = M('CatFlink');
			$list = $this->model->where("status=1")->order('sort')->select();
			$flink = M('Flink')->where("status=1")->order('sort')->select();
			foreach ( $list as $k => $v ){
				foreach ( $flink as $key => $val ){
					if ( $val['cid'] == $v['id'] ) $list[$k]['list'][] = $val;
				}
			}
			$this->assign('list',$list);
		}
		
	}