<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){

	if(ereg("\\\$AD_label",$code)){
		showmsg("这里不能放广告代码,要放广告代码,只能手工修改模板放进去!");
	}
	//$code=preg_replace("/http:\/\/([\d\w\/_\.]*)\/ie_edit\//is","",$code);
	//对地址做处理
	$code=En_TruePath($code);

	//多城市新加功能
	$pic_city_id = intval($pic_city_id);
	//$postdb[pic_city_id] = $pic_city_id;
	$rsdb = get_label();
	$_code = unserialize($rsdb[code]);
	if($pic_city_id){
		if($rsdb[code]==''){
			showmsg('你必须要先定义好全国显示的数据后,才可以再重新定义指定城市显示的数据!');
		}elseif(!$_code[0]){
			$_code[0] = $rsdb[code];
		}		
	}	
	if($_code[0]){
		$_code[$pic_city_id] = stripslashes($code);
		$code = addslashes(serialize($_code));
	}

	$div_db[html_edit]=$html_edit;
	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=0;

	

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


//多城市新加功能
$pic_city_id = 0;
$_code = unserialize($rsdb[code]);
if($_code[$_GET[pic_city_id]]){
	$rsdb[code] = $_code[$_GET[pic_city_id]];
}elseif(!isset($_GET[pic_city_id])&&$_code[$city_id]){
	$pic_city_id = $city_id;
	$rsdb[code] = $_code[$city_id];
}elseif($_code[0]){
	$rsdb[code] = $_code[0];
}

//if($html_edit==1||$htmledit=='yes'){
$rsdb[code] = editor_replace($rsdb[code]);
//}

//强制更换$html_edit
//if($htmledit=="no"){
//	$html_edit=0;
//}elseif($htmledit=="yes"){
//	$html_edit=1;
//}


//真实地址还原
$rsdb[code]=En_TruePath($rsdb[code],0);


	//多城市新加功能
	isset($_GET[pic_city_id]) && $pic_city_id = $_GET[pic_city_id];
	@include(ROOT_PATH.'data/all_city.php');
	if(count($city_DB[name])>1){
		$select_city="<select name='pic_city_id' onChange='CT_jumpMenu(this)'><option value='0'>全国</option>";
		foreach( $city_DB[name] AS $key=>$value){
			$ck=$key==$pic_city_id?' selected ':'';
			$select_city.="<option value='$key'$ck>$value</option>";
		}
		$select_city.="</select>";
	}

require("head.php");
require("template/label/code.htm");
require("foot.php");
?>