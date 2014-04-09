<?php
	class GetanyfreeAction extends CommonAction{
		public function defaults(){
			$get = array();
			foreach( $_GET as $key => $val ){
				$get[$key] = trim( $val );
			}

			$where = array();
			$where['status'] = 1;
			if ( $get['summary']  == 1 ){
				$where['summary'] = array( 'neq', '' );
			}
			if ( $get['thumb'] == 1 ){
				$where['thumb'] = array( 'neq', '' );
			}

			if ( !empty( $get['model'] ) ){
				$model = M( $get['model'] );
				$list = $model->where( $where )->order( $get['orderby'] . ' ' . $get['order'] )->limit( $get['qty'] )->select();
			}

			if ( !$get['title_len'] ){
				$get['title_len'] = 30;
			}

			switch ( $get['style'] ) {
				case 'js':
					$js = '<ul>';
					foreach ($list as $k => $value) {
						$js .= '<li><cite>'.toDate($value['create_time'],C('DEFAULT_DATE_FORMAT')).'</cite><a href="'.U('/views/'.$value['id']).'">'.ndsubstr($value['title'],$get['title_len']).'</a></li>';
					}
					$js .= '</ul>';
					echo 'document.write(\''.$js.'\');';
					break;
				
				case 'json':
					echo 'var json_result = ' . json_encode( $list );
					break;
			}
		}
	}