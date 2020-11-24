<?php

if($webdb['run_time']==1){
	$speed_endtime=explode(' ',microtime());
	$speed_totaltime.="TIME ".number_format((($speed_endtime[0]+$speed_endtime[1]-$speed_headtime)/1),6)." second(s)";
}
require(ROOT_PATH."inc/foot.php");

$content=ob_get_contents();
$content=str_replace('<!--include','',$content);
$content=str_replace('include-->','',$content);

//POST实现伪静态处理,POST的URL必须是href="网址post.php变量"
$_city_url=str_replace(array('.','/',),array('\.','\/'),$city_url);
$content=preg_replace("/href=\"$_city_url\/post\.php([^\"]*)\"/eis","get_url_value('\\1')",$content);

ob_end_clean();
ob_start();
echo $content;


//POST实现伪静态处理
function get_url_value($string){
	$detail=explode("&",substr($string,1));
	foreach($detail AS $value){
		$d=explode("=",$value);
		$d[0] && $$d[0]=$d[1];
	}
	if($action=='del'){
		$type='del';
	}elseif($job=='edit'){
		$type='edit';
	}else{
		$type='new';
		if($fid&&!$city_id){
			$city_id=$GLOBALS['city_id'];
		}elseif(!$fid){
			unset($city_id,$zone_id,$street_id);
		}
		if($webdb[post_htmlType]==1){
			unset($zone_id,$street_id);	//url太长了,也不好
		}
	}
	$url=get_post_url($type,$fid,$id,$city_id,$zone_id,$street_id);
	return "href=\"$url\"";
}

?>