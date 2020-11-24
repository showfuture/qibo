<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_content_4`;");
E_C("CREATE TABLE `qb_fenlei_content_4` (
  `rid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` mediumint(7) NOT NULL DEFAULT '0',
  `fid` mediumint(7) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `sortid` tinyint(1) NOT NULL DEFAULT '0',
  `my_jobs` varchar(30) NOT NULL DEFAULT '',
  `my_schoolage` varchar(30) NOT NULL DEFAULT '',
  `my_sex` varchar(4) NOT NULL DEFAULT '',
  `my_age` varchar(8) NOT NULL DEFAULT '',
  `my_workplace` varchar(50) NOT NULL DEFAULT '',
  `my_wage` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`rid`),
  KEY `fid` (`fid`),
  KEY `id` (`id`),
  KEY `uid` (`uid`),
  KEY `sortid` (`sortid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>