<?php
require("global.php");

if(in_array($banktype,array('alipay','tenpay','chinabank','yeepay'))){
	include(ROOT_PATH."inc/olpay/{$banktype}.php");
}elseif($banktype){
	showerr("支付类型有误!");	
}

$lfjdb[money]=get_money($lfjuid);

require(ROOT_PATH."inc/head.php");
require(html("buymoneycard"));
require(ROOT_PATH."inc/foot.php");


function olpay_send(){
	global $db,$pre,$webdb,$banktype,$atc_moeny,$timestamp,$lfjuid,$lfjid,$webdb;
	
	$atc_moeny = intval($atc_moeny);
	if($atc_moeny<1){
		showerr("你输入的充值金额不能小于1");
	}

	$array[money]=$atc_moeny;
	$array[return_url]="$webdb[www]/do/buymoneycard.php?banktype=$banktype&";
	$array[title]="购买{$webdb[MoneyName]},为{$lfjid}在线充值";
	$array[content]="为帐号:$lfjid,在线付款购买{$webdb[MoneyName]}";
	$array[numcode]=strtolower(rands(10));

	$db->query("INSERT INTO {$pre}olpay (`numcode` , `money` , `posttime` , `uid` , `username`, `banktype`, `paytype` ) VALUES ('$array[numcode]','$array[money]','$timestamp','$lfjuid','$lfjid','$banktype','1')");

	return $array;
}

function olpay_end($numcode){
	global $db,$pre,$webdb,$banktype;

	$rt = $db->get_one("SELECT * FROM {$pre}olpay WHERE numcode='$numcode' AND `paytype`=1");
	if(!$rt){
		showerr('系统中没有您的充值订单，无法完成充值！');
	}
	if($rt['ifpay'] == 1){
		showerr('该订单已经充值成功！');
	}
	$db->query("UPDATE {$pre}olpay SET ifpay='1' WHERE id='$rt[id]'");
	
	$floor = floor($rt[money]/10);

	$num=$rt[money]*$webdb[alipay_scale] + $floor*$webdb[alipay_give_scale];
	
	add_user($rt[uid],$num,'在线充值');

	refreshto("$webdb[www_url]/","恭喜你充值成功",10);
}

?>