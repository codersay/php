<?php
//
class IndexAction extends AdminAction{
    public function index(){
        $this->display();
    }

	public function top() {
		$this->display("Admin:Public:top");
	}

	public function left() {
		//$this->assign("username", $_SESSION["username"]);
		$this->display("Admin:Public:left");
	}

	public function switchfrm() {
		$this->display("Admin:Public:switchfrm");
	}

	public function mainframe() {
		$this->display("Admin:Public:mainframe");
	}

	public function manframe() {
		$this->display("Admin:Public:manframe");
	}
}
?>