<?php
if(!function_exists('html')){
die('F');
}
$show='';
$rows>50 && $rows=50;
$rows<1 && $rows=10;
$leng<1 && $leng=30;
$listdb=Get_AdInfo($fid,$rows?$rows:10,$leng?$leng:30);

//为方便页面布局
if($fid==-1&&count($listdb)==0){
	$listdb=Get_Info('hot',$rows,$leng);
}


foreach($listdb AS $rs){
	$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
	$rs[title]=get_word($rs[title],$leng);
	$show.="<div>·<a href='$rs[url]' target='_blank'>$rs[title]</a></div>";
}

if($webdb[RewriteUrl]==1){	//全站伪静态
	rewrite_url($show);
}

$show=str_replace(array("\n","\r","'"),array("","","\'"),$show);
if($webdb[cookieDomain]){
	echo "<SCRIPT LANGUAGE=\"JavaScript\">document.domain = \"$webdb[cookieDomain]\";</SCRIPT>";
}
echo "<SCRIPT LANGUAGE=\"JavaScript\">
parent.document.getElementById('$iframeID').innerHTML='$show';
</SCRIPT>";


?>