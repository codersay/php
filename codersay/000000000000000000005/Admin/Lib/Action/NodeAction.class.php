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
// $Id$
class NodeAction extends CommonAction {
	public function index(){
		$listsarr=$this->getpagelists($this->getActionName());
		$lists=$listsarr['lists'];
		foreach ($lists as $k => $v) {
			$lists[$k]['class']= M('Node')->where(array('id' =>$v['pid']))->getField('title');
		}	
		$this->assign('page', $listsarr['page']);
        $this->assign('Nodelist', $lists);
        $this->display();
	   }
	public function add(){
			$this->addata('Node');
		}
	public function insert(){
		$nodelist=M('Node')->field('id,title')->select();
		$this->assign("nodelist", $nodelist);
		$this->display();
	}
	public function edit() {
               
			 if(!$_GET['id']) $this->error("编辑项不存在或已删除!");	
			    $Node = M('Node');  		                 
				$this->assign('vo', $Node->getById($_GET['id'])); 
				$this->assign("nodelist", $Node->field('id,title')->select());   
                $this->display();     
                     	  
             }                
 
    public function update() {				
			$this->getupdate();
       }
	public function act(){
		$this->action();
	}
	public function setaccess(){
		if(!$_GET['role_id']) $this->error("该角色不存在或已被删除!");
	    //$role_id =$_GET['role_id'];
		$node_ids = M('Access')->where(array('role_id'=>$_GET['role_id']))->getField('node_id',true);
		$Nodelist = M('Node')->order('id desc')->select(); 	
		foreach ($Nodelist as $key => $value) {
			$Nodelist[$key]['checked']=in_array($value['id'],$node_ids) ? 1 :0;
			}	
        $this->assign('Nodelist', $Nodelist);
		$this->assign('role_id', $_GET['role_id']);
       $this->display();
    }
	public function saveaccess(){ 
	      if(!$_POST['role_id']) $this->error("该角色不存在或已被删除!");
	      $role_id = $_POST['role_id']; 
		  $node_ids = $_POST['id']; 
		   //echo  $role_id;
		   //print_r($node_id);
		   $Access=M('Access');
		  // $condition['role_id']=$role_id;
		   $delets=$Access->where(array('role_id'=>$role_id))->delete(); //$delets是返回被删除的记录数
	
	      foreach($node_ids as $v){
				$data['role_id'] = $role_id;
				$data['node_id'] = $v;
				$vo = M('Node')->getById($v);
				$data['pid']=$vo['pid'];
				$data['level']=$vo['level'];
				$result[]=$Access->add($data);
			}
			$this->message($result);
			
    }  
}
?>