<?php
function_exists('html') OR exit('ERR');

ck_power('companynews');

$linkdb=array(
			"全部新闻"=>"$admin_path&job=list",
			"已审核的新闻"=>"$admin_path&job=list&type=yz",
			"未审核的新闻"=>"$admin_path&job=list&type=unyz",
			"推荐新闻"=>"$admin_path&job=list&type=levels",
			);
if($job=="list"){
	$SQL=" WHERE 1 ";
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
		$SQL.=" AND title LIKE '%$keyword%' ";
	}
	elseif($type=="id"){
		$SQL.=" AND id='$keyword' ";
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
	$order="id";
	$desc="DESC";
	$query=$db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}news $SQL ORDER BY $order $desc LIMIT $min,$rows");
	$RS=$db->get_one("SELECT FOUND_ROWS()");	$showpage=getpage("","","$admin_path&job=list&type=$type&keyword=".urlencode($keyword),$rows,$RS['FOUND_ROWS()']);
	while($rs=$db->fetch_array($query)){
		@extract($db->get_one("SELECT title FROM {$_pre}company where uid='$rs[uid]'"));
		$rs[company] = $title;
		if(!$rs[yz]){
			$rs[ischeck]="<A HREF='$admin_path&action=work&id=$rs[id]&jobs=yz'>未审核</A>";
		}elseif( $rs[yz]==1){
			$rs[ischeck]="<A HREF='$admin_path&action=work&id=$rs[id]&jobs=unyz' style='color:red;'>已审核</A>";
		}
		if(!$rs[levels]){
			$rs[iscom]="<A HREF='$admin_path&action=work&id=$rs[id]&jobs=com&levels=1'>未推荐</A>";
		}else{
			$rs[iscom]="<A HREF='$admin_path&action=work&id=$rs[id]&jobs=com&levels=0' style='color:red;'>已推荐</A>";
		}
		$rs[title2]=urlencode($rs[title]);
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$listdb[]=$rs;
	}
	get_admin_html('list');
}
elseif($action=='work'){
	if($jobs=='com'){
		$db->query("UPDATE {$_pre}news SET levels='$levels' WHERE id='$id'");
	}elseif($jobs=='yz'){
		$db->query("UPDATE {$_pre}news SET yz='1' WHERE id='$id'");
	}elseif($jobs=='unyz'){
		$db->query("UPDATE {$_pre}news SET yz='0' WHERE id='$id'");
	}elseif($jobs=='del'){
		$db->query("DELETE FROM `{$_pre}news` WHERE `id` = '$id'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "del"){
	foreach($listdb  AS $key=>$value){		
		$db->query("DELETE FROM `{$_pre}news` WHERE `id` = '$key'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "com"){
	foreach($listdb  AS $key=>$value){		
		$db->query("UPDATE {$_pre}news SET levels='1' WHERE id='$key'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "yz"){
	foreach($listdb  AS $key=>$value){		
		$db->query("UPDATE {$_pre}news SET yz='1' WHERE id='$key'");
	}
	refreshto("$FROMURL","",0);
}
?>