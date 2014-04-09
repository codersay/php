<?php
class CommonAction extends Action {//公共控制器
	function _initialize() {
		header("Content-Type:text/html; charset=utf-8");
	}
	/*空操作*/
	function _empty() {
		$this->assign('jumpUrl', '__APP__/Public/error404');
		$this->error("抱歉您请求的页面不存在");
	}
	function error404() {
		$this->assign('jumpUrl', '__APP__/Public/error404');
		$this->error("抱歉您请求的页面不存在或已经删除。");
	}
	/*
	*lists:列表
	*$ModelName：模型名称
	*$where:查询条件
	*$pagesize 每页记录数目
	*$order排序条件
	*/
	function listinfo($ModelName,$where='',$pagesize=15,$order='id desc') {
		if (isset ($_GET['t'])) {
			$where['ctime'] = array (
				'like',
				$_GET['t']. '%'
			);
			$order = 'ctime desc';
		}else {
			$where = $where;
		}
		$D = D($ModelName);
		import("ORG.Util.Page");
		$count = $D->field('id')->where($where)->count();
		$P = new Page($count, $pagesize);
		$field = 'id,title,catid,keywords,description,inputtime,author,status,hits';
		$listinfo = $D->relation(true)->field($field)->where($where)->order($order)->limit($P->firstRow . ',' . $P->listRows)->select();
		$P->setConfig('header', '篇');
		$P->setConfig('prev', "«");
		$P->setConfig('next', '»');
		$P->setConfig('first', '|«');
		$P->setConfig('last', '»|');
		//$P->url = 'index/p';
		$page = $P->show();
		$listarr=array('info'=>$listinfo,'page'=>$page);
		return $listarr;
		
	}
	/*
	*getone:获取单条查询记录
	*$ModelName：模型名称
	*$where:查询条件
	*$pagesize 每页记录数目
	*$order排序条件录
	*/
	public function getone($ModuleName,$where,$field=''){
		$Module=D($ModuleName);
		if($field){
		    $vo = $Module->field($field)->where($where)->find();
		}else{
			$vo = $Module->where($where)->find();
		}
		if(!$vo) $this->error404();
		$Module->where($where)->setInc('hits',1);
		return $vo;
		}
	//明细页
	public function readaction($ModelName) {  
	     if(!$this->isGet()) {
			$this->error('非法请求');
			}           
		if (empty ($_GET['id'])) $this->error404();
		$Model = D($ModelName);
		$rid=trim($_GET['id']);
		$vo = $Model->relation(true)->where(array('id'=>$rid))->find();
		if (!$vo) $this->error404();			
		//推荐相关阅读
		$recommends = $Model->where(array('catid'=>$vo['catid']))->limit(9)->order('hits desc')->select();
       //点击量累计
		$Model->where(array('id'=>$rid))->setInc('hits', 1);
		//$News->where('id='.$_GET['id'])->setLazyInc("hits",1,60);//延迟更新(还没实现)
		unset ($map);
		$map['status'] = 1;
		$map['inputtime'] = array (
			'lt',
			$vo['inputtime']
		);
		$up = $Model->where($map)->field('id,title,inputtime')->order('inputtime desc')->find();

		unset ($map);
		$map['status'] = 1;
		$map['inputtime'] = array (
			'gt',
			$vo['inputtime']
		);
		$down = $Model->where($map)->field('id,title,inputtime')->order('inputtime asc')->find();
		$readarr=array('vo'=>$vo,'recommends'=>$recommends,'pageup'=>$up,'pagedown'=>$down,'id'=>$rid);
		return $readarr;
		        
       }
	/* 统计访问量*/
	public function visitNum($file){
		  @ session_start();
		$c_file = 'Public'.DIRECTORY_SEPARATOR.$file;
		if (!file_exists($c_file)) {
			$myfile = fopen($c_file, "w");
			fwrite($myfile, "0");
			fclose($myfile);
		}
		$counter = intval(file_get_contents($c_file));
        $file=basename($file,'.txt');
		if (!$_SESSION[$file]) {
			$_SESSION[$file] = true;
			$counter++;
			$fp = fopen($c_file, "w");
			fwrite($fp, $counter);
			fclose($fp);
		}

		$count = $counter;
		return $count;

		}
	/*
	*相关阅读
	*$Module：模型名称
	*$rid:获取的文章ID
	*$ViewName 视图名称
	*/
	public function relaread($Module, $rid, $ViewName) {
         $tagId=M('Tagged')->field('tagId')->where(array (
			'module' => $Module,
			'recordId' => trim($rid
		)))->getField('tagId');		
		if ($relalist !== false) {

			$map['tagId'] = $tagId;
			$map['status'] = 1;
			$map['id'] = array (
				'neq',
				$rid
			);
			$map['recordId'] = array (
				'neq',
				$rid
			);
			$relalist = D($ViewName)->where($map)->order('id desc')->select();

			return $relalist;

		}
	}
	/*
	*相关标签
	*$Module：模型名称
	*$ViewName 视图名称
	*/
	public function getags($Module, $ViewName) {
		if(!$this->isGet()) {
			$this->error('非法请求');
			}   
		$Tag = D('Tag');
		if (!empty ($_GET['name'])) {

			header("content-Type: text/html; charset=Utf-8");
			$name = trim($_GET['name']);
			//$name =iconv("GB2312","UTF-8",$name);

			$vo = $Tag->where(array (
				'module' => $Module,
				'name' => $name
			))->field('id,count')->find(); //取得标签的ID和相关数

			import("ORG.Util.Page");
			$listRows = 10;

			$P = new Page($vo['count'], $listRows);
			$P->setConfig('header', '篇博文 ');

			$list = D($ViewName)->where(array (
				'status' => 1,
				'tagId' => $vo['id']
			))->order('id desc')->limit($P->firstRow . ',' . $P->listRows)->select();

			if ($list) { //列出相关标签
				$page = $P->show();
				$this->assign("page", $page);
				$this->assign('list', $list);
			}
			$this->assign('tag', $name);
			$this->assign("count", $vo['count']);
		} else { //列出所有标签
			//$map['module']= $Module;
			$list = $Tag->where(array (
				'module' => $Module
			))->select();
			$this->assign('tags', $list);
		}
	}
	public function adddata($ModuleName) {
		if(!$this->isPost()) {
			$this->error('非法请求');
			}
		$Module = D($ModuleName);
		$vo = $Module->create();
		//dump($vo);
		/**/if (!$vo) $this->error('数据创建失败');
			if ($Module->add()) {
				if(in_array($ModuleName,array('Guestbook','Comment'))){
				$this->ajaxReturn($vo, '表单数据保存成功！', 1);
				}else{
					$this->success('添加成功');
				}
			} else {
				$this->error('操作失败');
			}
		
	}
	public function gettourl($ModuleName) {//还未测试2012.12.7
	    if(!$this->isGet()) {
			$this->error('非法请求');
			}    
		if (!empty ($_GET['id'])) {
			$url = M($ModuleName)->where(array('id'=>$_GET['id']))->getField('url');
			redirect($url, 1, ' ');
		}
	}
}
?>