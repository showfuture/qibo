<?php
function_exists('html') OR exit('ERR');

ck_power('companypic');

$linkdb=array(
			"全部图片"=>"$admin_path&job=list",
			"已审核的图片"=>"$admin_path&job=list&type=yz",
			"未审核的图片"=>"$admin_path&job=list&type=unyz",
			"推荐图片"=>"$admin_path&job=list&type=level",
			);
if($job=="list"){
	$SQL=" WHERE 1 ";
	if($type=="yz"){
		$SQL.=" AND yz=1 ";
	}
	elseif($type=="unyz"){
		$SQL.=" AND yz=0 ";
	}
	elseif($type=="level"){
		$SQL.=" AND level=1 ";
	}
	elseif($type=="unlevel"){
		$SQL.=" AND level=0 ";
	}
	elseif($type=="title"){
		$SQL.=" AND title LIKE '%$keyword%' ";
	}
	elseif($type=="pid"){
		$SQL.=" AND pid='$keyword' ";
	}
	elseif($type=="username"){
		@extract($db->get_one("SELECT uid FROM {$pre}memberdata WHERE username='$keyword' "));
		if(!$uid){
			showerr("用户不存在!");
		}
		$SQL.=" AND uid=$uid ";
	}
	$rows=10;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;
	$order="pid";
	$desc="DESC";
	$query=$db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}pic $SQL ORDER BY $order $desc LIMIT $min,$rows");
	$RS=$db->get_one("SELECT FOUND_ROWS()");	$showpage=getpage("","","$admin_path&job=list&type=$type&keyword=".urlencode($keyword),$rows,$RS['FOUND_ROWS()']);
	while($rs=$db->fetch_array($query)){
		@extract($db->get_one("SELECT title FROM {$_pre}company where uid='$rs[uid]'"));
		$rs[company] = $title;
		if(!$rs[yz]){
			$rs[ischeck]="<A HREF='$admin_path&action=work&pid=$rs[pid]&jobs=yz'>未审核</A>";
		}elseif( $rs[yz]==1){
			$rs[ischeck]="<A HREF='$admin_path&action=work&pid=$rs[pid]&jobs=unyz' style='color:red;'>已审核</A>";
		}
		if(!$rs[level]){
			$rs[iscom]="<A HREF='$admin_path&action=work&pid=$rs[pid]&jobs=com&level=1'>未推荐</A>";
		}else{
			$rs[iscom]="<A HREF='$admin_path&action=work&pid=$rs[pid]&jobs=com&levels=0' style='color:red;'>已推荐</A>";
		}
		$rs[title2]=urlencode($rs[title]);
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$listdb[]=$rs;
	}
	get_admin_html('list');
}
elseif($action=='work'){
	if($jobs=='com'){
		$db->query("UPDATE {$_pre}pic SET level='$level' WHERE pid='$pid'");
	}elseif($jobs=='yz'){
		$db->query("UPDATE {$_pre}pic SET yz='1' WHERE pid='$pid'");
	}elseif($jobs=='unyz'){
		$db->query("UPDATE {$_pre}pic SET yz='0' WHERE pid='$pid'");
	}elseif($jobs=='del'){
		@extract($db->get_one("SELECT url FROM {$_pre}pic where pid='$pid'"));
		@unlink(ROOT_PATH."$webdb[updir]/$url");
		@unlink(ROOT_PATH."$webdb[updir]/$url.gif");
		$db->query("DELETE FROM `{$_pre}pic` WHERE `pid` = '$pid'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "del"){
	foreach($listdb  AS $key=>$value){		
		@extract($db->get_one("SELECT url FROM {$_pre}pic where pid='$key'"));
		@unlink(ROOT_PATH."$webdb[updir]/$url");
		@unlink(ROOT_PATH."$webdb[updir]/$url.gif");
		$db->query("DELETE FROM `{$_pre}pic` WHERE `pid` = '$key'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "com"){
	foreach($listdb  AS $key=>$value){		
		$db->query("UPDATE {$_pre}pic SET level='1' WHERE pid='$key'");
	}
	refreshto("$FROMURL","",0);
}
elseif($jobs == "yz"){
	foreach($listdb  AS $key=>$value){		
		$db->query("UPDATE {$_pre}pic SET yz='1' WHERE pid='$key'");
	}
	refreshto("$FROMURL","",0);
}
?>