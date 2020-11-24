<?php
if(!function_exists('html')){
die('F');
}
if(!$lfjid){
	showerr("请先登录");
}elseif(!$id){
	showerr("ID不存在");
}
if($db->get_one("SELECT * FROM `{$_pre}collection` WHERE `id`='$id' AND uid='$lfjuid'")){
	showerr("请不要重复收藏本条信息",1); 
}
if(!$web_admin){
	if($webdb[Info_CollectArticleNum]<1){
		$webdb[Info_CollectArticleNum]=50;
	}
	$rs=$db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}collection` WHERE uid='$lfjuid'");
	if($rs[NUM]>=$webdb[Info_CollectArticleNum]){
		showerr("你最多只能收藏{$webdb[Info_CollectArticleNum]}条信息",1);
	}
}
$db->query("INSERT INTO `{$_pre}collection` (  `id` , `uid` , `posttime`) VALUES ('$id','$lfjuid','$timestamp')");

refreshto("$webdb[www_url]/member/?main=$Mdomain/member/collection.php","收藏成功!",1);
?>