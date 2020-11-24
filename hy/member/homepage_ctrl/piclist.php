<?php
//图片列表

if(!$psid) showerr("操作失败");

$rsdb=$db->get_one("SELECT * FROM {$_pre}picsort WHERE psid='$psid' LIMIT 1");

if(!$rsdb) showerr("系统错误");

$rsdb[faceurl]=tempdir($rsdb[faceurl]);
$rows=14;

if($page<1){
	$page=1;
}

$min=($page-1)*$rows;
$query=$db->query("SELECT * FROM {$_pre}pic WHERE uid='$uid' AND psid='$psid' ORDER BY orderlist DESC LIMIT $min,$rows;");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
	$rs[url]=tempdir($rs[url]);
	$listdb[]=$rs;
}
$showpage=getpage("{$_pre}pic"," WHERE uid='$uid' AND psid='$psid'","?atn=$atn&uid=$uid&psid=$psid",$rows);


?>