<?php
require(dirname(__FILE__)."/"."global.php");
$_GET['_fromurl'] && $_fromurl=$_GET['_fromurl'];
unset($uc_login_code);

//退出
if($action=="quit")
{
	$userDB->quit();

	//通行证处理
	if($_GET[passport_url]){
		$userDB->passport_server($lfjid,$_GET[passport_url]);
	}

	if(!$fromurl){
		$fromurl="$webdb[www_url]/";
	}
	echo "$uc_login_code<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$fromurl'>";
	exit;
}
else
{	//登录
	if($lfjid){
		//通行证处理
		if($_GET[passport_url]){
			$userDB->passport_server($lfjid,$_GET[passport_url]);
		}
		showerr("你已经登录了,请不要重复登录,要重新登录请点击<br><br><A HREF='$webdb[www_url]/do/login.php?action=quit'>安全退出</A>");
	}
	if($step==2){		
		$login = $userDB->login($username,$password,$cookietime);
		if($login==0){
			showerr("当前用户不存在,请重新输入");
		}elseif($login==-1){
			showerr("密码不正确,点击重新输入");
		}

		//通行证处理
		if($_COOKIE[passport_url]||$_POST[passport_url]){
			$passport_url=urldecode($_COOKIE[passport_url]?$_COOKIE[passport_url]:$_POST[passport_url]);
			setcookie('passport_url','');
			$userDB->passport_server($username,$passport_url);
		}

		if($fromurl&&!eregi("login\.php",$fromurl)&&!eregi("reg\.php",$fromurl)){
			$jumpto=$fromurl;
		}elseif($FROMURL&&!eregi("login\.php",$FROMURL)&&!eregi("reg\.php",$FROMURL)){
			$jumpto=$FROMURL;
		}else{
			$jumpto="$webdb[www_url]/";
		}
		refreshto("$jumpto","登录成功$uc_login_code",1);
	}
	//通行证处理
	if($_GET[passport_url]){
		setcookie('passport_url',$_GET[passport_url]);
	}
	require(ROOT_PATH."inc/head.php");
	require(html("login"));
	require(ROOT_PATH."inc/foot.php");
}


?>