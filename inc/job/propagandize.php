<?php
!function_exists('html') && exit('ERR');
if(!$webdb[propagandize_close]&&$db->get_one("SELECT * FROM {$pre}memberdata WHERE uid='$uid'")){
	$webdb['propagandize_LogDay'] || $webdb['propagandize_LogDay']=1;
	$today = date("z",$timestamp);
	$daytime = $today-$webdb['propagandize_LogDay'];
	$ip=sprintf("%u",ip2long($onlineip));
	$mydomain = str_replace('www.','',preg_replace("/http:\/\/(.*)/is","\\1",$webdb[www_url]));
	$fromurl = $fromurl ? $fromurl : $FROMURL ;
	if(!strstr($fromurl,$mydomain)&&$uid!=$lfjuid&&!$db->get_one("SELECT * FROM {$pre}propagandize WHERE day>'$daytime' AND ip='$ip'")){
		$fromurl=filtrate($FROMURL);
		$db->query("INSERT INTO `{$pre}propagandize` ( `uid` , `ip` , `day` , `posttime` , `fromurl` ) VALUES ( '$uid', '$ip', '$today', '$timestamp', '$fromurl')");
		$id = $db->insert_id();
		add_user($uid,$webdb[propagandize_Money],'Ðû´«ÍÆ¹ã½±Àø');
		set_cookie('propagandize_id',$id,$webdb['propagandize_LogDay']*3600*24);

		if(!table_field("{$pre}propagandize","newuid")){
			$db->query("ALTER TABLE  `{$pre}propagandize` ADD  `newuid` MEDIUMINT( 7 ) NOT NULL AFTER  `id`");
			$db->query("ALTER TABLE  `{$pre}propagandize` ADD INDEX (  `newuid` )");
		}
	}
}
$gotourl = $gotourl ? $gotourl : $webdb['propagandize_jumpto'];
header("location:$gotourl");

?>