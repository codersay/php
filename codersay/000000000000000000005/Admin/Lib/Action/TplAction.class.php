<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
if (empty($_SESSION[C('USER_AUTH_KEY')])) exit();
class TplAction extends Action {
	
	public function index() {
		import("@.ORG.Dir");
		$tpl=C('TPL_PATH');
		$list=new Dir($tpl,$pattern='*');
		$tpldir=array();
		foreach ($list as  $k => $v){
			$tpldir[$k]['tplname']= $v['filename'];
			$tpldir[$k]['path']= $v['path'];	
		}
		//dump($tpldir);
		$this->assign('tpldir',$tpldir);
		$this->assign('tpl_dir',$tpldir['0']['path']);
		$this->display();
		
	}
	public function tpl() {
		if(empty($_GET['dir'])) $this->error('模块不存在!');
		$dir=trim($_GET['dir']);
		import("@.ORG.Dir");
		$tpl=C('TPL_PATH').$dir;
		if(!is_dir($tpl)) $this->error('目录不存在!');
		$list=new Dir($tpl,$pattern='*');
		//dump($list);
		$files=array();
		foreach ($list as  $k => $v){
			$files[$k]['filename']= $v['filename'];
			$files[$k]['size']= $v['size'];
			$files[$k]['ctime']= $v['ctime'];
			$files[$k]['path']= $v['path'];
		}
		
		$this->assign('tpldir',$files['0']['path']);
		$this->assign('dir',$dir);
		$this->assign('files',$files);
		$this->display();/**/
		
	}
	public function insert(){
		if(empty($_GET['tplname']) && empty($_GET['dir'])) $this->error('模板不存在!');
		$tplname=trim($_GET['tplname']);
		$dir=trim($_GET['dir']);
	
			$tpl=C('TPL_PATH').$dir.DIRECTORY_SEPARATOR.$tplname.'.html';
			if(is_file(!$tpl)) $this->error('模板不存在!');
			$content=@file_get_contents($tpl);
			
			$this->assign('tplname',$tplname);
			$this->assign('tpldir',$dir);
			$this->assign('content',str_replace('</textarea>','&lt;/textarea>',$content));
			$this->display();
		
	}
	// 更新数据
	public function update(){
		if(empty($_POST['tplname'])&& empty($_POST['tpldir'])&& empty($_POST['content'])) $this->error('模板路径有误!');
		$tplname=$_POST['tplname'];
		$tpldir=$_POST['tpldir'];		
		
		$tpl=C('TPL_PATH').$tpldir.DIRECTORY_SEPARATOR.$tplname.'.html';	
		@file_put_contents($tpl,str_replace('&lt;/textarea>','</textarea>',stripslashes($_POST['content'])));
		$this->success('恭喜您,模板更新成功！');
		
	}
	
}
?>