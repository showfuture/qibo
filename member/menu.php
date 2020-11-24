<?php
!function_exists('html') && exit('ERR');

unset($menudb,$base_menudb);
//$base_menudb['修改个人资料']['link']='userinfo.php?job=edit';

//$base_menudb['<font color=red>版主管理.稿件</font>']['link']='list.php';
//$base_menudb['<font color=red>版主管理.稿件</font>']['power']='2';

//$base_menudb['<font color=red>版主管理.评论</font>']['link']='comment.php?job=work';
//$base_menudb['<font color=red>版主管理.评论</font>']['power']='2';

$menudb['基本功能']['修改个人资料']['link']='userinfo.php?job=edit';
$menudb['基本功能']['站内短消息']['link']='pm.php?job=list';
$menudb['基本功能']['积分充值']['link']='money.php?job=list';
$menudb['基本功能']['购买会员等级']['link']='buygroup.php?job=list';
//$menudb['基本功能']['企业信息']['link']='company.php?job=edit';
$menudb['基本功能']['身份验证']['link']='yz.php?job=email';
$menudb['基本功能']['积分消费记录']['link']='moneylog.php?job=list';
$menudb['基本功能']['购买空间']['link']='buyspace.php';

 


//插件菜单
$query = $db->query("SELECT * FROM {$pre}hack ORDER BY list DESC");
while($rs = $db->fetch_array($query)){
	if(is_file(ROOT_PATH."hack/$rs[keywords]/member_menu.php")){
		$array = include(ROOT_PATH."hack/$rs[keywords]/member_menu.php");
		$menudb['插件功能']["$array[name]"]['link']=$array['url'];
	}
}

?>