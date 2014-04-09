<?php
	class PublicAction extends Action{
		public function _empty(){
			// 插件单向操作转换操作。
			C('URL_CASE_INSENSITIVE', false);
			$action = h( __ACTION_NAME__ );
			$request = array();
			foreach ($_REQUEST as $key => $value) {
				$request[$key] = h( $value );
			}
			//addFreePlugin( $action, $request['hook'], $request );
			importPluginHook();
			Addons::addonsHook($action,$request['hook'], $request);
		}
	}