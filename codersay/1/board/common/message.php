<?php
	function issetURLName( $str ){
		$model = M('Archives');
		$value = $str;
		if ( $value ){
			$dbpre = C('DB_PREFIX');
			$data = $model->table($dbpre."archives archives, ".$dbpre."category category")
				->field("archives.url_name, category.channel")
				->where("archives.url_name='".$value."' OR category.channel='".$value."'")
				->find();
			if ( !empty($data['url_name']) || !empty($data['channel']) ){
				return false;
			}else{
				return true;
			}
		}
	}
?>