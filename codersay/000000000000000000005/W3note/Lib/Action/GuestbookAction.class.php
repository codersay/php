<?php
// 留言
class GuestbookAction extends CommonAction {
	 public static $wordArr = array();  
     public static $content = "";  
    public function index(){
		$garr= D('Guestbook')->gclist("id,username,inputtime,pid,url,content,path,concat(path,'-',id) as bpath");
		$this->assign('hotlist', D('News')->Hot());
		$this->assign('newslist', D('News')->newsinfo());
		$this->assign('bloglist', D('Blog')->newsinfo());
		$this->assign('Gklist', $garr['list']);
		$this->assign('DateList', D('News')->DateList('News'));	
		$this->assign('title', $title='网志留言板'); 
		$this->assign('page',$garr['page']);
		$this->assign('menu', D('Columns')->menu());
        $this->display();
    }
		
	public function add(){
		if(false === self::filter($_POST ['content'])){
            $this->error('含有敏感词！');
            }
		$this->adddata('Guestbook');
			/**/	
		}
	public function tourl(){
	  $this->gettourl('Guestbook');
      } 
	  /**
     * 过滤内容
     * @param $content
     *
     * @return bool
     */
    public static function filter($content){
        if($content=="") return false;
        self::$content = $content;
        empty(self::$wordArr)?self::getWord():"";
        foreach ( self::$wordArr as $row){
            if (false !== strstr(self::$content,$row)) return false;
        }
        return true;
    }

    public static function getWord(){
		$wordArr= require C('WORD_FILE').'Sensitivewords.php';
        self::$wordArr = $wordArr;

    }
}
?>