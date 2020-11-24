<?php
if(!function_exists('html')){
die('F');
}

$Cache_FileName=ROOT_PATH."cache/list/$city_id-$fid/bigsortshownewinfo.php";
if($webdb[Info_list_cache]&&(time()-filemtime($Cache_FileName))<($webdb[Info_list_cache]*60)){
	echo read_file($Cache_FileName);
	exit;
}


$rows=10;
$_erp=$Fid_db[tableid][$fid];
$show='';
$query = $db->query("SELECT * FROM `{$_pre}content$_erp` WHERE fid='$fid' AND city_id='$city_id' ORDER BY list DESC LIMIT $rows");
while($rs = $db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
	$rs[Lurl]=get_info_url('',$rs[fid],$rs[city_id]);
	$show.="<div style='clear:both;margin-top:4px;'><span style='float:left;'>[<A HREF='$rs[Lurl]' target='_blank'>$rs[fname]</A>]<A HREF='$rs[url]' target='_blank'>$rs[title]</A></span><span style='float:right;padding-right:10px;'>$rs[posttime]</span></div>";
}


if($webdb[RewriteUrl]==1){	//ȫվα��̬
	rewrite_url($show);
}


$show=str_replace(array("\n","\r","'"),array("","","\'"),$show);
if($webdb[cookieDomain]){
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.domain = \"$webdb[cookieDomain]\";</SCRIPT>";
}
echo "<SCRIPT LANGUAGE=\"JavaScript\">
parent.document.getElementById('$iframeID').innerHTML='$show';
</SCRIPT>";


if( $webdb[Info_list_cache]&&(time()-filemtime($Cache_FileName))>($webdb[Info_list_cache]*60)){
	if(!is_dir(dirname($Cache_FileName))){
		makepath(dirname($Cache_FileName));
	}
	write_file($Cache_FileName,ob_get_contents());
}


?>