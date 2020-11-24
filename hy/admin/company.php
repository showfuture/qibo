<?php
function_exists('html') OR exit('ERR');

ck_power('company');
$linkdb=array(
			"全部店铺"=>"$admin_path&job=list",
			"已审核的店铺"=>"$admin_path&job=list&type=yz",
			"未审核的店铺"=>"$admin_path&job=list&type=unyz",
			"推荐信息"=>"$admin_path&job=list&type=levels",
			);

$fid=intval($fid);

if($job=="list")
{
	$SQL=" WHERE 1 ";
	if($fid>0){
		$SQL.=" AND fid=$fid ";
	}
	
	if($type=="yz"){
		$SQL.=" AND yz=1 ";
	}
	elseif($type=="unyz"){
		$SQL.=" AND yz=0 ";
	}
	elseif($type=="levels"){
		$SQL.=" AND levels=1 ";
	}
	elseif($type=="unlevels"){
		$SQL.=" AND levels=0 ";
	}
	elseif($type=="title"){
		$SQL.=" AND binary title LIKE '%$keyword%' ";
	}
	elseif($type=="uid"){
		$SQL.=" AND uid='$keyword' ";
	}
	elseif($type=="username"){
		@extract($db->get_one("SELECT uid FROM {$pre}memberdata WHERE username='$keyword' "));
		if(!$uid){
			showerr("用户不存在!");
		}
		$SQL.=" AND uid=$uid ";
	}

	$rows=30;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;
	$order="uid";
	$desc="DESC";
	$query=$db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}company $SQL ORDER BY $order $desc LIMIT $min,$rows");
	$RS=$db->get_one("SELECT FOUND_ROWS()");
	$showpage=getpage("","","$admin_path&job=list&fid=$fid&type=$type&keyword=".urlencode($keyword),$rows,$RS['FOUND_ROWS()']);
	while($rs=$db->fetch_array($query))
	{
		$ts = $db->get_one("SELECT grouptype FROM {$pre}memberdata WHERE uid='$rs[uid]'");
		if($rs[yz]&&!$ts[grouptype]){	//修复一下错误
			$db->query("UPDATE {$pre}memberdata SET grouptype=1 WHERE uid='$rs[uid]'");
		}
		if(!$rs[yz]){
			$rs[ischeck]="<A HREF='$admin_path&action=work&uid=$rs[uid]&jobs=yz' style='color:black;'>未审核</A>";
		}elseif( $rs[yz]==1){
			$rs[ischeck]="<A HREF='$admin_path&action=work&uid=$rs[uid]&jobs=unyz' style='color:blue;'>已审核</A>";
		}
		if(!$rs[levels]){
			$rs[iscom]="<A HREF='$admin_path&action=work&uid=$rs[uid]&jobs=com&levels=1' style=''>未推荐</A>";
		}else{
			$rs[iscom]="<A HREF='$admin_path&action=work&uid=$rs[uid]&jobs=com&levels=0' style='color:red;'>已推荐</A>";
		}
		$rs[title2]=urlencode($rs[title]);
		$rs[posttime]=date("m-d",$rs[posttime]);
		$rs[city]=$city_DB[name][$rs[city_id]];
		$listdb[$rs[uid]]=$rs;
	}
	get_admin_html('list');
}
elseif($action=='work')
{
	if($jobs=='com'){
		$SQL=$levels?",levelstime='$timestamp'":",levelstime=''";
		$db->query("UPDATE {$_pre}company SET levels='$levels'$SQL WHERE uid='$uid'");
	}elseif($jobs=='yz'){
		$db->query("UPDATE {$_pre}company SET yz='1' WHERE uid='$uid'");
	}elseif($jobs=='unyz'){
		$db->query("UPDATE {$_pre}company SET yz='0' WHERE uid='$uid'");
	}elseif($jobs=='del'){
		if($_pre=="{$pre}hy_"){
			delete_home($uid);
		}else{
			showmsg('出错了,复制后的模块不能使用函数delete_home!');
		}
	}
	refreshto("$FROMURL","",0);
}
elseif($action=='batch')
{
	if(!$udb){
		showmsg('请选择一项!');
	}
	foreach($udb AS $uid=>$title){
		if($_pre=="{$pre}hy_"){
			delete_home($uid);
		}else{
			showerr('出错了,复制后的模块不能使用函数delete_home!');
		}
	}
	jump("删除成功","$FROMURL",2);
}

?>