<?php
if(!function_exists('html')){
die('F');
}

$Cache_FileName=ROOT_PATH."cache/index/$city_id/allnewinfo.php";
if($webdb[Info_index_cache]&&(time()-filemtime($Cache_FileName))<($webdb[Info_index_cache]*60)){
	echo read_file($Cache_FileName);
	exit;
}

$show=$SQL='';
$rows>50 && $rows=50;
$rows<1 && $rows=10;
$leng<1 && $leng=30;
if(!$webdb[Info_ShowNoYz]){
	$SQL =" AND yz='1' ";
}
$query = $db->query("SELECT * FROM {$_pre}db WHERE city_id='$city_id' ORDER BY id DESC LIMIT $rows");
while($rs = $db->fetch_array($query)){
	$_erp=$Fid_db[tableid][$rs[fid]];
	$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id=$rs[id] $SQL");
	if(!$rs[title]){
		continue;
	}
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
	$rs[title]=get_word($rs[title],$leng);
	$show.="<div>¡¤<a href='$rs[url]' target='_blank'>$rs[title]</a></div>";
}


if($webdb[RewriteUrl]==1){	//È«Õ¾Î±¾²Ì¬
	rewrite_url($show);
}


$show=str_replace(array("\n","\r","'"),array("","","\'"),$show);
if($webdb[cookieDomain]){
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.domain = \"$webdb[cookieDomain]\";</SCRIPT>";
}
echo "<SCRIPT LANGUAGE=\"JavaScript\">
parent.document.getElementById('$iframeID').innerHTML='$show';
</SCRIPT>";

if( $webdb[Info_index_cache]&&(time()-filemtime($Cache_FileName))>($webdb[Info_index_cache]*60)){
	if(!is_dir(dirname($Cache_FileName))){
		makepath(dirname($Cache_FileName));
	}
	write_file($Cache_FileName,ob_get_contents());
}

?>