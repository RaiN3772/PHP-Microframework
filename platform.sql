-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 22, 2023 at 04:25 AM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `platform`
--

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `user_id` int NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(16) NOT NULL,
  `info` text NOT NULL,
  KEY `FK_user_id_log` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `permission_id` int NOT NULL AUTO_INCREMENT,
  `permission_name` varchar(255) NOT NULL,
  `permission_title` varchar(255) DEFAULT NULL,
  `permission_description` text,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`permission_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`permission_id`, `permission_name`, `permission_title`, `permission_description`, `created_date`) VALUES
(1, 'root', 'Root', 'Act as the system', '2023-01-20 23:33:50'),
(2, 'admin_panel', 'Admin Panel', 'Can access admin panel?', '2023-01-20 23:33:50'),
(3, 'manage_user', 'User Management', 'Can manage users?', '2023-01-20 23:33:50'),
(4, 'manage_settings', 'Manage Settings', 'Can manage settings?', '2023-04-17 03:28:24'),
(5, 'manage_roles', 'Manage Roles', 'Can manage Roles?', '2023-04-17 18:51:41'),
(6, 'manage_perimissions', 'Manage Permissions', 'Can manage permissions?', '2023-04-18 14:17:21'),
(7, 'manage_users', 'Manage Users', 'Can manage users?', '2023-04-18 16:42:15'),
(8, 'manage_logs', 'Manage Logs', 'Can manage audit logs?', '2023-04-22 06:09:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `role_id` int NOT NULL AUTO_INCREMENT,
  `role_title` varchar(255) NOT NULL,
  `role_description` text,
  PRIMARY KEY (`role_id`),
  KEY `role_title` (`role_title`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`role_id`, `role_title`, `role_description`) VALUES
(1, 'Administrator', 'The highest level role with access to all features, functions, and settings and ability to manage other roles, users, and permissions.'),
(2, 'Registered', 'Default User Role');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

DROP TABLE IF EXISTS `role_permissions`;
CREATE TABLE IF NOT EXISTS `role_permissions` (
  `role_id` int NOT NULL,
  `permission_id` int NOT NULL,
  `assignment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `UNIQUE_role_perm` (`role_id`,`permission_id`),
  KEY `Fk_role_permissionid` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`role_id`, `permission_id`, `assignment_date`) VALUES
(1, 1, '2022-11-08 20:26:51');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci,
  `value` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `key`, `description`, `value`) VALUES
