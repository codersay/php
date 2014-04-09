<?php
class PublicAction extends Action {
    // 首页
    public function header() {
		
		$this->assign('tplname', $index='');
		//$this->assign('menu', $menu);
		 $this->display();		
          }
   public function right() {
             $this->display();
          }
   public function footer() {
             $this->display();
         }	
    public function search() {
             $this->display();
         }
	public function error404() {
             $this->display();
         }

   }
?>