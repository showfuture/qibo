<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_field`;");
E_C("CREATE TABLE `qb_fenlei_field` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `mid` mediumint(5) NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `field_name` varchar(30) NOT NULL DEFAULT '',
  `field_type` varchar(15) NOT NULL DEFAULT '',
  `field_leng` smallint(3) NOT NULL DEFAULT '0',
  `orderlist` int(10) NOT NULL DEFAULT '0',
  `form_type` varchar(15) NOT NULL DEFAULT '',
  `field_inputwidth` smallint(3) DEFAULT NULL,
  `field_inputheight` smallint(3) NOT NULL DEFAULT '0',
  `form_set` text NOT NULL,
  `form_value` text NOT NULL,
  `form_units` varchar(30) NOT NULL DEFAULT '',
  `form_title` text NOT NULL,
  `mustfill` tinyint(1) NOT NULL DEFAULT '0',
  `listshow` tinyint(1) NOT NULL DEFAULT '0',
  `listfilter` tinyint(1) DEFAULT NULL,
  `search` tinyint(1) NOT NULL DEFAULT '0',
  `allowview` varchar(255) NOT NULL DEFAULT '',
  `allowpost` varchar(255) NOT NULL DEFAULT '',
  `js_check` text NOT NULL,
  `js_checkmsg` varchar(255) NOT NULL DEFAULT '',
  `classid` mediumint(7) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=138 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_field` values('125','6','附注信息','content','mediumtext','0','7','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('124','6','新旧程度','my_hownew','varchar','12','8','select','0','0','9成新\r\n8成新\r\n7成新\r\n6成新\r\n5成新\r\n4成新\r\n3成新\r\n2成新\r\n1成新\r\n全新','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('122','6','原价','my_outprice','int','10','10','text','5','0','','','元','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('123','6','现价','my_price','int','7','9','text','5','0','','','元','','0','1','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('120','5','自我介绍','content','mediumtext','0','3','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('121','6','交易方式','sortid','varchar','1','11','radio','0','0','1|当面交易\r\n2|网上交易','1','','','1','1','1','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('119','5','学历','schoo_age','int','1','4','select','0','0','1|小学\r\n2|初中\r\n3|高中\r\n4|中专\r\n5|大专\r\n6|本科\r\n7|研究生\r\n8|博士以上','5','','','0','1','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('118','5','条件要求','sortid','int','1','5','radio','0','0','1|漂亮\r\n2|贤慧\r\n3|英俊\r\n4|上进\r\n5|老实','','','','1','1','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('117','5','兴趣爱好','my_interest','varchar','100','6','text','50','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('116','5','从事职业','my_job','varchar','30','7','text','30','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('115','5','体重','my_weight','varchar','15','8','text','3','0','','','公斤','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('114','5','身高','my_height','varchar','8','9','text','3','0','','','CM','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('113','5','年龄','my_age','varchar','8','10','text','2','0','','','岁','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('112','5','性别','my_sex','varchar','4','11','radio','0','0','男\r\n女\r\n保密','保密','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('111','4','自我介绍','content','mediumtext','0','0','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('110','4','期望月薪','my_wage','varchar','30','4','select','0','0','面议\r\n1000元以内\r\n1000元-2000元\r\n2000元-3000元\r\n3000元-4000元\r\n4000元-5000元\r\n5000元以上','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('108','4','工作经验','sortid','int','1','6','radio','0','0','1|应届生\r\n2|一年\r\n3|两年\r\n4|三年以上\r\n','1','','','0','1','1','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('109','4','期望工作城市','my_workplace','varchar','50','5','text','12','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('107','4','性别','my_sex','varchar','4','7','radio','0','0','男\r\n女\r\n保密','保密','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('106','4','年龄','my_age','varchar','8','8','text','2','0','','','岁','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('105','4','学历','my_schoolage','varchar','30','9','select','0','0','小学\r\n初中\r\n高中\r\n中专\r\n大专\r\n本科\r\n研究生\r\n博士以上','大专','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('104','4','期望从事职业','my_jobs','varchar','30','10','text','30','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('103','3','公司介绍','content','mediumtext','0','0','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('102','3','职位技能要求','my_jobabout','mediumtext','255','5','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('101','3','月薪待遇','wage','int','1','6','select','0','0','1|面议\r\n2|1000元以下\r\n3|1000元-2000元\r\n4|2000元-3000元\r\n5|3000元-4000元\r\n6|4000元-5000元\r\n7|5000元以上','1','','','0','1','1','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('100','3','工作地区','my_workplace','varchar','30','7','text','12','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('99','3','招聘人数','my_nums','varchar','12','8','text','5','0','','','人','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('98','3','招聘职位','my_jobs','varchar','30','9','text','30','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('97','3','招聘类型','sortid','varchar','1','10','radio','0','0','1|全职\r\n2|兼职\r\n3|实习','1','','','0','1','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('96','7','附注信息','content','mediumtext','0','0','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('95','7','公交线路','my_bus','varchar','50','4','text','12','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('94','7','附近公交站','my_station','varchar','50','5','text','15','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('93','7','所在楼层','my_floor','varchar','5','6','text','3','0','','','楼','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('92','7','装修情况','my_fitment','varchar','20','7','select','0','0','普通装修\r\n精装修\r\n豪华装修\r\n毛坯房','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('90','7','面积','my_acreage','varchar','12','9','text','5','0','','','平方米','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('91','7','价格','my_price','int','10','8','text','8','0','','','元','','0','1','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('89','7','性质','sortid','int','1','10','radio','0','0','1|个人\r\n2|中介','1','','','1','1','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('88','2','详细信息','content','mediumtext','0','2','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('86','1','附注信息','content','mediumtext','0','1','ieedit','700','300','','','','','0','0','0','0','','','','','31');");
E_D("replace into `qb_fenlei_field` values('87','2','性质','sortid','int','1','3','radio','0','0','1|个人\r\n2|团体\r\n3|企业','1','','','0','1','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('85','1','公交路线','my_bus','varchar','50','2','text','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('84','1','附近公交站','my_station','varchar','100','3','text','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('83','1','所在楼层','my_floor','varchar','12','4','text','4','0','','','楼','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('81','1','室内面积','my_acreage','varchar','12','6','text','5','0','','','平方米','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('82','1','装修情况','my_fitment','varchar','15','5','radio','0','0','普通装修\r\n精装修\r\n豪华装修\r\n毛坯房','普通装修','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('80','1','配套设施','my_peitao','varchar','150','7','checkbox','0','0','水\r\n电\r\n电话\r\n宽带\r\n管道煤气\r\n电梯\r\n家具','水/电','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('79','1','室内布局','my_rooms','varchar','30','8','select','0','0','两室一厅\r\n两室两厅\r\n三室一厅\r\n三室两厅\r\n一室一厅\r\n一居室\r\n三室以上\r\n别墅','','','','0','1','1','0','','','','','1');");
E_D("replace into `qb_fenlei_field` values('78','1','价格','my_price','int','8','9','text','12','0','','','元','','0','1','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('77','1','性质','sortid','int','1','10','radio','0','0','1|个人\r\n2|中介','1','','','0','1','1','1','','','','','1');");
E_D("replace into `qb_fenlei_field` values('126','13','详情','content','mediumtext','0','0','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('127','13','人均消费','sortid','int','3','0','radio','0','0','1|30元以下\r\n2|30~50元\r\n3|50~100元\r\n4|100~150元\r\n5|150~200元\r\n6|200~300元\r\n7|300元以上','1','','','0','0','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('128','13','环境','sortid2','int','3','0','radio','0','0','1|家庭聚会\r\n2|随便吃吃\r\n3|情侣约会\r\n4|商务洽谈\r\n5|朋友聚会\r\n6|工作午餐\r\n7|大型聚会','1','','','0','0','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('129','13','停车位','my_228','int','1','0','radio','0','0','1|免费\r\n2|收费\r\n3|无\r\n4|未知','4','','','0','0','1','1','','','','','1');");
E_D("replace into `qb_fenlei_field` values('130','13','公交线路','my_837','varchar','100','0','text','30','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('131','13','附近公交站','my_613','varchar','100','0','text','50','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('132','14','详情','content','mediumtext','0','0','textarea','0','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('133','14','人均消费','sortid','int','3','0','radio','0','0','1|30元以下\r\n2|30~50元\r\n3|50~100元\r\n4|100~150元\r\n5|150~200元\r\n6|200~300元\r\n7|300元以上','1','','','0','0','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('134','14','环境','sortid2','int','3','0','radio','0','0','1|家庭聚会\r\n2|随便吃吃\r\n3|情侣约会\r\n4|商务洽谈\r\n5|朋友聚会\r\n6|工作午餐\r\n7|大型聚会','1','','','0','0','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('135','14','停车位','my_382','int','1','0','radio','0','0','1|免费\r\n2|收费\r\n3|无\r\n4|未知','4','','','0','0','1','1','','','','','0');");
E_D("replace into `qb_fenlei_field` values('136','14','公交线路','my_835','varchar','100','0','text','30','0','','','','','0','0','0','0','','','','','0');");
E_D("replace into `qb_fenlei_field` values('137','14','附近公交站','my_491','varchar','100','0','text','30','0','','','','','0','0','0','0','','','','','1');");

require("../../inc/footer.php");
?>