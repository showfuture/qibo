<?php
if(!function_exists('html')){
	die('F');
}
header('Content-Type: text/html; charset=gb2312');

if(!$lfjid)
{
	die("<A HREF='$webdb[www_url]/login.php' onclick=\"clickEdit.cancel('clickEdit_$TagId')\">请先登录</A>");
}
if($atc=="do"){
	$_erp=$Fid_db[tableid][$fid];
	if(!$lfjuid){
		$power=0;
	}elseif($web_admin){
		$power=2;
		$rs=$db->get_one("SELECT S.admin,S.fid,A.uid,A.mid FROM {$_pre}content$_erp A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");
	}else{
		$rs=$db->get_one("SELECT S.admin,S.fid,A.uid,A.mid FROM {$_pre}content$_erp A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");
		$detail=@explode(",",$rs[admin]);
		if($rs[uid]==$lfjuid){
			$power=1;
		}elseif($lfjid&&@in_array($lfjid,$detail)){
			$power=2;
		}else{
			$power=0;
		}
	}
	if($power==0){
		die("你无权操作");
	}
	if($step==2){
		if($action=="del"){
			del_info($id,$_erp,$rs);
			$rs[url]=get_info_url('',$rs[fid],$rs[city_id]);
			refreshto($rs[url],"删除成功",1);
		}elseif($action=="levels"&&$power==2){
			$db->query("UPDATE {$_pre}content$_erp SET levels='$levels' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}elseif($action=="yz"&&$power==2){
			$db->query("UPDATE {$_pre}content$_erp SET yz='$yz' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}elseif($action=="top"&&$power==2){
			$db->query("UPDATE {$_pre}content$_erp SET list='$top' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}
	}else{
		$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$id'");
		echo "<A HREF=\"$city_url/post.php?job=edit&fid=$fid&id=$id\">修改</A><br><A HREF=\"$city_url/post.php?action=del&fid=$fid&id=$id\" onclick=\"return confirm('你确认要删除吗?');\">删除</A><br>";
		if($rs[levels]&&$power==2){
			echo "(已推荐)<A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=levels&levels=0&id=$id&fid=$fid\">取消推荐</A><br>";
		}elseif($power==2){
			echo "(未推荐)<A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=levels&levels=1&id=$id&fid=$fid\">推荐</A><br>";
		}
		if($rs[yz]&&$power==2){
			echo "(已审核)<A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=yz&yz=0&id=$id&fid=$fid\">取消审核</A><br>";
		}elseif($power==2){
			echo "(未审核)<A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=yz&yz=1&id=$id&fid=$fid\">审核通过</A><br>";
		}
		if($rs['list']>$timestamp&&$power==2){
			echo "(已置顶)<A HREF=\"\"><A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=top&top=$rs[posttime]&id=$id&fid=$fid\">取消置顶</A></A><br>";
		}elseif($power==2){
			$times=$timestamp*1.3;
			echo "(未置顶)<A HREF=\"$city_url/job.php?job=$job&atc=$atc&step=2&action=top&top=$times&id=$id&fid=$fid\">置顶</A><br>";
		}
	}
}
?>