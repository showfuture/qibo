<?php
!function_exists('html') && exit('ERR');

if($job=='listjf'&&$Apower[jfadmin_mod])
{
	$SQL='';
	if($fid){
		$SQL=" AND B.fid='$fid' ";
	}

	$rows=50;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;

	$showpage=getpage("{$pre}jfabout B LEFT JOIN `{$pre}jfsort` S ON B.fid=S.fid","WHERE 1 $SQL","index.php?lfj=jfadmin&job=listjf&","$rows");

	$query = $db->query("SELECT B.*,S.name AS fname FROM {$pre}jfabout B LEFT JOIN `{$pre}jfsort` S ON B.fid=S.fid WHERE 1 $SQL ORDER BY list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$listdb[]=$rs;
	}


	hack_admin_tpl('listjf');
}
elseif($action=="deljf"&&$Apower[jfadmin_mod])
{
	foreach( $idb AS $key=>$value){
		$db->query("DELETE FROM `{$pre}jfabout` WHERE id='$value'");
	}
	jump("删除成功","index.php?lfj=jfadmin&job=listjf",1);
}
elseif($action=="addjf"&&$Apower[jfadmin_mod])
{
	$db->query("INSERT INTO `{$pre}jfabout` ( `fid` , `title` , `content`, `list` ) VALUES ( '$fid', '$title', '$content', '$list' )");
	jump("添加成功","index.php?lfj=jfadmin&job=listjf&fid=$fid",1);
}
elseif($job=="addjf"&&$Apower[jfadmin_mod])
{
	$selectfid="<select name='fid'>";
	$query = $db->query("SELECT * FROM `{$pre}jfsort` ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$selectfid.="<option value='$rs[fid]'>$rs[name]</option>";
	}
	$selectfid.="</select>";


	hack_admin_tpl('addjf');
}
elseif($job=="editjf"&&$Apower[jfadmin_mod])
{
	$rsdb=$db->get_one("SELECT * FROM `{$pre}jfabout` WHERE id='$id'");
	$selectfid="<select name='fid'>";
	$query = $db->query("SELECT * FROM `{$pre}jfsort` ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ck=$rs[fid]==$rsdb[fid]?' selected ':'';
		$selectfid.="<option value='$rs[fid]' $ck>$rs[name]</option>";
	}
	$selectfid.="</select>";


	hack_admin_tpl('addjf');
}
elseif($action=="editjf"&&$Apower[jfadmin_mod])
{
	$db->query("UPDATE `{$pre}jfabout` SET `fid`='$fid',`title`='$title',`content`='$content' WHERE id='$id'");
	jump("添加成功","index.php?lfj=jfadmin&job=listjf&fid=$fid",1);
}
elseif($job=='listsort'&&$Apower[jfadmin_mod])
{
	$query = $db->query("SELECT * FROM `{$pre}jfsort` ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$listdb[]=$rs;
	}

	hack_admin_tpl('listsort');
}
elseif($action=="addsort"&&$Apower[jfadmin_mod])
{
	$name=filtrate($name);
	$db->query("INSERT INTO {$pre}jfsort (name) VALUES ('$name') ");
	jump("创建成功","$FROMURL");
}
elseif($action=="delsort"&&$Apower[jfadmin_mod])
{
	$db->query("DELETE FROM {$pre}jfsort WHERE fid='$fid'");
	jump("删除成功","$FROMURL");
}
elseif($job=="editsort"&&$Apower[jfadmin_mod])
{
	$rsdb=$db->get_one("SELECT * FROM {$pre}jfsort WHERE fid='$fid'");

	hack_admin_tpl('editsort');
}
elseif($action=='editsort'&&$Apower[jfadmin_mod])
{
	$db->query("UPDATE {$pre}jfsort SET name='$postdb[name]' WHERE fid='$fid'");
	jump("修改成功","index.php?lfj=jfadmin&job=listsort",1);
}
elseif($action=='sortorder'&&$Apower[jfadmin_mod])
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$pre}jfsort SET list='$value' WHERE fid='$key'");
	}
	jump("修改成功","index.php?lfj=jfadmin&job=listsort",1);
}