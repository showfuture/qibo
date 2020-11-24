<?php
require(dirname(__FILE__)."/global.php");
require(ROOT_PATH."data/friendlink.php");

//SEO
$titleDB['title']		= $webdb['SEO_title']?$webdb['SEO_title']:$webdb['Info_webname'];
$titleDB['keywords']	= $webdb['SEO_keywords']?$webdb['SEO_keywords']:$webdb['metakeywords'];
$titleDB['description']	= $webdb['SEO_description']?$webdb['SEO_description']:$webdb['description'];

/**
*ฑ๊วฉสนำร
**/
$ch_fid	= $ch_pagetype = 0;
$ch_module = $webdb[module_id];
require(ROOT_PATH."inc/label_module.php");


require(ROOT_PATH."inc/head.php");
require(getTpl("index"));
require(ROOT_PATH."inc/foot.php");


?>