<?php
if(is_file('install.php')){
	header("location:install.php");exit;
}

require(dirname(__FILE__)."/f/global.php");

mob_goto_url("3g/index.php?choose_cityID=$city_id");	//手机访问自动跳转


if($jobs=='show'){	//标签处理
	//针对多城市版,有可能CITYID不存在.
	if(!$city_id){
		foreach( $city_DB[name] AS $key=>$value){
			$city_id=$key;
			break;
		}
	}

}elseif(!$city_id){	//强制用户人工选择城市

	require(dirname(__FILE__)."/allcity.php");
	exit;

}elseif($city_DB[domain][$city_id]){

	if(preg_replace("/http:\/\/([^\/]+)\/(.*)/is","http://\\1",$WEBURL)!=$city_DB[domain][$city_id]){
		
		header("location:".$city_DB[domain][$city_id]);
		exit;
	}
}

//choose_domain();	//域名判断

//缓存
$Cache_FileName=ROOT_PATH."cache/index/$city_id/index.php";
if(!$jobs&&!$MakeIndex&&$webdb[Info_index_cache]&&(time()-filemtime($Cache_FileName))<($webdb[Info_index_cache]*60)){
	echo read_file($Cache_FileName);
	exit;
}

if(count($city_DB[name])>1&&$webdb[Info_htmlType]==2){
	foreach( $city_DB[name] AS $key=>$value){
		if(!$city_DB['dirname'][$key]){
			//showerr("你启用了高级伪静态,但是没有把所有城市生成目录,请进后台把所有城市生成目录!<br>目前至少没有把城市“{$value}”生成独立目录!");
		}
	}
}

require(ROOT_PATH."data/friendlink.php");

//SEO
$titleDB['title'] = $city_DB['metaT'][$city_id]?seo_eval($city_DB['metaT'][$city_id]):"{$city_DB[name][$city_id]} $titleDB[title]";
$titleDB['keywords']	= $city_DB['metaK'][$city_id]?seo_eval($city_DB['metaK'][$city_id]):$titleDB['keywords'];
$titleDB['description'] = $city_DB['metaD'][$city_id]?seo_eval($city_DB['metaD'][$city_id]):$titleDB['description'];

//城市模板
if($city_DB[tpl][$city_id]){
	list($head_tpl,$foot_tpl,$index_tpl)=explode("|",$city_DB[tpl][$city_id]);
	$head_tpl && $head_tpl=Mpath.$head_tpl;
	$foot_tpl && $foot_tpl=Mpath.$foot_tpl;
	$index_tpl && $index_tpl=Mpath.$index_tpl;
}

/**
*标签使用
**/
$chdb[main_tpl] = html("index",$index_tpl);
$ch_fid	= $ch_pagetype = 0;
$ch_module = $webdb[module_id]?$webdb[module_id]:99;	//系统特定ID参数,每个系统不能雷同
require(ROOT_PATH."inc/label_module.php");


/**
*推荐的栏目在首页显示
**/
$listdb_moresort=Info_ListMoreSort($webdb[InfoIndexCSRow],$webdb[InfoIndexCSLeng],$city_id);

//每个栏目的信息数
$InfoNum=get_infonum($city_id);
require(Mpath."inc/head.php");
require(html("index",$index_tpl));
require(Mpath."inc/foot.php");


if(!$jobs&&!$MakeIndex&&$webdb[Info_index_cache]&&(time()-filemtime($Cache_FileName))>($webdb[Info_index_cache]*60)){
	if(!is_dir(dirname($Cache_FileName))){
		makepath(dirname($Cache_FileName));
	}
	write_file($Cache_FileName,$content);
}elseif($jobs=='show'){
	@unlink($Cache_FileName);
}

?>