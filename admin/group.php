<?php
!function_exists('html') && exit('ERR');
if($job=="list"&&$Apower[group_list])
{
	$query=$db->query("SELECT * FROM `{$pre}group` ORDER BY gptype DESC,levelnum ASC");
	while( $rs=$db->fetch_array($query) ){
		if($rs[gptype]){
			$listdb_1[]=$rs;
			$rs[ifSystem]='高级系统组';
		}else{
			$listdb_0[]=$rs;
			$rs[ifSystem]='普通会员组';
		}
		$listdb[]=$rs;
	}

	$groupUpType[intval($webdb[groupUpType])]=' checked ';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/group/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="list_admin"&&$Apower[group_list_admin])
{
	$query=$db->query("SELECT * FROM `{$pre}group` ORDER BY gptype DESC,levelnum ASC");
	while( $rs=$db->fetch_array($query) ){
		if($rs[gptype]){
			$listdb_1[]=$rs;
			$rs[ifSystem]='高级系统组';
		}else{
			$listdb_0[]=$rs;
			$rs[ifSystem]='普通会员组';
		}
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/group/list_admin.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="add"&&$Apower[group_add])
{
	$query=$db->query("SELECT * FROM `{$pre}group` ORDER BY gptype DESC,levelnum ASC");
	while( $rs=$db->fetch_array($query) ){
		if($rs[gptype]){
			$listdb_1[]=$rs;
			$rs[ifSystem]='高级系统组';
		}else{
			$listdb_0[]=$rs;
			$rs[ifSystem]='普通会员组';
		}
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/group/add.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="add"&&$Apower[group_add])
{
	if(!$postdb[grouptitle]){
		showmsg("用户组名称不能为空");
	}
	$rs=$db->get_one("SELECT * FROM `{$pre}group` WHERE `grouptitle`='$postdb[grouptitle]'");
	if($rs){
		showmsg("当前用户组名称已经存在了,请更换一个");
	}
	$db->query("INSERT INTO `{$pre}group` (`gptype`,`grouptitle`,`levelnum`) VALUES ('$postdb[gptype]','$postdb[grouptitle]','$postdb[levelnum]')");
	write_group_cache();
	$gid=$db->insert_id();
	jump("用户组添加成功,请设置权限","index.php?lfj=$lfj&job=edit&gid=$gid");
}
elseif($action=="edit"&&$Apower[group_list])
{
	
	//$totalspace=$postdb[totalspace]*1024*1024;

	$rsdb=$db->get_one(" SELECT powerdb FROM `{$pre}group` WHERE gid='$gid' ");
	$power_db=@unserialize($rsdb[powerdb]);
	if(is_array($power_db))
	{
		$powerdb=array_merge($power_db,$powerdb);
	}

	$_powerdb=addslashes(@serialize($powerdb));
	$db->query(" UPDATE `{$pre}group` SET gptype='$postdb[gptype]',grouptitle='$postdb[grouptitle]',levelnum='$postdb[levelnum]',allowsearch='$postdb[allowseerch]',totalspace='$postdb[totalspace]',allowadmin='$postdb[allowadmin]',powerdb='$_powerdb' WHERE gid='$gid' ");
	write_group_cache();
	jump("修改成功","index.php?lfj=group&job=edit&gid=$gid");
}
elseif($action=="delete"&&$Apower[group_list])
{
	$db->query(" DELETE FROM `{$pre}group` WHERE gid='$gid' ");
	$db->query(" DELETE FROM `{$pre}admin_menu` WHERE groupid='$gid' ");
	unlink(ROOT_PATH."data/group/$gid.php");
	write_group_cache();
	jump("删除成功","index.php?lfj=$lfj&job=list");
}
elseif($action=="list"&&$Apower[group_list])
{
	foreach($postdb AS $key=>$rs){
		$db->query("UPDATE `{$pre}group` SET grouptitle='$rs[grouptitle]',levelnum='$rs[levelnum]' WHERE gid='$key' ");
	}
	write_group_cache();
	jump("修改成功","index.php?lfj=$lfj&job=list");
}
elseif($job=="edit"&&$Apower[group_list])
{
	$select_group=select_group("gid",$gid,"index.php?lfj=group&job=edit");
	$rsdb=$db->get_one(" SELECT * FROM `{$pre}group` WHERE gid='$gid' ");
	$powerdb=@unserialize($rsdb[powerdb]);

	if($gid==3||$gid==4){		
		$powerdb[comment_yz]=$powerdb[PassContribute]=1;
		$powerdb[comment_img]=0;
	}

	$powerdb[PassContribute]=intval($powerdb[PassContribute]);
	$PassContribute[$powerdb[PassContribute]]=" checked ";
	$rsdb_gptype[$rsdb[gptype]]=" checked ";
	$allowseerch[$rsdb[allowsearch]]=' checked ';
	$allowadmin[$rsdb[allowadmin]]=' checked ';
	$EditPassPower[intval($powerdb[EditPassPower])]=' checked ';
	$AllowUploadMax[intval($powerdb[AllowUploadMax])]=' checked ';

	$comment_yz[intval($powerdb[comment_yz])]=' checked ';
	$comment_img[intval($powerdb[comment_img])]=' checked ';

	$use2domain[intval($powerdb[use2domain])]=' checked ';
	$useHomepageStyle[intval($powerdb[useHomepageStyle])]=' checked ';
	$view_buy_view_contact[intval($powerdb[view_buy_view_contact])]=' checked ';

	$shop_postauto_yz[intval($powerdb[shop_postauto_yz])]=' checked ';
	$tg_postauto_yz[intval($powerdb[tg_postauto_yz])]=' checked ';
	$post_coupon_yz[intval($powerdb[post_coupon_yz])]=' checked ';

	
	$allow_get_homepage[intval($powerdb[allow_get_homepage])]=' checked ';

	//$rsdb[totalspace]=floor($rsdb[totalspace]/(1024*1024));

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/group/mod.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="admin_gr"&&$Apower[group_list_admin])
{
	write_hackmenu_cache();	//重新给插件生成一次缓存
	require(dirname(__FILE__)."/"."menu.php");
	$adminDB=$menudb;
	$rsdb=$db->get_one("SELECT * FROM {$pre}group WHERE gid='$gid'");
	$grdb=unserialize($rsdb[allowadmindb]);
	$mygrdb=$grdb[mymenu];
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/group/admin_gr.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="admin_gr"&&$Apower[group_list_admin])
{
	if(!$adgrdb){
		$allowadmin=0;
	}else{
		$allowadmin=1;
	}
	$adgrdb[mymenu]=$myadgrdb;
	$db->query("UPDATE {$pre}group SET allowadmindb='".serialize($adgrdb)."',allowadmin='$allowadmin' WHERE gid='$gid'");
	write_group_cache();
	jump("修改成功","$FROMURL",1);
}
elseif($action=="set"&&$Apower[group_list_admin])
{
	write_config_cache($webdbs);
	jump("修改成功",$FROMURL);
}

?>