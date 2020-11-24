<?php
!function_exists('html') && exit('ERR');
if($action=="del"&&$Apower[propagandize])
{
	foreach( $idDB AS $key=>$value){
		$db->query("DELETE FROM `{$pre}propagandize` WHERE id='$value'");
	}
	jump("删除成功","$FROMURL",1);
}
elseif($job=="list"&&$Apower[propagandize])
{
	$rows=20;
	if(!$page){
		$page=1;
	}
	$min=($page-1)*$rows;
	$showpage=getpage("`{$pre}propagandize`"," ","?lfj=$lfj&job=$job",$rows);
	$query = $db->query("SELECT P.*,D.username FROM `{$pre}propagandize` P LEFT JOIN {$pre}memberdata D ON P.uid=D.uid ORDER BY P.id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[ip]=long2ip($rs[ip]);
		$rs[ipfrom]=ipfrom($rs[ipfrom]);
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
	}

	hack_admin_tpl('list');
}
elseif($action=="set"&&$Apower[propagandize])
{
	write_config_cache($webdbs);
	jump("修改成功",$FROMURL);
}
elseif($job=="set"&&$Apower[propagandize])
{
	$propagandize_close[intval($webdb[propagandize_close])]=' checked ';

	hack_admin_tpl('set');
}
?>