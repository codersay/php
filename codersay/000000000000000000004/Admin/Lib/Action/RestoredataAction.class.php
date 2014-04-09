<?php
/**
 * @数据还原管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class RestoredataAction extends CommonAction{
	public function index(){
		$datadir = 'backupdata/';
		$data = scandir($datadir); 
		for($i=0; $i<count($data); $i++){
			if($data[$i] != "." && $data[$i] != ".."){
				if(stristr($data[$i],'rui_')){
					$datarow[] = $data[$i];
				}
			}
		}
		$bakfiles=array();
		foreach ($datarow as $k => $v) {
			$bakfiles[$k]['filename']=$v;//备份文件名
			$bakfiles[$k]['time']=$this->getdatacreattime($v);//创建备份时间
			$bakfiles[$k]['part']=$this->part($v);//分卷号
		}
	    $this->assign('files',$bakfiles);
		$this->display();
	}

	//导入备份数据
	public function import(){
		if($_GET['file']){
			$sqlfile=trim($_GET['file']).".sql";
			if($this->imdata($sqlfile)){
				$this->success('备份数据已经成功导入！');
			}
	    }
	}

	//删除备份文件
	public function del(){
		$datadir = 'backupdata/';
		if($_GET['file']){
			$sqlfile=trim($_GET['file']).".sql";
			if(!unlink($datadir.$sqlfile)){
				$this->error('删除备份文件失败！');
			}
			else{
				$this->success('删除备份文件成功！');
			}
	    }
	}

	//导入数据
	private function imdata($filename){
		$Boolean = preg_match("/_part/",$filename);
		$datadir = 'backupdata/';
		if($Boolean){
			$fn = explode("_part", $filename);  
			$backup = scandir($datadir);	 
			for($i=0; $i<count($backup); $i++){
				$part = preg_match("/{$fn[0]}/", $backup[$i]); 
				if($part){
					$filenames[] = $backup[$i];
				}
			}
		}
			
		if(is_array($filenames)){
			foreach($filenames as $fn){
				$data .= file_get_contents($datadir . $fn);  //获取数据
			}
		}else{
			$data = file_get_contents($datadir . $filename);
		}
		
		$data = str_replace("\r", "\n", $data);
		$regular = "/;\n/";
		$data = preg_split($regular,trim($data));
		
		$obj = new Model();
		foreach($data as $val){
			$obj->query($val);
		}
		return true;
	}

	//获取备份时间
	private function getdatacreattime($tb){
		if(!preg_match("/_part/", $tb)){            
			$str = explode(".", $tb);         
			$time = substr($str[0],-10);      
			//设置用在脚本中所有日期/时间函数的默认时区。   
			Date_default_timezone_set("PRC");   
			return date("Y-m-d H:i:s",$time);   
		}
		else{       
			//分卷   
			$str = explode("_part", $tb);     
			$time = substr($str[0],-10);  
			  Date_default_timezone_set("PRC");   
			return date("Y-m-d H:i:s",$time);   
		}    
	}

	//获取分卷
	public function part($tb){                  
		if(!preg_match("/_part/", $tb)){                 
			return "1";             
		}
		else{             
			$str = explode(".", $tb);               
			return substr($str[0],-1);            
		}    
	}
}
?>