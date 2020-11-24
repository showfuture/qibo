<?php
function_exists('html') OR exit('ERR');

ck_power('autopass');

if($job=="set"){
	$Info_postCkIp[intval($webdb[Info_postCkIp])]=' checked ';
	$Info_postCkMob[intval($webdb[Info_postCkMob])]=' checked ';
	$Info_YzKeyword_DO[intval($webdb[Info_YzKeyword_DO])]=' checked ';

	$showNoPassComment[intval($webdb[showNoPassComment])]=' checked ';

	$CommentPass_group=group_box("webdbs[CommentPass_group]",explode(",",$webdb[CommentPass_group]));

	get_admin_html('set');

}
elseif($action=='set'){

	write_config_cache($webdbs);
	refreshto($FROMURL,"�޸ĳɹ�");

}
?>