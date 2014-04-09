<?php
	class WidgetAction extends Action{
		public function _empty(){
			C('URL_CASE_INSENSITIVE', false);
			$action = h( __ACTION_NAME__ );
			$request = array();
			foreach ($_REQUEST as $key => $value) {
				$request[$key] = h( $value );
			}
			widget( $action, $request['action'], $request );
		}
	}