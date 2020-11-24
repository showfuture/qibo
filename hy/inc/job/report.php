<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjuid){
	showerr("游客不能举报,请先登录");
}
if($step==2)
{
	$rs=$db->get_one("SELECT * FROM {$_pre}report WHERE uid='$lfjuid' ORDER BY rid DESC LIMIT 1");
	if( ($timestamp-$rs[posttime])<60 ){
		showerr("1分钟内,请不要重复举报");
	}
	if(strlen($content)>300){
		showerr("附注信息不能大于150个汉字");
	}
	$content=filtrate($content);
	$db->query("INSERT INTO `{$_pre}report` (`id`, `fid`, `uid`, `username`, `posttime`, `onlineip`, `type`,`content`) VALUES ('$id','$fid','$lfjuid','$lfjid','$timestamp','$onlineip','$type','$content')");
	if(!$city_id){
		@extract($db->get_one("SELECT city_id FROM {$_pre}db WHERE id='$id'"));
	}
	$rs[url]=get_info_url($id,$fid,$city_id);
	refreshto("$rs[url]","举报成功",1);
}
@include(Mpath."data/guide_fid.php");

$typedb[1]=' checked ';

$report_type=explode("\r\n","\r\n".$webdb[Info_ReportDB]);
unset($report_type[0]);

require(Mpath."inc/head.php");
require(getTpl("report"));
require(Mpath."inc/foot.php");
?>