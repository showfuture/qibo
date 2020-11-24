<?php 
require(dirname(__FILE__)."/global.php");
$WebTitle=$webdb['webname'];

//进入城市
if($_GET[choose_cityID]){
	foreach( $city_DB[domain] AS $key=>$value){
		if($_GET[choose_cityID]==$key){
			setcookie('city_id',$key,$timestamp+3600,'/');
			break;
		}
	}
}
require(Mpath."template/head.htm");
require(Mpath."template/index.htm");
require(Mpath."template/foot.htm");
?>