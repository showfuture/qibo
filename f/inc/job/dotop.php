<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjuid){
	showerr('请先登录');
}

$TopDay = intval($TopDay);
if($TopDay<1 || $TopDay>$webdb[Info_TopDay]){
	$TopDay=1;
}

$rs=$db->get_one("SELECT admin FROM {$_pre}city WHERE fid='$_COOKIE[admin_cityid]'");
$detail=explode(',',$rs[admin]);
if(in_array($lfjid,$detail)){
	$web_admin=1;
}
$_erp=$Fid_db[tableid][$fid];
$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$id'");
if($rs[uid]!=$lfjuid&&!$web_admin){
	showerr('你没权限');
}
$list=$timestamp+3600*24*$TopDay;
if(!$web_admin){
	$lfjdb[money]=intval(get_money($lfjuid));
	if($lfjdb[money]<$webdb[Info_TopMoney]*$TopDay){
		showerr("你的{$webdb[MoneyName]}不足:".$webdb[Info_TopMoney]*$TopDay."{$webdb[MoneyDW]},置顶失败");
	}
	add_user($lfjuid,-intval($webdb[Info_TopMoney]*$TopDay),'置顶信息扣分');
}
$db->query("UPDATE {$_pre}content$_erp SET list='$list' WHERE id='$id'");
refreshto("$FROMURL","置顶成功",1);
?>