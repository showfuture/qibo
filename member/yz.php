<?php
require(dirname(__FILE__)."/"."global.php");

$linkdb=array("邮箱验证"=>"?job=email","身份验证"=>"?job=idcard","手机验证"=>"?job=mob");

if(!$lfjid){
	showerr("你还没登录");
}

if($action=='email')
{
	if (!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$email)) {
		showerr("邮箱不符合规则"); 
	}
	$Title="来自<$webdb[webname]>的邮箱验证信息!";
	$eid=str_replace('+','%2B',mymd5("$lfjid\t$lfjuid\t$email"));
	$Content="请点击以下网址,以完成邮箱的验证:<br><A HREF='$webdb[www_url]/do/job.php?job=yzemail&eid=$eid'>$webdb[www_url]/do/job.php?job=yzemail&eid=$eid</A>";
	if($webdb[MailType]=='smtp')
	{
		if(!$webdb[MailServer]||!$webdb[MailPort]||!$webdb[MailId]||!$webdb[MailPw])
		{
			showmsg("请管理员设置邮件服务器");
		}
		require_once(ROOT_PATH."inc/class.mail.php");
		$smtp = new smtp($webdb[MailServer],$webdb[MailPort],true,$webdb[MailId],$webdb[MailPw]);
		$smtp->debug = false;
		if($smtp->sendmail($email,$webdb[MailId], $Title, $Content, "HTML")){
			$succeed=1;
		}
	}
	elseif(mail($email, $Title, $Content))
	{
		$succeed=1;
	}

	if($succeed){
		refreshto("$FROMURL","系统刚刚发了一封验证信息到你邮箱,请尽快查收,以完成邮件验证",10);
	}else{
		showerr("邮件发送失败.请管理员检查邮箱服务器设置");
	}

}
elseif($action=='idcard')
{
	if(!$truename){
		showerr("真实姓名不能为空!");
	}
	if(!$idcard){
		showerr("身份证号码不能为空!");
	}
	if(!ereg("^[0-9]{15}",$idcard)){
		showerr("身份证号码有误!");
	}
	if($idcardpic){
		if(!is_file(ROOT_PATH."$webdb[updir]/$idcardpic")){
			showerr("请上传身份证复印件,不能引用其它网址!");
		}
		if(!eregi("^{$lfjuid}_",basename($idcardpic))&&$idcardpic!="idcard/$lfjuid.jpg"){
			showerr("请上传身份证复印件,不能引用其它图片!");
		}
		if($idcardpic!="idcard/$lfjuid.jpg"){
			unlink(ROOT_PATH."$webdb[updir]/idcard/$lfjuid.jpg");
			rename(ROOT_PATH."$webdb[updir]/$idcardpic",ROOT_PATH."$webdb[updir]/idcard/$lfjuid.jpg");
		}		
	}
	$db->query("UPDATE {$pre}memberdata SET idcard='$idcard',truename='$truename',idcard_yz='-1' WHERE uid='$lfjuid'");
	refreshto("$FROMURL","请等待管理员审核",10);
}
elseif($action=='mobphone')
{
	$code=rand(1000,9999);
	if( !eregi("^1(3|5|8)([0-9]{9})$",$mobphone) ){
		showerr("手机号码有误!");
	}
	$msg=sms_send($mobphone,"你的验证码是:$code");

	if($msg!==1){
		showerr("系统发送短信失败,有可能是你的手机号码有误,也有可能是系统的短信接口平台出现故障,请联系管理员在后台检查短信平台接口!");
	}
	$md5code=str_replace('+','%2B',mymd5("$code\t$mobphone\t$lfjuid","EN"));
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/yz.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=='mobphone2')
{
	if($lfjdb[mob_yz]){
		showerr("请不要重复验证手机号码!");
	}
	if(!$yznum){
		showerr("请输入验证码");
	}elseif(!$md5code){
		showerr("资料有误");
	}else{
		unset($code,$mobphone,$uid);
		list($code,$mobphone,$uid)=explode("\t",mymd5($md5code,"DE") );
		if($code!=$yznum||$uid!=$lfjuid){
			showerr("验证码不对");
		}
	}
	add_user($lfjuid,$webdb[YZ_MobMoney],'手机号码审核奖分');
	$db->query("UPDATE {$pre}memberdata SET mobphone='$mobphone',mob_yz='1' WHERE uid='$lfjuid'");
	refreshto("yz.php?job=mob","恭喜你,你的手机号码成功通过审核,你同时得到 {$webdb[YZ_MobMoney]} 个积分奖励!",10);
}
else
{	
	unset($idcardpic);
	if($job=='idcard'){
		if(is_file(ROOT_PATH."$webdb[updir]/idcard/$lfjuid.jpg")){
			$idcardpic="idcard/$lfjuid.jpg";
		}
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/yz.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
?>