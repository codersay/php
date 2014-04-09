<?php
	class WidgetAction extends CommonAction{
		protected function checkWidget(){
	        $widget = getPluginsDir(__ROOT_PATH__.'/applications/library/Widget','applications');
	        $this->_addPluginApp($widget);
	        return ;
		}
		protected function _addPluginApp($widgets){
			$widget_model = D("Plugins");
			$wds = array();
			foreach($widgets as $widget)			
				$wds[] = $widget['name'];
			
			$where['name'] = array('not in',$wds);
			$where['type'] = 'widget';
			//先把无效的插件删除
			$widget_model->where( $where )->delete();

	        foreach($widgets as $key=>$widget) {
	            $result = $widget_model->where('name="'.$widget['name'].'"')->find();
	            if(!$result) {
	                // 如果数据库不存在该插件 添加
	                $widget['status'] =  0; //默认为禁用
	                $widget_model->add($widget);
	            }
				else if($result["name"] != $widget["name"])
				{
					//有可能是移动了目录 插件是有记录的 但是插件文件的路径变化了
					//需要更新路径 否则写插件缓存时取不到所需的文件
					//启用状态不需要变,直接把file改了就行了
					$widget_model->where("name='".$widget['name']."'")->setField("name",$widget["name"]);
				}
	        }
	        return ;
		}
		public function act(){
			$this->checkWidget();
			$pluginDao = D("Plugins");
			$total = $pluginDao->count();
			import("ORG.Util.Page");
			$page = new Page($total,20);
			$list = $pluginDao
				->where("type='widget'")
				->order("sort")
				->limit($page->firstRow.",".$page->listRows)
				->select();

			$this->assign("list",$list);
			$this->assign("page",$page->show());
			$this->display();
		}

		/**
	     +----------------------------------------------------------
	     * 编辑插件文件
	     +----------------------------------------------------------
	     * @access public 
	     +----------------------------------------------------------
	     */
	    public function edit(){
	    	$path = __ROOT_PATH__.'/applications/library/Widget';
	    	$pluginDao = D("Plugins");
	    	$plugin = $pluginDao->find($this->_get('id'));
	    	$this->assign("path",$path);
			$this->assign("plugin",$plugin);
			$this->display();
	    }

	    public function updateOneSort(){
        	$model = D('Plugins');
        	$id = $this->_post('id');
        	$sort = $this->_post('sort');
        	if ( $sort != '' && is_numeric( $sort ) ){
        		$model->where("id='".$id."'")->setField('sort',$sort);
        	}
        }

		/**
	     +----------------------------------------------------------
	     * 保存对插件文件的编辑
	     +----------------------------------------------------------
	     * @access public 
	     +----------------------------------------------------------
	     */
	    public function save(){
	    	$count = file_put_contents($_POST["file"],stripslashes($_POST["content"]));
	    	if($count > 0){
	    		$msg = 'Widget文件';
	    		$info = getPluginInfos( $_POST['file'] );
	    		$where['id'] = $_POST['id'];
	    		$status = D('Plugins')->where( $where )->save( $info );
	    		if( $status !== false ) $msg .= ' , 数据表';
	    		$this->success( $msg . " 更新成功!");
	    	}else{
	    		$this->error("Widget失败!");
	    	}
	    }

	    public function forbid(){
			$this->_setStatus( 0, $_GET['id'], 'Plugins' );
		}
		
		public function resume(){
			$this->_setStatus( 1, $_GET['id'], 'Plugins' );
		}

		/**
	     +----------------------------------------------------------
	     * 写入插件缓存
	     +----------------------------------------------------------
	     * @access public 
	     +----------------------------------------------------------
	     */
	    protected function _writeWidget()
	    {
	        
	    }
		public function index(){
			$this->checkWidget();
			$widget_model = D("Plugins");
			$offWidget = $widget_model->where("type='widget' AND status='0'")->field("id,name,title,remark")->select();
			$onWidget = $widget_model->where("type='widget' AND status='1'")->field("id,name,title,remark")->order("priority")->select();

			$this->assign("offWidget",$offWidget);
			$this->assign("onWidget",$onWidget);
			$this->display();
		}

		/**
	     +----------------------------------------------------------
	     * 保存widget的顺序
	     +----------------------------------------------------------
	     * @access public 
	     +----------------------------------------------------------
	     */
		function widgetConfig()
		{
			$offWidget = explode('&',str_replace("offWidget[]=","",$_POST["offWidget"]));
			$onWidget = explode("&",str_replace("onWidget[]=","",$_POST["onWidget"]));

			$rs1 = $rs2 = true;
			$pluginDao = D("Plugins");
			if(!empty($offWidget))
				$where['id'] = array('in',$offWidget);
				$rs1 = $pluginDao->where($where)->setField("status","0");
			if(!empty($onWidget))
				$where['id'] = array('in',$onWidget);
				$rs2 = $pluginDao->where($where)->setField("status","1");

			//保存widget输出的顺序
			//$widgetArray = explode(",",$onWidget);
			foreach($onWidget as $key=>$id)
				$pluginDao->where("id='".$id."'")->setField("priority",($key+1));
			
			//$this->deleteFile( __ROOT_PATH__ . '/cache' );
			$this->success("保存widget配置成功");
		}

	}