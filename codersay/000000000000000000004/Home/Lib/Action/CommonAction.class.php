<?php
class CommonAction extends Action{
	public function _initialize(){
		$this->assign('collist',$this->head());
		$this->assign('linklist',$this->getLinks('writing'));
		$this->assign('randlist',$this->getRandomList(10));
		$this->assign('commentlist',$this->getCommentList());
		$this->assign('lastlist',$this->getLastArc());
		$this->assign('taglist',$this->getTags());
		$this->assign('datelist',$this->getDateList());
		$this->assign('hotreclist',$this->getHotRecArc('h'));
		$this->assign('categorylist',$this->getCategory());
	}

	//获取网站头部信息
	public function head(){
		$obj = D('Columns');
		$where['pid'] = 0;
		$where['isshow'] = 1;
		$list = $obj->field('colid,colname')->where($where)->order('ord asc')->select();
		foreach($list as $k => $v){
			$list[$k]['url'] = U('Index/columns',array('colid'=>$v['colid']));
			$list[$k]['submenu'] = $obj->getSubMenu($v['colid']);
		}
		return $list;
	}

	//获取右侧文章列表
	public function arcList($colid=0,$key='',$date='',$search=''){
		$offset = isset($_POST['offset'])?$_POST['offset']:0;
		$arcnum = C('CFG_PAGESIZE');
		$offset = $offset*$arcnum;
		if($date == ''){
			$obj = D('Article');
			$where['ischeck'] = 1;
			if($colid != 0){
				$where['colid'] = $colid;
			}
			elseif($key != ''){
				$where['keyword'] = array('like','%'.$key.'%');
			}
			elseif($search != ''){
				$map['title'] = array('like','%'.$search.'%');
				$map['content'] = array('like','%'.$search.'%');
				$map['_logic'] = 'OR';
				$where['_complex'] = $map;
			}
			$list = $obj->field('property,content,updatetime,mid,source,',true)->relation(true)->order('ord asc,createtime desc')->where($where)->limit($offset,$arcnum)->select();
			if(!$list){
				return '';
			}
			foreach ($list as $k=>$v){
				$list[$k]['arcurl'] = U('Article/index',array('arcid'=>$v['arcid']));
				$list[$k]['colurl'] = U('Index/columns',array('colid'=>$v['colid']));
				$list[$k]['commentnum'] = $this->getCommentNum($v['arcid']);
				$list[$k]['createtime'] = date('Y-m-d',$v['createtime']);
			}
		}
		else{
			$obj = new Model();
			$list = $obj->query("SELECT a.arcid,a.colid,a.description,a.createtime,a.click,a.ord,a.title,a.keyword,a.pic,b.colname FROM `".C('DB_PREFIX')."article` AS a LEFT JOIN `".C('DB_PREFIX')."columns` AS b ON a.colid=b.colid WHERE FROM_UNIXTIME(a.createtime,'%Y-%m')='".$date."' AND a.ischeck=1 ORDER BY a.ord ASC,a.createtime DESC LIMIT ".$offset.",10");
			if(!$list){
				return '';
			}
			foreach ($list as $k=>$v){
				$list[$k]['arcurl'] = U('Article/index',array('arcid'=>$v['arcid']));
				$list[$k]['colurl'] = U('Index/columns',array('colid'=>$v['colid']));
				$list[$k]['commentnum'] = $this->getCommentNum($v['arcid']);
				$list[$k]['createtime'] = date('Y-m-d',$v['createtime']);
			}
		}
		return $list;
	}

	//获得文章的评论数
	public function getCommentNum($arcid){
		$obj = M('Comment');
		$where['arcid'] = $arcid;
		$num = $obj->where($where)->count();
		return $num;
	}

	//获取位置信息
	public function getPos($colid=0,$key='',$date='',$search=''){
		$position = "<a href='/'>首页</a>";
		if($colid != 0){
			$where['colid'] = $colid;
			$data = M('Columns')->field('colname')->where($where)->find();
			$url = U('Index/columns',array('colid'=>$colid));
			$position .= ">>"."<a href='".$url."'>".$data['colname']."</a>";
		}
		elseif($key != ''){
			$position .= '>>'.$key;
		}
		elseif($date != ''){
			$position .= '>>'.$date;
		}
		elseif($search != ''){
			$position .= '>>搜索结果：'.$search;
		}
		return $position;
	}

	//获取友情链接
	//type:可传入数组
	public function getLinks($type){
		$obj = M('Links');
		$where['linktype'] = $type;
		$list = $obj->where($where)->select();
		return $list;
	}

	//获取随机文章
	public function getRandomList($num=10){
		$where['ischeck'] = 1;
		$list = D('Article')->field('arcid,title')->order('rand()')->limit($num)->where($where)->select();
		foreach ($list as $k=>$v){
			$list[$k]['arcurl'] = U('Article/index',array('arcid'=>$v['arcid']));
		}
		return $list;
	}

