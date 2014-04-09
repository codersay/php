<?php
/**
 * @缓存管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class ClearcacheAction extends CommonAction{
	public function index(){
		$this->display();
	}

	//清空缓存
	public function clear(){
		$type=trim($_GET['type']);
		if(empty($type)) {
			$this->error('请选择缓存类型！');
		}
		switch($type) {
		case 1:// 前台清空所有缓存             
			$path = C('CACHE_WEB');
			break;
		case 2:// 前台清空数据缓存
			$path = C('CACHE_WEB').'Temp';
			break;
		case 3://  前台清空数据目录
			$path = C('CACHE_WEB').'Data/_fields';
			 break;
		case 4:// 前台清空模板缓存
			 $path = C('CACHE_WEB').'Cache';
			break;
		case 5:// 后台清空所有缓存             
			 $path = C('CACHE_ADMIN');
			break;
		case 6:// 后台清空数据缓存   
			$path = C('CACHE_ADMIN').'Temp';
			break;
		case 7://后台清空数据目录
			$path = C('CACHE_ADMIN').'Data/_fields';
			break;
		case 8://后台清空模板缓存
			$path = C('CACHE_ADMIN').'Cache';
			break;
		}
		if(is_dir($path)){
			$this->delDir($path);
			$this->success('清理成功！');
		}
		else{
			$this->error('已清空！');
		}
	}

	//删除目录
	private function delDir($dirName)
	{
		if (!file_exists($dirName)){
			return false;
		}
		$dir = opendir($dirName);
		while ($fileName = readdir($dir)){
			$file = $dirName . '/' . $fileName;
			if ($fileName != '.' && $fileName != '..') {
				if (is_dir($file)){
					$this->delDir($file);
				} 
				else {
					unlink($file);
				}            
			}
		}
		closedir($dir);
		return rmdir($dirName);
	}
}
?>