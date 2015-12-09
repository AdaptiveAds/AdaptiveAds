# Author: Josh Preece
# Summary: Restore script to allow easy restoration of the database structure.

SET SQL_MODE='ALLOW_INVALID_DATES';

#CREATE DATABASE IF NOT EXISTS `adaptive_adaptiveads`;

#USE adaptive_adaptiveads;
CREATE DATABASE IF NOT EXISTS `adaptive_adaptiveads`;
USE adaptive_adaptiveads;

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
DROP TABLE IF EXISTS `migrations`;