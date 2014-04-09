<?php
class CommonModel extends RelationModel {
	protected $_validate = array (
		//array('email','require','请填写您的邮箱!'),
	array (
			'email',
			'email',
			'邮箱格式错误！'
		),
		
	);
	protected $_auto = array (
		array (
			'status',
			'1'
		),
		array (
			'inputtime',
			'time',
			1,
			'function'
		),
		array (
			'content',
			'content',
			1,
			'callback'
		),
		
	);
	
	 function recordnum() {
		return $this->field('id')->count();
	   }
	 function Rand($recordnum=12) {
		return $this->order("rand()")->limit($recordnum)->select();
	}	
	function Artnums() {
		return $this->field('id')->count();
	}
	function Hot($pagesize=9) {
		$hotlist = $this->field('id,title,hits')->order('hits desc')->limit($pagesize)->select();
		return $hotlist;
	}
	/* 最新发表*/
	function newsinfo($pagesize=15) {
		$newslists = $this->limit($pagesize)->order('id desc')->select();
		return $newslists;
	}
	function DateList($Module) {
		$Module = C('DB_PREFIX') . strtolower($Module);
		$DateList = $this->query("SELECT COUNT( FROM_UNIXTIME( inputtime , '%Y-%m' ) ) AS Count, FROM_UNIXTIME(inputtime , '%Y-%m' ) AS Time,inputtime As t FROM " . $Module . " GROUP BY Time order by Time desc");
		return $DateList;
	}
	
}
?>