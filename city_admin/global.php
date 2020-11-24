<?php
define('Memberpath',dirname(__FILE__).'/');
require(Memberpath."../f/global.php");



if(!$webdb[web_open])
{
	$webdb[close_why] = str_replace("\n","<br>",$webdb[close_why]);
	showerr("网站暂时关闭:$webdb[close_why]");
}


if(!$lfjid){
	showerr("你还没登录");
}elseif($_GET['admin_city']){
	if(!$city_DB[name][$_GET['admin_city']]){
		showerr('当前城市不存在');
	}
	setcookie('admin_cityid',$_GET['admin_city'],time()+3600,"/");
	$_COOKIE['admin_cityid']=$_GET['admin_city'];
}
elseif(!$_COOKIE['admin_cityid']){
	if(count($city_DB[name])<2){
		showerr('单城市版没有城市管理功能!');
	}
	$show='';
	foreach( $city_DB[name] AS $key=>$value){
		$show.="<option value='$key'>$value</option>";
	}
	foreach( $city_DB[name] AS $key=>$value){
	}
	showerr("<select name='select' onChange=\"window.location.href='?admin_city='+this.options[this.selectedIndex].value\"><option value=''>请选择一个你要管理的城市</option>$show</select>");
}
if($city_id=$_COOKIE['admin_cityid']){
	$cityDB=$db->get_one("SELECT * FROM {$pre}fenlei_city WHERE fid='$city_id'");
	$detail=explode(',',$cityDB[admin]);
	if(!$web_admin&&!in_array($lfjid,$detail)){
		setcookie('admin_cityid','');
		showerr("<A HREF='?'>你不是本城市的管理员,点击返回选择城市!</A>");
	}
}

$id=intval($id);
$aid=intval($aid);
$tid=intval($tid);


?>