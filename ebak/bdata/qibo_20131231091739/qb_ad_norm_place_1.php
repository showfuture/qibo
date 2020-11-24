<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_ad_norm_place`;");
E_C("CREATE TABLE `qb_ad_norm_place` (
  `id` mediumint(7) NOT NULL AUTO_INCREMENT,
  `keywords` varchar(50) NOT NULL DEFAULT '',
  `name` varchar(100) NOT NULL DEFAULT '',
  `type` varchar(30) NOT NULL DEFAULT '0',
  `isclose` tinyint(1) NOT NULL DEFAULT '0',
  `begintime` int(10) NOT NULL DEFAULT '0',
  `endtime` int(10) NOT NULL DEFAULT '0',
  `adcode` text NOT NULL,
  `posttime` int(10) NOT NULL DEFAULT '0',
  `list` int(10) NOT NULL DEFAULT '0',
  `uid` mediumint(7) NOT NULL DEFAULT '0',
  `hits` mediumint(7) NOT NULL DEFAULT '0',
  `money` mediumint(6) NOT NULL DEFAULT '0',
  `moneycard` mediumint(6) NOT NULL DEFAULT '0',
  `ifsale` tinyint(1) NOT NULL DEFAULT '0',
  `autoyz` tinyint(1) NOT NULL DEFAULT '0',
  `demourl` varchar(150) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk");
E_D("replace into `qb_ad_norm_place` values('1','article_list','文章列表页侧面广告','code','0','0','0','a:5:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:0:\"\";s:7:\"linkurl\";s:0:\"\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";}','0','0','0','0','0','5','0','1','/do/job.php?job=jump&pagetype=list');");
E_D("replace into `qb_ad_norm_place` values('10','article_content','文章内容里边的广告','pic','1','0','0','a:8:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:32:\"other/1_20090326120324_mnfIi.jpg\";s:7:\"linkurl\";s:20:\"http://www.haoid.cn/\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";s:5:\"width\";s:3:\"400\";s:6:\"height\";s:3:\"400\";s:9:\"pictarget\";s:5:\"blank\";}','0','0','0','0','0','5','1','1','/do/job.php?job=jump&pagetype=bencandy');");
E_D("replace into `qb_ad_norm_place` values('2','article_show','文章内容页侧边下方广告','code','0','0','0','a:5:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:0:\"\";s:7:\"linkurl\";s:0:\"\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:1782:\"<div style=\"LINE-HEIGHT: 150%\"><a href=\"http://www.haoid.cn/\" target=_blank><font color=#ff0000><strong>好站长资源</strong></font></a> 　　<a href=\"http://www.angelyyl.cn/\" target=_blank>冰蓝世界</a><a href=\"http://www.czin.cn/\" target=_blank><br />崇左热线—崇左人的网上家园</a> <br /><a href=\"http://www.sy50.com/\" target=_blank>邵阳网邻 了解邵阳 商务邵阳</a> <br /><a href=\"http://www.771881.cn/\" target=_blank>亲亲你抱抱你-国际女同拉拉网-败家女网站 </a><br /><a href=\"http://www.aihut.com/\" target=_blank>情感小筑原创情感文章网 </a><br /><a href=\"http://www.popyule.com/\" target=_blank>泡泡娱乐网--娱乐综合站PHP168构建</a> <br /><a href=\"http://www.china551.cn/\" target=_blank><font color=#ff0000>高中物理网</font></a> 　　<a href=\"http://www.ym988.com/\" target=_blank>圆梦模板工作室 </a><br /><a href=\"http://www.welights.com/\" target=_blank>国际灯具网</a> 　　<a href=\"http://www.hnmssy.cn/\" target=_blank>湖南民俗摄影网</a> <br /><a href=\"http://www.nuoyue.net/\" target=_blank><font color=#ff0000>诺跃站长社区 - 站长、菜鸟学习的好地方</font></a> <br /><a href=\"http://www.qzfl.com/\" target=_blank>泉州分类 连接泉州信息，服务百姓生活</a> <br /><a href=\"http://www.stmsn.com/\" target=_blank>中国内衣联盟</a> 　　<a href=\"http://www.downcc.cn/\" target=_blank>大当家软件站 </a><br /><a href=\"http://www.yt12333.cn/\" target=_blank>劳动社保之家-盐亭劳动保障网</a> <br /><a href=\"http://www.gooyi.cn/\" target=_blank>广易网 - 广州最大门户网 </a><br /><a href=\"http://www.idercn.com/\" target=_blank>I.D.部落</a> 　　<a href=\"http://www.tz0632.com/\" target=_blank>滕州城市网</a> 　　<a href=\"http://www.doubar.com/\" target=_blank>豆吧 </a></div>\r\n<div style=\"LINE-HEIGHT: 150%\"><a href=\"http://www.wfseo.org/\" target=_blank><font color=#d2691e>重庆网站优化</font><br /></a><br /></div>\";}','0','0','0','0','0','5','0','1','/do/job.php?job=jump&pagetype=bencandy');");
E_D("replace into `qb_ad_norm_place` values('11','digg_list','顶客排行榜侧边广告','code','0','0','0','a:5:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:0:\"\";s:7:\"linkurl\";s:0:\"\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:813:\"<div style=\"LINE-HEIGHT: 200%\"><a href=\"http://www.ibioo.com/\" target=_blank><font color=#ff0000>绿谷生物网--打造最具活力生物站!</font> </a><br /><a href=\"http://www.51solo.net/\" target=_blank>搜罗娱乐门户－精彩娱乐生活从我开始 </a><br /><a href=\"http://1.com/45/admin/www.china-highway.com\" target=_blank>方向和路线尽在中国高速公路网 </a><br /><a href=\"http://www.nenbei.com/\" target=_blank><font color=#ff0000>嫩北聚合娱乐网欢迎您的到来 </font></a><br /><a href=\"http://www.liuv.net/\" target=_blank><font color=#ff0000>流水设计</font></a> <br /><a href=\"http://www.fming.net/\" target=_blank>蜂鸣原创 文学与摄影的创作平台 </a><br /><a href=\"http://www.netchinatown.com/\" target=_blank>时尚唐城-海外华人精英的网络家园 </a><br /><a href=\"http://frp.ok586.cn/\" target=_blank>上海玻璃钢冷却塔专业生产厂家. </a></div>\";}','0','0','0','0','0','5','0','1','/do/digg.php');");
E_D("replace into `qb_ad_norm_place` values('19','list_page_topad','列表页侧边顶部广告位','pic','0','0','0','a:8:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:13:\"ad/listad.jpg\";s:7:\"linkurl\";s:19:\"http://www.hoid.cn/\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";s:5:\"width\";s:3:\"290\";s:6:\"height\";s:3:\"130\";s:9:\"pictarget\";s:5:\"blank\";}','0','0','0','2','0','10','1','1','/do/job.php?job=jump&pagetype=list');");
E_D("replace into `qb_ad_norm_place` values('18','show_topad','内容页顶部横幅广告','pic','0','0','0','a:8:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:18:\"ad/ad_show_top.jpg\";s:7:\"linkurl\";s:20:\"http://www.haoid.cn/\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";s:5:\"width\";s:3:\"980\";s:6:\"height\";s:2:\"60\";s:9:\"pictarget\";s:5:\"blank\";}','0','0','0','0','0','10','1','1','../do/job.php?job=jump&pagetype=bencandy');");
E_D("replace into `qb_ad_norm_place` values('17','show_right_top_picad','内容页侧边顶部图片广告位','pic','0','0','0','a:8:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:15:\"ad/qyshowad.jpg\";s:7:\"linkurl\";s:19:\"http://www.haoid.cn\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";s:5:\"width\";s:3:\"290\";s:6:\"height\";s:3:\"110\";s:9:\"pictarget\";s:5:\"blank\";}','0','0','0','29','0','10','1','1','/do/job.php?job=jump&pagetype=bencandy');");
E_D("replace into `qb_ad_norm_place` values('20','AD_list_topad','列表页顶部横幅广告','pic','0','0','0','a:8:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:14:\"ad/cnidca1.gif\";s:7:\"linkurl\";s:20:\"http://www.haoid.cn/\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:0:\"\";s:5:\"width\";s:3:\"980\";s:6:\"height\";s:2:\"60\";s:9:\"pictarget\";s:5:\"blank\";}','0','0','0','4','0','10','1','1','/do/list.php?fid=1');");
E_D("replace into `qb_ad_norm_place` values('21','sp_show_ad','专题页广告位','code','0','0','0','a:5:{s:4:\"word\";s:0:\"\";s:6:\"picurl\";s:0:\"\";s:7:\"linkurl\";s:0:\"\";s:8:\"flashurl\";s:0:\"\";s:4:\"code\";s:943:\"<div style=\"LINE-HEIGHT: 150%\"><a href=\"http://3cq.org/\" target=_blank>重庆幼儿教育 一切为了我们的孩子</a> <br /><a href=\"http://www.liuv.net/\" target=_blank>流水设计</a> <br /><a href=\"http://www.21yao.com/\" target=_blank>世纪医药网</a><br /><a href=\"http://www.fming.net/\" target=_blank>蜂鸣原创</a> <br /><a href=\"http://www.jnrx.net/\" target=_blank>胶南热线</a> <br /><a href=\"http://www.7mt.cn/\" target=_blank>骑摩托-中国第一摩托车互动媒体 </a><br /><a href=\"http://www.hnpolice.net/\" target=_blank>湖南公安高等专科学校校友会 </a><br /><a href=\"http://www.seo178.com/\" target=_blank>SEO培训选择--北京SEO培训中心</a> <br /><a href=\"http://www.51solo.net/\" target=_blank>品牌推广,SEO网站优化 </a><br /><a href=\"http://www.kljy.cn/\" target=_blank>致力于儿童教育 </a><br /><a href=\"http://www.eia8.com/job/\" target=_blank>中国环评吧招聘求职网</a> <br /><a href=\"http://www.wenzhang8.com/\" target=_blank>文章吧 打造最好经典文章网 </a>　 </div>\";}','0','0','0','0','0','0','0','1','/do/showsp.php?fid=1&id=23');");

require("../../inc/footer.php");
?>