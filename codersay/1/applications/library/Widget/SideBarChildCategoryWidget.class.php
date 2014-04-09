<?php

	/*

		Widget Name: SideBarChildCategory

		Widget URI: http://www.codersay.net/

		Remark: 侧边栏子及分类列表，用于多级分类选择。

		Title: 侧边栏子及分类

		Author: NickDraw

		Version: 1.0

		Author URI: http://www.codersay.net/

		Position: sidebar

		Param: {"title":"分类列表"}

	*/

	class SideBarChildCategoryWidget extends Widget{

		public function render($data) {

			$var = array();

			$catalog = $_GET['catalog'];

			if ( strtolower( MODULE_NAME ) == 'index' && strtolower( ACTION_NAME ) == 'index' ){

				$catalog = 0;

			}

			$var['category'] = array();

			if ( $catalog ){

				$category = $this->getCategory();

				foreach ($category as $key => $value) {

					if ( $value['pid'] == $catalog ) $var['category'][$key] = $value;

				}

			}

			$var = array_merge( $data, $var );

			// 渲染模版

	        $content = $this->renderFile('listCategory', $var);

	        // 输出数据

	        return $content;

		}



		private function getCategory(){

			$list = S('CategoryList');

			if ( !$list ){

				$model = M('Category');

				$where = array(

						'status'		=> 1

				);

				$list = $model->where($where)->order('sort')->select();

				S('CategoryList',$list);

			}

			return $list;

		}



	}