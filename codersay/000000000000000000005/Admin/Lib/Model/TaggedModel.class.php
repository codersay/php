<?php
// +----------------------------------------------------------------------
// | WBlog
// +----------------------------------------------------------------------
// | Copyright (c) 2008 http://www.w3note.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 网菠萝果
// +----------------------------------------------------------------------
// $Id$
class TaggedModel extends Model{
	/* 处理添加标签
	/*$vo:由creat创建的数据
	*$list成功插入数据库后，返回的ID
	*$module:模型名称
	*/
	public function saveTag($vo, $list, $module) {
		if (!empty ($vo) && !empty ($list)) {
			
			$tags = explode(' ', $vo['keywords']);
			$this->_saveTag($tags, $list, $module);
		}
	}
	public function _saveTag($tagarr, $list, $module) {
		$Tag = D('Tag');
		foreach ($tagarr as $key => $val) {
				$val = trim($val);
				if (!empty ($val)) {
					// 记录已经存在的标签
					$tagg = $Tag->where(array('module' => $module,'name' => $val))->find();
					if ($tagg) { //如果现在保存的标签与之前相同的标签累加
						$tagId = $tagg['id'];
						$Tag->where(array('id' =>$tagId))->setInc('count', 1); //count统计加1(这个函数有三个参数，默认加1)
					} else { //如果是新添的标签,标签+1
						$taginfo=array('module'=>$module,'count'=> 1,'name'=> $val);
						$result = $Tag->add($taginfo);
						$tagId = $result;
					}
				}
				//记录$Tagged信息
				$taggedinfo=array('module'=>$module,'recordId' => $list,'tagTime'=> time(),'tagId'=> $tagId);
				$this->add($taggedinfo);
			}
		
		}
	public function updateTag($vo, $module) {

		$recordId = trim($vo['id']);
		
		if ($vo['keywords'] == '') { //如果没有标签，则把原来的标签删除
			$this->deltag($recordId);
		} else {
			$newtags = explode(' ', $vo['keywords']); //获取更新的标签并转为数组                                  
			//$condition['recordId'] = $recordId; //当有多个标签时，将查询多篇日记，而不是一篇
			$tag = M('Tag');
			$taggedlist = $this->where(array('recordId'=>$recordId))->select();
			
			if ($taggedlist !== false) {

				foreach ($taggedlist as $key => $value) {
					//$tagId = trim($value['tagId']);
					$tagvo = $tag->where(array('id' => $value['tagId']))->find();
					$oldtags[] = $tagvo['name']; //获取原来的标签
				}
				$result  = count(array_diff(array_diff($newtags, $oldtags), array_diff($oldtags, $newtags)));
				$result1 = count(array_diff($newtags, $oldtags)); //返回更新前后TAG的差值数
				$result2 = count(array_diff($oldtags, $newtags)); //返回更新前后TAG的差值数

				if (($result1 !== $result2) || ($result !== 0)) { //2与原来的完全相同->过滤掉            
					$array_intersect = array_intersect($oldtags, $newtags); //取得交值
					$oldtags_diff = array_diff($oldtags, $array_intersect); //原来的标签,被更新后已无用，需要删除的
					$newtags_diff = array_diff($newtags, $array_intersect); //修改的标签,需要添加的

					//删除或者count-1	
					if (count($oldtags_diff) !== 0) {

						foreach ($oldtags_diff as $name) {
							//$name =iconv("GBK","UTF-8",$name);
							
							$tagvo = $tag->where(array('module'=>$module,'name'=>$name))->find();
							
							$count = intval($tagvo['count']); //获取标签的数量

							if ($count == 1) {
								$tag->where(array('id'=>$tagvo['id']))->delete();
								$this->where(array('tagId'=> $tagvo['id'],'recordId' => $recordId))->delete();
							}
							elseif ($count > 1) {

								$tag->where(array('id'=>$tagvo['id']))->setDec('count', 1); //标签数量减1
								$this->where(array('tagId'=> $tagvo['id'],'recordId' => $recordId))->delete(); //删除tagged中相关数据		   
							}
						}
					}

					//添加更新的标签  
					if (count($newtags_diff) !== 0) {
						$tags=$newtags_diff;
						$list=$recordId;
                        $this->_saveTag($tags, $list, $module);
					}

				} 

			} 
		} 

	}
	//删除标签
	public function deltag($recordId) { 
		$tagIds = $this->where(array('recordId'=>$recordId))->getField('tagId',true);
		$taggedids= $this->where(array('recordId'=>$recordId))->getField('id',true);
			foreach ($tagIds as $tagIdk => $tagIdv) {
				$tagId = $tagIdv;
				$tag = D('Tag');
				
				$count = $tag->where(array('id'=>$tagId))->getField('count'); //获取标签的数量

				if ($count == 1) {
					$tag->where(array('id'=>$tagId))->delete();
					
				}elseif ($count > 1) {
				
					$tag->where(array('id'=>$tagId))->setDec('count', 1);

				}
			}
			foreach ($taggedids as $taggedid_k => $taggedid_v) {
				$this->where(array('id' => $taggedid_v , 'recordId' =>$recordId))->delete();
			}	
	} 
}
?>