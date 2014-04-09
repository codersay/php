<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// @function 公共控制器
class CommonAction extends Action {
	function _initialize() {
		// 用户权限检查
		if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
			import('ORG.Util.RBAC');
			if (!RBAC :: AccessDecision()) {
				//检查认证识别号
				if (!$_SESSION[C('USER_AUTH_KEY')]) {
					//跳转到认证网关
					redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
				}
				// 没有权限 抛出错误
				if (C('RBAC_ERROR_PAGE')) {
					// 定义权限错误页面
					redirect(C('RBAC_ERROR_PAGE'));
				} else {
					if (C('GUEST_AUTH_ON')) {
						$this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
					}
					// 提示错误信息
					$this->error(L('_VALID_ACCESS_'));
				}
			}
		}
	}
	public function lists() {
		$Modulename = $this->getActionName();
		$modleid = $this->getmodleid($Modulename);//获取模型ID		
		if (isset ($_POST['catid']) && !empty ($_POST['catid'])) {
			$where['catid'] = intval($_POST['catid']);	
			$lists=M($Modulename)->where($where)->select();					
		} else {
            $where='';
			$listsarr=$this->getpagelists($Modulename,$where);
			$lists=$listsarr['lists'];
		}		
		$lists = ($recordnum = $this->recordnum($lists, $Modulename)) ? $recordnum : $lists;//附加字段
		if(in_array($Modulename,array('News','Blog','Download'))){
			$this->assign("catid", intval($_POST['catid']));
			$this->assign("catlist", D('Columns')->Catlist($Modulename, $modleid));
		}
		$this->assign('page', $listsarr['page']);
		$this->assign('tpl', $tpl = 'index');//模板标识，用于判断是什么类型的模板以加载相应的JS和CSS
		$this->assign('lists', $lists);
	}
	public function getpagelists($Modulename,$where='',$order='ord asc,id desc',$pagesize=12) {
		$M = M($Modulename);
		import("ORG.Util.Page");
		$count = $M->where($where)->count(); //计算总数
		$p = new Page($count, $pagesize);
		$lists = $M->where($where)->limit($p->firstRow . ',' . $p->listRows)->order($order)->select();
		$p->setConfig('header', '条');
		$p->setConfig('prev', "<");
		$p->setConfig('next', '>');
		$p->setConfig('first', '<<');
		$p->setConfig('last', '>>');
		return array('lists'=>$lists,'page'=>$p->show());
		}
	public function recordnum($lists, $Modulename) {
		
		if ($lists !== false) {
			
			if ($Modulename == 'News') {
				foreach ($lists as $k => $v) {
					$lists[$k]['total'] = M('Comment')->where(array('nid'=>$v['id']))->count();
					$lists[$k]['picnum'] = M('Attach')->where(array('recordId'=> $v['id'],'module'=>$Modulename))->count();
				 }
			}elseif($Modulename == 'Blog'){
				 foreach ($lists as $k => $v) {
					$lists[$k]['total'] = M('Comment')->where(array('bid'=>$v['id']))->count();
				 }
			}else{
				foreach ($lists as $k => $v) {	
				  $lists[$k]['total'] = M('Attach')->where(array('recordId'=> $v['id'],'module'=>$Modulename))->count();
				}
			}
			return $lists;
		}
	}
		
	public function getmodleid($Modulename) {
		$Marray = array (
			1 => 'News',
			2 => 'Blog',
			3 => 'Download',
		);
		$modleid = (int) implode(',', array_keys($Marray, $Modulename));
		return $modleid;
	}
	public function getModulename() {
		$Modulename = $this->getActionName();
		if ($Modulename == '') $this->error('the Modulename is no existence!');	
		return $Modulename;
	}
	public function _trigger($vo, $list) {
        D('Tagged')->saveTag($vo, $list, $this->getActionName());
    }
	public function addata($module) {
		if(!$this->isPost()) {
			$this->error('非法请求');
			}
		$D = D($module);
		$vo = $D->create();
		if (!$vo) $this->error($D->getError());
			$list = $D->add();
			if ($list) {
				//数据保存触发器
				if(in_array($module, array('News','Blog'))){
				if (method_exists($this, '_trigger')) {
					$this->_trigger($vo, $list); //$list成功添加数据后，返回的是该记录的ID
				}
				}
				$this->success("添加成功", "__GROUP__/" . $module . "/index/");
			} else {
				$this->error('添加失败');
			}
	}
	
	 public function getinsert(){
		      $Modulename=$this->getActionName();
			  $modleid = $this->getmodleid($Modulename);
		      $this->assign('catlist', D('Columns')->Catlist($Modulename,$modleid));		
		      }
	
	public function getedit() {
             if (empty($_GET['id'])) $this->error('编辑项不存在！');
				$Modulename=$this->getActionName();
                $vo = M($Modulename)->where(array('id'=>trim($_GET['id'])))->find();
                if ($vo) {
				  if(in_array($Modulename,array('News','Blog','Download'))){
				   $modleid = $this->getmodleid($Modulename);
		           $this->assign('catlist', D('Columns')->Catlist($Modulename,$modleid));
				   $vo['content']=str_ireplace('&','&amp;',$vo['content']);
				  }
				  
                   $this->assign('vo', $vo);
                  
                  } else {
                    $this->error();
                  }
           
            }
	 //更新    
	public function getupdate() {
		if(!$this->isPost()) {
			$this->error('非法请求');
			}
		$Modulename = $this->getActionName();
		$D = D($Modulename);
		$vo=$D->create();
		if (false === $vo) {
			$this->error($D->getError());
		}
		if(in_array($Modulename, array ('News','Blog'))){
		  D('Tagged')->updateTag($vo,$Modulename);
		}
		$result = $D->save();
		$this->message($result);
		
	}
		
	public function action() {
		$getid = $_REQUEST['id'];
		$action = trim($_GET['action']);
		$catid = isset($_REQUEST['catid']) ? trim($_REQUEST['catid']) :0;
		$ids = $_REQUEST['ids'];
		$ord= $_REQUEST['ord'];
		$M = $this->getActionName();
		$getids = implode(',', $getid);
		$id = is_array($getid) ? $getids : $getid;
		$map['id'] = array ('in',$id);
			
		if ((!$id)&&($action !=='order')) {
			$this->error('请勾选记录');
		}
		
		switch($action){
                case 'delete':
				        $this->del($M,$getid);
                        break;
                case 'move':
				        $this->move($M,$getid,$catid);
                        break;
				case 'check':
				        $this->check($M,$getid);
                        break;
				case 'posid':
				        $this->posid($M,$getid);
                        break;
				case 'order':
				        $this->order($M,$ids,$ord);
                        break;
                default:$this->error('未知操作');                                       
          }		
	}
	//消息提示
	public function message($result,$smessage='操作成功',$emessage='操作失误'){
		   if (false !== $result) {
				$this->success($smessage);
			} else {
				$this->error($emessage);
			}
		}
	//删除缩略图2013.2.26
	public function delthumb($thumb) {
		if ($thumb !== false) {
		$thumbfile='Public'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.'Thumb'.DIRECTORY_SEPARATOR.'wb_'.$thumb;		
		  if(is_file($thumbfile)){
		    unlink($thumbfile);
			}                   										
		}
	}

	//排序
	function order($M,$ids,$ord) {		
		$Module = D($M);
		foreach ($ids as $k => $v) {
			$id = $ids[$k];
			$data['ord'] = $ord[$k];
			if($M =='Columns'){
				$condition['colId'] = $id;
				}else{
				$condition['id'] = $id;
				}
			$result[] = $Module->where($condition)->save($data);
		}
		$this->message($result);		
	}
	
	//移动文章
	function move($M,$getid,$catid){
		$result=M($M)->where(array('id'=>array('in',$getid)))->save(array('catid'=>$catid));
		$this->message($result);
		}
	//推荐文章
	function posid($M,$getid){
		$result=M($M)->where(array('id'=>array ('in',$getid)))->save(array('posid'=>1)); 
		$this->message($result,'推荐成功');
		
		}
	//审核文章
	function check($M,$getid){
		$result=M($M)->where(array('id'=>array ('in',$getid)))->save(array('status'=>1)); 
		$this->message($result);
		
		}
	//删除文章以与其相关的缩略图、标签、评论、回复
	function del($M,$getid){
		$Module=M($M);
		$result = array ();
			foreach ($getid as $v) {
			  if(in_array($M,array('News','Blog','Download'))){
				$thumb = $Module->where(array('id' =>$v))->getField('thumb');
				$this->delthumb($thumb);//删除缩略图
			  }		
			  if(in_array($M,array('Download','News','Page'))){
				D('Attach')->delfile($M,$v);//删除附件，包括图片和文件
			  }							
			  if(in_array($M, array ('News','Blog'))){
				D('Tagged')->deltag($v);//删除标签	
				 D('Comment')->delct($M,$v);//删除评及回复
			  }				             
				
			  $result[] = $Module->delete($v);
			}
			$this->message($result);
		}
}
?>