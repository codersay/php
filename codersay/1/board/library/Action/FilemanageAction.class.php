<?php

	class FilemanageAction extends CommonAction{
		public function viewlist(){
			import("ORG.Net.Keditor");
			$root_path = __ROOT_PATH__ . "/".C('WEB_PUBLIC_PATH') . "/".C('DIR_ATTCH_PATH')."/";
			$root_url = __ROOT__."/".C('WEB_PUBLIC_PATH') . "/".C('DIR_ATTCH_PATH')."/";
			$ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp', 'mov', 'swf');
			Keditor::filemanager($root_path,$root_url,$ext_arr);
		}
	}
