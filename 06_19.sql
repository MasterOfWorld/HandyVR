# Host: localhost  (Version 5.5.5-10.1.9-MariaDB)
# Date: 2018-06-25 15:45:48
# Generator: MySQL-Front 6.0  (Build 2.20)


#
# Structure for table "tbl_admin"
#

DROP TABLE IF EXISTS `tbl_admin`;
CREATE TABLE `tbl_admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "tbl_admin"
#

INSERT INTO `tbl_admin` VALUES (1,'admin@admin.com','$2y$10$JIG72vnThCVxGMnKJVb3ButXa0tBuHeNw4fTn61tpZpFpDjC/.8aq','2017-09-30','2017-09-30');

#
# Structure for table "vr_adv"
#

DROP TABLE IF EXISTS `vr_adv`;
CREATE TABLE `vr_adv` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `adv_img` varchar(255) DEFAULT NULL,
  `adv_link` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "vr_adv"
#


#
# Structure for table "vr_categories"
#

DROP TABLE IF EXISTS `vr_categories`;
CREATE TABLE `vr_categories` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `category_name` varchar(255) DEFAULT NULL,
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `en` varchar(255) DEFAULT NULL,
  `ko` varchar(255) DEFAULT NULL,
  `zh_CN` varchar(255) DEFAULT NULL,
  `ja` varchar(255) DEFAULT NULL,
  `fr` varchar(255) DEFAULT NULL,
  `de` varchar(255) DEFAULT NULL,
  `pt_PT` varchar(255) DEFAULT NULL,
  `zh_TW` varchar(255) DEFAULT NULL,
  `it` varchar(255) DEFAULT NULL,
  `ru` varchar(255) DEFAULT NULL,
  `pl` varchar(255) DEFAULT NULL,
  `hu` varchar(255) DEFAULT NULL,
  `ar` varchar(255) DEFAULT NULL,
  `th` varchar(255) DEFAULT NULL,
  `es` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

#
# Data for table "vr_categories"
#

/*!40000 ALTER TABLE `vr_categories` DISABLE KEYS */;
INSERT INTO `vr_categories` VALUES (1,'Adventure','2018-06-22','2018-06-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Fantastic','2018-06-22','2018-06-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Tourist','2018-06-22','2018-06-22',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `vr_categories` ENABLE KEYS */;

#
# Structure for table "vr_hotel_config"
#

DROP TABLE IF EXISTS `vr_hotel_config`;
CREATE TABLE `vr_hotel_config` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(255) DEFAULT NULL,
  `hotel_cinemaview_bkg` varchar(255) DEFAULT NULL,
  `restericted_passcode` int(11) DEFAULT NULL,
  `bypassWiFiLock` int(11) DEFAULT NULL,
  `activate` int(11) DEFAULT NULL,
  `nfc_email_hotel` int(11) DEFAULT NULL,
  `nfc_email_address` varchar(255) DEFAULT NULL,
  `nfc_pm_guest` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "vr_hotel_config"
#


#
# Structure for table "vr_video"
#

DROP TABLE IF EXISTS `vr_video`;
CREATE TABLE `vr_video` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `video_type` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `file_name` varchar(255) DEFAULT NULL,
  `video_thumbnail_url` varchar(255) DEFAULT NULL,
  `video_preview_type` varchar(255) DEFAULT NULL,
  `video_preview_capture_time` varchar(255) DEFAULT NULL,
  `video_preview_url` varchar(255) DEFAULT NULL,
  `video_background_url` varchar(255) DEFAULT NULL,
  `video_views` varchar(255) DEFAULT NULL,
  `paid` varchar(11) DEFAULT NULL,
  `pin_to_top` varchar(11) DEFAULT NULL,
  `allow_download` varchar(11) DEFAULT NULL,
  `restricted_content` int(11) DEFAULT NULL,
  `updated` datetime DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

#
# Data for table "vr_video"
#


#
# Structure for table "vr_video_category"
#

DROP TABLE IF EXISTS `vr_video_category`;
CREATE TABLE `vr_video_category` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `vr_video_id` int(11) DEFAULT NULL,
  `vr_category_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_category"
#


#
# Structure for table "vr_video_currency"
#

DROP TABLE IF EXISTS `vr_video_currency`;
CREATE TABLE `vr_video_currency` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_currency"
#

/*!40000 ALTER TABLE `vr_video_currency` DISABLE KEYS */;
INSERT INTO `vr_video_currency` VALUES (1,'HKD'),(2,'JPY');
/*!40000 ALTER TABLE `vr_video_currency` ENABLE KEYS */;

#
# Structure for table "vr_video_details"
#

DROP TABLE IF EXISTS `vr_video_details`;
CREATE TABLE `vr_video_details` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `vr_video_id` int(11) DEFAULT NULL,
  `locale` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `credit` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `duration` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_details"
#


#
# Structure for table "vr_video_list"
#

DROP TABLE IF EXISTS `vr_video_list`;
CREATE TABLE `vr_video_list` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `vr_video_id` int(11) DEFAULT NULL,
  `hotel_id` int(11) DEFAULT NULL,
  `bypass_paid` int(11) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_list"
#


#
# Structure for table "vr_video_payment"
#

DROP TABLE IF EXISTS `vr_video_payment`;
CREATE TABLE `vr_video_payment` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `device_user_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `transcation_id` int(11) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_time` time DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_payment"
#


#
# Structure for table "vr_video_price"
#

DROP TABLE IF EXISTS `vr_video_price`;
CREATE TABLE `vr_video_price` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `vr_video_id` int(11) DEFAULT NULL,
  `currency_id` int(11) DEFAULT NULL,
  `price` float(3,2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_price"
#


#
# Structure for table "vr_video_subtitle"
#

DROP TABLE IF EXISTS `vr_video_subtitle`;
CREATE TABLE `vr_video_subtitle` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `subtitle_id` int(11) DEFAULT NULL,
  `video_id` int(11) DEFAULT NULL,
  `subtitle_lang` varchar(255) DEFAULT NULL,
  `subtitle_content` varchar(255) DEFAULT NULL,
  `subtitle_show_time` float(10,2) DEFAULT NULL,
  `subtitle_end_time` float(10,2) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "vr_video_subtitle"
#

