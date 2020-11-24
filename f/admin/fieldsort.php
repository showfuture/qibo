<?php
function_exists('html') OR exit('ERR');

ck_power('fieldsort');

if($job=="listsort")
{
	$gudie=getGuide($fid,"$admin_path&job=listsort&fid=");
	$query = $db->query("SELECT * FROM {$_pre}class WHERE fup='$fid' ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}class WHERE fup='$rs[fid]'"));
		$rs[NUM]=intval($NUM);
		$listdb[]=$rs;
	}

	get_admin_html('sort');
}
elseif($action=="addsort")
{
	if(!$name){
		showerr('名称不能为空!');
	}
	$detail=explode("\r\n",$name);
	foreach($detail AS $key=>$value){
		if($value){
			$value=filtrate($value);
			$db->query("INSERT INTO {$_pre}class (name,fup) VALUES ('$value','$fup')");
		}
	}
	refreshto("$FROMURL","创建成功");
}

//修改栏目信息
elseif($job=="editsort")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}class WHERE fid='$fid'");

	$gudie=getGuide($rsdb[fup],"$admin_path&job=listsort&fid=");

	get_admin_html('editsort');
}
elseif($action=="editsort")
{
	$db->query("UPDATE {$_pre}class SET name='$postdb[name]' WHERE fid='$postdb[fid]' ");
	 
	refreshto("$FROMURL","修改成功");
}
elseif($action=="delete")
{
	if(!$fid_db&&$fid){
		$fid_db[]=$fid;
	}

	if(!$fid_db){
		showerr("请选择一个!");
	}

	if(!in_array('fenlei',$BIZ_MODULEDB)&&count($fid_db)>1){
		showerr("免费版,不支持批量删除,一次只能删除一个");
	}

	foreach($fid_db AS $fid){
		extract($db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}class` WHERE fup='$fid'"));
		if($NUM){
			showerr("请先删除子分类");
		}
		$db->query("DELETE FROM `{$_pre}class` WHERE fid='$fid'");
	}	
	refreshto("$FROMURL","删除成功",0);
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}class SET list='$value' WHERE fid='$key' ");
	}
	refreshto("$FROMURL","修改成功",1);
}


function getGuide($fid,$url){
	global $db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}class WHERE fid='$fid' ");
	while($rs = $db->fetch_array($query)){
		$show.=" -&gt; <A HREF='{$url}$fid'>$rs[name]</A>".$show;
		if($rs[fup]){
			$show=getGuide($rs[fup],$url).$show;
		}else{
			$show="<A HREF='$url'>返回顶级</A>".$show;
		}
	}
	return $show;
}
?>