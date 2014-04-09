<?php
	class FeedbackAction extends CommonAction{
		private function checkType(){
			$type = $this->_get('type');
			if ( !$type ){
				$type = 'Comment';
			}
			return $type;
		}
		public function index(){
			$type = $this->checkType();
			$this->model = M($type);
			import( 'ORG.Util.Page' );
			$where['pid'] = 0;
			$count = $this->model->where( $where )->count();
			$p = new Page( $count, C('LIST_BOARD_NUMBER') );
			$list = $this->model
				->where( $where )
				->order( 'id DESC' )
				->limit( $p->firstRow . ',' . $p->listRows )
				->select();
			$this->assign('type',$type);
			$this->assign('list',$list);
			$this->assign('model',$this->model);
			$this->assign('page',$p->show());
			$this->display($type);
		}

		public function reply(){
			$type = strtolower( trim( $_GET['type'] ) );
			$this->display( 'reply_' . $type );
		}

		public function actBatch(){
			$model = D( $_POST['type'] );
			$where['id'] = array( 'in', $_POST['ids'] );
			if ( isset( $_POST['Disable'] ) ){
				$status = $model->where($where)->setField('status',0);
			}elseif ( isset( $_POST['Delete'] ) ){
				$status = $model->where($where)->delete();
			}elseif ( isset( $_POST['Enabled'] ) ){
				$status = $model->where($where)->setField('status',1);
			}
			if ( $status && $_POST['Delete'] ){
				if ( $model == 'Comment' ){
					D('Archives')->where("id='".$_cid."'")->setDec('count',count( $_POST['ids'] ));
				}
				$this->success( '操作完成！' );
			}else{
				$this->error( '操作失败！' );
			}

		}

		public function insert(){
			$model = trim( $_POST['model'] );
			if ( $model == 'Guestbook' ){
				unset( $_POST['model'] );
				$_POST['username'] = $_SESSION['AUTH']['nickname'];
				$_POST['email'] = $_SESSION['AUTH']['email'];
				$_POST['content'] = stripslashes( $_POST['content'] );
				$_POST['ipaddress'] = $_SERVER['REMOTE_ADDR'];
				$_POST['create_time'] = time();
			}
			//dump($_POST);exit();
			if ( D($model)->add( $_POST ) ){
                $this->success ('操作成功!');
            }else{
                $this->error ('操作失败!');
            }
		}

		public function delete(){
			$model = $this->_get('type');
			$_model = D($model);
			$where['id'] = $this->_get('id');
			if ( $model == 'Comment' || $model == 'Guestbook' ){
				$where['pid'] = $this->_get('id');
				$where['_logic'] = 'OR';
			}
			if ( $_model->where( $where )->delete() ){
				$_cid = $this->_get('cid');
				if ( $_cid ){
					if ( $model == 'Comment' ){
						D('Archives')->where("id='".$_cid."'")->setDec('count');
					}
				}
				$this->success( '删除完成！' );
			}else{
				$this->error('删除失败！');
			}
		}

	}