<?php
//¹«Ë¾Í¼¿â

if($edit_psid){
	$rsdb=$db->get_one("SELECT * FROM {$_pre}picsort WHERE uid='$uid' AND psid='$edit_psid' LIMIT 1");
}
$webdb[company_picsort_Max]=$webdb[company_picsort_Max]?$webdb[company_picsort_Max]:10;
$query=$db->query("SELECT * FROM {$_pre}picsort WHERE uid='$uid' ORDER BY orderlist DESC LIMIT 0,$webdb[company_picsort_Max];");
while($rs=$db->fetch_array($query)){
	$rs[faceurl]=tempdir($rs[faceurl]);
	$listdb[]=$rs;
}

?>