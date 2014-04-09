<?php
class CatAction extends CommonAction {
    public function index(){
		$listarr=$this->CategoryList();
		$this->assign('ance', D('Announce')->announce());
		$this->assign('newslist', D('Blog')->newsinfo());
		$this->assign('title', $listarr['CategoryName']);
		$this->assign('urlname', $listarr['urlname']);
		$this->assign('info', $listarr['info']);
		$this->assign('page', $listarr['page']);
        $this->display();
    }
	function CategoryList($where='',$pagesize=15,$order='id desc') {
	    if (isset ($_GET['catid']) && !empty ($_GET['catid'])) {
			$where['catid'] = $_GET['catid'];
			$vo=M('Columns')->where(array('colId' =>$_GET['catid']))->find();
			$ModelName=$this->GetModuleName($vo['modelid']);
			$UrlName=$this->GetUrlName($vo['modelid']);
			
		} else {
			$this->error404();
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
		$page = $P->show();
		$listarr=array('info'=>$listinfo,'page'=>$page,'CategoryName'=>$vo['colTitle'],'urlname'=>$UrlName);
		return $listarr;
		
	}
	public function GetModuleName($ModelId) {
		$Marray = array (
			'News' => 1,
			'Blog' => 2,
			'Download' => 3,
		);
		$ModuleName =  implode(',', array_keys($Marray, $ModelId));
		return $ModuleName;
	}
	public function GetUrlName($ModelId) {
		$Marray = array (
			'read' => 1,
			'blog' => 2,
			'down' => 3,
		);
		$UrlName =  implode(',', array_keys($Marray, $ModelId));
		return $UrlName;
	}
}