<?php
/**
 * @数据备份管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class BackupdataAction extends CommonAction{
	public function index(){
		$m = new Model();
		$list = $m->query("SHOW TABLE STATUS FROM "."`".C('DB_NAME')."`");
		$tables = array();
        foreach ($list as $key => $val)
		{
			$tables[$key]['name'] = $val['Name'];//表名
			$tables[$key]['rows'] = $val['Rows'];//记录数
			$tables[$key]['engine'] = $val['Engine'];//引擎
			$tables[$key]['data_length'] = sizecount($val['Data_length']);//表大小
			$tables[$key]['create_time']=$val['Create_time'];//表创建时间
			$tables[$key]['collation']=$val['Collation'];//编码类型
        }
		$this->assign('list',$tables);
		$this->display();
	}

	//数据备份
	public function backup(){
		$tbs = $_POST['tables'];
		$tbstr = implode(',',$tbs);
		if(!$this->isCheckBox($tbstr)){
			$this->error('请选中记录！');
		}
		$filesize = intval($_POST['filesize']);
		if ($filesize < 512) 
		{
			$this->error("每个分卷大小要大于521K！");
		}
		$data = $this->getBackupData($tbs,$filesize);
		if($this->wFile($data)){
			$this->success('备份数据成功！');
		}
		else{
			$this->error('备份数据失败！');
		}
	}

	//获取备份数据
	private function getBackupData($tables,$filesize){
		$data = '';
		foreach($tables as $tab){
			$obj = M(str_replace(C('DB_PREFIX'),'',$tab));//实例化一个表模型
			$row = $obj->query("SHOW CREATE TABLE $tab");
			$data .= "DROP TABLE IF EXISTS `".$tab."`;\n" . $row[0]['Create Table'] . ";\n";
			$datalist = $obj->select();
			foreach($datalist as $val){
				$data .= "INSERT INTO `".$tab."` VALUES (";
				$vals = array();
				foreach($val as $v){
					$vals[] = "'" . mysql_real_escape_string($v) . "'";
				}
				$data .= implode(', ', $vals) . ");\n"; 
			}
			$data .= "\n";
			if(strlen($data) > $filesize*1024){
				$datarow[] = $data;
				$data = ''; 
			}
		}
		//将最后部分的sql放入数组
		if(is_array($datarow)){
			array_push($datarow, $data);
			return $datarow; 
		}
		return $data;
	}

	//写入文件
	private function wFile($data){
		$datadir = 'backupdata/';
		if(is_array($data)){
			$i = 1;
			foreach($data as $val){
				$filename = $datadir . "rui_" . time() . "_part{$i}.sql"; //文件名
				if(!$fp = @fopen($filename, "w+")){ 
					echo "<font coloe='red'>提示：在打开文件时遇到错误！</font>"; 
					return false;
				}
				if(!@fwrite($fp, $val)){
					echo "<font color='red'>提示：在写入信息时遇到错误！</font>"; 
					fclose($fp); //需关闭文件才能删除
					unlink($filename); //删除文件
					return false;
				}
				$i++;
			}
		}
		else{ //单独备份
			$filename = $datadir . "rui_" . time() . ".sql";
			if(!$fp = @fopen($filename, "w+")){ 
				echo "<font coloe='red'提示：>在打开文件时遇到错误!</font>"; 
				return false;
			}
			if(!@fwrite($fp, $data)){
				echo "<font color='red'>提示：在写入信息时遇到错误!</font>"; 
				fclose($fp);
				unlink($filename);
				return false;
			}
		}
		fclose($fp);
		return true;
	}
}
?>