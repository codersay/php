<?php
/**
 * @博文管理模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/21
 * @Copyright: www.iqishe.com
 */

class ArticleModel extends Model{
	//自动验证
	protected $_validate = array(
		array('title','require','标题不能为空！'),
		array('title','','标题名称已经存在!',0,'unique',1),
		array('colid','checkCol','请选择栏目！',1,callback),
		array('content','require','内容不能为空！')
	);

	//自动完成
	protected $_auto = array(
		array('source','srcDefaultVal','3','callback'),
		array('createtime','time',1,'function'),
		array('updatetime','time',3,'function'),
	);
	
	//检查是否选择栏目
	public function checkCol($data){
		if($data == 0){
			return false;
		}
		else{
			return true;
		}
	}

	//文章来源为空时默认值
	public function srcDefaultVal($data){
		if(empty($data)){
			$data = '未知';
		}
		return $data;
	}

	//根据Colid获得文章数
	public function getArcNumByColid($colid){
		$num = $this->where(array('colid'=>$colid))->count();
		return $num;
	}
}
?>