<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_ad_compete_user`;");
E_C("CREATE TABLE `qb_ad_compete_user` (
  `ad_id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `begintime` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `money` mediumint(6) NOT NULL DEFAULT '0',
  `id` mediumint(7) NOT NULL DEFAULT '0',
  `yz` tinyint(1) NOT NULL DEFAULT '1',
  `adlink` varchar(200) NOT NULL DEFAULT '',
  `adword` varchar(255) NOT NULL DEFAULT '',
  `hits` mediumint(7) NOT NULL DEFAULT '0',
  `color` varchar(20) NOT NULL DEFAULT '',
  `fonttype` tinyint(1) NOT NULL DEFAULT '0',
  `city_id` mediumint(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ad_id`),
  KEY `id` (`id`,`endtime`,`money`,`yz`,`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk");
E_D("replace into `qb_ad_compete_user` values('11','1','admin','1239277578','1239709578','50','3','1','http://www.php168.com/','P8╧ы╥╫у╬','0','','0','0');");
E_D("replace into `qb_ad_compete_user` values('12','1','admin','1239279810','1239711810','50','3','1','http://www.php168.com/bbs','P8╧ы╥╫бшлЁ','0','','0','0');");

require("../../inc/footer.php");
?>