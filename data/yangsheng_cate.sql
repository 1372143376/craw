/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50624
Source Host           : localhost:3306
Source Database       : test

Target Server Type    : MYSQL
Target Server Version : 50624
File Encoding         : 65001

Date: 2018-01-17 15:46:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for yangsheng_cate
-- ----------------------------
DROP TABLE IF EXISTS `yangsheng_cate`;
CREATE TABLE `yangsheng_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `wx` varchar(255) DEFAULT NULL,
  `number` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `is_done` tinyint(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of yangsheng_cate
-- ----------------------------
INSERT INTO `yangsheng_cate` VALUES ('1', '健康养生大百科', 'jkysdbk ', null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('2', '一分钟健康养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('3', '陪你养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('4', '杭州日报养生道', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('5', '养生每日推送', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('6', '康美中药养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('7', '老中医养生道', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('8', '世医堂中医养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('9', '启忠养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('10', '脉脉养生', null, null, null, '0');
INSERT INTO `yangsheng_cate` VALUES ('11', '养生', null, null, null, '0');
