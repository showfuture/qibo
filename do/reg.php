<?php
require(dirname(__FILE__)."/"."global.php");
require(ROOT_PATH."data/level.php");

$_GET['_fromurl'] && $_fromurl=$_GET['_fromurl'];
if($lfjid){
	showerr("你已经注册了,请不要重复注册,要注册,请先退出");
}
if($webdb[forbidReg]){
	showerr("很抱歉,网站关闭了注册");
}


if($step==2){
	//阅读并同意注册协议
	if($agree!=1){
		//showerr("你并未同意注册协议，无法进行注册");
	}
	//用户自定义字段
	require_once(ROOT_PATH."/do/regfield.php");
	ck_regpost($postdb);

	if($webdb[forbidRegHour]){
		$webdb[forbidRegHour] = str_replace(array('24','　'),array('0',' '),$webdb[forbidRegHour]);
		$detail=explode(" ",$webdb[forbidRegHour]);
		if(in_array(ceil(date('H',$timestamp)),$detail)){
			showerr("系统设置当前时间段不允许注册");
		}
	}

	if($webdb[forbidRegIp]){
		$detail=explode("\r\n",$webdb[forbidRegIp]);
		foreach( $detail AS $key=>$value){
			//if(strstr($onlineip,$value)&&ereg("^$value",$onlineip)){
			if(strstr($onlineip,$value)){
				showerr("你所在IP禁止注册");
			}
		}
	}
	if($webdb[limitRegTime]&&get_cookie("limitRegTime")){
		showerr("{$webdb[limitRegTime]} 分钟内,请不要重复注册");
	}
	if( $webdb[yzImgReg] ){
		if(!check_imgnum($yzimg)){
			showerr("验证码不符合");
		}
	}

	//注册码核对
	if($webdb[yzNumReg]){
		$time=$timestamp-3600;	//1小时前的注册码失效.
		if($db->get_one("SELECT * FROM {$pre}regnum WHERE num='$yznum' AND sid='$usr_sid'")){
			if($webdb['yzNumReg']==1){
				if(substr(mymd5($email),0,2)!=substr($yznum,2,2)){
					showerr("请不要改换获取注册码的邮箱帐号!");
				}
			}elseif($webdb['yzNumReg']==2){
				if(substr(mymd5($mobphone),0,2)!=substr($yznum,2,2)){
					showerr("请不要改换或删除获取注册码的手机号码!");
				}
			}
			$db->query("DELETE FROM {$pre}regnum WHERE (num='$yznum' AND sid='$usr_sid') OR posttime<$time");
		}else{
			showerr("注册码不对!");
		}
	}

	if($mobphone && !ereg("^1([0-9]{10})$",$mobphone)){
		showerr('手机号码有误！');
	}

	if($password!=$password2){
		showerr("两次输入密码不一样");
	}elseif ($msn&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$msn)) {
		showerr("MSN不符合规则"); 
	}
	if($webdb[forbidRegName]){
		$detail=explode("\r\n",$webdb[forbidRegName]);
		if(in_array($username,$detail)){
			showerr("受保护的帐号,不允许使用,请更换一个吧");
		}
	}
	$msn = filtrate($msn);
	$homepage = filtrate($homepage);
	
	
	$gtype=0;
	//需要用户填写资料后,才能成为企业用户.如不填写资料也能成为企业用户的话,请把下面的//线取消即可
	//$gtype=$grouptype==1?1:0;
	
	if($groupid==3||$groupid==4||$memberlevel[$groupid]||!in_array($groupid,explode(",",$webdb[reg_group]))){
		$groupid=8;
	}

	$groupid || $groupid=8;
	

	$array=array(
		'username'=>$username,
		'password'=>$password,
		'groupid'=>intval($groupid),
		'grouptype'=>$gtype,
		'yz'=>$webdb[RegYz],
		'lastvist'=>$timestamp,
		'lastip'=>$onlineip,
		'regdate'=>$timestamp,
		'regip'=>$onlineip,
		'sex'=>$sex,
		'bday'=>"$bday_y-$bday_m-$bday_d",
		'oicq'=>$oicq,
		'msn'=>$msn,
		'homepage'=>$homepage,
		'email'=>$email,
		'mobphone'=>$mobphone
	);
	if($webdb['yzNumReg']==1){
		$array['email_yz']=1;
	}elseif($webdb['yzNumReg']==2){
		$array['mob_yz']=1;
	}

	//用户注册
	$uid = $userDB->register_user($array);
	if($uid<1){
		showerr($uid);
	}

	if($webdb[RegCompany] && $gtype==1){
		//注册企业用户
		//$db->query("INSERT INTO `{$pre}memberdata_1` ( `uid`) VALUES ('$uid')");
	}
	
	//用户登录
	$cookietime = 3600;
	$userDB->login($username,$password,$cookietime);

	//注册时间间隔处理
	if($webdb[limitRegTime]){
		set_cookie("limitRegTime",1,$webdb[limitRegTime]*60);
	}
	
	//注册用户自定义字段
	Reg_memberdata_field($uid,$postdb);

	//通行证处理
	if($_COOKIE[passport_url]||$_POST[passport_url]){
		$passport_url=urldecode($_COOKIE[passport_url]?$_COOKIE[passport_url]:$_POST[passport_url]);
		setcookie('passport_url','');
		$userDB->passport_server($username,$passport_url);
	}

	$jumpto&&$jumpto=urldecode($jumpto);

	add_user($uid,$webdb[regmoney],'注册得分');

	propagandize_reg($uid,$propagandize_name);	//介绍用户注册奖励积分

	
	//捆绑QQ帐号
	list($token,$secret,$openid)=explode("\t",mymd5(get_cookie('token_secret'),'DE'));	
	if($openid){
		$rs1 = $db->get_one("SELECT * FROM {$pre}memberdata WHERE `qq_api`='$openid'");
		if(!$rs1){
			$db->query("UPDATE {$pre}memberdata SET `qq_api`='$openid' WHERE username='$username'");
			refreshto("$webdb[www_url]","帐号捆绑成功!!",1);
		}
	}

	

	if(strstr($jumpto,$webdb[www_url])){
		refreshto("$jumpto","恭喜你，注册成功",1);
	}else{
		refreshto("$webdb[www_url]","恭喜你，注册成功",1);
	}
}else{

	//通行证处理
	if($_GET[passport_url]){
		setcookie('passport_url',$_GET[passport_url]);
	}

	$_fromurl || $_fromurl=$FROMURL;
	require(ROOT_PATH."inc/head.php");
	require(html("reg"));
	require(ROOT_PATH."inc/foot.php");
}


?>