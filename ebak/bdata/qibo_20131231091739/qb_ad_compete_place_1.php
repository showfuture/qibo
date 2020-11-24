<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_ad_compete_place`;");
E_C("CREATE TABLE `qb_ad_compete_place` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL DEFAULT '',
  `isclose` tinyint(1) NOT NULL DEFAULT '0',
  `list` int(10) NOT NULL DEFAULT '0',
  `price` mediumint(5) NOT NULL DEFAULT '0',
  `day` mediumint(4) NOT NULL DEFAULT '0',
  `adnum` smallint(3) NOT NULL DEFAULT '0',
  `wordnum` smallint(3) NOT NULL DEFAULT '0',
  `autoyz` tinyint(1) NOT NULL DEFAULT '1',
  `demourl` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk");
E_D("replace into `qb_ad_compete_place` values('3','顶客页竞价广告','0','0','50','5','8','36','1','');");

require("../../inc/footer.php");
?>