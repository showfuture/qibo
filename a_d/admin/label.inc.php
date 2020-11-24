<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){
	
	$code="<SCRIPT LANGUAGE=\'JavaScript\' src=\'http://www_qibosoft_com/a_d/a_d_s.php?job=js&ad_id=$adid\'></SCRIPT>";
	$div_db[adid]=$adid;

	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=0;

	//插入或更新标签库
	do_post();
}


$rsdb=get_label();
$rsdb[hide]?$hide_1='checked':$hide_0='checked';
if($rsdb[js_time]){
	$js_time='checked';
}
@extract(unserialize($rsdb[divcode]));
$div_width && $div_w=$div_width;
$div_height && $div_h=$div_height;
$query = $db->query("SELECT * FROM `{$_pre}norm_place` ORDER BY id DESC");
while($rs = $db->fetch_array($query)){
	if(!$adid){
		$adid=$rs[keywords];
	}
	$rs[ckcid]=$adid==$rs[keywords]?" checked ":"";
	$listdb[]=$rs;
}
require("head.php");
require(dirname(__FILE__)."/template/label/hack_ad.htm");
require("foot.php");
?>