<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_pic`;");
E_C("CREATE TABLE `qb_fenlei_pic` (
  `pid` mediumint(7) NOT NULL AUTO_INCREMENT,
  `id` mediumint(10) NOT NULL DEFAULT '0',
  `fid` mediumint(7) NOT NULL DEFAULT '0',
  `mid` smallint(4) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `imgurl` varchar(150) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`pid`),
  KEY `id` (`id`),
  KEY `fid` (`fid`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_pic` values('1','1','11','0','1','0','http://pic.58.com/p1/big/n_6734506480129.jpg','');");
E_D("replace into `qb_fenlei_pic` values('2','1','11','0','1','0','http://pic.58.com/p1/big/n_6734508713986.jpg','');");
E_D("replace into `qb_fenlei_pic` values('3','1','11','0','1','0','http://pic.58.com/p1/big/n_6734511689476.jpg','');");
E_D("replace into `qb_fenlei_pic` values('4','1','11','0','1','0','http://pic.58.com/p1/big/n_6734471650562.jpg','');");
E_D("replace into `qb_fenlei_pic` values('5','1','11','0','1','0','http://pic.58.com/p1/big/n_6734518066946.jpg','');");
E_D("replace into `qb_fenlei_pic` values('6','1','11','0','1','0','http://pic.58.com/p1/big/n_6734520442626.jpg','');");
E_D("replace into `qb_fenlei_pic` values('7','1','11','0','1','0','http://pic.58.com/p1/big/n_6734524643841.jpg','');");
E_D("replace into `qb_fenlei_pic` values('8','2','11','0','1','0','http://pic.58.com/p1/big/n_6677318701828.jpg','');");
E_D("replace into `qb_fenlei_pic` values('9','2','11','0','1','0','http://pic.58.com/p1/big/n_6677317915396.jpg','');");
E_D("replace into `qb_fenlei_pic` values('10','2','11','0','1','0','http://pic.58.com/p1/big/n_6677276803586.jpg','');");
E_D("replace into `qb_fenlei_pic` values('11','3','11','0','1','0','http://pic.58.com/p1/big/n_6669086810625.jpg','');");
E_D("replace into `qb_fenlei_pic` values('12','3','11','0','1','0','http://pic.58.com/p1/big/n_6669094643458.jpg','');");
E_D("replace into `qb_fenlei_pic` values('13','3','11','0','1','0','http://pic.58.com/p1/big/n_6669102120962.jpg','');");
E_D("replace into `qb_fenlei_pic` values('14','3','11','0','1','0','http://pic.58.com/p1/big/n_6669117145858.jpg','');");
E_D("replace into `qb_fenlei_pic` values('15','3','11','0','1','0','http://pic.58.com/p1/big/n_6669109559044.jpg','');");
E_D("replace into `qb_fenlei_pic` values('16','4','11','0','1','0','http://pic.58.com/p1/big/n_6776884899585.jpg','');");
E_D("replace into `qb_fenlei_pic` values('17','4','11','0','1','0','http://pic.58.com/p1/big/n_6776877710852.jpg','');");
E_D("replace into `qb_fenlei_pic` values('18','4','11','0','1','0','http://pic.58.com/p1/big/n_6776878775809.jpg','');");
E_D("replace into `qb_fenlei_pic` values('19','5','11','0','1','0','http://pic.58.com/p1/big/n_6675172719362.jpg','');");
E_D("replace into `qb_fenlei_pic` values('20','5','11','0','1','0','http://pic.58.com/p1/big/n_6675127980802.jpg','');");
E_D("replace into `qb_fenlei_pic` values('21','6','11','0','1','0','http://pic.58.com/p1/big/n_6274044757249.jpg','');");
E_D("replace into `qb_fenlei_pic` values('22','6','11','0','1','0','http://pic.58.com/p1/big/n_6274014898178.jpg','');");
E_D("replace into `qb_fenlei_pic` values('23','6','11','0','1','0','http://pic.58.com/p1/big/n_6274027778306.jpg','');");
E_D("replace into `qb_fenlei_pic` values('24','6','11','0','1','0','http://pic.58.com/p1/big/n_6274060408068.jpg','');");
E_D("replace into `qb_fenlei_pic` values('25','7','12','0','1','0','http://pic.58.com/p1/big/n_6629233098498.jpg','');");
E_D("replace into `qb_fenlei_pic` values('26','7','12','0','1','0','http://pic.58.com/p1/big/n_6629279272962.jpg','');");
E_D("replace into `qb_fenlei_pic` values('27','8','12','0','1','0','http://pic.58.com/p1/big/n_6756913455618.jpg','');");
E_D("replace into `qb_fenlei_pic` values('28','8','12','0','1','0','http://pic.58.com/p1/big/n_6756914729730.jpg','');");
E_D("replace into `qb_fenlei_pic` values('29','8','12','0','1','0','http://pic.58.com/p1/big/n_6756871945730.jpg','');");
E_D("replace into `qb_fenlei_pic` values('30','8','12','0','1','0','http://pic.58.com/p1/big/n_6756918049796.jpg','');");
E_D("replace into `qb_fenlei_pic` values('31','9','12','0','1','0','http://pic.58.com/p1/big/n_6648791474433.jpg','');");
E_D("replace into `qb_fenlei_pic` values('32','9','12','0','1','0','http://pic.58.com/p1/big/n_6648799507202.jpg','');");
E_D("replace into `qb_fenlei_pic` values('33','9','12','0','1','0','http://pic.58.com/p1/big/n_6648800388356.jpg','');");
E_D("replace into `qb_fenlei_pic` values('34','10','12','0','1','0','http://pic.58.com/p1/big/n_5923400835588.jpg','');");
E_D("replace into `qb_fenlei_pic` values('35','10','12','0','1','0','http://pic.58.com/p1/big/n_5923402491138.jpg','');");
E_D("replace into `qb_fenlei_pic` values('36','10','12','0','1','0','http://pic.58.com/p1/big/n_5923379162114.jpg','');");
E_D("replace into `qb_fenlei_pic` values('37','10','12','0','1','0','http://pic.58.com/p1/big/n_5923404312066.jpg','');");
E_D("replace into `qb_fenlei_pic` values('38','10','12','0','1','0','http://pic.58.com/p1/big/n_5923405158404.jpg','');");
E_D("replace into `qb_fenlei_pic` values('39','10','12','0','1','0','http://pic.58.com/p1/big/n_5923405762817.jpg','');");
E_D("replace into `qb_fenlei_pic` values('40','11','12','0','1','0','http://pic.58.com/p1/big/n_6543150205444.jpg','');");
E_D("replace into `qb_fenlei_pic` values('41','11','12','0','1','0','http://pic.58.com/p1/big/n_6543157596673.jpg','');");
E_D("replace into `qb_fenlei_pic` values('42','11','12','0','1','0','http://pic.58.com/p1/big/n_6543160072961.jpg','');");
E_D("replace into `qb_fenlei_pic` values('43','11','12','0','1','0','http://pic.58.com/p1/big/n_6543123519234.jpg','');");
E_D("replace into `qb_fenlei_pic` values('44','12','12','0','1','0','http://pic.58.com/p1/big/n_6695274413313.jpg','');");
E_D("replace into `qb_fenlei_pic` values('45','12','12','0','1','0','http://pic.58.com/p1/big/n_6695230392834.jpg','');");
E_D("replace into `qb_fenlei_pic` values('46','12','12','0','1','0','http://pic.58.com/p1/big/n_6695279130369.jpg','');");
E_D("replace into `qb_fenlei_pic` values('47','12','12','0','1','0','http://pic.58.com/p1/big/n_6695238440706.jpg','');");
E_D("replace into `qb_fenlei_pic` values('48','13','12','0','1','0','http://pic.58.com/p1/big/n_6651860091394.jpg','');");
E_D("replace into `qb_fenlei_pic` values('49','13','12','0','1','0','http://pic.58.com/p1/big/n_6651863946754.jpg','');");
E_D("replace into `qb_fenlei_pic` values('50','13','12','0','1','0','http://pic.58.com/p1/big/n_6651868582657.jpg','');");
E_D("replace into `qb_fenlei_pic` values('51','13','12','0','1','0','http://pic.58.com/p1/big/n_6651879048194.jpg','');");
E_D("replace into `qb_fenlei_pic` values('52','13','12','0','1','0','http://pic.58.com/p1/big/n_6651894885889.jpg','');");
E_D("replace into `qb_fenlei_pic` values('53','13','12','0','1','0','http://pic.58.com/p1/big/n_6651881218306.jpg','');");
E_D("replace into `qb_fenlei_pic` values('54','14','12','0','1','0','http://pic.58.com/p1/big/n_6273115439620.jpg','');");
E_D("replace into `qb_fenlei_pic` values('55','14','12','0','1','0','http://pic.58.com/p1/big/n_6273081732354.jpg','');");
E_D("replace into `qb_fenlei_pic` values('56','14','12','0','1','0','http://pic.58.com/p1/big/n_6273116459524.jpg','');");
E_D("replace into `qb_fenlei_pic` values('57','14','12','0','1','0','http://pic.58.com/p1/big/n_6273084650754.jpg','');");
E_D("replace into `qb_fenlei_pic` values('58','15','25','0','1','0','http://pic.58.com/p1/big/n_6668288325380.jpg','');");
E_D("replace into `qb_fenlei_pic` values('59','15','25','0','1','0','http://pic.58.com/p1/big/n_6668243447298.jpg','');");
E_D("replace into `qb_fenlei_pic` values('60','16','25','0','1','0','http://pic.58.com/p1/big/n_5847911041538.jpg','');");
E_D("replace into `qb_fenlei_pic` values('61','16','25','0','1','0','http://pic.58.com/p1/big/n_5847913764356.jpg','');");
E_D("replace into `qb_fenlei_pic` values('62','16','25','0','1','0','http://pic.58.com/p1/big/n_5847894684162.jpg','');");
E_D("replace into `qb_fenlei_pic` values('63','16','25','0','1','0','http://pic.58.com/p1/big/n_5847939890436.jpg','');");
E_D("replace into `qb_fenlei_pic` values('64','16','25','0','1','0','http://pic.58.com/p1/big/n_5847920633858.jpg','');");
E_D("replace into `qb_fenlei_pic` values('65','16','25','0','1','0','http://pic.58.com/p1/big/n_5847955339777.jpg','');");
E_D("replace into `qb_fenlei_pic` values('66','17','25','0','1','0','http://pic.58.com/p1/big/n_6547264688642.jpg','');");
E_D("replace into `qb_fenlei_pic` values('67','17','25','0','1','0','http://pic.58.com/p1/big/n_6547269359874.jpg','');");
E_D("replace into `qb_fenlei_pic` values('68','18','19','0','1','0','http://pic.58.com/p1/big/n_6761542190084.jpg','');");
E_D("replace into `qb_fenlei_pic` values('69','18','19','0','1','0','http://pic.58.com/p1/big/n_6761537635844.jpg','');");
E_D("replace into `qb_fenlei_pic` values('70','19','19','0','1','0','http://pic.58.com/p1/big/n_6674458128129.jpg','');");
E_D("replace into `qb_fenlei_pic` values('71','19','19','0','1','0','http://pic.58.com/p1/big/n_6674449699330.jpg','');");
E_D("replace into `qb_fenlei_pic` values('72','20','19','0','1','0','http://pic.58.com/p1/big/n_6579165722369.jpg','');");
E_D("replace into `qb_fenlei_pic` values('73','20','19','0','1','0','http://pic.58.com/p1/big/n_6579148441858.jpg','');");
E_D("replace into `qb_fenlei_pic` values('74','20','19','0','1','0','http://pic.58.com/p1/big/n_6579261257218.jpg','');");
E_D("replace into `qb_fenlei_pic` values('75','20','19','0','1','0','http://pic.58.com/p1/big/n_6579209917186.jpg','');");
E_D("replace into `qb_fenlei_pic` values('76','20','19','0','1','0','http://pic.58.com/p1/big/n_6579249465090.jpg','');");
E_D("replace into `qb_fenlei_pic` values('77','20','19','0','1','0','http://pic.58.com/p1/big/n_6579248914946.jpg','');");
E_D("replace into `qb_fenlei_pic` values('78','21','19','0','1','0','http://pic.58.com/p1/big/n_6777321068802.jpg','');");
E_D("replace into `qb_fenlei_pic` values('79','21','19','0','1','0','http://pic.58.com/p1/big/n_6777283788546.jpg','');");
E_D("replace into `qb_fenlei_pic` values('80','21','19','0','1','0','http://pic.58.com/p1/big/n_6777313677060.jpg','');");
E_D("replace into `qb_fenlei_pic` values('81','21','19','0','1','0','http://pic.58.com/p1/big/n_6777269783554.jpg','');");
E_D("replace into `qb_fenlei_pic` values('82','22','19','0','1','0','http://pic.58.com/p1/big/n_5914324988418.jpg','');");
E_D("replace into `qb_fenlei_pic` values('83','22','19','0','1','0','http://pic.58.com/p1/big/n_5914322499330.jpg','');");
E_D("replace into `qb_fenlei_pic` values('84','22','19','0','1','0','http://pic.58.com/p1/big/n_5914321671684.jpg','');");
E_D("replace into `qb_fenlei_pic` values('85','22','19','0','1','0','http://pic.58.com/p1/big/n_5914320547332.jpg','');");
E_D("replace into `qb_fenlei_pic` values('86','22','19','0','1','0','http://pic.58.com/p1/big/n_5914326906372.jpg','');");
E_D("replace into `qb_fenlei_pic` values('87','22','19','0','1','0','http://pic.58.com/p1/big/n_5914325925634.jpg','');");
E_D("replace into `qb_fenlei_pic` values('88','23','19','0','1','0','http://pic.58.com/p1/big/n_6228552039169.jpg','');");
E_D("replace into `qb_fenlei_pic` values('89','23','19','0','1','0','http://pic.58.com/p1/big/n_6228540864002.jpg','');");
E_D("replace into `qb_fenlei_pic` values('90','23','19','0','1','0','http://pic.58.com/p1/big/n_6228514492162.jpg','');");
E_D("replace into `qb_fenlei_pic` values('91','23','19','0','1','0','http://pic.58.com/p1/big/n_6228527664898.jpg','');");
E_D("replace into `qb_fenlei_pic` values('92','24','19','0','1','0','http://pic.58.com/p1/big/n_2840474831617.jpg','');");
E_D("replace into `qb_fenlei_pic` values('93','25','11','0','1','0','http://pic.58.com/p1/big/n_6676699118849.jpg','');");
E_D("replace into `qb_fenlei_pic` values('94','25','11','0','1','0','http://pic.58.com/p1/big/n_6676701816834.jpg','');");
E_D("replace into `qb_fenlei_pic` values('95','25','11','0','1','0','http://pic.58.com/p1/big/n_6676702116353.jpg','');");
E_D("replace into `qb_fenlei_pic` values('96','25','11','0','1','0','http://pic.58.com/p1/big/n_6676658765826.jpg','');");
E_D("replace into `qb_fenlei_pic` values('97','25','11','0','1','0','http://pic.58.com/p1/big/n_6676703413762.jpg','');");
E_D("replace into `qb_fenlei_pic` values('98','25','11','0','1','0','http://pic.58.com/p1/big/n_6676703170561.jpg','');");
E_D("replace into `qb_fenlei_pic` values('99','26','11','0','1','0','http://pic.58.com/p1/big/n_6669667112193.jpg','');");
E_D("replace into `qb_fenlei_pic` values('100','26','11','0','1','0','http://pic.58.com/p1/big/n_6669663453186.jpg','');");
E_D("replace into `qb_fenlei_pic` values('101','27','11','0','1','0','http://pic.58.com/p1/big/n_6675030029058.jpg','');");
E_D("replace into `qb_fenlei_pic` values('102','27','11','0','1','0','http://pic.58.com/p1/big/n_6675006245377.jpg','');");
E_D("replace into `qb_fenlei_pic` values('103','28','25','0','1','0','http://pic.58.com/p1/big/n_6734044924418.jpg','');");
E_D("replace into `qb_fenlei_pic` values('104','28','25','0','1','0','http://pic.58.com/p1/big/n_6734089378818.jpg','');");
E_D("replace into `qb_fenlei_pic` values('105','28','25','0','1','0','http://pic.58.com/p1/big/n_6734092457473.jpg','');");
E_D("replace into `qb_fenlei_pic` values('106','28','25','0','1','0','http://pic.58.com/p1/big/n_6734090518785.jpg','');");
E_D("replace into `qb_fenlei_pic` values('107','29','25','0','1','0','http://pic.58.com/p1/big/n_4233931316737.jpg','');");
E_D("replace into `qb_fenlei_pic` values('108','30','25','0','1','0','http://pic.58.com/p1/big/n_6755839858689.jpg','');");
E_D("replace into `qb_fenlei_pic` values('109','30','25','0','1','0','http://pic.58.com/p1/big/n_6755798215938.jpg','');");
E_D("replace into `qb_fenlei_pic` values('110','31','25','0','1','0','http://pic.58.com/p1/big/n_6777091359492.jpg','');");
E_D("replace into `qb_fenlei_pic` values('111','32','129','0','1','0','http://pic.58.com/p1/big/n_6777574838529.jpg','');");
E_D("replace into `qb_fenlei_pic` values('112','33','60','0','1','0','http://pic.58.com/p1/big/n_6668047451908.jpg','');");
E_D("replace into `qb_fenlei_pic` values('113','34','26','0','1','0','http://pic.58.com/p1/big/n_6762676355074.jpg','');");
E_D("replace into `qb_fenlei_pic` values('114','35','31','0','1','0','http://pic.58.com/p1/big/n_5042078629889.jpg','');");
E_D("replace into `qb_fenlei_pic` values('115','36','30','0','1','0','http://pic.58.com/p1/big/n_6778448960516.jpg','');");
E_D("replace into `qb_fenlei_pic` values('116','37','24','0','1','0','http://pic.58.com/p1/big/n_6780653510658.jpg','');");
E_D("replace into `qb_fenlei_pic` values('117','44','11','0','1','0','qb_fenlei_/11/1_20120830110821_kqluk.jpg','');");
E_D("replace into `qb_fenlei_pic` values('118','44','11','0','1','0','qb_fenlei_/11/1_20120830110821_oe7ls.jpg','');");

require("../../inc/footer.php");
?>