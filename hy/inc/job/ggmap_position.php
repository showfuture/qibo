<?php
if(!function_exists('html')){
	die('F');
}
require_once(dirname(__FILE__)."/googlemap.inc.php");
explain_url($cityid);

$cityname || $cityname='北京';
eregi("^[a-z0-9 ]+$",$cityname) || $cityname='中国'.$cityname;	//中文城市名要加上中国二字

print<<<EOT

<!DOCTYPE html>
<html dir="LTR"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<title>谷歌地图位置定位 $titleDB[title]</title>
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
	map.setZoom(13);
	map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

	if( isNaN(mapLat) || isNaN(mapLng) ){
		codeAddress();
	}else{
		mapLatLng = new google.maps.LatLng(mapLat,mapLng);
		map.setCenter(mapLatLng);
		newMarker = new google.maps.Marker({map: map,draggable:true,position:mapLatLng});
	}

	google.maps.event.addListener(map, 'click', function(event) {
			if(newMarker!=null)newMarker.setMap(null);
			newMarker =  new google.maps.Marker({map: map,draggable:true, position:new google.maps.LatLng(event.latLng.lat(),event.latLng.lng())});
			click_dragend();
	});	
 }

 function click_dragend(){
	google.maps.event.addListener(newMarker, 'dragend', function(){postpoint();});
	google.maps.event.addListener(newMarker, 'click', function(){postpoint();});
 }

 function postpoint(){
	 if(confirm("你确认选择当前位置吗?")){
		 window.opener.document.getElementById('mapid').value=newMarker.getPosition().lat()+','+newMarker.getPosition().lng();
		 window.close();
	 }
 }

function codeAddress() {
	var address = query;
    geocoder.geocode( { 'address': address}, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			map.setCenter(results[0].geometry.location);
			newMarker = new google.maps.Marker({map: map,draggable:true, position: results[0].geometry.location});
			click_dragend();
		} else {
			alert("找不到你所在的城市 :" + status);
			map.setZoom(5);
			map.setCenter(new google.maps.LatLng(39.89979413273051,116.35774612426758));
		}
	});
}
</script> 
</head> 
<body onload="init()">
   <div style="margin:10px;width:100%;">帮助说明:鼠标单击选中的位置,会产生一个小图标,再点击小图标即可选中位置(也可以拖动小图标定义更精准的位置)!</div>
  <div id="map_canvas" style="width: 100%; height: 650px;"></div> 
</body> 
</html> 

EOT;



?>