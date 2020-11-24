<?php
require(dirname(__FILE__)."/global.php");
require(dirname(__FILE__)."/../inc/homepage/global.php");
require_once(dirname(__FILE__)."/../bd_pics.php");

$atn=$atn?$atn:"info";

if(!$lfjuid){
	showerr("请先登录");
}elseif(!$uid){
	$uid=$lfjuid;
}

$linkdb=array("商铺预览"=>"$webdb[www_url]/home/?uid=$uid");
$link_blank=array("商铺预览"=>"_blank");




$companydb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid' LIMIT 1");

if($companydb[yz]!=1 && $webdb['ForbidDoHy'] && !$web_admin){
	showerr("你的企业信息还没通过审核,无权操作");
}

$rs=$db->get_one("SELECT admin FROM {$pre}fenlei_city WHERE fid='$companydb[city_id]'");
$detail=explode(',',$rs[admin]);
if($lfjid && in_array($lfjid,$detail)){
	$web_admin=1;
}

if(!$companydb[if_homepage]){
	showerr("您还没有申请企业商铺,<a href='$Murl/member/post_company.php?action=apply'>点击这里申请企业商铺</a>，拥有自己的商铺");
}elseif($companydb[uid]!=$lfjuid&&!$web_admin){
	showerr("你没权限!");
}
$companydb[logo]=tempdir($companydb[picurl]);

//主页配置文件
$homepage=$db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid' LIMIT 1");

if(!$homepage){
	caretehomepage($companydb,false);
}

if($atn&&eregi("^([_a-z0-9]+)$",$atn)&&is_file(dirname(__FILE__)."/homepage_ctrl/$atn.php")){
	require_once(dirname(__FILE__)."/homepage_ctrl/$atn.php");
}

require(dirname(__FILE__)."/"."head.php");
require(dirname(__FILE__)."/"."template/homepage_ctrl.htm");
require(dirname(__FILE__)."/"."foot.php");



?>