<?php
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "access`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "announce`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "attach`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "banner`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "blog`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "columns`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "comment`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "download`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "guestbook`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "news`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "link`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "node`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "page`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "reply`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "role`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "role_user`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "tag`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "tagged`;";
$sqls[] = "DROP TABLE IF EXISTS `" . $db_prefix . "user`;";
$sqls[] = "CREATE TABLE `" . $db_prefix . "access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `node_id` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) NOT NULL,
  `module` varchar(50) DEFAULT NULL,
  `pid` int(11) NOT NULL,
  KEY `groupId` (`role_id`),
  KEY `nodeId` (`node_id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '6', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '7', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '8', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '9', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '10', '3', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '11', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '5', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '3', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '2', '2', '', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "access` VALUES ('2', '1', '1', '', '0');";

$sqls[] = "CREATE TABLE `" . $db_prefix . "announce` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `content` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  `title` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `type` varchar(150) NOT NULL,
  `size` varchar(20) NOT NULL,
  `extension` varchar(20) NOT NULL,
  `savepath` varchar(255) NOT NULL,
  `savename` varchar(255) NOT NULL,
  `module` varchar(100) NOT NULL,
  `recordId` int(11) NOT NULL,
  `userId` int(11) unsigned NOT NULL,
  `uploadTime` int(11) unsigned DEFAULT NULL,
  `downCount` mediumint(9) unsigned NOT NULL DEFAULT '0',
  `hash` varchar(32) NOT NULL,
  `verify` varchar(8) NOT NULL,
  `remark` varchar(150) DEFAULT NULL,
  `version` mediumint(6) unsigned NOT NULL DEFAULT '0',
  `updateTime` int(12) unsigned NOT NULL,
  `alt` varchar(30) NOT NULL,
  `downloadTime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`),
  KEY `recordId` (`recordId`),
  KEY `userId` (`userId`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "banner` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `typeid` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `banner` varchar(150) NOT NULL,
  `arrimgs` tinytext NOT NULL,
  `advurl` tinytext NOT NULL,
  `inputtime` int(10) NOT NULL,
  `introduce` text NOT NULL,
  `posid` tinyint(2) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "blog` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `inputtime` int(10) NOT NULL,
  `udatetime` int(10) NOT NULL,
  `ctime` varchar(30) NOT NULL,
  `username` char(20) NOT NULL,
  `author` varchar(30) NOT NULL,
  `listorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  `posid` tinyint(1) NOT NULL DEFAULT '0',
  `ord` tinyint(3) NOT NULL,
  `hits` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "columns` (
  `colId` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `colPid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `typeid` smallint(3) NOT NULL,
  `languageid` tinyint(2) NOT NULL,
  `modelid` smallint(5) NOT NULL,
  `model` varchar(20) NOT NULL,
  `picId` smallint(5) unsigned NOT NULL DEFAULT '0',
  `colPath` varchar(100) NOT NULL DEFAULT '',
  `colTitle` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(150) NOT NULL,
  `asmenu` tinyint(1) NOT NULL,
  `description` varchar(200) NOT NULL DEFAULT '',
  `status` tinyint(2) NOT NULL DEFAULT '0',
  `ord` smallint(3) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`colId`),
  KEY `colPath` (`colPath`,`picId`)
) ENGINE=MyISAM CHARSET=utf8;";
$sqls[] = "INSERT INTO `" . $db_prefix . "columns` VALUES ('1', '0', '0', '1', '1', '文章', '0', '0', 'PHP', '','1', 'PHP', '0', '0');";
$sqls[] = "INSERT INTO `" . $db_prefix . "columns` VALUES ('2', '0', '0', '1', '2', '博客', '0', '0', '博客', '', '0','网志博客', '0', '0');";
$sqls[] = "INSERT INTO `" . $db_prefix . "columns` VALUES ('3', '0', '0', '1', '3', '下载', '0', '0', '下载', '','0', '下载', '0', '0');";

$sqls[] = "CREATE TABLE `" . $db_prefix . "comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `path` varchar(100) NOT NULL,
  `username` varchar(40) NOT NULL,
  `nid` mediumint(8) unsigned NOT NULL,
  `bid` mediumint(8) unsigned NOT NULL,
  `email` varchar(50) NOT NULL,
  `author` varchar(40) NOT NULL,
  `moudle` varchar(20) NOT NULL,
  `url` varchar(200) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `inputtime` varchar(20) NOT NULL,
  `verify` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `isreply` tinyint(1) NOT NULL,
  `ord` tinyint(5) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "download` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `languageid` tinyint(2) NOT NULL,
  `typeid` smallint(5) unsigned NOT NULL,
  `title` char(80) NOT NULL DEFAULT '',
  `style` char(24) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` char(255) NOT NULL DEFAULT '',
  `hits` int(10) NOT NULL,
  `posid` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `url` varchar(100) NOT NULL,
  `ord` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(2) unsigned NOT NULL DEFAULT '1',
  `sysadd` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `islink` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `updatetime` int(10) unsigned NOT NULL DEFAULT '0',
  `systems` varchar(100) NOT NULL DEFAULT 'Win2000/WinXP/Win2003',
  `copytype` varchar(15) NOT NULL DEFAULT '',
  `language` varchar(10) NOT NULL DEFAULT '',
  `classtype` varchar(20) NOT NULL DEFAULT '',
  `version` varchar(20) NOT NULL DEFAULT '',
  `filesize` varchar(10) NOT NULL DEFAULT 'Unkown',
  `stars` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `status` (`status`,`ord`,`id`),
  KEY `listorder` (`catid`,`status`,`ord`,`id`),
  KEY `catid` (`catid`,`status`,`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `path` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `updatetime` int(10) NOT NULL,
  `ip` varchar(15) NOT NULL,
  `url` varchar(200) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `content` text NOT NULL,
  `verify` varchar(32) NOT NULL,
  `isreply` tinyint(1) NOT NULL,
  `ord` tinyint(5) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "link` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `linktype` tinyint(1) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `inputtime` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ord` tinyint(5) NOT NULL,
  `introduce` text NOT NULL,
  `linkman` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "news` (
  `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `languageid` tinyint(2) NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `description` varchar(200) NOT NULL DEFAULT '',
  `inputtime` int(10) NOT NULL,
  `udatetime` int(10) NOT NULL,
  `ctime` varchar(30) NOT NULL,
  `username` char(20) NOT NULL,
  `listorder` smallint(3) unsigned NOT NULL DEFAULT '0',
  `posid` tinyint(2) NOT NULL DEFAULT '0',
  `ord` tinyint(3) NOT NULL,
  `hits` int(10) NOT NULL,
  `author` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";
$sqls[] = "INSERT INTO `" . $db_prefix . "news` VALUES ('1', '1', '1', '欢迎使用WBlog博客程序', '欢迎使用WBlog博客程序!', 'WBlog', '', '欢迎使用WBlog博客程序!', '1362233349', '0', '2013-03-02', '管理员', '0', '1', '0', '1', 'wblog','1');";
$sqls[] = "CREATE TABLE `" . $db_prefix . "node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `title` varchar(50) NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `remark` varchar(150) NOT NULL,
  `sort` smallint(6) unsigned NOT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`name`)
) ENGINE=MyISAM CHARSET=gb2312;";

