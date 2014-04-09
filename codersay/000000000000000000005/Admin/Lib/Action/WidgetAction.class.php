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
// $Id$
class WidgetAction extends CommonAction {
	function config(){
		$this->display();
	}
	function blogconfig(){
		$this->display();
	}
	function server(){
		$this->display();
	}
	
	function save(){
		$data=$_POST;
		$file=$data['file'];
		unset($data['file']);
		unset($data['__hash__']);
		if($file=='widgetconfig.inc.php'){	
			if($data['hot']=='')$data['hot']=8;
			if($data['rand']=='')$data['rand']=8;
			if($data['tags']=='')$data['tags']=8;
			if($data['newscommnts']=='')$data['newscommnts']=8 ;
				
		}		
		
		$content = "<?php\r\n//w3note.com 网站配置文件\r\nif (!defined('THINK_PATH')) exit();\r\nreturn array(\r\n";
        //获取数组
		foreach ($data as $key=>$value){
			$key=strtoupper($key);
			if(strtolower($value)=="true" || strtolower($value)=="false" || is_numeric($value))
				$content .= "\t'$key'=>$value, \r\n";
			else
				$content .= "\t'$key'=>'$value',\r\n";
				
			C($key,$value);
		}
		$content .= ");\r\n?>";
		
      	$r=@chmod($file,0777);
		$hand=file_put_contents(CONF_PATH.'widgetconfig.inc.php',$content);
		if (!$hand) {
			$this->error('文保存失败！');
		}else{
		   $cachefile = RUNTIME_PATH.'~runtime.php';
		   if(is_file($cachefile)) $result=unlink($cachefile);
       	   if($result){
			   $this->success('文件保存成功!');
		   }else{
			   $this->success('文件保存成功!');
			   }
		}
	}
}
?>