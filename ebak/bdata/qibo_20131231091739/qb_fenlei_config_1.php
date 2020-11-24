<?php
require("../../inc/header.php");

/*
		SoftName : EmpireBak Version 2010
		Author   : wm_chief
		Copyright: Powered by www.phome.net
*/

DoSetDbChar('gbk');
E_D("DROP TABLE IF EXISTS `qb_fenlei_config`;");
E_C("CREATE TABLE `qb_fenlei_config` (
  `c_key` varchar(50) NOT NULL DEFAULT '',
  `c_value` text NOT NULL,
  `c_descrip` text NOT NULL,
  PRIMARY KEY (`c_key`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk");
E_D("replace into `qb_fenlei_config` values('AdInfoListLeng','40','');");
E_D("replace into `qb_fenlei_config` values('Info_PostMaxNum','20','');");
E_D("replace into `qb_fenlei_config` values('Info_TopNum','5','');");
E_D("replace into `qb_fenlei_config` values('AdInfoSortShow','10','');");
E_D("replace into `qb_fenlei_config` values('AdInfoShowTime','100','');");
E_D("replace into `qb_fenlei_config` values('Info_feedbackID','111111','');");
E_D("replace into `qb_fenlei_config` values('Info_MakeIndexHtmlTime','0','');");
E_D("replace into `qb_fenlei_config` values('ErrSortMoney','13','');");
E_D("replace into `qb_fenlei_config` values('Info_DelKeyword','暴乱\r\n反动','');");
E_D("replace into `qb_fenlei_config` values('Info_PostMaxLeng','100000','');");
E_D("replace into `qb_fenlei_config` values('Info_RepeatPostNum','3','');");
E_D("replace into `qb_fenlei_config` values('Info_postCkMob','0','');");
E_D("replace into `qb_fenlei_config` values('Info_postCkIp','0','');");
E_D("replace into `qb_fenlei_config` values('DelOtherCommentMoney','12','');");
E_D("replace into `qb_fenlei_config` values('otherCardMoney','11','');");
E_D("replace into `qb_fenlei_config` values('permitMoney','10','');");
E_D("replace into `qb_fenlei_config` values('IDcardMoney','9','');");
E_D("replace into `qb_fenlei_config` values('EmailYzMoney','8','');");
E_D("replace into `qb_fenlei_config` values('ReportMoney','7','');");
E_D("replace into `qb_fenlei_config` values('GoodCommentMoney','6','');");
E_D("replace into `qb_fenlei_config` values('PublicizeRegMoney','5','');");
E_D("replace into `qb_fenlei_config` values('ALLInfoMoney','4','');");
E_D("replace into `qb_fenlei_config` values('Info_loginTime','16','');");
E_D("replace into `qb_fenlei_config` values('Info_loginMoney','3','');");
E_D("replace into `qb_fenlei_config` values('Info_regmoney','1','');");
E_D("replace into `qb_fenlei_config` values('illInfoMoney','14','');");
E_D("replace into `qb_fenlei_config` values('DelReportMoney','15','');");
E_D("replace into `qb_fenlei_config` values('Jump_allcity','0','');");
E_D("replace into `qb_fenlei_config` values('Jump_fromarea','1','');");
E_D("replace into `qb_fenlei_config` values('Info_TopMoney','3','');");
E_D("replace into `qb_fenlei_config` values('Info_closeWhy','网站维护当中,暂停开放','');");
E_D("replace into `qb_fenlei_config` values('sort_layout','10,9,150,165#2,4#1,5,3#6,7,8#','');");
E_D("replace into `qb_fenlei_config` values('Info_GroupCommentYzImg','2,3,4,8,9','');");
E_D("replace into `qb_fenlei_config` values('Info_GroupPostYzImg','2,3,4,8,9','');");
E_D("replace into `qb_fenlei_config` values('Info_weburl','','');");
E_D("replace into `qb_fenlei_config` values('ForbidPostIp','','');");
E_D("replace into `qb_fenlei_config` values('AdInfoIndexLeng','','');");
E_D("replace into `qb_fenlei_config` values('Info_ForbidMemberViewContact','0','');");
E_D("replace into `qb_fenlei_config` values('Info_ShowSearchContact','0','');");
E_D("replace into `qb_fenlei_config` values('Info_ImgShopContact','0','');");
E_D("replace into `qb_fenlei_config` values('Info_ForbidGuesViewContact','0','');");
E_D("replace into `qb_fenlei_config` values('Info_TopDay','2','');");
E_D("replace into `qb_fenlei_config` values('ForbidPostMember','','');");
E_D("replace into `qb_fenlei_config` values('Info_cityPost','0','');");
E_D("replace into `qb_fenlei_config` values('AdInfoBigsortShow','15','');");
E_D("replace into `qb_fenlei_config` values('InfoIndexCSRow','','');");
E_D("replace into `qb_fenlei_config` values('Force_Choose_City','0','');");
E_D("replace into `qb_fenlei_config` values('post_htmlType','0','');");
E_D("replace into `qb_fenlei_config` values('Info_Searchkeyword','0','');");
E_D("replace into `qb_fenlei_config` values('Post_group_UpPhoto','','');");
E_D("replace into `qb_fenlei_config` values('Info_forbidOutPost','1','');");
E_D("replace into `qb_fenlei_config` values('Info_MemberPostRepeat','0','');");
E_D("replace into `qb_fenlei_config` values('Info_GuestPostRepeat','0','');");
E_D("replace into `qb_fenlei_config` values('Info_MemberPostMoney','2','');");
E_D("replace into `qb_fenlei_config` values('InfoIndexLeng','26','');");
E_D("replace into `qb_fenlei_config` values('InfoIndexRow','8','');");
E_D("replace into `qb_fenlei_config` values('InfoListRow','10','');");
E_D("replace into `qb_fenlei_config` values('AdInfoIndexRow','16','');");
E_D("replace into `qb_fenlei_config` values('group_UpPhoto','','');");
E_D("replace into `qb_fenlei_config` values('Info_contact','010-88888888\r\nkefu@gmail.com\r\nkefu@msn.com\r\n88888888','');");
E_D("replace into `qb_fenlei_config` values('UpdatePostTime','3','');");
E_D("replace into `qb_fenlei_config` values('Info_showday','3/10/30/60/90/180','');");
E_D("replace into `qb_fenlei_config` values('Info_guide_word','','');");
E_D("replace into `qb_fenlei_config` values('Info_ShowNoYz','1','');");
E_D("replace into `qb_fenlei_config` values('Info_DelEndtime','0','');");
E_D("replace into `qb_fenlei_config` values('Info_MemberPostPicNum','','');");
E_D("replace into `qb_fenlei_config` values('Info_MemberDayPostNum','20','');");
E_D("replace into `qb_fenlei_config` values('Info_GuestPostPicNum','','');");
E_D("replace into `qb_fenlei_config` values('Info_GuestDayPostNum','3','');");
E_D("replace into `qb_fenlei_config` values('Info_ClosePostWhy','严打时期,暂停发布与修改信息','');");
E_D("replace into `qb_fenlei_config` values('Info_YzKeyword_DO','0','');");
E_D("replace into `qb_fenlei_config` values('CommentPass_group','3,4','');");
E_D("replace into `qb_fenlei_config` values('Info_htmlType','0','');");
E_D("replace into `qb_fenlei_config` values('Info_allcityType','0','');");
E_D("replace into `qb_fenlei_config` values('Info_MemberChooseCity','0','');");
E_D("replace into `qb_fenlei_config` values('Info_UseEndTime','1','');");
E_D("replace into `qb_fenlei_config` values('CollectArticleNum','23','');");
E_D("replace into `qb_fenlei_config` values('PostInfoMoney','2','');");
E_D("replace into `qb_fenlei_config` values('Info_allowGuesSearch','1','');");
E_D("replace into `qb_fenlei_config` values('Info_ClosePost','0','');");
E_D("replace into `qb_fenlei_config` values('module_pre','fenlei_','');");
E_D("replace into `qb_fenlei_config` values('Info_style','','');");
E_D("replace into `qb_fenlei_config` values('Info_metakeywords','房产 二手 交易 黄页','');");
E_D("replace into `qb_fenlei_config` values('Info_webadmin','','');");
E_D("replace into `qb_fenlei_config` values('Info_webOpen','1','');");
E_D("replace into `qb_fenlei_config` values('Info_areaname','全国','');");
E_D("replace into `qb_fenlei_config` values('module_close','0','');");
E_D("replace into `qb_fenlei_config` values('Info_htmlname','html','');");
E_D("replace into `qb_fenlei_config` values('Info_webname','分类信息','');");
E_D("replace into `qb_fenlei_config` values('AdInfoIndexShow','20','');");
E_D("replace into `qb_fenlei_config` values('GroupPassYz','','');");
E_D("replace into `qb_fenlei_config` values('GroupPostInfo','','');");
E_D("replace into `qb_fenlei_config` values('Info_TopColor','#F70968','');");
E_D("replace into `qb_fenlei_config` values('Info_Musttelephone','0','');");
E_D("replace into `qb_fenlei_config` values('Info_Mustmobphone','0','');");
E_D("replace into `qb_fenlei_config` values('Info_MustQQ','0','');");
E_D("replace into `qb_fenlei_config` values('Info_MustEmail','0','');");
E_D("replace into `qb_fenlei_config` values('InfoIndexCSLeng','','');");
E_D("replace into `qb_fenlei_config` values('Info_showsortnum','','');");
E_D("replace into `qb_fenlei_config` values('Info_ListNum','','');");
E_D("replace into `qb_fenlei_config` values('AdInfoListRow','10','');");
E_D("replace into `qb_fenlei_config` values('InfoListLeng','30','');");
E_D("replace into `qb_fenlei_config` values('showNoPassComment','0','');");
E_D("replace into `qb_fenlei_config` values('Info_YzKeyword','性爱\r\n做爱\r\n共产党','');");
E_D("replace into `qb_fenlei_config` values('rand_num','1288762604','');");
E_D("replace into `qb_fenlei_config` values('rand_num_inputname','hna','');");
E_D("replace into `qb_fenlei_config` values('Info_ReportDB','垃圾信息\r\n虚假信息\r\n违法信息\r\n雷同信息','');");
E_D("replace into `qb_fenlei_config` values('Info_index_cache','','');");
E_D("replace into `qb_fenlei_config` values('Info_list_cache','','');");
E_D("replace into `qb_fenlei_config` values('rand_num_mktime','1','');");
E_D("replace into `qb_fenlei_config` values('module_id','1','');");

require("../../inc/footer.php");
?>