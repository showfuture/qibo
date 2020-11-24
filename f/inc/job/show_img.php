<?php
$_erp=$Fid_db[tableid][$fid];
$rsdb=$db->get_one("SELECT A.* FROM `{$_pre}content$_erp` A WHERE A.id='$id'");
if(!$rsdb){
	showerr("资料不存在");
}

$fid=$rsdb[fid];
$mid=$rsdb[mid];

unset($urldb,$titledb);

$query = $db->query("SELECT * FROM {$_pre}pic WHERE id='$id'");
while($rs = $db->fetch_array($query)){
	$urldb[]="'".tempdir($rs[imgurl])."'";
	$titledb[]="'".addslashes($rs[name])."'";
}

if(!$urldb){
	if($rsdb[picurl]){
		header("location:".tempdir($rsdb[picurl]));
		exit;
	}
	echo '<SCRIPT LANGUAGE="JavaScript">
	<!--
		alert("NO IMG");
	self.close();
	//-->
	</SCRIPT>';
	exit;
}

$urldb=implode(",",$urldb);
$titledb=implode(",",$titledb);

$infourl=get_info_url($id,$rsdb[fid],$rsdb[city_id]);
	
require(Mpath."inc/head.php");
require(html("show_img"));
require(Mpath."inc/foot.php");

?>