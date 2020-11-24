<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){

	unset($SQL);
	$postdb[imgurl]=En_TruePath($imgurl);
	$postdb[imglink]=En_TruePath($imglink);
	$postdb[width]=$width;
	$postdb[height]=$height;

	//多城市新加功能
	$pic_city_id = intval($pic_city_id);
	$postdb[pic_city_id] = $pic_city_id;
	$rsdb = get_label();
	$code = unserialize($rsdb[code]);
	if($pic_city_id){
		if(!is_array($code)){
			showmsg('你必须要先定义好全国显示的数据后,才可以再重新定义指定城市显示的数据!');
		}elseif(!$code[0]){
			$code[0] = $code;
		}		
	}	
	if($code[0]){
		$code[$pic_city_id] = $postdb;
	}else{
		$code = $postdb;
	}
	

	$code=addslashes(serialize($code));	//多城市新加功能
	//$code=addslashes(serialize($postdb));
	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=0;



	//插入或更新标签库
	do_post();

}else{
	


	$rsdb=get_label();
	$div=unserialize($rsdb[divcode]);
	@extract($div);
	$code=unserialize($rsdb[code]);

	//多城市新加功能
	if($code[$_GET[pic_city_id]]){
		$code=$code[$_GET[pic_city_id]];
	}elseif(!isset($_GET[pic_city_id])&&$code[$city_id]){
		$code = $code[$city_id];
	}elseif($code[0]){
		$code = $code[0];
	}


	@extract($code);
	$rsdb[hide]?$hide_1='checked':$hide_0='checked';
	if($rsdb[js_time]){
		$js_time='checked';
	}
	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;
	$hide=(int)$rsdb[hide];

	$imgurl=En_TruePath($imgurl,0);
	$imglink=En_TruePath($imglink,0);

	$hidedb["$hide"]="checked";


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
	require("template/label/pic.htm");
	require("foot.php");

}

?>