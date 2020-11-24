<?php
require("global.php");

if(!$lfjid){
	showerr("你还没登录");
}

$lfjdb[money]=get_money($lfjuid);
$webdb[MoneyRatio]=intval($webdb[MoneyRatio]);


if($action=="del_record"){
	$db->query("DELETE FROM {$pre}olpay WHERE uid='$lfjuid' AND id='$id'");
}
if($job=="record")
{
	if($page<1){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	unset($listdb);
	$showpage=getpage("{$pre}olpay","WHERE uid='$lfjuid'","?job=$job",$rows);
	$query = $db->query("SELECT * FROM {$pre}olpay WHERE uid='$lfjuid' ORDER BY id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[ifpay]=$rs[ifpay]?"<font color=red>支付成功</font>":"支付失败";
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		if($rs[banktype]=='tenpay'){
			$rs[banktype]="财付通";
		}elseif($rs[banktype]=='alipay'){
			$rs[banktype]="支付宝";
		}elseif($rs[banktype]=='99pay'){
			$rs[banktype]="快钱";
		}elseif($rs[banktype]=='yeepay'){
			$rs[banktype]="易宝支付";
		}else{
			$rs[banktype]="其它方式";
		}
		$listdb[]=$rs;
	}
}

require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/money.htm");
require(dirname(__FILE__)."/"."foot.php");

?>