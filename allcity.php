<?php
define('allcity_page',true);
require_once(dirname(__FILE__)."/f/global.php");
include_once(ROOT_PATH."data/all_area.php");
require(ROOT_PATH."data/friendlink.php");

if($webdb[Info_allcityType]==1){
	$query = $db->query("SELECT * FROM {$_pre}city ORDER BY letter ASC,list DESC");
	while($rs = $db->fetch_array($query)){
		$listdb[$rs[letter]][]=$rs;
	}
}

if($job == "jump"){
	$cityurl = $city_DB[domain][$choose_cityID] ? $city_DB[domain][$choose_cityID] : $city_DB[url][$choose_cityID];
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$cityurl'>";
	exit;
}

//按省份选择城市
$areaids = $city_DB[fup][$city_id] ? $city_DB[fup][$city_id] :1;
if($show=="citys"){
	$areaid || $areaid = 1;
	foreach($city_DB[$areaid] AS $key=>$value){
		$selecteds = $cityid==$key?"selected=\"selected\"":"";
		echo "<option value=\"$key\" $selecteds>$value</option>\r";
	}
	exit;
}

//SEO
$titleDB[title] = $city_DB[metaT][$city_id]?$city_DB[metaT][$city_id]:"{$city_DB[name][$city_id]} $webdb[webname]";
$titleDB[keywords]	= $city_DB[metaK][$city_id]?$city_DB[metaK][$city_id]:$webdb[metakeywords];
$titleDB[description] = $city_DB[metaD][$city_id]?$city_DB[metaD][$city_id]:$webdb[description];

require(Mpath."inc/head.php");
require(html("allcity"));
require(Mpath."inc/foot.php");
?>