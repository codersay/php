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
class LinkAction extends CommonAction{

     public function index() {
        $this->lists();
        $this->display();
    }
	public function insert(){
		  if(isset($_POST['linktype'])){	
		      $this->assign("linktype", $_POST['linktype']);
			   } 
		  $this->display();			
		}
	public function add(){
		 $this->addata('Link');
						
		}
	 public function edit(){  
	     if(isset($_POST['linktype'])){	
		  $linktype=$_POST['linktype'];
		  $id=$_POST['id'];
		  }elseif(isset($_GET['id'])){
			  $id=$_GET['id'];
			  }
		      
		$Linklist =  M('Link')->where(array('id'=>$id))->find();
		$this->assign('vo',$Linklist);
		$this->assign("linktype", $linktype);
		$this->display();
    }
	public  function update() {
             $this->getupdate();
          }

	public function act(){
		$this->action();
		
		}	
}
?>