<?php
	class CommentAction extends CommonAction{
		
		public function index(){
			
			$model = M('Comment');
			$where = array(
				'cid'	=> intval( $_GET['comment'] ),
				'pid'	=> 0,
				'type'	=> $_GET['fst'],
				'status'=> 1
			);
			import("ORG.Util.PageAjax");
			$count = $model->where( $where )->count();
			$p = new PageAjax($count,C('COMMENT_LIST_COUNT'));
			$p->ajaxFunc = 'getComment';
			$list = $model->where( $where )->order("id DESC")->limit($p->firstRow.','.$p->listRows)->select();
			$comment_array = array();
			foreach($list as $key => $val){
				$son_list = $model->where("pid='".$val['id']."'")->order("id DESC")->select();
				$son_array = array();
				if (!empty($son_list)){
					foreach ($son_list AS $keys=>$vals){
						$son_array[$keys] = array(
							'id' => $vals['id'],
							'cid' => $vals['cid'],
							'username' => $vals['username'],
							'email' => md5($vals['email']),
							'msg' => $vals['msg'],
							'dtime' => toDate($vals['dtime'],"Y-m-d H:i:s"),
						);
					}
				}
				$comment_array[$key] = array(
					'id' => $val['id'],
					'cid' => $val['cid'],
					'username' => $val['username'],
					'email' => md5($val['email']),
					'msg' => $val['msg'],
					'dtime' => toDate($val['dtime'],"Y-m-d H:i:s"),
					'sondata' => $son_array,
				);
			}
			
			$page = $p->show();
			if ( !empty($comment_array) ){
				$this->ajaxReturn($comment_array,$page,1);
			}else{
				$this->ajaxReturn('暂无评论',0,0);
			}
			
		}

		public function insert(){
            $comment = D("Comment");
            $data = $_POST;
            $data['username'] = trim($data['username']);
            $data['verify'] = trim($data['verify']);

            $_cid['id'] = $_POST['cid'];
            $is_comment = 3;
        	if ( $data['type'] == 'alone' ){
        		$_model = D('Alone');
        		$is_comment = $_model->where( $_cid )->getField('is_comment');
        	}else{
        		$_model = D('Archives');
        	}
	        
            if($is_comment == 1){
            	$this->ajaxReturn(0,'此页面不允许评论！',0);
            }else{
            	if ( C('COMMENT_USER_NAME') == 1 ){
	            	if ( empty($data['username']) ){
	            		$this->ajaxReturn(0,'用户名不能为空!',0);
	            	}
		            if(checkSafe($data['username']) == false) {
		            	$this->ajaxReturn(0,'用户名非法！',0);
		            }
		        }
		        if ( C('COMMENT_USER_EMAIL') == 1 ){
		        	if ( empty( $data['email'] ) ){
		        		$this->ajaxReturn(0,'Email 不能为空!',0);
		        	}
		            if(checkEmail($data['email']) == false){
						$this->ajaxReturn(0,'Email Error!',0);
		            }
		        }
		        if ( C('COMMENT_VERIFY') == 1 ){
		            if (md5($data['verify']) != $_SESSION['verify']){
		                $this->ajaxReturn(0,'验证码错误！',0);
		            }
		        }

                $data['ip'] = get_client_ip();
                $data['dtime'] = time();
                $data['msg'] = trim($data['msg']);
                if ( strlen( trim( $data['msg'] ) ) < C('COMMENT_TEXT_LENGTH') ){
                	$this->ajaxReturn(0,'评论内容必须大于' . C('COMMENT_TEXT_LENGTH') . '个字符',0);
                }
                if ( C('COMMENT_TEXT_SENSITIVE') ){
                	$macth = preg_replace("/[\s]{2,}/", "|", C('COMMENT_TEXT_SENSITIVE') );
                	$search = explode( "|", $macth );
                	$data['msg'] = str_replace( $search, "", $data['msg'] );
                }
                $data['msg'] = nl2br(htmlspecialchars($data['msg'],ENT_NOQUOTES));
                unset( $data['verify'] );
                if ( C('COMMENT_EXAMINATION') == 0 ){
                	$data['status'] = 1;
                }else{
                	$data['status'] = 0;
                }
                if ( $status = $comment->add($data) ){
                	$_model->where( $_cid )->setInc('count');
                	$this->ajaxReturn($status,'评论成功！',1);
                }else{
                	$this->ajaxReturn(0,0,0);
                }
            }
			//$referer = $_SERVER['HTTP_REFERER'];
		}
		
		public function reply(){
			$data = $_POST;
			$mod = D("Comment");
			$data['username'] = trim($data['username']);
            $data['verify'] = trim($data['verify']);
            if ( C('COMMENT_USER_NAME') == 1 ){
            	if ( empty($data['username']) ){
            		$this->ajaxReturn(0,'用户名不能为空!',0);
            	}
            	if ( checkSafe($data['username']) == false ){
            		$this->ajaxReturn(0,'用户名非法',0);
            	}
            }
            if ( C('COMMENT_USER_EMAIL') == 1 ){
            	if ( empty( $data['email'] ) ){
	        		$this->ajaxReturn(0,'Email 不能为空!',0);
	        	}
	            if(checkEmail($data['email']) == false){
					$this->ajaxReturn(0,'Email Error!',0);
	            }
	        }
            if ( C('COMMENT_VERIFY') == 1 ){
	            if (md5($data['verify']) != $_SESSION['verify']){
	                $this->ajaxReturn(0,'验证码错误',0);
	            }
	        }

            $data['ip'] = get_client_ip();
            $data['dtime'] = time();
            $data['msg'] = trim($data['msg']);
            if ( C('COMMENT_TEXT_SENSITIVE') ){
            	$macth = preg_replace("/[\s]{2,}/", "|", C('COMMENT_TEXT_SENSITIVE') );
            	$search = explode( "|", $macth );
            	$data['msg'] = str_replace( $search, "", $data['msg'] );
            }
            $data['msg'] = nl2br(htmlspecialchars($data['msg']));
            unset( $data['verify'] );
            if ( C('COMMENT_EXAMINATION') == 0 ){
            	$data['status'] = 1;
            }else{
            	$data['status'] = 0;
            }
            $returndata = $mod->add($data);
            $this->ajaxReturn($returndata,'回复成功！',1);
		}
		
		// 验证码显示
	    public function verify(){
	    	if ( C('COMMENT_VERIFY') == 1 ){
	    		import("ORG.Util.Image");
	        	if ( C('COMMENT_VERIFY_ADV') == 1 ){
	        		Image::GBVerify(); // 中文验证码
	        	}else{
	        		Image::buildImageVerify(4);
	        	}
	    	}
	    }
	}
