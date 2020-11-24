<?php
define('Mpath',dirname(__FILE__).'/');
define( 'Mdirname' , preg_replace("/(.*)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );
require_once(dirname(__FILE__).'/../inc/common.inc.php');	//核心文件
require_once(dirname(__FILE__).'/function.php');
require_once(dirname(__FILE__).'/function.inc.php');
$Murl=$webdb['www_url'].'/'.Mdirname;					//本模块的访问地址
$Fid_db = include(ROOT_PATH."data/all_fid.php");
?>