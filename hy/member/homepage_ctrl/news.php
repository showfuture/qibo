<?php
//新闻列表

$rows=10;
if($page<1){
	$page=1;
}
	
$min=($page-1)*$rows;
$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid' LIMIT 1");
if(!$rsdb) showerr("商家信息未登记");
$where=" WHERE uid='$rsdb[uid]' ";
	
$query=$db->query("SELECT * FROM {$_pre}news $where ORDER BY posttime DESC LIMIT $min,$rows");
	
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[yz]=!$rs[yz]?"<font color=red>审核中</font>":"已通过";
	$listdb[]=$rs;
}	
	
$showpage=getpage("{$_pre}news",$where,"?uid=$uid&atn=$atn",$rows);

?>