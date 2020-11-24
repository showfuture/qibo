<?php
function_exists('html') OR exit('ERR');

ck_power('renzheng');
$linkdb=array(
			"全部企业"=>"$admin_path&job=list",
			"未认证的企业"=>"$admin_path&job=list&renzheng=0",
			"普通认证的企业"=>"$admin_path&job=list&renzheng=1",
			"银牌认证的企业"=>"$admin_path&job=list&renzheng=2",
			"金牌认证的企业"=>"$admin_path&job=list&renzheng=3",
			);

$renzhengdb=array(
	0=>'<font color="#cccccc">未认证</font>',
	1=>'<font color="#0000FF">普通认证</font>',
	2=>'<font color="#FF00FF">银牌认证</font>',
	3=>'<font color="#FF0000">金牌认证</font>',
);

$fid=intval($fid);

if($job=="list")
{
	$SQL=" WHERE 1 ";
	
	if( is_numeric($renzheng) ){
		$SQL.=" AND renzheng='$renzheng' ";
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
	$showpage=getpage("","","$admin_path&job=list&renzheng=$renzheng&fid=$fid&type=$type&keyword=".urlencode($keyword),$rows,$RS['FOUND_ROWS()']);
	while($rs=$db->fetch_array($query))
	{
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
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$rs[city]=$city_DB[name][$rs[city_id]];
		$listdb[$rs[uid]]=$rs;
	}
	get_admin_html('list');
}
elseif($job=='rz')
{
	$db->query("UPDATE {$_pre}company SET renzheng='$renzheng' WHERE uid='$uid'");
	refreshto("$FROMURL","",0);
}
elseif($job=='view')
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid'");
	$rsdb[permit_pic] && $rsdb[permit_pic] = tempdir($rsdb[permit_pic]);
	$rsdb[guo_tax_pic] && $rsdb[guo_tax_pic] = tempdir($rsdb[guo_tax_pic]);
	$rsdb[di_tax_pic] && $rsdb[di_tax_pic] = tempdir($rsdb[di_tax_pic]);
	$rsdb[organization_pic] && $rsdb[organization_pic] = tempdir($rsdb[organization_pic]);
	$rsdb[idcard_pic] && $rsdb[idcard_pic] = tempdir($rsdb[idcard_pic]);

	get_admin_html('view');

}
?>