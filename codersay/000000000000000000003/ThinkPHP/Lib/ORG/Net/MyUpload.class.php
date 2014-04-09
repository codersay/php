<?php
	/**
	* Upload file class.
	* @author ZhaoHuan.
	*/ 
	class MyUpload{
		var $file_name; // source file path on client.
		var $file_tmp_name; //temp file path on server.
		var $file_uploaded_name; // new file name.
		var $file_type;     //file's type.
		var $file_size;     //file's size.
		var $max_file_size; //maximumm file size.unit is Mb.
		var $allow_types;  //type of files allowed.
		var $upload_base_dir;  //destination directory. 
		var $file_new_path;   //file's new path on server.
		var $errors;      //errors.
		var $source;		//资源名，在错误信息中使用

		/* construct function. */
		function __construct($file_name, $file_tmp_name, $file_size, $allow_types="avi|flv", $max_file_size="20") {
			$this->file_name = $file_name;
			$this->file_tmp_name = $file_tmp_name;
			$this->file_size = $file_size;
			$this->max_file_size = $max_file_size;
			$this->allow_types = $allow_types;
		}

		function set_source($source) {
			$this->source = $source;
		}

		/* check whether there is a file to upload or not. */
		function check_file_none() {
			if($this->file_name == "") {
				$this->errors = "请选择要上传的文件";
				return false;
			}
			return true;
		}

		/* set destination directory. */
		function set_upload_base_dir($upload_base_dir) {
			$this->upload_base_dir = $upload_base_dir;
		}
	
		/* get the type of the file to be uploded. */
		function get_file_type() {
			$basename = basename($this->file_name);
			$infos = explode(".", $basename);
			$this->file_type = $infos[count($infos) - 1];
		}
		
		/* check whether the size of the file is too big or not. */
		function check_file_size() {
			$max_size = $this->max_file_size * 1024 *1024;	
			if($this->file_size > $max_size) {
				$this->errors .= $this->source."大小不能超过".$this->max_file_size."M";
				return false;
			}else {
				return true;
			}
		}

		/* check whether the type of the file is allowed or not. */
		function check_file_type() {
			$pos = strpos($this->allow_types, strtolower($this->file_type));
			if($pos === false) {
				$this->errors .= $this->source."只能是".strtoupper(str_replace("|", ",", $this->allow_types))."类型的文件";
				return false;
			}else {
				return true;
			}
		}

		/* set the new path of the uploaded file. */
		function set_file_uploaded_name() {
			list($usec, $sec) = explode(" ", microtime());
			$microtime = $sec.substr($usec, 2);
			$this->file_uploaded_name = $microtime.".".$this->file_type;
			$this->file_new_path = $this->upload_base_dir.$this->file_uploaded_name;
		}

		/* move temp file to destination directory. */
		function upload_file() {
			if( $this->check_file_none() ) {
				$this->get_file_type();
				if($this->check_file_type()) { // check file's type
					
					if($this->check_file_size()) {  // check file's size
						$this->set_file_uploaded_name();
						if(move_uploaded_file($this->file_tmp_name, $this->file_new_path)) {
							return true;
						}else {
							$this->errors .= $this->source."上传失败";
							return false;
						}
					}else {
						return false;
					}
	
				}else {
					return false;
				}
			}else {
				return false;
			}
		}
	}
?>