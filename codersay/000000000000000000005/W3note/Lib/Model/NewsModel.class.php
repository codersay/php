<?php
class NewsModel extends CommonModel{
    protected $_link = array(
        'Columns'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'Columns',
           'foreign_key'=>'catid',//News表中的catid
           'as_fields'=>'colTitle,colId,colPid',
       ),
         'Comment'=>array(
           'mapping_type'=>HAS_MANY,
           'class_name'=>'Comment',
           'foreign_key'=>'nid',//与上面的外键不同？
           'mapping_fields'=>'author,email,content,inputtime',
       ),
    );
	function Artnums() {
		return $this->field('id')->count();
	}
	/* 随机文章*/
	function Rand($recordnum=12) {
		return $this->order("rand()")->limit($recordnum)->select();
	}
}
?>