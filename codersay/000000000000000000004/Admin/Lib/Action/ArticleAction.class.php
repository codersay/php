<?php
/**
 * @博文管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/09
 * @Copyright: www.iqishe.com
 */

class ArticleAction extends CommonAction{
	//博文管理列表页
	public function index(){
		//获取列表
		$arcobj = D('Article');
		$map['1'] = 1;

		//当前用户的博文
		if(!empty($_GET['username'])){
			$map['username'] = $_GET['username'];
		}

		//获取某个栏目
		if(!empty($_GET['colid'])){
			$map['colid'] = $_GET['colid'];
		}

		//搜索
		$selcolid = 0;
		$searchkey = '';
		if(!empty($_POST['search']) && $_POST['search'] == 'search'){
			if(!empty($_POST['colid2']) && $_POST['colid2'] != 0){
				$colmid = explode('-',$_POST['colid2']);
				$map['colid'] = $colmid[0];
				$selcolid = $colmid[0];
			}
			if(!empty($_POST['keysearch'])){
				$map['title'] = array('like','%'.$_POST['keysearch'].'%');
				$searchkey = $_POST['keysearch'];
			}
		}
		//搜索后分页处理
		if(!empty($_GET['search']) && $_GET['search'] == 'search'){
			if(!empty($_GET['colid2']) && $_GET['colid2'] != 0){
				$colmid = explode('-',$_GET['colid2']);
				$map['colid'] = $colmid[0];
				$selcolid = $colmid[0];
			}
			if(!empty($_GET['keysearch'])){
				$map['title'] = array('like','%'.$_GET['keysearch'].'%');
				$searchkey = $_GET['keysearch'];
			}
		}

		$page = $this->paging($arcobj,$map);
		$list = $arcobj->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('ord ASC,arcid DESC')->select();
		foreach($list as $key => $val){
			$list[$key]['colname'] = D('Columns')->getColName($val['colid']);
			$list[$key]['comnum'] = D('Comment')->getArcNum($val['arcid']);
			
			//处理自定义属性，添加相应标示
			if(!empty($val['property'])){
				if(strpos($val['property'],',') === false){
					if($val['property'] == 'h'){
						$list[$key]['hc'] = "<img src='__PUBLIC__/admin/images/hot.gif'/>";
					}
					else{
						$list[$key]['hc'] = "<img src='__PUBLIC__/admin/images/tuijian.gif'/>";
					}
				}
				else{
					$list[$key]['hc'] = "<img src='__PUBLIC__/admin/images/tuijian.gif'/><img src='__PUBLIC__/admin/images/hot.gif'/>";
				}
			}
			else{
				$list[$key]['hc'] = '';
			}
		}
		$this->assign('page', $page->show());
		$this->assign('list', $list);

		//获取栏目
		$mname=$this->getActionName();
		$mid = $this->getMidId($mname);
		$this->assign('collist', D('Columns')->getColList($mid));

		//搜索模板变量
		$this->assign('collist2',D('Columns')->getColList($mid,$selcolid));
		$this->assign('searchkey',$searchkey);

		//获取当前登录身份
		$this->assign('uname',$_SESSION['loginUserName']);

		$this->display();
	}

	//新增博文
	public function add(){
		//获取栏目
		$mname=$this->getActionName();
		$mid = $this->getMidId($mname);
		$this->assign('collist', D('Columns')->getColList($mid)); 
		//获取当前登录身份
		$this->assign('username',$_SESSION['loginUserName']);

		$this->display();
	}

	//保存新增博文
	public function addsave(){
		$arcobj = D('Article');
		$form = $arcobj->create();
		if(!$form){
			$this->error(($arcobj->getError()));
		}

		//设置自定义属性
		$arcobj->property = isset($_POST['property']) ? implode(',',$_POST['property']) : '';

		//处理colid和mid
		$colmid = explode('-',$_POST['colid']);
		$arcobj->colid = $colmid[0];
		$arcobj->mid = $colmid[1];

		//处理关键字
		if(!empty($_POST['keyword'])){
			$tag = $_POST['keyword'];
			A('Tags')->saveTags($tag,$colmid[0]);
		}
		
		//自动提取内容摘要
		$description = $_POST['description'];
		if(empty($description)){
			$arcobj->description = subStrCN(html2text($_POST['content']),512);
		}
		
		$return = $arcobj->add();
		$this->message($return,'__GROUP__/Article/index','新增成功！','新增失败！');
	}

