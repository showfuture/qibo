<?php
require_once(dirname(__FILE__)."/"."global.php");

$rsdb=$db->get_one("SELECT A.*,S.* FROM {$_pre}content A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");

if(!$rsdb)
{
	die("地址有误,请检查之");
}

@include(dirname(__FILE__)."/data/guide_fid.php");


require(ROOT_PATH."inc/head.php");
require(getTpl("comment"));
require(ROOT_PATH."inc/foot.php");
?>