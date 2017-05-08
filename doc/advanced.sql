-- MySQL dump 10.13  Distrib 5.6.10, for Linux (x86_64)
--
-- Host: localhost    Database: advanced
-- ------------------------------------------------------
-- Server version	5.6.10

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `auth_assignment`
--

DROP TABLE IF EXISTS `auth_assignment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_assignment`
--

LOCK TABLES `auth_assignment` WRITE;
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` VALUES ('test','17',1466175308),('权限控制','3',1466006022),('测试员','17',1466175308),('系统管理员','14',1466078336),('系统管理员','15',1466080151),('系统管理员','16',1466080360),('系统管理员','3',1466006001);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item`
--

DROP TABLE IF EXISTS `auth_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  `rule_name` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`),
  KEY `rule_name` (`rule_name`),
  KEY `idx-auth_item-type` (`type`),
  CONSTRAINT `auth_item_ibfk_1` FOREIGN KEY (`rule_name`) REFERENCES `auth_rule` (`name`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item`
--

LOCK TABLES `auth_item` WRITE;
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` VALUES ('/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/assignment/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/assignment/assign',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/assignment/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/assignment/revoke',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/assignment/view',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/default/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/default/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/create',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/delete',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/update',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/menu/view',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/assign',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/create',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/delete',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/remove',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/update',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/permission/view',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/assign',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/create',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/delete',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/remove',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/update',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/role/view',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/assign',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/create',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/refresh',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/route/remove',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/create',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/delete',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/update',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/rule/view',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/*',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/activate',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/change-password',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/delete',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/index',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/login',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/logout',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/request-password-reset',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/reset-password',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/signup',2,NULL,NULL,NULL,1465927393,1465927393),('/admin/user/view',2,NULL,NULL,NULL,1465927393,1465927393),('/common/*',2,NULL,NULL,NULL,1466018566,1466018566),('/debug/*',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/*',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/db-explain',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/download-mail',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/index',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/toolbar',2,NULL,NULL,NULL,1465927393,1465927393),('/debug/default/view',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/*',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/*',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/action',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/diff',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/index',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/preview',2,NULL,NULL,NULL,1465927393,1465927393),('/gii/default/view',2,NULL,NULL,NULL,1465927393,1465927393),('/permission/create',2,'权限添加',NULL,NULL,1466178382,1466178382),('/permission/delete',2,'权限删除',NULL,NULL,1466189781,1466189781),('/permission/index',2,'权限列表',NULL,NULL,1466140400,1466190093),('/permission/update',2,'权限更新',NULL,NULL,1466189760,1466189760),('/role/*',2,NULL,NULL,NULL,1466067889,1466067889),('/role/create',2,'角色添加',NULL,NULL,1466189684,1466189684),('/role/delete',2,'角色删除',NULL,NULL,1466189719,1466189719),('/role/index',2,'角色列表',NULL,NULL,1466187154,1466189533),('/role/update',2,'角色更新',NULL,NULL,1466189699,1466189699),('/site/*',2,NULL,NULL,NULL,1465927393,1465927393),('/site/error',2,NULL,NULL,NULL,1465927393,1465927393),('/site/index',2,NULL,NULL,NULL,1465927393,1465927393),('/site/login',2,NULL,NULL,NULL,1465927393,1465927393),('/site/logout',2,NULL,NULL,NULL,1465927393,1465927393),('/user-backend/*',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/create',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/delete',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/index',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/signup',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/update',2,NULL,NULL,NULL,1465922171,1465922171),('/user-backend/view',2,NULL,NULL,NULL,1465922171,1465922171),('test',1,'test',NULL,NULL,1466175297,1466190022),('test1',1,'测试员',NULL,NULL,1466148949,1466148949),('权限控制',2,'权限控制',NULL,NULL,1465922218,1466020038),('测试员',1,'测试员',NULL,NULL,1466161424,1466190184),('系统管理员',1,'系统管理员',NULL,NULL,1465922626,1466142938);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_item_child`
--

DROP TABLE IF EXISTS `auth_item_child`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_item_child`
--

LOCK TABLES `auth_item_child` WRITE;
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` VALUES ('权限控制','/admin/menu/*'),('权限控制','/admin/permission/*'),('权限控制','/admin/role/*'),('权限控制','/admin/route/*'),('系统管理员','权限控制');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auth_rule`
--

DROP TABLE IF EXISTS `auth_rule`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auth_rule`
--

LOCK TABLES `auth_rule` WRITE;
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog`
--

DROP TABLE IF EXISTS `blog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '',
  `content` text,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog`
--

LOCK TABLES `blog` WRITE;
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
INSERT INTO `blog` VALUES (2,'Test','Hello World','2017-02-05 00:00:00');
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'权限管理',NULL,NULL,NULL,'{\"icon\":\"fa fa-lock\",\"visible\":true}'),(2,'权限控制',1,'/permission/index',NULL,'{\"icon\":\"fa fa-lock\",\"visible\":true}'),(3,'用户管理',1,'/user-backend/index',NULL,'{\"icon\":\"fa fa-user\",\"visible\":true}'),(4,'角色管理',1,'/role/index',NULL,'{\"icon\":\"fa fa-user\",\"visible\":true}');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_item`
--

DROP TABLE IF EXISTS `menu_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_item` (
  `menu_id` int(11) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  UNIQUE KEY `menu_item` (`menu_id`,`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单权限关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_item`
--

LOCK TABLES `menu_item` WRITE;
/*!40000 ALTER TABLE `menu_item` DISABLE KEYS */;
INSERT INTO `menu_item` VALUES (2,'/permission/create'),(2,'/permission/delete'),(2,'/permission/index'),(2,'/permission/update'),(4,'/role/create'),(4,'/role/delete'),(4,'/role/index'),(4,'/role/update');
/*!40000 ALTER TABLE `menu_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migration`
--

LOCK TABLES `migration` WRITE;
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` VALUES ('m000000_000000_base',1465885143),('m130524_201442_init',1465885148),('m140506_102106_rbac_init',1465906972);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `auth_key` varchar(32) NOT NULL COMMENT '自动登录key',
  `password_hash` varchar(255) NOT NULL COMMENT '加密密码',
  `password_reset_token` varchar(255) DEFAULT NULL COMMENT '重置密码token',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `role` smallint(6) NOT NULL DEFAULT '10' COMMENT '角色等级',
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '状态',
  `created_at` int(11) NOT NULL COMMENT '创建时间',
  `updated_at` int(11) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'tsai','YKqK0qNN19pR4q35tzrFzlYCacJb-bYA','$2y$13$gkgkmDcctltLSahNcqHvrOU6oL/QgW9Q57rBlJmR/.MF6Ec54J0Cu',NULL,'tsai@163.com',10,10,1465902873,1465902873),(2,'admin','ExcYDHuDa-JPowS44Q9GmjWNlhFiuLJv','$2y$13$hBWnRjN894Yzmw5uxSpgnuepuOu0RMFA0XgiNHG16DY.rjtOcH4jy',NULL,'admin@admin.com',10,10,1465985822,1465985822);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_backend`
--

DROP TABLE IF EXISTS `user_backend`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_backend` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_backend`
--

LOCK TABLES `user_backend` WRITE;
/*!40000 ALTER TABLE `user_backend` DISABLE KEYS */;
INSERT INTO `user_backend` VALUES (2,'jack','bRGZ1r0HlUQcMTbYpN1QAxtpigXYFc9G','123456','jack@163.com','2016-06-14 17:46:01','2016-06-14 17:46:01'),(3,'admin','xHrIurvjnNIM-FNhcb1jKqPCDboPxW8U','$2y$13$Pou5QI7Qr17ocvCY2N7X9.RMD4nPP5wcn/uX/UYmGkdhTUnYjm/tW','admin@admin.com','2016-06-15 07:34:49','2016-06-15 07:34:49'),(17,'test','UJPj2Bq21FRKtC3aPWEzT37CMe4chQ1D','$2y$13$kVtzWQCoPBb/tTOVZVQIz.pnx7863h42BvDdjgBaEDiU97VyNExIC','test@test.com','2016-06-16 21:26:54','2016-06-16 21:26:54');
/*!40000 ALTER TABLE `user_backend` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-18  3:05:59
