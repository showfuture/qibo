<?php 
require(dirname(__FILE__)."/global.php");
$WebTitle=$webdb['webname'];
$city_name=$city_DB[name];

if($act=="search"){
	@extract($db->get_one("SELECT fid FROM {$_pre}city WHERE name='$cityname'"));
	if($fid){
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php?choose_cityID=$fid'>";
		exit;
	}else{
		ShowErrs("<a href=\"$FROMURL\">当前系统没有您输入的城市！</a>");
	}
}

require(Mpath."template/allcity.htm");
require(Mpath."template/foot.htm");


?>