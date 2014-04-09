<?php
	/**
	 * 侧边日历插件
	 * @author NickDraw
	 * @version 1.0
	 */
	class SideBarCalendarAddons extends NormalAddons
	{
		protected $version = '1.0';
		protected $author = 'NickDraw';
		protected $site = 'http://www.nickdraw.com';
		protected $info = '侧边栏日历插件，可按日期查询文档。';
		protected $pluginName = '侧边栏日历插件';
		protected $sqlfile = '暂无';
		protected $tsVersion = "1.0";
		protected $param = array("title"=>"日历挂件","color"=>"red");
		protected $hook = 'sidebar_calendar';
		protected $position = 'sidebar';
		
		/**
		 * 获的改插件使用了那些钩子聚合类，那些钩子是需要进行排序的
		 * @return void
		 */
		public function getHooksInfo()
		{
			$hooks['list'] = array('SideBarCalendarHooks');
			return $hooks;
		}

		/**
		 * 后台管理入口
		 * @return array 管理相关数据
		 */
		public function adminMenu()
		{
			// $menu = array('config'=>'侧边栏日历管理');
			// return $menu;
		}

		public function start()
		{

		}

		public function install()
		{
			return true;
		}

		public function uninstall()
		{
			return true;
		}
	}