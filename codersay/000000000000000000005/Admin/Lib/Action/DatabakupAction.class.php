<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2012 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
if (empty($_SESSION[C('USER_AUTH_KEY')])) exit();
class DatabakupAction extends Action {
	public function mysqlcn(){
		import("@.ORG.Dbbackup");
		$dbbackup = new dbbackup(C('DB_HOST'), C('DB_USER'), C('DB_PWD'), C('DB_NAME'));
		return $dbbackup;
		}
	//数据表列表
    public function index(){
	    $tbinfo = $this->mysqlcn()->gettbinfo(); 
		$tables=array();
		foreach ($tbinfo as $k => $v) {
			$tables[$k]['id']=$k+1;
			$tables[$k]['name']=$v['Name'];
			$tables[$k]['engine']=$v['Engine'];
			$tables[$k]['data_length']=sizecount($v['Data_length']);//字节数
			$tables[$k]['create_time']=$v['Create_time'];
			$tables[$k]['collation']=$v['Collation'];
			}
		 $this->assign('tbs',$tables);
	     $this->display();
	
	}
    //备份数据
    public function export(){
		
	   // $tbs = $this->mysqlcn()->get_tb(); //获取数据库表集合									
	    if($_POST['sub']){
			$data = $this->mysqlcn()->get_backupdata($_POST['id']);		//获取备份数据
			if($this->mysqlcn()->export($data)){								//导入数据
				$this->success('恭喜您备份成功!');
		}
	    }
	     
	}
	//备份文件列表
    public function import(){
		
	   $bakfile = $this->mysqlcn()->get_backup();	
	   $bakfiles=array();
		foreach ($bakfile as $k => $v) {
			$bakfiles[$k]['id']=$k+1;//备份文件名序号，没有实际意义
			$bakfiles[$k]['bfn']=$v;//备份文件名
			$bakfiles[$k]['ct']=$this->getdatacreattime($v);//创建备份时间
			$bakfiles[$k]['part']=$this->part($v);//分卷号
			
			}
	    $this->assign('bfns',$bakfiles);
		$this->display();
	}
	//还原数据
     public function recovery(){
	   if($_GET['fn']){
		   $sqlfile=trim($_GET['fn']).".sql";//升到3.1后获取的文件名没有后缀，因些加上了一个后缀".sql"
		   //echo $sqlfile;
		 if($this->mysqlcn()->import($sqlfile)){//导入数据
		    
			$this->success('恭喜您<br>备份数据已经成功导入！');//提示信息
			
		}
	    }
	}
		 
	 public function del(){
		 if($_POST['sub']){
		   echo $this->mysqlcn()->del($_POST['id'])? $this->success('恭喜您备份文件已删除成功!') : $this->error('删除失败!');
	     }
		 }
	  //获取备份文件的时间
	  public function getdatacreattime($tb){
		   if(!preg_match("/_part/", $tb)){            
		      $str = explode(".", $tb);         
		         $time = substr($str[0],-10);      
		           //设置用在脚本中所有日期/时间函数的默认时区。   
		            Date_default_timezone_set("PRC");   
		            return date("Y-m-d h:i",$time);   
	          }else{       
		          //分卷   
		        $str = explode("_part", $tb);     
		           $time = substr($str[0],-10);  
		          Date_default_timezone_set("PRC");   
		         return date("Y-m-d h:i",$time);   
	           }    
		  }
	  //获取分卷
	  public function part($tb){                  
	     if(!preg_match("/_part/", $tb)){                 
		     return "1";             
	       }else{             
		   $str = explode(".", $tb);               
		     return substr($str[0],-1);            
	          }    
		  }
	
}