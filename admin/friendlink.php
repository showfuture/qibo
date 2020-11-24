<?php
!function_exists('html') && exit('ERR');

if($job=="mod"&&$Apower[friendlink_mod])
{
	$rsdb=$db->get_one("SELECT * FROM {$pre}friendlink WHERE id='$id' ");
	$rsdb[ifhide]=intval($rsdb[ifhide]);
	$ifhide[$rsdb[ifhide]]=" checked ";
	$yz[$rsdb[yz]]=" checked ";
	$iswordlink[$rsdb[iswordlink]]=" checked ";
	$select_fid=select_fsort("postdb[fid]",$rsdb[fid]);
	$rsdb[endtime]=$rsdb[endtime]?date("Y-m-d H:i:s",$rsdb[endtime]):'';
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/friendlink/menu.htm");
	require(dirname(__FILE__)."/"."template/friendlink/mod.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="mod"&&$Apower[friendlink_mod])
{
	$postdb[endtime]	&&	$postdb[endtime]=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$postdb[endtime]);
	$db->query("UPDATE {$pre}friendlink SET name='$postdb[name]',url='$postdb[url]',logo='$postdb[logo]',descrip='$postdb[descrip]',`ifhide`='$postdb[ifhide]',`yz`='$postdb[yz]',`iswordlink`='$postdb[iswordlink]',`fid`='$postdb[fid]',endtime='$postdb[endtime]' WHERE id='$id'");
	write_friendlink();
	jump("修改成功","$FROMURL",1);
}
elseif($job=="add"&&$Apower[friendlink_mod])
{
	$ifhide[0]=" checked ";
	$iswordlink[0]=" checked ";
	$yz[1]=" checked ";
	$select_fid=select_fsort("postdb[fid]","");
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/friendlink/menu.htm");
	require(dirname(__FILE__)."/"."template/friendlink/mod.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="add"&&$Apower[friendlink_mod])
{
	$db->query("INSERT INTO `{$pre}friendlink` (`name` , `url` ,`fid` , `logo` , `descrip` , `list`,ifhide,yz,iswordlink ) VALUES ('$postdb[name]','$postdb[url]','$postdb[fid]','$postdb[logo]','$postdb[descrip]','0','$postdb[ifhide]','$postdb[yz]','$postdb[iswordlink]')");
	write_friendlink();
	jump("添加成功","index.php?lfj=friendlink&job=list");
}
elseif($job=="list"&&$Apower[friendlink_mod])
{
	$rows=30;
	if(!$page){
		$page=1;
	}
	if($fid){
		$SQL=" WHERE A.fid='$fid' ";
	}else{
		$SQL="";
	}
	$min=($page-1)*$rows;
	$showpage=getpage("`{$pre}friendlink` A","$SQL","?lfj=$lfj&job=$job&fid=$fid",$rows);
	$query=$db->query("SELECT A.*,B.name AS fname FROM `{$pre}friendlink` A LEFT JOIN {$pre}friendlink_sort B ON A.fid=B.fid $SQL ORDER BY A.list DESC,A.yz ASC,A.id DESC LIMIT $min,$rows");
	while($rs=$db->fetch_array($query)){
		$rs[ifshow]=$rs[ifhide]?"<A HREF='?lfj=$lfj&job=up&ifhide=0&id=$rs[id]' style='color:red;'>首页隐藏</A>":"<A HREF='?lfj=$lfj&job=up&ifhide=1&id=$rs[id]' style='color:blue;'>首页显示</A>";
		if(!$rs[yz]){
			$rs[ifshow]="隐藏";
		}
		if(!$rs[endtime]){
			$rs[state]='长久有效';
		}elseif($rs[endtime]<$timestamp){
			$rs[state]='<font color=#FF0000>已过期</font>';
		}else{
			$rs[state]='<font color=#0000FF>'.date("Y-m-d H:i",$rs[endtime]).'</font>截止';
		}
		if($rs[logo]){
			$rs[logo]=tempdir($rs[logo]);
			$rs[logo]="<img src='$rs[logo]' width=88 height=31 border=0>";
		}
		$rs[yz]=$rs[yz]?"<a href='index.php?lfj=$lfj&job=setyz&yz=0&id=$rs[id]' style='color:red;'><img alt='已通过审核,点击取消审核' src='../member/images/check_yes.gif' border=0></a>":"<a href='index.php?lfj=$lfj&job=setyz&yz=1&id=$rs[id]' style='color:blue;'><img alt='还没通过审核,点击通过审核' src='../member/images/check_no.gif' border=0></a>";
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/friendlink/menu.htm");
	require(dirname(__FILE__)."/"."template/friendlink/friendlink.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="list"&&$Apower[friendlink_mod])
{
	foreach( $listdb AS $key=>$value){
		$db->query("UPDATE {$pre}friendlink SET `list`='$value' WHERE id='$key'");
	}
	write_friendlink();
	jump("修改成功","$FROMURL",1);
}
elseif($action=="delete"&&$Apower[friendlink_mod])
{
	$db->query("DELETE FROM `{$pre}friendlink` WHERE id='$id' ");
	write_friendlink();
	jump("删除成功","index.php?lfj=friendlink&job=list");
}
elseif($job=="up"&&$Apower[friendlink_mod])
{
	$db->query("UPDATE {$pre}friendlink SET `ifhide`='$ifhide' WHERE id='$id'");
	write_friendlink();
	jump("修改成功","$FROMURL",0);
}
elseif($job=="setyz"&&$Apower[friendlink_mod])
{
	$db->query("UPDATE {$pre}friendlink SET `yz`='$yz' WHERE id='$id'");
	write_friendlink();
	jump("修改成功","$FROMURL",0);
}



function select_fsort($name,$ckfid){
	global $db,$pre;
	$show="<select name='$name'><option value=''>请选择</option>";
	$query = $db->query("SELECT * FROM {$pre}friendlink_sort ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$ckfid==$rs[fid]?' selected ':'';
		$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
	}
	$show.="</select>";
	return $show;
}

?>