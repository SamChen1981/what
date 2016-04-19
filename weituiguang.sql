-- phpMyAdmin SQL Dump
-- version 3.4.7
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2012 年 12 月 27 日 13:50
-- 服务器版本: 5.5.17
-- PHP 版本: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `wbtg`
--
CREATE DATABASE `wbtg` DEFAULT CHARACTER SET gbk COLLATE gbk_chinese_ci;
USE `wbtg`;

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_admin`
--

CREATE TABLE IF NOT EXISTS `weiqi_admin` (
  `admin_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `lasttime` int(10) DEFAULT '0',
  `login_count` int(6) DEFAULT '0',
  PRIMARY KEY (`admin_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `weiqi_admin`
--

INSERT INTO `weiqi_admin` (`admin_id`, `username`, `password`, `lasttime`, `login_count`) VALUES
(1, 'admin', '96e79218965eb72c92a549dd5a330112', 1356586245, 230);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_article`
--

CREATE TABLE IF NOT EXISTS `weiqi_article` (
  `article_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `remark` text,
  `type` int(1) DEFAULT '0',
  PRIMARY KEY (`article_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

--
-- 转存表中的数据 `weiqi_article`
--

INSERT INTO `weiqi_article` (`article_id`, `name`, `remark`, `type`) VALUES
(3, '这是测试文章1', '哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容<br /><br /><br /><strong>哈哈，这是测试文章内容哈哈，这是测试文章内容</strong>', 1),
(4, '这是测试文章2', '哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容的', 1),
(5, '这是测试文章3', '哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容', 1),
(6, '这是测试文章4', '哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容哈哈，这是测试文章内容', 1),
(7, '如何注册', '哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试', 2),
(8, '如何注册2', '哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试哈哈，这是帮助中心测试', 2),
(9, '关于我们', '关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息', 3),
(10, '加入我们', '关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息', 3),
(11, '联系我们', '关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息关于我们测试信息', 3),
(12, '视频教程测试', '视频教程视频教程', 4),
(14, '如何接单', '<h5>如何注册</h5><center><div id="CaptivateContent"><embed height="522" type="application/x-shockwave-flash" width="710" src="./video/jiedan.swf" allowfullscreen="true" loop="true" play="true" menu="false" quality="high" wmode="opaque" classid="clsid:d27cdb6e-ae6d-11cf-96b8-4445535400000" />&nbsp;</div></center>', 4),
(16, '答复', '的发生的发生的发生地方', 1),
(17, '22222222222', '22222222222222222', 1),
(18, '22222222222', '999999999999', 1),
(19, '22222222222', '22222222222222222222222222', 3);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_blog`
--

CREATE TABLE IF NOT EXISTS `weiqi_blog` (
  `blog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `platform` enum('sina','qq') DEFAULT NULL,
  `name` varchar(200) DEFAULT '',
  `nick` varchar(30) NOT NULL DEFAULT '',
  `weibo` varchar(200) DEFAULT '',
  `image` varchar(100) DEFAULT '',
  `fansnum` int(10) DEFAULT NULL,
  `hots` int(5) DEFAULT '0',
  `zp_rate` float(4,2) NOT NULL DEFAULT '0.00' COMMENT '转评率',
  `verifyinfo` enum('Y','N') DEFAULT 'N',
  `money` float(9,2) DEFAULT '0.00' COMMENT '转发价格',
  `price` float(9,2) DEFAULT '0.00',
  `keywords` varchar(255) DEFAULT '',
  `publish_money` float(9,2) DEFAULT '0.00' COMMENT '直发价格',
  `click_money` float(9,2) DEFAULT '0.00' COMMENT '点击价格',
  `com_money` float(9,2) unsigned DEFAULT '0.00' COMMENT '平台转发价格',
  `com_pmoney` float(9,2) unsigned DEFAULT '0.00' COMMENT '平台直发价格',
  `com_click` float(9,2) unsigned DEFAULT '0.00' COMMENT '平台点击价格',
  `bind` varchar(20) DEFAULT NULL,
  `twitternum` int(5) DEFAULT NULL,
  `follownum` int(10) DEFAULT NULL,
  `week_order` int(10) DEFAULT '0' COMMENT '周订单量',
  `month_order` int(10) DEFAULT '0' COMMENT '月订单量',
  `location` varchar(100) DEFAULT NULL,
  `sex` enum('m','f','n') DEFAULT 'n',
  `to_sex` varchar(2) DEFAULT '0' COMMENT '受众性别 0大众 1男 2女',
  `soft` enum('N','Y') DEFAULT 'Y' COMMENT '是否软广',
  `reject` enum('Y','N') DEFAULT 'N' COMMENT '是否拒绝订单',
  `auction` enum('Y','N') DEFAULT 'Y',
  `shield` enum('Y','N') DEFAULT 'N' COMMENT '是否直发',
  `class` tinyint(1) DEFAULT '0' COMMENT '0 大众 1草根微博主 2红人馆 3媒体汇 4精品小号',
  `give_m` int(3) DEFAULT '0' COMMENT '收费%比',
  `lasttime` int(10) DEFAULT '0',
  `regtime` int(10) DEFAULT '0',
  `lock` enum('0','1','2') DEFAULT '0' COMMENT '0 待审核 1 通过审核 2驳回',
  PRIMARY KEY (`blog_id`),
  KEY `NewIndex1` (`member_id`),
  KEY `NewIndex2` (`lock`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4920 ;

--
-- 转存表中的数据 `weiqi_blog`
--

INSERT INTO `weiqi_blog` (`blog_id`, `member_id`, `platform`, `name`, `nick`, `weibo`, `image`, `fansnum`, `hots`, `zp_rate`, `verifyinfo`, `money`, `price`, `keywords`, `publish_money`, `click_money`, `com_money`, `com_pmoney`, `com_click`, `bind`, `twitternum`, `follownum`, `week_order`, `month_order`, `location`, `sex`, `to_sex`, `soft`, `reject`, `auction`, `shield`, `class`, `give_m`, `lasttime`, `regtime`, `lock`) VALUES
(4, 4, 'qq', '发达', '', 'http://www.baidu.com', '', 434343, 2, 0.00, 'Y', 22.00, 0.51, 'fdafda', 2.33, 0.00, 27.50, 2.91, 0.00, '', 0, 0, 1, 1, '', '', NULL, 'N', 'N', NULL, 'N', 0, 25, 1337054111, 1336390958, '1'),
(4883, 4, 'qq', 'qqvipgame', 'QQ会员游戏特权', 'http://t.qq.com/qqvipgame', 'http://app.qlogo.cn/mbloghead/66e4d3f0a4c33bdde37e/100', 39451611, 0, 3.84, 'Y', 21.00, 0.00, '', 21.00, 0.00, 24.15, 24.15, 0.00, NULL, NULL, NULL, 0, 0, '中国 广东 深圳', 'm', '0', 'Y', 'Y', 'Y', 'Y', 0, 15, 0, 1340562285, '1'),
(8, 4, 'qq', 'f测试', '', 'http://www.ddd', '', 12221, 0, 0.00, 'N', 34.00, 27.82, 'fdsaf fdfff', 22.00, 0.00, 42.50, 27.50, 0.00, '', 0, 0, 0, 0, '', '', NULL, 'Y', 'N', 'Y', 'N', 0, 25, 1337155232, NULL, '1'),
(4880, 4, 'sina', 'iloveufly', '简单生活', 'http://t.qq.com/iloveufly', 'http://app.qlogo.cn/mbloghead/3e1a8c0eb7395ab9b2fa/100', 87, 0, 9.99, 'N', 321.00, 0.00, '', 32.00, 0.00, 369.15, 36.80, 0.00, NULL, NULL, NULL, 0, 0, '中国 江西 南昌', 'm', NULL, 'Y', 'Y', 'Y', 'Y', 0, 15, 0, 1340442618, '1'),
(4867, 4, 'sina', '郎咸平', '郎咸平', 'http://weibo.com/1684388950', 'http://tp2.sinaimg.cn/1923882865/50/0/1', 10764340, 0, 0.00, 'Y', 12.00, 0.00, NULL, 123.00, 0.00, 15.00, 153.75, 0.00, NULL, NULL, NULL, 30, 30, NULL, '', NULL, 'Y', 'N', 'Y', 'N', 0, 25, NULL, 1340014457, '1'),
(4868, 4, 'sina', 'nxLvYou', '塑身女王', 'http://t.qq.com/nxLvYou', 'http://tp2.sinaimg.cn/1923882865/50/0/1', 217879, 0, 0.00, 'N', 212.00, 0.00, NULL, 11.00, 0.00, 265.00, 13.75, 0.00, NULL, NULL, NULL, 4, 4, '新疆 乌鲁木齐', 'n', NULL, 'Y', 'Y', 'Y', 'N', 0, 25, NULL, 1340021906, '1'),
(4869, 4, 'qq', 'chuangyejia', '创业家杂志', 'http://t.qq.com/chuangyejia', 'http://tp2.sinaimg.cn/1923882865/50/0/1', 658263, 0, 0.00, 'Y', 111.00, 0.00, NULL, 1222.00, 0.00, 138.75, 1527.50, 0.00, NULL, NULL, NULL, 0, 0, '新疆 乌鲁木齐', 'f', NULL, 'Y', 'Y', 'Y', 'N', 0, 25, NULL, 1340022127, '1'),
(4882, 4, 'sina', '周鸿祎', '周鸿祎', 'http://weibo.com/1708942053', 'http://tp2.sinaimg.cn/1708942053/50/5634391713/1', 3342969, 0, 9.99, 'Y', 321.00, 0.00, '', 32.00, 0.00, 369.15, 36.80, 0.00, NULL, NULL, NULL, 6, 6, '北京 朝阳区', 'm', NULL, 'Y', 'Y', 'Y', 'Y', 0, 15, 0, 1340443528, '1'),
(4884, 4, 'sina', '360用户特供机', '360用户特供机', 'http://weibo.com/2798510462', 'http://tp3.sinaimg.cn/2798510462/50/5632019979/1', 174645, 0, 99.99, 'Y', 21.00, 0.00, '', 21.00, 0.00, 24.15, 24.15, 0.00, NULL, NULL, NULL, 0, 0, '北京', 'm', '0', 'Y', 'Y', 'Y', 'Y', 0, 15, 0, 1340562818, '1'),
(4885, 47, 'sina', '坏人', '坏人', 'http://weibo.com/1644844331', 'http://tp4.sinaimg.cn/1644844331/50/5624155495/1', 17358, 0, 7.06, 'N', 12313.00, 0.00, '', 123.00, 0.00, 14159.95, 141.45, 0.00, NULL, NULL, NULL, 10, 10, '浙江 杭州', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346439349, '1'),
(4886, 47, 'sina', '姚晨', '姚晨', 'http://weibo.com/1266321801', 'http://tp2.sinaimg.cn/1266321801/50/5629186861/0', 24050562, 0, 4.53, 'Y', 15.00, 0.00, '', 15.00, 0.00, 17.25, 17.25, 0.00, NULL, NULL, NULL, 13, 13, '北京 朝阳区', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346578187, '1'),
(4887, 47, 'sina', '刘强东', '刘强东', 'http://weibo.com/1866402485', 'http://tp2.sinaimg.cn/1866402485/50/5640007423/1', 1893891, 0, 81.67, 'Y', 15.00, 0.00, '', 15.00, 0.00, 17.25, 17.25, 0.00, NULL, NULL, NULL, 6, 6, '北京 朝阳区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346578769, '1'),
(4888, 47, 'sina', '刘德华', '劉德華', 'http://weibo.com/1642890241', 'http://tp2.sinaimg.cn/1642890241/50/0/1', 22769, 0, 26.79, 'N', 15.00, 0.00, '', 15.00, 15.00, 17.25, 17.25, 15.00, NULL, NULL, NULL, 4, 4, '北京 海淀区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346579020, '1'),
(4889, 47, 'sina', '花瓣网', '花瓣网', 'http://weibo.com/2493118952', 'http://tp1.sinaimg.cn/2493118952/50/5626596493/0', 555628, 0, 11.10, 'Y', 11.00, 0.00, '', 11.00, 15.00, 12.65, 12.65, 15.00, NULL, NULL, NULL, 6, 6, '浙江 杭州', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346579189, '1'),
(4890, 47, 'sina', '网易新闻客户端', '网易新闻客户端', 'http://weibo.com/1974808274', 'http://tp3.sinaimg.cn/1974808274/50/1299826686/1', 43022, 0, 15.37, 'Y', 11.00, 0.00, '', 11.00, 15.00, 12.65, 12.65, 15.00, NULL, NULL, NULL, 7, 7, '北京 海淀区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346579451, '1'),
(4902, 53, 'sina', 'GIF图精选', 'GIF图精选', 'http://weibo.com/1853425063', 'http://tp4.sinaimg.cn/1853425063/50/5638695780/1', 1622029, 0, 4.28, 'N', 1200.00, 0.00, '', 11.00, 1.00, 1380.00, 12.65, 1.15, NULL, NULL, NULL, 4, 4, '北京 怀柔区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1353657127, 1353637507, '1'),
(4892, 47, 'sina', '任志强', '任志强', 'http://weibo.com/1182389073', 'http://tp2.sinaimg.cn/1182389073/50/1283203476/1', 9791601, 0, 2.82, 'Y', 2.00, 0.00, '', 1.00, 0.00, 2.30, 1.15, 0.00, NULL, NULL, NULL, 7, 7, '北京', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1346581206, '1'),
(4894, 48, 'qq', 'huangbaiming99', '黄百鸣', 'http://t.qq.com/huangbaiming99', 'http://app.qlogo.cn/mbloghead/013db4faf2ac9912e1a0/100', 3011599, 0, 0.95, 'Y', 2.00, 0.00, '', 22.00, 22.00, 2.30, 25.30, 25.30, NULL, NULL, NULL, 1, 1, '未知', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1351655859, '1'),
(4895, 48, 'sina', 'Name-张在阳', 'Name-张在阳', 'http://weibo.com/2232628617', 'http://tp2.sinaimg.cn/2232628617/50/5605015370/1', 9, 0, 99.99, 'N', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 24, 24, '北京 海淀区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1353221158, 1351669460, '1'),
(4896, 48, 'sina', '薛蛮子', '薛蛮子', 'http://weibo.com/1813080181', 'http://tp2.sinaimg.cn/1813080181/50/5641600999/1', 4812277, 0, 1.37, 'Y', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 2, 2, '北京 朝阳区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1351843623, '1'),
(4897, 48, 'qq', 'hqsbhuanqiuwang', '环球时报环球网', 'http://t.qq.com/hqsbhuanqiuwang', 'http://app.qlogo.cn/mbloghead/a39a02a3e930af27de46/100', 2075224, 0, 0.35, 'Y', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 1, 1, '中国 朝阳', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1351843722, '1'),
(4898, 49, 'qq', 'taskwei', '何炅', 'http://t.qq.com/taskwei', 'http://app.qlogo.cn/mbloghead/59eb411a574458cc7f3c/100', 33593011, 0, 4.59, 'Y', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 1, 1, '未知', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1351851427, 1351849167, '1'),
(4900, 48, 'sina', '劉德華全球歌迷會', '劉德華全球歌迷會', 'http://weibo.com/2176991194', 'http://tp3.sinaimg.cn/2176991194/50/5603395146/0', 279968, 0, 0.00, 'N', 111.00, 0.00, '', 111.00, 111.00, 127.65, 127.65, 127.65, NULL, NULL, NULL, 6, 6, '北京', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1353396127, '1'),
(4901, 48, 'sina', '神秘心理学', '神秘心理学', 'http://weibo.com/1100678467', 'http://tp4.sinaimg.cn/1100678467/50/5604972265/1', 860472, 0, 4.17, 'N', 111.00, 0.00, '', 111.00, 111.00, 127.65, 127.65, 127.65, NULL, NULL, NULL, 0, 0, '江苏 南京', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1353404222, '2'),
(4903, 53, 'sina', '君临天下', '君临天下', 'http://weibo.com/1091735405', 'http://tp2.sinaimg.cn/1091735405/50/5602340814/1', 32867, 0, 0.66, 'Y', 111.00, 0.00, '', 11.00, 1.00, 127.65, 12.65, 1.15, NULL, NULL, NULL, 0, 0, '北京 海淀区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1353637538, '1'),
(4904, 48, 'sina', '冯唐', '冯唐', 'http://weibo.com/1193258161', 'http://tp2.sinaimg.cn/1193258161/50/5647970152/1', 3718680, 0, 0.89, 'Y', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 1, 1, '其他', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354092295, '1'),
(4905, 56, 'sina', '北京消防', '北京消防', 'http://weibo.com/2258833123', 'http://tp4.sinaimg.cn/2258833123/50/5640999087/1', 1966408, 0, 13.08, 'Y', 1000.00, 0.00, '', 1000.00, 1.00, 1150.00, 1150.00, 1.15, NULL, NULL, NULL, 3, 3, '北京', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354092352, '1'),
(4906, 55, 'sina', '冷笑话精选', '冷笑话精选', 'http://weibo.com/1644395354', 'http://tp3.sinaimg.cn/1644395354/50/40002141909/1', 10557160, 0, 3.69, 'N', 0.30, 0.00, '', 1.00, 0.10, 0.34, 1.15, 0.11, NULL, NULL, NULL, 11, 11, '广东 广州', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354251235, '1'),
(4907, 57, 'sina', '温大文', '温大文', 'http://weibo.com/1095456370', 'http://tp3.sinaimg.cn/1095456370/50/40007486054/1', 157772, 0, 0.05, 'N', 5.00, 0.00, '', 5.00, 1.00, 5.75, 5.75, 1.15, NULL, NULL, NULL, 3, 3, '四川 成都', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354280139, '1'),
(4908, 58, 'sina', '焦点联播', '焦点联播', 'http://weibo.com/2283406765', 'http://tp2.sinaimg.cn/2283406765/50/22817018779/1', 70411, 0, 65.76, 'N', 3.00, 0.00, '', 7.00, 1.00, 3.45, 8.05, 1.15, NULL, NULL, NULL, 6, 6, '上海', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354365178, '1'),
(4909, 58, 'sina', '苹果汇', '苹果汇', 'http://weibo.com/1987543647', 'http://tp4.sinaimg.cn/1987543647/50/5644831935/1', 1427156, 0, 6.90, 'Y', 2.00, 0.00, '', 5.00, 0.80, 2.30, 5.75, 0.92, NULL, NULL, NULL, 7, 7, '北京 海淀区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354365255, '1'),
(4910, 55, 'sina', '杭州雨丝婚纱摄影', '杭州雨丝婚纱摄影', 'http://weibo.com/2634673051', 'http://tp4.sinaimg.cn/2634673051/50/5634273626/0', 52718, 0, 0.21, 'Y', 1.00, 0.00, '', 1.50, 0.30, 1.15, 1.73, 0.34, NULL, NULL, NULL, 6, 6, '浙江 杭州', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354365430, '1'),
(4911, 55, 'sina', '中国好声音', '中国好声音', 'http://weibo.com/2819027752', 'http://tp1.sinaimg.cn/2819027752/50/5637231616/1', 1303732, 0, 20.46, 'Y', 1.00, 0.00, '', 3.00, 0.30, 1.15, 3.45, 0.34, NULL, NULL, NULL, 5, 5, '浙江 杭州', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354365460, '1'),
(4912, 59, 'sina', '萧山日报', '萧山日报', 'http://weibo.com/1760203754', 'http://tp3.sinaimg.cn/1760203754/50/5607073139/0', 30009, 0, 4.83, 'Y', 10.00, 0.00, '', 10.00, 10.00, 11.50, 11.50, 11.50, NULL, NULL, NULL, 3, 3, '浙江 杭州', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354461450, '1'),
(4913, 61, 'sina', '萧山微博力量', '萧山微博力量', 'http://weibo.com/3050689503', 'http://tp4.sinaimg.cn/3050689503/50/40008103938/1', 7449, 0, 12.81, 'N', 20.00, 0.00, '', 20.00, 1.00, 23.00, 23.00, 1.15, NULL, NULL, NULL, 1, 1, '浙江 杭州', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354586546, '1'),
(4914, 63, 'sina', '温州微博力量', '温州微博力量', 'http://weibo.com/2401982602', 'http://tp3.sinaimg.cn/2401982602/50/39997802375/1', 173329, 0, 42.74, 'N', 15.00, 0.00, '', 15.00, 20.00, 17.25, 17.25, 23.00, NULL, NULL, NULL, 3, 3, '浙江 温州', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1354671328, '1'),
(4915, 64, 'sina', '萧山19楼', '萧山19楼', 'http://weibo.com/1831257380', 'http://tp1.sinaimg.cn/1831257380/50/5633832733/0', 25402, 0, 3.82, 'Y', 10.00, 0.00, '打打', 10.00, 20.00, 11.50, 11.50, 23.00, NULL, NULL, NULL, 0, 0, '浙江 杭州', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1355029991, 1354672700, '1'),
(4916, 66, 'sina', '时尚妆卖店官网', '时尚妆卖店官网', 'http://weibo.com/3006931637', 'http://tp2.sinaimg.cn/3006931637/50/40007507801/0', 41478, 0, 0.01, 'Y', 222.00, 0.00, '', 2222.00, 222.00, 255.30, 2555.30, 255.30, NULL, NULL, NULL, 0, 0, '其他', 'f', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1355037147, '1'),
(4917, 67, 'sina', '王力宏', '王力宏', 'http://weibo.com/1793285524', 'http://tp1.sinaimg.cn/1793285524/50/5616434063/1', 123456789, 0, 8.38, 'Y', 1.00, 0.00, '', 1.00, 1.00, 1.15, 1.15, 1.15, NULL, NULL, NULL, 1, 1, '台湾 台北市', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1355459139, 1355051131, '1'),
(4918, 65, 'sina', '武汉新浪乐居', '武汉新浪乐居', 'http://weibo.com/1267527155', 'http://tp4.sinaimg.cn/1267527155/50/5600239912/1', 354086, 0, 1.11, 'Y', 5.00, 0.00, '', 5.00, 5.00, 5.75, 5.75, 5.75, NULL, NULL, NULL, 1, 1, '湖北 武汉', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 1355473619, 1355459391, '1'),
(4919, 48, 'sina', '土摩托', '土摩托', 'http://weibo.com/1737847545', 'http://tp2.sinaimg.cn/1737847545/50/1279897776/1', 289723, 0, 4.19, 'Y', 2.00, 0.00, '', 2.00, 2.00, 2.30, 2.30, 2.30, NULL, NULL, NULL, 0, 0, '北京 朝阳区', 'm', '0', 'Y', 'N', 'Y', 'Y', 0, 15, 0, 1356585769, '0');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_blog_block`
--

CREATE TABLE IF NOT EXISTS `weiqi_blog_block` (
  `bblock_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) DEFAULT NULL,
  `member_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`bblock_id`),
  KEY `blog_id` (`blog_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

--
-- 转存表中的数据 `weiqi_blog_block`
--

INSERT INTO `weiqi_blog_block` (`bblock_id`, `blog_id`, `member_id`) VALUES
(37, 4918, 52),
(36, 4883, 60),
(38, 4917, 52),
(39, 4883, 52),
(40, 8, 52),
(41, 4880, 52),
(42, 4, 52);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_blog_fav`
--

CREATE TABLE IF NOT EXISTS `weiqi_blog_fav` (
  `bfav_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `blog_id` int(10) DEFAULT NULL,
  `member_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`bfav_id`),
  KEY `blog_id` (`blog_id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=36 ;

--
-- 转存表中的数据 `weiqi_blog_fav`
--

INSERT INTO `weiqi_blog_fav` (`bfav_id`, `blog_id`, `member_id`) VALUES
(19, 4882, 4),
(20, 4867, 4),
(17, 4883, 4),
(21, 4885, 51),
(22, 4890, 51),
(23, 4891, 51),
(24, 4889, 51),
(25, 4895, 52),
(26, 4898, 54),
(27, 4893, 56),
(28, 4886, 52),
(29, 4905, 61),
(30, 4906, 60),
(31, 4912, 60),
(32, 4913, 68),
(33, 4914, 52),
(34, 4892, 52);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_blog_member`
--

CREATE TABLE IF NOT EXISTS `weiqi_blog_member` (
  `member_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `member_lv` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `realname` varchar(30) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `qq` varchar(13) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `alipay_account` varchar(50) DEFAULT NULL,
  `alipay_realname` varchar(30) NOT NULL,
  `sex` enum('0','1') NOT NULL DEFAULT '1',
  `wedlock` enum('0','1') NOT NULL DEFAULT '0',
  `lasttime` int(10) NOT NULL DEFAULT '0',
  `reg_ip` varchar(16) DEFAULT NULL,
  `regtime` int(10) unsigned DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `pay_time` mediumint(8) unsigned DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pw_answer` varchar(250) DEFAULT NULL,
  `pw_question` varchar(250) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_id`),
  KEY `uni_user` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=68 ;

--
-- 转存表中的数据 `weiqi_blog_member`
--

INSERT INTO `weiqi_blog_member` (`member_id`, `member_lv`, `username`, `realname`, `contact`, `lastname`, `firstname`, `password`, `qq`, `phone`, `email`, `alipay_account`, `alipay_realname`, `sex`, `wedlock`, `lasttime`, `reg_ip`, `regtime`, `state`, `pay_time`, `money`, `pw_answer`, `pw_question`, `login_count`) VALUES
(48, 0, '13999999999', '13333333333', '张在阳', NULL, NULL, '96e79218965eb72c92a549dd5a330112', '1111', '13333333333', '1111@qq.com', '11111', '11111', '1', '1', 1356585713, '127.0.0.1', 1351578674, 0, NULL, '0.00', NULL, NULL, 40),
(50, 0, '13001101100', '13001101100', 'test', NULL, NULL, '0b713d64cc2ec9e517b12c30eb028266', '13001101100', '13001101100', 'nc@test.com', 'nc@test.com', 'nc', '1', '1', 1352026307, '114.245.2.74', 1352025440, 0, NULL, '0.00', NULL, NULL, 1),
(54, 0, '13888888888', '13888888888', '11', NULL, NULL, 'd0970714757783e6cf17b26fb8e2298f', '11', '13888888888', '11@134.com', '11', '11', '1', '1', 1353739473, '221.220.233.232', 1353739473, 0, NULL, '0.00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_blog_payoff`
--

CREATE TABLE IF NOT EXISTS `weiqi_blog_payoff` (
  `bpayoff_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) DEFAULT NULL,
  `time` int(10) DEFAULT '0',
  `money` float(6,2) DEFAULT '0.00',
  `account_money` float(6,2) DEFAULT '0.00',
  `rebate` float(5,4) DEFAULT '1.0000',
  `state` int(1) DEFAULT '0',
  `money_type` varchar(30) DEFAULT '常规活动',
  `pay_time` int(10) DEFAULT '0',
  `content` varchar(255) DEFAULT '',
  `task_id` int(10) DEFAULT NULL,
  `blog_id` int(10) DEFAULT NULL,
  `pingtai_money` float(6,2) DEFAULT '0.00',
  PRIMARY KEY (`bpayoff_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

--
-- 转存表中的数据 `weiqi_blog_payoff`
--

INSERT INTO `weiqi_blog_payoff` (`bpayoff_id`, `member_id`, `time`, `money`, `account_money`, `rebate`, `state`, `money_type`, `pay_time`, `content`, `task_id`, `blog_id`, `pingtai_money`) VALUES
(1, 4, 1336899453, 22.00, 22.00, 1.0000, 1, '常规活动', 1351406889, '', NULL, NULL, 0.00),
(3, 4, 1337066346, 32.00, 32.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(4, 4, 1340529394, 12.00, 12.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(5, 4, 1340531059, 2.91, 2.91, 1.0000, 1, '常规活动', 1340548228, '', NULL, NULL, 0.00),
(6, 4, 1340545425, 2.91, 2.91, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(7, 4, 1340545448, 15.00, 15.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(8, 4, 1340546864, 15.00, 15.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(9, 48, 1351669695, 1.15, 1.15, 1.0000, 1, '常规活动', 1353381563, '', NULL, NULL, 0.00),
(10, 48, 1351756797, 1.15, 1.15, 1.0000, 1, '常规活动', 1351759593, '', NULL, NULL, 0.00),
(11, 48, 1351758306, 1.15, 1.15, 1.0000, 1, '常规活动', 1351758458, '', NULL, NULL, 0.00),
(12, 48, 1351758754, 1.15, 1.15, 1.0000, 1, '常规活动', 1351759589, '', NULL, NULL, 0.00),
(13, 48, 1351758937, 1.15, 1.15, 1.0000, 1, '常规活动', 1355040873, '', NULL, NULL, 0.00),
(14, 48, 1351759312, 1.15, 1.15, 1.0000, 1, '常规活动', 1351759582, '', NULL, NULL, 0.00),
(15, 48, 1351759436, 1.15, 1.15, 1.0000, 1, '常规活动', 1354516477, '', NULL, NULL, 0.00),
(16, 48, 1351838971, 1.15, 1.15, 1.0000, 1, '常规活动', 1353378188, '', NULL, NULL, 0.00),
(17, 55, 1354371640, 1.15, 1.15, 1.0000, 1, '常规活动', 1354585201, '', NULL, NULL, 0.00),
(18, 55, 1354371645, 1.15, 1.15, 1.0000, 1, '常规活动', 1354599127, '', NULL, NULL, 0.00),
(19, 58, 1354371691, 2.30, 2.30, 1.0000, 1, '常规活动', 1354523594, '', NULL, NULL, 0.00),
(20, 58, 1354371711, 3.45, 3.45, 1.0000, 1, '常规活动', 1354776341, '', NULL, NULL, 0.00),
(21, 58, 1354375079, 2.30, 2.30, 1.0000, 1, '常规活动', 1355040858, '', NULL, NULL, 0.00),
(22, 55, 1354375132, 1.15, 1.15, 1.0000, 1, '常规活动', 1355731356, '', NULL, NULL, 0.00),
(23, 55, 1354375137, 1.15, 1.15, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(24, 58, 1354515597, 2.00, 2.00, 1.0000, 1, '常规活动', 1354517268, '', NULL, NULL, 0.00),
(25, 55, 1354515650, 1.00, 1.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(26, 55, 1354515653, 0.30, 0.30, 1.0000, 1, '常规活动', 1354517259, '', NULL, NULL, 0.00),
(27, 61, 1354589773, 20.00, 20.00, 1.0000, 1, '常规活动', 1354957024, '', NULL, NULL, 0.00),
(28, 63, 1354675230, 15.00, 15.00, 1.0000, 1, '常规活动', 1354684699, '', NULL, NULL, 0.00),
(29, 58, 1354760437, 2.00, 2.00, 1.0000, 1, '常规活动', 1354761355, '', NULL, NULL, 0.00),
(30, 55, 1354760518, 0.30, 0.30, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(31, 55, 1354760521, 1.00, 1.00, 1.0000, 1, '常规活动', 1354761261, '', NULL, NULL, 0.00),
(32, 48, 1354784687, 1.00, 1.00, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(33, 48, 1354785161, 1.15, 1.15, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(34, 48, 1354785934, NULL, NULL, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(35, 48, 1354786609, 1.15, 1.15, 1.0000, 0, '常规活动', 0, '', NULL, NULL, 0.00),
(36, 48, 1354786692, 1.00, 1.00, 1.0000, 1, '常规活动', 1355040847, '', NULL, NULL, 0.00);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_cash`
--

CREATE TABLE IF NOT EXISTS `weiqi_cash` (
  `cash_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `card` varchar(17) NOT NULL DEFAULT '' COMMENT '红包id',
  `money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '红包金额',
  `remark` text COMMENT '说明',
  `state` tinyint(1) DEFAULT '0' COMMENT '0未发放 1已使用 2作废 3已发放',
  PRIMARY KEY (`cash_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=217 ;

--
-- 转存表中的数据 `weiqi_cash`
--

INSERT INTO `weiqi_cash` (`cash_id`, `card`, `money`, `remark`, `state`) VALUES
(70, 'vcrty7bloetw264q', 23, NULL, 1),
(67, 'qxblyj6lnwvhx789', 23, NULL, 1),
(66, '7vvthrtvuh8yeby1', 23, NULL, 0),
(65, 's29zlptl4bgeg51b', 23, NULL, 0),
(64, 'ggh4ac5thcis4og1', 23, NULL, 0),
(63, '72k7lquhymf6dy77', 23, NULL, 0),
(62, '2whahtuni36i7xav', 23, NULL, 0),
(61, '0y9czm895srtnnq0', 23, NULL, 3),
(60, '28vc26xcwp73o2jl', 23, NULL, 0),
(71, 'txohc8g5jux9det4', 11, NULL, 3),
(72, '9xdm8292qwqbq1hp', 11, NULL, 3),
(73, 'pjr3l0atwk8pkrd4', 11, NULL, 1),
(74, '3qwwf2ie0thgvlhe', 11, NULL, 0),
(75, 'gjq2p6zu4nfjnjsi', 11, NULL, 0),
(76, 'sxalhen4633zwkbg', 11, NULL, 0),
(77, '3wkfpqk984hqmo39', 11, NULL, 0),
(78, 'chkne5o88qlvsv2w', 11, NULL, 0),
(79, 'lna6kn017yfbg69e', 11, NULL, 0),
(80, 'seq278kp5rz4kkop', 11, NULL, 0),
(81, 'zrwabxc7168a52bw', 11, NULL, 0),
(82, '9ogxf9w9l6vlo328', 22, NULL, 0),
(83, '53q20qjfq5q58w2l', 22, NULL, 0),
(84, '13pk2beguoc2ar9s', 22, NULL, 0),
(85, 'voeel0gbxtncsrpt', 22, NULL, 0),
(86, 'pvtllrr0zkoxrtco', 22, NULL, 0),
(87, 'hny42m9kzvfv8z7e', 22, NULL, 0),
(88, '80tz0lzyzsw658az', 22, NULL, 0),
(89, 'yze7enx7xb3tjlld', 22, NULL, 0),
(90, 'njpr9s3avfzsd04m', 22, NULL, 0),
(91, 'bppnm1h7r4m3pkvq', 22, NULL, 0),
(92, 'xggwfd2ymfyri6uo', 22, NULL, 0),
(93, 'jswhpswkgb0srx0g', 22, NULL, 0),
(94, '3q2ffbx18st4hqe2', 22, NULL, 0),
(95, 'm9yonx6b0vbuon1j', 22, NULL, 0),
(96, '5dkbcmohrjivcnvv', 22, NULL, 0),
(97, 'm3w9hfdggsg9hrx0', 22, NULL, 0),
(98, '1eyk4c9a4n4z3y60', 22, NULL, 0),
(99, 'gap87beys3h268ov', 22, NULL, 0),
(100, 'us78rerhe5lhpmej', 22, NULL, 0),
(101, '6wekslbuzse8q3b3', 22, NULL, 0),
(102, 'ikb8au41i0xc7ngg', 22, NULL, 3),
(104, 'pl3lxjarcx3l31b1', 100, NULL, 0),
(105, 'rjbkfpx5p8i9obvw', 100, NULL, 0),
(106, 'xpehjmw05rrxtcs8', 100, NULL, 0),
(107, '53bd888bohukk201', 100, NULL, 0),
(108, 'hp38jlw4bgs5wjmb', 100, NULL, 0),
(109, 'xip2fnwd1mkqupj2', 100, NULL, 0),
(110, 'fk5vwf94v179dlta', 100, NULL, 0),
(111, '1tgnzxybrnorh7fy', 100, NULL, 0),
(112, 'raldn50zshz87je4', 100, NULL, 0),
(113, 'kzl3x3d4vj5oikpq', 100, NULL, 3),
(114, 'gwersq4q2t53fcct', 100, NULL, 0),
(115, 'g13e846scbzgxtcd', 100, NULL, 0),
(116, 'jdl097lcq0ot00oe', 100, NULL, 0),
(117, 'pyylw0cc7y74pydw', 100, NULL, 0),
(118, 'zq655jgts3lezlev', 100, NULL, 0),
(119, 'cr7oyswsfgtouyrb', 100, NULL, 0),
(120, 'tz35erp771vwb0h7', 100, NULL, 0),
(121, 'cfumegu31us2dtjk', 100, NULL, 0),
(122, '03f10vbfzvj81cxf', 100, NULL, 0),
(123, 'qyuf7z49044dakoq', 100, NULL, 0),
(124, 'k24s0taj5kkg4iri', 100, NULL, 0),
(125, 'id84eetbd9ujk66q', 100, NULL, 0),
(126, 'ix6fdonjp5zkllyg', 100, NULL, 0),
(127, 'nozpyou839yk7o3n', 100, NULL, 0),
(128, 'unmx4eeemlrjfija', 100, NULL, 0),
(129, '5u35vta175fh82cf', 100, NULL, 0),
(130, 'j9fb8zi5wxxenbi0', 100, NULL, 0),
(131, '1wmg6u3qox99mbz2', 100, NULL, 0),
(132, 'mrmkqgzrk4g480ul', 100, NULL, 0),
(133, 'athnvr9ajkhxef0l', 100, NULL, 0),
(134, '236plsv9m7dp6kj1', 100, NULL, 0),
(135, 'xmqqxjtpr22hkfez', 100, NULL, 0),
(136, 'wc4pu03m15n7j0md', 100, NULL, 0),
(137, 'yadod7q0dg1v3b69', 100, NULL, 0),
(138, '3gglg3pvtzbj8b2l', 100, NULL, 0),
(139, 'budh6q16cqe6z2be', 100, NULL, 0),
(140, 'nf5cg2pzzocrciwo', 100, NULL, 0),
(141, '39r6c4p8pv4c9ouf', 100, NULL, 0),
(142, 'ma7zuw2zj9qvsk4n', 100, NULL, 0),
(143, '8jirwer6gv7dx6qb', 100, NULL, 0),
(144, 'x0nhkmsugqjumiph', 100, NULL, 0),
(145, 'qqm7uk6zjroayk03', 100, NULL, 0),
(146, 'mmgvp8wlq1opubn6', 100, NULL, 0),
(147, 'mr4i5lzn1jj2ctnq', 100, NULL, 0),
(148, 'p4n47oe7e98ff0zr', 100, NULL, 0),
(149, 'vo0pui57v6rq4xn9', 100, NULL, 0),
(150, '5h79219ogb40eko8', 100, NULL, 0),
(151, 'ih9swapn4pca9x2n', 100, NULL, 0),
(152, 'zp59b9h2vafiq0rk', 100, NULL, 0),
(153, 'j5wqbxmxp3bosstx', 100, NULL, 0),
(154, '6th5xc3an32ugb8r', 100, NULL, 0),
(155, 'xpwj4hx4pcozpjy3', 100, NULL, 0),
(156, 'rs5wxb3ett42ji2v', 100, NULL, 0),
(157, 'o498bvl61he5z6h3', 100, NULL, 0),
(158, 'pn8ja5geddi60k9t', 100, NULL, 0),
(159, 'tf0tv5n3sih6mod0', 100, NULL, 0),
(160, '0eo11v79aub5uiun', 100, NULL, 0),
(161, 'bl59sb2wvey3n1nr', 100, NULL, 0),
(162, 'p0hf5gb0k6g02bsd', 100, NULL, 0),
(163, '7mnk4cvld5tv2aaf', 100, NULL, 0),
(164, 'shoonxsm8d0qn04y', 100, NULL, 0),
(165, 'gkjrs8157s1jufby', 100, NULL, 0),
(166, '8u8tian4agwbmkue', 100, NULL, 0),
(167, '3csuu1lkgbm2zfpc', 100, NULL, 0),
(168, '226trhwhpe6sy0xq', 100, NULL, 0),
(169, '40fsaojv1plhiahm', 100, NULL, 0),
(170, '96hpeliqh8u5obdy', 100, NULL, 0),
(171, 'ikfl37t11yyse1mr', 100, NULL, 0),
(172, 'u66gdkhunxvdrh71', 100, NULL, 0),
(173, '9zsa9mi3d3oyoo4s', 100, NULL, 0),
(174, 's193reuu7iah7ke0', 100, NULL, 0),
(175, 'eajvtwj144rzc61o', 100, NULL, 0),
(176, '3roli4lp4y2g2hzu', 100, NULL, 0),
(177, 'wgobr1zu708wdjag', 100, NULL, 0),
(178, 'tdizmppfea8b9byj', 100, NULL, 0),
(179, 'si6m23sipr3orsx3', 100, NULL, 0),
(180, 'vup846622hr1vza4', 100, NULL, 0),
(181, '2f2trzy2jebcjwym', 100, NULL, 0),
(182, 'b79dzi2j4komtkzl', 100, NULL, 0),
(183, 'o7bwtrihsxwvpwc0', 100, NULL, 0),
(184, '5g7d8qaxjiy35z2x', 100, NULL, 0),
(185, 'pwxu8ffsebva8s4a', 100, NULL, 0),
(186, 'cji9utw5bcmgvai4', 100, NULL, 0),
(187, '3fxn1yqzdl7l4j9f', 100, NULL, 0),
(188, 'xj70usw9h1noyhc7', 100, NULL, 0),
(189, 'uubc8de1qqxre5sg', 100, NULL, 0),
(190, 've9n7n991m2sfjk6', 100, NULL, 0),
(191, 'z52xsngygq1s1nod', 100, NULL, 0),
(192, '64p5ycz4y2ur9h50', 100, NULL, 0),
(193, 'hb7dqsvrkmip21y4', 100, NULL, 0),
(194, 'wqjj3y3v8e0mha3q', 100, NULL, 3),
(195, 'ddpo1tog1echhals', 100, NULL, 3),
(196, 'y7qskflhxljc2zfb', 100, NULL, 3),
(197, 'nakvpqu0w1k59elb', 100, NULL, 0),
(198, 'ekaxgrgzyogx1j4r', 100, NULL, 0),
(199, 'a3uyrief4j6oee0p', 100, NULL, 0),
(200, '8t8xozocdmqedz73', 100, NULL, 0),
(201, 'argw76bqqx53xarz', 100, NULL, 0),
(202, 'fxjtb2al6ger3aob', 100, NULL, 0),
(203, 'oagp0pmwp7heu1w4', 100, NULL, 0),
(204, '0w8kb1apc5fz6hie', 100, NULL, 0),
(205, 'fque73ay2c7k4nf5', 100, NULL, 0),
(206, 'yra7ovnpvqu3njpc', 100, NULL, 0),
(207, 'k0lyrdcwscblr5b1', 100, NULL, 0),
(208, 'ahqpfleks6m2hha7', 100, NULL, 0),
(209, '26qeojrpw8sisilt', 100, NULL, 0),
(210, 'z3j3j7ia3isxpa8w', 100, NULL, 0),
(211, 'y88qzkkdd0ma6r8g', 100, NULL, 0),
(212, '1lqc1nzxrpbnazkh', 100, NULL, 0),
(213, '853xohrx8nuyyw9z', 100, NULL, 0),
(214, 'hybhw0uess888jay', 101, NULL, 0),
(215, 'v6rcf56y1fkdgdfn', 100, NULL, 0),
(216, 'wsqe21yq6y18zwgz', 100, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_class`
--

CREATE TABLE IF NOT EXISTS `weiqi_class` (
  `class_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '分类名称',
  `label` varchar(255) NOT NULL DEFAULT '' COMMENT '分类标签',
  PRIMARY KEY (`class_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_click_log`
--

CREATE TABLE IF NOT EXISTS `weiqi_click_log` (
  `blog_id` bigint(20) NOT NULL COMMENT '博客id',
  `task_id` bigint(20) NOT NULL COMMENT '活动id',
  `ip` varchar(20) NOT NULL COMMENT 'ip地址',
  `logtime` int(10) unsigned DEFAULT NULL COMMENT 'time',
  PRIMARY KEY (`blog_id`,`task_id`,`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `weiqi_click_log`
--

INSERT INTO `weiqi_click_log` (`blog_id`, `task_id`, `ip`, `logtime`) VALUES
(50, 1, '127.0.0.1', 1346563363);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_company_dinner`
--

CREATE TABLE IF NOT EXISTS `weiqi_company_dinner` (
  `cdinner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `dinner_id` int(10) DEFAULT NULL,
  `member_id` int(10) DEFAULT NULL,
  `name` varchar(100) DEFAULT '',
  `begintime` int(10) DEFAULT '0',
  `addtime` int(10) DEFAULT '0',
  `content` text,
  `pay_state` enum('Y','N') DEFAULT 'N',
  `state` int(1) DEFAULT '0' COMMENT '0 等待付款 1等待操作 2已开始 3 已完成',
  `operator` varchar(30) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `s_time` int(10) DEFAULT '0',
  PRIMARY KEY (`cdinner_id`),
  KEY `NewIndex1` (`dinner_id`),
  KEY `NewIndex2` (`member_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- 转存表中的数据 `weiqi_company_dinner`
--

INSERT INTO `weiqi_company_dinner` (`cdinner_id`, `dinner_id`, `member_id`, `name`, `begintime`, `addtime`, `content`, `pay_state`, `state`, `operator`, `url`, `s_time`) VALUES
(2, 1, 4, '感觉不错哟', 1336233600, 1336233600, '你是真的想我了吗？dd', 'Y', 0, 'admin', NULL, 0),
(3, 2, 4, '这是测试套餐', 1336233600, 1336233600, '<p>嘻嘻嘻嘻，这是测试套餐fdsfsdsdadsadfdsfsdffffff</p>', 'Y', 0, NULL, NULL, 0),
(5, 2, 4, '感觉不错哟', 1336579200, 0, '放大放大是放大放大是发达fdsa', 'Y', 1, NULL, NULL, 0),
(6, 2, 4, '感觉不错哟', 1337011200, 1340597987, '凡达范德萨', 'N', 3, 'admin', 'fdskafd', 1340597987),
(8, 2, 4, '哈哈哈', 1348243200, 0, '多萨达放大', 'Y', 1, NULL, NULL, 0),
(9, 2, 52, '方法发', 1351699200, 0, '打打', 'N', 0, NULL, NULL, 0),
(10, 5, 60, '打折促销', 1354377600, 0, '快！快！快！！[崩溃]找到一家包包低折促销的店，韩版包包限时折扣包邮！超多款式，各种style！！[爱爱爱]我看上的个糖果色包包原价140块钱，现在才99！姐妹们，时间有限，千万不要错过！[心]地址：', 'Y', 1, NULL, NULL, 0);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_company_member`
--

CREATE TABLE IF NOT EXISTS `weiqi_company_member` (
  `member_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `member_lv` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `realname` varchar(200) DEFAULT NULL,
  `homepage` varchar(200) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `password` varchar(32) DEFAULT NULL,
  `qq` varchar(13) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `sex` enum('0','1') NOT NULL DEFAULT '1',
  `wedlock` enum('0','1','2') NOT NULL DEFAULT '0',
  `lasttime` int(10) NOT NULL DEFAULT '0',
  `lastip` varchar(16) DEFAULT NULL,
  `reg_ip` varchar(16) DEFAULT NULL,
  `regtime` int(10) unsigned DEFAULT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '0',
  `pay_time` mediumint(8) unsigned DEFAULT NULL,
  `money` decimal(10,2) NOT NULL DEFAULT '0.00',
  `pw_answer` varchar(250) DEFAULT NULL,
  `pw_question` varchar(250) DEFAULT NULL,
  `login_count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_id`),
  KEY `uni_user` (`username`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

--
-- 转存表中的数据 `weiqi_company_member`
--

INSERT INTO `weiqi_company_member` (`member_id`, `member_lv`, `username`, `realname`, `homepage`, `address`, `contact`, `password`, `qq`, `phone`, `email`, `sex`, `wedlock`, `lasttime`, `lastip`, `reg_ip`, `regtime`, `state`, `pay_time`, `money`, `pw_answer`, `pw_question`, `login_count`) VALUES
(1, 1, 'demo', '', '', '', '', 'fe01ce2a7fbac8fafaed7c982a04e229', '', '', '', '1', '2', 0, NULL, '127.0.0.1', 1236835996, 0, NULL, '0.00', '', '', 0),
(59, 0, 'fnmqj', '梦游', 'http://www.cceefl.com', '', '梦游', '051b7cff8de1a92421e02a35d8b8ef1a', '114687222867', '15059855113', '11468722867@qq.com', '1', '1', 1353938575, '117.26.46.224', '117.26.46.224', 1353937816, 0, NULL, '0.00', NULL, NULL, 2),
(5, 1, 'iloveufly2', NULL, NULL, NULL, NULL, '14ed1a22176d3805f01deeab4c7aae03', NULL, NULL, NULL, '1', '0', 0, NULL, '192.168.1.5', 1315449120, 0, NULL, '0.00', NULL, NULL, 1),
(6, 1, 'asdjsaid', NULL, NULL, NULL, NULL, '6372874f438928fb864251c53459793f', NULL, NULL, NULL, '1', '0', 0, NULL, '192.168.1.10', 1315458303, 0, NULL, '0.00', NULL, NULL, 1),
(7, 1, 'ilove', NULL, NULL, NULL, NULL, '14ed1a22176d3805f01deeab4c7aae03', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1317913670, 0, NULL, '0.00', NULL, NULL, 1),
(8, 1, 'admin', NULL, NULL, NULL, NULL, '14ed1a22176d3805f01deeab4c7aae03', NULL, NULL, NULL, '1', '0', 1340198823, '192.168.1.35', '192.168.1.35', 1324275546, 0, NULL, '0.00', NULL, NULL, 3),
(9, 1, '浪迹天涯lius', NULL, NULL, NULL, NULL, '0ad00ce72424feeea4e2800d74e3839f', NULL, NULL, NULL, '1', '0', 0, NULL, '192.168.1.2', 1324275657, 0, NULL, '0.00', NULL, NULL, 1),
(10, 1, 'goodh', NULL, NULL, NULL, '', '14ed1a22176d3805f01deeab4c7aae03', '', '', NULL, '1', '0', 0, NULL, '127.0.0.1', 1324443435, 0, NULL, '0.00', '', '', 1),
(11, 1, '111111', NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1324451158, 0, NULL, '0.00', NULL, NULL, 1),
(12, 1, 'fdafda', NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1324451434, 0, NULL, '0.00', NULL, NULL, 1),
(13, 1, 'fdsafdas', NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1324451530, 0, NULL, '0.00', NULL, NULL, 1),
(14, 1, 'fdafds', NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1324451593, 0, NULL, '0.00', NULL, NULL, 1),
(15, 1, 'fdafdss', NULL, NULL, NULL, NULL, '21232f297a57a5a743894a0e4a801fc3', NULL, NULL, NULL, '1', '0', 0, NULL, '127.0.0.1', 1324451741, 0, NULL, '0.00', NULL, NULL, 1),
(16, 0, '', NULL, NULL, NULL, 'zhangzhifei', '14ed1a22176d3805f01deeab4c7aae03', '667676', '13345672345', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(17, 0, '13277886655', NULL, NULL, NULL, 'fjdksjk', '14ed1a22176d3805f01deeab4c7aae03', '23232', '13277886655', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(18, 0, '13277886655', NULL, NULL, NULL, 'fjdksjk', '14ed1a22176d3805f01deeab4c7aae03', '23232', '13277886655', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(19, 0, '13277886622', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886622', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(20, 0, '13277886644', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886644', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(21, 0, '13277886641', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886641', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(22, 0, '13277886641', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886641', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(23, 0, '13277886648', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886648', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(24, 0, '13277886648', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886648', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(25, 0, '13277886649', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886649', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(26, 0, '13277886649', NULL, NULL, NULL, 'fjdksjk', '21232f297a57a5a743894a0e4a801fc3', '23232', '13277886649', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(27, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(28, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(29, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(30, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(31, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(32, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(33, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(34, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(35, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(36, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(37, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(38, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(39, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(40, 0, '13328763322', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763322', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(41, 0, '13328763333', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763333', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(42, 0, '13328763323', NULL, NULL, NULL, '232', '21232f297a57a5a743894a0e4a801fc3', '323232', '13328763323', NULL, '1', '1', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(43, 0, 'iloveuf', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(44, 0, 'iloveuf2', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', 0, NULL, NULL, NULL, 0, NULL, '0.00', NULL, NULL, 0),
(45, 0, 'iloveuf22', '公司', 'http://www.b', '地址', '张飞飞', 'admin', '2323232', '14870602233', 'iloveufly@qq.com', '1', '0', 1336399432, NULL, '192.168.1.35', 1336399432, 0, NULL, '0.00', NULL, NULL, 0),
(46, 0, 'iloveu', '公司', 'http://www.b', '地址', '张飞飞', '21232f297a57a5a743894a0e4a801fc3', '2323232', '14870602233', 'iloveufly@qq.com', '1', '0', 1336400663, NULL, '192.168.1.35', 1336399619, 0, NULL, '0.00', NULL, NULL, 3),
(47, 0, 'sun001', '顶顶顶顶', 'http://www.baidu.com', '咚咚咚', '咚咚咚', 'e10adc3949ba59abbe56e057f20f883e', '23455', '13765652652', 'ddffdfz@ff.com', '1', '1', 1336978260, NULL, '112.229.235.172', 1336978260, 0, NULL, '0.00', NULL, NULL, 1),
(48, 0, 'admin1', 'admin', 'http://www.baidu.com', '', 'admin', 'e00cf25ad42683b3df678c61f42c6bda', '123456', '13800138000', 'admin@qq.com', '1', '1', 1353405461, '111.199.169.45', '218.65.101.113', 1336979569, 0, NULL, '123.00', NULL, NULL, 3),
(58, 0, 'xiaoxiao', '4445435', 'http://www.baidu.com', '54354', '2131', 'e10adc3949ba59abbe56e057f20f883e', '123123', '13826512341', '123123456@qq.com', '1', '1', 1353637356, NULL, '121.15.77.203', 1353637356, 0, NULL, '1000.00', NULL, NULL, 1),
(50, 0, 'uiui', 'fkdjk', 'http://sss.dfds', 'fjdkj', 'fjkd', '14ed1a22176d3805f01deeab4c7aae03', '556783', '15870602233', 'iloveufly@qq.com', '1', '1', 1340250239, NULL, '192.168.1.35', 1340250239, 0, NULL, '0.00', NULL, NULL, 1),
(51, 0, 'lizhen', 'jfdiosafjo', 'http://www.baidu.com', 'as', 'fdsaf', '96e79218965eb72c92a549dd5a330112', '1231231', '13556008441', 'fsadfsad1@Fsadf.com', '1', '1', 1346573026, '127.0.0.1', '127.0.0.1', 1346439163, 0, NULL, '99928966.74', NULL, NULL, 13),
(52, 0, 'zhangzaiyang', 'lkjl', 'http://www.baidu.com', 'sfsdfsd', 'dsfdsf', '96e79218965eb72c92a549dd5a330112', '25545', '13222222222', 'sfsdf@qq.com', '1', '1', 1356579469, '114.249.139.191', '127.0.0.1', 1350971536, 0, NULL, '89.61', NULL, NULL, 62),
(53, 0, '222222', '22222', 'http://www.dfd', '111', '111', 'e3ceb5881a0a1fdaad01296d7554868d', '123213123', '13222222222', '123123@qq.com', '1', '2', 1351577031, '127.0.0.1', '127.0.0.1', 1351576897, 0, NULL, '0.00', NULL, NULL, 3),
(54, 0, 'taskwei', '测试公司名称', 'http://www.taskwei.com', '', 'ceshi', 'e10adc3949ba59abbe56e057f20f883e', '123456', '15801575002', '15801575002@qq.com', '1', '1', 1351851625, '223.20.49.10', '223.20.49.10', 1351849641, 0, NULL, '67.75', NULL, NULL, 3),
(55, 0, 'test', 'test', 'http://www.test.com', '1234', '刘先生', 'e10adc3949ba59abbe56e057f20f883e', '13001101100', '13001101100', 'nc@test.com', '1', '1', 1353637819, '121.15.77.203', '114.245.2.74', 1352025126, 0, NULL, '11082040.00', NULL, NULL, 4),
(61, 0, 'shaodong', 'shaodong', 'http://www.chuangzhen.org', '成都', '少东', '55a6ed6c318482c455e259be3fdda30c', '4295111152371', '13980573621', '429511115237111@qq.com', '1', '1', 1354105284, '125.70.58.73', '125.70.58.73', 1354089665, 0, NULL, '99998849.99', NULL, NULL, 5),
(62, 0, 'wendawen', 'goweng', 'http://www.goweng.com', 'chengdushi', 'wendawen', 'e10adc3949ba59abbe56e057f20f883e', '7552227197', '13980110429', 'wendawen520@163.com', '1', '1', 1354280201, '171.217.54.190', '171.217.54.190', 1354280105, 0, NULL, '0.00', NULL, NULL, 2),
(63, 0, '123456', '123456', 'http://www.123.com', '', '123', 'e10adc3949ba59abbe56e057f20f883e', '36588922', '13912225897', '36588922@qq.com', '1', '1', 1354338119, '119.97.251.90', '119.97.251.90', 1354338067, 0, NULL, '500.00', NULL, NULL, 2),
(64, 0, 'kong', 'fengqi', 'http://mmayi.com', '', 'fengqi', 'cb3a1f7e970abd661e560f13793f9987', '25034705', '18717879960', '25034705@qq.com', '1', '0', 1354438745, NULL, '124.160.188.78', 1354438745, 0, NULL, '0.00', NULL, NULL, 1),
(65, 0, '科技广告', '杭州微博科技广告有限公司', 'http://www.chuangzhen.org/', '山东济南', '莫先生', 'd8578edf8458ce06fbc5bb76a58c5ca4', '2367228767', '13296565678', 'mo@163.com', '1', '1', 1354772936, '125.121.207.66', '125.121.17.144', 1354510428, 0, NULL, '898.32', NULL, NULL, 7),
(66, 0, 'whwanke', '武汉万科', 'http://www.whwanke.com', '', 'wed', 'e10adc3949ba59abbe56e057f20f883e', '2554222245', '15698754891', '2554222245@qq.com', '1', '1', 1355459543, '119.97.251.90', '119.97.251.90', 1354522682, 0, NULL, '0.00', NULL, NULL, 5),
(67, 0, 'a123456', '123456', 'http://www.baidu.com', '123456', '123456', 'e10adc3949ba59abbe56e057f20f883e', '4123456', '18982405546', '4123456@qq.com', '1', '0', 1354523459, NULL, '125.65.151.162', 1354523459, 0, NULL, '0.00', NULL, NULL, 1),
(68, 0, '我吃鸡蛋白', '苍穹网络', 'http://xs163.net', '浙江杭州', '我吃鸡蛋白', '908f4c520704d4f1efad7177f1343744', '408664626', '13588482450', '408664626@qq.com', '1', '1', 1354601668, '125.121.201.82', '125.121.201.82', 1354584919, 0, NULL, '436.75', NULL, NULL, 3),
(69, 0, '发生的发生地方', '热人声鼎沸', 'http://demo.weiboff.com/index.php?m=company&a=register', '', '随碟附送的', '4297f44b13955235245b2497399d7a93', '231231313', '15010999999', 'werw@rwer.v', '1', '1', 1354599867, '1.180.59.228', '1.180.59.228', 1354599659, 0, NULL, '100.00', NULL, NULL, 2),
(70, 0, '东方医学', '东方医学', 'http://www.cheeryoung.cn', '', '王先生', 'e10adc3949ba59abbe56e057f20f883e', '1566222441', '18272720999', 'elvenking@126.com', '1', '1', 1354846318, '125.121.21.77', '125.121.209.127', 1354669435, 0, NULL, '985.00', NULL, NULL, 7),
(71, 0, '东方医学1', '东方医学', 'http://www.cheeryoung.cn', '', '赵先生', 'e10adc3949ba59abbe56e057f20f883e', '1566222441', '18072729999', 'elvenking@126.com', '1', '2', 1354670860, NULL, '125.121.209.127', 1354670860, 0, NULL, '0.00', NULL, NULL, 1),
(72, 0, '277880170', '55555', 'http://www.baidu.com', '广州市白云区', 'HAO', '1104959d53dc3b60f2d40cd4a47d79e7', '277880170', '13717728122', '277880170@qq.com', '1', '0', 1355034817, NULL, '14.23.248.9', 1355034817, 0, NULL, '0.00', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_config`
--

CREATE TABLE IF NOT EXISTS `weiqi_config` (
  `config_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '唯一id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '配置名称',
  `value` text COMMENT '配置值',
  `image` varchar(50) NOT NULL DEFAULT '' COMMENT '配置照片',
  `other` varchar(10) NOT NULL DEFAULT '' COMMENT '配置其他信息',
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=465 ;

--
-- 转存表中的数据 `weiqi_config`
--

INSERT INTO `weiqi_config` (`config_id`, `name`, `value`, `image`, `other`) VALUES
(1, 'authority', 'a:34:{s:10:"admin_role";s:15:"管理员角色";s:8:"role_add";s:12:"增加角色";s:10:"admin_list";s:15:"管理员列表";s:7:"address";s:12:"地址管理";s:11:"shop_config";s:12:"店铺配置";s:6:"shoplv";s:12:"店铺等级";s:6:"userlv";s:12:"用户等级";s:12:"flash_manage";s:12:"轮播管理";s:7:"sms_set";s:12:"短信配置";s:9:"water_set";s:12:"水印配置";s:10:"spread_set";s:12:"积分配置";s:9:"theme_set";s:12:"模版配置";s:7:"article";s:12:"文章管理";s:10:"clearCache";s:12:"缓存管理";s:7:"dbi_set";s:10:"D币设置";s:11:"group_email";s:12:"群发邮件";s:5:"order";s:12:"订单管理";s:14:"order_takeaway";s:12:"送餐订单";s:4:"food";s:12:"菜品管理";s:10:"other_list";s:12:"服务管理";s:7:"comment";s:12:"评论管理";s:4:"user";s:12:"用户管理";s:4:"shop";s:12:"餐厅管理";s:7:"express";s:12:"快递管理";s:7:"service";s:12:"家政管理";s:10:"group_food";s:12:"团购审核";s:10:"shop_state";s:12:"餐厅审核";s:11:"food_status";s:12:"菜品审核";s:8:"shop_top";s:12:"推荐管理";s:19:"express_list_status";s:12:"快商审核";s:19:"service_list_status";s:12:"家商审核";s:11:"order_group";s:12:"团购订单";s:10:"db_userlog";s:12:"充值日志";s:9:"db_addlog";s:12:"消费日志";}', '', ''),
(428, 'email', 'a:6:{s:3:"ssl";s:1:"0";s:4:"host";s:11:"smtp.qq.com";s:4:"port";s:2:"25";s:8:"username";s:3:"123";s:8:"password";s:6:"GOOD12";s:8:"addreply";s:10:"123@qq.com";}', '', ''),
(429, 'sms', 'a:2:{s:3:"uid";s:1:"1";s:3:"pwd";s:1:"1";}', '', ''),
(432, 'shop_config', 'a:8:{s:9:"shop_name";s:9:"微推广";s:10:"shop_title";s:9:"微推广";s:12:"shop_account";s:9:"微推广";s:13:"shop_keywords";s:9:"微推广";s:8:"shop_dir";s:1:"/";s:8:"shop_icp";s:25:"京ICP备110110110号-1  ";s:6:"give_m";s:2:"15";s:5:"hgive";s:2:"15";}', '', ''),
(457, 'dbi', 'a:2:{i:0;a:3:{s:9:"pay_money";s:1:"1";s:5:"get_d";s:2:"10";s:6:"remark";s:11:"1元=10D币";}i:1;a:3:{s:9:"pay_money";s:2:"10";s:5:"get_d";s:2:"13";s:6:"remark";s:12:"10元=13D币";}}', '', ''),
(463, 'pay', 'a:3:{s:11:"pay_partner";s:10:"1211111111";s:7:"pay_key";s:10:"1111111111";s:8:"pay_user";s:6:"111111";}', '', ''),
(464, 'label', 'a:1:{s:5:"label";s:59:"admin,bbs,sss,sss,飞飞,不飞,想飞,随便,看看,是吗";}', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_cron`
--

CREATE TABLE IF NOT EXISTS `weiqi_cron` (
  `cronid` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `available` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 等待 1上锁 2 完成 3无任务',
  `type` enum('user','system') NOT NULL DEFAULT 'user',
  `name` char(50) NOT NULL DEFAULT '',
  `action` char(50) NOT NULL DEFAULT '',
  `lastrun` int(10) unsigned NOT NULL DEFAULT '0',
  `nextrun` int(10) unsigned NOT NULL DEFAULT '0',
  `weekday` tinyint(1) NOT NULL DEFAULT '0',
  `day` tinyint(2) NOT NULL DEFAULT '0',
  `hour` tinyint(2) NOT NULL DEFAULT '0',
  `minute` char(36) NOT NULL DEFAULT '',
  `other` tinyint(1) DEFAULT '0' COMMENT '0 关闭 1有任务就执行',
  `pkey` int(10) DEFAULT '0' COMMENT '一般用来存储主键',
  `data` varchar(10) DEFAULT '0' COMMENT '存储数据',
  PRIMARY KEY (`cronid`),
  KEY `nextrun` (`available`,`nextrun`)
) ENGINE=MyISAM  DEFAULT CHARSET=gbk AUTO_INCREMENT=22 ;

--
-- 转存表中的数据 `weiqi_cron`
--

INSERT INTO `weiqi_cron` (`cronid`, `available`, `type`, `name`, `action`, `lastrun`, `nextrun`, `weekday`, `day`, `hour`, `minute`, `other`, `pkey`, `data`) VALUES
(1, 1, 'system', '流单操作', 'finish_active', 0, 0, 0, 0, 0, '0', 1, 6, '3'),
(14, 1, 'system', '活动前10分钟发送短信', 'sms_active', 0, 1340538600, 0, 0, 0, '', 1, 30, '0'),
(15, 1, 'system', '活动开始操作', 'start_active', 0, 1340539200, 0, 0, 0, '', 1, 30, '2');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_dinner`
--

CREATE TABLE IF NOT EXISTS `weiqi_dinner` (
  `dinner_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `money` float(10,2) DEFAULT '0.00',
  `content` varchar(255) DEFAULT NULL,
  `platform` enum('sina','qq') DEFAULT NULL,
  PRIMARY KEY (`dinner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `weiqi_dinner`
--

INSERT INTO `weiqi_dinner` (`dinner_id`, `name`, `money`, `content`, `platform`) VALUES
(1, '[新浪微博] 3000元微博推广套餐', 3000.00, '这是一个广告套', 'sina'),
(2, '[腾讯微博] 5000元微博推广套餐', 5000.00, '这是一个视频推广套餐', 'qq'),
(3, '这是测试套餐2000元', 2000.00, '这是测试套餐，这是介绍，你可以随', 'qq'),
(5, '1000元套餐', 1000.00, '实际价格为1500元的优惠套餐。', 'sina');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_pay_ment`
--

CREATE TABLE IF NOT EXISTS `weiqi_pay_ment` (
  `pay_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL DEFAULT '0',
  `time` int(10) NOT NULL DEFAULT '0',
  `code` varchar(20) NOT NULL DEFAULT '0',
  `type` varchar(100) NOT NULL DEFAULT '账户余额充值',
  `money` float(7,2) NOT NULL DEFAULT '0.00',
  `state` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`pay_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=26 ;

--
-- 转存表中的数据 `weiqi_pay_ment`
--

INSERT INTO `weiqi_pay_ment` (`pay_id`, `member_id`, `time`, `code`, `type`, `money`, `state`) VALUES
(1, 4, 0, '1222322', '账户余额充值', 300.00, 0),
(2, 4, 1341118134, '0', '-余额充值', 0.00, 0),
(3, 4, 1341118218, '0', '生活小秘书-余额充值', 0.00, 0),
(4, 51, 1346440177, '0', '生活小秘书-余额充值', 0.00, 0),
(5, 4, 1350960249, '0', '生活小秘书-余额充值', 0.00, 0),
(6, 55, 1352025230, '0', '微推广-余额充值', 0.00, 0),
(7, 56, 1352083352, '0', '微推广-余额充值', 0.00, 0),
(8, 56, 1352083379, '0', '微推广-余额充值', 0.00, 0),
(9, 57, 1353219363, '0', '微推广-余额充值', 0.00, 0),
(10, 52, 1353650631, '0', '微推广-余额充值', 0.00, 0),
(11, 59, 1353938598, '0', '微推广-余额充值', 0.00, 0),
(12, 60, 1354082494, '0', '微推广-余额充值', 0.00, 0),
(13, 60, 1354175606, '0', '微推广-余额充值', 0.00, 0),
(14, 60, 1354175631, '0', '微推广-余额充值', 0.00, 0),
(15, 60, 1354175899, '0', '微推广-余额充值', 0.00, 0),
(16, 63, 1354338134, '0', '微推广-余额充值', 0.00, 0),
(17, 68, 1354585115, '0', '微推广-余额充值', 0.00, 0),
(18, 68, 1354586725, '0', '微推广-余额充值', 0.00, 0),
(19, 52, 1354762755, '0', '微推广-余额充值', 0.00, 0),
(20, 52, 1355288132, '0', '微推广-余额充值', 0.00, 0),
(21, 52, 1355288142, '0', '微推广-余额充值', 0.00, 0),
(22, 52, 1356327946, '0', '微推广-余额充值', 0.00, 0),
(23, 52, 1356335996, '0', '微推广-余额充值', 0.00, 0),
(24, 52, 1356336043, '0', '微推广-余额充值', 0.00, 0),
(25, 52, 1356537531, '0', '微推广-余额充值', 0.00, 0);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_task`
--

CREATE TABLE IF NOT EXISTS `weiqi_task` (
  `task_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) DEFAULT NULL,
  `type` enum('forward','publish','click') DEFAULT NULL,
  `platform` enum('sina','qq') DEFAULT NULL,
  `soft` enum('Y','N') DEFAULT 'N',
  `name` varchar(100) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL,
  `image` varchar(100) DEFAULT '',
  `begintime` int(10) unsigned DEFAULT NULL COMMENT '开始时间',
  `content` varchar(255) DEFAULT NULL,
  `remark` text,
  `money` float(10,2) DEFAULT '0.00',
  `consume` float(10,2) DEFAULT '0.00' COMMENT '实际消费金额',
  `fans_num` int(11) DEFAULT '0' COMMENT '完成粉丝数',
  `yp_num` mediumint(9) DEFAULT '0' COMMENT '已派单数',
  `url_num` mediumint(9) DEFAULT '0' COMMENT '已收链接数',
  `ld_num` mediumint(9) DEFAULT '0' COMMENT '流单数',
  `rj_num` mediumint(9) DEFAULT '0' COMMENT '拒单数',
  `qx_num` mediumint(9) DEFAULT '0' COMMENT '取消数',
  `sms` tinyint(1) DEFAULT '0' COMMENT '提示短信 0等待发生 1 已发送',
  `state` tinyint(1) DEFAULT '0' COMMENT '0未派单 1已派单 2正在进行 3派单完成 4 已退单',
  `pay_state` enum('Y','N') DEFAULT 'N',
  `endtime` int(10) unsigned DEFAULT NULL COMMENT '结束时间',
  PRIMARY KEY (`task_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=113 ;

--
-- 转存表中的数据 `weiqi_task`
--

INSERT INTO `weiqi_task` (`task_id`, `member_id`, `type`, `platform`, `soft`, `name`, `url`, `image`, `begintime`, `content`, `remark`, `money`, `consume`, `fans_num`, `yp_num`, `url_num`, `ld_num`, `rj_num`, `qx_num`, `sms`, `state`, `pay_state`, `endtime`) VALUES
(35, 4, 'forward', 'sina', 'Y', 'f测试', 'http://fdsf.dsfs', '', 1340557200, 'fdafas', 'fsfdsfds', 649.15, 0.00, 0, 0, 0, 0, 1, 3, 0, 4, 'Y', NULL),
(36, 4, 'publish', 'sina', 'Y', 'jkfdsjk', NULL, '', 1340589600, 'fdsafas', 'fdsfsafdsa', 369.15, 0.00, 0, 0, 0, 0, 0, 1, 0, 4, 'Y', NULL),
(37, 4, 'publish', 'sina', 'Y', '不错', NULL, 'uploads/images/4fe7c09d2cdb8.jpg', 1340590200, '放大放大发送', '发达', NULL, 0.00, 0, 0, 0, 0, 0, 1, 0, 4, 'Y', NULL),
(38, 4, 'forward', 'sina', 'Y', 'hfdsa', 'http://fdsf.fds', '', 1340593200, 'fdsafa', 'fdsfsdafad', 649.15, 0.00, 0, 3, 0, 0, 0, 0, 0, 1, 'Y', NULL),
(39, 4, 'forward', 'sina', 'Y', 'fafda', 'http://fdsfsd.ssfd', '', 1340593200, 'fdsafsa', 'fsafsdaf', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', NULL),
(43, 4, 'forward', 'sina', 'Y', '感觉不错', 'http://fdsfs.fds', '', 1340787600, 'fdafas', 'fdsafasd', 15.00, 0.00, 0, 0, 0, 0, 0, 1, 0, 4, 'Y', NULL),
(42, 4, 'forward', 'sina', 'Y', 'fdsafs', 'http://fds.fds', '', 1340629200, '范德萨发送', '范德萨发送大', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', NULL),
(41, 4, 'forward', 'sina', 'Y', 'fdafa', 'http://fdsfs.fds', '', 1340701200, 'fdaffdsfds', 'dsfsdf', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', NULL),
(40, 4, 'forward', 'sina', 'Y', 'fsafsa', 'http://fsdfsd.fdsf', '', 1340611200, 'fdsafdsa', 'fsdfsd', 649.15, 0.00, 0, 0, 0, 0, 0, 3, 0, 4, 'Y', NULL),
(34, 4, 'publish', 'sina', 'Y', '小测试一下', 'http://fsdf.sfds', '', 1340548800, 'sdfafsa', 'fdsfsdf', 649.15, 15.00, 10764340, 3, 1, 2, 1, 0, 0, 3, 'Y', NULL),
(33, 4, 'forward', 'sina', 'Y', 'fdafa', 'http://fsfds.fdsf', '', 1340544600, 'fdsafsa', 'fdsafsdaf', 17.91, 17.91, 11976462, 4, 2, 2, 1, 0, 0, 3, 'Y', NULL),
(44, 51, 'forward', 'sina', 'Y', '3213', 'http://www.badiu.com', '', 1346526000, '32132', '', 14174.95, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', NULL),
(45, 51, 'click', 'sina', 'Y', '3213123', 'http://aa.cc', '', 1346526000, '213213', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', NULL),
(46, 51, 'click', 'sina', 'Y', '123123', 'http://aa.cc', '', 1346526000, '213213', '', 14159.95, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', NULL),
(47, 51, 'publish', 'sina', 'Y', 'fsdadfdsaf', NULL, 'uploads/images/50411b9f4bffc.jpg', 1346529600, 'fasdfsf', '', 141.45, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', NULL),
(48, 51, 'click', 'sina', 'Y', '21312', 'http://aa.cc', 'uploads/images/50411c1f5d331.jpg', 1346529600, '213123', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', NULL),
(49, 51, 'click', 'sina', 'Y', 'test123', 'http://aa.cc', 'uploads/images/50411c52c22bc.jpg', 1346529600, '3213', '', 14159.95, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', NULL),
(50, 51, 'click', 'sina', 'Y', '12312', 'http://aa.cc', '', 1346752800, '213213', '', 42.55, 0.00, 0, 3, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(51, 51, 'forward', 'sina', 'Y', 'fsadf', 'http://aa.cc', '', 1346652000, '3213213', '3213123', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(52, 51, 'forward', 'sina', 'Y', 'fsadf', 'index.php?m=index&a=jump&id=52', '', 1346652000, '3213213', '3213123', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(53, 51, 'forward', 'sina', 'Y', 'fsadf', 'index.php?m=index&a=jump&id=53', '', 1346652000, '3213213', '3213123', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(54, 51, 'forward', 'sina', 'Y', 'dsadsad', 'index.php?m=index&a=jump&id=54', '', 1346652000, 'fdsfdsfa', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(55, 51, 'click', 'sina', 'Y', '123123', 'index.php?m=index&a=jump&id=55', '', 1346655600, '123213', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(56, 51, 'publish', 'sina', 'Y', '3212313', 'index.php?m=index&a=jump&id=56', '', 1346655600, '3123213', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(57, 51, 'click', 'sina', 'Y', 'fdsafdsafs', 'index.php?m=index&a=jump&id=57', '', 1346742000, 'dsafsd', '', 14177.20, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(58, 51, 'click', 'sina', 'Y', '`1312321', 'index.php?m=index&a=jump&id=58', '', 1346587200, '2313', '', 14177.20, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(59, 4, 'forward', 'sina', 'Y', '哒哒哒', 'index.php?m=index&a=jump&id=59', '', 1350962400, '第三方似懂非懂', '', 14194.45, 0.00, 0, 3, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(60, 52, 'publish', 'sina', 'Y', '测试哦', 'index.php?m=index&a=jump&id=60', '', 1351671600, '实打实的速度', '', 1.15, 1.15, 9, 1, 1, 0, 0, 0, 0, 3, 'Y', 2012),
(61, 52, 'publish', 'sina', 'Y', '', 'index.php?m=index&a=jump&id=61', '', 1351672200, '岁的斯蒂芬斯蒂芬', '', 1.15, 0.00, 0, 0, 0, 0, 1, 1, 0, 3, 'Y', 2012),
(62, 52, 'forward', 'sina', 'Y', '斯蒂芬森', 'index.php?m=index&a=jump&id=62', '', 1351735800, '今天要测试', '', 2.30, 0.00, 0, 0, 0, 0, 2, 2, 0, 3, 'Y', 2012),
(66, 52, 'forward', 'sina', 'Y', '的萨芬斯蒂芬', 'http://www.baidu.com', '', 1351760400, 'sdfsd', 'sdsd', 2.30, 1.15, 9, 0, 1, 0, 1, 2, 0, 3, 'Y', NULL),
(65, 52, 'forward', 'sina', 'Y', '萨芬是否', 'http://www.baidu.com', '', 1351755600, '司法所地方', '', 2.30, 1.15, 9, 0, 1, 0, 1, 2, 0, 3, 'Y', NULL),
(67, 52, 'forward', 'sina', 'Y', '测试拒单', 'http://www.baidu.com', '', 1351761000, '测试拒单', '', 2.30, 1.15, 278141, 2, 1, 0, 1, 0, 0, 3, 'Y', NULL),
(68, 52, 'forward', 'sina', 'Y', 'sdfff', 'http://www.baidu.com', '', 1351761000, 'sdff', '', 2.30, 1.15, 278141, 2, 1, 0, 0, 0, 0, 3, 'Y', NULL),
(69, 52, 'forward', 'sina', 'Y', '斯蒂芬斯蒂芬', 'http://www.baidu.com', '', 1351762200, '收复失地', '速度', 2.30, 1.15, 9, 2, 1, 0, 0, 0, 0, 3, 'Y', NULL),
(70, 52, 'forward', 'sina', 'Y', '萨芬是否', 'http://www.baidu.com', '', 1351762200, '傻傻的发呆', '', 1.15, 1.15, 9, 1, 1, 0, 0, 0, 0, 3, 'Y', NULL),
(71, 52, 'forward', 'sina', 'Y', 'dsfsf', 'index.php?m=index&a=jump&id=71', '', 1351843200, 'dd', '', 2.30, 1.15, 9, 2, 1, 0, 1, 0, 0, 3, 'Y', 2012),
(72, 54, 'forward', 'sina', 'Y', '111', 'index.php?m=index&a=jump&id=72', '', 1351933200, 'http://www.taskwei.com', 'http://www.taskwei.com', 32.25, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(73, 54, 'click', 'qq', 'N', '11111', 'http://index.php?m=index&a=jump&id=73', '', 1352023200, 'http://www.taskwei.com', 'http://www.taskwei.com', 29.80, 0.00, 0, 3, 0, 0, 0, 0, 0, 3, 'Y', 2012),
(74, 55, 'forward', 'sina', 'Y', '测试活动', 'http://weibo.com/a', '', 1353722400, 'hahaha、\r\n13123\r\n312123\r\n3123123\r\n123123\r\n312312\r\n312312\r\n', '不知道ssssss', 49.50, 0.00, 0, 3, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(75, 56, 'click', 'sina', 'N', '测试2', 'http://www.123.com', 'uploads/images/5097276272746.jpg', 1352118000, '盛大的撒', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 3, 'N', 2012),
(76, 56, 'forward', 'sina', 'Y', '测试测试', 'http://www.baidu.com', '', 1352354400, '不要点击', '什么是马上？', 1.15, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(77, 56, 'forward', 'sina', 'Y', '进口料件刻录机', 'http://www.baidu.com', '', 1352274600, '近乎疯狂的了撒就哭了', '近乎疯狂的了撒就哭了', 1.15, 0.00, 0, 1, 0, 0, 0, 0, 0, 3, 'Y', 2012),
(78, 55, 'forward', 'sina', 'Y', 'wwwwwwwwwwwww', 'http://weibo.com/a', '', 1353722400, 'dczczx', 'zczx', 14510.75, 0.00, 0, 11, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(79, 55, 'forward', 'sina', 'Y', 'cxxxx', 'http://weibo.com/a', '', 1353640200, 'fvbgfh', 'fghfgh', 14510.75, 0.00, 0, 11, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(80, 59, 'forward', 'sina', 'Y', '5355', 'http://demo.weiboff.com/i', '', 1354024800, '86', '', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(81, 60, 'forward', 'sina', 'Y', '双十二疯狂购', 'http://zhuti.xiaomi.com/activity/yjmf', '', 1354371600, '惊喜不断', '', 33.69, 8.05, 2854017, 7, 4, 0, 1, 0, 0, 1, 'Y', 2012),
(82, 61, 'click', 'sina', 'Y', 'test', 'http://aa.cc', '', 1354093200, 'test', 'test', 15763.10, 0.00, 0, 0, 0, 0, 0, 11, 0, 4, 'Y', 2012),
(83, 61, 'forward', 'sina', 'Y', 'test1', 'http://aa.cc', '', 1354096800, 'test1', 'test1', 1150.00, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(84, 60, 'forward', 'sina', 'N', '全场5折起', 'http://handuyishe.tmall.com/?ali_trackid=17_01a5efd2a1eeb915d985c307684db724', '', 1354323600, '#韩都推荐#【女王范】独特的版型设计更具韩范儿，大大的翻领毛领。舒适的毛呢面料，能够抵御寒冷的同时并且非常好搭配，随便搭上一条酷酷的围巾，皮靴皮包等，轻而易举就打造出街头混搭女王的风范，街头时尚混搭的必备品！>>>>>http://t.cn/zjthLpE', '(1).推手需要注册有微博。   \r\n(2).将雇主微博加为“关注”  \r\n(3).将雇主微博里的带有 BPbank.net 的内容转发到推手自己的微博，转发的微博内容不得删除，人工审核，删除者视为无效；   \r\n(4).推手转发微博的同时，要求至少要@( 5 )个好友，其中要有1个加V好友，无@好友者视为无效。   \r\n(5).对雇主微博内容进行发言点评，无点评者视为无效（注意：可以在点评的同时进行转发，转发的同时进行点评视为无效），点评禁止出现“卖”、“买”、“购”三字； \r\n(6).点评+转发+加关注到自己的微博即为一个稿件。   \r\n(7).再次强调在点评的时候请围绕突出关键词（商业计划书银行BPbank.net）来进行发言，或者直接使用雇主微博里的相关内容（不要使用全文），没有加入关键词的一律不通过。 \r\n(8).如果推手的僵尸粉超过30%，一律拒绝。   ', 1309.90, 0.00, 0, 4, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(85, 60, 'click', 'sina', 'Y', '圣诞特惠', 'http://weibo.com/2094592623/profile', 'uploads/images/50ba13f283d12.jpg', 1354374600, 'OL族们快来呀~~[hold住]刚刚翻到一家特价女装店，超多款式的韩版小西装都在限时特价！我看上的一款豹纹小西装半价包邮呢~[爱爱爱]你们也快来看看有没有自己喜欢的！小西装、高跟鞋、小提包，[心]走起>>>\r\n\r\n', '有图', 8.39, 4.60, 2783606, 5, 3, 0, 1, 0, 0, 3, 'Y', 2012),
(86, 60, 'forward', 'sina', 'Y', 'qqqqqq', 'http://www.baidu.com', '', 1354546800, '对方答复', '', 44.09, 0.00, 0, 4, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(87, 65, 'forward', 'sina', 'N', '双12特惠活动', 'http://e.weibo.com/hstyle', '', 1354513200, '#韩都推荐#【女王范】独特的版型设计更具韩范儿，大大的翻领毛领。舒适的毛呢面料，能够抵御寒冷的同时并且非常好搭配，随便搭上一条酷酷的围巾，皮靴皮包等，轻而易举就打造出街头混搭女王的风范，街头时尚混搭的必备品！>>>>>http://t.cn/zjthLpE\r\n\r\n', '必须配图。', 8.39, 3.30, 13288048, 5, 3, 0, 1, 0, 0, 3, 'Y', 2012),
(88, 66, 'forward', 'sina', 'Y', '1123', 'http://baidu.com', '', 1355544000, 'fdbbbfd', 'fb', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(89, 68, 'forward', 'sina', 'Y', '55555555', 'http://xs163.net', '', 1354588200, 'kkkkkkkkkkkkkkkkkk', 'kkkkkkkkkkk', 34.50, 20.00, 7449, 2, 1, 0, 0, 0, 0, 1, 'Y', 2012),
(90, 68, 'forward', 'sina', 'Y', '第三方', 'http://www.xs163.net', '', 1354608000, '挂号费', '好办法', 28.75, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(91, 70, 'forward', 'sina', 'Y', '阿道夫奥迪', 'http://www.xs163.net', '', 1354674600, '欢迎光临', '', 17.25, 15.00, 173329, 1, 1, 0, 0, 0, 0, 3, 'Y', 2012),
(92, 65, 'click', 'sina', 'N', '平安夜特惠套餐', 'http://www.landlist.cn/2010-12-24/4251282.htm', 'uploads/images/50bff4168f282.jpg', 1354759800, '最新楼盘动态 瑞泰假日在售房源面积47-109平，起价9600元/平，现举行购房返租金活动，详情可至售楼处咨询。\r\n', '', 22.19, 3.30, 12037034, 7, 3, 0, 1, 0, 0, 3, 'Y', 2012),
(99, 65, 'forward', 'sina', 'Y', '电风扇的地方发生', 'http://www.baidu.com', '', 1354779000, 'dfvsdfbb ', '', 46.39, 0.00, 0, 7, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(95, 52, 'forward', 'sina', 'Y', '123123', 'http://www.baidu.com', '', 1354793400, '斯蒂芬森的', '速度', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 0, 'N', 2012),
(108, 52, 'click', 'sina', 'Y', 'dsfasdfsadf', 'http://weibo.com/1885682354/z7i7uk1sk', '', 1355202000, '无', '根据内容自行写转发语', 22.19, 0.00, 0, 4, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(97, 65, 'forward', 'sina', 'Y', 'vdffds', 'http://www.baidu.com', '', 1354766400, 'cxdfvvgsdfv', '', 13.80, 0.00, 0, 2, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(98, 65, 'click', 'sina', 'Y', '11111', 'http://tuan.fanwe.com/index.php?m=Demo&a=index&', '', 1354766400, 'agffgafg', '', 34.89, 0.00, 0, 4, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(111, 52, 'publish', 'sina', 'N', '1111111111111111111', NULL, '', 1356422400, '11111111111111111', '', 1.15, 0.00, 0, 1, 0, 0, 0, 0, 0, 1, 'Y', 2012),
(109, 52, 'forward', 'sina', 'Y', '123asdfasdf啥啥啥', 'http://demo.weiboff.com/index.php?m=company&a=task_edit&task_id=109', '', 1356624000, '123速度是多少', '123速度是多少', 0.00, 0.00, 0, 0, 0, 0, 0, 0, 0, 3, 'N', 2012),
(110, 52, 'publish', 'qq', 'N', '1111111111111111', NULL, 'uploads/images/50d80b24bcaf3.jpg', 1356418800, '11111111111111', '1111111111111', 26.45, 0.00, 0, 2, 0, 0, 0, 0, 0, 3, 'Y', 2012),
(112, 52, 'forward', 'sina', 'Y', 'aaa ', 'http://www.baidu.com', '', 1356588000, '啊啊啊啊', '啊啊阿道夫 ', 32.59, 0.00, 0, 0, 0, 0, 0, 3, 0, 4, 'Y', 2012);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_task_blog`
--

CREATE TABLE IF NOT EXISTS `weiqi_task_blog` (
  `tblog_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) DEFAULT NULL,
  `blog_id` int(10) DEFAULT NULL,
  `member_id` int(10) DEFAULT NULL,
  `reject` enum('0','1','2','3','4','5') DEFAULT '5' COMMENT '0 已派单 1拒单 2已完成 3已取消 4流单 5待派单',
  `url` varchar(100) DEFAULT '',
  `comment` varchar(255) DEFAULT '' COMMENT '拒单原因',
  PRIMARY KEY (`tblog_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=334 ;

--
-- 转存表中的数据 `weiqi_task_blog`
--

INSERT INTO `weiqi_task_blog` (`tblog_id`, `task_id`, `blog_id`, `member_id`, `reject`, `url`, `comment`) VALUES
(154, 43, 4867, 4, '3', '', ''),
(153, 41, 4867, 4, '5', '', ''),
(151, 40, 4868, 4, '3', '', ''),
(150, 40, 4882, 4, '3', '', ''),
(149, 40, 4867, 4, '3', '', ''),
(148, 38, 4867, 4, '0', '', ''),
(147, 38, 4868, 4, '0', '', ''),
(146, 38, 4882, 4, '0', '', ''),
(145, 37, 4882, 4, '3', '', ''),
(144, 36, 4882, 4, '3', '', ''),
(143, 35, 4867, 4, '3', '', ''),
(142, 35, 4868, 4, '1', '', '暂时离开'),
(141, 35, 4882, 4, '3', '', ''),
(139, 34, 4868, 4, '4', '', ''),
(140, 34, 4867, 4, '2', 'http://fsdf.sfdsssdds', ''),
(138, 34, 4882, 4, '1', '', 'dfsaf'),
(137, 33, 5, 4, '2', 'http://www.baiud.com', ''),
(136, 33, 6, 4, '1', '', '我不喜欢'),
(135, 33, 7, 4, '4', '', ''),
(134, 33, 4867, 4, '2', 'http://ttt.cccfds', ''),
(155, 44, 4867, 51, '0', '', ''),
(156, 44, 4885, 51, '0', '', ''),
(157, 46, 4885, 51, '0', '', ''),
(158, 47, 4885, 51, '0', '', ''),
(159, 49, 4885, 51, '0', '', ''),
(160, 50, 4890, 51, '0', '', ''),
(161, 50, 4891, 51, '0', '', ''),
(162, 50, 4889, 51, '0', '', ''),
(163, 57, 4885, 51, '0', '', ''),
(164, 57, 4891, 51, '0', '', ''),
(165, 58, 4885, 51, '0', '', ''),
(166, 58, 4891, 51, '0', '', ''),
(167, 59, 4886, 4, '0', '', ''),
(168, 59, 4885, 4, '0', '', ''),
(169, 59, 4891, 4, '0', '', ''),
(170, 60, 4895, 52, '2', 'http://www.baidu.com', ''),
(171, 61, 4895, 52, '3', '', '暂时离开'),
(172, 62, 4893, 52, '3', '', '暂时离开'),
(173, 62, 4895, 52, '3', '', '速度达到'),
(179, 65, 4895, 52, '3', 'http://www.jbzyw.com', ''),
(178, 65, 4893, 52, '3', '', '价格原因'),
(180, 66, 4893, 52, '3', '', '价格原因'),
(181, 66, 4895, 52, '3', 'http://www.baidu.com', ''),
(182, 67, 4893, 52, '2', 'http://www.baidu.com', ''),
(183, 67, 4895, 52, '1', '', '价格原因'),
(184, 68, 4893, 52, '2', 'http://www.baidu.com', ''),
(185, 68, 4895, 52, '0', '', ''),
(186, 69, 4893, 52, '0', '', ''),
(187, 69, 4895, 52, '2', 'http://www.baidu.com', ''),
(188, 70, 4895, 52, '2', 'http://www.baidu.com', ''),
(189, 71, 4893, 52, '1', '', '价格原因'),
(190, 71, 4895, 52, '2', 'http://www.baidu.com', ''),
(191, 72, 4886, 54, '0', '', ''),
(192, 72, 4867, 54, '0', '', ''),
(193, 73, 4893, 54, '0', '', ''),
(197, 74, 4886, 55, '0', '', ''),
(195, 73, 4, 54, '0', '', ''),
(196, 73, 4898, 54, '0', '', ''),
(198, 74, 4867, 55, '0', '', ''),
(199, 74, 4887, 55, '0', '', ''),
(200, 75, 4895, 56, '5', '', ''),
(201, 76, 4893, 56, '0', '', ''),
(202, 77, 4895, 56, '0', '', ''),
(203, 78, 4886, 55, '0', '', ''),
(204, 78, 4867, 55, '0', '', ''),
(205, 78, 4892, 55, '0', '', ''),
(206, 78, 4887, 55, '0', '', ''),
(207, 78, 4902, 55, '0', '', ''),
(208, 78, 4889, 55, '0', '', ''),
(209, 78, 4900, 55, '0', '', ''),
(210, 78, 4890, 55, '0', '', ''),
(211, 78, 4888, 55, '0', '', ''),
(212, 78, 4885, 55, '0', '', ''),
(213, 78, 4895, 55, '0', '', ''),
(214, 79, 4886, 55, '0', '', ''),
(215, 79, 4867, 55, '0', '', ''),
(216, 79, 4892, 55, '0', '', ''),
(217, 79, 4887, 55, '0', '', ''),
(218, 79, 4902, 55, '0', '', ''),
(219, 79, 4889, 55, '0', '', ''),
(220, 79, 4900, 55, '0', '', ''),
(221, 79, 4890, 55, '0', '', ''),
(222, 79, 4888, 55, '0', '', ''),
(223, 79, 4885, 55, '0', '', ''),
(224, 79, 4895, 55, '0', '', ''),
(225, 80, 4887, 59, '5', '', ''),
(226, 81, 4889, 60, '0', '', ''),
(227, 82, 4886, 61, '3', '', ''),
(228, 82, 4867, 61, '3', '', ''),
(229, 82, 4892, 61, '3', '', ''),
(230, 82, 4887, 61, '3', '', ''),
(231, 82, 4902, 61, '3', '', ''),
(232, 82, 4889, 61, '3', '', ''),
(233, 82, 4900, 61, '3', '', ''),
(234, 82, 4890, 61, '3', '', ''),
(235, 82, 4888, 61, '3', '', ''),
(236, 82, 4885, 61, '3', '', ''),
(237, 82, 4895, 61, '3', '', ''),
(238, 83, 4905, 61, '0', '', ''),
(239, 84, 4867, 60, '0', '', ''),
(240, 84, 4905, 60, '0', '', ''),
(241, 84, 4900, 60, '0', '', ''),
(242, 84, 4888, 60, '0', '', ''),
(243, 81, 4906, 60, '1', '', '时间冲突'),
(244, 81, 4909, 60, '2', 'http://demo.weiboff.com/index.php?m=company&a=myindex', ''),
(245, 81, 4911, 60, '2', 'http://weibo.com/2094592623/profile', ''),
(246, 81, 4908, 60, '2', 'http://www.weiboyi.com/', ''),
(247, 81, 4910, 60, '2', 'http://weibo.com/2094592623/profile', ''),
(248, 81, 4890, 60, '0', '', ''),
(249, 85, 4906, 60, '0', '', ''),
(250, 85, 4909, 60, '2', 'http://www.chinaz.com/', ''),
(251, 85, 4911, 60, '2', 'http://www.53dns.com/', ''),
(252, 85, 4908, 60, '1', '', '价格原因'),
(253, 85, 4910, 60, '2', 'http://www.53dns.com/', ''),
(254, 86, 4886, 60, '0', '', ''),
(255, 86, 4867, 60, '0', '', ''),
(256, 86, 4906, 60, '0', '', ''),
(257, 86, 4912, 60, '0', '', ''),
(258, 87, 4906, 65, '2', 'http://weibo.com/338935888', ''),
(259, 87, 4909, 65, '2', 'http://e.weibo.com/hstyle', ''),
(260, 87, 4911, 65, '2', 'http://weibo.com/338935888', ''),
(261, 87, 4908, 65, '1', '', '此单为硬广'),
(262, 87, 4910, 65, '0', '', ''),
(263, 89, 4912, 68, '0', '', ''),
(264, 89, 4913, 68, '2', 'http://xs163.net', ''),
(265, 90, 4886, 68, '0', '', ''),
(266, 90, 4912, 68, '0', '', ''),
(267, 91, 4914, 70, '2', 'http://www.163.com', ''),
(268, 92, 4906, 65, '2', 'http://e.weibo.com/2433707254/z8sCaCNCb', ''),
(269, 92, 4896, 65, '0', '', ''),
(270, 92, 4909, 65, '2', 'http://e.weibo.com/1644489953/z8shZt8pG?ref=http%3A%2F%2Fweibo.com%2F2094592623%2Fprofile', ''),
(271, 92, 4911, 65, '1', '', '价格原因'),
(272, 92, 4908, 65, '0', '', ''),
(273, 92, 4910, 65, '2', 'http://e.weibo.com/2433707254/z8sCaCNCb', ''),
(274, 92, 4890, 65, '0', '', ''),
(293, 99, 4867, 65, '0', '', ''),
(292, 99, 4886, 65, '0', '', ''),
(279, 97, 4910, 65, '0', '', ''),
(280, 97, 4890, 65, '0', '', ''),
(281, 97, 4907, 65, '5', '', ''),
(282, 97, 4908, 65, '5', '', ''),
(286, 98, 4867, 65, '0', '', ''),
(285, 98, 4886, 65, '0', '', ''),
(287, 98, 4906, 65, '0', '', ''),
(288, 98, 4892, 65, '0', '', ''),
(291, 95, 4886, 52, '5', '', ''),
(290, 95, 4867, 52, '5', '', ''),
(294, 99, 4906, 65, '0', '', ''),
(295, 99, 4892, 65, '0', '', ''),
(296, 99, 4909, 65, '0', '', ''),
(297, 99, 4907, 65, '0', '', ''),
(298, 99, 4908, 65, '0', '', ''),
(306, NULL, 0, 52, '5', '', ''),
(307, 108, 4906, 52, '0', '', ''),
(308, 108, 4892, 52, '0', '', ''),
(309, 108, 4909, 52, '0', '', ''),
(310, 108, 4914, 52, '0', '', ''),
(311, 109, 4917, 52, '5', '', ''),
(312, 109, 4886, 52, '5', '', ''),
(313, 109, 4867, 52, '5', '', ''),
(314, 109, 4906, 52, '5', '', ''),
(315, 109, 4892, 52, '5', '', ''),
(316, 109, 4896, 52, '5', '', ''),
(317, 109, 4904, 52, '5', '', ''),
(318, 109, 4905, 52, '5', '', ''),
(319, 109, 4887, 52, '5', '', ''),
(320, 109, 4902, 52, '5', '', ''),
(321, 109, 4909, 52, '5', '', ''),
(322, 109, 4911, 52, '5', '', ''),
(323, 109, 4889, 52, '5', '', ''),
(324, 109, 4918, 52, '5', '', ''),
(325, 109, 4900, 52, '5', '', ''),
(326, 109, 4914, 52, '5', '', ''),
(327, 109, 4907, 52, '5', '', ''),
(328, 110, 4894, 52, '0', '', ''),
(329, 110, 4897, 52, '0', '', ''),
(330, 111, 4906, 52, '0', '', ''),
(331, 112, 4886, 52, '3', '', ''),
(332, 112, 4867, 52, '3', '', ''),
(333, 112, 4906, 52, '3', '', '');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_task_cron`
--

CREATE TABLE IF NOT EXISTS `weiqi_task_cron` (
  `tc_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) DEFAULT '0' COMMENT '操作类型  0 短信 1 开始 2结束',
  `time` int(10) DEFAULT '0' COMMENT '时间',
  `task_id` int(10) DEFAULT '0' COMMENT '活动id',
  PRIMARY KEY (`tc_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=181 ;

--
-- 转存表中的数据 `weiqi_task_cron`
--

INSERT INTO `weiqi_task_cron` (`tc_id`, `type`, `time`, `task_id`) VALUES
(7, 0, 1340556600, 35),
(8, 1, 1340557200, 35),
(9, 2, 1340560800, 35),
(16, 0, 1340592600, 38),
(17, 1, 1340593200, 38),
(18, 2, 1340596800, 38),
(25, 0, 1346525400, 44),
(26, 1, 1346526000, 44),
(27, 2, 1346529600, 44),
(28, 0, 1346525400, 46),
(29, 1, 1346526000, 46),
(30, 2, 1346529600, 46),
(31, 0, 1346529000, 47),
(32, 1, 1346529600, 47),
(33, 2, 1346533200, 47),
(34, 0, 1346529000, 49),
(35, 1, 1346529600, 49),
(36, 2, 1346533200, 49),
(37, 0, 1346752200, 50),
(38, 1, 1346752800, 50),
(39, 2, 1346756400, 50),
(40, 0, 1346741400, 57),
(41, 1, 1346742000, 57),
(42, 2, 1346745600, 57),
(43, 0, 1346586600, 58),
(44, 1, 1346587200, 58),
(45, 2, 1346590800, 58),
(46, 0, 1350961800, 59),
(47, 1, 1350962400, 59),
(48, 2, 1350966000, 59),
(49, 0, 1351671000, 60),
(50, 1, 1351671600, 60),
(51, 2, 1351675200, 60),
(75, 2, 1351764600, 68),
(74, 1, 1351761000, 68),
(73, 0, 1351760400, 68),
(58, 0, 1351754400, 63),
(59, 1, 1351755000, 63),
(60, 2, 1351758600, 63),
(61, 0, 1351755000, 64),
(62, 1, 1351755600, 64),
(63, 2, 1351759200, 64),
(72, 2, 1351764600, 67),
(71, 1, 1351761000, 67),
(70, 0, 1351760400, 67),
(76, 0, 1351761600, 69),
(77, 1, 1351762200, 69),
(78, 2, 1351765800, 69),
(85, 0, 1351932600, 72),
(86, 1, 1351933200, 72),
(87, 2, 1351936800, 72),
(93, 2, 1352358000, 76),
(92, 1, 1352354400, 76),
(91, 0, 1352353800, 76),
(99, 2, 1353726000, 74),
(98, 1, 1353722400, 74),
(97, 0, 1353721800, 74),
(100, 0, 1353721800, 78),
(101, 1, 1353722400, 78),
(102, 2, 1353726000, 78),
(103, 0, 1353639600, 79),
(104, 1, 1353640200, 79),
(105, 2, 1353643800, 79),
(111, 2, 1354100400, 83),
(110, 1, 1354096800, 83),
(109, 0, 1354096200, 83),
(112, 0, 1354323000, 84),
(113, 1, 1354323600, 84),
(114, 2, 1354327200, 84),
(115, 0, 1354371000, 81),
(116, 1, 1354371600, 81),
(117, 2, 1354375200, 81),
(123, 2, 1354550400, 86),
(122, 1, 1354546800, 86),
(121, 0, 1354546200, 86),
(129, 2, 1354591800, 89),
(128, 1, 1354588200, 89),
(127, 0, 1354587600, 89),
(130, 0, 1354607400, 90),
(131, 1, 1354608000, 90),
(132, 2, 1354611600, 90),
(141, 2, 1354770000, 97),
(140, 1, 1354766400, 97),
(139, 0, 1354765800, 97),
(142, 0, 1354765800, 98),
(143, 1, 1354766400, 98),
(144, 2, 1354770000, 98),
(145, 0, 1354778400, 99),
(146, 1, 1354779000, 99),
(147, 2, 1354782600, 99),
(148, 0, 1354798200, 100),
(149, 1, 1354798800, 100),
(150, 2, 1354802400, 100),
(151, 0, 1354791000, 101),
(152, 1, 1354791600, 101),
(153, 2, 1354795200, 101),
(154, 0, 1354794600, 102),
(155, 1, 1354795200, 102),
(156, 2, 1354798800, 102),
(157, 0, 1354791000, 103),
(158, 1, 1354791600, 103),
(159, 2, 1354795200, 103),
(160, 0, 1354791000, 104),
(161, 1, 1354791600, 104),
(162, 2, 1354795200, 104),
(163, 0, 1354794600, 105),
(164, 1, 1354795200, 105),
(165, 2, 1354798800, 105),
(171, 2, 1355205600, 108),
(170, 1, 1355202000, 108),
(169, 0, 1355201400, 108),
(175, 0, 1356421800, 111),
(176, 1, 1356422400, 111),
(177, 2, 1356426000, 111);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_task_payoff`
--

CREATE TABLE IF NOT EXISTS `weiqi_task_payoff` (
  `payoff_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) DEFAULT NULL,
  `time` int(10) DEFAULT NULL,
  `money` float(10,2) DEFAULT '0.00',
  `consume` float(10,2) DEFAULT '0.00',
  `task_id` int(10) DEFAULT NULL,
  PRIMARY KEY (`payoff_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=78 ;

--
-- 转存表中的数据 `weiqi_task_payoff`
--

INSERT INTO `weiqi_task_payoff` (`payoff_id`, `member_id`, `time`, `money`, `consume`, `task_id`) VALUES
(2, 4, 1336799861, 5000.00, 0.00, NULL),
(3, 4, 1337052030, 32.00, 0.00, NULL),
(4, 4, 1337065655, 32.00, 0.00, NULL),
(5, 4, 1340255044, 46.33, 0.00, NULL),
(6, 4, 1340255249, 46.33, 0.00, NULL),
(7, 4, 1340255369, 46.33, 0.00, NULL),
(8, 4, 1340448382, 12.00, 0.00, NULL),
(9, 4, 1340518204, 17.91, 0.00, NULL),
(10, 4, 1340519095, 15.00, 0.00, NULL),
(11, 4, 1340528434, 15.00, 0.00, NULL),
(12, 4, 1340529892, 17.91, 0.00, NULL),
(13, 4, 1340531594, 17.91, 0.00, NULL),
(14, 4, 1340533147, 17.91, 0.00, NULL),
(15, 4, 1340536388, 17.91, 0.00, NULL),
(16, 4, 1340542378, 17.91, 0.00, NULL),
(17, 4, 1340542622, 17.91, 0.00, NULL),
(18, 4, 1340546571, 649.15, 0.00, NULL),
(19, 4, 1340553228, 649.15, 0.00, NULL),
(20, 4, 1340587048, 369.15, 0.00, NULL),
(21, 4, 1340588196, 369.15, 0.00, NULL),
(22, 4, 1340588450, 649.15, 0.00, NULL),
(23, 4, 1340607615, 649.15, 0.00, NULL),
(24, 4, 1340703759, 15.00, 0.00, NULL),
(25, 51, 1346440264, 14174.95, 0.00, NULL),
(26, 51, 1346443022, 14159.95, 0.00, NULL),
(27, 51, 1346444204, 141.45, 0.00, NULL),
(28, 51, 1346444397, 14159.95, 0.00, NULL),
(29, 51, 1346582761, 42.55, 0.00, NULL),
(30, 51, 1346572396, 14177.20, 0.00, NULL),
(31, 51, 1346573066, 14177.20, 0.00, NULL),
(32, 4, 1350960546, 14194.45, 0.00, NULL),
(33, 52, 1351669582, 1.15, 0.00, NULL),
(34, 52, 1351670204, 1.15, 0.00, NULL),
(35, 52, 1351733813, 2.30, 0.00, NULL),
(36, 52, 1351752738, 2.30, 0.00, NULL),
(37, 52, 1351753405, 2.30, 0.00, NULL),
(38, 52, 1351753580, 2.30, 0.00, NULL),
(39, 52, 1351757801, 2.30, 0.00, NULL),
(40, 52, 1351758670, 2.30, 0.00, NULL),
(41, 52, 1351758815, 2.30, 0.00, NULL),
(42, 52, 1351759235, 2.30, 0.00, NULL),
(43, 52, 1351759272, 1.15, 0.00, NULL),
(44, 52, 1351838923, 2.30, 0.00, NULL),
(45, 54, 1351849905, 32.25, 0.00, NULL),
(46, 54, 1351850546, 29.80, 0.00, NULL),
(47, 56, 1352269324, 1.15, 0.00, NULL),
(48, 56, 1352270084, 1.15, 0.00, NULL),
(49, 55, 1353637947, 49.50, 0.00, NULL),
(50, 55, 1353638036, 14510.75, 0.00, NULL),
(51, 55, 1353638270, 14510.75, 0.00, NULL),
(52, 61, 1354090531, 15763.10, 0.00, NULL),
(53, 61, 1354092646, 1150.00, 0.00, NULL),
(54, 60, 1354240991, 1309.90, 0.00, NULL),
(55, 60, 1354369625, 33.69, 0.00, NULL),
(56, 60, 1354372268, 8.39, 0.00, NULL),
(57, 60, 1354377326, 1000.00, 0.00, NULL),
(58, 60, 1354463150, 44.09, 0.00, NULL),
(59, 65, 1354510905, 8.39, 0.00, NULL),
(60, 68, 1354586804, 34.50, 0.00, NULL),
(61, 68, 1354602770, 28.75, 0.00, NULL),
(62, 70, 1354672222, 17.25, 0.00, NULL),
(63, 65, 1354757235, 22.19, 0.00, NULL),
(64, 65, 1354762898, 13.80, 0.00, NULL),
(65, 65, 1354763660, 34.89, 0.00, NULL),
(66, 65, 1354777298, 46.39, 0.00, NULL),
(67, 52, 1354784602, 1.15, 0.00, NULL),
(68, 52, 1354785099, 1.15, 0.00, NULL),
(69, 52, 1354785913, 1.15, 0.00, NULL),
(70, 52, 1354786300, 1.15, 0.00, NULL),
(71, 52, 1354786673, 1.15, 0.00, NULL),
(72, 52, 1354787334, 1.15, 0.00, 105),
(73, 52, 1354787913, 1.15, 0.00, 107),
(74, 52, 1355197650, 22.19, 0.00, 108),
(75, 52, 1356335982, 26.45, 0.00, 110),
(76, 52, 1356336173, 1.15, 0.00, 111),
(77, 52, 1356503341, 32.59, 0.00, 112);

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_theme`
--

CREATE TABLE IF NOT EXISTS `weiqi_theme` (
  `theme_id` mediumint(4) unsigned NOT NULL AUTO_INCREMENT,
  `send_name` varchar(50) NOT NULL DEFAULT '' COMMENT '模版名称',
  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '发送标题',
  `tag_var` text COMMENT '标签变量',
  `content` text COMMENT '发送内容',
  `type` enum('sms','email') NOT NULL DEFAULT 'sms' COMMENT '模版类型',
  `status` enum('1','0') NOT NULL DEFAULT '1' COMMENT '1可用 0 不可用',
  PRIMARY KEY (`theme_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

--
-- 转存表中的数据 `weiqi_theme`
--

INSERT INTO `weiqi_theme` (`theme_id`, `send_name`, `name`, `tag_var`, `content`, `type`, `status`) VALUES
(2, '会员找回密码', '手机找回密码', '用户姓名｛name｝', '您的新密码是：{$password}[任何人以任何方式向您索取密码，均为诈骗行为，请勿泄漏]', 'sms', '0'),
(3, '会员找回密码', '邮箱找回密码', '用户年龄｛age｝', '您的新密码是：{$password}(提示：这是系统自动生成密码，请登录后修改你的密码)，', 'email', '1'),
(26, '订单修改通知博主', '', NULL, NULL, 'sms', '1'),
(27, '订单修改通知博主', '', NULL, NULL, 'email', '1'),
(28, '订单取消通知博主', '', NULL, '<p>博主你好，有企业主订单取消，请注意查看！</p>', 'sms', '1'),
(29, '订单取消通知博主', '', NULL, NULL, 'email', '1'),
(4, '博主审核通过', '', NULL, NULL, 'sms', '0'),
(5, '博主审核通过', '微博审核通过', '用户名{$username} 微博昵称:{$nick}', '<p>尊敬的会员： <span style="color:#ff0000;">{$username}<br /></span>恭喜！您提交的微博： <span style="color:#3333ff;">{$nick} </span>，审核通过！</p>', 'email', '1'),
(6, '博主审核驳回', '', NULL, NULL, 'sms', '0'),
(7, '博主审核驳回', '微博审核驳回', '用户名{$username} 微博昵称:{$nick}', '<p>尊敬的会员： <span><span style="color:#ff0000;">{$username}<br /></span></span>非常抱歉！您提交的微博： <span><span style="color:#3333ff;">{$nick}</span> </span>，审核被驳回！</p>', 'email', '1'),
(8, '广告主下单支付', '', NULL, NULL, 'sms', '0'),
(9, '广告主下单支付', '活动支付成功', '用户名:{$username} 活动名:{$name} 支付金额:{$money}', '尊敬的广告主：{$username}<br />恭喜您，活动：{$name}，支付成功！共支付金额:{$money}', 'email', '1'),
(10, '广告主审核驳回', '', NULL, NULL, 'sms', '0'),
(11, '广告主审核驳回', '广告主审核驳回', '{$username}:用户名', '尊敬的用户：{$username}<br />非常抱歉，您申请的广告主，被驳回！', 'email', '1'),
(12, '微博主注册完成', '', NULL, NULL, 'sms', '0'),
(13, '微博主注册完成', '微博主注册完成', NULL, '尊敬的微博主：{$username}<br />恭喜！注册成功！', 'email', '1'),
(14, '广告主注册完成', '手机绑定验证', NULL, '您的小秘书验证码是：{$verify}.如非您本人操作，也许是他人勿填了您的号码。【小秘书】', 'sms', '0'),
(15, '广告主注册完成', '企业主注册完成', '绑定邮箱｛email｝', '<p>尊敬的企业主：{$username}<br /><br />您的资料已提交，等待审核·····</p>', 'email', '1'),
(22, '活动付款给博主发邮件', '', NULL, NULL, 'sms', '0'),
(23, '活动付款给博主发邮件', '', NULL, NULL, 'email', '0'),
(24, '活动开始前10分钟发短信', '', NULL, NULL, 'sms', '0'),
(25, '活动开始前10分钟发短信', '', NULL, NULL, 'email', '0'),
(20, '广告主通过审核', '', NULL, NULL, 'sms', '0'),
(21, '广告主通过审核', '广告主通过审核', '{$username}:用户名', '尊敬的用户:{$username}<br />恭喜！您申请的广告主通过审核！', 'email', '1');

-- --------------------------------------------------------

--
-- 表的结构 `weiqi_url`
--

CREATE TABLE IF NOT EXISTS `weiqi_url` (
  `task_id` bigint(20) unsigned NOT NULL COMMENT '点击活动id',
  `jump_url` varchar(500) NOT NULL DEFAULT '' COMMENT '跳转地址',
  PRIMARY KEY (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `weiqi_url`
--

INSERT INTO `weiqi_url` (`task_id`, `jump_url`) VALUES
(1, 'http://www.baidu.com'),
(51, ''),
(52, ''),
(53, ''),
(54, 'http://aa.cc'),
(55, 'http://aa.cc'),
(56, 'http://aa.cc'),
(57, 'http://aa.cc'),
(58, 'http://www.baidu.com'),
(59, 'http://www.dfd'),
(60, 'http://www.baidu.com'),
(61, 'http://www.aa.com'),
(62, 'http://www.weibo.com'),
(71, 'http://www.baidu.com'),
(72, 'http://www.taskwei.com'),
(73, 'http://www.taskwei.com'),
(74, 'http://www.ceshihuodong.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
