<?php
  $configfile="../Admin/Conf/db_config.inc.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>wBlog博管系统 by www.w3note.com</title>
<link href="./install.css" rel="stylesheet" type="text/css" />
</head>
   <div class="fieldset">
	  <span class="legend">wBlog博客管理系统</span>
   <div id="result" class="none result" style="font-family:微软雅黑,Tahoma;margin-bottom: 10px;font-size:18px;color:green;text-align:center">
   </div>
    <ul><li style="color:green; font-size:16px;text-align:center;list-style:none;">
 <?php
  if(!is_writable($configfile)) exit("<font color=red>不可写！</font><a href='install.php'>返回修改</a>");
  $data=array();
  if(isset($_POST['install'])){
	  if(trim($_POST['adminpwd'])!==trim($_POST['readminpwd'])) exit("<font color=red>管理员密码输入不一致！</font><a href='install.php'>返回修改</a>");
	  $data['db_type']='mysql';
	  $data['db_host']=$_POST['db_host'];
	  $data['db_user']=$_POST['db_user'];
	  $data['db_pwd']=$_POST['db_pwd'];
	  $data['db_name']=$_POST['db_name'];
	  $data['db_prefix']=$_POST['db_prefix'];
	  $data['rbac_role_table']=$_POST['db_prefix'].'role';
	  $data['rbac_user_table']=$_POST['db_prefix'].'role_user';
	  $data['rbac_access_table']=$_POST['db_prefix'].'access';
	  $data['rbac_node_table']=$_POST['db_prefix'].'node';
	  $data['keycode']=create_keycode(6);
	  $admin=trim($_POST['admin']);
	  $adminpwd=$_POST['adminpwd'];
	  $content = "<?php\r\n//w3note.com WBlog配置文件\r\nif (!defined('W3CORE_PATH')) exit();\r\nreturn array(\r\n";
		foreach ($data as $key=>$value){
			$key=strtoupper($key);
			if(strtolower($value)=="true" || strtolower($value)=="false" || is_numeric($value)){
				$content .= "\t'$key'=>$value, \r\n";
			}else
				$content .= "\t'$key'=>'$value',\r\n";
		}
		$content .= ");\r\n?>";
      	$r=@chmod($configfile,0777);
		$hand=file_put_contents($configfile,$content);
		if (!$hand) {
			 exit($file.'配置文件写入失败！');
		}
   
	define('W3CORE_PATH','./W3Core');
	$db_config=include_once ($configfile);
	$adminpwd=md5(md5(trim($adminpwd)).$db_config['KEYCODE']);
    if (!@$link = mysql_connect($db_config['DB_HOST'], $db_config['DB_USER'], $db_config['DB_PWD'])) { //检查数据库连接情况
		echo "<font color=red>数据库连接失败! 请返回上一页检查连接参数</font> <a href=install.php>返回修改</a>";
	} else {
       
	if(mysql_get_server_info() > '4.1') {
		mysql_query("CREATE DATABASE IF NOT EXISTS `".$db_config['DB_NAME']."` ", $link);
		mysql_query("set names utf8");
	} else {
		//mysql_query("CREATE DATABASE IF NOT EXISTS `".$db_config['DB_NAME']."`", $link);
		mysql_query("set names utf8");
	}
	
	   if(!mysql_select_db($db_config['DB_NAME'])){
		   exit("<font color=red>找不到数据库：".$db_config['DB_NAME']."</font><a href='install.php'>返回修改</a>");
		};
	?>
	
    <?php
	  $db_prefix=$db_config['DB_PREFIX'];
      include_once ("sql_query.php"); //嵌入数据表文件
      
		foreach($sqls as $sql){
			$result[]=mysql_query($sql);
			
		}
		if($result !==false) echo"安装成功，欢迎使用！^_^";
		rename("install.php","install.lock");
      
    }

  }
    mysql_close($link);
	
?>
</li>
<li style="text-align:center;list-style:none;margin-top: 10px;"> <a href="../admin.php">进入后台</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;<a href="../index.php">浏览前台</a></li>
</ul>
</div>
<?php
 function create_keycode($lenth) {
	   return random($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
    }

 function random($length, $chars = '0123456789') {
	  $hash = '';
	  $max = strlen($chars) - 1;
	  for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	  }
	   return $hash;
     }
?>