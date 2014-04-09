<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: Page.class.php 2712 2012-02-06 10:12:49Z liu21st $
// 
// class Page {
    // // 分页栏每页显示的页数
    // public $rollPage = 5;
    // // 页数跳转时要带的参数
    // public $parameter  ;
    // // 默认列表每页显示行数
    // public $listRows = 20;
    // // 起始行数
    // public $firstRow	;
    // // 分页总页面数
    // protected $totalPages  ;
    // // 总行数
    // protected $totalRows  ;
    // // 当前页数
    // protected $nowPage    ;
    // // 分页的栏的总页数
    // protected $coolPages   ;
    // // 分页显示定制
    // protected $config  =	array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>'<span class="info"> %totalRow% %header% %nowPage%/%totalPage% 页</span> %first% %upPage% %linkPage% %downPage% %end%');
    // // 默认分页变量名
    // protected $varPage;
// 
    // /**
     // +----------------------------------------------------------
     // * 架构函数
     // +----------------------------------------------------------
     // * @access public
     // +----------------------------------------------------------
     // * @param array $totalRows  总的记录数
     // * @param array $listRows  每页显示记录数
     // * @param array $parameter  分页跳转的参数
     // +----------------------------------------------------------
     // */
    // public function __construct($totalRows,$listRows='',$parameter='') {
        // $this->totalRows = $totalRows;
        // $this->parameter = $parameter;
        // $this->varPage = C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ;
        // if(!empty($listRows)) {
            // $this->listRows = intval($listRows);
        // }
        // $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        // $this->coolPages  = ceil($this->totalPages/$this->rollPage);
        // $this->nowPage  = !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1;
        // if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            // $this->nowPage = $this->totalPages;
        // }
        // $this->firstRow = $this->listRows*($this->nowPage-1);
    // }
// 
    // public function setConfig($name,$value) {
        // if(isset($this->config[$name])) {
            // $this->config[$name]    =   $value;
        // }
    // }
// 
    // /**
     // +----------------------------------------------------------
     // * 分页显示输出
     // +----------------------------------------------------------
     // * @access public
     // +----------------------------------------------------------
     // */
    // public function show() {
        // if(0 == $this->totalRows) return '';
        // $p = $this->varPage;
        // $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
        // $url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
        // $parse = parse_url($url);
        // if(isset($parse['query'])) {
            // parse_str($parse['query'],$params);
            // unset($params[$p]);
            // $url   =  $parse['path'].'?'.http_build_query($params);
        // }
        // //上下翻页字符串
        // $upRow   = $this->nowPage-1;
        // $downRow = $this->nowPage+1;
        // if ($upRow>0){
            // $upPage="<a href='".$url."&".$p."=$upRow'>".$this->config['prev']."</a>";
        // }else{
            // $upPage="";
        // }
// 
        // if ($downRow <= $this->totalPages){
            // $downPage="<a href='".$url."&".$p."=$downRow'>".$this->config['next']."</a>";
        // }else{
            // $downPage="";
        // }
        // // << < > >>
        // if($nowCoolPage == 1){
            // $theFirst = "";
            // $prePage = "";
        // }else{
            // $preRow =  $this->nowPage-$this->rollPage;
            // $prePage = "<a href='".$url."&".$p."=$preRow' >上".$this->rollPage."页</a>";
            // $theFirst = "<a href='".$url."&".$p."=1' >".$this->config['first']."</a>";
        // }
        // if($nowCoolPage == $this->coolPages){
            // $nextPage = "";
            // $theEnd="";
        // }else{
            // $nextRow = $this->nowPage+$this->rollPage;
            // $theEndRow = $this->totalPages;
            // $nextPage = "<a href='".$url."&".$p."=$nextRow' >下".$this->rollPage."页</a>";
            // $theEnd = "<a href='".$url."&".$p."=$theEndRow' >".$this->config['last']."</a>";
        // }
        // // 1 2 3 4 5
        // $linkPage = "";
        // for($i=1;$i<=$this->rollPage;$i++){
            // $page=($nowCoolPage-1)*$this->rollPage+$i;
            // if($page!=$this->nowPage){
                // if($page<=$this->totalPages){
                    // $linkPage .= "&nbsp;<a href='".$url."&".$p."=$page'>&nbsp;".$page."&nbsp;</a>";
                // }else{
                    // break;
                // }
            // }else{
                // if($this->totalPages != 1){
                    // $linkPage .= "&nbsp;<span class='current'>".$page."</span>";
                // }
            // }
        // }
        // $pageStr	 =	 str_replace(
            // array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            // array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
        // return $pageStr;
    // }
