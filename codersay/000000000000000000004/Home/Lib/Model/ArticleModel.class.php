<?php

class ArticleModel extends RelationModel{
	protected $_link = array(
		'Columns' => array(
			'mapping_type' => BELONGS_TO,
			'class_name' => 'Columns',
			'foreign_key' => 'colid',
			'mapping_name' => 'category',
			'mapping_fields' => 'colname',
			'as_fields' => 'colname',
		),
	);

	//获取上一篇或下一篇文章
	public function getUpDownArc($time,$type='up'){
		if($type == 'up'){
			$where['createtime'] = array('GT',$time);
			$ord = 'asc';
		}
		if($type == 'down'){
			$where['createtime'] = array('LT',$time);
			$ord = 'desc';
		}
		$arcarray = $this->where($where)->field('arcid,title')->order('ord asc,createtime '.$ord)->find();
		if($arcarray){
			$url = "<a href='".U('Article/index',array('arcid'=>$arcarray['arcid']))."' target='_blank'>".$arcarray['title']."</a>";
			return $url;
		}
		else{
			return '';
		}
	}
}
?>