<?php
require("global.php");

$linkdb=array();

$rows=20;
if($page<1){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("{$_pre}content","WHERE uid='$lfjuid' AND yz!=2","?job=$job",$rows);
$query = $db->query("SELECT * FROM {$_pre}content WHERE uid='$lfjuid' AND yz!=2 ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[levels]=$rs[levels]?"<font color=red>已荐</font>":"未荐";
	if($rs[yz]==1){
		$rs[state]="<font color='blue'>已审</font>";
	}elseif($rs[yz]==2){
		$rs[state]="<font color='#cccccc'>回收站</font>";
	}else{
		$rs[state]="未审";
	}
	
	$listdb[]=$rs;
}
require(ROOT_PATH."member/head.php");
require("template/list.htm");
require(ROOT_PATH."member/foot.php");

?>