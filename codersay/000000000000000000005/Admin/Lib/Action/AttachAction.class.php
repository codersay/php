<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// $Id$
class AttachAction extends CommonAction {
    // 首页
    public function index() {
        $Attach = M('Attach');
        //import("ORG.Util.Page");                    
		if(isset($_GET['id'])&&isset($_GET['module'])){			   
			   $recordId=intval($_GET['id']);
			   $module=$_GET['module'];
			   $condition['recordId'] = $recordId;
			   $condition['module'] = $module;
		     }elseif(isset($_REQUEST['module'])){//根据模型管理文件
			     $module=$_REQUEST['module'];
			     $condition['module'] = $module;
			 }else{//默认情况下显示图片附件
			   $condition ='';
			   $module='';
		     }
		 $listsarr=$this->getpagelists('Attach',$condition,'id desc');
		 $Attachlist = $listsarr['lists']; 
		 foreach ($Attachlist as $k => $v) {
			 $recordId=$recordId ? $recordId: $Attach->where(array('id'=>$v['id']))->getField('recordId');			
			 $Attachlist[$k]['title']=M($module)->where(array('id'=>$recordId))->getField('title');
				  
		  }
		$Modelist=$Attach->Distinct(true)->field('module')->select();
		$this->assign('Modelist', $Modelist);
		$this->assign('page', $listsarr['page']);
		$this->assign('tpl', $tpl="index");
		$this->assign('modules', $module=$module?$module:'');
		$this->assign('recordId', $recordId=$recordId?$recordId:0);
        $this->assign('Attachlist', $Attachlist);
        $this->display();
    }
    
	 public function act(){
		$getid = $_REQUEST['id'];  
		$getids = implode(',',$getid);
		$id = is_array($getid) ? $getids : $getid;
		$map['id'] = array('in',$id);
		if(!$id){			
			$this->error('请勾选记录');		
		}
		$Attach = D('Attach');	//(在同一模型中操作2013.2.29之前)	
		if(trim($_GET['action']) == 'delete'){
			foreach($getid as $v){				
				$vo=$Attach->field('id,savename,module')->where(array('id' =>$v))->find();
				$result = $Attach->where(array('id'=>$v))->delete();
			   if($result !==false){
				    $filename= ($vo['module'] =='News')?'wb_'.$vo['savename'] : $vo['savename'];
				    $file='Public'.DIRECTORY_SEPARATOR.'Uploads'.DIRECTORY_SEPARATOR.$vo['module'].DIRECTORY_SEPARATOR.$filename;			     
			      if(is_file($file)){
				   unlink($file);				
				 }
				}
			}
			
			$this->message($result);
			
		}
	}
     public function upload() {
        if (!empty($_FILES)) {//如果有文件上传
		    $model=trim($_POST['module']);
		    if($model=='News'){
				$type='image';
			}else{
				$type='file';
			}
		    $result=D('Attach')->upload($model,$type);
			$this->message($result,'上传成功！','上传出错！');
															
           }
      }
  
    public function add(){
		$module=$_GET['module'] ? $_GET['module'] : '';
		$recordId=$_GET['id'] ? $_GET['id'] : 0;
		$this->assign('module',$module);
		$this->assign('recordId',$recordId);
		$this->display();
	   }
   }
?>