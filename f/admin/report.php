<?php
function_exists('html') OR exit('ERR');

ck_power('report');

$report_type=explode("\r\n","\r\n".$webdb[Info_ReportDB]);
unset($report_type[0]);
if($job=='list')
{
	$rows=20;
	$page<1 && $page=1;
	$min=($page-1)*$rows;
	
	$showpage=getpage("{$_pre}report","","$admin_path&job=$job",$rows);
	$query = $db->query("SELECT A.*,B.id,B.rid,B.iftrue,B.username AS Rname,B.posttime AS Rtime,B.type AS Rtype,B.content AS about FROM {$_pre}report B LEFT JOIN {$_pre}content A  ON A.id=B.id ORDER BY B.rid DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){

		if(!$rs[title]&&$_rs=get_id_info($rs[id])){
			$rs=$_rs[$rs[id]]+$rs;
		}

		if($rs[iftrue]==1){
			$rs[iftrue]="<font color=red>属实</font>";
		}elseif($rs[iftrue]==2){
			$rs[iftrue]="<font color=blue>不属实</font>";
		}else{
			$rs[iftrue]="待确认";
		}
		$rs[posttime]=date("m-d H:i",$rs[posttime]);
		$rs[Rtime]=date("m-d H:i",$rs[Rtime]);
		$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);

		$listdb[]=$rs;
	}
	get_admin_html('list');
}
elseif($jobs=="del"||$action=="del")
{
	if($rid){
		$db->query("DELETE FROM {$_pre}report WHERE rid='$rid'");
	}elseif($listdb){
		$s=implode(",",$listdb);
		$db->query("DELETE FROM {$_pre}report WHERE rid IN ($s)");
	}else{
		showerr("请选择一个");
	}
	refreshto("$FROMURL","删除成功",1);
	
}
elseif($jobs=="istrue"||$jobs=="isfalse")
{
	if(!$listdb){
		showerr("请选择一个");
	}
	$s=implode(",",$listdb);
	
	$query = $db->query("SELECT A.*,A.uid AS authoid,B.rid,B.iftrue FROM {$_pre}report B LEFT JOIN {$_pre}content A  ON A.id=B.id WHERE B.rid IN ($s)");
	while($rs = $db->fetch_array($query)){
		if($jobs=="istrue"&&$rs[iftrue]!=1){
			$db->query("UPDATE {$_pre}report SET iftrue=1 WHERE rid IN ($rs[rid])");
			add_user($rs[uid],abs($webdb[ReportMoney]));
			//add_user($rs[authoid],-abs($webdb[ReportMoney]));
		}elseif($jobs=="isfalse"&&$rs[iftrue]!=2){
			$db->query("UPDATE {$_pre}report SET iftrue=2 WHERE rid IN ($rs[rid])");
			add_user($rs[authoid],-abs($webdb[DelReportMoney]));
		}
	}
	refreshto("$FROMURL","操作成功",1);
}

?>