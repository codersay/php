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
class TagAction extends CommonAction {

    // 首页
    public function index() {
        $this->lists();
        $this->display();
    }
	
	 
    public function del(){   
		$condition['id'] = $_REQUEST['id'];
		$Tag = M('Tag');
		if($Tag->where($condition)->delete()){
			$this->success("删除成功！");
		}else{
		$this->error("删除失败!");
		}
    }
	public function act(){
		
		$getid = $_REQUEST['id'];  
		$getids = implode(',',$getid);
		$id = is_array($getid) ? $getids : $getid;
		$map['id'] = array('in',$id);
		if(!$id){			
			$this->error('请勾选记录');		
		}
		$Module = D('Tag');		
		  
		
		if($_REQUEST['act'] == '删除'){
			$result=array();
			foreach($getid as $v){
				$vo = $Module->where("id=$v")->find(); 
				
				$result[]=$Module->delete($v);
			}
			if(false !== $result){
			   $this->success("操作成功！");
			}else{
				$this->error("操作失败！");
				}/**/
			
		}
	}

   }

?>