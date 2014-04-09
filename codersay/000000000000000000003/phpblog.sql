-- phpMyAdmin SQL Dump
-- version 3.3.1
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2010 年 12 月 09 日 21:43
-- 服务器版本: 5.0.22
-- PHP 版本: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `phpblog`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `usrename` varchar(40) NOT NULL,
  `password` varchar(40) NOT NULL,
  `nickname` varchar(40) NOT NULL,
  `email` varchar(40) NOT NULL,
  `logintime` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- 转存表中的数据 `admin`
--


-- --------------------------------------------------------

--
-- 表的结构 `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(80) NOT NULL,
  `orderid` varchar(3) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=33 ;

--
-- 转存表中的数据 `category`
--

INSERT INTO `category` (`id`, `name`, `orderid`) VALUES
(22, 'php常用函数', '1'),
(23, 'ThinkPHP框架', '1'),
(27, 'php网站SEO', '1'),
(28, 'php技术博客', '1'),
(32, 'test', '1'),
(31, '222心情随笔', '222');

-- --------------------------------------------------------

--
-- 表的结构 `comment`
--

CREATE TABLE IF NOT EXISTS `comment` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL,
  `author` varchar(40) NOT NULL,
  `authoremail` varchar(100) NOT NULL,
  `authorurl` varchar(200) NOT NULL,
  `authorip` varchar(100) NOT NULL,
  `content` text,
  `parent` int(10) unsigned NOT NULL,
  `create_time` datetime NOT NULL,
  `checked` tinyint(1) default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=50 ;

--
-- 转存表中的数据 `comment`
--

INSERT INTO `comment` (`id`, `pid`, `author`, `authoremail`, `authorurl`, `authorip`, `content`, `parent`, `create_time`, `checked`) VALUES
(46, 0, 'ken', 'phpboke@163.com', 'http://www.phpboke.com', '127.0.0.1', 'This is a test', 0, '2010-11-28 22:24:55', 0),
(49, 0, '其轻轻轻轻', '111', '111', '127.0.0.1', '11', 0, '2010-12-01 20:29:49', 0),
(48, 0, 'zzz', 'zzz', 'zz', '127.0.0.1', 'zzz', 0, '2010-11-28 22:37:07', 0),
(47, 0, '555', '555', '55', '127.0.0.1', '55', 0, '2010-11-28 22:29:27', 0);

-- --------------------------------------------------------

--
-- 表的结构 `link`
--

CREATE TABLE IF NOT EXISTS `link` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(80) NOT NULL,
  `url` varchar(100) NOT NULL,
  `display` varchar(5) default '1',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `link`
--

INSERT INTO `link` (`id`, `name`, `url`, `display`, `create_time`, `update_time`) VALUES
(2, 'ThinkPHP框架', 'www.thinkphp.cn', '1', '0000-00-00 00:00:00', '2010-11-10 21:01:12'),
(11, '网易', 'www.163.com', '1', '2010-10-24 21:13:26', '2010-10-24 21:27:14'),
(9, 'baidu', 'www.baidu.com', '1', '0000-00-00 00:00:00', '2010-10-24 21:27:19'),
(10, 'sina', 'www.sina.com.cn', '1', '2010-10-24 21:10:22', '2010-10-24 21:10:22'),
(12, '开心网', 'www.kaixin001.com', '1', '2010-10-24 21:22:41', '2010-10-24 21:27:04'),
(13, '图王', 'www.admin5.com', '1', '2010-10-24 21:24:25', '2010-10-26 21:50:36'),
(15, 'bokee', 'www.bokee.com', '0', '2010-10-26 21:24:29', '2010-10-26 21:24:36'),
(19, '111tset', 'test', '1', '2010-11-10 21:03:30', '2010-11-17 21:20:41');

-- --------------------------------------------------------

--
-- 表的结构 `page`
--

CREATE TABLE IF NOT EXISTS `page` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(80) NOT NULL,
  `content` text,
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `hits` int(10) unsigned default '0',
  `orderid` int(8) unsigned NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `page`
--

INSERT INTO `page` (`id`, `name`, `content`, `create_time`, `update_time`, `hits`, `orderid`) VALUES
(1, '大学', '<p>我的大学生活的描述</p>', '0000-00-00 00:00:00', '2010-11-18 21:41:12', 0, 0),
(2, '友情链接', '友情链接的描述', '2010-10-21 10:00:10', '2010-11-18 21:41:33', 0, 0),
(3, 'About Me', '<p>关于我的个人简介</p>', '2010-10-21 10:40:10', '2010-11-18 21:42:07', 0, 0),
(4, 'PHP开源项目', '开源项目的介绍', '2010-10-21 10:48:10', '2010-11-18 21:42:55', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `post`
--

CREATE TABLE IF NOT EXISTS `post` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `title` varchar(80) NOT NULL,
  `content` text,
  `show_top` tinyint(1) default '0',
  `hits` int(10) unsigned NOT NULL default '0',
  `create_time` datetime NOT NULL,
  `update_time` datetime NOT NULL default '0000-00-00 00:00:00',
  `cid` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `post`
--

INSERT INTO `post` (`id`, `title`, `content`, `show_top`, `hits`, `create_time`, `update_time`, `cid`) VALUES
(1, '测试标题', '测试标题测试标题内容', 0, 14, '2010-10-21 20:09:13', '2010-10-26 20:06:48', 22),
(2, '反复反复反复反复', '点点点', 0, 7, '2010-10-21 20:11:38', '2010-10-26 20:08:45', 27),
(16, 'sdfsdf', 'sdfds', 0, 9, '2010-10-26 20:04:04', '0000-00-00 00:00:00', 28),
(4, '5555', '555', 0, 3, '2010-10-21 20:16:59', '0000-00-00 00:00:00', 22),
(5, '反反复复', '方法', 0, 13, '2010-10-21 20:19:40', '2010-10-26 20:11:56', 22),
(6, '任溶溶', '揉揉', 0, 4, '2010-10-21 20:19:49', '0000-00-00 00:00:00', 23),
(7, '踢踢腿', '&nbsp;天天', 0, 2, '2010-10-21 20:24:57', '0000-00-00 00:00:00', 22),
(8, '222', '踢踢腿', 0, 13, '2010-10-21 21:36:08', '2010-10-26 20:13:34', 22),
(9, '测试标题', '测试标题测试标题内容', 0, 18, '2010-10-25 23:08:13', '2010-10-26 20:09:13', 27),
(10, '反复反复反复反复33', '点点点', 0, 12, '2010-10-25 23:08:38', '0000-00-00 00:00:00', 27),
(11, '反复反复反复反复33', '点点点', 0, 14, '2010-10-25 23:08:46', '2010-10-26 21:30:54', 27),
(12, '44444反反复复1111', '方法', 0, 5, '2010-10-26 19:43:17', '2010-10-26 20:06:15', 23),
(13, '反复反复反复反复111', '点点点', 0, 11, '2010-10-26 19:43:24', '0000-00-00 00:00:00', 27),
(18, 'frfrfr', 'frfrf', 0, 9, '2010-10-26 20:04:47', '2010-10-26 20:07:46', 23),
(19, '222ThinkPHP框架测试类别111', '这里填下具体的内容谔谔', 1, 29, '2010-10-26 20:23:06', '2010-10-26 21:03:58', 23),
(20, '方夫人夫人房', '润肤乳房', 0, 17, '2010-10-26 20:27:16', '0000-00-00 00:00:00', 22),
(23, '似懂非懂是否', '士大夫是', 0, 17, '1970-01-01 00:00:00', '2010-10-26 20:39:30', 22),
(25, '润肤乳房', '夫人夫人', 1, 27, '2010-10-26 20:46:05', '2010-10-26 21:00:41', 22),
(26, '333通过沟通', '333通过提供', 1, 102, '2010-10-26 20:56:17', '2010-11-18 21:34:58', 22),
(29, 'test title', 'test content', 1, 2, '2010-12-09 21:14:20', '2010-12-09 21:14:20', 32);

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `username` varchar(45) NOT NULL,
  `password` varchar(45) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3');
