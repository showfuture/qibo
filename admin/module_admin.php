<?php
!function_exists('html') && exit('ERR');
$admin_path="index.php?lfj=$lfj&dirname=$dirname&file=$file";

require_once(ROOT_PATH."$dirname/admin/global.php");
require_once(ROOT_PATH."$dirname/admin/{$file}.php");


function get_admin_html($html_file_type,$getmenu=false){
	extract($GLOBALS);
	require(dirname(__FILE__)."/head.php");
	$getmenu && @include(ROOT_PATH."$dirname/admin/template/$file/menu.htm");
	require(ROOT_PATH."$dirname/admin/template/$file/{$html_file_type}.htm");
	require(dirname(__FILE__)."/foot.php");
}

//是否有后台权限!!
function ck_power($v){
	global $Apower,$webdb;
	if(!$Apower["Module_$webdb[module_pre]$v"]){
		showmsg('你无权限!');
	}
	return true;
}

?>