<?php
!function_exists('html') && exit('ERR');
if($lfjid){
	@include(ROOT_PATH."data/level.php");
	if( ereg("^pwbbs",$webdb[passport_type]) &&!is_array($db_modes) ){
		@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM {$TB_pre}msg WHERE `touid`='$lfjuid' AND type='rebox' AND ifnew=1"));
	}elseif( ereg("^dzbbs",$webdb[passport_type]) ){
		if($webdb[passport_type]=='dzbbs7'){
			$pmNUM=uc_pm_checknew($lfjuid);
		}else{
			@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM {$TB_pre}pms WHERE `msgtoid`='$lfjuid' AND folder='inbox' AND new=1"));
		}			
	}else{
		@extract($db->get_one("SELECT COUNT(*) AS pmNUM FROM `{$pre}pm` WHERE `touid`='$lfjuid' AND type='rebox' AND ifnew='1'"));
	}
	if(!$pmNUM){
		$MSG="<A target=\"_blank\" HREF=\"$webdb[www_url]/member/index.php?main=pm.php?job=list\">站内消息</A>";
	}else{
		$MSG="<A target=\"_blank\" HREF=\"$webdb[www_url]/member/index.php?main=pm.php?job=list\" style=\"color:blue;\">你有新消息({$pmNUM})</a>";
	}
	$lfjdb[_lastvist]=date("Y-m-d H:i",$lfjdb[lastvist]);
	$lfjdb[_regdate]=date("Y-m-d H:i",$lfjdb[regdate]);
}
if($styletype&&!eregi("^[-_0-9a-z]+$",$styletype)){
	showerr("风格样式有误",1);
}elseif(!$styletype){
	$styletype=0;
}
require_once(html("login_tpl/$styletype"));
$show=ob_get_contents();
ob_end_clean();
$show=str_replace(array("\n","\r","<!---->","'"),array("","","","\'"),$show);
if($webdb[www_url]=='/.'){
	$show=str_replace('/./','/',$show);
}

if($iframeID){	//框架方式不会拖慢主页面打开速度,推荐
	//处理跨域问题
	if($webdb[cookieDomain]){
		echo "<SCRIPT LANGUAGE='JavaScript'>
<!--
if('$showDomain'=='1'){
	if('$webdb[cookieDomain]'!='')document.domain = '$webdb[cookieDomain]';
}else{
	window.onerror=function (){
		url = '$WEBURL';
		url +=url.indexOf('?')>0?'&':'?';
		window.location.href=url+'showDomain=1';
		return true;
	};
	obj = (self==top) ? window.opener : window.parent ;
	obj.document.body;
}
//-->
</SCRIPT>";
	}

	echo "<SCRIPT LANGUAGE=\"JavaScript\">
	parent.document.getElementById('$iframeID').innerHTML='$show';
	</SCRIPT>";
}else{			//JS式会拖慢主页面打开速度,不推荐
	echo "document.write('$show');";
}

?>