INSERT INTO `qb_hack` (`keywords`, `name`, `isclose`, `author`, `config`, `htmlcode`, `hackfile`, `hacksqltable`, `adminurl`, `about`, `class1`, `class2`, `list`, `linkname`, `isbiz`) VALUES ('crontab', '定时任务', 0, '', '', '', '', '', 'index.php?lfj=crontab&job=list', '', 'other', '插件大全', 0, '', 0);
   
DROP TABLE IF EXISTS `qb_crontab`;
CREATE TABLE `qb_crontab` (
  `id` mediumint(7) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `minutetime` mediumint(4) NOT NULL default '0',
  `daytime` varchar(4) NOT NULL default '0',
  `whiletime` int(10) NOT NULL default '0',
  `lasttime` int(10) NOT NULL default '0',
  `filepath` varchar(50) NOT NULL default '',
  `about` text NOT NULL,
  `ifstop` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `ifstop` (`ifstop`)
) TYPE=MyISAM AUTO_INCREMENT=9 ;

#
# 导出表中的数据 `qb_crontab`
#


INSERT INTO `qb_crontab` VALUES (2, '备份数据库', 0, '0300', 0, 1292489459, 'inc/crontab/mysqlbak.php', '', 1);
INSERT INTO `qb_crontab` VALUES (4, '清空附件表', 0, '', 1296504125, 0, 'inc/crontab/delete_table_upfile.php', '', 1);
    