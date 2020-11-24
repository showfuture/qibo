<?php
if($job=="do"){
	if(!$lfjuid){
		$power=0;
	}elseif($web_admin){
		$power=2;
		$rs=$db->get_one("SELECT S.admin,S.fid,A.uid,A.mid FROM {$_pre}content A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");
	}else{
		$rs=$db->get_one("SELECT S.admin,S.fid,A.uid,A.mid FROM {$_pre}content A LEFT JOIN {$_pre}sort S ON A.fid=S.fid WHERE A.id='$id'");
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
		if($action=="levels"&&$power==2){
			$db->query("UPDATE {$_pre}content SET levels='$levels' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}elseif($action=="yz"&&$power==2){
			$db->query("UPDATE {$_pre}content SET yz='$yz' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}elseif($action=="top"&&$power==2){
			$db->query("UPDATE {$_pre}content SET list='$top' WHERE id='$id'");
			refreshto("$FROMURL","操作成功",1);
		}
	}else{
		$rs=$db->get_one("SELECT * FROM {$_pre}content WHERE id='$id'");
		
		if($rs[levels]&&$power==2){
			echo "(已推荐)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=levels&levels=0&id=$id\">取消推荐</A><br>";
		}elseif($power==2){
			echo "(未推荐)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=levels&levels=1&id=$id\">推荐</A><br>";
		}
		if($rs[yz]==1&&$power==2){
			echo "(已审核)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=yz&yz=0&id=$id\">取消审核</A><br>";
		}elseif($power==2){
			echo "(未审核)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=yz&yz=1&id=$id\">审核通过</A><br>";
		}
		if($rs['list']>$timestamp&&$power==2){
			echo "(已置顶)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=top&top=$timestamp&id=$id\">取消置顶</A></A><br>";
		}elseif($power==2){
			$times=$timestamp*1.3;
			echo "(未置顶)<A HREF=\"$Mdomain/ajax.php?inc=$inc&job=$job&step=2&action=top&top=$times&id=$id\">置顶</A><br>";
		}
		echo "<A HREF=\"$webdb[www_url]/member/?main=$Murl/member/post.php?fid=$fid\">发表文章</A><br>";
		echo "<A HREF=\"$webdb[www_url]/member/?main=$Murl/member/post.php?job=edit&fid=$fid&id=$id&rid=$rid\">修改文章</A><br>";
		echo "<A HREF=\"$webdb[www_url]/member/?main=$Murl/member/post.php?action=del&fid=$fid&id=$id&rid=$rid\" onclick=\"return confirm('你确认要删除吗?不可恢复');\">删除本文</A><br>";
	}
}
?>