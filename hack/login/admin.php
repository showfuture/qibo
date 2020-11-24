<?php
!function_exists('html') && exit('ERR');
if($job=='list'&&$Apower[hack_list])
{
	$rsdb=$db->get_one("SELECT * FROM {$pre}hack WHERE keywords='$hack' ");
	@extract(unserialize($rsdb[config]));
	$guestcode=stripslashes($guestcode);
	$membercode=stripslashes($membercode);
	if($webdb[passport_type])
	{
		$systemType='php168';
	}
	if($webdb[passport_type]&&$webdb[passport_TogetherLogin]==2&&$systemType=='php168')
	{
		$systemType='';
	}
	$systemTypeDB[$systemType]=' checked ';

	hack_admin_tpl('list');
}
elseif($job=='show'&&$Apower[hack_list])
{
	hack_admin_tpl('getcode');
}
?>