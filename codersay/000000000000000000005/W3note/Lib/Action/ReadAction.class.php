<?php
class ReadAction extends CommonAction {
   public function listarr(){
	     $listarr=array();
		 $listarr['announce']=D('Announce')->announce();//公告
	     return $listarr;
	   }   
   public function read() {            
		$readarr=$this->readaction('News');
		$listarr=$this->listarr();
		$carr= D('Comment')->gclist("id,username,inputtime,pid,nid,url,content,path,concat(path,'-',id) as bpath",array('nid'=>array('eq',$readarr['id'])));
        $this->assign('vo', $readarr['vo']);
		$this->assign('pageup', $readarr['pageup']);
		$this->assign('pagedown', $readarr['pagedown']);
		$this->assign('recommends', $readarr['recommends']);
		$this->assign('ctlist', $carr['list']); 
		$this->assign('page', $carr['page']);
		$this->assign('relalist', $this->relaread('News',$readarr['id'],'RelaNewsView'));   
		$this->assign('title', $title='');      
        $this->display();                             
       }
   
   public function tag() {//获取相关标签
         $this->getags('News','NewstagView');
         $this->display();
    }	
   public function add(){
		$this->adddata('Comment');
		}
  public function tourl(){
	  $this->gettourl('Comment');
      }
   }
?>