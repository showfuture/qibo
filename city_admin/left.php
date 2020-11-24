<?php
require_once(dirname(__FILE__)."/"."global.php");

if(!$lfjid){
	showerr("ฤใปนรปตวยผ");
}

if($web_admin)
{
	$power=3;
}
elseif( $db->get_one("SELECT * FROM {$pre}sort WHERE BINARY admin LIKE '%,$lfjid,%' LIMIT 1") )
{
	$power=2;
}
else
{
	$power=1;
}


unset($menudb);

if($Smenu){
	$rs = $db->get_one("SELECT * FROM {$pre}module WHERE pre='$Smenu'");
	$rs['dirname'] && @include(ROOT_PATH.$rs['dirname']."/member/menu.php");
	foreach( $menudb AS $key=>$array){
		foreach( $array AS $key2=>$array2){
			!eregi("^http:",$array2['link'])&&$menudb[$key][$key2]['link']="$webdb[www_url]/$rs[dirname]/member/".$array2['link'];
		}
	}
}else{
	require_once(dirname(__FILE__)."/"."menu.php");
	$menudb1=$menudb;
	$query = $db->query("SELECT * FROM {$pre}module ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		unset($menudb);
		$rs['dirname'] && @include(ROOT_PATH.$rs['dirname']."/member/menu.php");
		$menudb2=$menudb;
		foreach( $menudb2 AS $key=>$array){
			foreach( $array AS $key2=>$array2){
				!eregi("^http:",$array2['link'])&&$menudb2[$key][$key2]['link']="$webdb[www_url]/$rs[dirname]/member/".$array2['link'];
			}
		}
		$menudb1=$menudb1+$menudb2;
	}
	$menudb=$menudb1;
}

require_once(dirname(__FILE__)."/"."template/left.htm");

?>