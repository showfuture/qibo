<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjuid){
	showerr("ÇëÏÈµÇÂ¼");
}

if($act=='del'){
	$db->query("DELETE FROM {$pre}moneylog WHERE uid='$lfjuid' AND id='$id'");
}


$rows=20;
if(!$page){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("{$pre}moneylog","WHERE uid='$lfjuid'","?job=$job");
$query = $db->query("SELECT * FROM `{$pre}moneylog` WHERE uid='$lfjuid' ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[title] = get_word($rs[about],50);
	if($rs[money]>0){
		$rs[money]="<font color=red>$rs[money]</font>";
	}
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$listdb[]=$rs;
}

$lfjdb[money]=get_money($lfjuid);

require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/moneylog.htm");
require(dirname(__FILE__)."/"."foot.php");
 
?>