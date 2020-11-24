<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_hy_guestbook`;");
E_C("CREATE TABLE `qb_hy_guestbook` (
  `id` int(7) NOT NULL AUTO_INCREMENT,
  `cuid` mediumint(7) NOT NULL DEFAULT '0',
  `uid` int(7) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `yz` tinyint(1) NOT NULL DEFAULT '0',
  `posttime` int(16) NOT NULL DEFAULT '0',
  `list` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `cuid` (`cuid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>