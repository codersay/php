<?php
/**
 * @评论模型模型
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/29
 * @Copyright: www.iqishe.com
 */

class CommentModel extends Model{
	//过去文章的评论数
	public function getArcNum($arcid){
		$map['arcid'] = $arcid;
		$num = $this->where($map)->count();
		return $num;
	}
}
?>