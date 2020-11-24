<?php

if(!function_exists('get_info_url')){
	define('NO_IN_FL',true);
	$this_module_ArrayFid = $Fid_db;
	$this_module_fid = $fid;
	unset($Fid_db,$fid);
	$Fid_db = @include(ROOT_PATH."/data/all_fid.php");
	require_once(ROOT_PATH."inc/fenlei.inc.php");
}

require(html("head",$head_tpl));

if(NO_IN_FL===true){
	unset($Fid_db);
	$Fid_db =& $this_module_ArrayFid;
	$fid =& $this_module_fid;
}

?>