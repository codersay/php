<?php
// 首页
class BlogAction extends CommonAction {
	public function index() {
		$bloglistarr=$this->listinfo('Blog');
		$this->listarr();
		$this->assign('info', $bloglistarr['info']);//
		$this->assign('page', $bloglistarr['page']);//
		$this->assign('newslist', D('News')->newsinfo());
		$this->assign('title', $title='网志微博客');
		$this->display();
	}
	public function listarr(){
	    $listarr=array();
		$listarr['tagslist']=D('Tag')->TagList('Blog');//标签列表
		$listarr['announce']=D('Announce')->announce();//公告
		$listarr['hotlist']=D('Blog')->Hot();//热点文章
		$listarr['randlist']=D('Blog')->Rand();//随机文章
		$listarr['catlist']=D('Columns')->Catlist('Blog', 2);//栏目列表
	    $this->assign('ance',  $listarr['announce']);	
		$this->assign('hotlist', $listarr['hotlist']);
		$this->assign('randlist', $listarr['randlist']);
		$this->assign('Catlist', $listarr['catlist']);
		$this->assign('tags', $listarr['tagslist']);
	   } 
	public function category() {
		$blogcate=$this->listinfo1('Blog',$_GET['catid']);
		dump($bloglistarr['info']);
		$this->listarr();
		$this->assign('info', $bloglistarr['info']);//
		$this->assign('page', $bloglistarr['page']);//
		$this->assign('newslist', D('News')->newsinfo());
		$this->assign('title', $title='网志微博客');
		//$this->display();
		}  
	function listinfo1($ModelName,$where='',$pagesize=15,$order='id desc') {
	    if (isset ($_GET['catid']) && !empty ($_GET['catid'])) {
			$where['catid'] = $_GET['catid'];
			
		} else {
			//$this->error404();
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
	public function read() {
		$readarr=$this->readaction('Blog');
		$carr= D('Comment')->gclist("id,username,inputtime,pid,nid,url,content,path,concat(path,'-',id) as bpath",array('bid'=>array('eq',$readarr['id'])));
		$this->listarr();
		$this->assign('vo', $readarr['vo']);
		$this->assign('pageup', $readarr['pageup']);
		$this->assign('pagedown', $readarr['pagedown']);
		$this->assign('recommends', $readarr['recommends']);
		//$this->assign('ctlist', D('Comment')->commentlist('Blog',$readarr['id']));
		$this->assign('ctlist', $carr['list']); 
		$this->assign('page', $carr['page']);
		$this->assign('relalist', $this->relaread('Blog',$readarr['id'],'RelaBlogView'));
		$this->display();
	}
	public function tag() {
		$this->getags('Blog','BlogtagView');
		$listarr=$this->listarr();
		$this->assign('hotlist', $listarr['hotlist']);
		$this->assign('Tagslist', $listarr['tagslist']);	
		$this->assign('Catlist', $listarr['catlist']);
		$this->assign('DateList', $listarr['dateList']);
		$this->assign('newslists', D('Blog')->newsinfo());	
		$this->display();
	}

	public function add() {
		$this->adddata('Comment');
	}
	public function tourl() {
		$this->gettourl('Comment');
	}

	//RSS 
	public function feed() {
		$Bloglist = D('Blog')->order('id')->limit(10)->select();
		import("@.ORG.Rss");
		$RSS = new RSS(C('WEIBONAME'), '', C('WEIBODESC'), ''); //站点标题的链接
		foreach ($Bloglist as $list) {
			$RSS->AddItem($list['title'], U('/blog/' . $list['id']), $list['content'], $list['ctime']);
		}
		$RSS->Display();
	}
}
?>