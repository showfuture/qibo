<?php
!function_exists('html') && exit('ERR');
header('Content-Type: text/html; charset=gb2312');
if($type=='name'){
	if($name==''){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 请输入帐号,不能为空");
	}
	if (strlen($name)>30 || strlen($name)<3){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 帐号不能小于3个字符或大于30个字符");
	}
	$S_key=array('|',' ','',"'",'"','/','*',',','~',';','<','>','$',"\\","\r","\t","\n","`","!","?","%","^");
	foreach($S_key as $value){
		if (strpos($name,$value)!==false){ 
			die("<img src=$webdb[www_url]/images/default/check_error.gif> 用户名中包含有禁止的符号“{$value}”"); 
		}
	}
	if($userDB->get_passport($name,'name')){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> <font color='blue'>$name</font>,已经被注册了,请更换一个");
	}
	die("<img src=$webdb[www_url]/images/default/check_right.gif> <font color=red>恭喜你,此帐号可以使用!</font>");
}elseif($type=='email'){
	if($name==''){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 请输入邮箱,不能为空");
	}
	if (!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$name)) {
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 邮箱不符合规则"); 
	}
	if( $webdb[emailOnly] && $userDB->check_emailexists($name) ){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 当前邮箱已被注册了,请更换一个!"); 
	}
	die("<img src=$webdb[www_url]/images/default/check_right.gif> <font color=red>恭喜你,此邮箱可以使用!</font>");
}elseif($type=='pwd'){
	if($name==''){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 请输入密码,不能为空");
	}
	if (strlen($name)>30 || strlen($name)<6){
		die("<img src=$webdb[www_url]/images/default/check_error.gif> 密码不能小于6个字符或大于30个字符");
	}
	$S_key=array('|',' ','',"'",'"','/','*',',','~',';','<','>','$',"\\","\r","\t","\n","`","!","?","%","^");
	foreach($S_key as $value){
		if (strpos($name,$value)!==false){ 
			die("<img src=$webdb[www_url]/images/default/check_error.gif> 密码中包含有禁止的符号“{$value}”"); 
		}
	}
	die("<img src=$webdb[www_url]/images/default/check_right.gif> <font color=red>恭喜你,此密码可以使用!</font>");

}elseif($type=='yzimg'){
	if($db->get_one("SELECT * FROM {$pre}yzimg WHERE $SQL imgnum='$name' AND sid='$usr_sid'")){
		die("<img src=$webdb[www_url]/images/default/check_right.gif> <font color=red>验证码输入正确!</font>");
	}else{
		die("<img src=$webdb[www_url]/images/default/check_error.gif>请输入正确的验证码"); 
	}
}elseif($type=='propagandize'){

	if($userDB->get_passport($name,'name')){
		die("<img src=$webdb[www_url]/images/default/check_right.gif> <font color=red>推荐人帐号输入正确!</font>");
	}
	die("<img src=$webdb[www_url]/images/default/check_error.gif> 该推荐人的帐号不存在！");
	
}

?>