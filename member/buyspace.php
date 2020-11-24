<?php
require("global.php");

if(!$lfjid){
	showerr("你还没登录");
}

$lfjdb[money]=get_money($lfjuid);

$webdb[BuySpacesizeMoney]>0 || $webdb[BuySpacesizeMoney]=100;
if($action=='buy')
{
	if($spacesize<1){
		showerr("购买的空间容量不能小于1M");
	}
	if(!is_numeric($spacesize)){
		showerr("购买的空间容量必须是整数多少M");
	}
	$spacesize=intval($spacesize);
	$totalmoney=$spacesize*$webdb[BuySpacesizeMoney];
	if( $lfjdb[money]<$totalmoney ){
		showerr("你的积分不足$totalmoney");
	}
	$spacesize=$spacesize*1024*1024;
	$db->query("UPDATE {$pre}memberdata SET totalspace=totalspace+$spacesize WHERE uid='$lfjuid'");
	add_user($lfjuid,-$totalmoney,'购买空间奖分');
	refreshto("$FROMURL","恭喜你,购买空间成功,共消费了你 {$totalmoney} 个积分",10);
}

 
//已使用空间
$lfjdb[usespace]=number_format($lfjdb[usespace]/(1024*1024),3);

//系统允许使用空间
$space_system=number_format($webdb[totalSpace],3);

//用户组允许使用空间
$space_group=number_format($groupdb[totalspace],3);

//用户本身具有的空间
$space_user=number_format($lfjdb[totalspace]/(1024*1024),3);

//用户余下空间
$lfjdb[totalspace]=number_format($webdb[totalSpace]+$groupdb[totalspace]+$lfjdb[totalspace]/(1024*1024)-$lfjdb[usespace],3);

require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/buyspace.htm");
require(dirname(__FILE__)."/"."foot.php");

?>