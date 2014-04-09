<?php
	class ArchivesModel extends CommonModel{
		protected $_validate = array(
			//array('title','require','标题名称必须！'),
		);
	
		protected $_auto		=	array(
	        array('summary','checkSummary',3,'callback'),
	        array('thumb','checkThumb',3,'callback'),
	        array('content','stripslashes',3,'function'),
	        array('status','checkStatus',3,'callback'),
	        array('author','authorAuto',self::MODEL_INSERT,'callback'),
			array('create_time','time',self::MODEL_INSERT,'function'),
			array('update_time','time',self::MODEL_UPDATE,'function'),
		);
		
		public function checkStatus(){
			if ( !isset($_POST['status']) ){
				return 1;
			}else{
				return intval($_POST['status']);
			}
		}
		
		public function authorAuto(){
			return $_SESSION['AUTH']['id'];
		}
		
		public function checkSummary(){
			/*if (!isset($_POST['summary'])){
				$summary = cn_substr(strip_tags(stripslashes($_POST['content'])),300);
				return preg_replace("/[\s]{2,}/", "", $summary);
			}else{
				return stripslashes($_POST['summary']);
			}*/
			if (!isset($_POST['summary'])){
				$summary = explode( '[separator]', stripslashes( $_POST['content'] ) );
				return $summary[0];
			}else{
				return stripslashes( $_POST['summary'] );
			}
		}
		
		public function checkThumb(){
			if ( isset( $_SESSION["crop_zoom"] ) ){
				return $_SESSION["crop_zoom"]['foder'] . '/thumb_' . $_SESSION["crop_zoom"]['name'];
			}else{
				if ( isset( $_POST['thumb'] ) ){
					return $_POST['thumb'];
				}else{
					return '';
				}
			}
		}
		
	}
?>