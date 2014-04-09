<?php
	/**
	 +=========================================================
	 * NDlog 个人单用户博客系统
	 * index.php 入口文件
	 +=========================================================
	 * @copyright © 2012 nickdraw.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.nickdraw.com/license
	 +=========================================================
	 */
	error_reporting(0);
	session_start();
	
	define('ND_INSTALL',true);
	define( '__INSTALL_PATH__' , str_replace("\\", '/', dirname(__FILE__) ) );
	define( '__ROOT_PATH__' , substr( __INSTALL_PATH__, 0, -8 ) );
	
	include ( 'install.fun.php' );
	
	$installed = 'installed.lock';
	$time = time();
	$ip = getIP();
	$installsql = 'NDlog.sql';
	$configs = 'db.inc.php';
	$settings = 'settings.inc.php';
	
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
		addS($_POST);
		addS($_GET);
	}
	@extract($_POST);
	@extract($_GET);
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<link href="style.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="../static/js/jQuery/jquery.js"></script>
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
		<title>NDlog 安装向导 </title>
	</head>
	<body>
		<div id="warp">
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
				<h1>NDlog 安装向导</h1>
				<p class="l1 nt">版权所有 &copy; 2011 - <?php echo date('Y'); ?>，NickDraw.com 保留所有权利。</p>
				<ul class="l1 nt">
					<li>NDlog 是由 NickDraw 独立开发的单用户博客类建站程序，基于PHP脚本和MySQL数据库。本程序源码开放的，任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行使用而无需缴纳程序使用费。</li>
					<li>官方网址： www.nickdraw.com</li>
					<li>为了使你正确并合法的使用本软件，请你在使用前务必阅读清楚下面的协议条款：</li>
					<li>NickDraw(nickdraw.com) 为 NDlog 的作者，依法独立拥有NDlog产品著作权。</li>
	  				<li>用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 NDlog。</li>
	  				<li>nickdraw.com 有对本授权协议的最终解释权。</li>
  				</ul>
			  	<dl class="l1 nt">
			  		<dt>壹、协议许可的权利</dt>
			  		<dd>您可以在完全遵守本最终用户授权协议的基础上，将本软件应用于非商业用途，而不必支付软件版权授权费用；</dd>
			  		<dd>您可以在协议规定的约束和限制范围内修改 NDlog 源代码或界面风格以适应您的网站要求；</dd>
			  		<dd>您拥有使用本软件构建的网站中全部资料、文章及相关信息的所有权，并独立承担与文章内容的相关法律义务；</dd>
			  	</dl>
				<dl class="l1 nt">
  					<dt>贰、协议规定的约束和限制</dt>
  					<dd>不得对本软件进行出租、出售、抵押或发放子许可证；<dt>
  					<dd>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用NDlog的整体或任何部分，未经书面许可，页面页脚处的 Powered by NDlog和官网网站的链接（http://www.nickdraw.com ）都必须保留，而不能清除或修改；<dt>
  					<dd>禁止NDlog的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发；<dt>
  					<dd>如果您未能遵守本协议的条款，您的授权将被终止，所被许可的权利将被收回，并承担相应法律责任。<dt>
  				</dl>
  				<dl class="l1 nt">
  					<dt>叁、有限担保和免责声明</dt>
  					<dd>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的；<dt>
  					<dd>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任；<dt>
  					<dd>NickDraw(nickdraw.com)不对使用本软件构建的网站中的文章或信息承担责任。<dt>
  				</dl>
				<p class="nt" style="padding-bottom:20px;">电子文本形式的授权协议如同双方书面签署的协议一样，具有完全的和等同的法律效力。您一旦开始安装 NDlog 即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权力的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>
			</div>
			<div class="ch_next">
				<p style="margin-top:15px; float:left;"><input type="checkbox" id="checkAgreement" value="1" /> 我同意以上条款。</p>
				<input type="button" id="agreementNext" value="下一步" class="submit" style="float:right;margin-top:15px;" />
			</div>
			<?php
				}elseif( $step == '1' ){
					$dirarray = array (
						'cache',
						'install',
						'configs',
						'static',
						'static/uploads',
						'static/attach'
					);
					$writeable = array();
					foreach ($dirarray as $key => $dir){
						if (writable($dir)){
							$writeable[$key] = $dir.result(1, 0);
						}else{
							$writeable[$key] = $dir.result(0, 0);
							$quit = TRUE;
						}
					}
			?>
			<div id="content">
				<h1 class="l1 nt">服务器配置</h1>
				<dl class="l1 nt">
					<dt>操作系统</dt>
					<dd><?php echo PHP_OS;result(1, 1);?></dd>
				</dl>
				<dl class="l1 nt">
					<dt>PHP版本</dt>
					<dd>
						<?php
							echo PHP_VERSION;
							if (PHP_VERSION < '5.1.2'){
								result(0, 1);
								$quit = TRUE;
							}else{
								result(1, 1);
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>附件上传</dt>
					<dd>
						<?php
							if (@ini_get('file_uploads')){
								echo '支持 / ' . @ini_get('upload_max_filesize');
							}else{
								echo '<span class="red">不支持</span>';
							}
							result(1, 1);
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>PHP扩展</dt>
					<dd>
						<?php
							if (extension_loaded('mysql')){
								echo 'mysql:'.'支持';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：mysql</span>';
								result(0, 1);
								$quit = TRUE;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('gd')){
								echo 'GD:支持';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：GD</span>';
								result(0, 1);
								$quit = TRUE;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('curl')){
								echo 'curl:支持';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：curl</span>';
								result(0, 1);
								//$quit = TRUE;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('openssl')){
								echo 'OpenSSL:支持(其他平台API同步需要)';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：OpenSSL(其他平台API同步需要)</span>';
								result(0, 1);
								//$quit = TRUE;
							}
						?>
					</dd>
					<dd>
						<?php
							if (extension_loaded('mbstring')){
								echo 'mbstring:支持';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器没有安装这个PHP扩展：mbstring</span>';
								result(0, 1);
								//$quit = TRUE;
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>MySQL数据库</dt>
					<dd>
						<?php
							if (function_exists('mysql_connect')){
								echo '支持';
								result(1, 1);
							}else{
								echo '<span class="red">您的服务器不支持MYSQL数据库，无法安装NDlog。</span>';
								result(0, 1);
								$quit = TRUE;
							}
						?>
					</dd>
				</dl>
				<dl class="l1 nt">
					<dt>目录和文件的写权限</dt>
					<dd>
						<?php
							foreach ($writeable as $value){
								echo '<p>'.__ROOT_PATH__.'/'.$value.'</p>';
							}
							$conf_1 = __ROOT_PATH__ . '/configs/' . $configs;
							$conf_2 = __ROOT_PATH__ . '/configs/' . $settings;
							if (is_writable($conf_2)){
								echo '<p>'.__ROOT_PATH__.'/configs/'.$settings.result(1, 0).'</p>';
							}else{
								echo '<p>'.__ROOT_PATH__.'/configs/'.$settings.result(0, 0).'</p>';
								$quit = TRUE;
							}
							if (is_writable($conf_1)){
								echo '<p>'.__ROOT_PATH__.'/configs/'.$configs.result(1, 0).'</p>';
							}else{
								echo '<p>'.__ROOT_PATH__.'/configs/'.$configs.result(0, 0).'</p>';
								$quit = TRUE;
							}
						?>
					</dd>
				</dl>
			</div>
			<div class="ch_next">
				<form action='index.php?step=2' method="post">
					<input type="button" id="agreementPrev" rel="1" value="上一步" class="submit" style="float:left;margin-top:15px;" />
					<input type="submit" id="agreementNext" value="下一步" class="submit" style="float:right;margin-top:15px;"<?php if($quit) echo " disabled=\"disabled\"";?> />
				</form>
			</div>
			<?php
				}elseif( $step == '2' ){
			?>
			<form action='index.php?step=3' method="post">
			<div id="content">
				<h1 class="l1 nt">数据库配置</h1>
				<dl class="l1 nt">
					<dt>数据库服务器</dt>
					<dd>格式：地址(:端口)，一般为 localhost</dd>
					<dd><input type="text" name="db_host" value="localhost" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>数据库用户名</dt>
					<dd></dd>
					<dd><input type="text" name="db_username" value="root" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>数据库密码</dt>
					<dd></dd>
					<dd><input type="password" name="db_password" value="" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>数据库名</dt>
					<dd></dd>
					<dd><input type="text" name="db_name" value="ndlog" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>表名前缀</dt>
					<dd>同一数据库安装多个NDlog时可改变默认值</dd>
					<dd><input type="text" name="db_prefix" value="ndlog_" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>站点地址</dt>
					<dd>网站URL地址</dd>
					<dd><input type="text" name="site_url" value="<?php echo "http://".$_SERVER['HTTP_HOST'].rtrim(str_replace('\\', '/', dirname(dirname($_SERVER['SCRIPT_NAME']))),'/');?>" size="40" class='input' /></dd>
				</dl>
				
				<h1 class="l1 nt">超级管理员资料</h1>
				<dl class="l1 nt">
					<dt>用户的起始ID</dt>
					<dd></dd>
					<dd><input type="text" name="first_user_id" value="admin" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>电子邮件</dt>
					<dd></dd>
					<dd><input type="text" name="email" value="webmaster@206c.net" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt">
					<dt>密码</dt>
					<dd>为确保您网站管理的安全，密码必须大于6位数，并且是字母+数字或者符号</dd>
					<dd><input type="password" name="password" value="" size="40" class='input' /></dd>
				</dl>
				<dl class="l1 nt wrbg">
					<dt>重复密码</dt>
					<dd></dd>
					<dd><input type="password" name="rpassword" value="" size="40" class='input' /></dd>
				</dl>
			</div>
			<div class="ch_next">
				<input type="button" id="agreementPrev" rel="2" value="上一步" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="下一步" class="submit" style="float:right;margin-top:15px;"<?php if($quit) echo " disabled=\"disabled\"";?> />
			</div>
			</form>
			<script type="text/javascript">
				$(function(){
					//检测提交表单
					$('#agreementNext').click(function(){
						var db_host = $.trim( $('input[name="db_host"]').val() );
						var db_username = $.trim( $('input[name="db_username"]').val() );
						var db_password = $.trim( $('input[name="db_password"]').val() );
						var db_name = $.trim( $('input[name="db_name"]').val() );
						var db_prefix = $.trim( $('input[name="db_prefix"]').val() );
						//var site_url = $.trim( $('input[name="site_url"]').val() );
						
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
						/*if ( db_password == '' ){
							alert('请填写数据库密码！');
							return false;
						}*/
						if ( db_name == '' ){
							alert('请填写数据库名！');
							return false;
						}
						if ( db_prefix == '' ){
							alert('表前缀不可为空！');
							return false;
						}
						if ( first_user_id == '' ){
							alert('起始管理员账号必须填写！');
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
						$quit = TRUE;
					}elseif (!@mysql_connect($db_host, $db_username, $db_password)){
						$message .= '<p class="message">'.mysql_error().'</p>';
						$quit = TRUE;
					}
					if(strstr($db_prefix, '.')){
						$message .= '<p class="message">您指定的数据表前缀包含点字符(".")，请返回修改。</p>';
						$quit = TRUE;
					}
					if (strlen($password) < 6){
						$message .= '<p class="message">密码长度必须大于6位</p>';
						$quit = TRUE;
					}elseif ($password != $rpassword){
						$message .= '<p class="message">两次输入的密码不一致</p>';
						$quit = TRUE;
					}elseif (!preg_match('/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,3}$/i', $email)){
						$message .= '<p class="message">电子邮件格式不正确</p>';
						$quit = TRUE;
					}else{
						$forbiddencharacter = array ("\\","&"," ","'","\"","/","*",",","<",">","\r","\t","\n","#","$","(",")","%","@","+","?",";","^");
						foreach ($forbiddencharacter as $value){
							if (strpos($username, $value) !== FALSE){
								$message .= '<p class="message">用户名包含非法字符</p>';
								$quit = TRUE;
								break;
							}
						}
					}
					
					if ($quit){
						$allownext = ' disabled="disabled"';
						echo "<h1 class=\"error\">错误</h1>";
						echo $message;
					}else{
						$conf	=	array();
						$conf['db_host']		=	$db_host;
						$conf['db_name']		=	$db_name;
						$conf['db_username']	=	$db_username;
						$conf['db_password']	=	$db_password;
						$conf['db_prefix']		=	$db_prefix;
						$conf['db_pconnect']	=	0;
						$conf['db_charset']		=	'utf8';
						$conf['dbType']			=	'mysql';

						$account	=	array();
						$account['account']		=	$first_user_id;
						$account['email']		=	$email;
						$account['password']	=	substr(md5($password),5,8);

						$_SESSION['conf']		=	$conf;
						$_SESSION['account']	=	$account;
						$_SESSION['FUID']		=	$first_user_id;
						$_SESSION['HURL']		=	$site_url;
					?>
					<ul class="l1 nt">
						<li><?php echo '管理员帐号: ' . $first_user_id?></li>
						<li><?php echo '密码: ' . $password;?></li>
					</ul>
					<?php
						$conf_epath = __ROOT_PATH__ . '/configs/' . $configs;
						$fp = fopen( $conf_epath , 'wb');
						$conf_cont = <<<EOT
<?php
	/**
	 +=========================================================
	 * NDlog 个人单用户博客系统
	 * mysql.inc.php 数据库配置
	 +=========================================================
	 * @copyright © 2012 nickdraw.com All rights reserved.
	 * @author NickDraw(零度温柔) webmaster@206c.net
	 * @license http://www.nickdraw.com/license
	 +=========================================================
	 */
	return array(
		'DB_TYPE'               => 'mysql',     // 数据库类型
		'DB_HOST'               => '$db_host', // 服务器地址
		'DB_NAME'               => '$db_name',          // 数据库名
		'DB_USER'               => '$db_username',      // 用户名
		'DB_PWD'                => '$db_password',          // 密码
		'DB_PORT'               => '3306',        	// 端口
		'DB_PREFIX'             => '$db_prefix',    // 数据库表前缀
	    'DB_FIELDTYPE_CHECK'    => false,       // 是否进行字段类型检查
	    'DB_FIELDS_CACHE'       => true,        // 启用字段缓存
	    'DB_CHARSET'            => 'utf8',      // 数据库编码默认采用utf8
	);
?>
EOT;
						chmod( $conf_epath, 0777 );
						$result_1	=	fwrite($fp, trim($conf_cont));
						@fclose($fp);
						
						if($result_1 && file_exists($conf_epath)){
							echo '<p class="message">数据库配置信息写入完成</p>';
						}else{
							echo '<p class="message">数据库配置文件写入错误，请检查'.$conf_epath.'文件是否存在或属性是否为777</p>';
							$quit = TRUE;
						}
					}
				?>
			</div>
			<div class="ch_next">
			<form method="post" action="index.php?step=4">
				<input type="button" id="agreementPrev" rel="3" value="上一步" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="下一步" class="submit" style="float:right;margin-top:15px;"<?php echo $allownext;?> />
			</form>
			</div>
			<?php
				}elseif($step == '4'){
			?>
			<div id="content">
				<?php
					$db_config	=	$_SESSION['conf'];
					if (!$db_config['db_host'] && !$db_config['db_name']){
						$message .= '<p class="message">数据库配置失败</p>';
						$quit = TRUE;
					}else{
						mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
						$sqlv = mysql_get_server_info();
						if($sqlv < '4.1'){
							$message .= '<p class="message">您的 MYSQL 版本低于 4.1.0，安装无法继续进行！</p>';
							$quit = TRUE;
						}else{
							$db_charset	=	$db_config['db_charset'];
							$db_charset = (strpos($db_charset, '-') === FALSE) ? $db_charset : str_replace('-', '', $db_charset);

							mysql_query(" CREATE DATABASE IF NOT EXISTS `{$db_config['db_name']}` DEFAULT CHARACTER SET $db_charset ");

							if (mysql_errno()){
								$errormsg = mysql_error();
								$message .= '<p class="message">'.($errormsg ? $errormsg : '程序在执行数据库操作时发生了一个错误，安装过程无法继续进行。').'</p>';
								$quit = TRUE;
							}else{
								mysql_select_db($db_config['db_name']);
							}

							//判断是否有用同样的数据库前缀安装过
							$re		=	mysql_query("SELECT COUNT(1) FROM {$db_config['db_prefix']}user");
							$link	=	@mysql_fetch_row($re);

							if( intval($link[0]) > 0 ){
								$rebuild	=	true;
								$message .= '<p class="message">数据库中已经安装过 NDlog，继续安装会清空原有数据！</p>';
								$alert = ' onclick="return confirm(\'数据库中已经安装过 NDlog，继续安装会清空原有数据！\');"';
							}
						}
					}
					if ( $quit ){
						$allownext = 'disabled="disabled"';
						echo '<h1 class="l1 nt">错误</h1>';
						echo $message;
					}else{
						if ( $rebuild ){
							echo '<p class="message" style="color:red;font-size:16px;">数据库中已经安装过 NDlog，继续安装会清空原有数据！</p>';
						}
						echo '<p class="message">点击下一步开始导入数据</p>';
					}
				?>
			</div>
			<div class="ch_next">
			<form method="post" action="index.php?step=5">
				<input type="button" id="agreementPrev" rel="4" value="上一步" class="submit" style="float:left;margin-top:15px;" />
				<input type="submit" id="agreementNext" value="下一步" class="submit" style="float:right;margin-top:15px;"<?php echo $allownext,$alert?> />
			</form>
			</div>
			<?php
				}elseif($step == '5'){
					$db_config	=	$_SESSION['conf'];
					mysql_connect($db_config['db_host'], $db_config['db_username'], $db_config['db_password']);
					if (mysql_get_server_info() > '5.0'){
						mysql_query("SET sql_mode = ''");
					}
					$db_config['db_charset'] = (strpos($db_config['db_charset'], '-') === FALSE) ? $db_config['db_charset'] : str_replace('-', '', $db_config['db_charset']);
					mysql_query("SET character_set_connection={$db_config['db_charset']}, character_set_results={$db_config['db_charset']}, character_set_client=binary");
					mysql_select_db($db_config['db_name']);
					$tablenum = 0;

					$fp = fopen($installsql, 'rb');
					$sql = fread($fp, filesize($installsql));
					fclose($fp);
					
					$db_charset	=	$db_config['db_charset'];
					$db_prefix	=	$db_config['db_prefix'];
					$sql = str_replace("\r", "\n", str_replace('`'.'ndlog_', '`'.$db_prefix, $sql));
					$create_table_info = '';
					foreach(explode(";\n", trim($sql)) as $query){
						$query = trim($query);
						if($query) {
							if(substr($query, 0, 12) == 'CREATE TABLE'){
								$name = preg_replace("/CREATE TABLE ([A-Z ]*)`([a-z0-9_]+)` .*/is", "\\2", $query);
								$create_table_info .= '<dd>创建表 '.$name.' ... <span class="blue">OK</span></dd>';
								@mysql_query(createtable($query, $db_charset));
								$tablenum ++;
							}else{
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
					<dt>创建超级管理员帐户</dt>
					<?php
						//清空管理员表
						$dpsql = "TRUNCATE TABLE  `{$db_config['db_prefix']}user`";
						if( mysql_query($dpsql) ){
							echo '<li>用户表清理完成... <span class="blue">OK</span></li>';
						} else {
							echo '<li>用户表清理失败... <span class="red">ERROR</span></li>';
							$quit	=	true;
						}
						
						//添加管理员
						$siteAdmin	=	$_SESSION['account'];

						$sql1	=	"INSERT INTO `{$db_config['db_prefix']}user` (`id`, `account`, `nickname`, `password`, `bind_account`, `last_login_ip`, `login_count`, `verify`, `email`, `remark`, `create_time`, `update_time`, `status`, `type_id`, `info`, `level`) VALUES (NULL, '{$siteAdmin['account']}', '', '{$siteAdmin['password']}', '', '', '0', '8888', '{$siteAdmin['email']}', '管理员', ".time().", '0', '1', '0', '', 'administrator');";

						if( mysql_query($sql1) ){
							echo '<li>超级管理员权限设置成功... <span class="blue">OK</span></li>';
						} else {
							echo '<li>超级管理员权限设置失败... <span class="red">ERROR</span></li>';
							$quit	=	true;
						}

						if(!$quit){
							//锁定安装
							fopen( $installed, 'w' );
							//@unlink('../index.html');
						}else{
							echo '请重新安装';
						}
					?>
				</dl>
				<dl class="l1 nt">
					<dt>安装成功</dt>
					<dd>安装程序执行完毕，请尽快删除整个 install 目录，以免被他人恶意利用。如要重新安装，请删除本目录的 <?php echo $installed; ?> 文件！</dd>
					<dd><a href="../index.php">请点击这里开始体验NDlog吧！</a></dd>
					<dd><a href="../m.php">网站管理面板！</a></dd>
				</dl>
			</div>
			<?php
				}
			?>
		</div>
	</body>
</html>