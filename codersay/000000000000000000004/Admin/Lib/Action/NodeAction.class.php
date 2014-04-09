<?php
/**
 * @节点管理
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/07
 * @Copyright: www.iqishe.com
 */

class NodeAction extends CommonAction{
	public function index(){
		//获取列表
		$nodeobj = M('Node');
		$map['1'] = 1;

		//搜索
		$sellevel = 0;
		$searchkey = '';
		if(!empty($_POST['search']) && $_POST['search'] == 'search'){
			if(!empty($_POST['level']) && $_POST['level'] != 0){
				$map['level'] = $_POST['level'];
				$sellevel = $_POST['level'];
			}
			if(!empty($_POST['keysearch'])){
				$map['title'] = array('like','%'.$_GET['keysearch'].'%');
				$searchkey = $_POST['keysearch'];
			}
		}
		//搜索后分页处理
		if(!empty($_GET['search']) && $_GET['search'] == 'search'){
			if(!empty($_GET['level']) && $_GET['level'] != 0){
				$map['level'] = $_GET['level'];
				$sellevel = $_GET['level'];
			}
			if(!empty($_GET['keysearch'])){
				$map['title'] = array('like','%'.$_GET['keysearch'].'%');
				$searchkey = $_GET['keysearch'];
			}
		}
		

		$page = $this->paging($nodeobj,$map);
		$list = $nodeobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('level asc,sort ASC')->select();
		foreach($list as $key => $val){
			//处理pid
			if($val['pid'] == 0){
				$list[$key]['pidname'] = '顶级节点';
			}
			else{
				$row = $nodeobj->where(array('id'=>$val['pid']))->find();
				switch($row['level']){
				case 1: $list[$key]['pidname'] = $row['title'].'项目';break;
				case 2: $list[$key]['pidname'] = $row['title'].'模块';break;
				case 3: $list[$key]['pidname'] = $row['title'].'操作';break;
				default:break;
			}
			}
			//处理level
			switch($val['level']){
				case 1: $list[$key]['levelname'] = '项目';$list[$key]['title'] .= '项目';break;
				case 2: $list[$key]['levelname'] = '模块';$list[$key]['title'] .= '模块';break;
				case 3: $list[$key]['levelname'] = '操作';$list[$key]['title'] .= '操作';break;
				default:break;
			}
		}
		
		$this->assign('page', $page->show());
		$this->assign('list', $list);

		//搜索模板变量
		$this->assign('sellevel',$sellevel);
		$this->assign('searchkey',$searchkey);

		$this->display();
	}

	//排序
	public function updateord(){
		$idord = $_POST['idord'];
		$sort = $_POST['nodeord'];
		foreach($idord as $key => $val){
			$map['id'] = $val;//一维数组
			$data['sort'] = $sort[$key];
			$result[] = M('Node')->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Node/index');
	}
}
?>