<?php
class BcModel extends RelationModel{
		
	  public function getusername(){
		  if (isset ($_POST['username'])) {
			if(trim($_POST['username'])=='admin'){
			    return $data= '￣□￣';	
			}elseif(strlen($_POST['username']) >10){			    
				return $data= msubstr($_POST['username'],0,5);
			}else{
				return $data= $_POST['username'];
			}
		}else{
			if($_SESSION['loginUserName'])return $data='admin';
			}	
	    } 
	 public function path(){
		   $pid=isset($_POST['pid'])?(int)$_POST['pid']:0;
		   $id=$_POST['id'];
			if($pid==0){				
				return 0;
			}
			
			$fat=$this->where(array('id' => $pid))->find();
			$data=$fat['path'].'-'.$fat['id'];			
			return $data;
	    }
	public function content() {
		if(!$_SESSION['loginUserName']){
		if (isset ($_POST['content']) && !empty ($_POST['content'])) {
			 $data =deleteHtmlTags($_POST['content']);
			 $data =safeHtml($data);
			if (strlen($data) > 1000) {
				$data = msubstr($data, 0, 500);
			}
			return delworlds($data);
		}
		}
		if($_SESSION['loginUserName']){
			 return $data=$_POST['content'];
		}
		
	}
	public function geturl(){
		if (isset ($_POST['url'])) {
		$data = deleteHtmlTags($_POST['url']);
			 $data = safeHtml($data);
			 //$data =delUrl($data);
			return $data=$data?$data:"";
		}
	}	
	/*删除留言
	*$idarr为Book表的ID数组
	*/
	 public function del($idarr){
		 $this->where(array('id'=> array('in',$idarr)))->delete(); 
		 }
	 function gclist($field,$where='',$pagesize=30) {
		import("ORG.Util.Page");
         $count = $this->field('id')->where($where)->count();
		 $P = new Page($count, $pagesize);
		 
        $list=$this->field($field)->where($where)->order('bpath,id')->limit($P->firstRow . ',' . $P->listRows)->select();

		foreach ($list as $k => $v) {
			$list[$k]['count'] = count(explode('-', $v['bpath']));
			$list[$k]['tousername']=$this->where(array('id'=> $v['pid']))->getField('username');
			$str = '';
			if ($v['pid'] <> 0) {
				for ($i = 0; $i < $list[$k]['count'] * 2; $i++) {
					$str .= '&nbsp;';
				}
				$str .= ' ';
			}
			$list[$k]['space'] = $str;
		}
        $P->setConfig('header', '篇');
		$P->setConfig('prev', "«");
		$P->setConfig('next', '»');
		$P->setConfig('first', '|«');
		$P->setConfig('last', '»|');
		$page = $P->show();
		$arr=array('page'=>$page,'list'=>$list);
		return $arr;
	}
}
?>