<?php
class FeedAction extends Action {
    // 首页
    public function index() {
              $Bloglist = D('News')->order('id desc')->limit(20)->select();
		      import("@.ORG.Rss");
              $RSS = new RSS(C('SITENAME'),'',C('METADESC'),'');//站点标题的链接
              foreach($Bloglist as $list){ 
                $RSS->AddItem($list['title'],U('/news/'.$list['id']),$list['description'],$list['ctime']);
              }
              $RSS->Display();
    }
   }
?>