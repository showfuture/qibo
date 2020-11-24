<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjuid){
	showerr('请先登录');
}

$ShowDay = intval($ShowDay);
if($ShowDay<1||$ShowDay>$webdb[AdInfoShowTime]){
	$ShowDay = 1;
}

$rs=$db->get_one("SELECT admin FROM {$_pre}city WHERE fid='$_COOKIE[admin_cityid]'");
$detail=explode(',',$rs[admin]);
if(in_array($lfjid,$detail)){
	$web_admin=1;
}

$_erp=$Fid_db[tableid][$fid];
$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$id'");
$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$rs[fid]'");
if($rs[uid]!=$lfjuid&&!$web_admin){
	showerr('你没权限');
}


if($type==1){
	$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$rs[city_id]' AND sortid=-1 AND endtime>'$timestamp'");
	if($ts['NUM']>=$webdb['AdInfoIndexRow']){
		showerr('首页焦点信息没位置了!');
	}
}elseif($type==2){
	$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$rs[city_id]' AND sortid='$fidDB[fup]' AND endtime>'$timestamp'");
	if($ts['NUM']>=$webdb['AdInfoListRow']){
		showerr('大分类焦点信息没位置了!');
	}
}elseif($type==3){
	$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$rs[city_id]' AND sortid='$fid' AND endtime>'$timestamp'");
	if($ts['NUM']>=$webdb['AdInfoListRow']){
		showerr('列表页/内容页焦点信息没位置了!');
	}
}


$lfjdb[money]=intval(get_money($lfjuid));

if($type==1){
	$money=$webdb[AdInfoIndexShow]*$ShowDay;
}elseif($type==2){
	$money=$webdb[AdInfoBigsortShow]*$ShowDay;
}elseif($type==3){
	$money=$webdb[AdInfoSortShow]*$ShowDay;
}else{
	$money=0;
}

if(!$web_admin){
	if($lfjdb[money]<$money){
		showerr("你的{$webdb[MoneyName]}不足:{$money} {$webdb[MoneyDW]},你的{$webdb[MoneyName]}为:$lfjdb[money]{$webdb[MoneyDW]}");
	}
	add_user($lfjuid,-intval($money),'设置焦点信息扣分');
}


$endtime=$timestamp+$ShowDay*24*3600;
if($type==1){
	$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('-1','$rs[city_id]','$id','$rs[mid]','$rs[uid]','$timestamp','$endtime','$money','')");
}elseif($type==2){
	$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$fidDB[fup]','$rs[city_id]','$id','$rs[mid]','$rs[uid]','$timestamp','$endtime','$money','')");
}elseif($type==3){
	$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$rs[fid]','$rs[city_id]','$id','$rs[mid]','$rs[uid]','$timestamp','$endtime','$money','')");
}
refreshto("$FROMURL","焦点显示设置成功",1);
?>