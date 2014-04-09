<?php
/*
 * 
 * 
 */
class GetImage{
	private $savePath = './static/uploads/';//设置当前存放路径
	private $limitTime = 3600;
	
	public function __construct(){
		$this->check_save_patch();
	}
	/*
	*自定义储存目录
	*/
	public function set_save_patch($savePath=''){
		if(!empty($savePath))
			$this->savePath = $savePath;
	}
	/*
	*检查储存目录是否存在,如果不存在则建立储存目录
	*/
	 private function check_save_patch(){
		if(@is_dir($this->savePath)===false)
			$this->folder();
	}
	/*
	*建立储存文件夹
	*/
	private function folder(){
		$result = @mkdir($this->savePath,0777);
		if($result === false)
			return $this->message(777);
	}
	
	/*
	*按日期建立文件夹
	*/
	private function build_date_folder(){
		$folder = $this->savePath.date('Ymd');
		$result = @mkdir($folder,0777);
		if($result == true)
			return $folder.'/';
		else{
			if(@is_dir($folder))
				return $folder.'/';
			else
				return $this->message('请检查是否可以建立文件夹,如果linux操作系统请将目录的属性改为777!');
		}
	}
	/*
	*下载远程图片
	*/
	
	public function down($url,$type){
		$this->set_limit_time();
		$file = @file_get_contents($url);
		if($file){
			$folder = $this->check_save_patch().$this->build_date_folder();			
			$name = $this->bulid_name($url,$type);
			$fp = @fopen($folder.$name,'w+');
			if(@fwrite($fp,$file) ){
				@fclose($fp);
				return $folder.$name;
			}else{
     			//return $this->message('下载失败');
     			return '';
    		}
   		}else{
    		//return $this->message('获取文件失败!');
    		return '';
   		}	
	}
	/*
	*生成新的图片名
	*/
	private function bulid_name($url,$type){
		/*$arr = getimagesize($url);
		$name = explode('/',$arr['mime']);
		if(!is_array($name))
			$name = array('gif','jpg');
		return $file_name = date('Ymd').time().'.'.$name[1];*/
		$new_url_array = explode( '/' , $url );
		return $type . '_' . $new_url_array[count($new_url_array) - 1];
	}
	/*
	*建立下载超时时间
	*/
	public function set_limit_time($limitTime=''){
		if(!empty($limitTime))
			$this->limitTime = $limitTime;
		set_time_limit($this->limitTime);
	}
	/*
	* 错误信息
	*/
	private function message($message){
		return $message;
	}
}
?>