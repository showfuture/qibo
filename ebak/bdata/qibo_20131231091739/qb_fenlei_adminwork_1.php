<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_adminwork`;");
E_C("CREATE TABLE `qb_fenlei_adminwork` (
  `aid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `type` varchar(30) NOT NULL DEFAULT '',
  `id` mediumint(7) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ifpm` tinyint(1) NOT NULL DEFAULT '0',
  `fen` smallint(4) NOT NULL DEFAULT '0',
  `reason` text NOT NULL,
  `posttime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `type` (`type`),
  KEY `id` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>