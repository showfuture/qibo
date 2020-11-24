<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_module`;");
E_C("CREATE TABLE `qb_fenlei_module` (
  `id` smallint(4) NOT NULL AUTO_INCREMENT,
  `sort_id` mediumint(5) NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `list` smallint(4) NOT NULL DEFAULT '0',
  `style` varchar(50) NOT NULL DEFAULT '',
  `config` text NOT NULL,
  `config2` text NOT NULL,
  `comment_type` tinyint(1) NOT NULL DEFAULT '0',
  `ifdp` tinyint(1) NOT NULL DEFAULT '0',
  `template` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_module` values('1','0','住宅房','10','','a:1:{s:9:\"moduleSet\";a:1:{s:6:\"useMap\";s:1:\"1\";}}','','1','0','a:4:{s:4:\"list\";s:0:\"\";s:4:\"show\";s:0:\"\";s:4:\"post\";s:0:\"\";s:6:\"search\";s:0:\"\";}');");
E_D("replace into `qb_fenlei_module` values('2','0','一般信息','4','','a:1:{s:9:\"moduleSet\";N;}','','1','0','');");
E_D("replace into `qb_fenlei_module` values('7','0','商用房','9','','a:1:{s:9:\"moduleSet\";a:1:{s:6:\"useMap\";s:1:\"1\";}}','','0','0','');");
E_D("replace into `qb_fenlei_module` values('3','0','招聘','6','','a:1:{s:9:\"moduleSet\";N;}','','0','0','');");
E_D("replace into `qb_fenlei_module` values('4','0','求职','7','','a:1:{s:9:\"moduleSet\";N;}','','0','0','');");
E_D("replace into `qb_fenlei_module` values('5','0','交友','5','','a:1:{s:9:\"moduleSet\";N;}','','0','0','');");
E_D("replace into `qb_fenlei_module` values('6','0','交易','8','','a:1:{s:9:\"moduleSet\";N;}','','0','0','');");
E_D("replace into `qb_fenlei_module` values('13','0','餐饮','0','','a:1:{s:9:\"moduleSet\";a:1:{s:6:\"useMap\";s:1:\"1\";}}','a:6:{s:4:\"fen1\";a:2:{s:4:\"name\";s:4:\"总评\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen2\";a:2:{s:4:\"name\";s:4:\"环境\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen3\";a:2:{s:4:\"name\";s:4:\"服务\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen4\";a:2:{s:4:\"name\";s:4:\"价位\";s:3:\"set\";s:28:\"1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵\";}s:4:\"fen5\";a:2:{s:4:\"name\";s:8:\"喜欢程度\";s:3:\"set\";s:36:\"1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢\";}s:4:\"fen6\";a:2:{s:4:\"name\";s:8:\"环境氛围\";s:3:\"set\";s:68:\"家庭聚会\r\n随便吃吃\r\n情侣约会\r\n商务洽谈\r\n朋友聚会\r\n工作午餐\r\n大型聚会\";}}','0','1','');");
E_D("replace into `qb_fenlei_module` values('14','0','休闲','0','','a:1:{s:9:\"moduleSet\";a:1:{s:6:\"useMap\";i:1;}}','a:6:{s:4:\"fen1\";a:2:{s:4:\"name\";s:4:\"总评\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen2\";a:2:{s:4:\"name\";s:4:\"环境\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen3\";a:2:{s:4:\"name\";s:4:\"服务\";s:3:\"set\";s:36:\"1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好\";}s:4:\"fen4\";a:2:{s:4:\"name\";s:4:\"价位\";s:3:\"set\";s:28:\"1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵\";}s:4:\"fen5\";a:2:{s:4:\"name\";s:8:\"喜欢程度\";s:3:\"set\";s:36:\"1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢\";}s:4:\"fen6\";a:2:{s:4:\"name\";s:8:\"环境氛围\";s:3:\"set\";s:48:\"家庭聚会\r\n情侣约会\r\n商务洽谈\r\n朋友聚会\r\n大型聚会\";}}','0','1','');");

require("../../inc/footer.php");
?>