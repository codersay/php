<?php
	class ThemesAction extends CommonAction{
		
		public function _before_index(){
			$app_name = 'applications';
			$root_path = __ROOT_PATH__;
			$theme_path = $root_path . '/' . $app_name . '/themes/';
			import( 'ORG.Io.fileDirUtil' );
			$dir = new fileDirUtil();
			$list = $dir->dirNodeTree( $theme_path );
			
			$s = require ( $root_path . '/configs/settings.inc.php' );
			
			$array = array();
			foreach ( $list as $key => $val ) {
				$array[$key]['name'] = $val;
				$array[$key]['path'] = $theme_path . $val;
				if ( !file_exists( $theme_path . $val . '/info.php' ) ){
					$theme_info = 0;
				}else{
					$theme_info = require($theme_path . $val . '/info.php');
				}
				$array[$key]['info'] = $theme_info;
				//$array[$key]['thumb'] = $theme_path . $val . '/thumb.jpg';
				$array[$key]['thumb']	= __ROOT__ . '/' . $app_name . '/themes/' . $val . '/thumb.jpg';
			}
			$this->assign('cur_theme',$s['DEFAULT_THEME']);
			$this->assign('themes',$array);
		}
		
		public function updateTheme(){
			$conf_path = __ROOT_PATH__ . '/configs/settings.inc.php';
			$array = require( $conf_path );
			$dirname = dirname( $conf_path );
			if ( !is_dir( $dirname ) ){
				$this->error( '配置文件'.$conf_path.'不存在！' );
			}
			if ( !empty( $_POST['themes'] ) ){
				$array['DEFAULT_THEME'] = $_POST['themes'];
				$conf_content = "<?php\nreturn ".var_export($array, true).";";
				if ( file_put_contents( $conf_path, $conf_content ) ){
					$this->success( '成功设置主题为"' . $_POST['themes'] . '"！' );
				}else{
					$this->error( '设置主题为"' . $_POST['themes'] . '"失败！' );
				}
			}
			
		}
		
		public function settings(){
			$name = $this->_get('name');
			$path = __ROOT_PATH__ . '/applications/themes/' . $name . '/';
			$define = $path . 'plugin_define.php';
			if ( !is_file( $define ) ){
				$this->error('此模板没有可设置项目！');
			}else{
				$var = require_once ( $define );
				if ( empty( $var ) ){
					$this->error('此模板没有可设置项目！');
				}
				require_once ( $path . 'plugin.php' );
				$this->assign( 'themeName', $name );
				$this->assign( 'settings', $var );
				$this->display();
			}
		}
		
		public function setPlugin(){
			$name = $this->_get('name');
			$file = __ROOT_PATH__ . '/applications/themes/' . $name . '/plugin_define.php';
			$define = require( $file );
			if ( !is_file( $file ) ){
				$this->error('插件配置文件不存在！');
			}
			$status = $this->_get('status');
			$root = $this->_get('root');
			$vals = $this->_get('vals');
			$define[$root]['value'][$vals]['status'] = $status;
			$content = "<?php\nreturn ".var_export($define, true).";";
			if ( file_put_contents( $file, $content ) ){
				$this->success( '设置完成！' );
			}else{
				$this->error( '设置失败！' );
			}
		}
		
	}
