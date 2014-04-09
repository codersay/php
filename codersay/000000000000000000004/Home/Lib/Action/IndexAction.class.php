<?php
class IndexAction extends CommonAction {
    public function index(){
		$this->assign('arclist',$this->arcList());
		$this->assign('position',$this->getPos());
		$this->assign('flag','0_arc');
		$this->display();
    }

	//获取分类文章
	public function columns(){
		$colid = $_GET['colid'];
		$this->assign('arclist',$this->arcList($colid));
		$this->assign('position',$this->getPos($colid));
		$this->assign('flag',$colid.'_colarc');
		$this->display(C('CFG_DF_THEME').':Index:index');
	}

	//获取tag文章
	public function tag(){
		$key = $_GET['key'];
		$this->assign('arclist',$this->arcList(0,$key));
		$this->assign('position',$this->getPos(0,$key));
		$this->assign('flag',$key.'_tagarc');
		$this->display(C('CFG_DF_THEME').':Index:index');
	}

	//获取归档文章
	public function dateArc(){
		$date = $_GET['date'];
		$this->assign('arclist',$this->arcList(0,'',$date));
		$this->assign('position',$this->getPos(0,'',$date));
		$this->assign('flag',$date.'_datearc');
		$this->display(C('CFG_DF_THEME').':Index:index');
	}

	//文章搜索
	public function search(){
		$key = $this->_post('searchkey');
		if(empty($key)){
			$this->error('搜索关键字不能为空！');
		}
		$this->assign('arclist',$this->arcList(0,'','',$key));
		$this->assign('position',$this->getPos(0,'','',$key));
		$this->assign('flag',$key.'_searcharc');
		$this->display(C('CFG_DF_THEME').':Index:index');
	}

	//Ajax获取更多文章
	public function getArticle(){
		$flag = $_POST['flag'];
		$flagarray = explode('_',$flag);
		switch($flagarray[1]){
			case 'arc':
				$list = $this->arcList();
				break;
			case 'colarc':
				$list = $this->arcList($flagarray[0]);
				break;
			case 'tagarc':
				$list = $this->arcList(0,$flagarray[0]);
				break;
			case 'datearc':
				$list = $this->arcList(0,'',$flagarray[0]);
				break;
			case 'searcharc':
				$list = $this->arcList(0,'','',$flagarray[0]);
				break;
			default :
				$list = '';
				break;
		}
		$this->ajaxReturn($list);
	}
}