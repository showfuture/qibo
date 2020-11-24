<?php


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


@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' AND ifnew='1'"));

@extract($db->get_one("SELECT COUNT(*) AS infoNum FROM `{$pre}fenlei_db` WHERE `uid`='$lfjuid'"));
@extract($db->get_one("SELECT COUNT(*) AS CommentNum FROM `{$pre}fenlei_comments` WHERE `cuid`='$lfjuid'"));
@extract($db->get_one("SELECT COUNT(*) AS moneylogNum FROM `{$pre}moneylog` WHERE `uid`='$lfjuid'"));
@extract($db->get_one("SELECT COUNT(*) AS dianpingNum FROM `{$pre}fenlei_dianping` WHERE `uid`='$lfjuid'"));
@extract($db->get_one("SELECT COUNT(*) AS collectionNum FROM `{$pre}fenlei_collection` WHERE `uid`='$lfjuid'"));


?>