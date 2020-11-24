<?php 
require(dirname(__FILE__)."/global.php");

$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");
if(!$fidDB){
	ShowErrs("<span style=\"font-size:16px;color:red;\">À¸Ä¿²»´æÔÚ</span>");
}
$guides=get_guides($fid);
$thisfup=$fidDB[type]==1?$fid:$fidDB[fup];

$page=$page?$page:1;
$rows=20;
$min=($page-1)*$rows;
$query = $db->query("SELECT * FROM {$_pre}content WHERE yz=1 AND fid=$fid AND city_id='$city_id' ORDER BY id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$listdb[]=$rs;
}
$showpage=getpage("{$_pre}content","WHERE yz=1 AND fid=$fid AND city_id='$city_id'","?fid=$fid",$rows);
$showpage=$showpage?"<div class=\"showpage\">$showpage</div>":"";

$WebTitle=$fidDB[name]."-".$webdb['webname'];
require(Mpath."template/head.htm");
require(Mpath."template/list.htm");
require(Mpath."template/foot.htm");
?>