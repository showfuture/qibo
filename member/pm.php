<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjid){
	showerr("你还没登录");
}

$linkdb=array(
			"收件箱"=>"?job=list",
			"写新消息"=>"?job=send",
			"清空收件箱"=>"?job=clean"
			);
if($job=='list')
{	
	if(!$page){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;

	$SQL="SELECT * FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' ORDER BY mid DESC LIMIT $min,$rows";
	$showpage=getpage("`{$pre}pm`","WHERE `touid`='$lfjuid' AND type='rebox'","?job=$job",$rows);
	
	$query = $db->query($SQL);
	while($rs = $db->fetch_array($query))
	{
		if($rs[ifnew]){
			$rs[state]="<A style='color:red;'>未读</A>";
		}else{
			$rs[state]="已读";
		}
		$rs[mdate]=date("Y-m-d H:i",$rs[mdate]);
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/pm/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='read')
{

	$SQL="SELECT * FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' AND mid='$mid'";
	$db->query("UPDATE `{$pre}pm` SET `ifnew`=0 WHERE `touid`='$lfjuid' AND type='rebox' AND mid='$mid'");

	$rsdb=$db->get_one($SQL);
	$rsdb[mdate]=date("Y-m-d H:i",$rsdb[mdate]);

	//require_once(ROOT_PATH."inc/encode.php");
	//$rsdb[content]=format_text($rsdb[content]);

	$rsdb[content]=En_TruePath($rsdb[content],0);

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/pm/read.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='del')
{

	$SQL="DELETE FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' AND mid='$mid'";
	$db->query($SQL);
	refreshto("pm.php?job=list","删除成功",1);
}
elseif($job=='clean')
{

	$SQL="DELETE FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' ";
	if(!$step){
		require("head.php");
		echo "<CENTER><br> <br><b><font color=red>你确实要清空收件箱吗？不可恢复！</font><br> <br><A HREF='?job=$job&step=2'>[是]</A>　　　　　<A HREF='?job=list'>[否]</A></b></CENTER>";
		exit;
	}
	$db->query($SQL);
	refreshto("pm.php?job=list","收件箱已清空",1);
}
elseif($job=='send')
{
	if($step==2)
	{
		$rsdb=$userDB->get_passport($touser,'name');
		if(!$rsdb)
		{
			showerr("当前用户不存在");
		}
		if(!$title){
			showerr("标题不能为空");
		}
		if(strlen($array[title])>100){
			showerr("标题太长了!");
		}
		$array[touid]=$rsdb[uid];
		$array[fromuid]=$lfjuid;
		$array[fromer]=$lfjid;
		$array[title]=filtrate($title);
		
		//针对火狐浏览器做的处理
		$postdb[content] = str_replace("=\\\"../$webdb[updir]/","=\\\"$webdb[www_url]/$webdb[updir]/",$postdb[content]);
		$postdb[content]	=	preg_replace('/javascript/i','java script',$postdb[content]);
		$postdb[content]	=	preg_replace('/<(script)([^<>]*)>/i','&lt;\\1\\2>',$postdb[content]);
		$postdb[content]	=	preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$postdb[content]);
		$array[content] = stripslashes($postdb[content]);

		$array[content] = En_TruePath($array[content],1);

		pm_msgbox($array);
		refreshto("?job=list","发送成功",1);
	}
	if($uid){
		$rsdb = $userDB->get_passport($uid);
		$username = $rsdb[username];
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/pm/send.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

?>