# Author: Josh Preece
# Summary: Restore script to allow easy restoration of the database structure.

SET SQL_MODE='ALLOW_INVALID_DATES';

# Create a new database
CREATE DATABASE IF NOT EXISTS `adaptive_adaptiveads`;

USE adaptive_adaptiveads;

# Drop all tables if they exist
DROP TABLE IF EXISTS `Page`;
DROP TABLE IF EXISTS `Horizontal_Template`;
DROP TABLE IF EXISTS `Vertical_Template`;
DROP TABLE IF EXISTS `Template`;
DROP TABLE IF EXISTS `Screen`;
DROP TABLE IF EXISTS `User_Location`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Privilage`;
DROP TABLE IF EXISTS `Location`;
DROP TABLE IF EXISTS `Playlist_Advert`;
DROP TABLE IF EXISTS `Advert`;
DROP TABLE IF EXISTS `Transition`;
DROP TABLE IF EXISTS `Duration`;
DROP TABLE IF EXISTS `Page_Data`;
DROP TABLE IF EXISTS `Display_Timing`;
DROP TABLE IF EXISTS `Skin`;
DROP TABLE IF EXISTS `Playlist`;
DROP TABLE IF EXISTS `password_resets`;
DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `duration` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `duration_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `transition` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `transition_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `template_overrides_Skin` tinyint(1) NOT NULL,
  `duration_id` int(10) unsigned NOT NULL,
  `transition_id` int(10) unsigned NOT NULL,
  `is_vertical` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `template_duration_id_foreign` (`duration_id`),
  KEY `template_transition_id_foreign` (`transition_id`),
  CONSTRAINT `template_duration_id_foreign` FOREIGN KEY (`duration_id`) REFERENCES `duration` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `template_transition_id_foreign` FOREIGN KEY (`transition_id`) REFERENCES `transition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `horizontal_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `horizontal_template_template_id_foreign` (`template_id`),
  CONSTRAINT `horizontal_template_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `vertical_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `template_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `vertical_template_template_id_foreign` (`template_id`),
  CONSTRAINT `vertical_template_template_id_foreign` FOREIGN KEY (`template_id`) REFERENCES `template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `advert` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `advert_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `advert_deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `page_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_data_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `page_image` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `page_content` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `page` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `page_data_id` int(10) unsigned NOT NULL,
  `page_index` int(11) NOT NULL,
  `advert_id` int(10) unsigned NOT NULL,
  `vertical_id` int(10) unsigned NOT NULL,
  `horizontal_id` int(10) unsigned NOT NULL,
  `deleted` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_page_data_id_foreign` (`page_data_id`),
  KEY `page_advert_id_foreign` (`advert_id`),
  KEY `page_vertical_id_foreign` (`vertical_id`),
  KEY `page_horizontal_id_foreign` (`horizontal_id`),
  CONSTRAINT `page_advert_id_foreign` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_horizontal_id_foreign` FOREIGN KEY (`horizontal_id`) REFERENCES `horizontal_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_page_data_id_foreign` FOREIGN KEY (`page_data_id`) REFERENCES `page_data` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `page_vertical_id_foreign` FOREIGN KEY (`vertical_id`) REFERENCES `vertical_template` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `display_timing` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `playlist` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `playlist_name` datetime NOT NULL,
  `deleted` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `playlist_advert` (
  `playlist_id` int(10) unsigned NOT NULL,
  `advert_id` int(10) unsigned NOT NULL,
  `advert_index` int(11) NOT NULL,
  `display_timing_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`playlist_id`,`advert_id`),
  KEY `playlist_advert_advert_id_foreign` (`advert_id`),
  KEY `playlist_advert_display_timing_id_foreign` (`display_timing_id`),
  CONSTRAINT `playlist_advert_advert_id_foreign` FOREIGN KEY (`advert_id`) REFERENCES `advert` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `playlist_advert_display_timing_id_foreign` FOREIGN KEY (`display_timing_id`) REFERENCES `display_timing` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `playlist_advert_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `skin` (
  `ID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `skin_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `parent_location` int(11) NOT NULL,
  `skin_id` int(10) unsigned NOT NULL,
  `playlist_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `location_playlist_id_foreign` (`playlist_id`),
  KEY `location_skin_id_foreign` (`skin_id`),
  CONSTRAINT `location_playlist_id_foreign` FOREIGN KEY (`playlist_id`) REFERENCES `playlist` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `location_skin_id_foreign` FOREIGN KEY (`skin_id`) REFERENCES `skin` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `screen` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `is_vertical` tinyint(1) NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `screen_location_id_foreign` (`location_id`),
  CONSTRAINT `screen_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `privilage` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `privilage_level` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `user_location` (
  `user_id` int(10) unsigned NOT NULL,
  `location_id` int(10) unsigned NOT NULL,
  `privilage_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`location_id`),
  KEY `user_location_location_id_foreign` (`location_id`),
  KEY `user_location_privilage_id_foreign` (`privilage_id`),
  CONSTRAINT `user_location_location_id_foreign` FOREIGN KEY (`location_id`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_location_privilage_id_foreign` FOREIGN KEY (`privilage_id`) REFERENCES `privilage` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `user_location_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
