<?php
if(!function_exists('html')){
	die('F');
}
require_once(dirname(__FILE__)."/googlemap.inc.php");
explain_url($city_id);

$title = filtrate($title);
$cityname || $cityname='北京';
eregi("^[a-z0-9 ]+$",$cityname) || $cityname='中国'.$cityname;	//中文城市名要加上中国二字

print<<<EOT

<!DOCTYPE html>
<html dir="LTR"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>谷歌地图位置显示 $titleDB[title]</title>
<link href="$webdb[www_url]/images/default/googlemap.css" rel="stylesheet" type="text/css" />

<SCRIPT LANGUAGE="JavaScript">
<!--
if('$showDomain'=='1'){
	if('$webdb[cookieDomain]'!='')document.domain = '$webdb[cookieDomain]';
}else{
	window.onerror=function (){
		url = '$WEBURL';
		url +=url.indexOf('?')>0?'&':'?';
		if('$webdb[cookieDomain]'!='')window.location.href=url+'showDomain=1';
		return true;
	};
	obj = (self==top) ? window.opener : window.parent ;
	obj.document.body;
}
//-->
</SCRIPT>

<script type="text/javascript"
    src="http://ditu.google.cn/maps/api/js?sensor=false&language=zh"></script> 
<script  type="text/javascript"> 
var geocoder;
var query = "$cityname";
var map;
var newMarker = null;
var mapLat=parseFloat("$position_x"),mapLng=parseFloat("$position_y");
function init() {
	geocoder = new google.maps.Geocoder();
	map = new google.maps.Map(document.getElementById("map_canvas"), {scaleControl: true});
	map.setZoom(14);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

	if( isNaN(mapLat) || isNaN(mapLng) ){
		codeAddress();
	}else{
		mapLatLng = new google.maps.LatLng(mapLat,mapLng);
		map.setCenter(mapLatLng);
		newMarker = new google.maps.Marker({map: map,position:mapLatLng});
		var infowindow = new google.maps.InfoWindow();
		infowindow.setContent('<b>$title</b>');
		google.maps.event.addListener(newMarker, 'click', function() {infowindow.open(map, newMarker);});
	}
}

function codeAddress() {
	var address = query;
    geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			newMarker = new google.maps.Marker({map: map, position: results[0].geometry.location});
		} else {
			map.setZoom(5);
			map.setCenter(new google.maps.LatLng(39.89979413273051,116.35774612426758));
		}
	});
}
</script> 
</head> 
<body onload="init()">
    
  <div id="map_canvas" style="width: 100%; height: 100%;"></div> 
</body> 
</html> 

EOT;

?>