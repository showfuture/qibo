<?php
require_once(dirname(__FILE__)."/f/global.php");

$webdb[Info_adminfen]>0 || $webdb[Info_adminfen]=5;

$typedb=array("color"=>"标题加亮","top"=>"置顶","untop"=>"取消置顶","del"=>"删除","undel"=>"从回收站还原","fen"=>"评分","com"=>"推荐","uncom"=>"取消推荐","move"=>"转移栏目","movetop"=>"提前","movebottom"=>"置后","unyz"=>"取消验证","yz"=>"通过验证");


if(!$lfjid)
{
	showerr("你还没有登录");
}

if($job=='sort')
{
	unset($listdb,$linkdb);
	$listdb=array();
	list_allsort($fid,0);
	require("inc/head.php");
	require(html("admin"));
	require("inc/foot.php");
	exit;
}
elseif($job=="list")
{
	$_erp=$Fid_db[tableid][$fid];
	$SQL=" WHERE fid='$fid' ";
	$rows=40;
	if(!$page){
		$page=1;
	}
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}content$_erp","$SQL","?job=$job&fid=$fid","$rows");

	$query = $db->query("SELECT * FROM {$_pre}content$_erp $SQL ORDER BY list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		if($rs[yz]==1){
			$rs[ifyz]="<font color=blue>已审</font>";
		}elseif($rs[yz]==0){
			$rs[ifyz]="未审";
		}elseif($rs[yz]==2){
			$rs[ifyz]="作废";
		}
		if($rs[levels]){
			$rs[_levels]="(<font color=red>荐</font>)";
		}else{
			$rs[_levels]="";
		}
		if($rs['list']>$timestamp){
			$rs[_list]="(<font color=red>顶</font>)";
		}else{
			$rs[_list]="";
		}
		$rs[pages]<1 && $rs[pages]=1;
		$rs[url]=get_info_url($rs[id],$rs[fid],$rs[city_id]);
		$rs[listurl]=get_info_url('',$rs[fid],$rs[city_id]);
		$listdb[]=$rs;
	}
	require(ROOT_PATH."inc/class.inc.php");
	$Guidedb=new Guide_DB;
	$select_fid=$Guidedb->Select("{$_pre}sort","fid");

	require("inc/head.php");
	require(html("admin"));
	require("inc/foot.php");
}
elseif($action=="work")
{
	if(!$postdb)
	{
		showerr("请至少选择一篇文章");
	}
	if( !$typedb[$ctype] )
	{
		showerr("操作的类型不存在");
	}
	foreach( $postdb AS $key=>$id){
		do_work($ctype,$id);
	}
	refreshto("$FROMURL","操作成功","1");
}
elseif($job=="listcomment")
{
	$SQL=" WHERE 1 ";
	if($fid)
	{
		$SQL.=" AND fid='$fid' ";
	}
	$rows=40;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}comments","$SQL","?job=$job&fid=$fid","$rows");

	$query = $db->query("SELECT * FROM {$_pre}comments $SQL ORDER BY cid DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		if($rs[yz]==1){
			$rs[ifyz]="<font color=blue>已审</font>";
		}elseif($rs[yz]==0){
			$rs[ifyz]="未审";
		}
		if(!$rs[username])
		{
			$detail=explode(".",$rs[ip]);
			$rs[username]="$detail[0].$detail[1].$detail[2].*";
		}
		$rs[content]=preg_replace("/<([^<]+)>/is","",$rs[content]);
		$rs[title]=get_word($rs[content],80);
		$listdb[]=$rs;
	}
	require("inc/head.php");
	require(html("admin"));
	require("inc/foot.php");
}
elseif($action=="workcomment")
{
	if(!$postdb)
	{
		showerr("请至少选择一条评论");
	}
	if( !in_array($ctype,array('del','yz','unyz')) )
	{
		showerr("操作的类型不存在");
	}
	
	foreach( $postdb AS $key=>$id){
		do_comment_work($ctype,$id);
	}
	refreshto("$FROMURL","操作成功","1");
}else{
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=admin.php?job=sort'>";
	exit;
}

function do_comment_work($job,$id){
	global $db,$_pre,$pre,$webdb,$timestamp,$atc_pm,$atc_fen,$lfjdb,$atc_reason,$Mdomain,$web_admin,$typedb,$Fid_db;
	$rsdb=$db->get_one("SELECT A.*,S.admin FROM {$_pre}comments A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");
	if(!$web_admin)
	{
		if( !in_array($lfjdb[username],explode(",",$rsdb[admin])) )
		{
			showerr("你无权操作本评论");
		}
	}
	if($job=='del')
	{
		$db->query("DELETE FROM {$_pre}comments WHERE cid='$id'");
		$_erp=$Fid_db[tableid][$rsdb[fid]];
		$db->query("UPDATE {$_pre}content$_erp SET comments=comments-1 WHERE id='$rsdb[id]'");
	}
	elseif($job=='unyz')
	{
		$db->query("UPDATE {$_pre}comments SET yz='0' WHERE cid='$id'");
	}
	elseif($job=='yz')
	{
		$db->query("UPDATE {$_pre}comments SET yz='1' WHERE cid='$id'");
	}
}

