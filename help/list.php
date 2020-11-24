<?php
require(dirname(__FILE__)."/global.php");
@include(dirname(__FILE__)."/data/guide_fid.php");

$GuideFid[$fid]=" -> <A HREF='./'>$webdb[Info_webname]</A> ".$GuideFid[$fid];

//获取栏目与模块的配置文件
$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");
if(!$fidDB){
	showerr("栏目不存在");
}

//跳转到外部地址
if($fidDB[jumpurl]){
	header("location:$fidDB[jumpurl]");
	exit;
}

$fidDB[descrip]=En_TruePath($fidDB[descrip],0);

//SEO
$titleDB[title]		= filtrate("$fidDB[name] - $webdb[Info_webname] - $titleDB[title]");
$titleDB[keywords]	= $titleDB[description] = filtrate("$webdb[Info_webname] - $webdb[Info_metakeywords] - $titleDB[title] - $titleDB[keywords]");


//模板
$FidTpl=unserialize($fidDB[template]);
$head_tpl=$FidTpl['head'];
$foot_tpl=$FidTpl['foot'];

$_url="list.php?fid=$fid";

//为获取标签参数
if($fidDB[type]){
	$chdb[main_tpl]=getTpl("bigsort",$FidTpl['list']);
}else{
	$chdb[main_tpl]=getTpl("list",$FidTpl['list']);
}


//标签
$ch_fid	= intval($fidDB[config][label_list]);		//是否定义了栏目专用标签
$ch_pagetype = 2;									//2,为list页,3,为bencandy页
$ch_module = $webdb[module_id];						//系统特定ID参数,每个系统不能雷同
$ch = 0;											//不属于任何专题
require(ROOT_PATH."inc/label_module.php");

$SQL=" AND (A.city_id='$city_id' OR A.city_id='0') ";

$NUM=0;
$Lrows=$fidDB[maxperpage]>0?$fidDB[maxperpage]:($webdb[Infolist_row]>0?$webdb[Infolist_row]:15);
if($fidDB[type]==0){
	@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}content A WHERE A.fid=$fid AND A.yz=1 $SQL"));
}


if($fidDB[type]==1){	//大分类
	$sort_db=$listdb_moresort=ListOnlySort(100);
}else{	//小分类
	$listdb=ListThisSort($Lrows,70);
	$showpage=getpage("{$_pre}content A","WHERE A.fid=$fid AND A.yz=1 $SQL",$_url,$Lrows,$NUM);	
}


require(ROOT_PATH."inc/head.php");
if($fidDB[type]){
	require(getTpl("bigsort",$FidTpl['list']));
}else{
	require(getTpl("list",$FidTpl['list']));
}
require(ROOT_PATH."inc/foot.php");

?>