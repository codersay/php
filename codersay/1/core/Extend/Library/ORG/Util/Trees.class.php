<?php
	/**
	* 通用树形类, 可生成任何树形结构
	* 206c.net    webmaster@206c.net
	* NickDraw
	*/
	
	class tree extends Think
	{
		private $arr = array(); // @protected array   生成树形结构所需的数组
		public $icon = array('│','├','└');  // @protected array    生成树形所需符号，可替换为图片
		private $_return = '';  //@access private
		
		
		/*
		* 构造函数, 初始化类
		* @param array 2维数组，例如：
		* array(
		*      1 => array('id'=>'1','pid'=>0,'name'=>'一级栏目一'),
		*      2 => array('id'=>'2','pid'=>0,'name'=>'一级栏目二'),
		*      3 => array('id'=>'3','pid'=>1,'name'=>'二级栏目一'),
		*      4 => array('id'=>'4','pid'=>1,'name'=>'二级栏目二'),
		*      5 => array('id'=>'5','pid'=>2,'name'=>'二级栏目三'),
		*      6 => array('id'=>'6','pid'=>3,'name'=>'三级栏目一'),
		*      7 => array('id'=>'7','pid'=>3,'name'=>'三级栏目二')
		*      )
		*/
		
		public function __construct($arr=array()){
			$this->arr = $arr;
		   	$this->ret = "";
		   	return is_array($arr);
		}
		
		/*public function tree($arr=array()){
	       
		}*/
		
		/**
		* @param int
		* @return array
		* 得到父级数组
		*/
		private function getParent($AID){
			$newarr = array();
			if(!isset($this->arr[$AID])) return false;
			$pid = $this->arr[$AID]['pid'];
			$pid = $this->arr[$pid]['pid'];
			if(is_array($this->arr)){
				foreach($this->arr as $id => $a){
					if($a['pid'] == $pid) $newarr[$id] = $a;
				}
			}
			return $newarr;
		}
		
		/**
		* @param int
		* @return array
		* 得到子级数组
		*/
		private function getChild($AID){
			$a = $newarr = array();
			if(is_array($this->arr)){
				foreach($this->arr as $id => $a){
					if($a['pid'] == $AID) $newarr[$id] = $a;
				}
			}
			return $newarr ? $newarr : false;
		}
		
		/**
		*  @param int
		*  @return array
		*  得到当前位置数组
		*/
		private function getCurrPosition($AID,&$newarr){
			$a = array();
			if(!isset($this->arr[$AID])) return false;
	        $newarr[] = $this->arr[$AID];
			$pid = $this->arr[$AID]['pid'];
			if(isset($this->arr[$pid])){
			    $this->getCurrPosition($pid,$newarr);
			}
			if(is_array($newarr)){
				krsort($newarr);
				foreach($newarr as $v){
					$a[$v['id']] = $v;
				}
			}
			return $a;
		}
		
		/**
		* @return string
		* @param int ID，表示获得这个ID下的所有子级
		* @param string 生成树型结构的基本代码，例如："<option value=\$id \$selected>\$spacer\$name</option>"
		* @param int 被选中的ID，比如在做树型下拉框的时候需要用到
		* 得到树型结构
		*/
		public function getTreelist($AID,$str,$sid=0,$adds='',$types=''){
			$number = 1;
			$child = $this->getChild($AID);
			if(is_array($child)){
			    $total = count($child);
				foreach($child as $id=>$a){
					$j=$k='';
					if($number==$total){
						$j .= $this->icon[2];
					}else{
						$j .= $this->icon[1];
						$k = $adds ? $this->icon[0] : '';
					}
					$spacer = $adds ? $adds.$j : '';
					$selected = $a['id']==$sid ? "selected" : '';
					$disabled = $a['type'] !== $types && !empty($types) ? 'disabled="disabled"' : '';
					@extract($a);
					eval("\$nstr = \"$str\";");
					$this->_return .= $nstr;
					$this->getTreelist($a['id'],$str,$sid,$adds.$k.'&nbsp;',$types);
					$number++;
				}
			}
			return $this->_return;
		}
		
	}
?>