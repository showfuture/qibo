<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_module`;");
E_C("CREATE TABLE `qb_module` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `name` varchar(30) NOT NULL DEFAULT '',
  `pre` varchar(20) NOT NULL DEFAULT '',
  `dirname` varchar(30) NOT NULL DEFAULT '',
  `domain` varchar(100) NOT NULL DEFAULT '',
  `admindir` varchar(20) NOT NULL DEFAULT '',
  `config` text NOT NULL,
  `list` mediumint(5) NOT NULL DEFAULT '0',
  `admingroup` varchar(150) NOT NULL DEFAULT '',
  `adminmember` text NOT NULL,
  `ifclose` tinyint(1) NOT NULL DEFAULT '0',
  `ifsys` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk");
E_D("replace into `qb_module` values('2','2','广告系统','ad_','a_d','','','','0','','','0','0');");
E_D("replace into `qb_module` values('1','2','分类信息','fenlei_','f','','','a:7:{s:12:\"list_PhpName\";s:18:\"list.php?&fid=\$fid\";s:12:\"show_PhpName\";s:29:\"bencandy.php?&fid=\$fid&id=\$id\";s:8:\"MakeHtml\";N;s:14:\"list_HtmlName1\";N;s:14:\"show_HtmlName1\";N;s:14:\"list_HtmlName2\";N;s:14:\"show_HtmlName2\";N;}','80','','','0','1');");
E_D("replace into `qb_module` values('3','2','黄页商铺','hy_','hy','','','a:7:{s:12:\"list_PhpName\";s:18:\"list.php?&fid=\$fid\";s:12:\"show_PhpName\";s:29:\"bencandy.php?&fid=\$fid&id=\$id\";s:8:\"MakeHtml\";N;s:14:\"list_HtmlName1\";N;s:14:\"show_HtmlName1\";N;s:14:\"list_HtmlName2\";N;s:14:\"show_HtmlName2\";N;}','0','','','0','1');");
E_D("replace into `qb_module` values('20','2','公告资讯','help_','help','','','a:7:{s:12:\"list_PhpName\";s:18:\"list.php?&fid=\$fid\";s:12:\"show_PhpName\";s:29:\"bencandy.php?&fid=\$fid&id=\$id\";s:8:\"MakeHtml\";N;s:14:\"list_HtmlName1\";N;s:14:\"show_HtmlName1\";N;s:14:\"list_HtmlName2\";N;s:14:\"show_HtmlName2\";N;}','102','','','0','0');");

require("../../inc/footer.php");
?>