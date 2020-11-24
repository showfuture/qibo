<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){

	unset($SQL);
	$postdb[flashurl]=$flashurl;
	$postdb[width]=$width;
	$postdb[height]=$height;
	$code=addslashes(serialize($postdb));
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
	@extract($code);
	if($rsdb[js_time]){
		$js_time='checked';
	}
	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;
	$hide=(int)$rsdb[hide];
	$hidedb["$hide"]="checked";


 	require("head.php");
	require("template/label/swf.htm");
	require("foot.php");

}

?>