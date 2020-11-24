<?php
//修改图片

if(count($pids)<1) showerr("至少选择一项");

$pids=implode(",",$pids);
$query=$db->query("SELECT * FROM {$_pre}pic WHERE pid IN($pids) ORDER BY orderlist DESC");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
	//$rs[url]=$webdb[www_url]."/".$user_picdir.$rs[url];
	$rs[url]=tempdir($rs[url]);
	$listdb[]=$rs;
}

?>