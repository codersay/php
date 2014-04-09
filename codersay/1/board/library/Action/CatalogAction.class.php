<?php
	class CatalogAction extends CommonAction{
		public function _before_index(){
			//$img_path = C('TMPL_PARSE_STRING');
			$model = M('Category');
			$html = '';
			$data = $model->where("pid='0'")->order("sort")->select();
			$i = 1;
			foreach($data as $key=>$val){
				$trcolor = '';
				if ( ( $i % 2 ) == 0 ){
					$trcolor = ' bgcolor="#f9f9f9"';
				}else{
					$trcolor = ' bgcolor="#ffffff"';
				}
				
				if ($this->checkSonCategory($model, $val['id'])){
					$display = '<span class="cat_display" rel="' . $val['id'] . '"></span>';
				}else{
					$display = '<span class="cat_hidden" rel="' . $val['id'] . '"></span>';
				}
				
				$html .= '<tr rel="' . $val['id'] . '" class="rows_style"'.$trcolor.'>' . "\r\n" .
					'<td align="center" rel="'.$val['id'].'" class="esort">'.$val['sort'].'</td>'."\r\n" .
					'<td align="center">' . $val['id'] . '</td>' . "\r\n" .
					'<td align="center">' . $display . '</td>' . "\r\n" .
					'<td align="left"><span class="ename" rel="'.$val['id'].'">' . $val['name'] . '</span></td>' . "\r\n" . 
					'<td align="center">' . getParentCategory($val['pid']) . '</td>' . "\r\n" . 
					'<td align="center">' . $val['type'] . '</td>' . "\r\n" .
					'<td align="center" class="action_e">' . "\r\n";
					$html .= '<a href="'.U( 'edit?id='.$val['id'].'&pid='.$val['pid'].'&node='.$_GET['node'] ).'" class="edit_category">修改</a><span class="c_line">|</span>';
					$html .= '<a href="'.U('delete?id='.$val['id']).'" title="' . $val['name'] . ' 删除 " rel="' . $val['id'] . '" class="del_category">删除</a>' . "\r\n".
					'</td>' . "\r\n".
				'</tr>' . "\r\n";
				
				$html .= $this->getSonCategory($model, $val['id'], '├──');
				$i++;
			}
            
			$this->assign("list",$html);
		}

		public function add(){
			$this->catTypeOption();
			$this->getCategoryOption();
			$this->display();
		}

		public function _before_edit(){
			$this->catTypeOption( trim( $_GET['type'] ) );
			$this->getCategoryOption( '', intval( $_GET['pid'] ) );
		}

		protected function getSonCategory($model,$pid,$step){
			$data = $model->where("pid='".$pid."'")->select();
			$html = '';
			if (!empty($data)){
				$i = 1;
				foreach ($data as $key => $val) {
					$trcolor = '';
					if ( ( $i % 2 ) == 0 ){
						$trcolor = ' bgcolor="#f9f9f9"';
					}else{
						$trcolor = ' bgcolor="#ffffff"';
					}
					
					$display = '';
					
					$html .= '<tr rel="' . $val['id'] . '" class="tr_' . $val['pid'] . ' rows_style"'.$trcolor.'>' . "\r\n" .
						'<td align="center" rel="'.$val['id'].'" class="esort">'.$val['sort'].'</td>' . "\r\n" .
						'<td align="center">' . $val['id'] . '</td>' . "\r\n" .
						'<td align="center"></td>' . "\r\n" .
						'<td align="left">' . $step . ' ' . $display . ' <span class="ename" rel="'.$val['id'].'">' . $val['name'] . '</span></td>' . "\r\n" . 
						'<td align="center">' . getParentCategory($val['pid']) . '</td>' . "\r\n" . 
						'<td align="center">' . $val['type'] . '</td>' . "\r\n" .
						'<td align="center" class="action_e">' . "\r\n";
						$html .= '<a href="'.U( 'edit?id='.$val['id'].'&pid='.$val['pid'].'&type='.$val['type'] ).'" class="edit_category">修改</a><span class="c_line">|</span>';
						$html .= '<a href="'.U('delete?id='.$val['id']).'" title="' . $val['name'] . ' 删除 " rel="' . $val['id'] . '" class="del_category">删除</a>' . "\r\n".
						'</td>' . "\r\n".
					'</tr>' . "\r\n";
					
					$html .= $this->getSonCategory($model, $val['id'], '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$step);
					$i++;
				}
			}
			return $html;
		}
		
		protected function checkSonCategory($model,$pid){
			$data = $model->where("pid='".$pid."'")->select();
			if (!empty($data)){
				return $data;
			}else{
				return false;
			}
		}
		
		public function getCateOne(){
			$model = M('Category');
			$cat = $model->find( intval( $_GET['id'] ) );
			if ( !empty( $cat ) ){
				$this->ajaxReturn($cat,1,1);
			}else{
				$this->ajaxReturn(0,0,0);
			}
		}
		
		public function delete(){
			$this->model = D('Category');
			$where['id'] = intval( $_GET['id'] );
			$cate = $this->model->find($where['id']);
			if ( $cate['type'] == 'alone' ){
				D('Alone')->where("cid='".$where['id']."'")->delete();
			}
			if ( $this->model->where( $where )->delete() ){
				$this->success('删除完成！');
			}else{
				$this->error('删除失败！');
			}
		}
		
		public function update(){
			$_POST['channel'] = trim( $_POST['channel'] );
			if ( !empty( $_POST['channel'] ) ){
				if ( issetURLName( $_POST['channel'] ) == false ){
					$_POST['channel'] .= '_' . substr(strtoupper(md5(uniqid().md5(time()))),6,10);
				}
			}
			$model = D('Category');
			$whereID = intval( $_POST['id'] );
			if ( $_POST['pid'] == 0 ){
				if ( $list = $this->checkSonCategory( $model, $whereID ) ){
					foreach ( $list as $key => $value ) {
						$whereID .= ',' . $value['id'];
					}
				}
				$where = array(
					'id'	=> array( 'in', $whereID )
				);
				$update['channel'] = $_POST['channel'];
				$update['type'] = $_POST['type'];
				$model->where( $where )->save( $update );
			}
			if ( $_POST['level'] ){
				$_POST['level'] = intval( $_POST['level'] ) + 1;
			}
			$status = $model->where( "id='".intval( $_POST['id'] )."'" )->save( $_POST );
			if ( $status !== false ){
				if ( $_POST['type'] == 'alone' && !empty( $_POST['is_comment'] ) ){
					D('Alone')->where( "cid='".intval( $_POST['id'] )."'" )->setField( 'is_comment', $_POST['is_comment'] );
				}
				$this->success('修改成功！');
			}else{
				$this->error('修改失败！');
			}
		}
		
		public function insert(){
			// ALTER TABLE `ndlog_category` CHANGE `channel` `channel` VARCHAR(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL

			$model = D('Category');

			$_POST['name'] = trim( $_POST['name'] );
			if ( empty( $_POST['name'] ) ){
				$this->error('分类名称必须！');
			}
			if ( empty( $_POST['type'] ) ){
				$_POST['type'] = 'article';
			}
			$_POST['channel'] = trim( $_POST['channel'] );
			if ( !empty( $_POST['channel'] ) ){
				if ( issetURLName( $_POST['channel'] ) == false ){
					$_POST['channel'] .= '_' . substr(strtoupper(md5(uniqid().md5(time()))),6,10);
				}
			}

			if ( $_POST['pid'] > 0 ){
				$_POST['level'] = $model->where("id='".$_POST['pid']."'")->getField('level') + 1;
			}else{
				$_POST['level'] = 1;
			}
			if ( !isset( $_POST['status'] ) ){
				$_POST['status'] = 1;
			}
			if ( $insert = $model->add( $_POST ) ){
				if ( $_POST['type'] == 'alone' ){
					$alone['cid'] = $insert;
					D('Alone')->add( $alone );
				}
				$this->success('添加成功！');
			}else{
				$this->error('添加失败！');
			}
		}

		public function updateOneSort(){
        	$model = D('Category');
        	$id = trim( $_POST['id'] );
        	$sort = trim( $_POST['sort'] );
        	if ( !empty( $sort ) && is_numeric( $sort ) ){
        		$model->where("id='".$id."'")->setField('sort',$sort);
        	}
        }

        public function updateOneName(){
        	$model = D('Category');
        	$id = $this->_post('id');
        	$name = $this->_post('name');
        	if ( !empty( $name ) ){
        		$model->where("id='".$id."'")->setField('name',$name);
        	}
        }
		
	}