function do_work($job,$id){
	global $db,$_pre,$pre,$webdb,$timestamp,$atc_pm,$atc_fen,$lfjdb,$atc_reason,$Mdomain,$web_admin,$typedb,$Fid_db;
	$RS=$db->get_one("SELECT fid FROM {$_pre}db WHERE id='$id'");
	$_erp=$Fid_db[tableid][$RS[fid]];
	$rsdb=$db->get_one("SELECT A.*,S.admin FROM {$_pre}content$_erp A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");	
	if(!$web_admin)
	{
		if( !in_array($lfjdb[username],explode(",",$rsdb[admin])) )
		{
			showerr("你无权操作本文:$rsdb[title]");
		}
	}
	if(abs($atc_fen)>$webdb[Info_adminfen])
	{
		showerr("评分界限不能超过:$webdb[Info_adminfen]");
	}

	if($db->get_one("SELECT * FROM {$_pre}adminwork WHERE id='$id' AND uid='$lfjdb[uid]' AND type='$job'"))
	{
		showerr("你不能重复对本文进行{$typedb[$job]},文章标题是:$rsdb[title]");
	}

	if($job=='color')
	{
		global $color;
		$db->query("UPDATE {$_pre}content$_erp SET titlecolor='$color' WHERE id='$id'");
	}
	elseif($job=='top')
	{
		global $toptime;
		$list=$timestamp+$toptime;
		$db->query("UPDATE {$_pre}content$_erp SET list='$list' WHERE id='$id'");
	}
	elseif($job=='untop')
	{
		$db->query("UPDATE {$_pre}content$_erp SET list=posttime WHERE id='$id'");
	}
	elseif($job=='del')
	{
		$db->query("UPDATE {$_pre}content$_erp SET yz=2 WHERE id='$id'");
	}
	elseif($job=='undel')
	{
		$db->query("UPDATE {$_pre}content$_erp SET yz=0 WHERE id='$id'");
	}
	elseif($job=='com')
	{
		$db->query("UPDATE {$_pre}content$_erp SET levels=1,levelstime='$timestamp' WHERE id='$id'");
	}
	elseif($job=='uncom')
	{
		$db->query("UPDATE {$_pre}content$_erp SET levels=0,levelstime='0' WHERE id='$id'");
	}
	elseif($job=='move')
	{
		global $fid;
		$rs=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");
		if($rs[mid]==$rsdb[mid])
		{
			$db->query("UPDATE {$_pre}content$_erp SET lastfid=fid,fid='$fid',fname='$rs[name]' WHERE id='$id'");
			$db->query("UPDATE {$_pre}db SET fid='$fid' WHERE id='$id'");
		}
		else
		{
			showerr("信息:“{$rsdb[title]}”,与目标栏目的模块不一样.不能转移栏目");
		}
	}
	elseif($job=='movetop')
	{
		global $atc_id1;
		if(!$atc_id1){
			showerr("id不存在");
		}
		$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$atc_id1'");
		$rs['list']++;
		$db->query("UPDATE {$_pre}content$_erp SET list='$rs[list]' WHERE id='$id'");
	}
	elseif($job=='movebottom')
	{
		global $atc_id2;
		if(!$atc_id2){
			showerr("id不存在");
		}
		$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$atc_id2'");
		$rs['list']--;
		$db->query("UPDATE {$_pre}content$_erp SET list='$rs[list]' WHERE id='$id'");
	}
	elseif($job=='unyz'&&$rsdb[yz]==1)
	{
		add_user($lfjdb[uid],-$webdb[PostInfoMoney]);
		$db->query("UPDATE {$_pre}content$_erp SET yz='0' WHERE id='$id'");
	}
	elseif($job=='yz'&&$rsdb[yz]==0)
	{
		add_user($lfjdb[uid],$webdb[PostInfoMoney]);
		$db->query("UPDATE {$_pre}content$_erp SET yz='1' WHERE id='$id'");
	}
	
	$atc_reason=filtrate($atc_reason);
	$array[touid]=$rsdb[uid];
	$array[fromuid]=$lfjdb[uid];
	$array[fromer]=$lfjdb[username];
	$title=get_word($rsdb[title],30);
	$array[title]=addslashes("你的文章被{$typedb[$job]}了,文章标题是:$title");
	$url=get_info_url($rsdb[id],$rsdb[fid],$rsdb[city_id]);
	$array[content]=addslashes("操作理由是:$atc_reason<br><br>积分影响是:{$atc_fen}分<br><br><A HREF='$url' target=_blank>点击查看</A>");

	$atc_pm && $array[touid] && pm_msgbox($array);

	$atc_fen && plus_money($rsdb[uid],$atc_fen);

	$db->query("INSERT INTO `{$_pre}adminwork` (`type`, `id`, `uid`, `username`, `ifpm`, `fen`, `reason`, `posttime`) VALUES ( '$job', '$id', '$lfjdb[uid]', '$lfjdb[username]', '$atc_pm', '$atc_fen', '$atc_reason', '$timestamp')");
}



function list_allsort($fid,$Class){
	global $db,$_pre,$listdb,$web_admin,$lfjdb,$lfjid,$webdb,$groupdb,$Fid_db;
	$Class++;
	$query=$db->query("SELECT S.* FROM {$_pre}sort S WHERE S.fup='$fid' ORDER BY S.list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$Class;$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		$rs[icon]=$icon;
		$_erp=$Fid_db[tableid][$rs[fid]];
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}content$_erp WHERE fid='$rs[fid]' AND yz=1"));
		$rs[yznum]=$NUM;
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}content$_erp WHERE fid='$rs[fid]' AND yz=0"));
		$rs[unyznum]=$NUM;

		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}comments WHERE fid='$rs[fid]' AND yz=1"));
		$rs[Cyznum]=$NUM;
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}comments WHERE fid='$rs[fid]' AND yz=0"));
		$rs[Cunyznum]=$NUM;

		if($web_admin||in_array($lfjid,explode(",",$rs[admin]))){
			$rs[_admin]='';
		}else{
			$rs[_admin]="onclick=\"alert('你无权管理');return false;\" style='color:#ccc;'";
		}

		$listdb[]=$rs;
		list_allsort($rs[fid],$Class);
	}
}


?>