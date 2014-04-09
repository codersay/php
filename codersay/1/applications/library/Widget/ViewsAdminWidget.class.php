<?php
	/*
		Widget Name: ViewsAdmin
		Widget URI: http://www.ndlog.com/
		Remark: 前台管理员登录状态下管理快捷操作。
		Title: 快捷操作
		Author: NickDraw
		Version: 1.0
		Author URI: http://www.ndlog.com/
		Position: other
		Param: 
	*/
	class ViewsAdminWidget extends Widget{
		public function render($data) {
			$html = '';
			if ( $_SESSION['AUTH'] ){
				$href = '<a href="/m.php?m=archiver&a=edit&id='.$data['id'].'&cid='.$data['cid'].'&type='.$data['type'].'&node=2">修改</a>';
				$href .= ' &nbsp;&nbsp;&nbsp; ';
				$href .= '<a href="/m.php?m=archiver&a=delete&id='.$data['id'].'&cid='.$data['cid'].'">删除</a>';
				switch ($data['page']) {
					case 'index':
						$html .= '<dd class="dd admin_action">';
						$html .= $href;
						$html .= '</dd>';
						break;
					case 'views':
						$html .= '<div class="admin_action">';
						$html .= $href;
						$html .= '</div>';
						break;
					default :
						$html .= $href;
						break;
				}
			}
			return $html;
		}
	}