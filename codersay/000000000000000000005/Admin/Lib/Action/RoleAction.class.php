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
class RoleAction extends CommonAction {
    
	 public function index(){
        $this->lists();
        $this->display();
		
	   }
	 public function setrole(){
		if(!$_GET['user_id']) $this->error("该用户不存在或已被删除!");
		$role_ids= M('Role_user')->where(array('user_id'=>$_GET['user_id']))->getField('role_id',true);
		$Rolelist = M('Role')->order('id desc')->select(); 	
		foreach ($Rolelist as $key => $value) {
			$Rolelist[$key]['checked']=in_array($value['id'],$role_ids) ? 1 :0;
			}	
			//print_r($Nodelist);
        $this->assign('rolelist', $Rolelist);
		$this->assign('user_id', $_GET['user_id']);
		
       $this->display();
		
	   }
	 public function saverole(){ 
	      if(!$_POST['user_id']) $this->error("该用户不存在或已被删除!");
	      
		   $Role_user=M('Role_user');
		
		   $delets=$Role_user->where(array('user_id'=>$_POST['user_id']))->delete(); //$delets是返回被删除的记录数
		  
		   
	      foreach($_POST['id'] as $v){
				$data['user_id'] = $_POST['user_id'];
				$data['role_id'] = $v;
				$result=$Role_user->add($data);
			}
			$this->message($result);
			
    }
	public function add(){
		  $this->addata('Role');
	  
	}
	public function insert() {
		$this->assign('rolelist', M('Role')->field('id,name')->select());
		$this->display();	
	}
	function edit() {
              
		if(!$_GET['id']) $this->error("编辑项不存在或已删除!");
		$Role = M("Role");			   
		               
		 $this->assign('rolelist', $Role->field('id,pid,name')->select());			   
		 $this->assign('vo', $Role->getById($_GET['id']));		 
                       
         $this->display();              
        }
	public  function update() {
		$this->getupdate();
       }
                
	public function del(){   
		
		if(!$_GET['id']) $this->error("该不存在或已删除!");
		$result=M('Role')->where(array('id'=>$_GET['id']))->delete();
		if($result){
			$this->success("删除成功！");
		}else{
		$this->error("删除失败!");
		}
    }                    
}