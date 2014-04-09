<?php
	class EmptyAction extends CommonAction{
		protected $item;
		public function index(){
			$this->_empty();
		}
		public function _empty(){
			//print_r($_GET);
			$classID = $_GET['catalog'];
			$levelid = isset($_GET['_URL_'][1])?$_GET['_URL_'][1]:null;
			$model = M('Archives');
			switch ($this->itemType) {
				case 'Category':
					switch ($this->category['type']) {
						case 'alone':
							$this->model = M('Alone');
							$where['cid'] = intval( $classID );
							$this->model->where( $where )->setInc('click');
							$alone = $this->model->where( $where )->find();
							$array = array();
							foreach( $this->category as $key => $val ){
								$array['cat_'.$key] = $val;
							}
							$this->assign( 'vo', array_merge( $alone, $array ) );
							break;
								
						default:
							$IDlist = $this->getCategoryIDlist( $classID );
							$where['status'] = 1;
							if ( $IDlist == 0 ){
								$where['cid'] = $classID;
							}else{
								$where['cid'] = array( 'in', $IDlist );
								//增加更多条件查询,自定义条件查询。	
								if(isset($levelid)) $where['levelid'] = $levelid;
							}
							import( 'ORG.Util.Page' );
							$count = $model->where( $where )->count();
			 				$p = new Page( $count, C('LIST_VIEW_NUMBER') );
							$list = $model
								->where( $where )
								->order('set_top DESC, recommend DESC, id DESC')
								->limit($p->firstRow.','.$p->listRows)
								->select();
								//echo $model->getLastSql();
							$this->assign('page',$p->show());
							$this->assign('list',$list);
							break;
					}
					break;

				case 'Views' :
					switch ($this->category['type']) {
						case 'picture':
							$this->model = M('Picture');
							import( 'ORG.Util.Page' );

							$where = array(
								'status' => 1,
								'cid' => $this->items['id']
							);
							import( 'ORG.Util.Page' );
							$count = $this->model->where($where)->count();
							$p = new Page( $count, C('LIST_PICTURE_NUMBER') );
							$list = $this->model->where($where)->limit($p->firstRow.','.$p->listRows)->select();
							$this->assign('page',$p->show());
							$this->assign('list',$list);
							break;
						
						default:
							$this->category['type'] = $this->items['type'];
							break;
					}
					$this->assign('vo',$this->items);
					break;
				
				default:
					# code...
					break;
			}
			$this->display($this->itemType.':'.$this->category['type']);
		}
	}
