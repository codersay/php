<?php
/**
 * @模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/03
 * @Copyright: www.iqishe.com
 */

class ModelModel extends Model{
	protected $_validate = array(
		array('maction','','模型操作名已存在!',0,'unique',1),
		array('mname','','模型名已存在!',0,'unique',1)
	);

	//获取模型列表
	public function getMolList($selid=1){
		$list = $this->where(array('status'=>1))->select();
		$rlist = '';
		foreach($list as $key => $val){
			if($val['mid'] == $selid){
				$rlist .= "<option value='".$val['mid']."' selected>".$val['mname']."</option>\r\n";
			}
			else{
				$rlist .= "<option value='".$val['mid']."'>".$val['mname']."</option>\r\n";
			}
		}
		return $rlist;
	}

	//获取模型名称
	public function getMname($mid){
		$data = $this->where(array('mid'=>$mid))->find();
		return $data['mname'];
	}
}
?>