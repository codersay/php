<?php
error_reporting(0);
session_start();

define('RUI_INSTALL',true);
define('INSTALL_PATH',str_replace("\\", '/', dirname(__FILE__)));
define('ROOT_PATH',substr( INSTALL_PATH, 0, -8 ) );

include ( 'install.inc.php' );

$installed = 'installed.lock';
$time = time();
$ip = getIp();
$installsql = 'sqldata.sql';
$dbconfig = 'dbconfig.inc.php';
$webconfig = 'webconfig.inc.php';

header('Content-Type: text/html; charset=utf-8');

if ( file_exists( $installed ) ){
	exit('确认要重新安装吗？如果是，请先删除' . $installed . '文件！');
}

if (!is_readable($installsql)){
	exit('数据库文件无法读取，请检查/install/'.$installsql.'是否存在。');
}

$quit = false;
$message = $alert = $link = $sql = $allownext = '';

$PHP_SELF = addslashes(htmlspecialchars($_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME']));
set_magic_quotes_runtime(0);
if (!get_magic_quotes_gpc()){
	add_Slashes($_POST);
	add_Slashes($_GET);
}
@extract($_POST);
@extract($_GET);
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<link href="images/style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../Public/common/jquery/jquery.js"></script>
		<script type="text/javascript">
			$(function(){
				setReSize();
				$(window).resize(setReSize);
				$('#agreementPrev').click(function(){
					window.location.href = '?step=' + ( $(this).attr('rel') - 1 );
				});
			});
			function setReSize(){
				var _h = $(window).height();
				var _warp_h = $('#warp').height() + 82;
				var _height = ( _h - _warp_h ) / 2;
				$('#warp').css('margin-top',_height);
			}
		</script>
		<title>RUIBlog 安装向导 </title>
	</head>
	<body>
		<div id="warp">
		<h1 style='line-height:40px'><img src='images/logo.png' width='35' height='35'/>RUIBlog安装程序</h1>
			<?php
				if ( !$step ){
			?>
			<script type="text/javascript">
				$(function(){
					$('#agreementNext').click(function(){
						if ( !$('#checkAgreement').attr('checked') ){
							alert('您需要先同意安装条款');
						}else{
							window.location.href="?step=1";
						}
					});
				});
			</script>
			<div id="content">
				<h1>RUIBlog协议许可</h1>
				<ul class="l1 nt">
					<h3>RUIBlog介绍</h3>
					<li>RUIBlog 是由 RUI 独立开发的博客系统，亦可作为CMS使用，基于PHP脚本和MySQL数据库。本程序源码开放的，任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行使用而无需缴纳程序使用费。</li>
					<li>官方网址： www.zhangenrui.cn</li>
					<li>为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：</li>
					<li>RUI(zhangenrui.cn) 为 RUIBlog 的作者，依法独立拥有RUIBlog产品著作权。</li>
	  				<li>用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用RUIBlog。</li>
	  				<li>zhangenrui.cn 有对本授权协议的最终解释权。</li>
  				</ul>
			  	<ul class="l1 nt">
			  		<h3>ONE--协议许可的权利</h3>
			  		<li>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用；</li>
			  		<li>您可以在协议规定的约束和限制范围内修改 RUIBlog 源代码或界面风格以适应您的网站要求；</li>
			  		<li>您拥有使用本软件构建的网站中全部资料、文章及相关信息的所有权，并独立承担与文章内容的相关法律义务；</li>
			  	</ul>
				<ul class="l1 nt">
  					<h3>TWO--协议规定的约束和限制</h3>
  					<li>不得对本软件进行出租、出售、抵押或发放子许可证；</li>
  					<li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用RUIBlog的整体或任何部分，未经书面许可，页面页脚处的 Powered by RUIBlog和官网网站的链接（http://www.zhangenrui.cn ）都必须保留，而不能清除或修改；</li>
  					<li>禁止NDlog的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发；</li>
  					<li>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。</li>
  				</ul>
  				<ul class="l1 nt">
  					<h3>THREE--有限担保和免责声明</h3>
  					<li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；</li>
  					<li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；</li>
  					<li>RUI(zhangenrui.cn)不对使用本软件构建的网站中的文章或信息承担责任。</li>
  				</ul>
				<p class="nt" style="padding-bottom:20px;">电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 RUIBlog 即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
			</div>
			<div class="ch_next">
				<p style="margin-top:15px; float:left;"><input type="checkbox" id="checkAgreement" value="1" /> 我同意以上条款。</p>
				<input type="button" id="agreementNext" value="继续" class="submit" style="float:right;margin-top:15px;" />
			</div>
			<?php
				}elseif( $step == '1' ){
					$dirarray = array (
						'backupdata',
						'install',
						'Public/config',
						'Public',
						'Uploads',
					);
					$writeable = array();
					foreach ($dirarray as $key => $dir){
						if (isWriteable($dir)){
							$writeable[$key] = $dir.getResult(1, 0);
						}else{
							$writeable[$key] = $dir.getResult(0, 0);
							$quit = true;
						}
					}
			?>
			<div id="content">
				<h1>系统环境检测</h1>
				<dl class="l1 nt">
					<dt>操作系统：</dt>
					<dd><?php echo PHP_OS;getResult(1, 1);?></dd>
				</dl>
				<dl class="l1 nt">
					<dt>PHP版本：</dt>
					<dd>
						<?php
							echo PHP_VERSION;
							if (PHP_VERSION < '5.1.2'){
								getResult(0, 1);
								$quit = true;
							}else{
								getResult(1, 1);
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>附件上传：</dt>
					<dd>
						<?php
							if (@ini_get('file_uploads')){
								echo '支持 / ' . @ini_get('upload_max_filesize');
							}else{
								echo '<span class="red">不支持</span>';
							}
							getResult(1, 1);
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>PHP扩展：</dt>
					<dd>
						<?php
							if (extension_loaded('mysql')){
								echo 'mysql:'.'支持';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：mysql</span>';
								getResult(0, 1);
								$quit = true;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('gd')){
								echo 'GD:支持';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：GD</span>';
								getResult(0, 1);
								$quit = true;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('curl')){
								echo 'curl:支持';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：curl</span>';
								getResult(0, 1);
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('openssl')){
								echo 'OpenSSL:支持(其他平台API同步需要)';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：OpenSSL(其他平台API同步需要)</span>';
								getResult(0, 1);
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('mbstring')){
								echo 'mbstring:支持';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：mbstring</span>';
								getResult(0, 1);
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>MySQL数据库：</dt>
					<dd>
						<?php
							if (function_exists('mysql_connect')){
								echo '支持';
								getResult(1, 1);
							}else{
								echo '<span class="red">您的服务器不支持MYSQL数据库，无法安装NDlog。</span>';
								getResult(0, 1);
								$quit = true;
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>目录和文件的写权限：</dt>
					<dd>
						<?php
							foreach ($writeable as $value){
								echo '<p>'.ROOT_PATH.'/'.$value.'</p>';
							}
							$conf_1 = ROOT_PATH . '/Public/config/' . $dbconfig;
							$conf_2 = ROOT_PATH . '/Public/config/' . $webconfig;
							if (is_writable($conf_2)){
								echo '<p>'.ROOT_PATH.'/Public/config/'.$webconfig.getResult(1, 0).'</p>';
							}else{
								echo '<p>'.ROOT_PATH.'/Public/config/'.$webconfig.getResult(0, 0).'</p>';
								$quit = true;
							}
							if (is_writable($conf_1)){
								echo '<p>'.ROOT_PATH.'/Public/config/'.$dbconfig.getResult(1, 0).'</p>';
							}else{
								echo '<p>'.ROOT_PATH.'/Public/config/'.$dbconfig.getResult(0, 0).'</p>';
								$quit = true;
							}
						?>
					</dd>
				</dl>
			</div>
			<div class="ch_next">
				<form action='index.php?step=2' method="post">
					<input type="button" id="agreementPrev" rel="1" value="后退" class="submit" style="float:left;margin-top:15px;" />
					<input type="submit" id="agreementNext" value="继续" class="submit" style="float:right;margin-top:15px;"<?php if($quit) echo " disabled=\"disabled\"";?> />
				</form>
			</div>
			<?php
				}elseif( $step == '2' ){
			?>
			<form action='index.php?step=3' method="post">
			<div id="content">
				<h1>数据库配置</h1>
				<dl class="l1 nt">
					<dt>数据库服务器：</dt>
					<dd>格式：地址(:端口)，一般为 localhost</dd>
					<dd><input type="text" name="db_host" value="localhost" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>数据库用户名：</dt>
					<dd></dd>
					<dd><input type="text" name="db_username" value="root" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>数据库密码：</dt>
					<dd></dd>
					<dd><input type="password" name="db_password" value="" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>数据库名：</dt>
					<dd></dd>
					<dd><input type="text" name="db_name" value="ruiblog" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>表名前缀：</dt>
					<dd></dd>
					<dd><input type="text" name="db_prefix" value="iqishe_" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>站点地址：</dt>
					<dd>网站URL地址</dd>
					<dd><input type="text" name="site_url" value="<?php echo "http://".$_SERVER['HTTP_HOST'].rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))),'/');?>" size="40" class='input' /></dd>
				</dl>
				
				<h1>管理员信息</h1>
				<dl class="l1 nt">
					<dt>管理员账户：</dt>
					<dd></dd>
					<dd><input type="text" name="first_user_id" value="admin" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>密码：</dt>
					<dd>为确保您网站管理的安全，密码建议大于6位数，并且是字母+数字或者符号</dd>
					<dd><input type="password" name="password" value="" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>重复密码：</dt>
					<dd></dd>
					<dd><input type="password" name="rpassword" value="" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>电子邮件：</dt>
					<dd></dd>
					<dd><input type="text" name="email" value="zer0131@vip.qq.com" size="40" class='input' /></dd>
				</dl>
			</div>
			<div class="ch_next">
				<input type="button" id="agreementPrev" rel="2" value="后退" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="继续" class="submit" style="float:right;margin-top:15px;"<?php if($quit) echo " disabled=\"disabled\"";?> />
			</div>
			</form>
			<script type="text/javascript">
				$(function(){
					//检测提交表单
					$('#agreementNext').click(function(){
						var db_host = $.trim( $('input[name="db_host"]').val() );
						var db_username = $.trim( $('input[name="db_username"]').val() );
						var db_name = $.trim( $('input[name="db_name"]').val() );
						var db_prefix = $.trim( $('input[name="db_prefix"]').val() );
						
						var first_user_id = $.trim( $('input[name="first_user_id"]').val() );
						var password = $.trim( $('input[name="password"]').val() );
						var rpassword = $.trim( $('input[name="rpassword"]').val() );
						if ( db_host == '' ){
							alert('请填写数据库地址，一般本机为localhost');
							return false;
						}
						if ( db_username == '' ){
							alert('请填写数据库用户名！');
							return false;
						}
						if ( db_name == '' ){
							alert('请填写数据库名！');
							return false;
						}
						if ( db_prefix == '' ){
							alert('表前缀不可为空！');
							return false;
						}
						if ( first_user_id == '' ){
							alert('管理员账号必须填写！');
							return false;
						}
						if ( password == '' ){
							alert('请设置管理员密码！');
							return false;
						}
						if ( password != rpassword ){
							alert('两次输入的密码不同，情重新设置！');
							return false;
						}
					});
				});
			</script>
			<?php
				}elseif( $step == '3' ){
			?>
			<div id="content">
				<?php
					if(empty($db_host) || empty($db_username) || empty($db_name) || empty($db_prefix)){
						$message .= '<p class="message">数据库配置信息不完整<p>';
						$quit = true;
					}elseif (!@mysql_connect($db_host, $db_username, $db_password)){
						$message .= '<p class="message">'.mysql_error().'</p>';
						$quit = true;
					}
					if(strstr($db_prefix, '.')){
						$message .= '<p class="message">您指定的数据表前缀包含点字符(".")，请返回修改。</p>';
						$quit = true;
					}
					if ($password != $rpassword){
						$message .= '<p class="message">两次输入的密码不一致</p>';
						$quit = true;
					}elseif (!preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/i', $email)){
						$message .= '<p class="message">电子邮件格式不正确</p>';
						$quit = true;
					}else{
						$forbiddencharacter = array ("\\","&"," ","'","\"","/","*",",","<",">","\r","\t","\n","#","$","(",")","%","@","+","?",";","^");
						foreach ($forbiddencharacter as $value){
							if (strpos($username, $value) !== FALSE){
								$message .= '<p class="message">账户包含非法字符</p>';
								$quit = true;
								break;
							}
						}
					}
					
					if ($quit){
						$allownext = ' disabled="disabled"';
						echo "<h1 class=\"error\">错误</h1>";
						echo $message;
					}else{
						$conf = array();
						$conf['db_host'] = $db_host;
						$conf['db_name'] = $db_name;
						$conf['db_username'] = $db_username;
						$conf['db_password'] = $db_password;
						$conf['db_prefix'] = $db_prefix;
						$conf['db_pconnect'] = 0;
						$conf['db_charset'] = 'utf8';
						$conf['dbType'] = 'mysql';

						$account = array();
						$account['account'] = $first_user_id;
						$account['email'] = $email;
						$account['password'] = md5($password);

						$_SESSION['conf'] = $conf;
						$_SESSION['account'] = $account;
						$_SESSION['FUID'] = $first_user_id;
						$_SESSION['HURL'] = $site_url;
					?>
					<ul class="l1 nt">
						<li><?php echo '管理员帐号: ' . $first_user_id?></li>
						<li><?php echo '密码: ' . $password;?></li>
					</ul>
					<?php
						$conf_epath = ROOT_PATH . '/Public/config/' . $dbconfig;
						$conf_webpath = ROOT_PATH . '/Public/config/' . $webconfig;
						$fp = fopen( $conf_epath , 'wb');
						$conf_cont = <<<EOT
<?php
/*数据库配置信息*/
return array(
	'DB_TYPE' => 'mysql',
	'DB_HOST' => '$db_host',
	'DB_NAME' => '$db_name',
	'DB_USER' => '$db_username',
	'DB_PWD' => '$db_password',
	'DB_PORT'  => '3306',
	'DB_PREFIX' => '$db_prefix',
	'RBAC_ROLE_TABLE' => '{$db_prefix}role',
	'RBAC_USER_TABLE'=>'{$db_prefix}role_user',
	'RBAC_ACCESS_TABLE'=>'{$db_prefix}access',
	'RBAC_NODE_TABLE'=>'{$db_prefix}node',
);
?>
EOT;
						chmod( $conf_epath, 0777 );
						$getResult_1 = fwrite($fp, trim($conf_cont));
						@fclose($fp);
						if($getResult_1 && file_exists($conf_epath)){
							echo '<p class="smessage">数据库配置信息写入完成</p>';
						}else{
							echo '<p class="message">数据库配置文件写入错误，请检查'.$conf_epath.'文件是否存在或属性是否为777</p>';
							$quit = true;
						}
						$webconfarr = require($conf_webpath);
						$webconfarr['CFG_INDEXURL'] = $site_url;
						$confcontent = "<?php\n";
						$confcontent .= "/*网站配置信息*/\nreturn ".var_export($webconfarr, true).";\n?>";
						if(file_put_contents($conf_webpath, $confcontent) && file_exists($conf_webpath)){
							echo '<p class="smessage">网站配置信息写入完成</p>';
						}
						else{
							echo '<p class="message">网站配置文件写入错误，请检查'.$conf_webpath.'文件是否存在</p>';
							$quit = true;
						}
					}
				?>
			</div>
			<div class="ch_next">
			<form method="post" action="index.php?step=4">
				<input type="button" id="agreementPrev" rel="3" value="后退" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="继续" class="submit" style="float:right;margin-top:15px;"<?php echo $allownext;?> />
			</form>
			</div>
			<?php
				}elseif($step == '4'){
			?>
			<div id="content">
				<?php
					$db_config = $_SESSION['conf'];
					if (!$db_config['db_host'] && !$db_config['db_name']){
						$message .= '<p class="message">数据库配置失败</p>';
						$quit = true;
					}else{
						mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
						$sqlv = mysql_get_server_info();
						if($sqlv < '4.1'){
							$message .= '<p class="message">您的 MYSQL 版本低于 4.1.0，安装无法继续进行！</p>';
							$quit = true;
						}else{
							$db_charset = $db_config['db_charset'];
							$db_charset = (strpos($db_charset, '-') === false) ? $db_charset : str_replace('-', '', $db_charset);

							mysql_query("CREATE DATABASE IF NOT EXISTS `{$db_config['db_name']}` DEFAULT CHARACTER SET $db_charset");

							if (mysql_errno()){
								$errormsg = mysql_error();
								$message .= '<p class="message">'.($errormsg ? $errormsg : '程序在执行数据库操作时发生了一个错误，安装过程无法继续进行。').'</p>';
								$quit = true;
							}else{
								mysql_select_db($db_config['db_name']);
							}

							//判断是否有用同样的数据库前缀安装过
							$re = mysql_query("SELECT COUNT(1) FROM `{$db_config['db_prefix']}users`");
							$link = @mysql_fetch_row($re);

							if( intval($link[0]) > 0 ){
								$rebuild = true;
								$message .= '<p class="message">数据库中已经安装过 RUIBlog，继续安装会清空原有数据！</p>';
								$alert = ' onclick="return confirm(\'数据库中已经安装过 RUIBlog，继续安装会清空原有数据！\');"';
							}
						}
					}
					if ( $quit ){
						$allownext = 'disabled="disabled"';
						echo '<h1>错误</h1>';
						echo $message;
					}else{
						if ( $rebuild ){
							echo '<p class="message" style="color:red;font-size:16px;">数据库中已经安装过 RUIBlog，继续安装会清空原有数据！</p>';
						}
						echo '<p class="smessage">点击"继续"开始导入数据</p>';
					}
				?>
			</div>
			<div class="ch_next">
			<form method="post" action="index.php?step=5">
				<input type="button" id="agreementPrev" rel="4" value="后退" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="继续" class="submit" style="float:right;margin-top:15px;"<?php echo $allownext,$alert?> />
			</form>
			</div>
			<?php
				}elseif($step == '5'){
					$db_config = $_SESSION['conf'];
					mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
					if (mysql_get_server_info() > '5.0'){
						mysql_query("SET sql_mode = ''");
					}
					$db_config['db_charset'] = (strpos($db_config['db_charset'], '-') === false) ? $db_config['db_charset'] : str_replace('-', '', $db_config['db_charset']);
					mysql_query("SET character_set_connection={$db_config['db_charset']}, character_set_getResults={$db_config['db_charset']}, character_set_client=binary");
					mysql_select_db($db_config['db_name']);
					$tablenum = 0;

					$fp = fopen($installsql, 'rb');
					$sql = fread($fp, filesize($installsql));
					fclose($fp);
					
					$db_charset = $db_config['db_charset'];
					$db_prefix = $db_config['db_prefix'];
					$sql = str_replace("\r", "\n", str_replace('`'.'iqishe_', '`'.$db_prefix, $sql));
					$create_table_info = '';
					$arrsql = explode(";\n", trim($sql));
					foreach($arrsql as $query){
						$query = trim($query);
						if($query) {
							if(substr($query, 0, 12) == 'CREATE TABLE'){
								$name = preg_replace("/(CREATE TABLE) `([a-z0-9_]+)` .*/is", "\\2", $query);
								$create_table_info .= '<dd>创建表 '.$name.'&nbsp;&nbsp;(<span class="blue">OK</span>)</dd>';
								@mysql_query(createTable($query, $db_charset));
								$tablenum ++;
							}else{
								if(substr($query,0,11) == 'INSERT INTO'){
									@mysql_query("SET NAMES $db_charset");//解决中文乱码
								}
								@mysql_query($query);
							}
						}
					}
			?>
			<div id="content" style="height:448px;">
				<dl class="l1 nt">
					<dt>导入数据库</dt>
					<?php echo $create_table_info; ?>
				</dl>
				<dl class="l1 nt">
					<dt>创建管理员帐户</dt>
					<?php
						//清空管理员表
						$dpsql = "TRUNCATE TABLE  `{$db_config['db_prefix']}users`";
						if( mysql_query($dpsql) ){
							echo '<dd>用户表清理完成&nbsp;&nbsp;(<span class="blue">OK</span>)</dd>';
						} else {
							echo '<dd>用户表清理失败&nbsp;&nbsp;(<span class="red">ERROR</span>)</dd>';
							$quit = true;
						}
						
						//添加管理员
						$siteAdmin = $_SESSION['account'];

						$sql1 = "INSERT INTO `{$db_config['db_prefix']}users` (`uid`, `username`, `pwd`, `bindaccount`, `logintime`, `loginip`, `createtime`, `updatetime`, `status`, `email`, `isadmin`) VALUES ('1', '{$siteAdmin['account']}', '{$siteAdmin['password']}', '', '0', '', ".time().", ".time().", '1', '{$siteAdmin['email']}','1');";

						if( mysql_query($sql1) ){
							echo '<dd>管理员设置成功&nbsp;&nbsp;(<span class="blue">OK</span>)</dd>';
						} else {
							echo '<dd>管理员设置失败&nbsp;&nbsp;(<span class="red">ERROR</span>)</dd>';
							$quit = true;
						}

						if(!$quit){
							//锁定安装
							fopen( $installed, 'w' );
						}else{
							echo '请重新安装';
						}
					?>
				</dl>
				<dl class="l1 nt">
					<dt>安装成功</dt>
					<dd>安装程序执行完毕，请尽快删除整个 install 目录，以免被他人恶意利用。如要重新安装，请删除本目录的 <?php echo $installed; ?> 文件！</dd>
					<dd><a href="../index.php">开始体验RUIBlog</a></dd>
					<dd><a href="../admin.php">后台管理</a></dd>
				</dl>
			</div>
			<?php
				}
			?>
		</div>
	</body>
</html>