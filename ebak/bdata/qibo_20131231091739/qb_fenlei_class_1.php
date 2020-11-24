<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_class`;");
E_C("CREATE TABLE `qb_fenlei_class` (
  `fid` int(7) NOT NULL AUTO_INCREMENT,
  `fup` int(7) NOT NULL DEFAULT '0',
  `name` varchar(60) NOT NULL DEFAULT '',
  `list` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`fid`),
  KEY `fup` (`fup`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_class` values('31','0','岗位类型','1');");
E_D("replace into `qb_fenlei_class` values('32','31','计算机/互联网类','0');");
E_D("replace into `qb_fenlei_class` values('33','31','人力资源/行政/文职人员','0');");
E_D("replace into `qb_fenlei_class` values('34','31','医疗卫生/美容保健','0');");
E_D("replace into `qb_fenlei_class` values('38','34','护士/护理人员','0');");
E_D("replace into `qb_fenlei_class` values('37','34','医生/医师','0');");
E_D("replace into `qb_fenlei_class` values('39','33','文员/秘书','0');");
E_D("replace into `qb_fenlei_class` values('40','33','行政/人力资源总监','0');");
E_D("replace into `qb_fenlei_class` values('41','32','软件工程师','0');");
E_D("replace into `qb_fenlei_class` values('42','32','硬件工程师','0');");

require("../../inc/footer.php");
?>