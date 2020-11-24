<?php
!function_exists('html') && exit('ERR');

if($job=="list")
{
	$fid=intval($fid);
	
	$sortdb=array();
	list__allsort($fid,$table='area');

	if($fid){
		$rsdb=$db->get_one(" SELECT * FROM {$pre}area WHERE fid='$fid' ");
	}
	$sort_fup=$Guidedb->Select("{$pre}area","fup",$fid);

	hack_admin_tpl('sort');
}
elseif($action=="addsort")
{
	if($fup){
		$rs=$db->get_one("SELECT name,class FROM {$pre}area WHERE fid='$fup' ");
		$class=$rs['class'];
		$db->query("UPDATE {$pre}area SET sons=sons+1 WHERE fid='$fup'");
		$type=0;
	}else{
		$class=0;
		$type=1;	/*分类标志*/
	}
	
	$class++;
	$db->query("INSERT INTO {$pre}area (name,fup,class,type,allowcomment) VALUES ('$name','$fup','$class','$type',1) ");
	@extract($db->get_one("SELECT fid FROM {$pre}area ORDER BY fid DESC LIMIT 0,1"));
	
	mod_sort_class("{$pre}area",0,0);		//更新class
	mod_sort_sons("{$pre}area",0);			//更新sons
	/*更新导航缓存*/
	cache_area();
	refreshto("?lfj=$lfj&job=editsort&fid=$fid","创建成功");
}

//修改栏目信息
elseif($job=="editsort")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT * FROM {$pre}area WHERE fid='$fid'");
	$rsdb[config]=unserialize($rsdb[config]);
	$sort_fid=$Guidedb->Select("{$pre}area","postdb[fid]",$fid,"?lfj=$lfj&job=$job");
	$sort_fup=$Guidedb->Select("{$pre}area","postdb[fup]",$rsdb[fup]);
	$style_select=select_style('postdb[style]',$rsdb[style]);
	$group_post=group_box("postdb[allowpost]",explode(",",$rsdb[allowpost]));
	$group_viewtitle=group_box("postdb[allowviewtitle]",explode(",",$rsdb[allowviewtitle]));
	$group_viewcontent=group_box("postdb[allowviewcontent]",explode(",",$rsdb[allowviewcontent]));
	$group_download=group_box("postdb[allowdownload]",explode(",",$rsdb[allowdownload]));
	$typedb[$rsdb[type]]=" checked ";

	$forbidshow[intval($rsdb[forbidshow])]=" checked ";
	$allowcomment[intval($rsdb[allowcomment])]=" checked ";

	$tpl=unserialize($rsdb[template]);
 

	$listorder[$rsdb[listorder]]=" selected ";


	$sonListorder[$rsdb[config][sonListorder]]=" selected ";

	hack_admin_tpl('editsort');
}
elseif($action=="editsort")
{
	//检查父栏目是否有问题
	check_fup("{$pre}area",$postdb[fid],$postdb[fup]);
	$postdb[allowpost]=@implode(",",$postdb[allowpost]);
	$postdb[allowviewtitle]=@implode(",",$postdb[allowviewtitle]);
	$postdb[allowviewcontent]=@implode(",",$postdb[allowviewcontent]);
	$postdb[allowdownload]=@implode(",",$postdb[allowdownload]);
	$postdb[template]=@serialize($postdb[tpl]);
	unset($SQL);

	$rs_fid=$db->get_one("SELECT * FROM {$pre}area WHERE fid='$postdb[fid]'");
	//这样处理是其他地方也修改过这个值.比如标签里
	$rs_fid[config]=unserialize($rs_fid[config]);
	//$rs_fid[config][sonTitleRow]=$sonTitleRow;
	//$rs_fid[config][sonTitleLeng]=$sonTitleLeng;
	//$rs_fid[config][cachetime]=$cachetime;
	//$rs_fid[config][sonListorder]=$sonListorder;
	$postdb[config]=addslashes( serialize($rs_fid[config]) );

	if($rs_fid[fup]!=$postdb[fup])
	{
		$rs_fup=$db->get_one("SELECT class FROM {$pre}area WHERE fup='$postdb[fup]' ");
		$newclass=$rs_fup['class']+1;
		$db->query("UPDATE {$pre}area SET sons=sons+1 WHERE fup='$postdb[fup]' ");
		$db->query("UPDATE {$pre}area SET sons=sons-1 WHERE fup='$rs_fid[fup]' ");
		$SQL=",class=$newclass";
	}
	

	$db->query("UPDATE {$pre}area SET fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',allowdownload='$postdb[allowdownload]',forbidshow='$postdb[forbidshow]',config='$postdb[config]'$SQL WHERE fid='$postdb[fid]' ");

	mod_sort_class("{$pre}area",0,0);		//更新class
	mod_sort_sons("{$pre}area",0);			//更新sons
	/*更新导航缓存*/
	cache_area();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="delete")
{
	$db->query(" DELETE FROM `{$pre}area` WHERE fid='$fid' ");
	
	mod_sort_class("{$pre}area",0,0);		//更新class
	mod_sort_sons("{$pre}area",0);			//更新sons
	/*更新导航缓存*/
	cache_area();
	refreshto($FROMURL,"删除成功");
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$pre}area SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$pre}area",0,0);		//更新class
	mod_sort_sons("{$pre}area",0);			//更新sons
	/*更新导航缓存*/
	cache_area();
	refreshto("$FROMURL","修改成功",1);
}



/**
*更新缓存
**/
 

function cache_area(){
	global $db,$pre;
	$show="<?php\r\n";
	$query = $db->query("SELECT fid,fup,name FROM {$pre}area LIMIT 500");
	while($rs = $db->fetch_array($query)){
		$rs[name]=addslashes($rs[name]);
		$show.="\$area_db[{$rs[fup]}][{$rs[fid]}]='$rs[name]';
		\$area_db[name][{$rs[fid]}]='$rs[name]';
		";
	}
	write_file(ROOT_PATH."data/all_area.php",$show);
}

/*栏目列表*/
function list__allsort($fid,$table='sort'){
	global $db,$pre,$sortdb;
	$query=$db->query("SELECT * FROM {$pre}$table where fup='$fid' ORDER BY list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$rs['class'];$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		$rs[config]=unserialize($rs[config]);
		$rs[icon]=$icon;
		$sortdb[]=$rs;

		list__allsort($rs[fid],$table);
	}
}
?>