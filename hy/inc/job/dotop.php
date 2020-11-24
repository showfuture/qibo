<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjuid){
	showerr('请先登录');
}

$rs=$db->get_one("SELECT admin FROM {$pre}fenlei_city WHERE fid='$city_id'");
$detail=explode(',',$rs[admin]);
if(in_array($lfjid,$detail)){
	$web_admin=1;
}


$rs=$db->get_one("SELECT * FROM {$_pre}content WHERE id='$id'");
if($rs[uid]!=$lfjuid&&!$web_admin){
	showerr('你没权限');
}
$list=$timestamp+3600*24*$webdb[Info_TopDay];
if(!$web_admin){
	$lfjdb[money]=intval(get_money($lfjuid));
	if($lfjdb[money]<$webdb[Info_TopMoney]){
		showerr("你的积分不足:$webdb[Info_TopMoney],不能选择置顶");
	}
	add_user($lfjuid,-intval($webdb[Info_TopMoney]));
}
$db->query("UPDATE {$_pre}content SET list='$list' WHERE id='$id'");
refreshto("$FROMURL","置顶成功",1);
?>