// 
// }
class Page {
	// 起始行数
    public $firstRow;
    // 列表每页显示行数
    public $listRows;
    // 页数跳转时要带的参数
    public $parameter;
    // 分页总页面数
    protected $totalPages;
    // 总行数
    protected $totalRows;
    // 当前页数
    public $rewrite;//是否采用伪静态形式
    protected $nowPage;
    // 分页的栏的总页数
    protected $coolPages;
    // 分页栏每页显示的页数
    protected $rollPage;
    // 分页显示定制
    protected $config = array(
		'header' => '条记录',
		// 'prev' => '&lsaquo;',
		// 'next' => '&rsaquo;',
        // 'first' => '&laquo;',
		// 'last' => '&raquo;',
		'prev' => '<tt style="font-family:Verdana;">&laquo;</tt>',
		'next' => '<tt style="font-family:Verdana;">&raquo;</tt>',
        'first' => '',
		'last' => '',
		'theme' => '<span class="info">%totalRow% %header% %nowPage%/%totalPage% 页</span> %upPage% %first% %linkPage% %end% %downPage%'
	);
    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
	public function __construct($totalRows, $listRows, $rewrite = '0' ,$parameter = '')
    {
    	$this->rewrite = $rewrite;
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->rollPage = C('PAGE_ROLLPAGE');
        $this->listRows = !empty($listRows) ? $listRows : C('PAGE_LISTROWS');
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        $this->coolPages = ceil($this->totalPages / $this->rollPage);
        $this->nowPage = !empty($_GET[C('VAR_PAGE')]) ? $_GET[C('VAR_PAGE')] : 1;
        if (!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows * ($this->nowPage - 1);
        
    }

    public function setConfig($name, $value)
    {
        if (isset($this->config[$name])) {
            $this->config[$name] = $value;
        }
    }

    /**
     * +----------------------------------------------------------
     * 分页显示输出
     * +----------------------------------------------------------
     * @access public
     * +----------------------------------------------------------
     */
    public function show()
    {
        if (0 == $this->totalRows){
        	return '';
        }
		
        $p = C('VAR_PAGE');
        $nowCoolPage = ceil($this->nowPage / $this->rollPage);
        $url = $_SERVER['REQUEST_URI'] . (strpos($_SERVER['REQUEST_URI'], '?') ? '' : "?") . $this->parameter;
		$parse = parse_url($url);
        if (isset($parse['query'])) {
            parse_str($parse['query'], $params);
            unset($params[$p]);
            $url = $parse['path'] . '?' . http_build_query($params);
        }

		$patterns = array(
			"/\/p\/\d+/",
			"/\.shtml/",
			"/\.html/",
			"/\?/",
			"/\/$/",
		);

		// 静态显示分页参数
		
		/*if(C('URL_MODEL') || $this->rewrite){
			$url = preg_replace($patterns, '', $url);
			$format = C('URL_PATHINFO_DEPR') . $p . C('URL_PATHINFO_DEPR') . "%d".C('URL_HTML_SUFFIX');
		}else{
			if (!strpos($_SERVER['REQUEST_URI'], '&'))
			{
				$format = "{$p}=%d";
			}
			else
			{
				$format = "&{$p}=%d";
			}
		}*/
        if ( C('CUSTOM_URL_MODEL') == 3 || strpos( $_SERVER['REQUEST_URI'], '&' ) ){
            $format = "&{$p}=%d";
        }else{
    		$format = "{$p}=%d";
        }

        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;
        if ($upRow>0){
            $upPage="<a href='".$url.sprintf($format, $upRow)."'>".$this->config['prev']."</a>";
        }else{
            $upPage="<span class=\"disabled\">".$this->config['prev']."</span>";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a href='".$url.sprintf($format, $downRow)."'>".$this->config['next']."</a>";
        }else{
            $downPage="<span class=\"disabled\">".$this->config['next']."</span>";
        }

		//只有1页时不显示"上一页""下一页"
		if($this->totalPages <= 1){
			$downPage = $upPage = '';
		}

		$offset = floor($this->rollPage/2);

		$linkPage = "";
		if($this->totalPages <= $this->rollPage){
			$startPage = 1;
			$endPage = $this->totalPages;
		}else{
			//set startPage
			if($this->nowPage > $offset){
				$startPage = $this->nowPage - $offset;
			}else{
				$startPage = 1;
			}

			//set endPage
			if($this->nowPage + $offset < $this->totalPages){
				$endPage = $this->nowPage + $offset;
			}else{
				$startPage = $this->totalPages - $this->rollPage;
				$endPage = $this->totalPages;
			}

			if($this->nowPage + $offset < $this->rollPage){
				$startPage = 1;
				$endPage = $this->rollPage;
			}
		}

        // << < > >>
		if($startPage == 1){
            $nextPage = "";
            $theEnd="";
			$theFirst = "";
            $prePage = "";
		}else{
            $preRow =  $this->nowPage-$this->rollPage;
            $prePage = "<a href='".$url.sprintf($format, $preRow)."' >上".$this->rollPage."页</a>";
            $theFirst = "<a href='".$url.sprintf($format, 1)."' class='first' >". 1 /*$this->config['first']*/ ."</a> <a class='dotsm'>...</a>";
		}

		if($endPage == $this->totalPages){
            $nextPage = "";
            $theEnd="";
		}else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "[<a href='".$url.sprintf($format, $nextRow)."' >下".$this->rollPage."页</a>]";
            $theEnd = "<a class='dotsm'>...</a> <a href='".$url.sprintf($format, $theEndRow)."' class='last' >". $theEndRow /*$this->config['last']*/ ."</a>";
		}

		//确保$startPage和$endPage的范围
		$startPage = $startPage < 1 ? 1 : $startPage;
		$endPage = $endPage > $this->totalPages ? $this->totalPages : $endPage;
		
        // 1 2 3 4 5
		for( $i = $startPage; $i <= $endPage; $i++ ){
			//$page = ( $nowCoolPage-1 ) * $this->rollPage + $i;
            if( $i != $this->nowPage ){
                //if( $page <= $this->totalPages ){
                if( $i <= $this->totalPages ){
                    $linkPage .= "<a href='".$url.sprintf($format, $i)."'>".$i."</a>";
                }else{
                    break;
                }
            }else{
                if( $this->totalPages != 1 ){
                    $linkPage .= "<span class='current'>".$i."</span>";
                }
            }
        }

		$find = array(
			'%header%',
			'%nowPage%',
			'%totalRow%',
            '%totalPage%',
			'%upPage%',
			'%downPage%',
			'%first%',
			'%prePage%',
			'%linkPage%',
            '%nextPage%',
			'%end%',
		);
		$replace = array(
			$this->config['header'], 
			$this->nowPage,
			$this->totalRows,
			$this->totalPages,
			$upPage,
			$downPage,
			$theFirst,
			$prePage,
            $linkPage,
			$nextPage,
			$theEnd,
		);

        $pageStr = str_replace($find, $replace, $this->config['theme']);
        return $pageStr;
    }

}