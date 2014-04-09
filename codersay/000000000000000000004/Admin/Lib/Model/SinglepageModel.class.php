<?php
/**
 * @单页管理模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/15
 * @Copyright: www.iqishe.com
 */
class SinglepageModel extends Model{
	//自动验证
	protected $_validate = array(
		array('title','require','标题不能为空！'),
		array('title','','标题名称已经存在!',0,'unique',1),
		array('content','require','内容不能为空！')
	);

	//自动完成
	protected $_auto = array(
		array('createtime','time',1,'function'),
		array('updatetime','time',3,'function')
	);
}
?>