	//获取左侧评论列表
	public function getCommentList($num=5){
		$where['isreply'] = 0;
		$list = D('Comment')->relation(true)->field('id,arcid,writer,content,time')->order('time desc')->where($where)->limit($num)->select();
		foreach ($list as $k=>$v){
			$list[$k]['url'] = U('Article/index',array('arcid'=>$v['arcid']))."#comments";
			$list[$k]['content'] = mb_substr($v['content'],0,14,'utf-8');
		}
		return $list;
	}

	//获取左侧近期文章
	public function getLastArc($num=5){
		$where['ischeck'] = 1;
		$list = D('Article')->field('arcid,createtime,title')->where($where)->limit($num)->order('createtime desc')->select();
		foreach ($list as $k=>$v){
			$list[$k]['arcurl'] = U('Article/index',array('arcid'=>$v['arcid']));
			$list[$k]['commentnum'] = $this->getCommentNum($v['arcid']);
		}
		return $list;
	}

	//过去左侧标签
	public function getTags(){
		$list = M('Tags')->field('tagname,num')->select();
		foreach ($list as $k=>$v){
			$list[$k]['tagurl'] = U('Index/tag',array('key'=>$v['tagname']));
		}
		return $list;
	}

	//文章归档
	public function getDateList(){
		$obj = new Model();
		$list = $obj->query("SELECT COUNT(FROM_UNIXTIME(createtime,'%Y-%m')) AS count,FROM_UNIXTIME(createtime,'%Y-%m') AS time FROM `".C('DB_PREFIX')."article` GROUP BY time ORDER BY time DESC");
		foreach ($list as $k=>$v){
			$list[$k]['url'] = U('Index/dateArc',array('date'=>$v['time']));
		}
		return $list;
	}

	//获取左侧热门、推荐或热门推荐文章
	public function getHotRecArc($property,$num=5){
		$where['ischeck'] = 1;
		$where['property'] = $property;
		$list = D('Article')->where($where)->field('arcid,createtime,title')->limit($num)->order('ord asc,createtime desc')->select();
		foreach ($list as $k=>$v){
			$list[$k]['arcurl'] = U('Article/index',array('arcid'=>$v['arcid']));
			$list[$k]['commentnum'] = $this->getCommentNum($v['arcid']);
		}
		return $list;
	}

	//获得留言或评论
	public function getCFContent($model){
		$obj = D($model);
		$arcid = $_POST['arcid'];
		$offset = $_POST['offset'];
		$offset = $offset*10;//开始位置
		if($arcid != 0){
			$where['arcid'] = $arcid;
		}
		$where['pid'] = 0;
		$list = $obj->field('id,writer,content,time')->where($where)->order('time desc')->limit($offset,10)->select();
		if(!$list){
			$this->ajaxReturn('');
		}
		import("ORG.Util.Input");
		foreach ($list as $k=>$v){
			$list[$k]['reply'] = $this->getReply($model,$v['id'],$arcid,$v['writer']);
			$list[$k]['time'] = date('Y-m-d',$v['time']);
			$list[$k]['content'] = Input::stripSlashes(Input::nl2Br($v['content']));
		}
		return $list;
	}

	//保存留言或评论
	public function saveCF($model,$prompt,$url){
		$verify = trim($_POST['verify']);
		if(empty($verify)){
			$this->error('验证码不能为空！');
		}
		if(session('verify') != md5($verify)) {
			$this->error('验证码错误！');
		}
		$obj = D($model);
		if(!($obj->create())){
			$this->error($obj->getError());
		}

		//处理[code][/code]
		import("ORG.Util.Input");
		$content = Input::stripSlashes($_POST['content']);
		$content = preg_replace("/\[code\]/",'<pre>',$content);
		$content = preg_replace("/\[\/code\]/",'</pre>',$content);
		$obj->content =$content;
		
		$result = $obj->add();
		if($result){
			$this->success($prompt.'成功！', $url);
		}
		else{
			$this->error($prompt.'失败！');
		}
	}

	//获取文章文类
	public function getCategory(){
		$obj = D('Columns');
		$list = $obj->field('colid,colname')->order('ord asc,colid asc')->select();
		foreach ($list as$k=>$v){
			 $list[$k]['url'] = U('Index/columns',array('colid'=>$v['colid']));
			 $list[$k]['count'] = $this->getCategoryNum($v['colid']);
		}
		return $list;
	}

	public function _empty(){
		$this->display(C('CFG_DF_THEME').':Public:404');
	}

	//获得分类下的文章数
	private function getCategoryNum($colid){
		$where['colid'] = $colid;
		$num = D('Article')->where($where)->count();
		return $num;
	}

	//获得回复列表
	private function getReply($model,$id,$arcid,$replyto){
		$obj = D($model);
		if($arcid != 0){
			$where['arcid'] = $arcid;
		}
		$where['pid'] = $id;
		$list = $obj->field('id,writer,content,time')->where($where)->order('time desc')->select();
		if(!$list){
			return '';
		}
		foreach ($list as$k=>$v){
			$list[$k]['time'] = date('Y-m-d',$v['time']);
			$list[$k]['writer'] = $v['writer'].'@'.$replyto;
		}
		return $list;
	}
}
?>