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
class UserAction extends CommonAction {
	
	public function index() {
        $this->lists();
        $this->display();
    }
	public function act(){
		$this->action('User');
		
	}
	public function insert(){
	
		$a=$_SESSION['verify'];
		$this->assign("a", $a);
		$this->display();
	}
	public function edit() {
             $this->getedit();
			 $this->display(); 
            }
	
	// 插入数据
	public function add() {
		$this->addata('User');
	}   
	public  function update() {
            $this->getupdate();
   }
}
?>