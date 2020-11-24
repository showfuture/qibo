<?php
if(!function_exists('html')){
	die('F');
}

if(!$uid){
	showerr("请选择一个用户");
}
//include_once(ROOT_PATH."data/level.php");

$rows=20;
if(!$page){
	$page=1;
}
$min=($page-1)*$rows;
$showpage=getpage("{$_pre}db","WHERE uid='$uid'","?job=$job&uid=$uid",$rows);

$listdb = user_info($uid,$rows,$min);

$rsdb=$db->get_one("SELECT * FROM {$pre}memberdata WHERE uid='$uid' ");

if($rsdb[sex]==1)
{
	$rsdb[sex]="男";
}
elseif($rsdb[sex]==2)
{
	$rsdb[sex]="女";
}
else
{
	$rsdb[sex]="保密";
}
$rsdb[regdate]=date("Y-m-d H:i:s",$rsdb[regdate]);
$rsdb[lastvist]=date("Y-m-d H:i:s",$rsdb[lastvist]);
$rsdb[money]=get_money($uid);

require(Mpath."inc/head.php");
require(html("userinfo"));
require(Mpath."inc/foot.php");

?>