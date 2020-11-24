<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_help_config`;");
E_C("CREATE TABLE `qb_help_config` (
  `c_key` varchar(50) NOT NULL DEFAULT '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY (`c_key`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");
E_D("replace into `qb_help_config` values('Info_metakeywords','帮助中心','');");
E_D("replace into `qb_help_config` values('Info_webOpen','1','');");
E_D("replace into `qb_help_config` values('Info_webname','公告资讯','');");
E_D("replace into `qb_help_config` values('Info_description','','');");
E_D("replace into `qb_help_config` values('module_close','0','');");
E_D("replace into `qb_help_config` values('module_pre','help_','');");
E_D("replace into `qb_help_config` values('module_id','20','');");
E_D("replace into `qb_help_config` values('Info_PostCommentType','0','');");
E_D("replace into `qb_help_config` values('Info_PassCommentType','0','');");
E_D("replace into `qb_help_config` values('Info_ShowCommentRows','','');");

require("../../inc/footer.php");
?>