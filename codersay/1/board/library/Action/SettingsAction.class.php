<?php
	class SettingsAction extends CommonAction{
		public function _before_index(){
			$array = require( __ROOT_PATH__ . '/configs/settings.inc.php' );
			$this->assign( 'conf', $array );
		}
		
		public function updateSettings(){
			$conf_path = __ROOT_PATH__ . '/configs/settings.inc.php';
			$array = require( $conf_path );
			$dirname = dirname( $conf_path );
			if ( !is_dir( $dirname ) ){
				$this->error( '配置文件'.$conf_path.'不存在！' );
			}
			foreach ( $_POST['conf'] as $key => $val ) {
				$array[$key] = trim( $val );
			}
			$conf_content = "<?php\nreturn ".var_export($array, true).";";
			if ( file_put_contents( $conf_path, $conf_content ) ){
				$this->success( '修改配置成功！' );
			}else{
				$this->error( '写入"' . $conf_path . '"失败！' );
			}
		}
	}
