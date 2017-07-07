-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.6.10 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- 导出 kerwin 的数据库结构
CREATE DATABASE IF NOT EXISTS `kerwin` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `kerwin`;

-- 导出  表 kerwin.admin_log 结构
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

-- 正在导出表  kerwin.admin_log 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `admin_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `admin_log` ENABLE KEYS */;

-- 导出  表 kerwin.auth_assignment 结构
CREATE TABLE IF NOT EXISTS `auth_assignment` (
  `item_name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`item_name`,`user_id`),
  CONSTRAINT `auth_assignment_ibfk_1` FOREIGN KEY (`item_name`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  kerwin.auth_assignment 的数据：~1 rows (大约)
/*!40000 ALTER TABLE `auth_assignment` DISABLE KEYS */;
INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES
	('test', '2', 1499154854);
/*!40000 ALTER TABLE `auth_assignment` ENABLE KEYS */;

-- 导出  表 kerwin.auth_item 结构
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

-- 正在导出表  kerwin.auth_item 的数据：~29 rows (大约)
/*!40000 ALTER TABLE `auth_item` DISABLE KEYS */;
INSERT INTO `auth_item` (`name`, `type`, `description`, `rule_name`, `data`, `created_at`, `updated_at`) VALUES
	('/admin-log/index', 2, '日志列表', NULL, NULL, 1499096458, 1499096458),
	('/blog/create', 2, '博客添加', NULL, NULL, 1490181000, 1499148667),
	('/blog/delete', 2, '博客删除', NULL, NULL, 1490181166, 1490181166),
	('/blog/index', 2, '博客列表', NULL, NULL, 1490180955, 1490180955),
	('/blog/update', 2, '博客更新', NULL, NULL, 1490181120, 1490181120),
	('/blog/view', 2, '博客详情', NULL, NULL, 1490181146, 1490181146),
	('/category/create', 2, '分类添加', NULL, NULL, 1499096125, 1499096125),
	('/category/delete', 2, '分类删除', NULL, NULL, 1499096171, 1499096171),
	('/category/index', 2, '分类列表', NULL, NULL, 1499096058, 1499096058),
	('/category/update', 2, '分类更新', NULL, NULL, 1499096154, 1499096154),
	('/category/view', 2, '分类详情', NULL, NULL, 1499150122, 1499150122),
	('/rbac/menu/create', 2, '菜单添加', NULL, NULL, 1487733184, 1487733184),
	('/rbac/menu/delete', 2, '菜单删除', NULL, NULL, 1487733239, 1487733239),
	('/rbac/menu/index', 2, '菜单列表', NULL, NULL, 1487676156, 1487676156),
	('/rbac/menu/update', 2, '菜单更新', NULL, NULL, 1487733219, 1487733219),
	('/rbac/permission/create', 2, '权限添加', NULL, NULL, 1487733155, 1499098008),
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
	('sysadmin', 1, '系统管理员', NULL, NULL, 1487676207, 1499150133),
	('test', 1, '测试员', NULL, NULL, 1490181213, 1499154796);
/*!40000 ALTER TABLE `auth_item` ENABLE KEYS */;

-- 导出  表 kerwin.auth_item_child 结构
CREATE TABLE IF NOT EXISTS `auth_item_child` (
  `parent` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `child` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`),
  CONSTRAINT `auth_item_child_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `auth_item_child_ibfk_2` FOREIGN KEY (`child`) REFERENCES `auth_item` (`name`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  kerwin.auth_item_child 的数据：~35 rows (大约)
/*!40000 ALTER TABLE `auth_item_child` DISABLE KEYS */;
INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
	('sysadmin', '/admin-log/index'),
	('sysadmin', '/blog/create'),
	('sysadmin', '/blog/delete'),
	('sysadmin', '/blog/index'),
	('test', '/blog/index'),
	('sysadmin', '/blog/update'),
	('sysadmin', '/blog/view'),
	('test', '/blog/view'),
	('sysadmin', '/category/create'),
	('sysadmin', '/category/delete'),
	('sysadmin', '/category/index'),
	('test', '/category/index'),
	('sysadmin', '/category/update'),
	('sysadmin', '/category/view'),
	('test', '/category/view'),
	('sysadmin', '/rbac/menu/create'),
	('sysadmin', '/rbac/menu/delete'),
	('sysadmin', '/rbac/menu/index'),
	('test', '/rbac/menu/index'),
	('sysadmin', '/rbac/menu/update'),
	('sysadmin', '/rbac/permission/create'),
	('sysadmin', '/rbac/permission/delete'),
	('sysadmin', '/rbac/permission/index'),
	('test', '/rbac/permission/index'),
	('sysadmin', '/rbac/permission/update'),
	('sysadmin', '/rbac/role/create'),
	('sysadmin', '/rbac/role/delete'),
	('sysadmin', '/rbac/role/index'),
	('test', '/rbac/role/index'),
	('sysadmin', '/rbac/role/update'),
	('sysadmin', '/rbac/user-backend/delete'),
	('sysadmin', '/rbac/user-backend/index'),
	('test', '/rbac/user-backend/index'),
	('sysadmin', '/rbac/user-backend/signup'),
	('sysadmin', '/rbac/user-backend/update');
/*!40000 ALTER TABLE `auth_item_child` ENABLE KEYS */;

-- 导出  表 kerwin.auth_rule 结构
CREATE TABLE IF NOT EXISTS `auth_rule` (
  `name` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `data` text COLLATE utf8_unicode_ci,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  kerwin.auth_rule 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `auth_rule` DISABLE KEYS */;
/*!40000 ALTER TABLE `auth_rule` ENABLE KEYS */;

-- 导出  表 kerwin.blog 结构
CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '标题',
  `content` text COMMENT '博客内容',
  `user_id` int(11) NOT NULL COMMENT '创建博客的用户id',
  `edit_id` int(11) DEFAULT NULL COMMENT '修改博客的用户id',
  `tags` varchar(100) DEFAULT NULL COMMENT '标签',
  `category` int(3) NOT NULL COMMENT '分类',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  kerwin.blog 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `blog` DISABLE KEYS */;
/*!40000 ALTER TABLE `blog` ENABLE KEYS */;

-- 导出  表 kerwin.category 结构
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '分类名字',
  `count` int(11) NOT NULL DEFAULT '0' COMMENT '文章数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `image_url` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='分类';

-- 正在导出表  kerwin.category 的数据：0 rows
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
/*!40000 ALTER TABLE `category` ENABLE KEYS */;

-- 导出  表 kerwin.menu 结构
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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- 正在导出表  kerwin.menu 的数据：~9 rows (大约)
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` (`id`, `name`, `parent`, `route`, `order`, `data`) VALUES
	(1, '系统管理', NULL, NULL, NULL, '{"icon":"fa fa-gears","visible":"true"}'),
	(2, '用户管理', 1, '/rbac/user-backend/index', NULL, '{"icon":"fa fa-user","visible":"true"}'),
	(3, '角色管理', 1, '/rbac/role/index', NULL, '{"icon":"fa fa-users","visible":"true"}'),
	(4, '权限管理', 1, '/rbac/permission/index', NULL, '{"icon":"fa fa-lock","visible":"true"}'),
	(5, '菜单管理', 1, '/rbac/menu/index', NULL, '{"icon":"fa fa-th-list","visible":"true"}'),
	(6, '文章管理', NULL, NULL, NULL, '{"icon":"fa fa-book","visible":"true"}'),
	(7, '文章列表', 6, '/blog/index', NULL, '{"icon":"fa fa-list-alt","visible":"true"}'),
	(8, '操作日志', 1, '/admin-log/index', NULL, '{"icon":"fa fa-file-text","visible":"true"}'),
	(9, '博客分类', 6, '/category/index', NULL, '{"icon":"fa fa-folder","visible":"true"}');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;

-- 导出  表 kerwin.menu_item 结构
CREATE TABLE IF NOT EXISTS `menu_item` (
  `menu_id` int(11) NOT NULL,
  `item_name` varchar(64) NOT NULL,
  UNIQUE KEY `menu_item` (`menu_id`,`item_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='菜单权限关联表';

-- 正在导出表  kerwin.menu_item 的数据：~27 rows (大约)
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
	(4, '/rbac/permission/create'),
	(4, '/rbac/permission/delete'),
	(4, '/rbac/permission/index'),
	(4, '/rbac/permission/update'),
	(5, '/rbac/menu/create'),
	(5, '/rbac/menu/delete'),
	(5, '/rbac/menu/index'),
	(5, '/rbac/menu/update'),
	(7, '/blog/create'),
	(7, '/blog/delete'),
	(7, '/blog/index'),
	(7, '/blog/update'),
	(7, '/blog/view'),
	(8, '/admin-log/index'),
	(9, '/category/create'),
	(9, '/category/delete'),
	(9, '/category/index'),
	(9, '/category/update'),
	(9, '/category/view');
/*!40000 ALTER TABLE `menu_item` ENABLE KEYS */;

-- 导出  表 kerwin.migration 结构
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 正在导出表  kerwin.migration 的数据：~3 rows (大约)
/*!40000 ALTER TABLE `migration` DISABLE KEYS */;
INSERT INTO `migration` (`version`, `apply_time`) VALUES
	('m000000_000000_base', 1465885143),
	('m130524_201442_init', 1465885148),
	('m140506_102106_rbac_init', 1465906972);
/*!40000 ALTER TABLE `migration` ENABLE KEYS */;

-- 导出  表 kerwin.tags 结构
CREATE TABLE IF NOT EXISTS `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '标签名字',
  `count` int(11) NOT NULL COMMENT '文章数量',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='标签';

-- 正在导出表  kerwin.tags 的数据：0 rows
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;

-- 导出  表 kerwin.tag_map 结构
CREATE TABLE IF NOT EXISTS `tag_map` (
  `tag_id` int(11) NOT NULL COMMENT '标签id',
  `blog_id` int(11) NOT NULL COMMENT '博客id',
  UNIQUE KEY `blog_tag` (`tag_id`,`blog_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='标签映射表';

-- 正在导出表  kerwin.tag_map 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `tag_map` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_map` ENABLE KEYS */;

-- 导出  表 kerwin.user_backend 结构
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  kerwin.user_backend 的数据：~2 rows (大约)
/*!40000 ALTER TABLE `user_backend` DISABLE KEYS */;
INSERT INTO `user_backend` (`id`, `username`, `auth_key`, `password_hash`, `email`, `created_at`, `updated_at`) VALUES
	(1, 'admin', 'xHrIurvjnNIM-FNhcb1jKqPCDboPxW8U', '$2y$13$sxIiDu1eLiTlNT4eW/jhpuDaS6yAfTuQlngL2jfwwT8ELv6vDws6C', 'admin@admin.com', '2016-06-15 07:34:49', '2016-06-15 07:34:49'),
	(2, 'test', 'UJPj2Bq21FRKtC3aPWEzT37CMe4chQ1D', '$2y$13$kVtzWQCoPBb/tTOVZVQIz.pnx7863h42BvDdjgBaEDiU97VyNExIC', 'test@test.com', '2016-06-16 21:26:54', '2016-06-16 21:26:54');
/*!40000 ALTER TABLE `user_backend` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
