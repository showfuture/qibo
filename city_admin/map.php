<?php
require_once(dirname(__FILE__)."/"."global.php");
@include_once(ROOT_PATH."data/all_area.php");
if(!$lfjid){
	showerr("你还没登录");
}

if($lfjdb[sex]==1){
	$lfjdb[sex]='男';
}elseif($lfjdb[sex]==2){
	$lfjdb[sex]='女';
}else{
	$lfjdb[sex]='保密';
}

$group_db=$db->get_one("SELECT totalspace,grouptitle FROM {$pre}group WHERE gid='$lfjdb[groupid]' ");

//用户已使用空间
$lfjdb[usespace]=number_format($lfjdb[usespace]/(1024*1024),3);

//系统允许使用空间
$space_system=number_format($webdb[totalSpace],0);

//用户组允许使用空间
$space_group=number_format($group_db[totalspace],0);

//用户本身具有的空间
$space_user=number_format($lfjdb[totalspace]/(1024*1024),0);

//用户余下可用空间大小
$onlySpace=number_format($webdb[totalSpace]+$group_db[totalspace]+$lfjdb[totalspace]/(1024*1024)-$lfjdb[usespace],3);

$lfjdb[lastvist]=date("Y-m-d H:i:s",$lfjdb[lastvist]);
$lfjdb[regdate]=date("Y-m-d H:i:s",$lfjdb[regdate]);
$lfjdb[money]=get_money($lfjdb[uid]);

if($lfjdb[C][endtime]&&$lfjdb[groupid]!=8){
	$lfjdb[C][endtime]=date("Y-m-d",$lfjdb[C][endtime]);
	$lfjdb[C][endtime]="于{$lfjdb[C][endtime]}截止";
}else{
	$lfjdb[C][endtime]='长期有效';
}

if( ereg("^pwbbs",$webdb[passport_type]) ){
	@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM {$TB_pre}msg WHERE `touid`='$lfjuid' AND type='rebox' AND ifnew=1"));
}elseif( ereg("^dzbbs",$webdb[passport_type]) ){
	if($webdb[passport_type]=='dzbbs7'){
		$pmNUM=uc_pm_checknew($lfjuid);
	}else{
		@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM {$TB_pre}pms WHERE `msgtoid`='$lfjuid' AND folder='inbox' AND new=1"));
	}			
}else{
	@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' AND ifnew='1'"));
}

unset($fusername,$fuid,$vname,$vuid,$GuestbookNum,$CommentNum,$Lognum,$PhotoNum);






require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/map.htm");
require(dirname(__FILE__)."/"."foot.php");

?>