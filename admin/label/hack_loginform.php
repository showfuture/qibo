<?php
!function_exists('html') && exit('ERR');

if($action=='mod'){
	
	if(!$code){
		showmsg("请选择一种登录代码");
	}
	$div_db[logintype]=$logintype;
	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=0;
	$code=En_TruePath($code);

	//插入或更新标签库
	do_post();


}



$rsdb=get_label();
$rsdb[hide]?$hide_1='checked':$hide_0='checked';
if($rsdb[js_time]){
	$js_time='checked';
}

@extract(unserialize($rsdb[divcode]));
$div_width && $div_w=$div_width;
$div_height && $div_h=$div_height;

//真实地址还原
$rsdb[code]=En_TruePath($rsdb[code],0);

if(!isset($logintype)){
	$rsdb[code]='<script language="JavaScript" src="'.$webdb[www_url].'/do/hack.php?hack=login&job=js&styletype=0"></script>';
}

$logintypedb[$logintype]=' checked ';

require("head.php");
require("template/label/hack_code.htm");
require("foot.php");
?>