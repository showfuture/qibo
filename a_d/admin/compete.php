<?php
!function_exists('html') && exit('ERR');

//列出所有广告
if($job=="listad"&&ck_power('compete_listad')){
	$query = $db->query("SELECT * FROM `{$pre}ad_compete_place` ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$_s1=$db->get_one("SELECT COUNT(*) AS Num FROM `{$pre}ad_compete_user` WHERE id='$rs[id]'");
		$rs[AllAdNum]=$_s1[Num];
		$_s2=$db->get_one("SELECT COUNT(*) AS Num FROM `{$pre}ad_compete_user` WHERE id='$rs[id]' AND endtime>$timestamp");
		$rs[AdNum]=$_s2[Num];
		$rs[isclose]=$rs[isclose]?'关闭':'开放';
		$listdb[]=$rs;
	}
	get_admin_html('listad');
}

//添加广告
elseif($job=="addplace"&&ck_power('compete_listad'))
{
	get_admin_html('addplace');
}

//修改广告
elseif($job=="editadplace"&&ck_power('compete_listad'))
{
	$rsdb=$db->get_one("SELECT * FROM `{$pre}ad_compete_place` WHERE id='$id'");
	$isclose[intval($rsdb[isclose])]=" checked ";
	get_admin_html('addplace');
}

//处理修改广告
elseif($action=="editadplace"&&ck_power('compete_listad'))
{
	if($postdb[day]<1){
		showmsg("有效投放天数不能小于1天");
	}
	if($postdb[price]<1){
		showmsg("最低起价不能小于1");
	}
	$db->query("UPDATE `{$pre}ad_compete_place` SET name='$postdb[name]',price='$postdb[price]',day='$postdb[day]',isclose='$isclose',adnum='$postdb[adnum]',wordnum='$postdb[wordnum]',list='$postdb[list]',demourl='$postdb[demourl]' WHERE id='$id' ");
	
	jump("修改成功","$admin_path&job=listad",1);
}

//处理添加广告
elseif($action=="addplace"&&ck_power('compete_listad'))
{

	if(!$IS_BIZPhp168){
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$pre}ad_compete_place"));
		if($NUM>19){
			showerr("免费版最多只能创建20个");
		}
	}

	if($postdb[day]<1){
		showmsg("有效投放天数不能小于1天");
	}
	if($postdb[price]<1){
		showmsg("最低起价不能小于1");
	}
	$db->query("INSERT INTO `{$pre}ad_compete_place` (`name` , `price` , `day`, `adnum`, `wordnum`, `demourl`) VALUES ('$postdb[name]','$postdb[price]','$postdb[day]','$postdb[adnum]','$postdb[wordnum]','$postdb[demourl]')");	
				
	jump("添加成功","$admin_path&job=listad",1);
}

//删除广告
elseif($action=='deleteadplace'&&ck_power('compete_listad'))
{
	$db->query("DELETE FROM `{$pre}ad_compete_place` WHERE id='$id'");
	$db->query("DELETE FROM `{$pre}ad_compete_user` WHERE id='$id'");
	jump("删除成功","$FROMURL",1);
}

elseif($job=="listuser"&&ck_power('compete_listuser'))
{
	if($page<1){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	if($id){
		$SQL=" WHERE A.id='$id' ";
	}
	$showpage=getpage("`{$pre}ad_compete_user` A","$SQL","?job=$job",$rows);
	$query = $db->query("SELECT A.*,B.* FROM `{$pre}ad_compete_user` A LEFT JOIN `{$pre}ad_compete_place` B ON A.id=B.id $SQL ORDER BY A.endtime DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[begintime]=date("Y-m-d H:i",$rs[begintime]);
		$rs[endtime]=date("Y-m-d H:i",$rs[endtime]);
		$listdb[]=$rs;
	}

	get_admin_html('listuser');
}

elseif($action=="deleteusr"&&ck_power('compete_listuser'))
{
	$db->query("DELETE FROM `{$pre}ad_compete_user` WHERE ad_id='$ad_id'");
	jump("删除成功","$FROMURL",1);
}

?>