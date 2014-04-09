<?php
/**
 * @用户管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class UsersAction extends CommonAction{
	public function index(){
		$userobj = M('Users');
		$map['1'] = 1;
		$prefix = C('DB_PREFIX');

		//根据角色显示用户
		if(!empty($_GET['rid'])){
			$map[$prefix.'role_user.role_id'] = $_GET['rid'];
		}

		$page = $this->paging($userobj,$map);

		//关联查询
		$list = $userobj->field('uid,username,logintime,loginip,createtime,'.$prefix.'users.status,isadmin,'.$prefix.'role_user.role_id,'.$prefix.'role_user.user_id,'.$prefix.'role.name')->join($prefix.'role_user on '.$prefix.'users.uid='.$prefix.'role_user.user_id')->join($prefix.'role on '.$prefix.'role.id='.$prefix.'role_user.role_id')->where($map)->limit($page->firstRow . ',' . $page->listRows)->order('createtime desc')->select();
		foreach($list as $key => $val){
			//获取角色
			if($val['isadmin'] == 1){
				$list[$key]['role'] = '管理员';
			}
			else{
				//$uid = $val['uid'];
				//$rolerow = $this->getRoleByUser($uid);
				$list[$key]['role'] = $val['name'];
			}

			//获取博文数
			$list[$key]['arcnum'] = M('Article')->where(array('username'=>$val['username']))->count();
		}
		$this->assign('page', $page->show());
		$this->assign('list', $list);
		$this->display();
	}

	//增加用户
	public function add(){
		$this->assign('rolelist', D('Role')->getRoleList());
		$this->display();
	}

	//保存新增用户
	public function addsave(){
		$userobj = D('Users');
		$form = $userobj->create();
		if(!$form){
			$this->error(($userobj->getError()));
		}

		//密码一致性处理
		if(trim($_POST['pwd']) != trim($_POST['confirmpwd'])){
			$this->error('两次输入的密码不一致！');
		}

		$userobj->pwd = md5(trim($_POST['pwd']));

		$return = $userobj->add();

		//用户角色处理
		if($_POST['isadmin'] == 0){
			if($_POST['userrole'] == 0){
				$this->error('请选择用户角色！');
			}
			$data['role_id'] = $_POST['userrole'];
			$data['user_id'] = $return;
			M('RoleUser')->add($data);
		}

		$this->message($return,'__GROUP__/Users/index','新增成功！','新增失败！');
	}

	//编辑显示
	public function edit(){
		$uid = $_GET['uid'];
		if(empty($uid)){
			$this->error('编辑项不存在！');
		}
		$map['uid'] = $uid;
		$data = D('Users')->where($map)->find();
		if($data){
			//处理用户角色
			if($data['isadmin'] == 0){
				$rolerow = $this->getRoleByUser($data['uid']);
				$this->assign('rolelist', D('Role')->getRoleList($rolerow['id']));
			}
			else{
				$this->assign('rolelist', D('Role')->getRoleList());
			}
		}
		$this->assign('data',$data);
		$this->display();
	}

	//更新
	public function update(){
		$userobj = D('Users');
		$form = $userobj->create();
		if(!$form){
			$this->error(($userobj->getError()));
		}
		$return = $userobj->save();

		//用户角色处理
		$ruobj = M('RoleUser');
		$map['user_id'] = $_POST['uid'];
		if($_POST['isadmin'] == 0){
			if($_POST['userrole'] == 0){
				$this->error('请选择用户角色！');
			}
			$data['role_id'] = $_POST['userrole'];
			$result = $ruobj->where($map)->find();
			if($result == null){
				$data['user_id'] = $_POST['uid'];
				$ruobj->add($data);
			}
			else{
				$ruobj->where($map)->save($data);
			}
		}
		else{
			$result = $ruobj->where($map)->find();
			if($result){
				$ruobj->where($map)->delete();
			}
		}

		$this->message($return,'__GROUP__/Users/index','更新成功！','更新失败！');
	}

	//删除
	public function del(){
		$uid = $_GET['uid'];
		if($_SESSION[C('USER_AUTH_KEY')] == $uid){
			$this->error('当前正在使用不可删除！');
		}
		$userobj = D('Users');

		//删除用户角色表中数据
		$row = $userobj->field('isadmin')->where(array('uid'=>$uid))->find();
		if($row['isadmin'] == 0){
			M('RoleUser')->where(array('user_id'=>$uid))->delete();
		}

		$result = $userobj->where(array('uid'=>$uid))->delete();
		$this->message($result,'__GROUP__/Users/index','删除成功！','删除失败！');
	}

	//修改密码显示
	public function pwd(){
		$this->assign('uid',$_SESSION[C('USER_AUTH_KEY')]);
		$this->display();
	}

	//修改密码提交
	public function changePwd(){
		if(empty($_POST['oldpwd'])){
			$this->error('请填写原始密码！');
		}
		if (empty($_POST['newpwd'])){
			$this->error('请填写新密码！');
		}
		if (empty($_POST['confirmpwd'])){
			$this->error('请填写确认密码！');
		}
		if(empty($_POST['verify'])){
			$this->error('请填写验证码！');
		}
		$verify = $_POST['verify'];
		if(session('verify') != md5($verify)){
			$this->error('验证码错误！');
		}
		$userrow = M('Users')->where(array('uid'=>$_POST['uid']))->find();
		$pwd = $userrow['pwd'];
		if($pwd != md5($_POST['oldpwd'])){
			$this->error('原始密码不正确！');
		}
		if($_POST['newpwd'] != $_POST['confirmpwd']){
			$this->error('两次输入的密码不一致！');
		}
		$data['pwd'] = md5($_POST['newpwd']);
		$result = M('Users')->where(array('uid'=>$_POST['uid']))->save($data);
		$this->message($result,'__GROUP__/Users/pwd','密码修改成功！','密码修改失败！');
	}

	//禁用或启用
	public function updown(){
		$uid = $_GET['uid'];
		if($_SESSION[C('USER_AUTH_KEY')] == $uid){
			$this->error('当前正在使用不可更改状态！');
		}
		$isup = $_GET['isup'];
		$map['uid'] = $uid;
		if($isup == 1){
			$data['status'] = 1;
			$result = D('Users')->where($map)->save($data);
		}
		else{
			$data['status'] = 0;
			$result = D('Users')->where($map)->save($data);
		}
		$this->message($result,'__GROUP__/Users/index');
	}
}
?>