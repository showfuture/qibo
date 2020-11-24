INSERT INTO `qb_hack` VALUES ('propagandize', '推广赚取积分功能', 0, '', '', '', '', '', 'index.php?lfj=propagandize&job=list', '', 'other', '其它功能', 8, '', 0);


CREATE TABLE `qb_propagandize` (
  `id` int(10) NOT NULL auto_increment,
  `uid` mediumint(7) NOT NULL default '0',
  `ip` bigint(11) NOT NULL default '0',
  `day` smallint(3) NOT NULL default '0',
  `posttime` int(10) NOT NULL default '0',
  `fromurl` varchar(150) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `day` (`day`,`uid`,`ip`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
