<?php
/**
 * @系统配置管理控制器
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/10
 * @Copyright: www.iqishe.com
 */

class ConfigAction extends CommonAction{
	public function index(){
		$confpath = './Public/config/webconfig.inc.php';
		$webconfig = require($confpath);
		$this->assign('config',$webconfig);
		$this->display();
	}

	//更新配置文件(写入)
	public function update(){
		$confpath = './Public/config/webconfig.inc.php';
		$webconfig = require($confpath);
		$dirname = dirname( $confpath );
		if (!is_dir( $dirname )){
			$this->error('配置文件不存在！');
		}
		foreach($_POST['conf'] as $key => $val){
			$array[$key] = trim( $val );
		}
		$confcontent = "<?php\n";
		$confcontent .= "/*网站配置信息*/\nreturn ".var_export($array, true).";\n?>";
		if (file_put_contents($confpath, $confcontent)){
			$this->success('修改配置成功！',U('Config/index'));
		}
		else{
			$this->error('修改配置失败！');
		}
	}
}
?>