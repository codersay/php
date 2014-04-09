<?php
class PageAction extends CommonAction {
	public function index() {
		$vo=$this->getone('Page',array('id'=>$_GET['id']));
		$this->assign('vo',$vo);
		$this->display();
    }
	 public function about() {
		$about = M("Page");
		$vo = $about->where(array('id'=>1))->find();
		 $about->where('id='.$vo['id'])->setInc("hits",1);
		$this->assign('vo',$vo);
		$this->display();
		
    }
	//下载
	public function getDownload() {
        //读取附件信息
           $id = $_GET['id'];
           $Attach = M('Attach');
		   $map['module']="Page";
           $attachs = $Attach->where($map)->order('uploadTime desc')->select();
            //模板变量赋值
           $this->assign("attachs", $attachs ? $attachs : '');
       }

      public function download() {
		   import("ORG.Util.Http");
          $id = $_GET['id'];
          $dao = M("Attach");
          $attach = $dao->where("id=" . $id)->find();
          $filename = $attach["savepath"] . $attach["savename"];
		  //$filename = $attach['url'];
        if (is_file($filename)) {
            if (!isset($_SESSION['attach_down_count_' . $id])) {
                $dao->setInc('downcount', "id=" . $id);
                $_SESSION['attach_down_count_' . $id] = true;
            }
            Http::download($filename, $attach->name);
        }
    }
	
   }
?>