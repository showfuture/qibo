<?php
require(dirname(__FILE__)."/"."global.php");

if(!$uid){
	$uid=$lfjuid;
}
if(!$web_admin&&$uid!=$lfjuid){
	showerr('你没权限!');
}

$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid'");
if(!$rsdb[if_homepage]){
	showerr("您还没有申请企业商铺,<a href='$Murl/member/post_company.php'>点击这里申请企业商铺</a>，拥有自己的商铺");
}
if($rsdb[yz]!=1 && $webdb['ForbidDoHy'] && !$web_admin){
	showerr("当前商家还没通过审核,无法显示");
}


if($action=='save'){
	
	if(!$web_admin&&$rsdb[renzheng]){
		showerr('认证之后,不可以再修改');

	}
	foreach($postdb AS $key=>$value){
		$postdb[$key] = filtrate($value);
	}
	
	$db->query("UPDATE {$_pre}company SET permit_pic='$postdb[permit_pic]',guo_tax_pic='$postdb[guo_tax_pic]',di_tax_pic='$postdb[di_tax_pic]',organization_pic='$postdb[organization_pic]',idcard_pic='$postdb[idcard_pic]' WHERE uid='$uid'");
	refreshto($FROMURL,"提交成功,请等待管理员审核,在未审核前可以再进行修改!");
}


require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/renzheng.htm");
require(ROOT_PATH."member/foot.php");

?>