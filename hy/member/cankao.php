<?php
require(dirname(__FILE__)."/"."global.php");

if(!$uid){
	$uid=$lfjuid;
}
if(!$web_admin&&$uid!=$lfjuid){
	showerr('你没权限!');
}

$companydb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid' LIMIT 1");

if(!$companydb[if_homepage]){
	showerr("您还没有申请企业商铺,<a href='post_company.php'>点击这里申请企业商铺</a>，拥有自己的商铺");
}
if($companydb[yz]!=1 && $webdb['ForbidDoHy'] && !$web_admin){
	showerr("你的企业信息还没通过审核,无权操作");
}


//$webdb[vip_par_payfor]=$webdb[vip_par_payfor]?$webdb[vip_par_payfor]:50;
//$webdb[vip_min_long]=$webdb[vip_min_long]?$webdb[vip_min_long]:1;


if(!$action){
	$page=intval($page);
	$page=$page>1?$page:1;
	$rows=10;
	$min=($page-1)*$rows;
	$query=$db->query("SELECT * FROM {$_pre}friendlink WHERE uid='$uid' LIMIT $min,$rows");
	$showpage=getpage("{$_pre}friendlink","WHERE uid='$uid'","?",$rows);
	while($rs=$db->fetch_array($query)){

		$rs[yz]=(!$rs[yz])?"未审核":"<font color=red>已审核</font>";
		$listdb[]=$rs;
	}

}elseif($action=='add'){
	if($ck_id){
		$rsdb=$db->get_one("SELECT * FROM {$_pre}friendlink WHERE ck_id='$ck_id' LIMIT 1");
	}

}elseif($action=='save_add'){	

	if(!$title || strlen($title)>40) showerr("标题不能为空，且只能是40个字符");
	if(!$url || strtolower(substr($url,0,4)!='http')) showerr("地址不能为空，且必须以http开头");
	if(strlen($description)>400)showerr("描述最多400个字符");

	$title = filtrate($title);
	$url = filtrate($url);
	$description = filtrate($description);

	if($ck_id){
		$db->query("UPDATE `{$_pre}friendlink` SET
		title='$title',
		url='$url',
		description='$description',
		yz=1
		WHERE ck_id='$ck_id';");
	}else{
		$db->query("INSERT INTO `{$_pre}friendlink` ( `ck_id` , `uid` , `username` ,  `companyName` , `title` , `url` , `description` , `yz` ) VALUES ('', '$lfjuid', '$lfjid', '$companydb[title]', '$title', '$url', '$description', '1')");
	}
	refreshto("?","保存成功",1);

}elseif($action=='del'){	
	
	if($ck_id){
		$db->query("DELETE FROM {$_pre}friendlink WHERE ck_id='$ck_id' AND `uid`='$uid'");
	}
	refreshto("?","操作成功",1);
}

require(ROOT_PATH."member/head.php");
require(dirname(__FILE__)."/"."template/cankao.htm");
require(ROOT_PATH."member/foot.php");

?>