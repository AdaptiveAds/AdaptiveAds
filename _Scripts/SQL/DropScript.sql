# Author: Josh Preece
# Summary: Restore script to allow easy restoration of the database structure.

SET SQL_MODE='ALLOW_INVALID_DATES';

#CREATE DATABASE IF NOT EXISTS `adaptive_adaptiveads`;

#USE adaptive_adaptiveads;
CREATE DATABASE IF NOT EXISTS `homestead`;
USE homestead;

DROP TABLE IF EXISTS `page`;
DROP TABLE IF EXISTS `template`;
DROP TABLE IF EXISTS `advert`;
DROP TABLE IF EXISTS `transition`;
DROP TABLE IF EXISTS `duration`;
DROP TABLE IF EXISTS `pageData`;