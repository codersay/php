<?php

class EmptyAction extends Action{
	public function index(){
		$this->display(C('CFG_DF_THEME').':Public:404');
	}

	public function _empty(){
		$this->display(C('CFG_DF_THEME').':Public:404');
	}
}
?>