<?php
class BlogModel extends CommonModel{
	protected $_validate  =  array(
     array('title','require','标题不能为空！'),
	 array('content','require','内容不能为空！'),
     //array('title','','标题名称已经存在！',0,'unique',1), // 在新增的时候验证title字段是否唯一
     
);
    protected $_auto = array (
		array (
			'status',
			'0'
		),
		array (
			'inputtime',
			'time',
			1,
			'function'
		),
		
	);
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
           'foreign_key'=>'bid',//与上面的外键不同？
           'mapping_fields'=>'username,email,content,inputtime',
       ),
    );
}
?>
