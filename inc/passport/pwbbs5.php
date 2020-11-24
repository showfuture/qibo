<?php
$TB_pre = $webdb[passport_pre] ? $webdb[passport_pre] : "pw_";
$TB_path = $webdb[passport_path];
$TB_url = $webdb[passport_url];

$TB[table] = "{$TB_pre}members";
$TB[uid] = "uid";
$TB[username] = "username";
$TB[password] = "password";

@include(ROOT_PATH."$TB_path/data/bbscache/config.php");


/**
*取得用户数据
**/
function PassportUserdb(){
	global $db,$timestamp,$webdb,$onlineip,$TB,$pre,$db_ifsafecv,$userDB;
	list($lfjuid,$lfjpwd,$safecv)=explode("\t",StrCode(GetCookie('winduser'),'DECODE'));
	if( !$lfjuid || !$lfjpwd )
	{
		return '';
	}
	if($db_ifsafecv)
	{
		$SQL=",M.safecv";
	}
	
	$detail = $userDB->get_allInfo($lfjuid);
	if( PwdCode($detail[password])!=$lfjpwd || ( $db_ifsafecv && $safecv!=$detail['safecv'] ) ){
		return ;
	}	
	return $detail;
}

function GetCookie($Var){
    return $_COOKIE[CookiePre().'_'.$Var];
}
function CookiePre(){
	//return ($GLOBALS['db_cookiepre']) ? $GLOBALS['db_cookiepre'] : substr(md5($GLOBALS['db_sitehash']), 0, 5);
	if($GLOBALS['db_cookiepre']){	//PW8.7 
		return $GLOBALS['db_cookiepre'];
	}else{
		return substr(md5(isset($GLOBALS['db_ifsafecv'])?$GLOBALS['db_sitehash']:$GLOBALS['db_hash']),0,5);
	}	
}

function PwdCode($pwd){
	return md5($_SERVER["HTTP_USER_AGENT"].$pwd.$GLOBALS['db_hash']);
}

function StrCode($string,$action='ENCODE'){
	$key	= substr(md5($_SERVER["HTTP_USER_AGENT"].$GLOBALS['db_hash']),8,18);
	$string	= $action == 'ENCODE' ? $string : base64_decode($string);
	$len	= strlen($key);
	$code	= '';
	for($i=0; $i<strlen($string); $i++){
		$k		= $i % $len;
		$code  .= $string[$i] ^ $key[$k];
	}
	$code = $action == 'DECODE' ? $code : base64_encode($code);
	return $code;
}

?>