	//编辑博文显示
	public function edit(){
		//获取编辑内容
		$arcid = trim($_GET['arcid']);
		if(empty($arcid)){
			$this->error('编辑项不存在！');
		}
		$map['arcid'] = $arcid;
		$data = D('Article')->where($map)->find();
		if($data){
			//获取栏目
			$mname=$this->getActionName();
			$mid = $this->getMidId($mname);
			$this->assign('collist', D('Columns')->getColList($mid,$data['colid']));

			//处理自定义属性
			if(!empty($data['property'])){
				if(strpos($data['property'],',') === false){
					if($data['property'] == 'h'){
						$data['property'] = "<input id='propertyh' class='np' type='checkbox' value='h' name='property[]' checked />热门(h)"."<input id='propertyh' class='np' type='checkbox' value='c' name='property[]'  />推荐(c)";
					}
					else{
						$data['property'] = "<input id='propertyh' class='np' type='checkbox' value='h' name='property[]'  />热门(h)"."<input id='propertyh' class='np' type='checkbox' value='c' name='property[]' checked />推荐(c)";
					}
				}
				else{
					$data['property'] = "<input id='propertyh' class='np' type='checkbox' value='h' name='property[]' checked />热门(h)"."<input id='propertyh' class='np' type='checkbox' value='c' name='property[]' checked />推荐(c)";
				}
			}
			else{
				$data['property'] = "<input id='propertyh' class='np' type='checkbox' value='h' name='property[]'/>热门(h)"."<input id='propertyh' class='np' type='checkbox' value='c' name='property[]'  />推荐(c)";
			}
			
			//是否有关键词
			if(empty($data['keyword'])){
				$data['iskey'] = 0;
			}
			else{
				$data['iskey'] = 1;
			}
			$this->assign('data',$data);
		}
		else{
			$this->error();
		}
		$this->display();
	}

	//更新博文
	public function update(){
		$arcobj = D('Article');
		$form = $arcobj->create();
		if(!$form){
			$this->error(($arcobj->getError()));
		}

		//设置自定义属性
		$arcobj->property = isset($_POST['property']) ? implode(',',$_POST['property']) : '';

		//处理colid和mid
		$colmid = explode('-',$_POST['colid']);
		$arcobj->colid = $colmid[0];
		$arcobj->mid = $colmid[1];

		//处理关键字
		if(!empty($_POST['keyword'])){
			$tag = trim($_POST['keyword']);
			if(!($_POST['iskey'])){
				A('Tags')->saveTags($tag,$colmid[0]);
			}
			else{
				A('Tags')->saveTags($tag,$colmid[0],0);
			}
		}

		//自动提取内容摘要
		$description = $_POST['description'];
		if(empty($description)){
			$arcobj->description = subStrCN(html2text($_POST['content']),240);
		}
		
		$return = $arcobj->save();
		$this->message($return,'__GROUP__/Article/index','更新成功！','更新失败！');
	}

	//文章推荐
	/*public function recommend(){
		$this->success('推荐成功！','__GROUP__/Article/index');
	}*/

	//文章更新排序
	public function updateord(){
		$arcidord = $_POST['arcidord'];
		$ord = $_POST['arcorder'];
		$arcobj = D('Article');
		foreach($arcidord as $key => $val){
			$map['arcid'] = $val;//一维数组
			$data['ord'] = $ord[$key];
			$result[] = $arcobj->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Article/index');
	}

	//文章审核
	public function check(){
		$arcid = $_POST['arcid'];
		$arcidstr = implode(',',$arcid);
		if(!$this->isCheckBox($arcidstr)){
			$this->error('请选中记录！');
		}
		$result=D('Article')->where(array('arcid'=>array ('in',$arcidstr)))->save(array('ischeck'=>1)); 
		$this->message($result,'__GROUP__/Article/index');
	}

	//文章删除
	public function del(){
		$arcid = $_POST['arcid'];
		$arcidstr = implode(',',$arcid);
		if(!$this->isCheckBox($arcidstr)){
			$this->error('请选中记录！');
		}
		$result=D('Article')->where(array('arcid'=>array ('in',$arcidstr)))->delete(); 
		$this->message($result,'__GROUP__/Article/index','删除成功！','删除失败！');
	}

	//文章移动
	public function move(){
		$arcid = $_POST['arcid'];
		$arcidstr = implode(',',$arcid);
		if(!$this->isCheckBox($arcidstr)){
			$this->error('请选中记录！');
		}
		if($_POST['colid1'] == 0){
			$this->error('请选择栏目！');
		}
		$colmid = explode('-',$_POST['colid1']);

		$result=D('Article')->where(array('arcid'=>array('in',$arcidstr)))->save(array('colid'=>$colmid[0],'mid'=>$colmid[1]));
		$this->message($result,'__GROUP__/Article/index');
	}
}
?>