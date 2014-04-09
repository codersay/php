<?php
	class ArchiverAction extends CommonAction{
		public function _empty(){
			$url = $_GET['_URL_'];
			$_url = array();
			foreach ( $url as $key => $value ) {
				$_url[$key] = strtolower( trim( $value ) );
			}
			$year = $_url[1];
			if ( $_url[2] ){
				$month = $_url[2];
				$end_month = $_url[2];
			}else{
				$month = '01';
				$end_month = '12';
			}
			if ( $_url[3] ){
				$day = $_url[3];
				$end_day = $_url[3];
			}else{
				$day = '01';
				$end_day = date( 'd', mktime( 0, 0, 0, $month + 1, 0, $year ) );
			}
			if ( strlen( $month ) == 1 ){
				$month = '0' . $month;
			}
			if ( strlen( $end_month ) == 1 ){
				$end_month = '0' . $end_month;
			}
			$start_time = strtotime( $year . '-' . $month . '-' . $day . ' 00:00:00' );
			$end_time = strtotime( $year . '-' . $end_month . '-' . $end_day . ' 23:59:59' );
			
			$model = M( 'Archives' );
			$where = "create_time > '" . $start_time . "' AND create_time < '" . $end_time . "'";
			$count = $model->where($where)->count();
			import('ORG.Util.Page');
			$p = new Page( $count, C('LIST_VIEW_NUMBER') );
			$list = $model->where($where)->order('id DESC')->limit($p->firstRow . ',' . $p->listRows)->select();
			$this->assign('page',$p->show());
			$this->assign('list',$list);
			$this->display('Category:article');
		}
	}