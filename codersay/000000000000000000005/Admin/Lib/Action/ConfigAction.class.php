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
class ConfigAction extends CommonAction {
	function config(){
		//echo CONF_PATH;
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
		if($file=='siteconfig.inc.php'){	
			if($data['sitename']=='')$data['sitename']='WBlog博管系统' ;
			
			$arrurl=explode("/",$_SERVER["PHP_SELF"]);
			if($arrurl['1']=='admin.php'){
              $rooturl='http://'.$_SERVER['SERVER_NAME'].'/';
            }else{
             $rooturl='http://'.$_SERVER['SERVER_NAME'].'/'.$arrurl['1'].'/';
            }
			if($data['domainname']=='')$data['domainname']=$rooturl;
			if($data['rooturl']=='')$data['rooturl']=$rooturl;
			if($data['cssurl']=='')$data['cssurl']=$rooturl.'Public/Css/';
			if($data['jsurl']=='')$data['jsurl']=$rooturl.'Public/Js/' ;
			if($data['imgurl']=='')$data['imgurl']=$rooturl.'Public/Images/';
			if($data['metakeys']=='')$data['metakeys']='网志博客' ;
			if($data['metadesc']=='')$data['metadesc']='本系统采用目前流行的开源框架THINKPHP开发' ;
			if($data['weiboname']=='')$data['weiboname']='网志博管系统' ;
			if($data['weibokeys']=='')$data['weibokeys']='网志博客' ;
			if($data['weibodesc']=='')$data['weibodesc']='本系统采用目前流行的开源框架THINKPHP开发' ;
			if($data['pagesize']=='')$data['pagesize']='15' ;
			if($data['email']=='')$data['email']='1211150392@qq.com' ;
			if($data['contact']=='')$data['contact']='网菠萝果' ;
			if($data['company']=='')$data['company']='w3note' ;
			if($data['icp']=='')$data['icp']='' ;
			if($data['phone']=='')$data['phone']='0779-******' ;
			if($data['address']=='')$data['address']='广西北海' ;
			//缩略图配置
			if($data['thumb_w']=='')$data['thumb_w']=100 ;//缩略图默认宽度
			if($data['thumb_h']=='')$data['thumb_h']=100 ;//缩略图默认长度
			if($data['image_w']=='')$data['image_w']=700 ;//图片默认宽度
			if($data['image_h']=='')$data['image_h']=700 ;//图片默认长度
			if($data['maxsize']=='')$data['maxsize']=3 ;//上传文件大小
			if($data['iswater']=='')$data['iswater']=0 ;//添加水印
			//if($data['thumb_maxsize']=='')$data['thumb_maxsize']=10240 ;//默认图片大小
			if($data['allowexts']=='')$data['allowexts']='jpg,png,gif,jpeg,rar,zip' ;//默认允许上传的文件类型
		
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
		$hand=file_put_contents(CONF_PATH.'siteconfig.inc.php',$content);
		if (!$hand) {
			$this->error($file.'配置文件写入失败！');
		}else{
		   $cachefile = RUNTIME_PATH.'~runtime.php';
		   if(is_file($cachefile)) $result=unlink($cachefile);
       	   if($result){
			   $this->success('配置文件保存成功!更新成功!');
		   }else{
			   $this->success('配置文件保存成功!');
			   }
		}
	}
}
?>