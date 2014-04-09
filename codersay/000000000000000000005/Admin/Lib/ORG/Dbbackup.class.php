<?php

	/**
	 * 数据库备份程序
	 * @author：w3note.com
	 * @lastupdate：2012-9-18
	 *注：此类部分来源于网络
	 */
	class dbbackup{

			private $dbhost;//数据库主机

			private $dbuser;//数据库用户名
		
			private $dbpwd;//数据库密码
		
			private $dbname;//数据库名
		
			private $coding;//数据库编码,GBK,UTF8,gb2312

			private $conn;//数据库连接标识

			private $data_dir = 'data/';//文件夹路径（存放备份数据）

			private $part = 2048;//分卷长度（单位KB）

			public $bakfn;//备份文件名


		public function __construct($dbhost, $dbuser, $dbpwd, $dbname, $coding = 'UTF8',$pconnect = 0){
			$this->init();
			$this->dbhost = $dbhost;
			$this->dbuser = $dbuser;
			$this->dbpwd =  $dbpwd;
			$this->dbname = $dbname;
			$this->coding = $coding;
			$this->connect();
			$this->part = $this->part * 1024; //设置分卷长度,单位为KB
			$this->cre_dir();  				  //创建文件夹
		}

		
		private function init(){
			set_time_limit(0);					//程序执行不限时
			error_reporting(E_ERROR | E_PARSE); //报错级别
		}

		
		private function connect(){
			
			if($pconnect==0){
				$this->conn =@mysql_pconnect($this->dbhost, $this->dbuser, $this->dbpwd);
				}else{
				$this->conn =@mysql_pconnect($this->dbhost, $this->dbuser, $this->dbpwd);	
			}
			if(!$this->conn){
				echo '<font color="red">错误提示：链接数据库失败！</font>';
				exit();
			}

			if(!@mysql_select_db($this->dbname, $this->conn)){
				echo '<font color="red">错误提示：打开数据库失败！</font>';
				exit();
			}

			if(!@mysql_query("SET NAMES $this->coding")){
				echo '错误提示：设置编码失败！';
			}
		}

		
		private function cre_dir(){
			//文件夹不存在则创建
			if(!is_dir($this->data_dir)){
				mkdir($this->data_dir, 0777);
			}
		}

		
		public function gettbinfo(){
			if ($res=mysql_query("SHOW TABLE STATUS FROM ".$this->dbname."")){  

               while($row=mysql_fetch_array($res)) {
			      $arrtbinfo[]=$row;
			    }
			   
            } 

			
			return $arrtbinfo; //返回表集合
		}

		
		public function get_backupdata($arrtb){
			$backupdata = "#\n# WBlog bakfile\n#Time: ".date('Y-m-d H:i',time())."\n# Type: \n# w3note: http://www.w3note.com\n# --------------------------------------------------------\n\n\n"; //存储备份数据
			foreach($arrtb as $tb){
				//获取表结构
				$query = mysql_query("SHOW CREATE TABLE $tb");
				$row = mysql_fetch_row($query);
				$backupdata .= "DROP TABLE IF EXISTS $tb;\n" . $row[1] . ";\n\n";
				//获取表数据
				$query = mysql_query("select * from $tb");
				$numfields = mysql_num_fields($query); //统计字段数
				
				while($row = mysql_fetch_row($query)){
					$comma = ""; 
					$backupdata .= "INSERT INTO $tb VALUES (";
					for($i=0; $i<$numfields; $i++){
											  	 
						$backupdata .= $comma . "'" . mysql_escape_string($row[$i]) . "'";
						$comma = ",";
					}
					$backupdata .= ");\n";
					
					if(strlen($backupdata) > $this->part){
						$arrbackupdata[] = $backupdata;
						$backupdata = ''; 
					}
				}
				$backupdata .= "\n"; 
			}
			
			if(is_array($arrbackupdata)){
				
				array_push($arrbackupdata, $backupdata);
				return $arrbackupdata; 
			}
			return $backupdata; 
		}

		
		private function wri_file($data){
			
			if(is_array($data)){
				$i = 1;
				foreach($data as $val){
					
					$filename = $this->data_dir . "wb_" . time() . "_part{$i}.sql"; //文件名
					if(!$fp = @fopen($filename, "w+")){ echo "在打开文件时遇到错误,备份失败!"; return false;}
					if(!@fwrite($fp, $val)){
						echo "在写入信息时遇到错误,备份失败!"; fclose($fp); //需关闭文件才能删除
						unlink($filename); //删除文件
						return false;}
					$this->bakfn[] = "wb_" . time() . "_part{$i}.sql"; //备份成功则返回文件名数组
					$i++;
				}
			}else{ //单独备份
				$filename = $this->data_dir . "wb_" . time() . ".sql";
				if(!$fp = @fopen($filename, "w+")){ echo "在打开文件时遇到错误,备份失败!"; return false;}
				if(!@fwrite($fp, $data)){
					echo "在写入信息时遇到错误,备份失败!"; fclose($fp);
					unlink($filename);
					return false;}
				$this->bakfn = "wb_" . time() . ".sql"; 
			}
			fclose($fp);
			return true;
		}

		
		public function export($data){
			return $this->wri_file($data); //写入数据
		}

		public function get_backup(){
			$backup = scandir($this->data_dir); 
			for($i=0; $i<count($backup); $i++){
				if($backup[$i] != "." && $backup[$i] != ".."){
					if(stristr($backup[$i], 'wb_')) $arrbackup[] = $backup[$i];
									
				}
			}
			return $arrbackup;
		}

		public function import($filename){
			
			$Boolean = preg_match("/_part/",$filename); 		   
			if($Boolean){
				$fn = explode("_part", $filename);				  
				$backup = scandir($this->data_dir);	    		  
				for($i=0; $i<count($backup); $i++){
					$part = preg_match("/{$fn[0]}/", $backup[$i]); 
					if($part){
						$filenames[] = $backup[$i];
					}
				}
			}
			
			if(is_array($filenames)){
				foreach($filenames as $fn){
					$data .= file_get_contents($this->data_dir . $fn);  //获取数据
				}
			}else{
				$data = file_get_contents($this->data_dir . $filename);
			}
			
			
			$data = str_replace("\r", "\n", $data);
			$regular = "/;\n/";
			$data = preg_split($regular,trim($data));
		
			foreach($data as $val){
				mysql_query($val) or die('导入数据失败！' . mysql_error());
			}
			return true;
			
		}

		
		public function del($delfn){
			
			if(is_array($delfn)){
				foreach($delfn as $fn){
					if(!unlink($this->data_dir.$fn)){ return false;}
				}
				return true;
			}
			
			return unlink($this->data_dir.$delfn);
		}

	}

?>





