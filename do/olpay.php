<?php
require("global.php");

if(in_array($banktype,array('alipay','tenpay','chinabank','yeepay'))){
	include(ROOT_PATH."inc/olpay/{$banktype}.php");
}elseif($banktype){
	showerr("支付类型有误!");	
}

require(ROOT_PATH."inc/head.php");
require(html("olpay"));
require(ROOT_PATH."inc/foot.php");

function olpay_send(){
	global $db,$pre,$webdb,$banktype,$atc_moeny,$timestamp,$lfjuid,$lfjid,$pay_code;
	
	if(!$pay_code){
		showerr("数据有误!");
	}
	list($type,$atc_moeny,$numcode,$mid)=explode("\t",mymd5($pay_code,'DE'));
	
	while(strlen($numcode)<10){
		$numcode="0$numcode";
	}

	$array[money]=$atc_moeny;
	$pay_code = str_replace('=','QIBO',$pay_code);	//这个符号“=”容易出问题
	$array[return_url]="$webdb[www_url]/do/olpay.php?banktype=$banktype&pay_code=$pay_code&";
	$array[title]="在线付款";
	$array[content]="为帐号:$lfjid,在线付款";
	$array[numcode]=$numcode;
	
	//万能表单订单
	if($type=='form'){
		$db->query("INSERT INTO {$pre}olpay (`numcode` , `money` , `posttime` , `uid` , `username`, `banktype`, `formid` ) VALUES ('$array[numcode]','$array[money]','$timestamp','$lfjuid','$lfjid','$banktype','$mid')");
	
	//商城订单
	}elseif($type=='module'){
		$db->query("INSERT INTO {$pre}olpay (`numcode` , `money` , `posttime` , `uid` , `username`, `banktype`, `moduleid` ) VALUES ('$array[numcode]','$array[money]','$timestamp','$lfjuid','$lfjid','$banktype','$mid')");
	}

	return $array;
}

function olpay_end($numcode){
	global $db,$pre,$webdb,$banktype,$pay_code,$lfjuid;

	if(!$pay_code){
		showerr("数据有误!!");
	}
	list($type,$atc_moeny,$atc_numcode,$mid,$shopmoney)=explode("\t",mymd5($pay_code,'DE'));
	if($atc_numcode!=intval($numcode)){
		showerr("数据被修改过!!");
	}

	//主要是针对支付宝不能单纯一位数字的问题,inc/olpay/alipay.php,文件中做了修改
	$numcode=str_replace("code","",$numcode);

	//万能表单订单
	if($type=='form'){
		$rt = $db->get_one("SELECT * FROM {$pre}olpay WHERE numcode='$numcode' AND `formid`='$mid'");

	//商城订单
	}elseif($type=='module'){
		$rt = $db->get_one("SELECT * FROM {$pre}olpay WHERE numcode='$numcode' AND `moduleid`='$mid'");
		$db->query("UPDATE {$pre}shoporderuser SET ifpay='1' WHERE id='$atc_numcode'");
		//奖励积分
		if($shopmoney){
			add_user($lfjuid,$shopmoney,'购买商品得分');
		}
	}	
	if(!$rt){
		showerr('系统中没有您的订单，无法完成支付！');
	}
	if($rt['ifpay'] == 1){
		showerr('该订单已经支付成功！');
	}
	$db->query("UPDATE {$pre}olpay SET ifpay='1' WHERE id='$rt[id]'");

	refreshto("$webdb[www_url]/","恭喜你支付成功",60);
}

?>