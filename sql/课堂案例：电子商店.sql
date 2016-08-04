-- phpMyAdmin SQL Dump
-- version 4.1.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 2014-10-23 21:25:45
-- 服务器版本： 5.5.24
-- PHP Version: 5.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gouwu`
--

-- --------------------------------------------------------

--
-- 表的结构 `order_goods`
--

CREATE TABLE IF NOT EXISTS `order_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `pro_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `count` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单商品表' AUTO_INCREMENT=9 ;

--
-- 转存表中的数据 `order_goods`
--

INSERT INTO `order_goods` (`id`, `order_id`, `pro_id`, `price`, `count`) VALUES
(1, 1, 1, 1999, 1),
(2, 1, 4, 5499, 1),
(3, 1, 12, 3238, 2),
(4, 2, 4, 5499, 1),
(5, 3, 5, 11499, 1),
(6, 3, 12, 3238, 1),
(7, 4, 2, 3999, 4),
(8, 5, 4, 5499, 1);

-- --------------------------------------------------------

--
-- 表的结构 `order_info`
--

CREATE TABLE IF NOT EXISTS `order_info` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `order_time` datetime NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `order_addr` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`order_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='订单信息表' AUTO_INCREMENT=6 ;

--
-- 转存表中的数据 `order_info`
--

INSERT INTO `order_info` (`order_id`, `user_id`, `order_time`, `order_total`, `order_addr`) VALUES
(1, 1, '2014-04-05 06:07:08', '10736.00', '北京市昌平区回龙观镇金燕龙写字楼101室'),
(2, 2, '2014-06-15 16:17:18', '5499.00', '金燕龙102室'),
(3, 5, '2014-06-22 21:20:21', '14737.00', '金燕龙写字楼201室'),
(4, 1, '2014-07-06 05:04:03', '3999.00', '金燕龙101'),
(5, 1, '2014-07-08 09:10:11', '5499.00', '金燕龙写字楼前台代收');

-- --------------------------------------------------------

--
-- 表的结构 `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `pro_id` int(11) NOT NULL AUTO_INCREMENT,
  `pro_name` varchar(100) NOT NULL,
  `protype_id` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `pinpai` varchar(25) NOT NULL,
  `chandi` varchar(25) NOT NULL,
  PRIMARY KEY (`pro_id`),
  KEY `pro_name` (`pro_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='商品信息表' AUTO_INCREMENT=16 ;

--
-- 转存表中的数据 `product`
--

INSERT INTO `product` (`pro_id`, `pro_name`, `protype_id`, `price`, `pinpai`, `chandi`) VALUES
(1, '康佳（KONKA）42英寸全高清液晶电视', 1, '1999.00', '康佳', '深圳'),
(2, '索尼（SONY）4G手机（黑色）', 2, '3238.00', '索尼', '深圳'),
(3, '海信（Hisense）55英寸智能电视', 1, '4199.00', '海信', '青岛'),
(4, '联想（Lenovo）14.0英寸笔记本电脑', 3, '5499.00', '联想', '北京'),
(5, '索尼（SONY）13.3英寸触控超极本', 3, '11499.00', '索尼', '天津'),
(11, '索尼（SONY）60英寸全高清液晶电视', 1, '6999.00', '索尼', '北京'),
(12, '联想（Lenovo）14.0英寸笔记本电脑', 3, '2999.00', '联想', '北京'),
(13, '联想 双卡双待3G手机', 2, '988.00', '联想', '北京'),
(15, '惠普（HP）黑白激光打印机', 3, '1169.00', '惠普', '天津');

-- --------------------------------------------------------

--
-- 表的结构 `product_type`
--

CREATE TABLE IF NOT EXISTS `product_type` (
  `protype_id` int(11) NOT NULL AUTO_INCREMENT,
  `protype_name` varchar(50) NOT NULL,
  PRIMARY KEY (`protype_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='产品类型表' AUTO_INCREMENT=12 ;

--
-- 转存表中的数据 `product_type`
--

INSERT INTO `product_type` (`protype_id`, `protype_name`) VALUES
(1, '家用电器'),
(2, '手机数码'),
(3, '电脑办公'),
(4, '图书音像'),
(5, '家居家具'),
(6, '服装配饰'),
(7, '个护化妆'),
(8, '运动户外'),
(9, '汽车用品'),
(10, '食品酒水'),
(11, '营养保健');

-- --------------------------------------------------------

--
-- 表的结构 `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(25) NOT NULL,
  `user_pswd` varchar(128) NOT NULL,
  `real_name` varchar(25) NOT NULL,
  `birthday` date DEFAULT NULL,
  `QQ` varchar(12) DEFAULT NULL,
  `reg_time` datetime NOT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_name` (`user_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户信息表' AUTO_INCREMENT=7 ;

--
-- 转存表中的数据 `user_info`
--

INSERT INTO `user_info` (`user_id`, `user_name`, `user_pswd`, `real_name`, `birthday`, `QQ`, `reg_time`) VALUES
(1, 'swk', '123', '孙悟空', '1989-02-10', '12500791', '2013-04-05 06:07:08'),
(2, 'zbj', '456', '猪八戒', '1995-01-01', '19950101', '2009-08-07 06:05:04'),
(3, 'shs', '789', '沙和尚', '1995-02-02', '', '2010-11-12 13:14:15'),
(4, 'yhdd', '1234', '玉皇大帝', '1991-02-03', '19910203', '2002-02-22 22:22:22'),
(5, 'gynn', '2234', '观音娘娘', '1995-05-05', '555991', '2008-08-08 08:08:08'),
(6, 'change', '3234', '嫦娥', '1991-02-03', '', '2011-11-11 11:11:11');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
