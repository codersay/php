CREATE TABLE IF NOT EXISTS `ndlog_adv` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` char(20) NOT NULL,
  `title` varchar(160) NOT NULL,
  `dsp` mediumtext NOT NULL,
  `url` tinytext NOT NULL,
  `banner` varchar(255) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `count` char(20) NOT NULL,
  `dtime` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_alone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `click` int(11) unsigned NOT NULL,
  `count` char(20) NOT NULL,
  `author` int(10) NOT NULL,
  `attach` text NOT NULL,
  `is_comment` tinyint(1) unsigned NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_archives` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sync_QQ_ID` char(30) NOT NULL,
  `cid` int(10) unsigned NOT NULL COMMENT '类分ID',
  `type` char(10) NOT NULL,
  `channel` char(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `recommend` tinyint(1) unsigned NOT NULL COMMENT '推荐(YES,NO)',
  `set_top` tinyint(1) unsigned NOT NULL,
  `set_index` tinyint(1) unsigned NOT NULL,
  `click` bigint(20) unsigned NOT NULL COMMENT '击数点',
  `count` int(11) unsigned NOT NULL,
  `title` char(60) NOT NULL,
  `url_name` varchar(255) NOT NULL,
  `tags` varchar(255) NOT NULL,
  `summary` text NOT NULL COMMENT '内容提要',
  `content` text NOT NULL,
  `attach` text NOT NULL,
  `author` int(10) unsigned NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `music` varchar(255) NOT NULL,
  `video` varchar(255) NOT NULL,
  `update_time` int(10) unsigned NOT NULL COMMENT '新更时间',
  `create_time` int(10) unsigned NOT NULL COMMENT '布发时间',
  `keyword` char(30) NOT NULL,
  `description` text NOT NULL COMMENT '页面描述',
  `lang` char(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `ndlog_archives` (`id`, `sync_QQ_ID`, `cid`, `type`, `channel`, `status`, `recommend`, `set_top`, `set_index`, `click`, `count`, `title`, `tags`, `summary`, `content`, `attach`, `author`, `thumb`, `music`, `video`, `update_time`, `create_time`, `keyword`, `description`, `lang`) VALUES (1, '', 1, 'article', '', 1, 0, 0, 0, 0, 0, '默认演示博文', '默认 演示', '<p>\r\n	<span></span>您好，欢迎使用NDlog。\r\n</p>\r\n<p>\r\n	NDlog 是由 NickDraw 独立开发的单用户博客类建站程序，基于PHP脚本和MySQL数据库。本程序源码开放的，任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行使用而无需缴纳程序使用费。\r\n</p>\r\n<p>\r\n	用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 NDlog。\r\n</p>\r\n<p>\r\n	<a href="http://bbs.im1981.com" target="_blank">NDlog讨论区</a> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>NDlog是一款可以根据模板随意定制类型的图文管理系统，可提供：</strong> \r\n</p>\r\n<ul>\r\n	<li>\r\n		文章\r\n		<p>\r\n			可发布文字、图文、碎语……\r\n		</p>\r\n	</li>\r\n	<li>\r\n		图集\r\n		<p>\r\n			可发布图像专辑，以组图专辑的形式体现。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		音乐\r\n		<p>\r\n			可发布音乐，使用 xiami.com 的api接口，分享音乐。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		视频\r\n		<p>\r\n			可发布视频，使用 土豆、56、酷6、优酷、163 视频分享。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		友情链接\r\n		<p>\r\n			大多网站都有的功能，可在后台分类管理里面填写唯一ID为<span>flink即可。</span> \r\n		</p>\r\n	</li>\r\n	<li>\r\n		留言簿\r\n		<p>\r\n			如需此功能只需在<span>后台分类管理里面填写唯一ID为</span><span>guestbook即可。</span> \r\n		</p>\r\n	</li>\r\n</ul>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	简单说明：\r\n</p>\r\n<ol>\r\n	<li>\r\n		<span style="line-height:1.5;">用户可根据自己的需求将网站部署成企业站、博客等网站（根据模板定制</span><span style="line-height:1.5;">）。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">高效的运行处理机制。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">简单便捷的后台管理。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">单模板插件处理机制，每个模板可定制不同的插件独立管理。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">……</span> \r\n	</li>\r\n</ol>\r\n<p>\r\n	此文章为系统默认文章，您可以在管理后台删除\r\n</p>', '<p>\r\n	<span></span>您好，欢迎使用NDlog。\r\n</p>\r\n<p>\r\n	NDlog 是由 NickDraw 独立开发的单用户博客类建站程序，基于PHP脚本和MySQL数据库。本程序源码开放的，任何人都可以从互联网上免费下载，并可以在不违反本协议规定的前提下进行使用而无需缴纳程序使用费。\r\n</p>\r\n<p>\r\n	用者：无论个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读协议，在理解、同意、并遵守本协议的全部条款后，方可开始使用 NDlog。\r\n</p>\r\n<p>\r\n	<a href="http://bbs.im1981.com" target="_blank">NDlog讨论区</a> \r\n</p>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	<strong>NDlog是一款可以根据模板随意定制类型的图文管理系统，可提供：</strong> \r\n</p>\r\n<ul>\r\n	<li>\r\n		文章\r\n		<p>\r\n			可发布文字、图文、碎语……\r\n		</p>\r\n	</li>\r\n	<li>\r\n		图集\r\n		<p>\r\n			可发布图像专辑，以组图专辑的形式体现。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		音乐\r\n		<p>\r\n			可发布音乐，使用 xiami.com 的api接口，分享音乐。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		视频\r\n		<p>\r\n			可发布视频，使用 土豆、56、酷6、优酷、163 视频分享。\r\n		</p>\r\n	</li>\r\n	<li>\r\n		友情链接\r\n		<p>\r\n			大多网站都有的功能，可在后台分类管理里面填写唯一ID为<span>flink即可。</span> \r\n		</p>\r\n	</li>\r\n	<li>\r\n		留言簿\r\n		<p>\r\n			如需此功能只需在<span>后台分类管理里面填写唯一ID为</span><span>guestbook即可。</span> \r\n		</p>\r\n	</li>\r\n</ul>\r\n<p>\r\n	<br />\r\n</p>\r\n<p>\r\n	简单说明：\r\n</p>\r\n<ol>\r\n	<li>\r\n		<span style="line-height:1.5;">用户可根据自己的需求将网站部署成企业站、博客等网站（根据模板定制</span><span style="line-height:1.5;">）。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">高效的运行处理机制。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">简单便捷的后台管理。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">单模板插件处理机制，每个模板可定制不同的插件独立管理。</span> \r\n	</li>\r\n	<li>\r\n		<span style="line-height:1.5;">……</span> \r\n	</li>\r\n</ol>\r\n<p>\r\n	此文章为系统默认文章，您可以在管理后台删除\r\n</p>', '', 1, '', '', '', 0, 1361513956, '', '', '');

CREATE TABLE IF NOT EXISTS `ndlog_attach` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) unsigned NOT NULL COMMENT '对应ID',
  `model` char(20) NOT NULL COMMENT '模块',
  `type` char(20) NOT NULL COMMENT '文件类型',
  `size` char(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `folder` char(30) NOT NULL,
  `ext` char(10) NOT NULL,
  `click` char(20) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `hash` varchar(128) NOT NULL,
  `title` varchar(255) NOT NULL,
  `mime` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`,`size`,`ext`,`click`,`status`),
  KEY `create_time` (`create_time`,`update_time`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(10) unsigned DEFAULT '0',
  `tpl` varchar(200) DEFAULT NULL,
  `url` varchar(200) NOT NULL,
  `type` char(60) DEFAULT NULL,
  `banner` char(64) NOT NULL,
  `name` varchar(120) DEFAULT NULL,
  `channel` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `display` char(10) DEFAULT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `icons` varchar(200) NOT NULL,
  `nav` char(10) DEFAULT NULL,
  `count` char(20) NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `lang` char(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `ndlog_category` (`id`, `pid`, `tpl`, `url`, `type`, `banner`, `name`, `channel`, `sort`, `display`, `status`, `level`, `icons`, `nav`, `count`, `keyword`, `description`, `lang`) VALUES
(1, 0, NULL, '', 'article', '', 'Blog', 'blog', 0, NULL, 1, 1, '', 'nav', '1', '', '', 'zh-cn');

CREATE TABLE IF NOT EXISTS `ndlog_cat_flink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL,
  `sort` smallint(4) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `count` char(20) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

CREATE TABLE IF NOT EXISTS `ndlog_comment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL,
  `pid` int(10) NOT NULL,
  `type` char(10) CHARACTER SET utf8 NOT NULL,
  `username` char(20) CHARACTER SET utf8 DEFAULT NULL,
  `email` varchar(120) CHARACTER SET utf8 NOT NULL,
  `arctitle` varchar(60) CHARACTER SET utf8 DEFAULT NULL,
  `icon` int(10) NOT NULL,
  `ip` char(15) CHARACTER SET utf8 DEFAULT NULL,
  `dtime` int(10) DEFAULT NULL,
  `msg` text CHARACTER SET utf8,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_counts` (
  `archives` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '文档总数',
  `article` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '文章总数',
  `picture` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '图集总数',
  `music` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '音乐总数',
  `video` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '视频总数',
  `broken` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '碎语总数',
  `comment` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '评论总数',
  `guestbook` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '留言数',
  `total_pv` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '总PV',
  `total_ip` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '总IP',
  `alone` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '今日独立用户',
  `online` int(10) unsigned NOT NULL DEFAULT '0',
  `today_pv` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '今日PV',
  `today_ip` int(20) unsigned NOT NULL DEFAULT '0' COMMENT '今日IP'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `ndlog_flink` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `info` text NOT NULL,
  `url` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `sort` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `cid` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `ndlog_flink` (`id`, `name`, `info`, `url`, `logo`, `sort`, `status`, `cid`) VALUES
(1, 'NDlog', 'NDlog 官网', 'http://www.ndlog.com', '', 0, 1, 1);

CREATE TABLE IF NOT EXISTS `ndlog_guestbook` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` char(30) NOT NULL,
  `email` varchar(99) NOT NULL,
  `content` text NOT NULL,
  `ipaddress` char(15) NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `update_time` int(10) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_node` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `module` char(20) NOT NULL,
  `action` char(20) NOT NULL,
  `name` char(50) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `remark` varchar(255) NOT NULL,
  `sort` smallint(6) unsigned NOT NULL,
  `pid` smallint(6) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `group_id` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `level` (`level`),
  KEY `pid` (`pid`),
  KEY `status` (`status`),
  KEY `name` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=54 ;

INSERT INTO `ndlog_node` (`id`, `module`, `action`, `name`, `status`, `remark`, `sort`, `pid`, `level`, `type`, `type_name`, `group_id`) VALUES
(1, 'catalog', '', '分类', 1, '', 0, 0, 0, 0, '', 0),
(2, 'archiver', '', '文档', 1, '', 0, 0, 0, 0, '', 0),
(3, 'alone', '', '单页', 1, '', 0, 0, 0, 0, '', 0),
(4, 'themes', '', '主题', 1, '', 0, 0, 0, 0, '', 0),
(5, 'widget', '', 'Widgets', 1, '', 0, 0, 0, 0, '', 0),
(6, 'plugins', '', '插件', 1, '', 0, 0, 0, 0, '', 0),
(7, 'flink', '', '链接', 1, '', 0, 0, 0, 0, '', 0),
(8, 'feedback', '', '反馈', 1, '', 0, 0, 0, 0, '', 0),
(9, 'user', '', '用户', 1, '', 0, 0, 0, 0, '', 0),
(10, 'settings', '', '配置', 1, '', 0, 0, 0, 0, '', 0),
(11, 'tools', '', '工具', 1, '', 0, 0, 0, 0, '', 0),
(12, 'catalog', 'add', '新增一个分类', 1, '', 0, 1, 0, 0, '', 0),
(13, 'catalog', 'index', '分类列表', 1, '', 0, 1, 0, 0, '', 0),
(14, 'archiver', 'publish', '撰写一篇文章', 1, '', 0, 2, 0, 0, '{"type":"article"}', 0),
(15, 'archiver', 'publish', '发布一组图集', 1, '', 0, 2, 0, 0, '{"type":"picture"}', 0),
(16, 'archiver', 'publish', '分享音乐', 1, '', 0, 2, 0, 0, '{"type":"music"}', 0),
(17, 'archiver', 'publish', '分享视频', 1, '', 0, 2, 0, 0, '{"type":"video"}', 0),
(18, 'archiver', 'publish', '发表一则碎语', 1, '', 0, 2, 0, 0, '{"type":"broken"}', 0),
(19, 'archiver', 'index', '所有文档列表', 1, '', 0, 2, 0, 0, '', 0),
(20, 'archiver', 'index', '文章列表', 1, '', 0, 2, 0, 0, '{"type":"article"}', 0),
(21, 'archiver', 'index', '图集列表', 1, '', 0, 2, 0, 0, '{"type":"picture"}', 0),
(22, 'archiver', 'index', '音乐列表', 1, '', 0, 2, 0, 0, '{"type":"music"}', 0),
(23, 'archiver', 'index', '视频列表', 1, '', 0, 2, 0, 0, '{"type":"video"}', 0),
(24, 'archiver', 'index', '碎语列表', 1, '', 0, 2, 0, 0, '{"type":"broken"}', 0),
(25, 'alone', 'index', '单页面列表', 1, '', 0, 3, 0, 0, '', 0),
(26, 'alone', 'add', '新增一个单页面', 1, '', 0, 3, 0, 0, '{"type":"alone"}', 0),
(27, 'themes', 'index', '主题列表', 1, '', 0, 4, 0, 0, '', 0),
(28, 'flink', 'index', '友情链接列表', 1, '', 0, 7, 0, 0, '{"type":"links"}', 0),
(29, 'flink', 'index', '链接分类', 1, '', 0, 7, 0, 0, '{"type":"category"}', 0),
(30, 'flink', 'add', '新增一个友情链接', 1, '', 0, 7, 0, 0, '{"type":"links"}', 0),
(31, 'flink', 'add', '新增一个友情链接分类', 1, '', 0, 7, 0, 0, '{"type":"category"}', 0),
(33, 'feedback', 'index', '评论管理', 1, '', 0, 8, 0, 0, '{"type":"Comment"}', 0),
(34, 'feedback', 'index', '留言管理', 1, '', 0, 8, 0, 0, '{"type":"Guestbook"}', 0),
(35, 'user', 'index', '用户列表', 1, '', 0, 9, 0, 0, '', 0),
(36, 'user', 'add', '新增一个用户', 1, '', 0, 9, 0, 0, '', 0),
(37, 'user', 'myinfo', '我的资料', 1, '', 0, 9, 0, 0, '', 0),
(38, 'user', 'setAvatar', '个人头像设置', 1, '', 0, 9, 0, 0, '', 0),
(39, 'settings', 'basic', '基本设置', 0, '', 0, 10, 0, 0, '', 0),
(40, 'settings', 'system', '系统设置', 0, '', 0, 10, 0, 0, '', 0),
(41, 'settings', 'attach', '附件相关', 0, '', 0, 10, 0, 0, '', 0),
(42, 'settings', 'comment', '评论相关', 0, '', 0, 10, 0, 0, '', 0),
(43, 'tools', 'index', '数据库备份', 1, '', 0, 11, 0, 0, '', 0),
(44, 'tools', 'sqlrun', '独立运行SQL语句', 1, '', 0, 11, 0, 0, '', 0),
(45, 'tools', 'cache', '缓存相关', 1, '', 0, 11, 0, 0, '', 0),
(46, 'tools', 'counts', '统计相关', 1, '', 0, 11, 0, 0, '', 0),
(47, 'tools', 'advs', '焦点轮换广告', 1, '', 10, 11, 0, 0, '{"type":"focus"}', 0),
(48, 'tools', 'customdata', '自定义调用数据', 1, '', 0, 11, 0, 0, '', 0),
(49, 'tools', 'advs', '自由定制广告', 1, '', 12, 11, 0, 0, '{"type":"free"}', 0),
(50, 'tools', 'advadd', '新增焦点轮换图', 1, '', 11, 11, 0, 0, '{"type":"focus"}', 0),
(51, 'tools', 'advadd', '新增自由定制广告', 1, '', 13, 11, 0, 0, '{"type":"free"}', 0),
(52, 'widget', 'index', 'Widget 列表', 1, '', 0, 5, 0, 0, '', 0),
(53, 'widget', 'act', 'Widget 操作', 1, '', 0, 5, 0, 0, '', 0);

CREATE TABLE IF NOT EXISTS `ndlog_picture` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `text` text NOT NULL,
  `folder` char(10) NOT NULL,
  `ext` varchar(6) NOT NULL,
  `file` varchar(255) NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `click` char(30) NOT NULL DEFAULT '0',
  `count` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_plugins` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `title` varchar(200) NOT NULL,
  `remark` text NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `version` varchar(10) NOT NULL,
  `uri` varchar(255) NOT NULL,
  `type` char(20) NOT NULL,
  `sort` tinyint(4) unsigned NOT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '100',
  `position` char(20) NOT NULL,
  `hook` char(60) NOT NULL,
  `param` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

INSERT INTO `ndlog_plugins` (`id`, `name`, `author`, `title`, `remark`, `status`, `version`, `uri`, `type`, `sort`, `priority`, `position`, `hook`, `param`) VALUES
(1, 'SideBarLogin', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏用户登录', '侧边栏自由定制ajax用户登录及管理员信息及操作挂件。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', ''),
(2, 'NewArchives', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新文档', '侧边栏最新文档，条目及字符数可定制。', 0, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12"}'),
(3, 'NewArticle', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新文章', '侧边栏最新文章，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12"}'),
(4, 'NewPicture', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新图集', '侧边栏最新图集，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12"}'),
(5, 'NewBroken', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最碎语', '侧边栏最碎语，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12"}'),
(6, 'NewComment', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新视频', '侧边栏最新分享视频，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12","title":"最新评论"}'),
(7, 'NewGuestBook', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新留言', '最新留言，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12","title":"最新留言"}'),
(8, 'NewMusic', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新音乐', '侧边栏最新分享音乐，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12","title":"最新音乐"}'),
(9, 'NewVideo', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '侧边栏最新视频', '侧边栏最新分享视频，条目及字符数可定制。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'sidebar', '', '{"total":"10","strlen":"12","title":"最新视频"}'),
(10, 'TplChange', '<a href="http://www.ndlog.com/" target="_blank">NickDraw</a>', '模板切换按钮', '模板切换列表，可随意定制，将{:W("TplChange",array())}放置在你需要的模板位置即可。', 1, '1.0', 'http://www.ndlog.com/', 'widget', 0, 100, 'other', '', ''),
(11, 'SideBarCalendar', 'NickDraw', '侧边栏日历插件', '侧边栏日历插件，可按日期查询文档。', 1, '1.0', 'http://www.nickdraw.com', 'plugin', 0, 100, 'sidebar', 'sidebar_calendar', '{"title":"\\u65e5\\u5386\\u6302\\u4ef6","color":"red"}');

CREATE TABLE IF NOT EXISTS `ndlog_system_data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `list` char(30) DEFAULT 'default' COMMENT '列表名',
  `key` char(50) DEFAULT 'default' COMMENT '键名',
  `value` text COMMENT '键值',
  `mtime` timestamp NULL DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `list_key` (`list`,`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2670 ;

CREATE TABLE IF NOT EXISTS `ndlog_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `count` mediumint(6) unsigned NOT NULL,
  `module` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `module` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_tagged` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `record_id` int(11) unsigned NOT NULL,
  `tag_id` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `module` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `module` (`module`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `ndlog_user` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `account` varchar(64) NOT NULL,
  `nickname` varchar(50) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `bind_account` varchar(50) NOT NULL,
  `last_login_time` int(11) unsigned DEFAULT '0',
  `last_login_ip` varchar(40) DEFAULT NULL,
  `login_count` mediumint(8) unsigned DEFAULT '0',
  `verify` varchar(32) DEFAULT NULL,
  `email` varchar(50) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `create_time` int(11) unsigned NOT NULL,
  `update_time` int(11) unsigned NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `type_id` tinyint(2) unsigned DEFAULT '0',
  `info` text NOT NULL,
  `level` char(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `account` (`account`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;