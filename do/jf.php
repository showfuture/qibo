<?php
require(dirname(__FILE__)."/"."global.php");


$lfjdb && $lfjdb[money]=get_money($lfjdb[uid]);

$query = $db->query("SELECT * FROM {$pre}jfsort ORDER BY list");
while($rs = $db->fetch_array($query)){
	$fnameDB[$rs[fid]]=$rs[name];
	$query2 = $db->query("SELECT * FROM {$pre}jfabout WHERE fid='$rs[fid]' ORDER BY list");
	while($rs2 = $db->fetch_array($query2)){
		eval("\$rs2[title]=\"$rs2[title]\";");
		eval("\$rs2[content]=\"$rs2[content]\";");
		$jfDB[$rs[fid]][]=$rs2;
	}
}

require(ROOT_PATH."inc/head.php");
require(html("jf"));
require(ROOT_PATH."inc/foot.php");

?>