SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` char(32) NOT NULL COMMENT '密码',
  `name` varchar(255) NOT NULL COMMENT '名字',
  `surname` varchar(255) NOT NULL COMMENT '姓',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `gender` varchar(50) NOT NULL COMMENT '性别',
  `date_of_birth` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '出生年月日',
  `employ_id` varchar(255) NOT NULL,
  `organization_address` varchar(255) NOT NULL COMMENT '地址',
  `phone` varchar(255) NOT NULL COMMENT '电话',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `token` varchar(150) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`) USING BTREE,
  UNIQUE KEY `email` (`email`(191)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for data
-- ----------------------------
DROP TABLE IF EXISTS `data`;
CREATE TABLE `data` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `upload_date` int(11) unsigned NOT NULL DEFAULT '0',
  `time` varchar(255) NOT NULL,
  `path` varchar(255) NOT NULL,
  `is_delete` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `user_id` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for data_gps
-- ----------------------------
DROP TABLE IF EXISTS `data_gps`;
CREATE TABLE `data_gps` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data_id` int(11) unsigned NOT NULL,
  `latitude` varchar(255) NOT NULL COMMENT '纬度',
  `longitude` varchar(255) NOT NULL COMMENT '经度',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for data_old
-- ----------------------------
DROP TABLE IF EXISTS `data_old`;
CREATE TABLE `data_old` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `date` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '上传数据 日期',
  `time` varchar(255) NOT NULL COMMENT '上传数据 时间',
  `eda` varchar(255) NOT NULL COMMENT '上传数据 皮肤电活动',
  `bvp` varchar(255) NOT NULL COMMENT '上传数据 血量脉搏',
  `acc` varchar(255) NOT NULL COMMENT '上传数据 加速度计',
  `hr` varchar(255) NOT NULL COMMENT '上传数据 心率',
  `temp` varchar(255) NOT NULL COMMENT '上传数据 温度',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` char(32) NOT NULL COMMENT '密码',
  `name` varchar(255) NOT NULL COMMENT '名字',
  `surname` varchar(255) NOT NULL COMMENT '姓',
  `age` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '年龄',
  `gender` varchar(50) NOT NULL COMMENT '性别',
  `date_of_birth` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '出生年月日',
  `fiscal_code` varchar(255) NOT NULL COMMENT '税号',
  `address` varchar(255) NOT NULL COMMENT '地址',
  `phone` varchar(255) NOT NULL COMMENT '电话',
  `email` varchar(50) NOT NULL COMMENT '邮箱',
  `token` varchar(150) NOT NULL DEFAULT '',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`) USING BTREE,
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for user_medical_history
-- ----------------------------
DROP TABLE IF EXISTS `user_medical_history`;
CREATE TABLE `user_medical_history` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `visual_disability` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '视力障碍',
  `mobility_disability` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '行动不便',
  `wheelchair_user` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '轮椅使用者',
  `hypertension` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '高血压',
  `diabetes` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '糖尿病',
  `asthma` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '哮喘',
  `arthritis` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '关节炎',
  `user_id` int(11) unsigned NOT NULL,
  `create_time` int(11) unsigned NOT NULL DEFAULT '0',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;
