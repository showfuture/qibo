<?php
function_exists('html') OR exit('ERR');

ck_power('refurbish');

//refurbish_info(true); 此方法要用到以下两个文件
require_once(Mpath."inc/function.php");
require_once(Mpath."inc/biz.php");

$fid=intval($fid);

if($job=="list")
{
	$SQL=" WHERE 1 ";
	$rows=25;
	if(!$page){
		$page=1;
	}
	$min=($page-1)*$rows;

	$showpage=getpage("{$_pre}refurbish A","$SQL","?","$rows");

	$query = $db->query("SELECT A.*,B.* FROM {$_pre}refurbish A LEFT JOIN {$_pre}db B ON A.id=B.id $SQL ORDER BY A.id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query))
	{
		if(!$rs[fid]){	//信息被删除后，这里也要相应的删除掉
			$db->query("DELETE FROM {$_pre}refurbish WHERE id='$rs[id]'");
			continue;
		}
		$times = $rs['times'];
		$_erp=$Fid_db[tableid][$rs[fid]];
		$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$rs[id]'");

		$rs['times'] = substr($times,0,2).':'.substr($times,2,2);
		
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);

 
		$rs[city]=$city_DB[name][$rs[city_id]];

		$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);

		$listdb[$rs[id]]=$rs;
	}
	//$sort_fid=$Guidedb->Select("{$_pre}sort","fid",$fid,"?job=list");
	get_admin_html('list');
}
elseif($action=="del")
{
	if(!$ids&&!$id){
		showerr("请选择一条信息");
	}

	if($id){
		$ids[] = $id;
	}
	foreach($ids AS $key=>$value){
		$db->query("DELETE FROM {$_pre}refurbish WHERE id='$value'");
		refurbish_info(true);
	}
	refreshto($FROMURL,"操作成功",1);
}

?>