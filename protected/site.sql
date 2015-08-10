/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50616
Source Host           : localhost:3306
Source Database       : site

Target Server Type    : MYSQL
Target Server Version : 50616
File Encoding         : 65001

Date: 2015-05-18 09:29:09
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `tbl_address`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_address`;
CREATE TABLE `tbl_address` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL,
  `address` varchar(255) NOT NULL DEFAULT '',
  `format_address` varchar(255) NOT NULL DEFAULT '',
  `room` int(10) NOT NULL,
  `street` varchar(200) NOT NULL DEFAULT '',
  `locality` varchar(200) NOT NULL DEFAULT '',
  `region` varchar(200) NOT NULL DEFAULT '',
  `zipcode` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `tbl_courier`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_courier`;
CREATE TABLE `tbl_courier` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `image` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(10) NOT NULL DEFAULT '',
  `moto` varchar(100) NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `isbusy` int(3) NOT NULL DEFAULT '0',
  `status` int(3) NOT NULL DEFAULT '1',
  `update_datetime` datetime NOT NULL,
  `create_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送员表';

-- ----------------------------
-- Table structure for `tbl_courier_orders`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_courier_orders`;
CREATE TABLE `tbl_courier_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `oid` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '0',
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='配送员配送订单表';

-- ----------------------------
-- Table structure for `tbl_food`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_food`;
CREATE TABLE `tbl_food` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `rid` int(10) NOT NULL,
  `sid` int(10) NOT NULL,
  `image` varchar(255) NOT NULL,
  `price` float(20,2) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `rec` int(3) NOT NULL DEFAULT '0',
  `sortnum` int(5) NOT NULL DEFAULT '0',
  `discount` float(10,2) NOT NULL DEFAULT '0.00',
  `status` int(3) NOT NULL DEFAULT '1',
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜品表';

-- ----------------------------
-- Table structure for `tbl_order`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_order`;
CREATE TABLE `tbl_order` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `realname` varchar(255) NOT NULL DEFAULT '',
  `user_address` varchar(255) NOT NULL DEFAULT '',
  `user_mobile` varchar(20) NOT NULL DEFAULT '',
  `expect_date` varchar(20) NOT NULL DEFAULT '',
  `expect_time` varchar(50) NOT NULL DEFAULT '',
  `total_price` float(20,2) NOT NULL,
  `discount` float(20,2) NOT NULL,
  `paytype` varchar(20) NOT NULL DEFAULT '',
  `payment` varchar(20) NOT NULL DEFAULT '0',
  `cardnum` varchar(20) NOT NULL DEFAULT '',
  `cardowner` varchar(50) NOT NULL DEFAULT '',
  `courier` int(10) NOT NULL,
  `courier_mobile` varchar(20) NOT NULL DEFAULT '',
  `status` int(3) NOT NULL DEFAULT '3',
  `deal` int(3) NOT NULL DEFAULT '0',
  `tag` int(3) NOT NULL DEFAULT '0',
  `fee` float(10,0) NOT NULL DEFAULT '0',
  `desc` text NOT NULL,
  `food_datetime` datetime NOT NULL,
  `send_datetime` datetime NOT NULL,
  `finish_datetime` datetime NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Table structure for `tbl_order_log`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_order_log`;
CREATE TABLE `tbl_order_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `oid` int(10) NOT NULL,
  `rid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `status` int(3) NOT NULL,
  `desc` varchar(255) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单日志表';

-- ----------------------------
-- Table structure for `tbl_po`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_po`;
CREATE TABLE `tbl_po` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `oid` int(10) NOT NULL,
  `rid` int(10) NOT NULL,
  `uid` int(10) NOT NULL,
  `fid` int(10) NOT NULL,
  `num` int(10) NOT NULL DEFAULT '0',
  `price` float(20,2) NOT NULL,
  `discount` float(20,2) NOT NULL,
  `tips` varchar(255) NOT NULL,
  `status` int(3) NOT NULL DEFAULT '1',
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单菜品表';

-- ----------------------------
-- Table structure for `tbl_restaurant`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_restaurant`;
CREATE TABLE `tbl_restaurant` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(38) NOT NULL,
  `name` varchar(200) NOT NULL,
  `type` int(3) NOT NULL,
  `image` varchar(255) NOT NULL,
  `tel` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `address` varchar(200) NOT NULL,
  `map_x` decimal(20,6) NOT NULL,
  `map_y` decimal(20,6) NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL,
  `start` float(10,2) NOT NULL,
  `area` varchar(255) NOT NULL,
  `zipcode` int(10) NOT NULL,
  `vip` int(3) NOT NULL DEFAULT '0',
  `sortnum` int(5) NOT NULL DEFAULT '0',
  `tags` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐厅表';

-- ----------------------------
-- Table structure for `tbl_restaurant_series`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_restaurant_series`;
CREATE TABLE `tbl_restaurant_series` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `rid` int(10) NOT NULL,
  `sid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `tbl_series`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_series`;
CREATE TABLE `tbl_series` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `tbl_tag`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tag`;
CREATE TABLE `tbl_tag` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='餐厅标签';

-- ----------------------------
-- Table structure for `tbl_tag_value`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_tag_value`;
CREATE TABLE `tbl_tag_value` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tid` int(10) NOT NULL,
  `value` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT '',
  `realname` varchar(255) NOT NULL DEFAULT '',
  `firstname` varchar(128) NOT NULL DEFAULT '',
  `lastname` varchar(128) NOT NULL DEFAULT '',
  `email` varchar(128) NOT NULL DEFAULT '',
  `tel` varchar(20) NOT NULL DEFAULT '',
  `mobile` varchar(20) NOT NULL,
  `address_id` int(10) NOT NULL,
  `uuid` varchar(128) NOT NULL DEFAULT '',
  `source` varchar(20) NOT NULL DEFAULT '',
  `status` int(3) NOT NULL DEFAULT '1',
  `token` varchar(50) NOT NULL DEFAULT '',
  `token_time` int(10) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'admin', '96e79218965eb72c92a549dd5a330112', 'admin', '', '', '', 'admin@example.com', '', '13333333333', '0', '', '', '1', '', '0', '0000-00-00 00:00:00', '2015-05-14 09:46:27');