<?php

//各种动作
if($action=="msg_post"){ //留言

	//检测多少时间内不能重复留言
	$Omsg=$db->get_one("SELECT max(posttime) AS posttime  FROM {$_pre}guestbook` WHERE cuid='$uid' AND uid='$lfjuid' ");

	if(!check_imgnum($yzimg)){
		showerr("验证码不符合");
	}

	if($Omsg[posttime]){
		if( intval($Omsg[posttime]) + 60 > time() ){
			showerr("1分钟内不能再次留言");
		}
	}



	//
	if(!$content){
		showerr("内容不能为空");
	}
	if(strlen($content)>1000){
		showerr("内容不能超过500个字");
	}
	$content=filtrate($content);
	$yz=1;
	$db->query("INSERT INTO `{$_pre}guestbook` (`cuid`,  `uid` , `username` , `ip` , `content` , `yz` , `posttime` , `list` ) 
	VALUES (
	'$uid','$lfjuid','$lfjid','$onlineip','$content','$yz','".time()."','".time()."')
	");
	refreshto("?m=msg&uid=$uid&page=$page","谢谢你的留言",1);

}elseif($action=="msg_delete"){ //删除留言

	if($web_admin){
		$db->query("DELETE FROM `{$_pre}guestbook` WHERE id='$id'");
	}else{
		$db->query("DELETE FROM `{$_pre}guestbook` WHERE id='$id' AND (uid='$lfjuid' OR cuid='$lfjuid' )");
	}
	refreshto("?m=msg&uid=$uid&page=$page","删除成功",0);

}



//初始变量：
$tpl_left=array(
'base'=>"商家档案",
'tongji'=>"统计信息",
'l_news'=>"新闻动态",
'ck'=>"友情链接",
);

$tpl_right=array(
'info'=>"商家简介",
'contactus'=>"联系我们",
'msg'=>"留 言 本",
'dping'=>"顾客点评",
'visitor'=>"访客足迹",
'r_photo'=>"商家图片",
'r_news'=>"商家新闻",
//'r_coupon'=>"促销信息",
);



$webdb[company_upload_max]=5;	//批量可上传多少张图片

$webdb[homepage_banner_size]=$webdb[homepage_banner_size]?$webdb[homepage_banner_size]:80;
$webdb[homepage_ico_size]=$webdb[homepage_ico_size]?$webdb[homepage_ico_size]:50;
//$webdb[friendlinkmax]=$webdb[friendlinkmax]?$webdb[friendlinkmax]:20;

/***风格存放目录 *****/
$tpl_dir=Mpath."homepage_tpl/";






//激活商家主页
function caretehomepage($rsdb,$jump=true){
	global $db,$webdb,$_pre,$pre,$tpl_left,$tpl_right,$timestamp,$ltitle;

	if( $db->get_one("SELECT * FROM `{$_pre}home` WHERE uid='$rsdb[uid]'") ){
		showerr("你已经有商铺了!");
	}
	
	foreach($tpl_left AS $key=>$val){
		$index_left[]=$key;
	}
	$index_left=implode(",",$index_left);
	
	foreach($tpl_right AS $key=>$val){
		if(in_array($key,array('info'))){  //控制那些模块可以初始化
			$index_right[]=$key;
		}
	}
	$index_right=implode(",",$index_right);
	
	$listnum=array(
	'guestbook'=>4,'visitor'=>10,'newslist'=>10,
	'Mguestbook'=>10,'Mvisitor'=>40,'Mnewslist'=>10);
	$listnum=addslashes(serialize($listnum));

	$menu=require(Mpath."inc/homepage/menu.php");
	$menu=addslashes(serialize($menu));

	$db->query("INSERT INTO `{$_pre}home` (  `uid` , `username` , `style` , `index_left` , `index_right` ,`listnum`,`banner`, `bodytpl`, `head_menu` ) VALUES ( '$rsdb[uid]', '$rsdb[username]', 'default', '$index_left', '$index_right','$listnum','','left', '$menu');");
	

	//初始化图库
	$db->query("INSERT INTO `{$_pre}picsort` ( `psid` , `psup` , `name` , `remarks` , `uid` , `username` , `level` , `posttime` , `orderlist` ) VALUES 
	('', '0', '产品图库', '记录产品多方面图片资料', '$rsdb[uid]', '$rsdb[username]',  '0', '$timestamp', '2'),
	('', '0', '资质说明', '荣誉证书，获奖证书，营业执照', '$rsdb[uid]', '$rsdb[username]', '0', '$timestamp', '1');   
	");

	$db->query("UPDATE {$_pre}company SET if_homepage=1 WHERE uid='$rsdb[uid]' ");

	if($jump){
		//跳转
		$url="?uid=$rsdb[uid]";
		echo "商家页面激活成功....<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>";
		exit;
	}
}




//类目录列表
function choose_sort($fid,$class,$ck=0,$ctype)
{
	global $db,$_pre;
	for($i=0;$i<$class;$i++){
		$icon.="&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	$class++;          //AND type=1
	$query = $db->query("SELECT * FROM {$_pre}sort WHERE fup='$fid'   ORDER BY list DESC LIMIT 500");
	while($rs = $db->fetch_array($query)){
		$ckk=$ck==$rs[fid]?' selected ':'';
		$fup_select.="<option value='$rs[fid]' $ckk >$icon|-$rs[name]</option>";
		$fup_select.=choose_sort($rs[fid],$class,$ck,$ctype);
	}
	return $fup_select;
}


?>