<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_hy_friendlink`;");
E_C("CREATE TABLE `qb_hy_friendlink` (
  `ck_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `username` varchar(16) NOT NULL DEFAULT '',
  `companyName` varchar(64) NOT NULL DEFAULT '',
  `title` varchar(128) NOT NULL DEFAULT '',
  `url` varchar(248) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `yz` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ck_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>