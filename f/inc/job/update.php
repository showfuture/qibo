<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjuid){
	showerr('请先登录');
}

$rs=$db->get_one("SELECT admin FROM {$_pre}city WHERE fid='$_COOKIE[admin_cityid]'");
$detail=explode(',',$rs[admin]);
if(in_array($lfjid,$detail)){
	$web_admin=1;
}

$groupdb[refurbish_fenlei_num] || $groupdb[refurbish_fenlei_num]=5;

$_erp=$Fid_db[tableid][$fid];
$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$id'");
if($rs[uid]!=$lfjuid&&!$web_admin){
	showerr('你无权限');
}
$webdb[UpdatePostTime]>0 || $webdb[UpdatePostTime]=1;
if($timestamp-$rs[posttime]<(3600*$webdb[UpdatePostTime])){
	showerr("距离上次更新时间{$webdb[UpdatePostTime]}小时后,才可以操作!");
}

$time=$timestamp-3600*24;
if(count(Info_list_content("WHERE uid='$rs[uid]' AND posttime>$time","","",array_flip($Fid_db[tableid])))>=$groupdb[refurbish_fenlei_num]){
	showerr("你当前所在用户组24小时内刷新与新发表累计不能超过{$groupdb[refurbish_fenlei_num]}条信息!");
}

if($rs['list']>$timestamp){
	$list=$rs['list'];
}else{
	$list=$timestamp;
}
$db->query("UPDATE {$_pre}content$_erp SET list='$list',posttime='$timestamp' WHERE id='$id'");

refurbish_info(true);

refreshto("$FROMURL","操作成功,本条信息被顶在列表页的前面了!",1);
?>