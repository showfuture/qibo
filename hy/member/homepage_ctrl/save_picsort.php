<?php
//更新图库

$name=filtrate($name);
$remarks=filtrate($remarks);
$orderlist=intval($orderlist);
if(strlen($name)<2 || strlen($name)>16)showerr("图集只能名称只能是1-8个汉字");
if(strlen($remarks)>100)showerr("描述最多50个字");

if($psid){ //更新
	$db->query("update `{$_pre}picsort` set 
	`name`='$name',
	`remarks`='$remarks',
	`orderlist`='$orderlist'
	where psid='$psid' AND uid='$uid'");

}else{ //添加

	$webdb[company_picsort_Max]=$webdb[company_picsort_Max]?$webdb[company_picsort_Max]:10;
	$mypicsortnum=$db->get_one("SELECT COUNT(*) AS num FROM {$_pre}picsort WHERE uid='$uid' ");
	if($mypicsortnum[num]>=$webdb[company_picsort_Max])	showerr("您的图集数量已经到最大数目{$webdb[company_picsort_Max]}");	

	$db->query("INSERT INTO `{$_pre}picsort` ( `psid` , `psup` , `name` , `remarks` , `uid` , `username` ,  `level` , `posttime` , `orderlist` ) 
	VALUES ('', '0', '$name', '$remarks', '$uid', '$lfjid',  '0', '$timestamp', '$orderlist');");
}

refreshto("?uid=$uid&atn=pic","保存成功");


?>