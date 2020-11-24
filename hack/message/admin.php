<?php
!function_exists('html') && exit('ERR');

if($job=="send"&&$Apower[message_send])
{
	$group_send=group_box("Group",'');

	hack_admin_tpl('send');
}
elseif($job=="test"&&$Apower[message_send])
{
	hack_admin_tpl('test');
}
elseif($action=="send"&&$Apower[message_send])
{
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
			showmsg("标题不能为空");
		}
		if(!$postdb[content]){
			showmsg("内容不能为空");
		}
		$show="<?php
\$Group='$Group';
\$Num='$Num';
\$Title='$Title';
\$Content='$Content';
		";
		write_file(ROOT_PATH."cache/message_cache.php",$show);
	}
	else
	{
		include_once(ROOT_PATH."cache/message_cache.php");
	}
	$Title=addslashes($Title);
	//$postdb[content]=addslashes($postdb[content]);

	$rows=$Num;
	$min=($page-1)*$rows;
	$query = $db->query("SELECT D.* FROM {$pre}memberdata D WHERE D.groupid IN ($Group) LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$array[touid]=$rs[uid];
		$array[fromuid]=0;
		$array[fromer]="系统消息";
		$array[title]=addslashes($Title);
		//$postdb[content]=addslashes($postdb[content]);
		
		//针对火狐浏览器做的处理
		$postdb[content] = str_replace("=\\\"../$webdb[updir]/","=\\\"$webdb[www_url]/$webdb[updir]/",$postdb[content]);
		$postdb[content]	=	preg_replace('/javascript/i','java script',$postdb[content]);
		$postdb[content]	=	preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$postdb[content]);
		$array[content] = stripslashes($postdb[content]);
		pm_msgbox($array);
		$ck++;
	}
	$page++;
	
	if($ck++)
	{
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&action=$action&page=$page&succeeNUM=$succeeNUM&failNUM=$failNUM'>";
		exit;
	}
	else
	{
		unlink(ROOT_PATH."cache/message_cache.php");
		$succeeNUM=intval($succeeNUM);
		$failNUM=intval($failNUM);
		jump("站内消息发送完毕","index.php?lfj=$lfj&job=send",30);	
	}
}
elseif($action=="test"&&$Apower[message_send])
{
	if($page<1)
	{
		$page=1;
		if(!$Usrdb){
			showmsg("会员帐号不能为空");
		}
		$Group=implode(",",$Group);
		if($Num<1){
			$Num=100;
		}
		if(!$Title){
			showmsg("标题不能为空");
		}
		if(!$Content){
			showmsg("内容不能为空");
		}
		$show="<?php
\$Num='$Num';
\$Usrdb='$Usrdb';
\$Title='$Title';
\$Content='$Content';
		";
		write_file(ROOT_PATH."cache/message_cache.php",$show);
	}
	else
	{
		include_once(ROOT_PATH."cache/message_cache.php");
	}
	$Title=addslashes($Title);
	$Content=addslashes($Content);
	$rows=$Num;
	$min=($page-1)*$rows;
	$detail=explode("\r\n",$Usrdb);
	for($i=$min;$i<($min+$rows);$i++)
	{
		if(!$username=$detail[$i])
		{
			continue;
		}
		$rs = $db->get_one("SELECT D.* FROM {$pre}memberdata D WHERE D.username='$username' LIMIT $min,$rows");
		if(!$rs[uid])
		{
			continue;
		}
		$array[touid]=$rs[uid];
		$array[fromuid]=0;
		$array[fromer]="系统消息";
		$array[title]=addslashes($Title);
		$array[content]=addslashes($Content);
		pm_msgbox($array);
		$ck++;
	}
	$page++;
	
	if($ck++)
	{
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&action=$action&page=$page&succeeNUM=$succeeNUM&failNUM=$failNUM'>";
		exit;
	}
	else
	{
		unlink(ROOT_PATH."cache/message_cache.php");
		$succeeNUM=intval($succeeNUM);
		$failNUM=intval($failNUM);
		jump("站内消息发送完毕","index.php?lfj=$lfj&job=$action",30);	
	}
}
?>