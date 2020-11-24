<?php
require_once(dirname(__FILE__)."/"."global.php");

$ifuseMenu=0;	//不想使用后台自定义菜单的话.把1换成0


$selectcity='';
foreach( $city_DB[name] AS $key=>$value){
	$check=$key==$city_id?' selected ':'';
	$selectcity.="<option value='$key' $check>$value</option>";
}
$selectcity="<select name='select' onChange=\"window.location.href='?admin_city='+this.options[this.selectedIndex].value\">$selectcity</select>";


if($web_admin){
	$power=3;
}else{
	$power=1;
}
unset($menudb,$menu_GpartDB);
$SystemId=intval($SystemId);

 
preg_match("/(.*)\/(index\.php|)\?main=(.+)/is",$WEBURL,$UrlArray);
$MainUrl=$UrlArray[3]?$UrlArray[3]:"map.php?uid=$lfjuid";

require_once(dirname(__FILE__)."/"."menu.php");

 

$topmenu='';
$select_id=0;
$i=0;
 

$start_id=($select_id-4>0)?($select_id-4):0;

require_once(dirname(__FILE__)."/"."template/index.htm");


?>