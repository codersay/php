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
if (empty($_SESSION[C('USER_AUTH_KEY')])) exit();
class ClearAction extends Action {
    
	 public function index(){
         
          $this->display();

	 }
	 
	 public function del(){   
		$type=trim($_GET['type']);
		if(empty($type)) $this->error('请选择缓存类型！');
		
            switch($type) {
            case 1:// 全部清空             
				 $path   =   RUNTIME_PATH;
                break;
            case 2:// 文件缓存目录
                $path   =   RUNTIME_PATH.'Temp';
                break;
			case 3://  前后台数据缓存目录
                $path   =   RUNTIME_PATH.'Data'.DIRECTORY_SEPARATOR.'_fields';
				 break;
            case 4:// 全部模板缓存
                 $path  =  RUNTIME_PATH.'Cache';
                break;
            case 5:// 前台模板缓存             
				 $path   =  C('CACHE_HOME');
                break;
            case 6:// 后台模板缓存   
                $path   =  C('CACHE_ADMIN');
                break;
            }
       
         import("@.ORG.Dir");
		
	    if(!Dir::isEmpty($path)){
		 Dir::del($path);
		 //echo $path."aa";
		 $this->success('更新成功');
		 }else{
			 //echo $path."dd";
			 //Dir::del($path);
			 $this->error('已清空！');
		}
    }	
}

?>