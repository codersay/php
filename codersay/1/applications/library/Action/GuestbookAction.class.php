<?php
	class GuestbookAction extends CommonAction{
		public function _before_index(){
			$this->model = M('Guestbook');
			import( 'ORG.Util.Page' );
			$where['pid'] = 0;
			$total = $this->model->where($where)->count();
			$p = new Page( $total, C('LIST_VIEW_NUMBER') );
			$list = $this->model->where($where)->order('id DESC')->limit($p->firstRow.','.$p->listRows)->select();
			
			$this->assign('page',$p->show());
			$this->assign('model',$this->model);
			$this->assign('list',$list);
		}
		
		public function insert(){
			$_POST['username'] = h( trim( $_POST['username'] ) );
			$_POST['email'] = trim( $_POST['email'] );
			$_POST['verify'] = trim( $_POST['verify'] );
			$_POST['content'] = trim( $_POST['content'] );
			$_POST['ipaddress'] = get_client_ip();
			$_POST['create_time'] = time();
			
			if ( empty( $_POST['username'] ) ) {
				$this->ajaxReturn( '用户名必须填写！', '#username', 0 );
			}elseif ( empty( $_POST['email'] ) ) {
				$this->ajaxReturn( '邮箱不能为空！', '#email', 0 );
			}elseif ( checkEmail( $_POST['email'] ) == false ) {
				$this->ajaxReturn( '邮箱地址错误！', '#email', 0 );
			}elseif ( empty( $_POST['content'] ) ) {
				$this->ajaxReturn( '留言内容不能为空！', '#bookcontent', 0 );
			}elseif ( md5( $_POST['verify'] ) != $_SESSION['verify'] ) {
				$this->ajaxReturn( '验证码错误！', '#verify', 0 );
			}else{
				$_POST['status'] = 1;
				$_POST['content'] = stripslashes( $_POST['content'] );
				if ( D('Guestbook')->add( $_POST ) ){
					$this->ajaxReturn( U('/guestbook'), 1, 1 );
				}else{
					$this->ajaxReturn( '留言失败！', 0, 0 );
				}
			}
		}

		public function verify(){
	    	import("ORG.Util.Image");
	        Image::buildImageVerify(4,5,'png',60,28);
	    }
		
	}
