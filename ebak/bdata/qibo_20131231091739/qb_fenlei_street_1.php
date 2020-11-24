<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_street`;");
E_C("CREATE TABLE `qb_fenlei_street` (
  `fid` mediumint(7) unsigned NOT NULL AUTO_INCREMENT,
  `fup` mediumint(7) unsigned NOT NULL DEFAULT '0',
  `name` varchar(200) NOT NULL DEFAULT '',
  `class` smallint(4) NOT NULL DEFAULT '0',
  `sons` smallint(4) NOT NULL DEFAULT '0',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `admin` varchar(100) NOT NULL DEFAULT '',
  `list` int(10) NOT NULL DEFAULT '0',
  `listorder` tinyint(2) NOT NULL DEFAULT '0',
  `passwd` varchar(32) NOT NULL DEFAULT '',
  `logo` varchar(150) NOT NULL DEFAULT '',
  `descrip` text NOT NULL,
  `style` varchar(50) NOT NULL DEFAULT '',
  `template` text NOT NULL,
  `jumpurl` varchar(150) NOT NULL DEFAULT '',
  `maxperpage` tinyint(3) NOT NULL DEFAULT '0',
  `metakeywords` varchar(255) NOT NULL DEFAULT '',
  `metadescription` varchar(255) NOT NULL DEFAULT '',
  `allowcomment` tinyint(1) NOT NULL DEFAULT '0',
  `allowpost` varchar(150) NOT NULL DEFAULT '',
  `allowviewtitle` varchar(150) NOT NULL DEFAULT '',
  `allowviewcontent` varchar(150) NOT NULL DEFAULT '',
  `allowdownload` varchar(150) NOT NULL DEFAULT '',
  `forbidshow` tinyint(1) NOT NULL DEFAULT '0',
  `config` text NOT NULL,
  `dirname` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`fid`),
  KEY `fup` (`fup`)
) ENGINE=MyISAM AUTO_INCREMENT=129 DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_street` values('1','1','北太平庄','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BeiTaiPingZhuang');");
E_D("replace into `qb_fenlei_street` values('2','1','大钟寺','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaZhongSi');");
E_D("replace into `qb_fenlei_street` values('3','1','定慧寺','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DingHuiSi');");
E_D("replace into `qb_fenlei_street` values('4','1','甘家口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GanJiaKou');");
E_D("replace into `qb_fenlei_street` values('5','1','公主坟','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GongZhuFen');");
E_D("replace into `qb_fenlei_street` values('6','1','航天桥','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HangTianQiao');");
E_D("replace into `qb_fenlei_street` values('7','1','健翔桥','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JianXiangQiao');");
E_D("replace into `qb_fenlei_street` values('8','1','蓝靛厂','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LanDianChang');");
E_D("replace into `qb_fenlei_street` values('9','1','马甸','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','MaDian');");
E_D("replace into `qb_fenlei_street` values('10','1','清河','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','QingHe');");
E_D("replace into `qb_fenlei_street` values('11','1','上地','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangDi');");
E_D("replace into `qb_fenlei_street` values('12','1','上庄','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangZhuang');");
E_D("replace into `qb_fenlei_street` values('13','1','四季青','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','SiJiQing');");
E_D("replace into `qb_fenlei_street` values('14','1','魏公村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WeiGongCun');");
E_D("replace into `qb_fenlei_street` values('15','1','西二旗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiErQi');");
E_D("replace into `qb_fenlei_street` values('16','1','五道口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuDaoKou');");
E_D("replace into `qb_fenlei_street` values('17','1','西三旗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiSanQi');");
E_D("replace into `qb_fenlei_street` values('18','1','西直门','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiZhiMen');");
E_D("replace into `qb_fenlei_street` values('19','1','外香山','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WaiXiangShan');");
E_D("replace into `qb_fenlei_street` values('20','1','学院路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XueYuanLu');");
E_D("replace into `qb_fenlei_street` values('21','1','玉泉路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuQuanLu');");
E_D("replace into `qb_fenlei_street` values('22','1','圆明园','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuanMingYuan');");
E_D("replace into `qb_fenlei_street` values('23','1','中关村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongGuanCun');");
E_D("replace into `qb_fenlei_street` values('24','73','荔湾湖','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LiWanHu');");
E_D("replace into `qb_fenlei_street` values('25','73','沙面','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShaMian');");
E_D("replace into `qb_fenlei_street` values('26','73','流花','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LiuHua');");
E_D("replace into `qb_fenlei_street` values('27','73','上下九地区','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangXiaJiuDiQu');");
E_D("replace into `qb_fenlei_street` values('28','73','陈家祠','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChenJia');");
E_D("replace into `qb_fenlei_street` values('29','73','中山七八路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanQiBaLu');");
E_D("replace into `qb_fenlei_street` values('30','73','西关','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiGuan');");
E_D("replace into `qb_fenlei_street` values('31','73','芳村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','FangCun');");
E_D("replace into `qb_fenlei_street` values('32','73','坑口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','KengKou');");
E_D("replace into `qb_fenlei_street` values('33','73','窖口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiaoKou');");
E_D("replace into `qb_fenlei_street` values('34','73','东风西','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengXi');");
E_D("replace into `qb_fenlei_street` values('35','73','宝华路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaoHuaLu');");
E_D("replace into `qb_fenlei_street` values('36','73','鹤洞新村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HeDongXinCun');");
E_D("replace into `qb_fenlei_street` values('37','73','周门','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhouMen');");
E_D("replace into `qb_fenlei_street` values('38','73','彩虹戏院','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','CaiHongXiYuan');");
E_D("replace into `qb_fenlei_street` values('39','73','黄沙','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangSha');");
E_D("replace into `qb_fenlei_street` values('40','74','北京路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BeiJingLu');");
E_D("replace into `qb_fenlei_street` values('41','74','小北','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiaoBei');");
E_D("replace into `qb_fenlei_street` values('42','74','海珠广场','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HaiZhuGuangChang');");
E_D("replace into `qb_fenlei_street` values('43','74','西门口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiMenKou');");
E_D("replace into `qb_fenlei_street` values('44','74','东风中路/越秀公园','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengZhongLu_YueXiuGongYuan');");
E_D("replace into `qb_fenlei_street` values('45','74','东山环市东','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongShanHuanShiDong');");
E_D("replace into `qb_fenlei_street` values('46','74','五羊新城','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuYangXinCheng');");
E_D("replace into `qb_fenlei_street` values('47','74','麓湖公园','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LuHuGongYuan');");
E_D("replace into `qb_fenlei_street` values('48','74','中山云路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanYunLu');");
E_D("replace into `qb_fenlei_street` values('49','74','东川','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongChuan');");
E_D("replace into `qb_fenlei_street` values('50','74','解放南','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JieFangNan');");
E_D("replace into `qb_fenlei_street` values('51','74','解放北','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JieFangBei');");
E_D("replace into `qb_fenlei_street` values('52','74','沿江路线','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YanJiangLuXian');");
E_D("replace into `qb_fenlei_street` values('53','74','中山二三路/东山口','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanErSanLu_DongShanKou');");
E_D("replace into `qb_fenlei_street` values('54','75','五羊新村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuYangXinCun');");
E_D("replace into `qb_fenlei_street` values('55','75','东风东路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengDongLu');");
E_D("replace into `qb_fenlei_street` values('56','75','东华西路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongHuaXiLu');");
E_D("replace into `qb_fenlei_street` values('57','75','德政中路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DeZhengZhongLu');");
E_D("replace into `qb_fenlei_street` values('58','75','达道路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaDaoLu');");
E_D("replace into `qb_fenlei_street` values('59','75','广东工大','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangDongGongDa');");
E_D("replace into `qb_fenlei_street` values('60','75','白云路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunLu');");
E_D("replace into `qb_fenlei_street` values('61','75','黄花岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangHuaGang');");
E_D("replace into `qb_fenlei_street` values('62','75','新河蒲路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinHePuLu');");
E_D("replace into `qb_fenlei_street` values('63','76','棠下','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TangXia');");
E_D("replace into `qb_fenlei_street` values('64','76','东圃','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongPu');");
E_D("replace into `qb_fenlei_street` values('65','76','员村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuanCun');");
E_D("replace into `qb_fenlei_street` values('66','76','珠江新城/跑马场','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhuJiangXinCheng_PaoMaChang');");
E_D("replace into `qb_fenlei_street` values('67','76','天河公园','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeGongYuan');");
E_D("replace into `qb_fenlei_street` values('68','76','天河北/广州东站','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeBei_GuangZhouDongZhan');");
E_D("replace into `qb_fenlei_street` values('69','76','车陂','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','Che');");
E_D("replace into `qb_fenlei_street` values('70','76','五山','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuShan');");
E_D("replace into `qb_fenlei_street` values('71','76','沙河','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShaHe');");
E_D("replace into `qb_fenlei_street` values('72','76','天河南','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeNan');");
E_D("replace into `qb_fenlei_street` values('73','76','后天河北','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HouTianHeBei');");
E_D("replace into `qb_fenlei_street` values('74','76','体育中心','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TiYuZhongXin');");
E_D("replace into `qb_fenlei_street` values('75','76','岗顶','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GangDing');");
E_D("replace into `qb_fenlei_street` values('76','76','粤垦','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YueKen');");
E_D("replace into `qb_fenlei_street` values('77','76','黄村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangCun');");
E_D("replace into `qb_fenlei_street` values('78','76','林和','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LinHe');");
E_D("replace into `qb_fenlei_street` values('79','77','江南大道','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangNanDaDao');");
E_D("replace into `qb_fenlei_street` values('80','77','滨江路沿线','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BinJiangLuYanXian');");
E_D("replace into `qb_fenlei_street` values('81','77','工业大道','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GongYeDaDao');");
E_D("replace into `qb_fenlei_street` values('82','77','宝岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaoGang');");
E_D("replace into `qb_fenlei_street` values('83','77','新港西','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinGangXi');");
E_D("replace into `qb_fenlei_street` values('84','77','南洲','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanZhou');");
E_D("replace into `qb_fenlei_street` values('85','77','琶洲','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','PaZhou');");
E_D("replace into `qb_fenlei_street` values('86','77','广州大道','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangZhouDaDao');");
E_D("replace into `qb_fenlei_street` values('87','77','赤岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChiGang');");
E_D("replace into `qb_fenlei_street` values('88','77','昌岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChangGang');");
E_D("replace into `qb_fenlei_street` values('89','77','江南中','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangNanZhong');");
E_D("replace into `qb_fenlei_street` values('90','77','华州/东晓路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuaZhou_DongXiaoLu');");
E_D("replace into `qb_fenlei_street` values('91','77','官州','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuanZhou');");
E_D("replace into `qb_fenlei_street` values('92','77','大学城','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaXueCheng');");
E_D("replace into `qb_fenlei_street` values('93','77','南石头','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanShiTou');");
E_D("replace into `qb_fenlei_street` values('94','77','江海','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangHai');");
E_D("replace into `qb_fenlei_street` values('95','78','黄浦区府','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangPuQuFu');");
E_D("replace into `qb_fenlei_street` values('96','78','开发区','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','KaiFaQu');");
E_D("replace into `qb_fenlei_street` values('97','78','黄埔岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangPuGang');");
E_D("replace into `qb_fenlei_street` values('98','78','文冲','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WenChong');");
E_D("replace into `qb_fenlei_street` values('99','78','新塘','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinTang');");
E_D("replace into `qb_fenlei_street` values('100','79','南湖','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanHu');");
E_D("replace into `qb_fenlei_street` values('101','79','同和','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TongHe');");
E_D("replace into `qb_fenlei_street` values('102','79','机场路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiChangLu');");
E_D("replace into `qb_fenlei_street` values('103','79','黄石路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangShiLu');");
E_D("replace into `qb_fenlei_street` values('104','79','广园路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangYuanLu');");
E_D("replace into `qb_fenlei_street` values('105','79','同德罗冲围','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TongDeLuoChongWei');");
E_D("replace into `qb_fenlei_street` values('106','79','新体育馆','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinTiYuGuan');");
E_D("replace into `qb_fenlei_street` values('107','79','广花','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangHua');");
E_D("replace into `qb_fenlei_street` values('108','79','白云大道','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunDaDao');");
E_D("replace into `qb_fenlei_street` values('109','79','新广从路','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinGuangCongLu');");
E_D("replace into `qb_fenlei_street` values('110','79','三元里','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','SanYuanLi');");
E_D("replace into `qb_fenlei_street` values('111','79','广源新村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangYuanXinCun');");
E_D("replace into `qb_fenlei_street` values('112','79','桂花岗','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuiHuaGang');");
E_D("replace into `qb_fenlei_street` values('113','79','新市','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinShi');");
E_D("replace into `qb_fenlei_street` values('114','79','金沙洲','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JinShaZhou');");
E_D("replace into `qb_fenlei_street` values('115','79','白云山','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunShan');");
E_D("replace into `qb_fenlei_street` values('116','79','棠溪','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TangXi');");
E_D("replace into `qb_fenlei_street` values('117','79','外语学校','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WaiYuXueXiao');");
E_D("replace into `qb_fenlei_street` values('118','80','市桥','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiQiao');");
E_D("replace into `qb_fenlei_street` values('119','80','洛溪','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LuoXi');");
E_D("replace into `qb_fenlei_street` values('120','80','华南板块','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuaNanBanKuai');");
E_D("replace into `qb_fenlei_street` values('121','80','大石','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaShi');");
E_D("replace into `qb_fenlei_street` values('122','80','南沙','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanSha');");
E_D("replace into `qb_fenlei_street` values('123','80','钟村','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongCun');");
E_D("replace into `qb_fenlei_street` values('124','80','祈福','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','QiFu');");
E_D("replace into `qb_fenlei_street` values('125','80','石基','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiJi');");
E_D("replace into `qb_fenlei_street` values('126','81','旧区','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiuQu');");
E_D("replace into `qb_fenlei_street` values('127','81','新区','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinQu');");
E_D("replace into `qb_fenlei_street` values('128','81','狮岭','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiLing');");

require("../../inc/footer.php");
?>