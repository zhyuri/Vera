/**
*
* @copyright  Copyright (c) 2014 Yuri Zhang (http://www.yurilab.com)
* All rights reserved
*
* filename:   mysql.sql
* description:  MySQL数据库导入文件
*
* @author Yuri
* @license Apache v2 License
* 
**/

-- 主机: localhost
-- 生成日期: 2014 年 04 月 17 日 20:15
-- 服务器版本: 5.1.62
-- PHP 版本: 5.3.2-1ubuntu4.19

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- 表的结构 `EventReply`
--

CREATE TABLE IF NOT EXISTS `EventReply` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serverID` varchar(20) NOT NULL COMMENT '公众号ID',
  `eventType` varchar(20) NOT NULL COMMENT '事件类型',
  `reply` text COMMENT '回复内容',
  `replyType` varchar(10) DEFAULT NULL COMMENT '回复内容类型',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `EventReply`
--

INSERT INTO `EventReply` VALUES(1, ' ', 'subscribe', '{\r\n    "Content":"欢迎关注测试公众号"\r\n}', 'text');
INSERT INTO `EventReply` VALUES(2, ' ', 'LOCATION', 'driving', 'route');

-- --------------------------------------------------------

--
-- 表的结构 `Keyword`
--

CREATE TABLE IF NOT EXISTS `Keyword` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serverID` varchar(20) NOT NULL COMMENT '公众号ID',
  `keyword` varchar(100) NOT NULL COMMENT '关键字',
  `reply` text COMMENT '每种回复信息的特殊部分存储为json编码',
  `replyType` varchar(10) NOT NULL DEFAULT 'text' COMMENT '回复内容类型',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `Keyword`
--

INSERT INTO `Keyword` VALUES(1, ' ', '博客', NULL, 'blog');
INSERT INTO `Keyword` VALUES(3, ' ', '抽奖', NULL, 'lucky');

-- --------------------------------------------------------

--
-- 表的结构 `ServerID`
--

CREATE TABLE IF NOT EXISTS `ServerID` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serverID` varchar(20) DEFAULT NULL COMMENT '公众号ID',
  `name` varchar(100) DEFAULT NULL COMMENT '公众号名称',
  `defaultReply` text COMMENT '默认的回复信息',
  `latitude` double NOT NULL DEFAULT '0' COMMENT '纬度',
  `longitude` double NOT NULL DEFAULT '0' COMMENT '经度',
  `remarks` varchar(100) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='用于存储公众号的ID信息，新建的公众号没有name和remarks，已有公众号必须完善此信息';

--
-- 转存表中的数据 `ServerID`
--

INSERT INTO `ServerID` VALUES(1, ' ', '测试用公众号', '这里是欢迎信息\nThis is welcome message', 24.437363, 118.097105, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `SpecialWords`
--

CREATE TABLE IF NOT EXISTS `SpecialWords` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `serverID` varchar(20) NOT NULL COMMENT '公众号ID',
  `specialWords` varchar(20) NOT NULL COMMENT '特殊关键字',
  `plugin` varchar(20) NOT NULL COMMENT '对应的处理插件',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `SpecialWords`
--

INSERT INTO `SpecialWords` VALUES(1, ' ', '注册', 'register');
INSERT INTO `SpecialWords` VALUES(2, ' ', '注销', 'register');
INSERT INTO `SpecialWords` VALUES(3, ' ', '会员', 'register');
INSERT INTO `SpecialWords` VALUES(4, ' ', '成绩', 'cet');
