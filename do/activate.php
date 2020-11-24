<?php
require_once("global.php");

if($action=='send')
{
	$rs=$userDB->get_allInfo($atc_username,'name');
	if(!$rs){
		showerr("帐号不存在");
	}elseif($rs[yz]){
		showerr("当前帐号已经激活了,你不能重复激活!");
	}elseif(!$atc_email){
		showerr("请输入邮箱!");
	}
	if (!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$atc_email)) {
		showerr("邮箱不符合规则"); 
	}
	if(!$webdb[mymd5])
	{
		$webdb[mymd5]=rands(10);
		$db->query("REPLACE INTO {$pre}config (`c_key`,`c_value`) VALUES ('mymd5','$webdb[mymd5]')");
		write_file(ROOT_PATH."data/config.php","\$webdb['mymd5']='$webdb[mymd5]';",'a');
	}
	$md5_id=str_replace('+','%2B',mymd5("{$rs[username]}\t{$rs[password]}"));
	$Title="来自“{$webdb[webname]}”的邮件,请激活帐号!!";
	$Content="你在“{$webdb[webname]}”的帐号是“{$rs[$TB[username]]}”还没激活,请点击此以下网址,激活你的帐号。<br><br><A HREF='$webdb[www_url]/do/activate.php?job=activate&md5_id=$md5_id' target='_blank'>$webdb[www_url]/do/activate.php?job=activate&md5_id=$md5_id</A>";

	if($webdb[MailType]=='smtp')
	{
		if(!$webdb[MailServer]||!$webdb[MailPort]||!$webdb[MailId]||!$webdb[MailPw])
		{
			showmsg("请管理员先设置邮件服务器");
		}
		require_once(ROOT_PATH."inc/class.mail.php");
		$smtp = new smtp($webdb[MailServer],$webdb[MailPort],true,$webdb[MailId],$webdb[MailPw]);
		$smtp->debug = false;

		if($smtp->sendmail($atc_email,$webdb[MailId], $Title, $Content, "HTML"))
		{
			$succeeNUM++;
		}
	}
	else
	{
		if(mail($atc_email, $Title, $Content))
		{
			$succeeNUM++;
		}
	}
	if($succeeNUM)
	{
		refreshto("./","系统已经成功发送邮件到你的邮箱:“{$atc_email}”，请注意查收!",5);
	}
	else
	{
		showerr("邮件发送失败，可能你的邮箱有误,或者是服务器发送邮件功能有问题！！");
	}
}
elseif($job=='activate')
{
	list($username,$password)=explode("\t",mymd5($md5_id,'DE'));

	$rs=$userDB->get_allInfo($username,'name');

	if($rs&&$rs[password]==$password)
	{
		$db->query("UPDATE {$pre}memberdata SET `yz`='1' WHERE uid='$rs[uid]'");
		refreshto("login.php","恭喜你，你的帐号“{$username}”激活成功，请立即登录，体验会员特有的功能!",10);
	}
	else
	{
		showerr("帐号激活失败!");
	}
}

if($username){
	$rs=$userDB->get_allInfo($username,'name');
	$email=$rs[email];
}
require(ROOT_PATH."inc/head.php");
require(html("activate"));
require(ROOT_PATH."inc/foot.php");
?>