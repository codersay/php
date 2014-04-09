<?php
/**
 * @标签管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class TagsAction extends CommonAction{
	public function index(){
		//获取列表
		$tagobj = D('Tags');
		$map['1'] = 1;

		//搜索
		$searchkey = '';
		if(!empty($_POST['search']) && $_POST['search'] == 'search'){
			if(!empty($_POST['tagkey'])){
				$map['tagname'] = array('like','%'.$_POST['tagkey'].'%');
				$searchkey = $_POST['tagkey'];
			}
		}

		$page = $this->paging($tagobj,$map);
		$list = $tagobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('addtime desc')->select();
		foreach($list as $key => $val){
			$list[$key]['colname'] = D('Columns')->getColName($val['colid']);
		}
		$this->assign('page', $page->show());
		$this->assign('list', $list);

		//搜索模板变量
		$this->assign('searchkey',$searchkey);

		$this->display();
	}

	//删除单个标签
	public function del(){
		$tagid = trim($_GET['tagid']);
		if(empty($tagid)){
			$this->error('该项不存在！');
		}
		$result = D('Tags')->where(array('tagid'=>$tagid))->delete();
		$this->message($result,'__GROUP__/Tags/index','删除成功！','删除失败！');
	}

	//批量删除标签
	public function delall(){
		$tagid = $_POST['tagid'];
		$tagidstr = implode(',',$tagid);
		if(!$this->isCheckBox($tagidstr)){
			$this->error('请选中记录！');
		}
		$result=D('Tags')->where(array('tagid'=>array ('in',$tagidstr)))->delete(); 
		$this->message($result,'__GROUP__/Tags/index','删除成功！','删除失败！');
	}

	//新增或更新tags
	public function saveTags($tag,$colid,$isadd=1){
		$tagobj = D('Tags');
		//多关键字
		if(strpos($tag,',') !== false){
			$tags = explode(',',trim($tag));
			foreach($tags as $key => $val){
				$result = $tagobj->where(array('tagname'=>$val))->find();
				if($result){
					if($isadd){
						$tagobj->where(array('tagname'=>$val))->setInc('num',1);
					}
				}
				else{
					$data['tagname'] = $val;
					$data['num'] = '1';
					$data['colid'] = $colid;
					$data['addtime'] = time();
					$tagobj->add($data);
				}
			}
		}
		else{
			$result = $tagobj->where(array('tagname'=>$tag))->find();
			if($result){
				if($isadd){
					$tagobj->where(array('tagname'=>$tag))->setInc('num',1);
				}
			}
			else{
				$data['tagname'] = $tag;
				$data['num'] = '1';
				$data['colid'] = $colid;
				$data['addtime'] = time();
				$tagobj->add($data);
			}
		}
	}
}
?>