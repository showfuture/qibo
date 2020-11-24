<?php

header('Content-type: text/html; charset='.WEB_LANG);

if($action=='getfidsonslist'){
	
	if(!$Fid_db[$fup]) echo "&nbsp;";
	
	foreach($Fid_db[$fup] AS $k=>$v){
		$next='true';
		if(!$Fid_db[$k] || $class >= 4) $next = 'false';
		$str.= "<div><a href=\"javascript:;\" onclick=\"changeClassName($class,this,{$k},$next,$ctype ,\'$Murl\')\">{$v}</a></div>"; 
	}
	
	$str=$str?$str:"&nbsp;";
	echo '<script >parent.inputcontent(\''.$str.'\','.$class.');</script>';
	exit;
}
?>