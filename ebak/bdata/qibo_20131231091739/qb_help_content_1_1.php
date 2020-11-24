<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_help_content_1`;");
E_C("CREATE TABLE `qb_help_content_1` (
  `rid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `subhead` varchar(150) NOT NULL DEFAULT '',
  `id` mediumint(7) NOT NULL DEFAULT '0',
  `fid` mediumint(7) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `topic` tinyint(1) NOT NULL DEFAULT '0',
  `content` mediumtext NOT NULL,
  `orderid` mediumint(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`rid`),
  KEY `aid` (`id`,`topic`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk");
E_D("replace into `qb_help_content_1` values('1','','1','3','1','1','<p>大家只要把以下网址</p><p>http://www_qibosoft_com/do/job.php?job=propagandize&amp;uid=1<br /></p><p>转发给你的好友,或者是各大论坛,只要有人访问了,你就可以获取2个积分的奖励</p><p><br /></p><p>如果用户成功注册的话,还将额外得到5个积分的奖励</p><p><br /></p><p>若成功注册的用户再推荐其它用户的话,不仅他可以得到奖励,你同时也会得到奖励,因为他们都将属于你的下线.</p>','0');");
E_D("replace into `qb_help_content_1` values('2','','2','7','1','1','<p>如题所示,一经发现,严肃处理,并提交相关IP来源信息给公安机关等相关部门处理.</p>','0');");
E_D("replace into `qb_help_content_1` values('3','','3','2','1','1','<p>如果有必要的话,欢迎大家升级为VIP会员,权限更多!!</p>','0');");

require("../../inc/footer.php");
?>