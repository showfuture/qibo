<?php
function_exists('html') OR exit('ERR');
ck_power('comment');
if($job=="list")
{
	$rows = 30;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;
	$query = $db->query("SELECT SQL_CALC_FOUND_ROWS A.*,M.title FROM {$_pre}guestbook A LEFT JOIN {$_pre}company M ON A.cuid=M.uid  ORDER BY A.posttime desc LIMIT $min,$rows");
	$RS=$db->get_one("SELECT FOUND_ROWS()");
	$totalNum=$RS['FOUND_ROWS()'];
	while($rs = $db->fetch_array($query)){
		$rs[posttime]=date("y/m/d H:i:s",$rs[posttime]);
		$detail=explode(".",$rs[ip]);
		$rs[ip]="$detail[0].$detail[1].$detail[2].*";
		if(!$rs[username]){
			$detail=explode(".",$rs[ip]);
			$rs[username]="$detail[0].$detail[1].*.*";
		}
		$rs[content]=str_replace("\n","<br>",$rs[content]);
		$listdb[]=$rs;
	}
	$showpage=getpage("","","$admin_path&job=list",$rows,$totalNum);
	get_admin_html('list');
}
if($job == "see"){
	$rs = $db->get_one("SELECT A.*,M.title FROM {$_pre}guestbook A LEFT JOIN {$_pre}company M ON A.cuid=M.uid WHERE A.id='$id'");
	$rs[posttime]=date("y/m/d H:i:s",$rs[posttime]);
	$detail=explode(".",$rs[ip]);
	$rs[ip]="$detail[0].$detail[1].$detail[2].*";
	if(!$rs[username]){
		$detail=explode(".",$rs[ip]);
		$rs[username]="$detail[0].$detail[1].*.*";
	}
	get_admin_html('list');
}
if($job=="del"){
	foreach($listdb  AS $key=>$value){
		$db->query("DELETE FROM `{$_pre}guestbook` WHERE `id` = '$key'");
	}
	refreshto("$FROMURL","",0);
}
?>