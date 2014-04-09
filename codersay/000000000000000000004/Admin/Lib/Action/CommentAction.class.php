<?php
/**
 * @评论管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class CommentAction extends CommonAction{
	public function index(){
		//获取列表
		$obj = D('Comment');
		$map['pid'] = 0;

		$selcolid = 0;
		$searchkey = '';
		if(!empty($_POST['search']) && $_POST['search'] == 'search'){
			if(!empty($_POST['colid']) && $_POST['colid'] != 0){
				$colmid = explode('-',$_POST['colid']);
				$map['colid'] = $colmid[0];
				$selcolid = $colmid[0];
			}
			if(!empty($_POST['keysearch'])){
				$map['content'] = array('like','%'.$_POST['keysearch'].'%');
				$searchkey = $_POST['keysearch'];
			}
		}
		//搜索后分页处理
		if(!empty($_GET['search']) && $_GET['search'] == 'search'){
			if(!empty($_GET['colid']) && $_GET['colid'] != 0){
				$colmid = explode('-',$_GET['colid']);
				$map['colid'] = $colmid[0];
				$selcolid = $colmid[0];
			}
			if(!empty($_GET['keysearch'])){
				$map['content'] = array('like','%'.$_GET['keysearch'].'%');
				$searchkey = $_GET['keysearch'];
			}
		}

		$page = $this->paging($obj,$map);
		$list = $obj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('time DESC')->select();
		foreach($list as $key => $val){
			//获取评论文章标题
			$row = M('Article')->where(array('arcid'=>$val['arcid']))->find();
			$list[$key]['title'] = $row['title'];

			$list[$key]['fullcontent'] = $val['content'];
			if(strlen($val['content']) > 16){
				$list[$key]['content'] = mb_substr($val['content'],0,16,'utf-8').'...';
			}
		}

		$this->assign('page', $page->show());
		$this->assign('list', $list);

		//获取栏目
		//$this->assign('collist', D('Columns')->getColList(0));

		//搜索模板变量
		$this->assign('collist',D('Columns')->getColList($mid,$selcolid));
		$this->assign('searchkey',$searchkey);
		$this->display();
	}

	//评论回复显示
	public function reply(){
		$id = trim($_GET['id']);
		if(empty($id)){
			$this->error('评论不存在！');
		}
		$map['id'] = $id;
		$data = M('Comment')->where($map)->find();
		if($data){
			import("ORG.Util.Input");
			$row = M('Article')->where(array('arcid'=>$data['arcid']))->find();
			$data['title'] = $row['title'];
			$data['num'] = M('Comment')->where(array('pid'=>$id))->count();
			$data['content'] = Input::nl2Br($data['content']);
		}
		$this->assign('data',$data);
		$this->display();
	}

	//增加管理员回复
	public function replyAdd(){
		
		//处理[code][/code]
		$content = $_POST['rcontent'];
		$content = preg_replace("/\[code\]/",'<pre>',$content);
		$content = preg_replace("/\[\/code\]/",'</pre>',$content);

		$data['arcid'] = $_POST['arcid'];
		$data['colid'] = $_POST['colid'];
		$data['writer'] = '管理员';
		$data['content'] = $content;
		$data['isreply'] = $_POST['isreply'];
		$data['time'] = time();
		$data['pid'] = $_POST['id'];
		$data['ip'] = get_client_ip();
		$obj = M('Comment');

		//标记已回复
		$obj->where(array('id'=>$_POST['id']))->save(array('ischeck'=>1));

		//添加管理员回复
		$result = $obj->add($data);
		$this->message($result,'__GROUP__/Comment/index','回复成功！','回复失败！');
	}

	//评论删除
	public function del(){
		$id = trim($_GET['id']);
		if(empty($id)){
			$this->error('评论不存在！');
		}

		//删除评论所属回复
		M('Comment')->where(array('pid'=>$id))->delete();

		//删除评论
		$result = M('Comment')->where(array('id'=>$id))->delete();
		$this->message($result,'__GROUP__/Comment/index','删除成功！','删除失败！');
	}
}
?>