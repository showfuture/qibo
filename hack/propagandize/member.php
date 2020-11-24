<?php
!function_exists('html') && exit('ERR');

if(!$lfjid){
	showerr("你还没登录");
}

if($webdb[propagandize_close]){
	showerr("系统没有开放此功能");
}

if(!table_field("{$pre}propagandize","newuid")){
	$db->query("ALTER TABLE  `{$pre}propagandize` ADD  `newuid` MEDIUMINT( 7 ) NOT NULL AFTER  `id`");
	$db->query("ALTER TABLE  `{$pre}propagandize` ADD INDEX (  `newuid` )");
}

if($job=='more'){
	List_propagandize_reg($uid);
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/member/more.htm");
	require(ROOT_PATH."member/foot.php");
	exit;
}

$rows=20;
if(!$page){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("`{$pre}propagandize`","WHERE uid='$lfjuid'","?hack=$hack");
$query = $db->query("SELECT A.*,B.username FROM `{$pre}propagandize` A LEFT JOIN {$pre}memberdata B ON A.newuid=B.uid WHERE A.uid='$lfjuid' ORDER BY A.id DESC LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[ip]=long2ip($rs[ip]);
	$rs[ipfrom]=ipfrom($rs[ipfrom]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$rs[more] = ($rs[newuid]&&$db->get_one("SELECT * FROM `{$pre}propagandize` WHERE uid='$rs[newuid]'"))?"<A HREF='?hack=$hack&job=more&uid=$rs[newuid]'>MORE</A>":"";
	$listdb[]=$rs;
}

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/template/member/propagandize.htm");
require(ROOT_PATH."member/foot.php");


function List_propagandize_reg($uid){
	global $db,$pre,$listdb;
	$query = $db->query("SELECT A.*,B.username FROM {$pre}propagandize A LEFT JOIN {$pre}memberdata B ON A.newuid=B.uid WHERE A.uid='$uid'");
	while($rs = $db->fetch_array($query)){
		$rs[ip]=long2ip($rs[ip]);
		$rs[ipfrom]=ipfrom($rs[ipfrom]);
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$listdb[]=$rs;
		if($rs[newuid]){
			List_propagandize_reg($rs[newuid]);
		}
	}
}

?>