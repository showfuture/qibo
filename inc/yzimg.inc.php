<?php
defined('ROOT_PATH') or die();
@ob_end_clean();
require_once(ROOT_PATH."inc/waterimage.php");

//GIF动画要用到
require_once(ROOT_PATH."inc/gifencoder.inc.php");
require_once(ROOT_PATH."inc/showgif.php");

if($webdb[is_chineseIMG]){
	if($webdb[is_MathYZ]){
		$array=array('-','+');
		$a=rand(0,10);
		$chinaDB=array('零','壹','贰','叁','肆','伍','陆','柒','捌','玖','拾');
		$typem=rand(0,1);
		$typemDB=array('减','加');
		$b=$array[$typem];
		$c=rand(0,10);
		$string_yzimg=$chinaDB[$a].$typemDB[$typem].$chinaDB[$c].'=?';
		$_string_yzimg=$typem?($a+$c):($a-$c);
	}else{
		$_string_yzimg=$string_yzimg=chines_Rand(3);
	}
}else{
	if($webdb[is_MathYZ]){
		$array=array('-','+');
		$a=rand(0,9);
		$typem=rand(0,1);
		$b=$array[$typem];
		$c=rand(0,9);
		$string_yzimg=$a.$b.$c.'=?';
		$_string_yzimg=$typem?($a+$c):($a-$c);
	}else{
		$_string_yzimg=$string_yzimg=yzImgNumRand(4);
	}
}


$db->query("REPLACE INTO `{$pre}yzimg` ( `sid` , `imgnum` , `posttime` ) VALUES ('$usr_sid', '$_string_yzimg', '$timestamp')");
if($webdb['is_chineseIMG']){	//中文
	chinese_yzimg($string_yzimg);

}elseif($webdb['YzImg_difficult']==3){	//GIF动画超复杂
	show_gif_difficult($string_yzimg);

}elseif($webdb['YzImg_difficult']==2){	//GIF动画复杂
	show_gif_easy($string_yzimg);

}elseif($webdb['YzImg_difficult']){	//难识别的图片
	yz2img($string_yzimg);
	
}else{	//易识别的图片
	yzImg($string_yzimg);	
}

function yzImgNumRand($lenth){
	global $webdb;
	$string = "0123456789qwertyuipasdfghjkzxcvbnmQERTYUADFGHJLBNM";
	if(eregi("^([a-z0-9]+)$",$webdb[YzImg_string])){
		$string = $webdb[YzImg_string];
	}
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$randval.= substr($string,mt_rand(0,strlen($string)-1),1);
	}
	return $randval;
}

function chines_Rand($lenth){
	global $webdb;
	$string = "齐博是广州协天软件科技有限公司的产品而龙城是产品的总设计师";
	if($webdb[YzImg_string]&&!eregi('[[:alnum:]]',$user)&&!eregi('[[:punct:]]',$user)){
		$string = $webdb[YzImg_string];
	}
	mt_srand((double)microtime() * 1000000);
	for($i=0;$i<$lenth;$i++){
		$rand1=mt_rand(0,strlen($string)-2);
		$rand1=$rand1%2==0?$rand1:($rand1-1);
		$randval.= substr($string,$rand1,2);
	}
	return $randval;
}
?>