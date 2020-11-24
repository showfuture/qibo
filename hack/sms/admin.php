<?php
!function_exists('html') && exit('ERR');

if($job=="send"&&$Apower[mail_send])
{
	$group_send=group_box("Group",'');

	hack_admin_tpl('send');
}
elseif($job=="set"&&$Apower[mail_send])
{
	$sms_type[$webdb[sms_type]]=' checked ';


	hack_admin_tpl('set');
}
elseif($job=="test"&&$Apower[mail_send])
{

	hack_admin_tpl('test');
}
elseif($action=="set"&&$Apower[mail_send])
{
	write_config_cache($webdbs);
	jump("设置成功",$FROMURL);
}
elseif($action=="send"&&$Apower[mail_send])
{

	if(!$IS_BIZPhp168){
		showerr("免费版无此功能");
	}
	if(!$Group){
		showerr("请选择一个用户组");
	}
	if($page<1)
	{
		$page=1;
		if(!$Group){
			showmsg("你必须选择一个用户组");
		}
		$Group=implode(",",$Group);
		if($Num<1){
			$Num=1;
		}
		if(!$Title){
			showmsg("短信内容不能为空");
		}
	}
	$Title=urlencode($Title);
	$rows=$Num;
	$min=($page-1)*$rows;
	$query = $db->query("SELECT mobphone FROM {$pre}memberdata WHERE groupid IN ($Group) LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		if( sms_send($rs[mobphone], $Title )===1 ){
			$succeeNUM++;
		}else{
			$failNUM++;
		}
		$ck++;
	}
	$page++;
	
	if($ck++)
	{
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&action=$action&page=$page&succeeNUM=$succeeNUM&failNUM=$failNUM&Group=$Group&Title=$Title&Num=$Num'>";
		exit;
	}
	else
	{
		$succeeNUM=intval($succeeNUM);
		$failNUM=intval($failNUM);
		jump("手机短信发送完毕,发送成功的短信有 <font color=red>{$succeeNUM}</font> 条,发送失败的短信有 <font color=red>{$failNUM}</font> 条","index.php?lfj=$lfj&job=send",30);	
	}
}
elseif($action=="test"&&$Apower[mail_send])
{
	if($page<1)
	{
		$page=1;
		if(!$mobDB){
			showmsg("手机号码不能为空");
		}
		if(!$Title){
			showmsg("短信内容不能为空");
		}
		$Num=1;
		$detail=explode("\r\n",$mobDB);
	}
	else
	{
		$detail=explode(",",$mobDB);
	}
	//$Title=urlencode($Title);
	$rows=$Num;
	$min=($page-1)*$rows;	
	for($i=$min;$i<($min+$rows);$i++)
	{
		if(!$detail[$i]){
			continue;
		}
		if( sms_send($detail[$i], $Title)===1 ){
			$succeeNUM++;
		}else{
			$failNUM++;
		}
		$ck++;
	}
	$page++;
	
	if($ck++)
	{
		$mobstr=implode(",",$detail);
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&action=$action&page=$page&succeeNUM=$succeeNUM&failNUM=$failNUM&mobDB=$mobstr&Title=$Title'>";
		exit;
	}
	else
	{
		$succeeNUM=intval($succeeNUM);
		$failNUM=intval($failNUM);
		jump("短信发送完毕,发送成功的短信有 <font color=red>{$succeeNUM}</font> 条,发送失败的短信有 <font color=red>{$failNUM}</font> 条","index.php?lfj=$lfj&job=$action",30);	
	}
}
?>