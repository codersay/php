<?php

	class PluginsAction extends CommonAction{

		public function _initialize(){
			parent::_initialize();
			import("Core.Addons",CORE_PATH);
			import("addons.Hooks",CORE_PATH);
			import("addons.AbstractAddons",CORE_PATH);
			import("addons.NormalAddons",CORE_PATH);
			import("addons.SimpleAddons",CORE_PATH);
            Addons::loadAllValidAddons();
		}

		public function _before_index(){
			$model = model('Addon');
		    $admin = $model->getAddonsAdmin();
	        $result = $model->getAddonAllList();
	        foreach($result['valid']['data'] as $key=>$value){
	            foreach($admin as $v){
	                if($v[1] == $value['addonId']) $result['valid']['data'][$key]['admin'] = true;
	            }
	        }
	     
			$this->assign('list', $result);
		}

		/**
	     * 开启插件操作
	     * @return void
	     */
		public function startAddon()
		{
			$result = model('Addon')->startAddons(replaceHtmls($_GET['name']));
			if(true === $result) {
				$this->success('启用成功');
			} else {
				$this->error('启动失败');
			}
		}

	    /**
	     * 停止插件操作
	     * @return void
	     */
		public function stopAddon()
		{
			$result = model('Addon')->stopAddonsById(intval($_GET['addonId']));
			if(true === $result) {
				$this->success('停用成功');
			} else {
				$this->error('停用失败');
			}
	    }

	    /**
	     * 卸载插件操作
	     * @return void
	     */
	    public function uninstallAddon()
	    {
			$result = model('Addon')->uninstallAddons(replaceHtmls($_GET['name']));
			if(true === $result) {
				$this->success('卸载成功');
			} else {
				$this->error('卸载失败');
			}
	    }

	    /**
	     * 插件后台管理页面
	     * @return void
	     */
		public function admin()
		{
	        $addon = model('Addon')->getAddonObj(intval($_GET['pluginid']));
	        $addonInfo = model('Addon')->getAddon(intval($_GET['pluginid']));
	        if(!$addon) $this->error('插件未启动或插件不存在');
	        $info = $addon->getAddonInfo();
	        $adminMenu = $addon->adminMenu();
	        if(!$adminMenu){
	            $this->assign('addonName',$info['pluginName']);
	            $this->assign('menu',false);
	            $this->display();
	            return;
	        }
	        $this->assign('menu', $adminMenu);
	        if(!isset($_GET['page'])){
	        	$amarr = array_keys($adminMenu);
	            $_GET['page'] = $page = array_shift($amarr);
	        }else{
	            $page = replaceHtmls($_GET['page']);
	        }
	        $title = ( isset( $addonInfo['pluginName'] ) ) ? $addonInfo['pluginName'] : $addonInfo['title'];
	        $this->assign('page',$page);
	        $this->assign('addonName',$title);
	        $this->assign('name',$addonInfo['name']);
	        $this->assign('isAjax',$this->isAjax());
	        $this->display();
	    }

	    public function doAdmin()
	    {
	    	
	        $addonInfo = model('Addon')->getAddon(intval($_GET['pluginid']));
	        $result = array('status'=>true,'info'=>"");
	           
	        F('Cache_App',null);
	        
	        Addons::addonsHook($addonInfo['name'],replaceHtmls($_GET['page']),array('result' => & $result),true);
	        
	        //dump($result);
	       
	        if($result['status']){
	        	$_POST['jumpUrl'] && $this->assign('jumpUrl', $_POST['jumpUrl']);
	            $this->success($result['info']);
	        }else{
	            $this->error($result['info']);
	        }
	    }

	    public function updateOneSort(){
        	$model = D('Plugins');
        	$id = $this->_post('id');
        	$sort = $this->_post('sort');
        	if ( $sort != '' && is_numeric( $sort ) ){
        		$model->where("id='".$id."'")->setField('sort',$sort);
        	}
        }

	}

