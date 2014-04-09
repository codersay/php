<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// $Id$
class AttachModel extends RelationModel{
	protected $_link = array(
        'Page'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'Page',
           'foreign_key'=>'recordId',//Attach表recordId
           'as_fields'=>'downCount,name',
       ),
    );	
		
	/**
	 * 附件上传:上传图片，缩略图，文件
	 * @param string $model 上传所在模块
	 * @param bool $type 上传文件的类型:：image（图片）；thumb(缩略图)；file(文件)
	 */

	public function upload($model = null, $type = 'image'){
		//导入上传类
		import('ORG.NET.UploadFile');
		$upload = new UploadFile();
        $upload->saveRule = 'uniqid'; //设置上传文件规则
		$upload->maxSize = C('MAXSIZE')*1024*1024;	//上传文件大小	
		$upload->allowExts = explode(',', C('ALLOWEXTS'));//文件类型
	
		if ($model){//判断存放地方是否存在否则新建
			$upload->savePath = './Public/Uploads/'.$model.'/';
			if (!file_exists($upload->savePath)) {
			  mkdir($upload->savePath);
		    }
		}else{
			$upload->savePath = './Public/Uploads/Thumb/';
			if (!file_exists($upload->savePath)) {
			  mkdir($upload->savePath);
			}
		}
		if (in_array($type,array('image','thumb'))){
			$upload->thumb = true;
			$upload->thumbRemoveOrigin  = true;// //删除原图
			$upload->thumbPrefix = 'wb_';	
			$upload->thumbMaxWidth = $type=='thumb' ? C('THUMB_W') :C('IMAGE_W');//缩略图宽度
			$upload->thumbMaxHeight = $type=='thumb' ? C('THUMB_H') :C('IMAGE_H');//缩略图高度	
				
		}
		if (!$upload->upload()) {
			return $upload->getErrorMsg();
		}else{
			$uploadlist = $upload->getUploadFileInfo();
			if(C('ISWATER') && $type=='image'){
			  import('ORG.Util.Image');
              //给m_缩略图添加水印, Image::water('原文件名','水印图片地址')
			  foreach ($uploadlist as $key => $value){
                Image::water($value['savepath'] . 'wb_' . $value['savename'], './Public/admin/images/water.png');
			 }
		    }
		}
		if (in_array($type,array('image','file'))){
			return $this->_add($uploadlist,$model);
		}else{
			return $uploadlist[0]['savename'];//返回缩略图保存名称
		}		
	}
	/*
	 * 上传的附件整合成attach所需数据，存入表并返回数组
	 * */
	private function _add($uploadlist,$module=''){
		//$j = count($uploadlist);
		$v = array();
		foreach ($uploadlist as $key => $value){
		
			$v[$key]['name']		=	$value['name'];
			$v[$key]['savename']	=	$value['savename'];
			$v[$key]['savepath']	=	substr($value['savepath'], 2);
			$v[$key]['size']		=	$value['size'];
			$v[$key]['userId']		=	$_SESSION[C('USER_AUTH_KEY')];
			$v[$key]['uploadTime']	=	time();
			$v[$key]['alt']	        =	$_POST['alt'][$key];
			$v[$key]['module']	    = 	$_POST['module'];//当前项目路径 
			$v[$key]['recordId']	= 	$_POST['recordId'];//当前项目路径 
			$this->add($v[$key]);
			if($this->thumb){
			
				$v[$key]['prefix']		=	$this->thumbPrefix;				
			}
			$v[$key]['id'] = M('Attach')->getLastInsID();			
		}
		return $v;
	}
	//删除附件包括图片和文件
	public function delfile($M,$recordId){
			$arrid = $this->where(array('module'=>$M,'recordId'=>$recordId))->getField('id',true);
			foreach($arrid as $v){				
				$savename = $this->where(array('id' =>$v))->getField('savename');
				$result = $this->where(array('id'=>$v))->delete();
				if($result !==false){
				 $filename= ($M =='Picture')?'wb_'.$savename : $savename;
				 $file='Public'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$M.DIRECTORY_SEPARATOR.$filename;
			      if(is_file($file)){
				   unlink($file);				
				 }
				}
			}
		}
}
?>