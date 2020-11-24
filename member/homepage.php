<?php
require("global.php");
@include_once(ROOT_PATH."data/all_area.php");
if(!$uid&&!$username)
{
	$uid=$lfjuid;
}
$uid = intval($uid);
if($uid)
{
	$rsdb = $userDB->get_info($uid);
}
elseif($username)
{
	$rsdb = $userDB->get_info($username,'name');
}

if(!$rsdb)
{
	showerr("用户不存在");
}

$db->query("UPDATE {$pre}memberdata SET hits=hits+1,lastview='$timestamp' WHERE uid='$uid'");

$rsdb[money]=get_money($rsdb[uid]);


$group_db=$db->get_one("SELECT totalspace,grouptitle FROM {$pre}group WHERE gid='$rsdb[groupid]' ");

//已使用空间
$rsdb[usespace]=number_format($rsdb[usespace]/(1024*1024),3);

//系统允许使用空间
$space_system=number_format($webdb[totalSpace],3);

//用户组允许使用空间
$space_group=number_format($group_db[totalspace],3);

//用户本身具有的空间
$space_user=number_format($rsdb[totalspace]/(1024*1024),3);

//用户余下空间
$rsdb[totalspace]=number_format($webdb[totalSpace]+$group_db[totalspace]+$rsdb[totalspace]/(1024*1024)-$rsdb[usespace],3);

if($rsdb[sex]==1)
{
	$rsdb[sex]='男';
}
elseif($rsdb[sex]==2)
{
	$rsdb[sex]='女';
}
else
{
	$rsdb[sex]='保密';
}

$rsdb[lastvist]=date("Y-m-d H:i:s",$rsdb[lastvist]);
$rsdb[regdate]=date("Y-m-d H:i:s",$rsdb[regdate]);
$rsdb[introduce]=str_replace("\n","<br>",$rsdb[introduce]);

if($lfjuid!=$rsdb[uid]&&!$web_admin)
{
	$rsdb[regip]=$rsdb[address]=$rsdb[postalcode]=$rsdb[telephone]=$rsdb[mobphone]=$rsdb[idcard]=$rsdb[truename]="保密";
}
$rsdb[icon]=tempdir($rsdb[icon]);

$rsdb[lastip]=ipfrom($rsdb[lastip]);

$rsdb[postalcode]==0&&$rsdb[postalcode]='';

$rsdb[lastview]=$rsdb[lastview]?date("Y-m-d H:i",$rsdb[lastview]):'未知';
$rsdb[hits] || $rsdb[hits]='未知';






//论坛贴子
$mybbsDB='';
if( ereg("^pwbbs",$webdb[passport_type]) ){
	$query = $db->query("SELECT * FROM {$TB_pre}threads WHERE authorid='$uid' ORDER BY tid DESC LIMIT 10");
	while($rs = $db->fetch_array($query)){
		$mybbsDB[]=$rs;
	}
}

//过滤不健康的字
$rsdb[truename]=replace_bad_word($rsdb[truename]);
$rsdb[introduce]=replace_bad_word($rsdb[introduce]);
$rsdb[address]=replace_bad_word($rsdb[address]);

@include(ROOT_PATH."data/all_fid.php");
$myarticleDB = '';
$query = $db->query("SELECT * FROM {$pre}fenlei_db WHERE uid='$uid' ORDER BY id DESC LIMIT 15");
while($rs = $db->fetch_array($query)){
	$_erp=$Fid_db[tableid][$rs[fid]];
	$rs=$db->get_one("SELECT * FROM {$pre}fenlei_content$_erp WHERE id='$rs[id]'");
	$rs[posttime]=date("y-m-d H:i:s",$rs[posttime]);
	$myarticleDB[]=$rs;
}

require(get_member_tpl('homepage'));

$content=ob_get_contents();
ob_end_clean();
ob_start();
if($webdb[www_url]=='/.'){
	$content=str_replace('/./','/',$content);
}
echo $content;
?>