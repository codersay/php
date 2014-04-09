<?php
/**
 * @公用控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/05
 * @Copyright: www.iqishe.com
 */
class CommonAction extends Action{
	//初始化页面
	public function _initialize(){
		// 用户权限检查
		if (C('USER_AUTH_ON') && !in_array(MODULE_NAME, explode(',', C('NOT_AUTH_MODULE')))) {
			import('ORG.Util.RBAC');
			if (!RBAC::AccessDecision()) {
				//检查认证识别号
				if (!$_SESSION [C('USER_AUTH_KEY')]) {
					//跳转到认证网关
					redirect(PHP_FILE . C('USER_AUTH_GATEWAY'));
				}
				// 没有权限 抛出错误
				if (C('RBAC_ERROR_PAGE')) {
					// 定义权限错误页面
					redirect(C('RBAC_ERROR_PAGE'));
				} else {
					if (C('GUEST_AUTH_ON')) {
						$this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
					}
					// 提示错误信息
					$this->error(L('_VALID_ACCESS_'));
				}
			}
		}
	}

	//获得模型的ID
	public function getMidId($mname) {
		$map['maction'] = $mname;
		$data = D('Model')->where($map)->find();
		$mid = (int)$data['mid'];
		return $mid;
	}

	//分页
	public function paging($obj,$where='',$pagesize='12'){
		import("ORG.Util.Page");
		$count = $obj->where($where)->count();
		$pageobj = new Page($count,$pagesize);
		$pageobj->setConfig('header', '条');
		$pageobj->setConfig('prev', "<");
		$pageobj->setConfig('next', '>');
		$pageobj->setConfig('first', '<<');
		$pageobj->setConfig('last', '>>');
		return $pageobj;
	}

	//判断是否选中checkbox
	public function isCheckBox($ids){
		if(!$ids){
			return false;
		}
		else{
			return true;
		}
	}

	//消息提示
	public function message($result,$backurl,$successmsg='操作成功！',$errormsg='操作失败！'){
		if (false === $result) {
			$this->error($errormsg);
		} 
		else {
			$this->success($successmsg,$backurl);
		}
	}

	//根据用户获得角色
	public function getRoleByUser($uid){
		$roleuser = M('RoleUser')->where(array('user_id'=>$uid))->find();
		$roleid = $roleuser['role_id'];
		$rolerow = M('Role')->where(array('id'=>$roleid))->find();
		return $rolerow;
	}
}
?>