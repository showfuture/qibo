<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_admin_menu`;");
E_C("CREATE TABLE `qb_admin_menu` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `fid` mediumint(5) NOT NULL DEFAULT '0',
  `name` text NOT NULL,
  `linkurl` varchar(150) NOT NULL DEFAULT '',
  `color` varchar(15) NOT NULL DEFAULT '',
  `target` tinyint(1) NOT NULL DEFAULT '0',
  `list` smallint(4) NOT NULL DEFAULT '0',
  `groupid` mediumint(5) NOT NULL DEFAULT '0',
  `iftier` tinyint(1) NOT NULL DEFAULT '0',
  `ifcompany` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `groupid` (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=154 DEFAULT CHARSET=gbk");
E_D("replace into `qb_admin_menu` values('87','0','重要功能','','','0','7','3','0','0');");
E_D("replace into `qb_admin_menu` values('90','87','首页分类布局设置','index.php?lfj=module_admin&dirname=f&file=center&job=settable','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('144','0','参数设置','','','0','8','3','0','0');");
E_D("replace into `qb_admin_menu` values('145','144','全局参数设置','index.php?lfj=center&job=config','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('146','144','分类相关参数','index.php?lfj=module_admin&dirname=f&file=center&job=post','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('147','87','更新首页标签','index.php?lfj=module_admin&dirname=f&file=center&job=label','','0','10','3','0','0');");
E_D("replace into `qb_admin_menu` values('148','87','分类信息管理','index.php?lfj=module_admin&dirname=f&file=list&job=list','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('149','87','评论管理','index.php?lfj=module_admin&dirname=f&file=comment&job=list','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('150','87','分类栏目管理','index.php?lfj=module_admin&dirname=f&file=sort&job=listsort','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('151','87','城市地区管理','index.php?lfj=module_admin&dirname=f&file=city&job=city','','0','0','3','0','0');");
E_D("replace into `qb_admin_menu` values('152','87','友情链接管理','index.php?lfj=module_admin&dirname=f&file=friendlink&job=list','','0','0','3','0','0');");

require("../../inc/footer.php");
?>