<?php
!function_exists('html') && exit('ERR');
//当前文件是注册时通过手机或邮箱获取注册码的功能
if(!is_table("{$pre}regnum")){
	$db->query("CREATE TABLE `{$pre}regnum` (
	`sid` varchar( 8 ) NOT NULL default '',
	`num` varchar( 6 ) NOT NULL default '',
	`posttime` int( 10 ) NOT NULL default '0',
	UNIQUE KEY `sid` ( `sid` ) ,
	KEY `posttime` ( `num` , `posttime` ) 
	) ENGINE = HEAP");
}
if(!$webdb[yzNumReg]){
	showerr('系统没开放这个功能！');
}
$time=$timestamp-60;
if($db->get_one("SELECT * FROM {$pre}regnum WHERE sid='$usr_sid' AND posttime>$time")){
	showerr("如果你的注册码还没有收到的话？请一分钟后再重发！");
}
$randNum = rands(2).substr(mymd5($num),0,2);
$content = $webdb['webname']."提供给您的注册码是:(".$randNum.")这四位数";
if($webdb['yzNumReg']==2){
	if(!ereg("^1([0-9]{10})$",$num)){
		showerr('手机号码有误！'.$num);
	}
	if(sms_send($num,$randNum)){
		$db->query("REPLACE INTO `{$pre}regnum` ( `sid` , `num` , `posttime` ) VALUES ('$usr_sid', '$randNum', '$timestamp')");
		showerr("信息已经成功发送到您指定的手机号码中,请注意查收，有可能会延迟几分钟，请耐心等待！",1);
	}else{
		showerr("信息发送失败，可能是手机短信接口有问题！");
	}
}elseif($webdb['yzNumReg']==1){
	$email=$num;
	$title = $webdb['webname']."提供给你的注册码信息";
	if(send_mail($email,$title,$content,$ifcheck=1)){
		$db->query("REPLACE INTO `{$pre}regnum` ( `sid` , `num` , `posttime` ) VALUES ('$usr_sid', '$randNum', '$timestamp')");
		showerr("注册码信息已经成功发送到您的邮箱中,请注意查收",1);
	}else{
		showerr("信息发送失败，可能是邮件发送功能配置有误！");
	}
}
?>