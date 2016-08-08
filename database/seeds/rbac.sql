/*
Navicat MySQL Data Transfer

Source Server         : 127.0.0.1
Source Server Version : 50626
Source Host           : 127.0.0.1:3306
Source Database       : rbac

Target Server Type    : MYSQL
Target Server Version : 50626
File Encoding         : 65001

Date: 2016-08-08 11:25:24
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_password_resets
-- ----------------------------
DROP TABLE IF EXISTS `admin_password_resets`;
CREATE TABLE `admin_password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `admin_password_resets_email_index` (`email`),
  KEY `admin_password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for admin_permissions
-- ----------------------------
DROP TABLE IF EXISTS `admin_permissions`;
CREATE TABLE `admin_permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '菜单父ID',
  `icon` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '图标class',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '权限名,采用route',
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '权限显示名称',
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '描述',
  `is_menu` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否作为菜单显示,[1|0]',
  `sort` tinyint(4) NOT NULL DEFAULT '0' COMMENT '排序',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_permissions
-- ----------------------------
INSERT INTO `admin_permissions` VALUES ('1', '0', 'fa-dashboard', 'admin.index', '首页', 'dashboard', '1', '99', '2016-08-04 19:41:31', '2016-08-04 20:03:25');
INSERT INTO `admin_permissions` VALUES ('2', '0', 'fa-cog', '#system', '系统设置', '设置菜单', '1', '98', '2016-08-04 20:07:46', '2016-08-04 20:07:46');
INSERT INTO `admin_permissions` VALUES ('3', '2', null, 'admin.permission.index', '权限列表', '权限菜单列表', '1', '99', '2016-08-05 10:38:32', '2016-08-05 10:38:32');
INSERT INTO `admin_permissions` VALUES ('4', '3', null, 'admin.permission.create', '添加权限', '添加权限菜单操作', '0', '0', '2016-08-05 10:40:09', '2016-08-05 10:40:09');
INSERT INTO `admin_permissions` VALUES ('5', '3', null, 'admin.permission.edit', '修改权限', '修改权限菜单操作', '0', '0', '2016-08-05 10:40:47', '2016-08-05 10:40:47');
INSERT INTO `admin_permissions` VALUES ('6', '3', null, 'admin.permission.destroy', '删除权限', '删除权限菜单操作', '0', '0', '2016-08-05 10:41:34', '2016-08-05 10:41:34');
INSERT INTO `admin_permissions` VALUES ('7', '2', null, 'admin.role.index', '角色列表', '角色列表展示', '1', '98', '2016-08-05 11:46:33', '2016-08-05 11:46:33');
INSERT INTO `admin_permissions` VALUES ('8', '7', null, 'admin.role.create', '添加角色', '添加角色操作', '0', '0', '2016-08-05 11:59:17', '2016-08-05 11:59:17');
INSERT INTO `admin_permissions` VALUES ('9', '7', null, 'admin.role.edit', '编辑角色', '编辑角色操作', '0', '0', '2016-08-05 11:59:45', '2016-08-05 11:59:45');
INSERT INTO `admin_permissions` VALUES ('10', '7', null, 'admin.role.destroy', '删除角色', '删除角色操作', '0', '0', '2016-08-05 12:00:21', '2016-08-05 12:00:21');
INSERT INTO `admin_permissions` VALUES ('11', '2', null, 'admin.user.index', '用户列表', '用户管理', '1', '97', '2016-08-05 22:16:43', '2016-08-05 22:16:43');
INSERT INTO `admin_permissions` VALUES ('12', '11', null, 'admin.user.create', '添加用户', '添加用户', '0', '0', '2016-08-05 22:17:11', '2016-08-05 22:17:11');
INSERT INTO `admin_permissions` VALUES ('13', '11', null, 'admin.user.edit', '编辑用户', '编辑用户', '0', '0', '2016-08-05 22:17:31', '2016-08-05 22:17:31');
INSERT INTO `admin_permissions` VALUES ('14', '11', null, 'admin.user.destroy', '删除用户', '删除用户', '0', '0', '2016-08-05 22:17:47', '2016-08-05 22:17:47');

-- ----------------------------
-- Table structure for admin_permission_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_permission_role`;
CREATE TABLE `admin_permission_role` (
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `admin_permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `admin_permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `admin_permissions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_permission_role
-- ----------------------------
INSERT INTO `admin_permission_role` VALUES ('1', '1');
INSERT INTO `admin_permission_role` VALUES ('2', '1');
INSERT INTO `admin_permission_role` VALUES ('3', '1');
INSERT INTO `admin_permission_role` VALUES ('4', '1');
INSERT INTO `admin_permission_role` VALUES ('5', '1');
INSERT INTO `admin_permission_role` VALUES ('6', '1');
INSERT INTO `admin_permission_role` VALUES ('7', '1');
INSERT INTO `admin_permission_role` VALUES ('8', '1');
INSERT INTO `admin_permission_role` VALUES ('9', '1');
INSERT INTO `admin_permission_role` VALUES ('10', '1');
INSERT INTO `admin_permission_role` VALUES ('11', '1');
INSERT INTO `admin_permission_role` VALUES ('12', '1');
INSERT INTO `admin_permission_role` VALUES ('13', '1');
INSERT INTO `admin_permission_role` VALUES ('14', '1');
INSERT INTO `admin_permission_role` VALUES ('1', '2');
INSERT INTO `admin_permission_role` VALUES ('2', '2');
INSERT INTO `admin_permission_role` VALUES ('11', '2');
INSERT INTO `admin_permission_role` VALUES ('12', '2');
INSERT INTO `admin_permission_role` VALUES ('13', '2');

-- ----------------------------
-- Table structure for admin_roles
-- ----------------------------
DROP TABLE IF EXISTS `admin_roles`;
CREATE TABLE `admin_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_roles
-- ----------------------------
INSERT INTO `admin_roles` VALUES ('1', 'admin', '管理员', '管理员,权限较大', '2016-08-05 16:22:42', '2016-08-05 18:29:16');
INSERT INTO `admin_roles` VALUES ('2', 'operation', '运营', '运营工作人员', '2016-08-05 19:18:07', '2016-08-05 19:18:07');

-- ----------------------------
-- Table structure for admin_role_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_role_user`;
CREATE TABLE `admin_role_user` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `admin_role_user_role_id_foreign` (`role_id`),
  CONSTRAINT `admin_role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `admin_roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `admin_role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `admin_users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_role_user
-- ----------------------------
INSERT INTO `admin_role_user` VALUES ('1', '1');
INSERT INTO `admin_role_user` VALUES ('1', '2');
INSERT INTO `admin_role_user` VALUES ('2', '2');

-- ----------------------------
-- Table structure for admin_users
-- ----------------------------
DROP TABLE IF EXISTS `admin_users`;
CREATE TABLE `admin_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '用户名',
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '账号邮箱',
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT '密码',
  `is_super` tinyint(4) DEFAULT '0' COMMENT '是否超级管理员',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admin_users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin_users
-- ----------------------------
INSERT INTO `admin_users` VALUES ('1', 'admin', 'admin@admin.com', '$2y$10$d7z1viWm5T2Q9lOeYb5aTuREj0xWiy39lOdHDP6SZxKZeb.oIF0.2', '1', 'Dv3tee98qKqIO7fUbBpewPjOZReHnyNqXuFCWwSk0MGntEAQgkCP2q7zMe57', '2016-07-25 05:56:33', '2016-08-08 11:21:14');
INSERT INTO `admin_users` VALUES ('2', 'test', 'test@test.com', '$2y$10$FsQtMWfKlMoze5g13KMlmeqcUDEW1tcB7ay4v8yS/OAtAH84KyFhe', '0', '7KWWuyDj66SIHXxQDoETd8hDU3oFdnmDdjgTguN12qmJO5TDXiPObVzbpxwq', '2016-08-05 20:40:04', '2016-08-06 11:16:15');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2016_08_02_111257_create_admin_users_table', '1');
INSERT INTO `migrations` VALUES ('2016_08_02_111533_create_admin_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('2016_08_04_110545_entrust_setup_tables', '1');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
