<?php
function_exists('html') OR exit('ERR');

ck_power('center');

//$linkdb=array("核心设置"=>"center.php?job=config");

if($job=="config")
{
	$showNoPassComment[intval($webdb[showNoPassComment])]=' checked ';

	$webdb[Info_webOpen]?$Info_webOpen1='checked':$Info_webOpen0='checked';
	$Info_webOpen[intval($webdb[Info_webOpen])]=' checked ';

	$Info_delpaper[intval($webdb[Info_delpaper])]=' checked ';

	$module_close[intval($webdb[module_close])]=" checked ";
	
	get_admin_html('config');
}


elseif($action=="config")
{
	if( isset($webdbs[Info_webadmin]) ){
		$webdbs[Info_webadmin]=filtrate($webdbs[Info_webadmin]);
		$db->query("UPDATE {$pre}module SET adminmember='$webdbs[Info_webadmin]' WHERE id='$webdb[module_id]'");
	}
	if( isset($webdbs[Info_weburl]) ){
		$webdbs[Info_weburl]=filtrate($webdbs[Info_weburl]);
		$db->query("UPDATE {$pre}module SET domain='$webdbs[Info_weburl]' WHERE id='$webdb[module_id]'");
	}

	module_write_config_cache($webdbs);
	refreshto($FROMURL,"修改成功");
}

?>