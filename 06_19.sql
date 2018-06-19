# Host: localhost  (Version 5.5.5-10.1.9-MariaDB)
# Date: 2018-06-19 17:17:19
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
# Structure for table "tbl_data"
#

DROP TABLE IF EXISTS `tbl_data`;
CREATE TABLE `tbl_data` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `videoCategory` int(11) NOT NULL DEFAULT '0',
  `videoType` varchar(255) NOT NULL DEFAULT '',
  `videoURL` varchar(255) NOT NULL DEFAULT '',
  `thumbnailURL` varchar(255) NOT NULL DEFAULT '',
  `videoPreviewURL` varchar(255) NOT NULL DEFAULT '',
  `video360BackgroundURL` varchar(255) DEFAULT NULL,
  `videoTitle` varchar(255) DEFAULT NULL,
  `videoSubTitle` varchar(255) DEFAULT NULL,
  `videoDescription` varchar(255) NOT NULL DEFAULT '',
  `videoDuration` varchar(255) DEFAULT NULL,
  `videoCredit` varchar(255) DEFAULT NULL,
  `fileName` varchar(255) DEFAULT NULL,
  `isPaid` varchar(3) DEFAULT NULL,
  `price` float(4,2) DEFAULT NULL,
  `PaidUnit` varchar(255) DEFAULT NULL,
  `captureTime` int(11) DEFAULT NULL,
  `PinToTop` varchar(3) DEFAULT NULL,
  `VideoViews` int(11) DEFAULT NULL,
  `videoSubtitleShowTime` float(10,5) DEFAULT NULL,
  `videoSubtitleEndTime` float(10,5) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "tbl_data"
#


#
# Structure for table "tbl_type"
#

DROP TABLE IF EXISTS `tbl_type`;
CREATE TABLE `tbl_type` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "tbl_type"
#

INSERT INTO `tbl_type` VALUES (1,'Featured','2017-11-23','2017-11-23'),(2,'Travel','2017-11-23','2018-06-08'),(3,'Adventure','2017-11-23','2018-06-08'),(4,'Sports','2018-06-08','2018-06-08'),(5,'Gaming','2018-06-11','2018-06-11');

#
# Structure for table "tbl_video"
#

DROP TABLE IF EXISTS `tbl_video`;
CREATE TABLE `tbl_video` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `videoTitle` varchar(255) DEFAULT NULL,
  `videoCredit` varchar(255) DEFAULT NULL,
  `videoDescription` varchar(255) DEFAULT NULL,
  `videoCategory` varchar(255) DEFAULT NULL,
  `videoPreviewURL` varchar(255) DEFAULT NULL,
  `thumbnailURL` varchar(255) DEFAULT NULL,
  `video360BackgroundURL` varchar(255) DEFAULT NULL,
  `videoType` varchar(255) DEFAULT NULL,
  `videoURL` varchar(255) DEFAULT NULL,
  `videoViews` int(11) DEFAULT NULL,
  `isPaid` tinyint(3) DEFAULT NULL,
  `price` float(5,2) DEFAULT NULL,
  `priceUnit` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#
# Data for table "tbl_video"
#

