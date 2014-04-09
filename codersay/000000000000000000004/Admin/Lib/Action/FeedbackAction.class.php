<?php
/**
 * @留言管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */
class FeedbackAction extends CommonAction{
	public function index(){
		//获取列表
		$obj = D('Feedback');
		$map['pid'] = 0;

		$page = $this->paging($obj,$map);
		$list = $obj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('time DESC')->select();
		foreach ($list as $k=>$v){
			$list[$k]['fullcontent'] = $v['content'];
			if(strlen($v['content']) > 16){
				$list[$k]['content'] = mb_substr($v['content'],0,16,'utf-8').'...';
			}
		}

		$this->assign('page', $page->show());
		$this->assign('list', $list);
		$this->display();
	}

	//留言回复
	public function reply(){
		$id = trim($_GET['id']);
		if(empty($id)){
			$this->error('留言不存在！');
		}
		$map['id'] = $id;
		$data = M('Feedback')->where($map)->find();
		if($data){
			import("ORG.Util.Input");
			$data['num'] = M('Feedback')->where(array('pid'=>$id))->count();
			$data['content'] = Input::nl2Br($data['content']);
		}
		$this->assign('data',$data);
		$this->display();
	}

	//增加管理员回复
	public function replyAdd(){

		//处理[code][/code]
		$content = $_POST['rfeed'];
		$content = preg_replace("/\[code\]/",'<pre>',$content);
		$content = preg_replace("/\[\/code\]/",'</pre>',$content);

		$data['writer'] = '管理员';
		$data['content'] = $content;
		$data['isreply'] = $_POST['isreply'];
		$data['time'] = time();
		$data['pid'] = $_POST['id'];
		$data['ip'] = get_client_ip();
		$obj = M('Feedback');

		//标记已回复
		$obj->where(array('id'=>$_POST['id']))->save(array('ischeck'=>1));

		//添加管理员回复
		$result = $obj->add($data);
		$this->message($result,'__GROUP__/Feedback/index','回复成功！','回复失败！');
	}

	//留言删除
	public function del(){
		$id = trim($_GET['id']);
		if(empty($id)){
			$this->error('留言不存在！');
		}

		//删除留言所属回复
		M('Feedback')->where(array('pid'=>$id))->delete();

		//删除评论
		$result = M('Feedback')->where(array('id'=>$id))->delete();
		$this->message($result,'__GROUP__/Feedback/index','删除成功！','删除失败！');
	}
}
?>