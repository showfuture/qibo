<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_alonepage`;");
E_C("CREATE TABLE `qb_alonepage` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `fid` mediumint(5) NOT NULL DEFAULT '0',
  `name` varchar(100) NOT NULL DEFAULT '',
  `title` varchar(100) NOT NULL DEFAULT '',
  `posttime` int(10) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `username` varchar(30) NOT NULL DEFAULT '',
  `style` varchar(15) NOT NULL DEFAULT '',
  `tpl_head` varchar(50) NOT NULL DEFAULT '',
  `tpl_main` varchar(50) NOT NULL DEFAULT '',
  `tpl_foot` varchar(50) NOT NULL DEFAULT '',
  `filename` varchar(100) DEFAULT NULL,
  `filepath` varchar(30) NOT NULL DEFAULT '',
  `descrip` text NOT NULL,
  `keywords` varchar(255) NOT NULL DEFAULT '',
  `content` text NOT NULL,
  `hits` int(7) NOT NULL DEFAULT '0',
  `ishtml` tinyint(1) NOT NULL DEFAULT '0',
  `city_id` mediumint(7) NOT NULL DEFAULT '0',
  `ifclose` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `city_id` (`city_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk");
E_D("replace into `qb_alonepage` values('1','0','友情链接','友情链接','1229507597','0','','','','','','friendlink.htm','','','','<table cellSpacing=4 cellPadding=4 width=\"100%\" border=0>\r\n<tbody>\r\n<tr>\r\n<td width=\"20%\"><a href=\"http://www.mmcbbs.com/\" target=_blank>菁菁论坛</a></td>\r\n<td width=\"20%\"><a href=\"http://www.liuv.net/\" target=_blank>流水设计</a></td>\r\n<td width=\"20%\"><a href=\"http://pic.goodod.com/\" target=_blank>欧迪手机图片</a></td>\r\n<td width=\"20%\"><a href=\"http://www.tianyakezhan.com/\" target=_blank>天涯客栈</a></td>\r\n<td width=\"20%\"><a href=\"http://www.czin.cn/\" target=_blank>崇左热线</a></td></tr>\r\n<tr>\r\n<td width=\"20%\"><a href=\"http://www.jneg.com.cn/\" target=_blank>金能家园</a></td>\r\n<td width=\"20%\"><a href=\"http://www.wyrj.com/\" target=_blank>屋檐人家</a></td>\r\n<td width=\"20%\"><a href=\"http://www.nenbei.com/\" target=_blank>嫩北网</a></td>\r\n<td width=\"20%\"><a href=\"http://www.photosbar.com/\" target=_blank>图吧</a></td>\r\n<td width=\"20%\"><a href=\"http://www.ok586.cn/\" target=_blank>视览供销</a></td></tr>\r\n<tr>\r\n<td width=\"20%\"><a href=\"http://www.51solo.net/\" target=_blank>我爱搜罗娱乐</a></td>\r\n<td width=\"20%\"><a href=\"http://www.toopd.com/\" target=_blank>飞羽设计</a></td>\r\n<td width=\"20%\"><a href=\"http://www.qiqig.com/\" target=_blank>爱雅</a></td>\r\n<td width=\"20%\"><a href=\"http://www.jxsrjys.com.cn/\" target=_blank>上饶教研</a></td>\r\n<td width=\"20%\"><a href=\"http://www.unok.net/\" target=_blank>优盟网</a></td></tr>\r\n<tr>\r\n<td width=\"20%\"><a href=\"http://mmm.pudou.com/\" target=_blank>扑豆中国</a></td>\r\n<td width=\"20%\"><a href=\"http://www.itzhan.com/\" target=_blank>IT中文</a></td>\r\n<td width=\"20%\"><a href=\"http://www.hkwtv.com/\" target=_blank>香港网视</a></td>\r\n<td width=\"20%\">&nbsp;</td>\r\n<td width=\"20%\">&nbsp;</td></tr></tbody></table>','54','0','0','0');");

require("../../inc/footer.php");
?>