<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjid){
	showerr("你还没登录");
}
if($do=='del'){
	$db->query("DELETE FROM {$_pre}collection WHERE cid='$cid' AND uid='$lfjuid'");
}
if($page<1){
	$page=1;
}
$rows=20;
$min=($page-1)*$rows;

$showpage=getpage(" {$_pre}collection B ","WHERE B.uid=$lfjuid","?job=$job",$rows);
$listdb=array();
$query = $db->query("SELECT B.id,B.cid,B.posttime AS ctime FROM {$_pre}collection B WHERE B.uid=$lfjuid ORDER BY B.cid DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	if($rss=get_id_info($rs[id])){
		$rs+=$rss[$rs[id]];
	}
	$listdb[]=$rs;
}
foreach( $listdb AS $key=>$rs){
	if($rs[yz]==2){
		$rs[state]="<A style='color:red;'>作废</A>";
	}elseif($rs[yz]==1){
		$rs[state]="已审";
	}elseif(!$rs[yz]){
		$rs[state]="<A style='color:blue;'>待审</A>";
	}
	if($rs[levels]){
		$rs[levels]="<A style='color:red;'>已推荐</A>";
	}else{
		$rs[levels]="未推荐";
	}
	$rs[ctime]=date("Y-m-d",$rs[ctime]);
	$rs[title]=get_word($rs[full_title]=$rs[title],54);
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
	$listdb[$key]=$rs;
}

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/collection.htm");
require(ROOT_PATH."member/foot.php");
?>