(1, 'website_name', 'This is the name of your website that will be displayed in the browser\'s title bar and in search engine results.', 'Platform'),
(2, 'website_url', 'This is the address of your website, such as \"www.example.com\".', 'localhost'),
(3, 'favicon_url', 'This is a small icon that is displayed in the browser\'s tab or address bar, next to the website name.', '/assets/images/favicon.ico'),
(4, 'logo_url', 'This is an image that represents your website and is typically displayed at the top of every page on your website.', 'https://downloads.rvrealm.com/rv-logos/RVR.png'),
(5, 'deactivate_website', 'When this option is enabled, the site will be locked and visitors will be presented with a message.', 'off'),
(6, 'deactivate_website_msg', 'This is the message that will be displayed to visitors when the website is deactivated.', 'We apologize for the inconvenience, but the platform is currently closed for maintenance. Our team is working to improve the site and will be back online as soon as possible. We apologize for any inconvenience this may cause and appreciate your patience.'),
(7, 'debugging', 'When this option is enabled, error messages will be logged to aid in troubleshooting.', '1'),
(8, 'date_format', 'This field specifies the format in which date and time will be displayed on the website. For example, using the format \'F j, Y\' will output the date as \"January 13, 2023\". You can refer to the link \"https://www.w3schools.com/php/func_date_date_format.asp\" for more information and different options for formatting the date and time.', 'Y-m-d'),
(9, 'website_description', 'A brief summary of your website\'s purpose or content that could be used by search engines to display in search results.', 'Welcome to the Platform'),
(10, 'default_avatar', 'This is the default avatar image that will be used for users who have not set their own avatar.', '/assets/images/blank.png'),
(11, 'user_folder', 'This is the location on the server where the files of the users are stored.', '/uploads/users/'),
(12, 'default_role', 'This is the default role of new members', '2'),
(13, 'deactivate_registration', 'When this option is enabled, the registration will be closed and no new users will be able to create an account', 'off'),
(14, 'minimum_username_length', 'The minimum number of characters a username can be when a user registers', '3'),
(15, 'maximum_username_length', 'The maximum number of characters a username can be when a user registers', '20'),
(16, 'minimum_password_length', 'The minimum number of characters a password should contain', '8'),
(17, 'maximum_password_length', 'The maximum number of characters a password should contain', '30'),
(18, 'complex_password', 'Do you want users to use complex passwords? ', 'off'),
(19, 'failed_logins', 'The number of times to allow someone to attempt to login\r\n', '3'),
(20, 'failed_login_time', 'The amount of time (in seconds) before someone can try to login again, after they have failed to login the first time (600 seconds = 10 mins)', '600'),
(21, 'allow_username_change', 'Can change username?', 'off'),
(22, 'allow_name_change', 'Can change Display name?', 'off'),
(23, 'deactivate_profiles', 'When this option is enabled, the profiles will be deactivated', 'off'),
(24, 'allowed_images_type', 'Determines which types of image files can the user upload', 'png, jpg, jpeg'),
(25, 'allowed_image_size', 'Determines the size of image file can the user upload (in MB)', '3'),
(26, 'allow_email_change', 'Can change Email Address?', 'off');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `failed_logins` int NOT NULL DEFAULT '0',
  `last_failed_login` datetime DEFAULT NULL,
  `last_login` datetime DEFAULT NULL,
  `last_online` datetime DEFAULT NULL,
  `last_ip` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Unknown',
  `register_ip` varchar(255) NOT NULL DEFAULT 'Unknown',
  `avatar` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '/assets/images/blank.png',
  `display_name` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT 'Unknown',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `display_name` (`display_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Triggers `users`
--
DROP TRIGGER IF EXISTS `trg_insert_user_role`;
DELIMITER $$
CREATE TRIGGER `trg_insert_user_role` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO user_roles (user_id, role_id)
    SELECT NEW.id, `value`
    FROM settings
    WHERE `key` = 'default_role';
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `trg_insert_user_settings`;
DELIMITER $$
CREATE TRIGGER `trg_insert_user_settings` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    INSERT INTO user_settings (user_id)
    SELECT NEW.id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
CREATE TABLE IF NOT EXISTS `user_roles` (
  `user_id` int NOT NULL,
  `role_id` int NOT NULL,
  `assignment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY `user_id` (`user_id`,`role_id`),
  KEY `FK_roleid` (`role_id`),
  KEY `FK_userid` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `user_settings`
--

DROP TABLE IF EXISTS `user_settings`;
CREATE TABLE IF NOT EXISTS `user_settings` (
  `user_id` int NOT NULL,
  `private` varchar(3) NOT NULL DEFAULT 'off',
  `hide_email` varchar(3) CHARACTER SET utf8mb4 NOT NULL DEFAULT 'on',
  `hide_online` varchar(3) NOT NULL DEFAULT 'off',
  `hide_login` varchar(3) NOT NULL DEFAULT 'off',
  KEY `FK_user_id_settings` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `auth_attempts`
--

DROP TABLE IF EXISTS `auth_attempts`;
CREATE TABLE IF NOT EXISTS `auth_attempts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(64 NOT NULL,
  `attempts` int NOT NULL DEFAULT '1',
  `last_attempt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`ip_address`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `logs`
--
ALTER TABLE `logs`
  ADD CONSTRAINT `FK_user_id_log` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `Fk_permission_roleid` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Fk_role_permissionid` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`permission_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_roles`
--
ALTER TABLE `user_roles`
  ADD CONSTRAINT `FK_roleid` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_userid` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_settings`
--
ALTER TABLE `user_settings`
  ADD CONSTRAINT `FK_user_id_settings` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
