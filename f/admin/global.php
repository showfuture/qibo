<?php
function_exists('html') OR exit('ERR');

define('Mdirname', preg_replace("/(.*)\/([^\/]+)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );
define('Mpath', preg_replace("/(.*)\/([^\/]+)\/([^\/]+)/is","\\1/\\2/",str_replace("\\","/",dirname(__FILE__))) );

define('Madmindir', preg_replace("/(.*)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );


$Mpath = Mpath;
define('Adminpath',dirname(__FILE__).'/');


require(Mpath."inc/function.php");
require_once(Mpath."inc/module.class.php");
$Fid_db = include(ROOT_PATH."data/all_fid.php");

$Murl=$webdb[www_url].'/'.Mdirname;
$_pre="{$pre}{$webdb[module_pre]}";					//数据表前缀
$Module_db=new Module_Field();						//自定义模型相关

$Mdomain=$ModuleDB[$webdb[module_pre]][domain]?$ModuleDB[$webdb[module_pre]][domain]:$Murl;

@include_once(ROOT_PATH."data/all_city.php");	//必须要放在$Mdomain变量之后,里边要用到$Mdomain变量


?>