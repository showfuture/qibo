<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_template`;");
E_C("CREATE TABLE `qb_template` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `type` smallint(4) NOT NULL DEFAULT '0',
  `filepath` varchar(100) NOT NULL DEFAULT '',
  `descrip` text NOT NULL,
  `list` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=gbk");
E_D("replace into `qb_template` values('5','头部白板','7','template/default/none.htm','','0');");
E_D("replace into `qb_template` values('6','底部白板','8','template/default/none.htm','','0');");
E_D("replace into `qb_template` values('23','文章列表页(左宽右窄)','2','template/default/list.htm','','0');");
E_D("replace into `qb_template` values('22','内容页(左宽右窄)','3','template/default/bencandy.htm','','0');");
E_D("replace into `qb_template` values('24','主页(左宽右窄)','1','template/default/index.htm','','0');");
E_D("replace into `qb_template` values('20','内容页(上下型)','3','template/default/bencandy_tpl_2.htm','','0');");
E_D("replace into `qb_template` values('21','独立页','9','template/default/alonepage.htm','','0');");

require("../../inc/footer.php");
?>