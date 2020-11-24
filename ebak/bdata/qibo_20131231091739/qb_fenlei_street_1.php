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
E_D("replace into `qb_fenlei_street` values('1','1','��̫ƽׯ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BeiTaiPingZhuang');");
E_D("replace into `qb_fenlei_street` values('2','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaZhongSi');");
E_D("replace into `qb_fenlei_street` values('3','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DingHuiSi');");
E_D("replace into `qb_fenlei_street` values('4','1','�ʼҿ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GanJiaKou');");
E_D("replace into `qb_fenlei_street` values('5','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GongZhuFen');");
E_D("replace into `qb_fenlei_street` values('6','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HangTianQiao');");
E_D("replace into `qb_fenlei_street` values('7','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JianXiangQiao');");
E_D("replace into `qb_fenlei_street` values('8','1','���峧','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LanDianChang');");
E_D("replace into `qb_fenlei_street` values('9','1','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','MaDian');");
E_D("replace into `qb_fenlei_street` values('10','1','���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','QingHe');");
E_D("replace into `qb_fenlei_street` values('11','1','�ϵ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangDi');");
E_D("replace into `qb_fenlei_street` values('12','1','��ׯ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangZhuang');");
E_D("replace into `qb_fenlei_street` values('13','1','�ļ���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','SiJiQing');");
E_D("replace into `qb_fenlei_street` values('14','1','κ����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WeiGongCun');");
E_D("replace into `qb_fenlei_street` values('15','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiErQi');");
E_D("replace into `qb_fenlei_street` values('16','1','�����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuDaoKou');");
E_D("replace into `qb_fenlei_street` values('17','1','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiSanQi');");
E_D("replace into `qb_fenlei_street` values('18','1','��ֱ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiZhiMen');");
E_D("replace into `qb_fenlei_street` values('19','1','����ɽ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WaiXiangShan');");
E_D("replace into `qb_fenlei_street` values('20','1','ѧԺ·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XueYuanLu');");
E_D("replace into `qb_fenlei_street` values('21','1','��Ȫ·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuQuanLu');");
E_D("replace into `qb_fenlei_street` values('22','1','Բ��԰','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuanMingYuan');");
E_D("replace into `qb_fenlei_street` values('23','1','�йش�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongGuanCun');");
E_D("replace into `qb_fenlei_street` values('24','73','�����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LiWanHu');");
E_D("replace into `qb_fenlei_street` values('25','73','ɳ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShaMian');");
E_D("replace into `qb_fenlei_street` values('26','73','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LiuHua');");
E_D("replace into `qb_fenlei_street` values('27','73','���¾ŵ���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShangXiaJiuDiQu');");
E_D("replace into `qb_fenlei_street` values('28','73','�¼���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChenJia');");
E_D("replace into `qb_fenlei_street` values('29','73','��ɽ�߰�·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanQiBaLu');");
E_D("replace into `qb_fenlei_street` values('30','73','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiGuan');");
E_D("replace into `qb_fenlei_street` values('31','73','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','FangCun');");
E_D("replace into `qb_fenlei_street` values('32','73','�ӿ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','KengKou');");
E_D("replace into `qb_fenlei_street` values('33','73','�ѿ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiaoKou');");
E_D("replace into `qb_fenlei_street` values('34','73','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengXi');");
E_D("replace into `qb_fenlei_street` values('35','73','����·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaoHuaLu');");
E_D("replace into `qb_fenlei_street` values('36','73','�׶��´�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HeDongXinCun');");
E_D("replace into `qb_fenlei_street` values('37','73','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhouMen');");
E_D("replace into `qb_fenlei_street` values('38','73','�ʺ�ϷԺ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','CaiHongXiYuan');");
E_D("replace into `qb_fenlei_street` values('39','73','��ɳ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangSha');");
E_D("replace into `qb_fenlei_street` values('40','74','����·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BeiJingLu');");
E_D("replace into `qb_fenlei_street` values('41','74','С��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiaoBei');");
E_D("replace into `qb_fenlei_street` values('42','74','����㳡','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HaiZhuGuangChang');");
E_D("replace into `qb_fenlei_street` values('43','74','���ſ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XiMenKou');");
E_D("replace into `qb_fenlei_street` values('44','74','������·/Խ�㹫԰','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengZhongLu_YueXiuGongYuan');");
E_D("replace into `qb_fenlei_street` values('45','74','��ɽ���ж�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongShanHuanShiDong');");
E_D("replace into `qb_fenlei_street` values('46','74','�����³�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuYangXinCheng');");
E_D("replace into `qb_fenlei_street` values('47','74','´����԰','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LuHuGongYuan');");
E_D("replace into `qb_fenlei_street` values('48','74','��ɽ��·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanYunLu');");
E_D("replace into `qb_fenlei_street` values('49','74','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongChuan');");
E_D("replace into `qb_fenlei_street` values('50','74','�����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JieFangNan');");
E_D("replace into `qb_fenlei_street` values('51','74','��ű�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JieFangBei');");
E_D("replace into `qb_fenlei_street` values('52','74','�ؽ�·��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YanJiangLuXian');");
E_D("replace into `qb_fenlei_street` values('53','74','��ɽ����·/��ɽ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongShanErSanLu_DongShanKou');");
E_D("replace into `qb_fenlei_street` values('54','75','�����´�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuYangXinCun');");
E_D("replace into `qb_fenlei_street` values('55','75','���綫·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongFengDongLu');");
E_D("replace into `qb_fenlei_street` values('56','75','������·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongHuaXiLu');");
E_D("replace into `qb_fenlei_street` values('57','75','������·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DeZhengZhongLu');");
E_D("replace into `qb_fenlei_street` values('58','75','���·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaDaoLu');");
E_D("replace into `qb_fenlei_street` values('59','75','�㶫����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangDongGongDa');");
E_D("replace into `qb_fenlei_street` values('60','75','����·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunLu');");
E_D("replace into `qb_fenlei_street` values('61','75','�ƻ���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangHuaGang');");
E_D("replace into `qb_fenlei_street` values('62','75','�º���·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinHePuLu');");
E_D("replace into `qb_fenlei_street` values('63','76','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TangXia');");
E_D("replace into `qb_fenlei_street` values('64','76','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DongPu');");
E_D("replace into `qb_fenlei_street` values('65','76','Ա��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YuanCun');");
E_D("replace into `qb_fenlei_street` values('66','76','�齭�³�/������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhuJiangXinCheng_PaoMaChang');");
E_D("replace into `qb_fenlei_street` values('67','76','��ӹ�԰','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeGongYuan');");
E_D("replace into `qb_fenlei_street` values('68','76','��ӱ�/���ݶ�վ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeBei_GuangZhouDongZhan');");
E_D("replace into `qb_fenlei_street` values('69','76','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','Che');");
E_D("replace into `qb_fenlei_street` values('70','76','��ɽ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WuShan');");
E_D("replace into `qb_fenlei_street` values('71','76','ɳ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShaHe');");
E_D("replace into `qb_fenlei_street` values('72','76','�����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TianHeNan');");
E_D("replace into `qb_fenlei_street` values('73','76','����ӱ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HouTianHeBei');");
E_D("replace into `qb_fenlei_street` values('74','76','��������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TiYuZhongXin');");
E_D("replace into `qb_fenlei_street` values('75','76','�ڶ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GangDing');");
E_D("replace into `qb_fenlei_street` values('76','76','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','YueKen');");
E_D("replace into `qb_fenlei_street` values('77','76','�ƴ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangCun');");
E_D("replace into `qb_fenlei_street` values('78','76','�ֺ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LinHe');");
E_D("replace into `qb_fenlei_street` values('79','77','���ϴ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangNanDaDao');");
E_D("replace into `qb_fenlei_street` values('80','77','����·����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BinJiangLuYanXian');");
E_D("replace into `qb_fenlei_street` values('81','77','��ҵ���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GongYeDaDao');");
E_D("replace into `qb_fenlei_street` values('82','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaoGang');");
E_D("replace into `qb_fenlei_street` values('83','77','�¸���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinGangXi');");
E_D("replace into `qb_fenlei_street` values('84','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanZhou');");
E_D("replace into `qb_fenlei_street` values('85','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','PaZhou');");
E_D("replace into `qb_fenlei_street` values('86','77','���ݴ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangZhouDaDao');");
E_D("replace into `qb_fenlei_street` values('87','77','���','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChiGang');");
E_D("replace into `qb_fenlei_street` values('88','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ChangGang');");
E_D("replace into `qb_fenlei_street` values('89','77','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangNanZhong');");
E_D("replace into `qb_fenlei_street` values('90','77','����/����·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuaZhou_DongXiaoLu');");
E_D("replace into `qb_fenlei_street` values('91','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuanZhou');");
E_D("replace into `qb_fenlei_street` values('92','77','��ѧ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaXueCheng');");
E_D("replace into `qb_fenlei_street` values('93','77','��ʯͷ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanShiTou');");
E_D("replace into `qb_fenlei_street` values('94','77','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiangHai');");
E_D("replace into `qb_fenlei_street` values('95','78','��������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangPuQuFu');");
E_D("replace into `qb_fenlei_street` values('96','78','������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','KaiFaQu');");
E_D("replace into `qb_fenlei_street` values('97','78','���Ҹ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangPuGang');");
E_D("replace into `qb_fenlei_street` values('98','78','�ĳ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WenChong');");
E_D("replace into `qb_fenlei_street` values('99','78','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinTang');");
E_D("replace into `qb_fenlei_street` values('100','79','�Ϻ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanHu');");
E_D("replace into `qb_fenlei_street` values('101','79','ͬ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TongHe');");
E_D("replace into `qb_fenlei_street` values('102','79','����·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiChangLu');");
E_D("replace into `qb_fenlei_street` values('103','79','��ʯ·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuangShiLu');");
E_D("replace into `qb_fenlei_street` values('104','79','��԰·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangYuanLu');");
E_D("replace into `qb_fenlei_street` values('105','79','ͬ���޳�Χ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TongDeLuoChongWei');");
E_D("replace into `qb_fenlei_street` values('106','79','��������','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinTiYuGuan');");
E_D("replace into `qb_fenlei_street` values('107','79','�㻨','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangHua');");
E_D("replace into `qb_fenlei_street` values('108','79','���ƴ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunDaDao');");
E_D("replace into `qb_fenlei_street` values('109','79','�¹��·','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinGuangCongLu');");
E_D("replace into `qb_fenlei_street` values('110','79','��Ԫ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','SanYuanLi');");
E_D("replace into `qb_fenlei_street` values('111','79','��Դ�´�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuangYuanXinCun');");
E_D("replace into `qb_fenlei_street` values('112','79','�𻨸�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','GuiHuaGang');");
E_D("replace into `qb_fenlei_street` values('113','79','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinShi');");
E_D("replace into `qb_fenlei_street` values('114','79','��ɳ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JinShaZhou');");
E_D("replace into `qb_fenlei_street` values('115','79','����ɽ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','BaiYunShan');");
E_D("replace into `qb_fenlei_street` values('116','79','��Ϫ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','TangXi');");
E_D("replace into `qb_fenlei_street` values('117','79','����ѧУ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','WaiYuXueXiao');");
E_D("replace into `qb_fenlei_street` values('118','80','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiQiao');");
E_D("replace into `qb_fenlei_street` values('119','80','��Ϫ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','LuoXi');");
E_D("replace into `qb_fenlei_street` values('120','80','���ϰ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','HuaNanBanKuai');");
E_D("replace into `qb_fenlei_street` values('121','80','��ʯ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','DaShi');");
E_D("replace into `qb_fenlei_street` values('122','80','��ɳ','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','NanSha');");
E_D("replace into `qb_fenlei_street` values('123','80','�Ӵ�','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ZhongCun');");
E_D("replace into `qb_fenlei_street` values('124','80','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','QiFu');");
E_D("replace into `qb_fenlei_street` values('125','80','ʯ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiJi');");
E_D("replace into `qb_fenlei_street` values('126','81','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','JiuQu');");
E_D("replace into `qb_fenlei_street` values('127','81','����','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','XinQu');");
E_D("replace into `qb_fenlei_street` values('128','81','ʨ��','0','0','0','','0','0','','','','','','','0','','','1','','','','','0','','ShiLing');");

require("../../inc/footer.php");
?>