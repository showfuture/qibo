<?php
require(dirname(__FILE__)."/f/global.php");
choose_domain();	//域名判断

/**
*标签使用
**/
$chdb[main_tpl] = html("allsort");
$ch_fid	= $ch_pagetype = 5;
$ch_module = $webdb[module_id]?$webdb[module_id]:99;	//系统特定ID参数,每个系统不能雷同
require(ROOT_PATH."inc/label_module.php");

require(ROOT_PATH."data/friendlink.php");
//每个栏目的信息数
$InfoNum=get_infonum($city_id);
require(Mpath."inc/head.php");
require(html("allsort"));
require(Mpath."inc/foot.php");