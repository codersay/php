<?php

class ArticleAction extends CommonAction{
	public function index(){
		$obj = D('Article');
		$arcid = $_GET['arcid'];
		$where['arcid'] = $arcid;
		$article = $obj->relation(true)->where($where)->find();
		$article['arcurl'] =  U('Article/index',array('arcid'=>$arcid));
		$article['commentnum'] = $this->getCommentNum($article['arcid']);
		$article['colurl'] = U('Index/columns',array('colid'=>$article['colid']));

		//处理关键字
		$keyarray = explode(',',$article['keyword']);
		foreach ($keyarray as$k=>$v){
			$keyarray[$k] = "<a href='".U('Index/tag',array('key'=>$v))."'>".$v."</a>";
		}
		$article['keyurl'] = implode(',',$keyarray);

		//处理上一篇下一篇文章
		$article['prearc'] = $obj->getUpDownArc($article['createtime'],'up');
		$article['nextarc'] = $obj->getUpDownArc($article['createtime'],'down');

		//点击次数更新
		$data['click'] = $article['click'] + 1;
		$obj->where(array('arcid'=>$arcid))->save($data);

		$this->assign('article',$article);
		$this->display();
	}
}
?>