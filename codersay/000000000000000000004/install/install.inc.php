<?php
function getIp(){
	if (isset ($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$onlineip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}elseif (isset ($_SERVER['HTTP_CLIENT_IP'])){
		$onlineip = $_SERVER['HTTP_CLIENT_IP'];
	}else{
		$onlineip = $_SERVER['REMOTE_ADDR'];
	}
	$onlineip = preg_match('/[\d\.]{7,15}/', addslashes($onlineip), $onlineipmatches);
	return $onlineipmatches[0] ? $onlineipmatches[0] : 'unknown';
}

function add_Slashes(&$array){
	if (is_array($array)){
		foreach ($array as $key => $value){
			 add_Slashes($array[$key]);
		}
	}elseif (is_string($array)){
		$array = addslashes($array);
	}
}

function isWriteable($var){
	$writeable = FALSE;
	$var = ROOT_PATH . '/' . $var;
	if(!is_dir($var)){
		@mkdir($var, 0777);
	}
	if (is_dir($var)){
		$var .= '/temp.txt';
		if (($fp = @fopen($var, 'w')) && (fwrite($fp, 'By_Rui'))){
			fclose($fp);
			@unlink($var);
			$writeable = TRUE;
		}
	}
	return $writeable;
}

function getResult($result = 1, $output = 1){
	if($result){
		$text = '&nbsp;&nbsp;(<span class="blue">OK</span>)';
		if(!$output){
			return $text;
		}
		echo $text;
	}else{
		$text = '&nbsp;&nbsp;(<span class="red">NO</span>)';
		if(!$output){
			return $text;
		}
		echo $text;
	}
}

function createTable($sql, $db_charset){
	$db_charset = (strpos($db_charset, '-') === FALSE) ? $db_charset : str_replace('-', '', $db_charset);
	$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
	$type = in_array($type, array("MYISAM", "HEAP")) ? $type : "MYISAM";
	return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).(mysql_get_server_info() > "4.1" ? " ENGINE=$type DEFAULT CHARSET=$db_charset" : " TYPE=$type");
}
?>