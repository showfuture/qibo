<?php
function_exists('html') OR exit('ERR');

ck_power('comment');
if($job=="list")
{
	!$page&&$page=1;
	$rows=20;
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}comments","","$admin_path&job=$job","$rows");
	$query=$db->query(" SELECT * FROM {$_pre}comments ORDER BY cid DESC LIMIT $min,$rows ");
	while($rs=$db->fetch_array($query)){
		$rs[content]=filtrate(get_word($rs[content],60));
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$rs[username]=$rs[username]?$rs[username]:$rs[ip];
		if($rs[yz]==1){
			$rs[yz]="<A HREF='$admin_path&action=list&jobs=unyz&ciddb[{$rs[cid]}]=$rs[cid]' style='color:blue;'>已审核</A>";
		}elseif($rs[yz]==0){
			$rs[yz]="<A HREF='$admin_path&action=list&jobs=yz&ciddb[{$rs[cid]}]=$rs[cid]' style='color:red;'>未审核</A>";
		}
		$listdb[]=$rs;
	}
	get_admin_html('list');
}
elseif($action=="list")
{
	if(!$ciddb){
		showmsg("请选择一条评论");
	}
	if($jobs=="delete")
	{
		foreach($ciddb AS $key=>$rs){
			$rs=$db->get_one("SELECT id FROM {$_pre}comments WHERE cid='$key' ");
			$db->query(" UPDATE {$_pre}content SET comments=comments-1 WHERE id='$rs[id]' ");
			$db->query("DELETE FROM {$_pre}comments WHERE cid='$key' ");
			$ck++;
		}
	}
	elseif($jobs=="yz"||$jobs=="unyz")
	{
		if($jobs=="yz"){
			$yz=1;
		}else{
			$yz=0;
		}
		foreach($ciddb AS $key=>$rs){
			$db->query(" UPDATE {$_pre}comments SET yz='$yz' WHERE cid='$key' ");
			$ck++;
		}
	}
	$retime=$ck==1?0:1;
	refreshto("$FROMURL","操作成功",$retime);
}
elseif($job=="show")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}comments WHERE cid='$cid' ");
	$rsdb[content]=str_replace("\r\n","<br>",$rsdb[content]);

	get_admin_html('show');
}