<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_hy_config`;");
E_C("CREATE TABLE `qb_hy_config` (
  `c_key` varchar(50) NOT NULL DEFAULT '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY (`c_key`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");
E_D("replace into `qb_hy_config` values('Info_webOpen','1','');");
E_D("replace into `qb_hy_config` values('sort_layout','1,5#3,8,7#2,4,6#','');");
E_D("replace into `qb_hy_config` values('Private_tpl_foot','','');");
E_D("replace into `qb_hy_config` values('Private_tpl_head','','');");
E_D("replace into `qb_hy_config` values('gg_map_api','ABQIAAAAlNgPp05cAGeYiuhUaYZaQxTW052HFKp4AKcN41m_fnJmItJl4BQhSQXzWfwAcbC1Q-Vv7Wfd9hCL4g','');");
E_D("replace into `qb_hy_config` values('IF_Private_tpl','0','');");
E_D("replace into `qb_hy_config` values('module_id','3','');");
E_D("replace into `qb_hy_config` values('vipselfdomaincannot','','');");
E_D("replace into `qb_hy_config` values('vipselfdomain','','');");
E_D("replace into `qb_hy_config` values('creat_home_money','0','');");
E_D("replace into `qb_hy_config` values('module_pre','hy_','');");
E_D("replace into `qb_hy_config` values('Index_listsortnum','3','');");
E_D("replace into `qb_hy_config` values('module_close','0','');");
E_D("replace into `qb_hy_config` values('Info_webname','╩фрЁилфл','');");
E_D("replace into `qb_hy_config` values('HyRewrite','0','');");

require("../../inc/footer.php");
?>