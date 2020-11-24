<?php
!function_exists('html') && exit('ERR');
if($job=="list"&&$Apower[moneylog]){
	$rows=20;
	if($page<1){
		$page=1;
	}
	$min=($page-1)*$rows;
	$where = $uid?"WHERE A.uid='$uid'":"";
	$headhtml = $uid?"<span class=\"FL\">用户积分消费记录</span><span class='FR'><a href='?lfj=$lfj&job=list'>所有用户记录</a></span>":"<span class=\"FL\">用户积分消费记录</span>";
	$query = $db->query("SELECT A.*,B.username FROM {$pre}moneylog A LEFT JOIN {$pre}memberdata B ON A.uid=B.uid $where ORDER BY A.id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$rs[title] = get_word($rs[about],50);
		$listdb[] = $rs;
	}
	$showpage=getpage("{$pre}moneylog A","$where","?lfj=moneylog&job=list&uid=$uid",$rows);	//列表分页	
}elseif($job=="view"&&$Apower[moneylog]){
	$headhtml = "<span class=\"FL\">查看用户积分消费记录</span><span class='FR'><a href='?lfj=$lfj&job=list'>返回列表</a></span>";
	$rsdb=$db->get_one("SELECT A.*,B.username FROM {$pre}moneylog A LEFT JOIN {$pre}memberdata B ON A.uid=B.uid WHERE A.id=$id ");
	$rsdb[posttime]=date("Y-m-d H:i",$rsdb[posttime]);
}elseif($job=="del"&&$Apower[moneylog]){
	$db->query("DELETE FROM {$pre}moneylog WHERE id='$id'");
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&job=list&page=$page'>";
	exit;
}elseif($job=="delall"&&$Apower[moneylog]){
	foreach($listdb  AS $key=>$value){
		$db->query("DELETE FROM {$pre}moneylog WHERE id='$key'");
	}
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?lfj=$lfj&job=list'>";
	exit;
}
hack_admin_tpl('list');
?>