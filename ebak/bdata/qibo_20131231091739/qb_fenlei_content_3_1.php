<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_content_3`;");
E_C("CREATE TABLE `qb_fenlei_content_3` (
  `rid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` mediumint(7) NOT NULL DEFAULT '0',
  `fid` mediumint(7) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `my_jobs` varchar(30) NOT NULL DEFAULT '',
  `my_nums` varchar(12) NOT NULL DEFAULT '',
  `my_jobabout` mediumtext NOT NULL,
  `my_workplace` varchar(30) NOT NULL DEFAULT '',
  `wage` tinyint(1) NOT NULL DEFAULT '0',
  `sortid` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`rid`),
  KEY `fid` (`fid`),
  KEY `id` (`id`),
  KEY `uid` (`uid`),
  KEY `wage` (`wage`),
  KEY `sortid` (`sortid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_content_3` values('1','33','60','1','北京晋粤湘都餐饮有限责任公司（原名龙河村酒楼）成立于2006年5月26日，坐落在中关村北大街42号（圆明园东门正对面），营业面积达4000多平方米，酒楼以古典风格为主，30多个大小不等的包房，1500多个餐位，五百个宽敞的停车位，更是方便大众。二楼的宴会大厅，可接待各种婚宴，生日宴等大型聚会。 本店经营主要以山西面食、晋菜为主，兼经营山西雁北风味，精美川、湘、粤、淮扬菜，地方官府私房菜，以及应时海鲜。我公司经营有几大招牌菜：精品佛跳墙、沁洲黄小米煮辽参、岁岁平安参、极品鸳鸯燕、鲍汁鲜鱼翅、黄焖四宝及山珍海味、老大同炖羊杂、倒蒜羊肉、天镇风味烧烤、大同香辣兔头、正宗浑源凉粉、香辣烤鱼………… 该酒楼由上海紫萍餐饮管理有限公司专业管理。 总经理王吉海将带领旗下全体员工共创美好未来。 现高薪对社会公开招聘各岗位人员。','收款员','5','会洗碗','北京','3','1');");

require("../../inc/footer.php");
?>