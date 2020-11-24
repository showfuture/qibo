<?php
error_reporting(0);
//JS显示广告,不再调用GLOBAL文件.节省MYSQL开支
if($_GET['job']=='js'){
	unset($_AD_label,$AD_label);
	require_once(dirname(__FILE__)."/../data/ad_cache.php");
	require_once(dirname(__FILE__)."/../data/config.php");

	$cityid=$_COOKIE["{$webdb[cookiePre]}city_id"];
	$show=$_AD_label[$cityid][$_GET['ad_id']]?$_AD_label[$cityid][$_GET['ad_id']]:$_AD_label[$_GET['ad_id']];

	//对javascript进行特别处理
	if(eregi("<SCRIPT",$show)){
		preg_match_all("/<SCRIPT([^>]*)>(.*?)<\/SCRIPT>/is",$show,$array);
		foreach($array[1] AS $key=>$value){
			//一般联盟广告会出现这种情况
			if(eregi("src=",$value)){
				$value=str_replace("'","\'",$value);
				echo "document.write('<SCRIPT$value><\/SCRIPT>');";
			}else{
				echo $array[2][$key];
			}
		}
		$show=preg_replace("/(.*?)<SCRIPT([^>]*)>(.*?)<\/SCRIPT>(.*?)/is","\\1\\4",$show);
	}

	$show=str_replace("\n","",$show);
	$show=str_replace("\r","",$show);
	$show=str_replace("'","\'",$show);
	echo "document.write('$show');";
	exit;
}
require(dirname(__FILE__)."/"."global.php");
if($job=="jump")
{
	$rs=$db->get_one("SELECT * FROM {$_pre}norm_place WHERE id='$id'");
	$acodedb=unserialize($rs[adcode]);
	if($acodedb){
		$db->query("UPDATE {$_pre}norm_place SET hits=hits+1 WHERE id='$id'");
		if($u_id){
			$db->query("UPDATE {$_pre}norm_user SET u_hits=u_hits+1 WHERE u_id='$u_id'");
		}
		if($acodedb[linkurl]&&!$u_id){
			header("location:$acodedb[linkurl]");
		}else{
			$url=base64_decode($url);
			header("location:$url");
		}
		
		exit;
	}
}
elseif($job=='sell')
{
	$query = $db->query("SELECT * FROM `{$_pre}compete_user` WHERE id='$id' AND endtime>'$timestamp' AND yz=1 AND city_id='$city_id' ORDER BY money DESC");
	while($rs = $db->fetch_array($query))
	{
		echo "document.write('<div class=\"ad_js\"><A HREF=\"$rs[adlink]\" target=_blank>$rs[adword]</A></div>');\r\n";
	}
} 
?>