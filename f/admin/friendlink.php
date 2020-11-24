<?php
function_exists('html') OR exit('ERR');

ck_power('friendlink');

$linkdb=array(
			"添加友情链接"=>"$admin_path&job=add",
			"友情链接管理"=>"$admin_path&job=list",
			);

if($job=="mod")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}friendlink WHERE id='$id' ");
	$rsdb[ifhide]=intval($rsdb[ifhide]);
	$ifhide[$rsdb[ifhide]]=" checked ";
	$yz[$rsdb[yz]]=" checked ";
	$iswordlink[$rsdb[iswordlink]]=" checked ";
	$select_fid=select_fsort("postdb[fid]",$rsdb[city_id]);
	$rsdb[endtime]=$rsdb[endtime]?date("Y-m-d H:i:s",$rsdb[endtime]):'';

	get_admin_html('mod');
}
elseif($action=="mod")
{
	$postdb[endtime]	&&	$postdb[endtime]=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$postdb[endtime]);
	//die("UPDATE {$_pre}friendlink SET name='$postdb[name]',url='$postdb[url]',logo='$postdb[logo]',descrip='$postdb[descrip]',`ifhide`='$postdb[ifhide]',`yz`='$postdb[yz]',`iswordlink`='$postdb[iswordlink]',`city_id`='$postdb[fid]',endtime='$postdb[endtime]' WHERE id='$id'");
	$db->query("UPDATE {$_pre}friendlink SET name='$postdb[name]',url='$postdb[url]',logo='$postdb[logo]',descrip='$postdb[descrip]',`ifhide`='$postdb[ifhide]',`yz`='$postdb[yz]',`iswordlink`='$postdb[iswordlink]',`city_id`='$postdb[fid]',endtime='$postdb[endtime]' WHERE id='$id'");
	write_friendlink();
	refreshto("$FROMURL","修改成功",1);
}
elseif($job=="add")
{
	$ifhide[0]=" checked ";
	$iswordlink[0]=" checked ";
	$yz[1]=" checked ";
	$select_fid=select_fsort("postdb[fid]","");

	get_admin_html('mod');
}
elseif($action=="add")
{
	//die("INSERT INTO `{$_pre}friendlink` (`name` , `url` ,`city_id` , `logo` , `descrip` , `list`,ifhide,yz,iswordlink,posttime ) VALUES ('$postdb[name]','$postdb[url]','$postdb[fid]','$postdb[logo]','$postdb[descrip]','0','$postdb[ifhide]','$postdb[yz]','$postdb[iswordlink]','$timestamp')");
	$db->query("INSERT INTO `{$_pre}friendlink` (`name` , `url` ,`city_id` , `logo` , `descrip` , `list`,ifhide,yz,iswordlink,posttime ) VALUES ('$postdb[name]','$postdb[url]','$postdb[fid]','$postdb[logo]','$postdb[descrip]','0','$postdb[ifhide]','$postdb[yz]','$postdb[iswordlink]','$timestamp')");
	write_friendlink();
	refreshto("$admin_path&job=list","添加成功");
}
elseif($job=="list")
{
	$rows=30;
	if(!$page){
		$page=1;
	}
	if($cityid){
		$SQL=" WHERE A.city_id='$cityid' ";
	}else{
		$SQL="";
	}
	$min=($page-1)*$rows;
	$showpage=getpage("`{$_pre}friendlink` A","$SQL","$admin_path&job=$job&cityid=$cityid",$rows);
	$query=$db->query("SELECT A.*,B.name AS fname FROM `{$_pre}friendlink` A LEFT JOIN {$_pre}city B ON A.city_id=B.fid $SQL ORDER BY A.yz ASC,A.list DESC,A.id DESC LIMIT $min,$rows");
	while($rs=$db->fetch_array($query)){
		$rs[ifshow]=$rs[ifhide]?"<A HREF='$admin_path&job=up&ifhide=0&id=$rs[id]' style='color:red;'>首页隐藏</A>":"<A HREF='$admin_path&job=up&ifhide=1&id=$rs[id]' style='color:blue;'>首页显示</A>";
		if(!$rs[yz]){
			$rs[ifshow]="隐藏";
		}
		$rs[fname] || $rs[fname]='全国';
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
		$rs[yz]=$rs[yz]?"<a href='$admin_path&job=setyz&yz=0&id=$rs[id]' style='color:red;'><img alt='已通过审核,点击取消审核' src='../member/images/check_yes.gif' border=0></a>":"<a href='$admin_path&job=setyz&yz=1&id=$rs[id]' style='color:blue;'><img alt='还没通过审核,点击通过审核' src='../member/images/check_no.gif' border=0></a>";
		$listdb[]=$rs;
	}

	get_admin_html('friendlink');
}
elseif($action=="list")
{
	foreach( $listdb AS $key=>$value){
		$db->query("UPDATE {$_pre}friendlink SET `list`='$value' WHERE id='$key'");
	}
	write_friendlink();
	refreshto("$FROMURL","修改成功",1);
}
elseif($action=="delete")
{
	$db->query("DELETE FROM `{$_pre}friendlink` WHERE id='$id' ");
	write_friendlink();
	refreshto("$admin_path&job=list","删除成功");
}
elseif($job=="up")
{
	$db->query("UPDATE {$_pre}friendlink SET `ifhide`='$ifhide' WHERE id='$id'");
	write_friendlink();
	refreshto("$FROMURL","修改成功",0);
}
elseif($job=="setyz")
{
	$db->query("UPDATE {$_pre}friendlink SET `yz`='$yz' WHERE id='$id'");
	write_friendlink();
	refreshto("$FROMURL","修改成功",0);
}



//友情链接缓存
function write_f_friendlink(){
	global $db,$_pre,$timestamp;
	$query = $db->query("SELECT * FROM {$_pre}friendlink WHERE yz=1 AND (endtime=0 OR endtime>$timestamp) ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		foreach( $rs AS $key=>$value){
			$rs[$key]=AddSlashes($rs[$key]);
		}
		if($rs[logo]&&!$rs[iswordlink]){
			$rs[logo]=tempdir($rs[logo]);
			if($rs[fid]){
				$show.="\$CFLDB[i_$rs[fid]][]=array('name'=>'$rs[name]','url'=>'$rs[url]','logo'=>'$rs[logo]','descrip'=>'$rs[descrip]');\r\n";
			}else{
				$logodb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','logo'=>'$rs[logo]','descrip'=>'$rs[descrip]')";
			}
		}else{
			if($rs[fid]){
				$show.="\$CFLDB[w_$rs[fid]][]=array('name'=>'$rs[name]','url'=>'$rs[url]','descrip'=>'$rs[descrip]');\r\n";
			}else{
				$worddb[]="'$rs[id]'=>array('name'=>'$rs[name]','url'=>'$rs[url]','descrip'=>'$rs[descrip]')";
			}
		}
	}
	$write="<?php unset(\$friendlinkDB,\$CFLDB);\r\n\$friendlinkDB[1]=array(".implode(",\r\n",$logodb).");\r\n\$friendlinkDB[0]=array(".implode(",\r\n",$worddb).");";
	
	write_file(ROOT_PATH."data/friendlink.php",$write."\r\n$show?>");
}

function select_fsort($name,$fid=''){
	global $db,$_pre,$webdb;
	$show.="<select name='$name'><option value=''>$webdb[Info_areaname]</option>";
	$query = $db->query("SELECT * FROM {$_pre}city ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ck=$fid==$rs[fid]?'selected':'';
		$show.="<option value='$rs[fid]' $ck>$rs[name]</option>";
	}
	$show.="</select>";
	return $show;
}
?>