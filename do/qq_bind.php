<?php
require(dirname(__FILE__)."/global.php");
if($lfjid){
	showerr("你已经登录了,请不要重复登录,要重新登录请点击<br><br><A HREF='$webdb[www_url]/do/login.php?action=quit'>安全退出</A>");
}elseif(!$webdb[QQ_login]){
	showerr('该功能已关闭!');
}

if($step==2){		
	$login = $userDB->login($username,$password,intval($webdb[QQ_logintime]*3600));
	if($login==0){
		showerr("当前用户不存在,请重新输入");
	}elseif($login==-1){
		showerr("密码不正确,点击重新输入");
	}

	list($token,$secret,$openid)=explode("\t",mymd5(get_cookie('token_secret'),'DE'));
	
	$MSG='帐号捆绑失败!!';

	if($openid){
		$rs1 = $db->get_one("SELECT * FROM {$pre}memberdata WHERE `qq_api`='$openid'");
		$rs2 = $db->get_one("SELECT * FROM {$pre}memberdata WHERE username='$username'");
		if(!$rs1&&!$rs2[qq_api]){
			$db->query("UPDATE {$pre}memberdata SET `qq_api`='$openid' WHERE username='$username'");
			$MSG='帐号捆绑成功!!';
		}else{
			$MSG="帐号捆绑失败,因为帐号{$username}已经绑定了其它QQ号码!!";
		}
	}	

	refreshto("$webdb[www_url]/","$MSG{$uc_login_code}",3);
}
	
require(ROOT_PATH."inc/head.php");
require(html("qq_bind"));
require(ROOT_PATH."inc/foot.php");

?>