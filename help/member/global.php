<?php
define('Memberpath',dirname(__FILE__).'/');
require(Memberpath."../global.php");
require(ROOT_PATH."inc/class.inc.php");
$Guidedb=new Guide_DB;


if(!$lfjid){
	showerr("ฤใปนรปตวยผ");
}


function ckGroupYz($value){
	global $lfjdb;
	if(!$value)
	{
		return 0;
	}
	$detail=explode(",",$value);
	if( in_array($lfjdb[groupid],$detail) )
	{
		return 1;
	}
}


?>