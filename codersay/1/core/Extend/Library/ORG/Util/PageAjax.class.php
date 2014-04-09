<?php 
class PageAjax
{
    public $firstRow	; //分页起始行数 * @var integer * @access protected
    public $listRows	; //列表每页显示行数 * @var integer * @access protected
    public $parameter  ; //页数跳转时要带的参数 * @var integer * @access protected
    public $totalPages  ; //分页总页面数 * @var integer * @access protected
    public $totalRows  ; //总行数 * @var integer * @access protected
    public $nowPage    ; //当前页数 * @var integer * @access protected
    public $coolPages   ; //分页的栏的总页数 * @var integer * @access protected

    /** 分页栏每页显示的页数 * @var integer * @access protected */
    public $rollPage   ;
    
    /** 分页记录名称 * @var integer * @access protected */

	// 分页显示定制
    public $config   =	array('prev'=>'&lsaquo;','next'=>'&rsaquo;','first'=>'First','last'=>'Last');
    public $ajaxFunc =""   ; //ajax分页函数 * @var integer * @access protected

    /**
     +----------------------------------------------------------
     * 架构函数
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @param array $totalRows  总的记录数
     * @param array $firstRow  起始记录位置
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     +----------------------------------------------------------
     */
    public function __construct($totalRows,$listRows='',$parameter='')
    {    
        $this->totalRows = $totalRows;
        $this->parameter = $parameter;
        $this->rollPage = C('PAGE_ROLLPAGE');
        $this->listRows = !empty($listRows)?$listRows:C('PAGE_LISTROWS');
        $this->totalPages = ceil($this->totalRows/$this->listRows);     //总页数
        $this->coolPages  = ceil($this->totalPages/$this->rollPage);
		$this->nowPage  = !empty($_GET[C('VAR_PAGE')])&&($_GET[C('VAR_PAGE')] >0)?$_GET[C('VAR_PAGE')]:1;
		$this->setConfig('last','... '.$this->totalPages);
		$this->ajaxFunc=C('AJAX_FUNCTION');

        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        $this->firstRow = $this->listRows*($this->nowPage-1);
    }

	
	public function setConfig($name,$value) {
		if(isset($this->config[$name])) {
			$this->config[$name]	=	$value;
		}
	}

	public function getHref($page)
	{
		if(empty($this->ajaxFunc)){
			$href=$url."&".C('VAR_PAGE')."=".$page;
			
		}else{
			$href="javascript:".$this->ajaxFunc."(".$page.");";
		}
		return $href;
	}

    /**
     +----------------------------------------------------------
     * 分页显示
     * 用于在页面显示的分页栏的输出
     +----------------------------------------------------------
     * @access public 
     +----------------------------------------------------------
     * @return string
     +----------------------------------------------------------
     */

    public function show($isArray=false){

        if(0 == $this->totalRows) return;
        $nowCoolPage      = ceil($this->nowPage/$this->rollPage);
		$url  =  $_SERVER['REQUEST_URI'].(strpos($_SERVER['REQUEST_URI'],'?')?'':"?").$this->parameter;
		
        //上下翻页字符串
        $upRow   = $this->nowPage-1;
        $downRow = $this->nowPage+1;

	
        if ($upRow>0){
            $upPage="<a href='".$this->getHref($upRow)."'>".$this->config['prev']."</a>";
        }else{
            $upPage="<span class=\"disabled\">".$this->config['prev']."</span>";
        }

        if ($downRow <= $this->totalPages){
            $downPage="<a href='".$this->getHref($downRow)."'>".$this->config['next']."</a>";
        }else{
            $downPage="<span class=\"disabled\">".$this->config['next']."</span>";
        }
		
		//-----------------------

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
		
		if($startPage == 1){
            $nextPage = "";
            $theEnd="";
			$theFirst = "";
            $prePage = "";
		}else{
            $preRow =  $this->nowPage-$this->rollPage;
            $prePage = "<a href='".$this->getHref($preRow)."' >上".$this->rollPage."页</a>";
            $theFirst = "<a href='".$this->getHref(1)."' class='first' >". 1 /*$this->config['first']*/ ."</a> <a class='dotsm'>...</a>";
		}

		if($endPage == $this->totalPages){
            $nextPage = "";
            $theEnd="";
		}else{
            $nextRow = $this->nowPage+$this->rollPage;
            $theEndRow = $this->totalPages;
            $nextPage = "[<a href='".$this->getHref($nextRow)."' >下".$this->rollPage."页</a>]";
            $theEnd = "<a class='dotsm'>...</a> <a href='".$this->getHref($theEndRow)."' class='last' >". $theEndRow /*$this->config['last']*/ ."</a>";
		}
		
       
       	$startPage = $startPage < 1 ? 1 : $startPage;
		$endPage = $endPage > $this->totalPages ? $this->totalPages : $endPage;
		
        // 1 2 3 4 5
		for( $i = $startPage; $i <= $endPage; $i++ ){
			//$page = ( $nowCoolPage-1 ) * $this->rollPage + $i;
            if( $i != $this->nowPage ){
                //if( $page <= $this->totalPages ){
                if( $i <= $this->totalPages ){
                    $linkPage .= "<a href='".$this->getHref($i)."'>".$i."</a>";
                }else{
                    break;
                }
            }else{
                if( $this->totalPages != 1 ){
                    $linkPage .= "<span class='current'>".$i."</span>";
                }
            }
        }
		
		
        $pageStr = $upPage.$theFirst.$linkPage.$theEnd.$downPage; 
		
        if($isArray) {
            $pageArray['totalRows'] =   $this->totalRows;
            $pageArray['upPage']    =   $this->getHref($upRow);
            $pageArray['downPage']  =   $this->getHref($downRow);
            $pageArray['totalPages']=   $this->totalPages;
            $pageArray['firstPage'] =   $this->getHref(1);
            $pageArray['endPage']   =   $this->getHref($theEndRow);
            $pageArray['nextPages'] =   $this->getHref($nextRow);
            $pageArray['prePages']  =   $this->getHref($preRow);
            $pageArray['linkPages'] =   $linkPage;
			$pageArray['nowPage'] =   $this->nowPage;
        	return $pageArray;
        }
        return $pageStr;
    }

}//类定义结束
?>