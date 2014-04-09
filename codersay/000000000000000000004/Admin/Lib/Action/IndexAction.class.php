<?php
/**
 * @后台首页控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/05
 * @Copyright: www.iqishe.com
 */
class IndexAction extends CommonAction {
	//后台首页入口
	public function index(){
		$this->assign('username',$_SESSION['loginUserName']);
		$this->display();
    }

	//菜单显示
	public function menu(){
		$this->display();
	}

	//显示主窗体
	public function main(){
		//设置系统信息
		$info = array(
			'PHP版本' => PHP_VERSION,
			'操作系统' => PHP_OS,
			'运行环境' => $_SERVER["SERVER_SOFTWARE"],
			'上传限制' => ini_get('upload_max_filesize'),
			'服务器域名' => $_SERVER['SERVER_NAME'].' [ '.gethostbyname($_SERVER['SERVER_NAME']).' ]',
			'Register_Globals' => get_cfg_var("register_globals")=="1" ? "ON" : "<font color='red'>OFF</font>",
			'Magic_Quotes_Gpc' => (1===get_magic_quotes_gpc())?'ON':"<font color='red'>OFF</font>",
			'版本信息' => 'RUIBlog_1.0.0'
		);
		$this->assign('info',$info);

		$role = '';
		//获取用户角色
		if($_SESSION[C('ADMIN_AUTH_KEY')] === true){
			$role = '管理员';
		}
		else{
			$uid = $_SESSION[C('USER_AUTH_KEY')];
			$roleuser = M('RoleUser')->where(array('user_id'=>$uid))->find();
			$roleid = $roleuser['role_id'];
			$rolerow = M('Role')->where(array('id'=>$roleid))->find();
			$role = $rolerow['name'];
		}
		$this->assign('role',$role);

		//设置统计信息
		$this->assign('blognu',M('Article')->count());
		$this->assign('commentnum',M('Comment')->where(array('pid'=>0))->count());
		$this->assign('feednum',M('Feedback')->count());


		//设置最新文档
		$list = M('Article')->order('createtime desc')->limit(5)->select();
		$this->assign('list',$list);

		$this->display();
	}
}