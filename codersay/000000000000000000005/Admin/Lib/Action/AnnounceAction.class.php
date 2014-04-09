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
class AnnounceAction extends CommonAction {
     public function index() {
        $this->lists();
        $this->display();
    }
    public function insert(){
			 $this->display(); 			
	}
    // 处理表单数据
    public function add(){
		$this->addata($this->getActionName());
		}
	public function edit(){  		      
		$this->getedit();
		$this->display();
    }	 
     public function act(){
		$this->action();
	}
    public  function update() {
             $this->getupdate();
          }
   }
?>