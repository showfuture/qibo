<?php
if($webdb['run_time']==1){
	$speed_endtime=explode(' ',microtime());
	$speed_totaltime.="TIME ".number_format((($speed_endtime[0]+$speed_endtime[1]-$speed_headtime)/1),6)." second(s)";
}
if($webdb[AvoidGather]){
	echo "<SCRIPT LANGUAGE='JavaScript'>avoidgather('$webdb[AvoidGatherPre]');</SCRIPT>";
}
require(html("foot",$foot_tpl));

$content=ob_get_contents();
$content=str_replace("<!---->","",$content);
$content=preg_replace("/<!--include(.*?)include-->/is","\\1",$content);
ob_end_clean();
ob_start(); /*方便后面再次调用*/
$content=kill_badword($content);
if($webdb[cookieDomain] && strstr($content,'ewebeditor/ewebeditor.php?')){
	$content=preg_replace("/document.domain([^<]+)/is","",$content);
}
if($webdb[www_url]=='/.'){
	$content=str_replace('/./','/',$content);
}

if($webdb[RewriteUrl]==1){	//全站伪静态
	rewrite_url($content);
}

echo $content;

?>