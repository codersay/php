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
//if (empty($_SESSION[C('USER_AUTH_KEY')])) exit();
class BannerAction extends CommonAction{

     public function index() {
        $this->lists();
        $this->display();
    }
	public function insert(){
		  if(isset($_POST['typeid'])&&$_POST['typeid']!=0){	
		      $this->assign("typeid", $_POST['typeid']);
			  
			  }	
			  $this->display(); 		
		     }
	 public function add(){
		$this->addata('Banner');
		}
	 public function edit(){  
		$Bannerlist =M('Banner')->where(array('id'=>$_GET['id']))->find();
		$this->assign('vo',$Bannerlist);
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