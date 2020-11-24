<?php
!function_exists('html') && exit('ERR');

if($job)
{
	$query=$db->query(" select * from {$pre}config ");
	while( $rs=$db->fetch_array($query) ){
		$webdb[$rs[c_key]]=$rs[c_value];
	}
}

if($job=="config"&&$Apower[center_config])
{
	$webdb[web_open]?$web_open1='checked':$web_open0='checked';
	$webdb[html]?$html_1='checked':$html_0='checked';
 	$webdb[forbid_guest_see]?$forbid_guest_see1='checked':$forbid_guest_see0='checked';
	$webdb[forbid_post]?$forbid_post1='checked':$forbid_post0='checked';
	$webdb[nav_menu]?$nav_menu1='checked':$nav_menu0='checked';

	$webdb[is_waterimg]?$is_waterimg_1='checked':$is_waterimg_0='checked';
	$waterpos[$webdb[waterpos]]='checked';

	//$select=select_mgroup('gid',$webdb[reg_groupid]);
	$webdb[remind_reg]?$remind_reg1='checked':$remind_reg0='checked';
	$webdb[reg_emails]?$reg_emails1='checked':$reg_emails0='checked';
	$webdb[ifreg]?$ifreg1='checked':$ifreg0='checked';
	$webdb[morereg]?$morereg1='checked':$morereg0='checked';
	$webdb[email_yz]?$email_yz1='checked':$email_yz0='checked';
	$webdb[email_yz_fail]?$email_yz_fail1='checked':$email_yz_fail0='checked';
	$webdb[ifregmsg]?$ifregmsg1='checked':$ifregmsg0='checked';

	$webdb[admin_login]?$admin_login1='checked':$admin_login0='checked';
	$webdb[usrfrom]?$usrfrom1='checked':$usrfrom0='checked';
	$webdb[flack]?$flack1='checked':$flack0='checked';
	$webdb[signtime]?$signtime1='checked':$signtime0='checked';
	$webdb[bbs_showtop]?$bbs_showtop1='checked':$bbs_showtop0='checked';
	$webdb[gdpic]?$gdpic1='checked':$gdpic0='checked';
	$webdb[no_cache]?$no_cache1='checked':$no_cache0='checked';
	$webdb[run_time]?$run_time1='checked':$run_time0='checked';
	$webdb[connet_nums]?$connet_nums1='checked':$connet_nums0='checked';
	$webdb[forbid_show_bug]?$forbid_show_bug1='checked':$forbid_show_bug0='checked';
	$webdb[admin_login_yz]?$admin_login_yz1='checked':$admin_login_yz0='checked';
	$webdb[obstart]?$obstart1='checked':$obstart0='checked';
	$webdb[down_header]?$down_header1='checked':$down_header0='checked';
	$webdb[forbid_steal_download]?$forbid_steal_download1='checked':$forbid_steal_download0='checked';
	$webdb[getpicsize]?$getpicsize1='checked':$getpicsize0='checked';
	$webdb[showstyle]?$showstyle1='checked':$showstyle0='checked';
	@include(ROOT_PATH."data/group/{$P_M[value][m1_groupid]}.php");
	$mgroupdb['allowrp']?$guest_reply='允许发表评论':$guest_reply='不允许发表评论';
	$webdb[updir]=$webdb[updir]?$webdb[updir]:$updir;

	$truepath=preg_replace("/(.+)\/([^\/]+)\/([^\/]+)/is","\\1",$WEBURL);
	if($webdb[truepath]!=$truepath){
		//echo "<CENTER>出错了!!!请正确修改程序所在目录为<font color=red>$truepath</font></CENTER><br><br><br><br>";
	}
	$webdb[truepath] || $webdb[truepath]=$truepath;
	if(!function_exists("ImageJpeg")||!function_exists("imagegif")){
		$gdmsg='提示:当前系统检测到你的服务器不能全面的支持GD库生成水印缩略图,建议不要启用';
	}else{
		$gdmsg='提示:当前系统检测到你的服务器基本可以支持GD库生成水印缩略图';
	}
	$max_upload= ini_get('file_uploads') ? ini_get('upload_max_filesize') : 'Disabled';	//最大上传限制


	$select_style=select_style('webdbs[style]',$webdb[style]);
	$select_member_style=select_member_style('webdbs[style_member]',$webdb[style_member]);

	$NewsMakeHtml[$webdb[NewsMakeHtml]]=' checked ';

	$webdb[UseMoneyType]=='bbs'?$UseMoneyType[bbs]=' checked ':$UseMoneyType[cms]=' checked ';

	if($webdb[MakeIndexHtmlTime]>0){
		$ifmakeindexhtml[Y]=" checked ";
	}else{
		$ifmakeindexhtml[N]=" checked ";
	}

	$AutoPassCompany[intval($webdb[AutoPassCompany])]=' checked ';

	$AutoCutFace[intval($webdb[AutoCutFace])]=' checked ';
	
	
	$UserEmailAutoPass[intval($webdb[UserEmailAutoPass])]=' checked ';

	$BbsUserAutoPass[intval($webdb[BbsUserAutoPass])]=' checked ';
	$yzImgAdminLogin[$webdb[yzImgAdminLogin]]=" checked ";

	$Del_MoreUpfile[intval($webdb[Del_MoreUpfile])]=' checked ';

	$DownLoad_readfile[intval($webdb[DownLoad_readfile])]=' checked ';
	$webdb[path]?$path1=' checked ':$path0=' checked ';

	$RewriteUrl[intval($webdb[RewriteUrl])]=' checked ';


	$GroupPassYz=group_box("webdbs[GroupPassYz]",explode(",",$webdb[GroupPassYz]));
	$webdb[Info_webOpen]?$Info_webOpen1='checked':$Info_webOpen0='checked';
	$Info_forbidOutPost[intval($webdb[Info_forbidOutPost])]=' checked ';
	$Info_DelEndtime[intval($webdb[Info_DelEndtime])]=' checked ';
	$Jump_fromarea[intval($webdb[Jump_fromarea])]=' checked ';
	$Jump_allcity[intval($webdb[Jump_allcity])]=' checked ';
	$Force_Choose_City[intval($webdb[Force_Choose_City])]=' checked ';
	$Info_allowGuesSearch[intval($webdb[Info_allowGuesSearch])]=' checked ';
	$Info_Searchkeyword[intval($webdb[Info_Searchkeyword])]=' checked ';

	$Info_ShowNoYz[intval($webdb[Info_ShowNoYz])]=' checked ';

	$Info_htmlType[intval($webdb[Info_htmlType])]=' checked ';

	$module_close[intval($webdb[module_close])]=' checked ';
	
	$Info_UseEndTime[intval($webdb[Info_UseEndTime])]=' checked ';
	$Info_MemberChooseCity[intval($webdb[Info_MemberChooseCity])]=' checked ';
	$Info_allcityType[intval($webdb[Info_allcityType])]=' checked ';

	$Info_index_cache[intval($webdb[Info_index_cache])]=' checked ';

	$Info_sys[intval($webdb[Info_sys])]=' checked ';

	$if_GGmap[intval($webdb[if_GGmap])]=' checked ';
	

	$group_UpPhoto=group_box("webdbs[group_UpPhoto]",explode(",",$webdb[group_UpPhoto]),array(2));
	$Post_group_UpPhoto=group_box("webdbs[Post_group_UpPhoto]",explode(",",$webdb[Post_group_UpPhoto]));


	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/config.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='yzimg'&&$Apower[center_config])
{
	$YzImg_letter_differ[intval($webdb[YzImg_letter_differ])]=' checked ';
	$YzImg_difficult[intval($webdb[YzImg_difficult])]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/yzimg.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="olpay"&&$Apower[center_config])
{
	$Money2card[$webdb[Money2card]]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/olpay.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="sms"&&$Apower[center_config])
{
	$sms_type[$webdb[sms_type]]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/sms.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="mail"&&$Apower[center_config])
{
	$MailType[$webdb[MailType]]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/mail.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="gd_img"&&$Apower[center_config])
{
	if(!function_exists("ImageJpeg")&&!function_exists("imagegif")){
		echo "报错提示:你的空间没装GD库不支持图片处理功能,请必须禁用以下所有功能,否则系统运行不正常<br><br><br><br>";
	}
	if($webdb[waterAlpha]<1){
		$webdb[waterAlpha]=100;
	}
	$webdb[is_waterimg]=intval($webdb[is_waterimg]);
	$is_waterimg["$webdb[is_waterimg]"]=" checked ";

	$if_gdimg[intval($webdb[if_gdimg])]=" checked ";

	$webdb[waterpos]=intval($webdb[waterpos]);
	$waterpos["$webdb[waterpos]"]=" checked ";
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/gd_img.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="othersystem"&&$Apower[center_config])
{
	$webdb[passport_type] || $webdb[passport_type]=0;
	$webdb[passport_TogetherLogin]=intval($webdb[passport_TogetherLogin]);
	$passport_TogetherLogin["$webdb[passport_TogetherLogin]"]=" checked ";
	$passport_type["$webdb[passport_type]"]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/othersystem.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="yz"&&$Apower[center_config])
{
	$EditYzEmail[intval($webdb[EditYzEmail])]=' checked ';
	$EditYzMob[intval($webdb[EditYzMob])]=' checked ';
	$EditYzIdcard[intval($webdb[EditYzIdcard])]=' checked ';

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/yz.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="vistlimit"&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/vistlimit.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="givemoney"&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/givemoney.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="user_reg"&&($Apower[user_reg]||$Apower[center_config]))
{
	$reg_group='';
	$query=$db->query("SELECT * FROM {$pre}group ORDER BY gid ASC");
	while($rs=$db->fetch_array($query))
	{
		$checked=in_array($rs[gid],explode(",",$webdb[reg_group]))?"checked":"";
		
		if($webdb[groupUpType]){
			$disabled=($rs[gid]==3||$rs[gid]==2||$rs[gid]==4||$rs[levelnum]>0)?' disabled ':'';
		}else{
			$disabled=($rs[gid]==3||$rs[gid]==2||$rs[gid]==4||$rs[levelnum]>0||(!$rs[levelnum]&&!$rs[gptype]&&$rs[gid]!=8))?' disabled ':'';
		}
		$reg_group.="<input type='checkbox' $disabled name='webdbs[reg_group][]' value='{$rs[gid]}' $checked>&nbsp;{$rs[grouptitle]}&nbsp;&nbsp;";
	}

	$forbidReg[$webdb[forbidReg]]=' checked ';
	$RegYz[intval($webdb[RegYz])]=' checked ';
	$RegCompany[intval($webdb[RegCompany])]=' checked ';
	$yzImgReg[$webdb[yzImgReg]]=" checked ";
	$emailOnly[intval($webdb[emailOnly])]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/user_reg.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="ftp"&&$Apower[center_config])
{
	$UseFtp[intval($webdb[UseFtp])]=" checked ";
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/ftp.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="contribute"&&$Apower[center_config])
{
	$webdb[ifContribute]==='0' || $webdb[ifContribute]=1;
	$ifContribute[$webdb[ifContribute]]=" checked ";
	$webdb[groupPassContribute]="$webdb[groupPassContribute],3";
	$groupPassContribute=group_box("webdbs[groupPassContribute]",explode(",",$webdb[groupPassContribute]));
	

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/contribute.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="money"&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/money.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="config"&&($Apower[center_config]||$Apower[center_cache]||$Apower[user_reg]))
{
	if($webdb[NewsMakeHtml]==1 && $webdbs[RewriteUrl]==1){
		showmsg('你已经选择了真静态,就不能选择伪静态,要使用伪静态,请先取消真静态!!');
	}

	if($ifmakeindexhtml=='N')
	{
		$webdbs[MakeIndexHtmlTime]=0;
	}
	elseif($ifmakeindexhtml=='Y'&&$webdbs[MakeIndexHtmlTime]<1)
	{
		$webdbs[MakeIndexHtmlTime]=700;
	}



	if( isset($webdbs[copyright]) )
	{
		$webdbs[hideFid]=$hideFid;
	}
	write_config_cache($webdbs);
	jump("修改成功",$FROMURL);
}
elseif($job=="cc_attack"&&$Apower[center_config])
{
	$cc_attack[intval($webdb[cc_attack])]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/cc_attack.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="setindex"&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/setindex.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='limitip'&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/limitip.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='cache'&&($Apower[center_cache]||$Apower[center_config]))
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/cache.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="delindex"&&$Apower[center_config])
{
	if(is_file(dirname(__FILE__)."/"."..$webdb[path]/index.htm")){
		@unlink(dirname(__FILE__)."/"."..$webdb[path]/index.htm.bak");
		@rename(dirname(__FILE__)."/"."..$webdb[path]/index.htm","..$webdb[path]/index.htm.bak");
	}
	if($returnto){
		jump("执行完毕",$returnto);
	}
	jump("执行完毕","index.php?lfj=center&job=map");
}
elseif($job=="module"&&$Apower[center_config])
{
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/center/menu.htm");
	require(dirname(__FILE__)."/"."template/center/module.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=="map")
{
	$systemMsg=systemMsg();
	$OfficialNotice=read_file(ROOT_PATH."cache/OfficialNotice.txt");
	if(WEB_LANG=='utf-8')$OfficialNotice=gbk2utf8($OfficialNotice);

	$Member = $userDB->total_num();

	extract($db->get_one("SELECT COUNT(*) AS fenleiNUM FROM {$pre}fenlei_db"));
	extract($db->get_one("SELECT COUNT(*) AS CommentNUM FROM {$pre}fenlei_comments"));
	extract($db->get_one("SELECT COUNT(*) AS dianpingNUM FROM {$pre}fenlei_dianping"));


	if(!strstr(preg_replace("/http:\/\/(www\.|)(.*)/is","\\2",$WEBURL),preg_replace("/http:\/\/(www\.|)(.*)/is","\\2",$webdb[www_url]))&&$webdb[www_url]!='/.'){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
		echo "<CENTER><A HREF='index.php?lfj=center&job=config' style='color:red;font-size:25px;'>严重警告,你设置的“整站访问网址”有误,请点击重新设置</A></CENTER>";
		exit;
	}
	if(!strstr($WEBURL,$webdb[admin_url])){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
		echo "<CENTER><A HREF='index.php?lfj=center&job=config' style='color:red;font-size:25px;'>严重警告,你设置的“后台访问网址”有误,请点击重新设置</A></CENTER>";
		exit;
	}

	
	unset($dirdb);
	$dirdb[]="data";
	$dirdb[]="data/group";
	//$dirdb[]="data/style";

	$dirdb[]="cache";
	//$dirdb[]="cache/hack";
	$dirdb[]="cache/mysql_bak";

	$dirdb[]=$webdb[updir];

	foreach( $dirdb AS $key=>$value){
		$dirname=ROOT_PATH.$value;
		if(!is_writable($dirname)){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
			echo "<CENTER><A style='color:red;font-size:25px;'>严重警告,".$dirname."此目录不可写，请用FTP修改其属性为0777可写</A></CENTER>";
			exit;
		}
		$dir=opendir($dirname);
		while($file=readdir($dir)){
			if($file=='.'||$file=='..'){
				continue;
			}
			$_f=$dirname.'/'.$file;
			if(!is_writable($_f)){
				echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
				echo "<CENTER><A style='color:red;font-size:25px;'>严重警告,".$_f."此目录不可写，请用FTP修改其属性为0777可写</A></CENTER>";
				exit;
			}
		}
	}

	if( mysql_get_server_info() > '4.1' && $webdb[passport_type] ){
		$c1=$userDB->get_passport_charset();
		$array=$db->get_one("SHOW CREATE TABLE {$pre}memberdata");
		preg_match("/DEFAULT CHARSET=([-0-9a-z]+)/is",$array['Create Table'],$ar);
		$c2=$ar[1];
		if($c1&&$c2&&($c1!=$c2)){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
			echo "<CENTER><A style='color:red;font-size:25px;'>严重警告,整合论坛失败,因为你论坛使用的数据库编码是:$c1,而整站使用的数据库编码是:$c2,这是不允许的，必须使整站的数据库编码与论坛的一样，现在你必须备份整站数据库,然后修改数据库配置文件data/mysql_config.php数据库编码为$c1，然后再到地址栏还原数据库选择编码为:$c1,只能在地址栏还原.不能在后台还原.因为后台还原不能选择数据库编码,以上操作步骤绝对不能颠倒,即第一步整站后台备份数据,第二步修改数据库配置文件,第三步地址栏目还原数据库</A></CENTER>";
			exit;
		}
	}

	if( mysql_get_server_info() > '4.1' ){
		$array=$db->get_one("SHOW CREATE TABLE {$pre}config");
		preg_match("/DEFAULT CHARSET=([-0-9a-z]+)/is",$array['Create Table'],$ar);
		$c2=$ar[1];
		if($c2&&$c2!=$dbcharset){
			echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
			echo "<CENTER><A style='color:red;font-size:25px;'>严重警告,你的数据库编码是:$c2,你必须修改文件/data/mysql_config.php，在他倒数第二行加上这句话(注意结尾分号不能少):\$dbcharset = '$c2';</A></CENTER>";
			exit;
		}
	}

	if( mysql_get_server_info() < '4.1' && $dbcharset){
		echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
		echo "<CENTER><A style='color:red;font-size:25px;'>严重警告,你的数据库是低版本，你必须修改文件/data/mysql_config.php，在他倒数第二行加上这句话(注意结尾分号不能少):\$dbcharset = '';</A></CENTER>";
		exit;
	}
	
	if( eregi("^pwbbs",$webdb[passport_type]) && $webdb[passport_TogetherLogin] )
	{
		@include(ROOT_PATH."$webdb[passport_path]/data/bbscache/config.php");
		if($db_ckdomain!=$webdb[cookieDomain])
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
			echo "<CENTER><A HREF='index.php?lfj=center&job=config' style='color:red;font-size:25px;'>严重警告,你设置的“COOKIE域名”有误,请点击重新设置,你必须跟论坛保持一致,如果论坛设置,那么整站也要设置,如果论坛不设置,整站也不能设置,必须要保持一致.否则同步登录会不成功</A></CENTER>";
			exit;
		}
	}

	if( eregi("^dzbbs",$webdb[passport_type]) && $webdb[passport_TogetherLogin] )
	{
		@include(ROOT_PATH."$webdb[passport_path]/config.inc.php");
		if($cookiedomain!=$webdb[cookieDomain])
		{
			echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />';
			echo "<CENTER><A HREF='index.php?lfj=center&job=config' style='color:red;font-size:25px;'>严重警告,你设置的“COOKIE域名”有误,请点击重新设置,你必须跟论坛保持一致,如果论坛设置,那么整站也要设置,如果论坛不设置,整站也不能设置,必须要保持一致.否则同步登录会不成功</A></CENTER>";
			exit;
		}
	}
	if($webdb[SystemType]&&is_file("map.php")){		//考虑独立版分类
		require_once("map.php");
	}
	require(dirname(__FILE__)."/"."template/map.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

elseif($job=='GetOfficialNotice'){
	$OfficialUrl2='du.com';
	$OfficialUrl1='www.bai';
	$files=read_file("template/map.htm");
	if(!strstr($files,'$OfficialNotice')&&filesize(ROOT_PATH."cache/OfficialNotice.txt")>9){
		echo "<SCRIPT LANGUAGE='JavaScript'>
			<!--
			function openwindows(){
				//window.open('http://$OfficialUrl1$OfficialUrl2/OfficialNotice.php?E=$qibosoft_Edition&upgrade_Record=$webdb[upgrade_Record]');
				}
			openwindows();
			//-->
		</SCRIPT>";
	}if( !@copy("http://$OfficialUrl1$OfficialUrl2/OfficialNotice.php?E=$qibosoft_Edition&upgrade_Record=$webdb[upgrade_Record]&U=$webdb[www_url]&T=FL",ROOT_PATH."cache/OfficialNotice.txt") )
	{
		if(!$OfficialNotice=file_get_contents("http://$OfficialUrl1$OfficialUrl2/OfficialNotice.php?E=$qibosoft_Edition&upgrade_Record=$webdb[upgrade_Record]&U=$webdb[www_url]&T=FL"))
		{
			$OfficialNotice=sockOpenUrl("http://$OfficialUrl1$OfficialUrl2/OfficialNotice.php?E=$qibosoft_Edition&upgrade_Record=$webdb[upgrade_Record]&U=$webdb[www_url]&T=FL");
		}
		write_file(ROOT_PATH."cache/OfficialNotice.txt",$OfficialNotice);
	}
	exit;}
phpinfo();
?>