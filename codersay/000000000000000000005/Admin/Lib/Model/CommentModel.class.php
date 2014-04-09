<?php
class CommentModel extends BcModel{
	protected $_auto=array(
		    array('isreply','1'),  
		    array ('inputtime','time',1,'function'),
			array('path','path',3,'callback'),	
			array('username','getusername',3,'callback'),
			);
	protected $_link = array(
        'News'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'News',
           'foreign_key'=>'nid',//Comment表中nid
           'as_fields'=>'title',
       ),
	     /**/'Blog'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'Blog',
           'foreign_key'=>'cid',//Comment表中nid
           'as_fields'=>'title',
       ),
    );
    	//删除评论2012.12.13
	public function delct($Modulename,$v) { 
		if ($Modulename == 'News') {
			$where['nid']=$v;
		}
		elseif (($Modulename == 'Blog')) {
			$where['bid']=$v;
		}
		$cidarr =$this->where($where)->getField('id',true);//获取评论表中bid为v的论论列表
		if ($cidarr !== false) {
			$this->where(array('id'=> array('in',$cidarr)))->delete(); 
		}	
	}	
}
?>