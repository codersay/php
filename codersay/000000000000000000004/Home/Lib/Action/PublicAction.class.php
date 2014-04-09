<?php
class PublicAction extends Action{
	//生成验证码
	public function verify(){
		import('ORG.Util.Image');
		Image::buildImageVerify(4,1,gif,48,22,'verify');
	}
}
?>