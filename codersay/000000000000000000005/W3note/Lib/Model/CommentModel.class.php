<?php
class CommentModel extends BcModel{	 
	    protected $_validate  = array(
			    array('email','require','请填写您的邮箱!'),
                array('email','email','邮箱格式错误！'), 
				
               );
         
		protected $_auto=array(
		             array('status','1'),  
		             array('inputtime','time',1,'function'),
		             array('content','content',1,'callback'),
					 array('url','geturl',1,'callback'),
		             array ('inputtime','time',1,'function'),
			         array('path','path',3,'callback'),	
			         array('username','getusername',3,'callback'),
	               );
        /* 评论总数*/
	function Cmnum() {
		return $this->field('id')->count();
	}
	/* 最新评论及回复*/
	function newscoments() {
		$newscoments = $this->limit(9)->order('id desc')->select();
		return $newscoments;
	}
	/*
	*文章评论列表
	*$Module：模型名称
	*$rid:获取的文章ID
	*/
	public function commentlist($Module, $rid) {
		$rid = trim($rid);
		if ($Module == 'News')
			$condition['nid'] = $rid;
		if ($Module == 'Blog')
			$condition['bid'] = $rid;
		$commentlist = $this->relation(true)->where($condition)->order('inputtime desc')->select();
		return $commentlist;
	}
	protected function GetIp(){
		$data= get_client_ip();
		
		$arrip=array('0.0.0.0','94.23.14.30','199.116.173.93','58.53.192.218','87.73.2.26','213.209.215.90');
        $errip=in_array($data,$arrip);
        if($errip) exit();
		
		if(!$data) exit();
		 return $data ;
		}
	
		
}
?>