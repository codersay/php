<?php
/**
 * @标签模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/09
 * @Copyright: www.iqishe.com
 */
class TagsModel extends Model{
	//自动验证
	/*protected $_validate = array(
		array('title','','标题名称已经存在!',1,'unique',3)
	);*/

	//自动完成
	protected $_auto = array(
		//array('addtime','time',3,'function')
	);
}
?>