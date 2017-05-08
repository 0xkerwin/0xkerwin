-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.40 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 advanced 的数据库结构
CREATE DATABASE IF NOT EXISTS `advanced` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `advanced`;

-- 导出  表 advanced.admin_log 结构
CREATE TABLE IF NOT EXISTS `admin_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(10) unsigned NOT NULL COMMENT '操作用户ID',
  `admin_name` varchar(255) NOT NULL COMMENT '操作用户名',
  `record_time` int(11) NOT NULL COMMENT '记录时间',
  `admin_ip` varchar(255) NOT NULL COMMENT '操作用户IP',
  `description` varchar(255) NOT NULL COMMENT '记录描述',
  `route` varchar(255) NOT NULL COMMENT '操作路由',
  `model` varchar(255) NOT NULL COMMENT '操作模块（例：系统管理）',
  `object` varchar(255) NOT NULL COMMENT '操作对象（例：菜单列表）',
  `type` int(2) NOT NULL COMMENT '操作类型（例：添加）',
  `result` int(2) NOT NULL COMMENT '操作结果',
  `remark` text COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- 正在导出表  advanced.admin_log 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;

-- 导出  表 advanced.auth_assignment 结构
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  advanced.auth_assignment 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('sysadmin', '2', 1487676216);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;

-- 导出  表 advanced.auth_item 结构
CREATE TABLE IF NOT EXISTS `auth_item` (
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

-- 正在导出表  advanced.auth_item 的数据：~17 rows (大约)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('/rbac/menu/create', 2, '菜单添加', NULL, NULL, 1487733184, 1487733184),
	('/rbac/menu/delete', 2, '菜单删除', NULL, NULL, 1487733239, 1487733239),
	('/rbac/menu/index', 2, '菜单列表', NULL, NULL, 1487676156, 1487676156),
	('/rbac/menu/update', 2, '菜单更新', NULL, NULL, 1487733219, 1487733219),
	('/rbac/perminssion/create', 2, '权限添加', NULL, NULL, 1487733155, 1487733155),
	('/rbac/permission/delete', 2, '权限删除', NULL, NULL, 1487732995, 1487732995),
	('/rbac/permission/index', 2, '权限列表', NULL, NULL, 1487676134, 1487676274),
	('/rbac/permission/update', 2, '权限更新', NULL, NULL, 1487732975, 1487732975),
	('/rbac/role/create', 2, '角色添加', NULL, NULL, 1487733088, 1487733088),
	('/rbac/role/delete', 2, '角色删除', NULL, NULL, 1487733105, 1487733105),
	('/rbac/role/index', 2, '角色列表', NULL, NULL, 1487676099, 1487676099),
	('/rbac/role/update', 2, '角色更新', NULL, NULL, 1487733038, 1487733068),
	('/rbac/user-backend/delete', 2, '用户删除', NULL, NULL, 1487732936, 1487732936),
	('/rbac/user-backend/index', 2, '用户列表', NULL, NULL, 1487675839, 1487677249),
	('/rbac/user-backend/signup', 2, '用户添加', NULL, NULL, 1487676007, 1487677264),
	('/rbac/user-backend/update', 2, '用户更新', NULL, NULL, 1487676058, 1487732893),
	('sysadmin', 1, '系统管理员', NULL, NULL, 1487676207, 1489913942);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;

-- 导出  表 advanced.auth_item_child 结构
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  advanced.auth_item_child 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

-- 导出  表 advanced.auth_rule 结构
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  advanced.auth_rule 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;

-- 导出  表 advanced.blog 结构
CREATE TABLE `blog` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(100) NOT NULL DEFAULT '' COMMENT '标题',
  `content` TEXT NULL COMMENT '博客内容',
  `user_id` INT(11) NOT NULL COMMENT '创建博客的用户id',
  `edit_id` INT(11) NULL DEFAULT NULL COMMENT '修改博客的用户id',
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='博客';

-- 正在导出表  advanced.blog 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;

-- 导出  表 advanced.menu 结构
CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `parent` int(11) DEFAULT NULL,
  `route` varchar(256) DEFAULT NULL,
  `order` int(11) DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`),
  KEY `parent` (`parent`),
  CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `menu` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- 正在导出表  advanced.menu 的数据：~6 rows (大约)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
	(1, '系统管理', NULL, NULL, NULL, '{"icon":"fa fa-gears","visible":"true"}'),
	(2, '用户管理', 1, '/rbac/user-backend/index', NULL, '{"icon":"fa fa-user","visible":"true"}'),
	(3, '角色管理', 1, '/rbac/role/index', NULL, '{"icon":"fa fa-users","visible":"true"}'),
	(4, '权限管理', 1, '/rbac/permission/index', NULL, '{"icon":"fa fa-lock","visible":"true"}'),
	(5, '菜单管理', 1, '/rbac/menu/index', NULL, '{"icon":"fa fa-th-list","visible":"true"}'),
	(6, '操作日志', 1, '/admin-log/index', NULL, '{"icon":"fa fa-file-text","visible":"true"}'),
  (7, '文章管理', NULL, NULL, NULL, '{"icon":"fa fa-book","visible":"true"}'),
  (8, '博客管理', 7, '/blog/index', NULL, '{"icon":"fa fa-list-alt","visible":"true"}');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- 导出  表 advanced.menu_item 结构
CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_id` int(11) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  UNIQUE KEY `menu_item` (`menu_id`,`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单权限关联表';

-- 正在导出表  advanced.menu_item 的数据：~16 rows (大约)
/*!40000 ALTER TABLE `menu_item` DISABLE KEYS */;
INSERT INTO `menu_item` (`menu_id`, `item_name`) VALUES
	(2, '/rbac/user-backend/delete'),
	(2, '/rbac/user-backend/index'),
	(2, '/rbac/user-backend/signup'),
	(2, '/rbac/user-backend/update'),
	(3, '/rbac/role/create'),
	(3, '/rbac/role/delete'),
	(3, '/rbac/role/index'),
	(3, '/rbac/role/update'),
	(4, '/rbac/perminssion/create'),
	(4, '/rbac/permission/delete'),
	(4, '/rbac/permission/index'),
	(4, '/rbac/permission/update'),
	(5, '/rbac/menu/create'),
	(5, '/rbac/menu/delete'),
	(5, '/rbac/menu/index'),
	(5, '/rbac/menu/update');
/*!40000 ALTER TABLE `menu_item` ENABLE KEYS */;

-- 导出  表 advanced.migration 结构
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  advanced.migration 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1465885143),
	('m130524_201442_init', 1465885148),
	('m140506_102106_rbac_init', 1465906972);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- 导出  表 advanced.user 结构
CREATE TABLE IF NOT EXISTS `user` (
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

-- 正在导出表  advanced.user 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `username`, `auth_key`, `password_hash`, `password_reset_token`, `email`, `role`, `status`, `created_at`, `updated_at`) VALUES
	(1, 'tsai', 'YKqK0qNN19pR4q35tzrFzlYCacJb-bYA', '$2y$13$gkgkmDcctltLSahNcqHvrOU6oL/QgW9Q57rBlJmR/.MF6Ec54J0Cu', NULL, 'tsai@163.com', 10, 10, 1465902873, 1465902873),
	(2, 'admin', 'ExcYDHuDa-JPowS44Q9GmjWNlhFiuLJv', '$2y$13$hBWnRjN894Yzmw5uxSpgnuepuOu0RMFA0XgiNHG16DY.rjtOcH4jy', NULL, 'admin@admin.com', 10, 10, 1465985822, 1465985822);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

-- 导出  表 advanced.user_backend 结构
CREATE TABLE IF NOT EXISTS `user_backend` (
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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  advanced.user_backend 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `user_backend` DISABLE KEYS */;
INSERT INTO `user_backend` (`id`, `username`, `auth_key`, `password_hash`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'xHrIurvjnNIM-FNhcb1jKqPCDboPxW8U', '$2y$13$Pou5QI7Qr17ocvCY2N7X9.RMD4nPP5wcn/uX/UYmGkdhTUnYjm/tW', 'admin@admin.com', '2016-06-15 07:34:49', '2016-06-15 07:34:49'),
	(2, 'jack', 'bRGZ1r0HlUQcMTbYpN1QAxtpigXYFc9G', '$2y$13$VrDqHc385gCdp3kkm//5s.4sAYaDQoJRECneCeLH0S.6SHqMwwLhC', 'jack@163.com', '2016-06-14 17:46:01', '2016-06-14 17:46:01'),
	(3, 'test', 'UJPj2Bq21FRKtC3aPWEzT37CMe4chQ1D', '$2y$13$kVtzWQCoPBb/tTOVZVQIz.pnx7863h42BvDdjgBaEDiU97VyNExIC', 'test@test.com', '2016-06-16 21:26:54', '2016-06-16 21:26:54');
/*!40000 ALTER TABLE `user_backend` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
