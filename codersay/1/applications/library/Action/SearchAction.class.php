<?php
	 class SearchAction extends CommonAction
	 {
	 	public function _before_index()
	 	{
	 		$keys = $this->_get('keywords');
	 		if ( empty( $keys ) ){
	 			$this->error( '请输入搜索关键字！');
	 		}
	 		$sql = 'status=1';
	 		if ( strpos( $keys, ' ' ) == 0 ){
	 			$sql .= ' AND `title` like \'%' . $keys . '%\'';
	 		}else{
	 			$keys = preg_split('/[\n\r\t\s]+/i', $keys);
	 			$sql .= ' AND (';
	 			foreach( $keys as $val ){
	 				$sql .= ' `title` like \'%' . $val . '%\' OR';
	 			}
	 			$sql = trim( $sql, ' OR' );
	 			$sql .= ' )';
	 		}
	 		
	 		$model = M('Archives');
	 		
	 		$count = $model->where( $sql )->count();
	 		
	 		import( 'ORG.Util.Page' );
	 		$p = new Page( $count, C('LIST_VIEW_NUMBER') );
	 		$list = $model
	 			->where( $sql )
	 			->order( 'id DESC' )
	 			->limit( $p->firstRow . ',' . $p->listRows )
	 			->select();
	 		
	 		$this->assign( 'list', $list );
	 		$this->assign( 'page', $p->show() );
	 		
	 	}
	 }