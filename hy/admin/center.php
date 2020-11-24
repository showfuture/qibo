<?php
function_exists('html') OR exit('ERR');

//$linkdb=array("核心设置"=>"center.php?job=config");

if($job)
{
	$query=$db->query("SELECT * FROM {$_pre}config ");
	while( $rs=$db->fetch_array($query) ){
		$webdb[$rs[c_key]]=$rs[c_value];
	}
}
if($job=="label"&&ck_power('center_label')){
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$Murl/index.php?jobs=show'>";
	exit;
}
elseif($job=="config"&&ck_power('center_config'))
{
	$showNoPassComment[intval($webdb[showNoPassComment])]=' checked ';

	$webdb[Info_webOpen]?$Info_webOpen1='checked':$Info_webOpen0='checked';
	$Info_webOpen[intval($webdb[Info_webOpen])]=' checked ';

	$module_close[intval($webdb[module_close])]=" checked ";

	$Info_sys[intval($webdb[Info_sys])]=' checked ';
	
	get_admin_html('config');
}


elseif($action=="config"&&ck_power('center_config'))
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
elseif($action=="settable")
{
	module_write_config_cache($webdbs);
	refreshto($FROMURL,"设置成功");
}
elseif($job=="settable")
{
	
	$layout=array();
	$detail=explode("#",$webdb[sort_layout]);
	foreach($detail AS $key=>$value){
		$detail2=explode(",",$value);
		foreach($detail2 AS $fup){
			if(!$Fid_db['0'][$fup]){
				continue;
			}
			$layout[$key][$fup]['name']=$Fid_db['name'][$fup];
			$layout[$key][$fup]['son']=$Fid_db[$fup];
			$ckfup[$fup]=1;
		}
	}
	foreach($Fid_db[0] AS $fup=>$name){
		if(!$ckfup[$fup]){
			$layout[0][$fup]['name']=$Fid_db['name'][$fup];
			$layout[0][$fup]['son']=$Fid_db[$fup];
		}
	}

	get_admin_html('settable');
}

?>