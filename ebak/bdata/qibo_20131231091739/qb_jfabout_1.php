<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_jfabout`;");
E_C("CREATE TABLE `qb_jfabout` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `fid` mediumint(5) NOT NULL DEFAULT '0',
  `title` varchar(150) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `list` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=gbk");
E_D("replace into `qb_jfabout` values('5','1','用户注册可得{\$webdb[regmoney]}个积分','','0');");
E_D("replace into `qb_jfabout` values('8','2','文章被设置为精华可得{\$webdb[comArticleMoney]}个积分','','0');");
E_D("replace into `qb_jfabout` values('9','1','每个点卡可兑换{\$webdb[MoneyRatio]}个积分,点卡可以通过在线充值获得.','','0');");

require("../../inc/footer.php");
?>