$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('1', 'admin', '后台项目', '0', '1', '后台项目', '1', '0', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('2', 'news', '文章管理', '0', '1', '文章管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('3', 'index', '首页管理', '0', '1', '首页模块', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('4', 'download', '下载管理', '0', '1', '下载管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('5', 'page', '单页管理', '0', '1', '单页管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('6', 'columns', '栏目管理', '0', '1', '栏目管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('7', 'databakup', '数据备份', '0', '1', '数据备份', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('8', 'role', '角色管理', '0', '1', '角色管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('9', 'config', '配置管理', '0', '1', '配置管理', '1', '1', '3');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('10', 'blog', '博客管理', '0', '1', '博客管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('11', 'user', '用户管理', '0', '1', '用户管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('12', 'guestbook', '留言管理', '0', '1', '留言管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('13', 'link', '友情链接管理', '0', '1', '友情链接管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('14', 'comment', '评论管理', '0', '1', '评论管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('15', 'upload', '附件管理', '0', '1', '附件管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('16', 'announce', '公告管理', '0', '1', '公告管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('17', 'banner', '广告管理', '0', '1', '广告管理', '1', '1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "node` VALUES ('18', 'index', '友情列表', '1', '1', '友情列表', '1', '14', '3');";

$sqls[] = "CREATE TABLE `" . $db_prefix . "page` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `languageid` tinyint(2) NOT NULL,
  `title` varchar(80) NOT NULL DEFAULT '',
  `keywords` varchar(100) NOT NULL DEFAULT '',
  `content` mediumtext NOT NULL,
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `ord` smallint(3) unsigned NOT NULL DEFAULT '0',
  `posid` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `username` char(20) NOT NULL,
  `inputtime` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) NOT NULL,
  `udatetime` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARSET=utf8;";
$sqls[] = "INSERT INTO `" . $db_prefix . "page` VALUES ('1', '1', '关于博客', '', '关于博客', '', '0', '0', '1', '管理员', '1362973252', '0', '0');";
$sqls[] = "CREATE TABLE `" . $db_prefix . "role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `pid` smallint(6) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `remark` varchar(150) NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `pid` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "INSERT INTO `" . $db_prefix . "role` VALUES ('1', 'admin', '0', '1', '管理员');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role` VALUES ('2', 'user', '1', '1', '用户');";

$sqls[] = "CREATE TABLE `" . $db_prefix . "role_user` (
  `role_id` mediumint(9) unsigned NOT NULL,
  `user_id` char(32) NOT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('1', '1');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('1', '2');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('2', '4');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('2', '3');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('2', '38');";
$sqls[] = "INSERT INTO `" . $db_prefix . "role_user` VALUES ('3', '39');";

$sqls[] = "CREATE TABLE `" . $db_prefix . "tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `count` mediumint(6) unsigned NOT NULL,
  `module` varchar(100) NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `module` (`module`),
  KEY `count` (`count`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "tagged` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userId` int(11) unsigned NOT NULL,
  `recordId` int(11) unsigned NOT NULL,
  `tagId` int(11) NOT NULL,
  `tagTime` int(11) NOT NULL,
  `module` varchar(25) NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "CREATE TABLE `" . $db_prefix . "user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `bindusername` varchar(50) NOT NULL,
  `lastlogintime` int(11) unsigned NOT NULL DEFAULT '0',
  `lastloginip` varchar(40) NOT NULL,
  `loginnum` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `verify` varchar(32) NOT NULL,
  `email` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `isadministrator` tinyint(1) NOT NULL,
  `createtime` int(11) unsigned NOT NULL,
  `updatetime` int(11) unsigned NOT NULL,
  `ord` tinyint(3) NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `typeid` tinyint(2) unsigned NOT NULL DEFAULT '0',
  `info` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM CHARSET=utf8;";

$sqls[] = "INSERT INTO `" . $db_prefix . "user` VALUES ('1', '".$admin."', '管理员', '".$adminpwd."', '', '1350895578', ' ', '0', '8888', '644828230@qq.com', '备注信息', '1', '1222907803', '1326266696', '0', '1', '0', '');";
?>