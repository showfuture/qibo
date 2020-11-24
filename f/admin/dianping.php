<?php
function_exists('html') OR exit('ERR');

ck_power('dianping');

if($job=="list")
{
	!$page&&$page=1;
	$rows=20;
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}dianping","","$admin_path&job=$job","$rows");
	$query=$db->query(" SELECT * FROM {$_pre}dianping ORDER BY cid DESC LIMIT $min,$rows ");
	while($rs=$db->fetch_array($query)){
		$rs[content]=preg_replace("/<([^<]+)>/is","",$rs[content]);
		$rs[content]=get_word($rs[content],80);
		$rs[posttime]=date("m-d",$rs[posttime]);
		$rs[username]=$rs[username]?$rs[username]:$rs[ip];
		$rs[ifgood]=$rs[type]==1?'<font color=red>精华</font>':'普通';
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
		showerr("请选择一条评论");
	}
	if($jobs=="delete")
	{
		foreach($ciddb AS $key=>$rs){
			$rs=$db->get_one("SELECT fid,id FROM {$_pre}dianping WHERE cid='$key' ");
			$_erp=$Fid_db[tableid][$rs[fid]];
			$db->query(" UPDATE {$_pre}content$_erp SET comments=comments-1 WHERE id='$rs[id]' ");
			$db->query("DELETE FROM {$_pre}dianping WHERE cid='$key' ");
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
			$db->query(" UPDATE {$_pre}dianping SET yz='$yz' WHERE cid='$key' ");
			$ck++;
		}
	}
	elseif($jobs=="good"||$jobs=="ungood")
	{
		foreach($ciddb AS $key=>$rs){
			$rs=$db->get_one("SELECT * FROM {$_pre}dianping WHERE cid='$key'");
			if($jobs=="good"&&$rs[type]!=1){
				$db->query(" UPDATE {$_pre}dianping SET type='1' WHERE cid='$key' ");
				add_user($rs[uid],abs($webdb[GoodCommentMoney]));
			}elseif($jobs=="ungood"&&$rs[type]==1){
				$db->query(" UPDATE {$_pre}dianping SET type='0' WHERE cid='$key' ");
				add_user($rs[uid],-abs($webdb[GoodCommentMoney]));
			}			
			$ck++;
		}
	}
	$retime=$ck==1?0:1;
	refreshto("$FROMURL","操作成功",$retime);
}
elseif($job=="show")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}dianping WHERE cid='$cid' ");
	$rsdb[content]=str_replace("\r\n","<br>",$rsdb[content]);

	get_admin_html('show');
}