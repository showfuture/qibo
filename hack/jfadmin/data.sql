INSERT INTO `qb_hack` (`keywords`, `name`, `isclose`, `author`, `config`, `htmlcode`, `hackfile`, `hacksqltable`, `adminurl`, `about`, `class1`, `class2`, `list`, `linkname`, `isbiz`) VALUES ('jfadmin_mod', '积分介绍管理', 0, '', '', '', '', '', 'index.php?lfj=jfadmin&job=listjf', '', 'other', '其它功能', 7, '', 0);


CREATE TABLE `qb_jfabout` (
  `id` mediumint(7) NOT NULL auto_increment,
  `fid` mediumint(5) NOT NULL default '0',
  `title` varchar(150) NOT NULL default '',
  `content` text NOT NULL,
  `list` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=10 ;

#
# 导出表中的数据 `qb_jfabout`
#

INSERT INTO `qb_jfabout` VALUES (6, 2, '发表文章可得{$webdb[postArticleMoney]}个积分', '只有审核后的文章才可得积分,没审核的文章不得积分.', 0);
INSERT INTO `qb_jfabout` VALUES (7, 2, '删除文章扣除{$webdb[deleteArticleMoney]}个积分', '', 0);
INSERT INTO `qb_jfabout` VALUES (5, 1, '用户注册可得{$webdb[regmoney]}个积分', '', 0);
INSERT INTO `qb_jfabout` VALUES (8, 2, '文章被设置为精华可得{$webdb[comArticleMoney]}个积分', '', 0);
INSERT INTO `qb_jfabout` VALUES (9, 1, '每个点卡可兑换{$webdb[MoneyRatio]}个积分,点卡可以通过在线充值获得.', '', 0);



CREATE TABLE `qb_jfsort` (
  `fid` mediumint(5) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `list` int(10) NOT NULL default '0',
  PRIMARY KEY  (`fid`)
) TYPE=MyISAM AUTO_INCREMENT=3 ;

#
# 导出表中的数据 `qb_jfsort`
#

INSERT INTO `qb_jfsort` VALUES (1, '会员中心', 0);
INSERT INTO `qb_jfsort` VALUES (2, '文章中心', 0);



