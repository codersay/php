DROP TABLE IF EXISTS `iqishe_article`;
CREATE TABLE `iqishe_article` (
`arcid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(30) NOT NULL DEFAULT '',
`property` varchar(50) NOT NULL DEFAULT '',
`pic` varchar(100) NOT NULL DEFAULT '',
`colid` smallint(5) unsigned NOT NULL DEFAULT '0',
`keyword` varchar(100) NOT NULL DEFAULT '',
`description` text NOT NULL DEFAULT '',
`content` text NOT NULL DEFAULT '',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`updatetime` int(10) unsigned NOT NULL DEFAULT '0',
`click` int(10) unsigned NOT NULL DEFAULT '0',
`mid` smallint(5) unsigned NOT NULL DEFAULT '0',
`source` varchar(100) NOT NULL DEFAULT '',
`ord` tinyint(3) unsigned NOT NULL DEFAULT '50',
`title` varchar(100) NOT NULL DEFAULT '',
`ischeck` tinyint(1) NOT NULL DEFAULT '0',
PRIMARY KEY (`arcid`),
KEY `arcindex` (`username`,`colid`,`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_columns`;
CREATE TABLE `iqishe_columns` (
`colid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`mid` smallint(5) unsigned NOT NULL DEFAULT '0',
`pid` smallint(5) unsigned NOT NULL DEFAULT '0',
`isshow` tinyint(1) unsigned NOT NULL DEFAULT '1',
`colname` varchar(100) NOT NULL DEFAULT '',
`description` varchar(100) NOT NULL DEFAULT '',
`keyword` varchar(100) NOT NULL DEFAULT '',
`seo` varchar(100) NOT NULL DEFAULT '',
`ord` tinyint(3) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`colid`),
KEY `colindex` (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `iqishe_tags`;
CREATE TABLE `iqishe_tags` (
`tagid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`tagname` varchar(100) NOT NULL DEFAULT '',
`num` mediumint(8) unsigned NOT NULL DEFAULT '0',
`addtime` int(10) unsigned NOT NULL DEFAULT '0',
`colid` smallint(5) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`tagid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_singlepage`;
CREATE TABLE `iqishe_singlepage` (
`sgid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`title` varchar(100) NOT NULL DEFAULT '',
`keyword` varchar(100) NOT NULL DEFAULT '',
`description` varchar(200) NOT NULL DEFAULT '',
`username` varchar(30) NOT NULL DEFAULT '',
`click` int(10) NOT NULL DEFAULT '0',
`createtime` int(10) NOT NULL DEFAULT '0',
`updatetime` int(10) NOT NULL DEFAULT '0',
`content` text NOT NULL DEFAULT '',
PRIMARY KEY (`sgid`),
KEY `spindex` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_model`;
CREATE TABLE `iqishe_model` (
`mid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
`mname` varchar(60) NOT NULL DEFAULT '',
`maction` varchar(50) NOT NULL DEFAULT '',
`status` tinyint(1) unsigned NOT NULL DEFAULT '1',
`issystem` tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`mid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

INSERT INTO `iqishe_model` VALUES('1','博文','Article','1','1'),
('2','图集','Image','1','1'),
('3','下载','Download','1','1');

DROP TABLE IF EXISTS `iqishe_comment`;
CREATE TABLE `iqishe_comment` (
`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`arcid` mediumint(8) unsigned NOT NULL DEFAULT '0',
`colid` smallint(5) unsigned NOT NULL DEFAULT '0',
`writer` varchar(30) NOT NULL DEFAULT '',
`ip` varchar(20) NOT NULL DEFAULT '',
`content` text NOT NULL DEFAULT '',
`isreply` tinyint(1) unsigned NOT NULL DEFAULT '0',
`time` int(10) unsigned NOT NULL DEFAULT '0',
`email` varchar(20) NOT NULL DEFAULT '',
`ischeck` tinyint(1) NOT NULL DEFAULT '0',
`pid` mediumint(8) NOT NULL DEFAULT '0',
PRIMARY KEY (`id`),
KEY `cntindex` (`arcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_feedback`;
CREATE TABLE `iqishe_feedback` (
`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`writer` varchar(30) NOT NULL DEFAULT '',
`ip` varchar(20) NOT NULL DEFAULT '',
`content` text NOT NULL DEFAULT '',
`isreply` tinyint(1) unsigned NOT NULL DEFAULT '0',
`time` int(10) unsigned NOT NULL DEFAULT '0',
`email` varchar(20) NOT NULL DEFAULT '',
`ischeck` tinyint(1) NOT NULL DEFAULT '0',
`pid` mediumint(8) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_links`;
CREATE TABLE `iqishe_links` (
`id` smallint(8) unsigned NOT NULL AUTO_INCREMENT,
`linktype` enum('writing','logo') NOT NULL DEFAULT 'writing',
`url` varchar(60) NOT NULL DEFAULT '',
`linkname` varchar(50) NOT NULL DEFAULT '',
`ord` tinyint(3) unsigned NOT NULL DEFAULT '0',
`logo` varchar(60) NOT NULL DEFAULT '',
`remark` varchar(100) NOT NULL DEFAULT '',
`email` varchar(20) NOT NULL DEFAULT '',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`updatetime` int(10) unsigned NOT NULL DEFAULT '0',
`ischeck` tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_users`;
CREATE TABLE `iqishe_users` (
`uid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(30) NOT NULL DEFAULT '',
`pwd` varchar(50) NOT NULL DEFAULT '',
`bindaccount` varchar(50) NOT NULL DEFAULT '',
`logintime` int(10)  unsigned NOT NULL DEFAULT '0',
`loginip` varchar(20) NOT NULL DEFAULT '',
`createtime` int(10) unsigned NOT NULL DEFAULT '0',
`updatetime` int(10) unsigned NOT NULL DEFAULT '0',
`status` tinyint(1) unsigned NOT NULL DEFAULT '1',
`email` varchar(20) NOT NULL DEFAULT '',
`isadmin` tinyint(1) unsigned NOT NULL DEFAULT '0',
PRIMARY KEY (`uid`),
KEY `uindex` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_access`;
CREATE TABLE `iqishe_access` (
`role_id` smallint(6) unsigned NOT NULL,
`node_id` smallint(6) unsigned NOT NULL,
`level` tinyint(1) NOT NULL,
`module` varchar(50) DEFAULT NULL,
`pid` int(11) DEFAULT NULL,
KEY `groupId` (`role_id`),
KEY `nodeId` (`node_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `iqishe_role`;
CREATE TABLE `iqishe_role` (
`id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`pid` smallint(6) DEFAULT NULL,
`status` tinyint(1) unsigned DEFAULT NULL,
`remark` varchar(255) DEFAULT NULL,
PRIMARY KEY (`id`),
KEY `pid` (`pid`),
KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;

DROP TABLE IF EXISTS `iqishe_node`;
CREATE TABLE `iqishe_node` (
`id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
`name` varchar(20) NOT NULL,
`title` varchar(50) DEFAULT NULL,
`status` tinyint(1) DEFAULT '0',
`remark` varchar(255) DEFAULT NULL,
`sort` smallint(6) unsigned DEFAULT NULL,
`pid` smallint(6) unsigned NOT NULL,
`level` tinyint(1) unsigned NOT NULL,
PRIMARY KEY (`id`),
KEY `level` (`level`),
KEY `pid` (`pid`),
KEY `status` (`status`),
KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

INSERT INTO `iqishe_node` VALUES('1','Admin','后台管理','1','后台管理','50','0','1'),
('10','Article','博文管理','1','博文管理','50','1','2'),
('11','Columns','分类管理','1','分类管理','50','1','2'),
('12','Tags','标签管理','1','标签管理','50','1','2'),
('13','Singlepage','单页管理','1','单页管理','50','1','2'),
('14','Model','模型管理','1','模型管理','50','1','2'),
('15','Comment','评论管理','1','评论管理','50','1','2'),
('16','Feedback','留言管理','1','留言管理','50','1','2'),
('17','Links','友情链接','1','友情链接','50','1','2'),
('18','Users','用户列表','1','用户列表','50','1','2'),
('19','Role','角色管理','1','角色管理','50','1','2'),
('20','Node','节点管理','1','节点管理','50','1','2'),
('21','Config','系统设置','1','系统设置','50','1','2'),
('22','Clearcache','清理缓存','1','清理缓存','50','1','2'),
('23','Backupdata','数据备份','1','数据备份','50','1','2'),
('24','Restoredata','数据还原','1','数据还原','50','1','2'),
('25','Index','后台主页','1','后台主页','50','1','2'),
('1000','index','博文列表','1','博文列表','50','10','3'),
('1001','add','添加博文','1','添加博文','50','10','3'),
('1002','edit','编辑博文','1','编辑博文','50','10','3'),
('1003','updateord','博文排序','1','博文排序','50','10','3'),
('1004','check','博文审核','1','博文审核','50','10','3'),
('1005','del','博文删除','1','博文删除','50','10','3'),
('1006','move','博文移动','1','博文移动','50','10','3'),
('1007','addsave','保存新增博文','1','保存新增博文','50','10','3'),
('1008','update','博文编辑更新','1','博文编辑更新','50','10','3'),
('1100','index','分类列表','1','分类列表','50','11','3'),
('1101','add','增加分类','1','增加分类','50','11','3'),
('1102','edit','编辑分类','1','编辑分类','50','11','3'),
('1103','addsun','增加子分类','1','增加子分类','50','11','3'),
('1104','del','删除分类','1','删除分类','50','11','3'),
('1105','updateord','分类排序','1','分类排序','50','11','3'),
('1106','addsave','保存新增分类','1','保存新增分类','50','11','3'),
('1107','update','分类编辑更新','1','分类编辑更新','50','11','3'),
('1108','sunsave','保存子分类','1','保存子分类','50','11','3'),
('1200','index','标签列表','1','标签列表','50','12','3'),
('1201','del','删除单个标签','1','删除单个标签','50','12','3'),
('1202','delall','批量删除标签','1','批量删除标签','50','12','3'),
('1300','index','单页列表','1','单页列表','50','13','3'),
('1301','add','增加单页','1','增加列表','50','13','3'),
('1302','edit','编辑单页','1','编辑单页','50','13','3'),
('1303','del','删除单页','1','删除单页','50','13','3'),
('1304','addsave','保存新增单页','1','保存新增单页','50','13','3'),
('1305','update','更新单页','1','更新单页','50','13','3'),
('1400','index','模型列表','1','模型列表','50','14','3'),
('1401','updown','启用禁用模型','1','启用禁用模型','50','14','3'),
('1500','index','评论列表','1','评论列表','50','15','3'),
('1501','reply','评论回复','1','评论回复','50','15','3'),
('1502','check','评论审核','1','评论审核','50','15','3'),
('1503','del','评论删除','1','评论删除','50','15','3'),
('1504','replyAdd','保存评论回复','1','保存评论回复','50','15','3'),
('1600','index','留言列表','1','留言列表','50','16','3'),
('1601','reply','留言回复','1','留言回复','50','16','3'),
('1602','del','留言删除','1','留言删除','50','16','3'),
('1603','replyAdd','保存留言回复','1','保存留言回复','50','16','3'),
('1700','index','链接列表','1','链接列表','50','17','3'),
('1701','add','增加链接','1','增加链接','50','17','3'),
('1702','edit','编辑链接','1','编辑链接','50','17','3'),
('1703','check','链接审核','1','链接审核','50','17','3'),
('1704','del','链接删除','1','链接删除','50','17','3'),
('1705','addSave','保存新增链接','1','保存新增链接','50','17','3'),
('1706','update','更新链接','1','更新链接','50','17','3'),
('1707','updateord','更新链接排序','1','更新链接排序','50','17','3'),
('1800','index','用户列表','1','用户列表','50','18','3'),
('1801','add','增加用户','1','增加用户','50','18','3'),
('1802','pwd','修改密码','1','修改密码','50','18','3'),
('1803','changePwd','修改密码提交','1','修改密码提交','50','18','3'),
('1804','addsave','保存新增用户','1','保存新增用户','50','18','3'),
('1805','edit','编辑用户','1','编辑用户','50','18','3'),
('1806','update','更新用户','1','更新用户','50','18','3'),
('1807','del','删除用户','1','删除用户','50','18','3'),
('1808','updown','启用禁用用户','1','启用禁用用户','50','18','3'),
('1900','index','角色列表','1','角色列表','50','19','3'),
('2000','index','节点列表','1','节点列表','50','20','3'),
('2100','index','系统设置','1','系统设置','50','21','3'),
('2200','index','清理缓存','1','清理缓存','50','22','3'),
('2300','index','数据备份','1','数据备份','50','23','3'),
('2400','index','数据还原','1','数据还原','50','24','3'),
('2500','index','系统首页','1','系统首页','50','25','3'),
('2501','main','系统主页','1','系统主页','50','25','3'),
('2502','menu','系统菜单','1','系统菜单','50','25','3');

DROP TABLE IF EXISTS `iqishe_role_user`;
CREATE TABLE `iqishe_role_user` (
`role_id` mediumint(9) unsigned DEFAULT NULL,
`user_id` char(32) DEFAULT NULL,
KEY `group_id` (`role_id`),
KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;