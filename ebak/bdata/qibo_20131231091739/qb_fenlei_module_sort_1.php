<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_module_sort`;");
E_C("CREATE TABLE `qb_fenlei_module_sort` (
  `sort_id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `sort_name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`sort_id`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");

require("../../inc/footer.php");
?>