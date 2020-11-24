<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){

	
	$div_db[c_code]=$code;
	$div_db[c_height]=$c_height;
	$div_db[c_rolltype]=$c_rolltype;
	$div_db[c_rollspeed]=$c_rollspeed;
	$code="<marquee direction=\'$c_rolltype\' scrolldelay=\'1\' scrollamount=\'$c_rollspeed\' onmouseout=\'if(document.all!=null){this.start()}\' onmouseover=\'if(document.all!=null){this.stop()}\' height=\'$c_height\'>$code</marquee>";
	
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

$rsdb[code]=$c_code;
if($c_rolltype!="up"&&$c_rolltype!="down"&&$c_rolltype!="left"&&$c_rolltype!="right"){
	$c_rolltype="up";
}
$c_rollspeed || $c_rollspeed=1;

$c_rolltypedb[$c_rolltype]=" checked ";


require("head.php");
require("template/label/hack_rollnews.htm");
require("foot.php");
?>