<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_db`;");
E_C("CREATE TABLE `qb_fenlei_db` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `fid` mediumint(7) NOT NULL DEFAULT '0',
  `city_id` mediumint(7) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `fid` (`fid`),
  KEY `city_id` (`city_id`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_db` values('1','11','1','1');");
E_D("replace into `qb_fenlei_db` values('2','11','1','1');");
E_D("replace into `qb_fenlei_db` values('3','11','1','1');");
E_D("replace into `qb_fenlei_db` values('4','11','1','1');");
E_D("replace into `qb_fenlei_db` values('5','11','1','1');");
E_D("replace into `qb_fenlei_db` values('6','11','1','1');");
E_D("replace into `qb_fenlei_db` values('7','12','1','1');");
E_D("replace into `qb_fenlei_db` values('8','12','1','1');");
E_D("replace into `qb_fenlei_db` values('9','12','1','1');");
E_D("replace into `qb_fenlei_db` values('10','12','1','1');");
E_D("replace into `qb_fenlei_db` values('11','12','1','1');");
E_D("replace into `qb_fenlei_db` values('12','12','1','1');");
E_D("replace into `qb_fenlei_db` values('13','12','1','1');");
E_D("replace into `qb_fenlei_db` values('14','12','1','1');");
E_D("replace into `qb_fenlei_db` values('15','25','1','1');");
E_D("replace into `qb_fenlei_db` values('16','25','1','1');");
E_D("replace into `qb_fenlei_db` values('17','25','1','1');");
E_D("replace into `qb_fenlei_db` values('18','19','1','1');");
E_D("replace into `qb_fenlei_db` values('19','19','1','1');");
E_D("replace into `qb_fenlei_db` values('20','19','1','1');");
E_D("replace into `qb_fenlei_db` values('21','19','1','1');");
E_D("replace into `qb_fenlei_db` values('22','19','1','1');");
E_D("replace into `qb_fenlei_db` values('23','19','1','1');");
E_D("replace into `qb_fenlei_db` values('24','19','1','1');");
E_D("replace into `qb_fenlei_db` values('25','11','1','1');");
E_D("replace into `qb_fenlei_db` values('26','11','1','1');");
E_D("replace into `qb_fenlei_db` values('27','11','1','1');");
E_D("replace into `qb_fenlei_db` values('28','25','1','1');");
E_D("replace into `qb_fenlei_db` values('29','25','1','1');");
E_D("replace into `qb_fenlei_db` values('30','25','1','1');");
E_D("replace into `qb_fenlei_db` values('31','25','1','1');");
E_D("replace into `qb_fenlei_db` values('32','129','1','1');");
E_D("replace into `qb_fenlei_db` values('33','60','1','1');");
E_D("replace into `qb_fenlei_db` values('34','26','1','1');");
E_D("replace into `qb_fenlei_db` values('35','31','1','1');");
E_D("replace into `qb_fenlei_db` values('36','30','1','1');");
E_D("replace into `qb_fenlei_db` values('37','24','1','1');");

require("../../inc/footer.php");
?>