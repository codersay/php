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
class ColumnsAction extends CommonAction{	
	   public function index(){
			   $newscat=D('Columns')->Catlist('News',1);	
			   $blogcat=D('Columns')->Catlist('Blog',2);	
			   $downloadcat=D('Columns')->Catlist('Download',3);
			   $catarray=array($newscat,$blogcat,$downloadcat);
			   $this->assign('catarray',$catarray);

			   $this->display();	
	           }
		
	    public function insert(){
			   if(isset($_POST['modelid'])){//判断是哪个模型
			       $modelid=trim($_POST['modelid']);
			       $model=$this->getMname($modelid);	
				   }
		       $alist=D('Columns')->Catlist($model, $modelid);	
			   $this->assign('modelid',$modelid);	
			   $this->assign('alist',$alist);	
			   $this->assign('mlist',$this->modelist());
			   $this->display();
		      }
		  
	     public function edit(){
    	    if(!$_GET['colId']) $this->error("该栏目不存在或已删除！");
		    $vo = M('Columns')->where(array('colId'=>$_GET['colId']))->find();
		    $alist=D('Columns')->Catlist($this->getMname($vo['modelid']), $vo['modelid']);	
			$this->assign('mlist',$this->modelist());
		    $this->assign('colId',$_GET['colId']);
		    $this->assign('modelid',$vo['modelid']);
		    $this->assign('alist',$alist);	
		   
            $this->assign('vo',$vo);
		
		$this->display();
    }
		public function getMname($modelid){
			$Marray = array (
			     1 => 'News',
			     2 => 'Blog',
			     3 => 'Download',
		       );
			$model=$Marray[$modelid];  
			return  $model;
			}
		public function modelist(){
			$mlist=M('Columns')->Distinct(true)->field('model,modelid')->select();
			 return $mlist;
			}
		public function add(){
				$this->addata('Columns');
		}
		public function addcol(){
				if (empty($_GET['colId'])) $this->error('栏目ID不存在');	
                $vo = M('Columns')->where(array('colId'=>trim($_GET['colId'])))->find();
                if ($vo !==false) {
                   $this->assign('vo', $vo);                 
                  } 
				 $this->display();          
		}

		
       // 删除数据
	    public function del() {
		  if(empty($_REQUEST['colId'])) $this->error('删除项不存在！');
			  $getid=trim($_REQUEST['colId']);
			  if(in_array($getid,array(1,2,3))) $this->error('系统根目录不能删除！');
			  $Columns	=	M('Columns');
			  $vo = $Columns->where(array('colId'=>$getid))->find();
			  $M = M($this->getMname($vo['modelid']));
			  if($Columns->where(array('colPid'=>$getid))->select()){
			         $this->error("请先删除子栏目!");
		      }elseif($M->where(array('catid'=>$getid))->select()){
			    $this->error('请先清空栏目下数据!');
		      }elseif($Columns->where(array('colId'=>$getid))->delete()){
			   $this->success("删除成功!");
		     }
	      }
	   public  function update() {
		      $colPid=isset($_POST['colPid'])?(int)$_POST['colPid']:0;
		       $colId=$_POST['colId'];
		       $Column = M('Columns');
			   $fat=$Column->where(array('colId'=>$colPid))->find();
			   $son=$Column->where(array('colId'=>$colId))->find();
			if(in_array($son['colId'],explode("-", $fat['colPath']))){
								
				    $this->error("父级不能移到子级栏目!");
				  }

                $this->getupdate();
             }
	   		 
	 public function act(){
		$this->action();
	}	
}
?>