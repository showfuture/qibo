<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_hy_mysort`;");
E_C("CREATE TABLE `qb_hy_mysort` (
  `ms_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uid` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `sortname` char(32) NOT NULL DEFAULT '',
  `fup` int(10) unsigned NOT NULL DEFAULT '0',
  `listorder` int(8) unsigned NOT NULL DEFAULT '0',
  `ctype` tinyint(1) NOT NULL DEFAULT '1',
  `hits` int(8) unsigned NOT NULL DEFAULT '0',
  `best` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ms_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>