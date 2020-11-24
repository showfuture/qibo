<?php
if(!function_exists('html')){
	die('F');
}

$cityname=str_replace("市","",$city_DB[name][$cityid]);


//require_once(ROOT_PATH."inc/pinyin.php");
//$cityname=change2pinyin($cityname,0);

$cityname || $cityname='guangzhou';	//默认为广州

print<<<EOT

<html xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="content-type" content="text/html; charset=GB2312"/>
<meta name="keywords" content="LTEZMarker,JavaScript,灵图,51ditu EZMarker API,地图,范例文档,vml"/>
<title>使用直接显示在页面上的ezmarker-灵图51ditu Maps API范例</title>
<style type="text/css">v\:*{behavior:url(#default#VML);}</style>
<script language="javascript" src="http://api.51ditu.com/js/maps.js"></script>
<script language="javascript" src="http://api.51ditu.com/js/ezmarker.js"></script>
<SCRIPT LANGUAGE='JavaScript'>
<!--
if('$showDomain'=='1'){
	if('$webdb[cookieDomain]'!='')document.domain = '$webdb[cookieDomain]';
}else{
	window.onerror=function (){
		url = '$WEBURL';
		url +=url.indexOf('?')>0?'&':'?';
		window.location.href=url+'showDomain=1';
		return true;
	};
	obj = (self==top) ? window.opener : window.parent ;
	obj.document.body;
}
//-->
</SCRIPT>
</head>
<body>



	<div id="mapDiv" style="position:absolute;width:600px; height:400px;">
	</div>
<script language="javascript">
var ezmarker=new LTEZMarker("ezmarker",1,document.getElementById("mapDiv"));	//创建一个ezmarker
ezmarker.setDefaultView("$cityname",4);//设置ezmarker地图的默认视图位置到深圳

function setMap(point,zoom){
	window.opener.document.getElementById('$mapid').value=point.getLongitude()+','+point.getLatitude();
	window.self.close();
//document.getElementById("x").value=point.getLongitude();
//document.getElementById("y").value=point.getLatitude();
//document.getElementById("z").value=zoom;
}

LTEvent.addListener(ezmarker,"mark",setMap);
</script>
	 

</BODY>
</HTML>


EOT;
?>