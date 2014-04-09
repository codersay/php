<?php
     //开启调试模式
      define('APP_DEBUG',true);
     //前台目录
     define('APP_PATH', './W3note/');
     define('W3CORE_PATH','./ThinkPHP');
	 if(!is_file('./install/install.php')){
	 require W3CORE_PATH.'/ThinkPHP.php';
	 }else{
		header('Location: ./install/index.php');
		 }
?>

