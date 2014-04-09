<?php
$dbconfig = require('./Public/config/dbconfig.inc.php');
$webconfig = require('./Public/config/webconfig.inc.php');
$config = array(
	'URL_MODEL' => 2,
	'SHOW_PAGE_TRACE' => true,//显示调试信息
	'TMPL_TEMPLATE_SUFFIX' => '.htm',
	'URL_CASE_INSENSITIVE' => true,
	'URL_HTML_SUFFIX' => 'html', //url伪静态设置
	'TMPL_L_DELIM' => '<{',
	'TMPL_R_DELIM' => '}>',
	'DEFAULT_THEME' => $webconfig['CFG_DF_THEME'],
	'TMPL_PARSE_STRING' => array(
		'__CSS__' => __ROOT__.'/'.APP_NAME.'/Tpl/'.$webconfig['CFG_DF_THEME'].'/Public/style',
		'__JS__' => __ROOT__.'/'.APP_NAME.'/Tpl/'.$webconfig['CFG_DF_THEME'].'/Public/js',
		'__IMG__' => __ROOT__.'/'.APP_NAME.'/Tpl/'.$webconfig['CFG_DF_THEME'].'/Public/images',
	),
	'URL_ROUTER_ON' => false,
	'URL_ROUTE_RULES' => array(
		//'category/:colid\d' => 'Index/columns',
	),
	'DEFAULT_FILTER' => 'htmlspecialchars,stripslashes',
);

return array_merge($dbconfig,$webconfig,$config);
?>