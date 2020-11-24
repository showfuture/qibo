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

if($groupdb[refurbish_auto_fenlei_num]<1){
	showerr('你所在用户组无权设置自动刷新功能');
}

$_erp=$Fid_db[tableid][$fid];
$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$id'");
if($rs[uid]!=$lfjuid&&!$web_admin){
	showerr('你无权限');
}

if(!is_table("{$_pre}refurbish")){
	$db->insert_file('',"CREATE TABLE `{$_pre}refurbish` (
  `id` int(10) NOT NULL default '0',
  `uid` int(7) NOT NULL default '0',
  `times` varchar(255) NOT NULL default '',
  `refurbish_time` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`)
  ) TYPE=MyISAM;");
}

if($type=='del'){
	$db->query("DELETE FROM {$_pre}refurbish WHERE id='$id'");
	refurbish_info(true);
	refreshto("$FROMURL","操作成功,本条信息被取消了自动刷新!",2);
}

$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}refurbish WHERE uid='$rs[uid]' AND id!='$id'");
if($ts[NUM]>=$groupdb[refurbish_auto_fenlei_num]){
	showerr("你所在用户组最多只能设置 {$groupdb[refurbish_auto_fenlei_num]} 条信息自动刷新");
}
if($postdb[h1]==$postdb[h2] && $postdb[i2]==$postdb[i1]){
	//showerr("请认真设置好刷新时间点");
}
$s = date('s');
//$times="$postdb[h1]$postdb[i1]$s#$postdb[h2]$postdb[i2]$s";
$times="$postdb[h1]$postdb[i1]$s";

//避免每次添加新信息就刷新
$His=date('His',$timestamp);
$z=date('z',$timestamp);
while(strlen($z)<3)$z="0$z";	//一年中小于100天的要补够三位数

$db->query("REPLACE INTO  `{$_pre}refurbish` (  `id` ,  `uid` ,  `times` ,`refurbish_time`) VALUES ('$id',  '$rs[uid]',  '$times','$z$His')");

refurbish_info(true);

refreshto("$FROMURL","操作成功,本条信息被设置为自动刷新了!",1);
?>