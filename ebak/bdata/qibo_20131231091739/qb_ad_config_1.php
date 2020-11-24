<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_ad_config`;");
E_C("CREATE TABLE `qb_ad_config` (
  `c_key` varchar(50) NOT NULL DEFAULT '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY (`c_key`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");
E_D("replace into `qb_ad_config` values('module_pre','ad_','');");
E_D("replace into `qb_ad_config` values('Info_webOpen','1','');");
E_D("replace into `qb_ad_config` values('module_id','24','');");
E_D("replace into `qb_ad_config` values('module_close','0','');");
E_D("replace into `qb_ad_config` values('Info_webname','广告系统','');");

require("../../inc/footer.php");
?>