<?php
require_once(dirname(__FILE__)."/"."global.php");
if(!$lfjid){
	showerr("ฤใปนรปตวยผ");
}

@include(ROOT_PATH."data/all_fid.php");
$myarticleDB = '';
$query = $db->query("SELECT * FROM {$pre}fenlei_db WHERE uid='$uid' ORDER BY id DESC LIMIT 30");
while($rs = $db->fetch_array($query)){
	$_erp=$Fid_db[tableid][$rs[fid]];
	$rs=$db->get_one("SELECT * FROM {$pre}fenlei_content$_erp WHERE id='$rs[id]'");
	$rs[posttime]=date("y-m-d H:i:s",$rs[posttime]);
	$myarticleDB[]=$rs;
}

require(dirname(__FILE__)."/"."head.php");
require(get_member_tpl('map'));
require(dirname(__FILE__)."/"."foot.php");

?>