<?php
require(dirname(__FILE__)."/"."global.php");

$GuideFid[$fid] = " &gt;&gt; <a href=\"$webdb[_www_url]/do/sitemap.php\">мЬу╬╣ьм╪</a>";
$fenlie_fid_db = include(ROOT_PATH."data/all_fid.php");
$hy_fid_db = include(ROOT_PATH."hy/data/all_fid.php");	
include(ROOT_PATH."help/data/all_fid.php");
$help_fid_db = $Fid_db;

$Fid_db = include(ROOT_PATH."data/all_fid.php");

require(ROOT_PATH."inc/head.php");
require(html("sitemap"));
require(ROOT_PATH."inc/foot.php");
?>