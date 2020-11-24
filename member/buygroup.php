<?php
require("global.php");

if(!$lfjid){
	showerr("你还没登录");
}

$lfjdb[money]=get_money($lfjuid);

if($job=="buy"||$action=='buy'){
	$rsdb=$db->get_one("SELECT * FROM {$pre}group WHERE gid='$gid'");
	if(!$rsdb){
		showerr("资料有误");
	}	
}

if($action=='buy')
{
	$buyday = intval($buyday);
	$webdb[groupTime]>0 || $webdb[groupTime]=1;
	if($buyday<$webdb[groupTime]){
		showerr("你购买的天数不能小于 {$webdb[groupTime]} 天");
	}
	$total_money = ceil(abs($rsdb[levelnum]*$buyday));
	if($lfjdb[money]<$total_money){
		showerr("你的{$webdb[MoneyName]}不足 {$total_money} {$webdb[MoneyDW]}");
	}
	if($rsdb[gptype] || !$memberlevel[$gid]){
		showerr("系统级别,你不能购买!");
	}
	if($lfjdb[groupid]==3||$lfjdb[groupid]==4){
		showerr("你是管理员,不可以购买比你低的级别");
	}

	if($lfjdb[C][endtime]>$timestamp){ //重复购买,时间累加
		
		$remnant_time = $lfjdb[C][endtime]-$timestamp;
		$remnant_time = floor($remnant_time*intval($memberlevel[$lfjdb[groupid]])/$memberlevel[$gid]);
		$lfjdb[C][endtime] = $timestamp + $remnant_time + $buyday*86400;
	
	}else{
		$lfjdb[C][endtime] = $timestamp+$buyday*86400;
	}
	
	
	$config=addslashes(serialize($lfjdb[C]));
	$db->query("UPDATE {$pre}memberdata SET config='$config',groupid='$gid' WHERE uid='$lfjuid'");
	add_user($lfjuid,-$total_money,'购买会员级别扣分');
	refreshto("$FROMURL","恭喜你,升级成功",1);
}

 
$query = $db->query("SELECT * FROM {$pre}group WHERE gptype=0");
while($rs = $db->fetch_array($query)){
	$rs[g]=@include_once(ROOT_PATH."data/group/$rs[gid].php");
	$listdb[]=$rs;
}

if($lfjdb[C][endtime]&&$lfjdb[groupid]!=8){
	$lfjdb[C][endtime]=date("截止日期为: Y-m-d H:i ，",$lfjdb[C][endtime]);
}else{
	$lfjdb[C][endtime]='';
}

require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/buygroup.htm");
require(dirname(__FILE__)."/"."foot.php");

?>