<?php
!function_exists('html') && exit('ERR');


if($job=='list'&&$Apower[menu_list])
{
	if(!table_field("{$pre}menu",'extend')){
		$db->query("ALTER TABLE `{$pre}menu` ADD `extend` VARCHAR( 30 ) NOT NULL");
	}
	$query = $db->query("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND fid=0 ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$rs[hide]=$rs[hide]?'<a style="color:blue;">隐藏</a>':'显示';
		$listdb[]=$rs;
		$query2 = $db->query("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND fid='$rs[id]' ORDER BY list DESC");
		while($rs2 = $db->fetch_array($query2)){
			$rs2[hide]=$rs2[hide]?'<a style="color:blue;">隐藏</a>':'显示';
			$rs2[icon]='&nbsp;&nbsp;&nbsp;&nbsp;|--------';
			$listdb[]=$rs2;
		}
	}

	$ShowMenu[intval($webdb[ShowMenu])]=" checked ";

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/guidemenu/menu.htm");
	require(dirname(__FILE__)."/"."template/guidemenu/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=='edit'&&$Apower[menu_list])
{
	$atc="edit";
	$rsdb=$db->get_one("SELECT * FROM {$pre}menu WHERE id='$id'");
	$target[$rsdb[target]]=' checked ';
	$hide[$rsdb[hide]]=' checked ';

	$selected=select_fupmenu('fid',$rsdb[fid]);
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/guidemenu/menu.htm");
	require(dirname(__FILE__)."/"."template/guidemenu/edit.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=='edit'&&$Apower[menu_list])
{
	if(!$postdb[name])
	{
		showerr("名称不能为空");
	}
	if(!$postdb['linkurl'])
	{
		showerr("链接地址不能为空");
	}
	$postdb[name]=filtrate($postdb[name]);
	$postdb[linkurl]=filtrate($postdb[linkurl]);

	$db->query("UPDATE {$pre}menu SET fid='$fid',name='$postdb[name]',linkurl='$postdb[linkurl]',color='$postdb[color]',target='$postdb[target]',hide='$postdb[hide]',list='$postdb[list]' WHERE id='$id'");
	menu_cache();
	jump("修改成功","?lfj=guidemenu&job=list",1);
}
elseif($job=='add'&&$Apower[menu_list])
{
	$target[0]=' checked ';
	$hide[0]=' checked ';
	$atc="add";
	$selected=select_fupmenu('fid',$rsdb[fid]);
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/guidemenu/menu.htm");
	require(dirname(__FILE__)."/"."template/guidemenu/edit.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=='add'&&$Apower[menu_list])
{
	if(!$postdb[name]){
		showerr("名称不能为空");
	}
	if(!$postdb['linkurl']){
		showerr("链接地址不能为空");
	}
	$postdb[name]=filtrate($postdb[name]);
	$postdb[linkurl]=filtrate($postdb[linkurl]);

	$db->query("INSERT INTO `{$pre}menu` (`fid`, `name`, `linkurl`, `color`, `target`, `moduleid`, `hide`, `list`) VALUES ('$fid', '$postdb[name]', '$postdb[linkurl]', '$postdb[color]', '$postdb[target]', 0, '$postdb[hide]', '$postdb[list]')");
	menu_cache();
	jump("添加成功","?lfj=guidemenu&job=list",1);
}
elseif($action=='delete'&&$Apower[menu_list])
{
	$rs = $db->get_one("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND fid='$id'");
	if($rs){
		showerr("请先删除子菜单或者把子菜单移走.才能删除此菜单");
	}

	$db->query("DELETE FROM `{$pre}menu` WHERE id='$id'");
	menu_cache();
	jump("删除成功","?lfj=guidemenu&job=list",1);
}
elseif($action=="editlist"&&$Apower[menu_list])
{
	foreach( $order AS $key=>$value)
	{
		$db->query("UPDATE {$pre}menu SET list='$value' WHERE id='$key'");
	}
	menu_cache();
	jump("修改成功","?lfj=guidemenu&job=list",1);
}
elseif($action=="setShowMenu"&&$Apower[menu_list])
{
	write_config_cache($webdbs);
	jump("修改成功","?lfj=guidemenu&job=list",1);
}


function menu_cache(){
	global $db,$pre;
	$query = $db->query("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND hide=0 AND fid=0 ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$array[]="$rs[name]|$rs[linkurl]|$rs[target]|$rs[color]|$rs[id]";
		
		//$show.='
		//var Menu_'.$rs[id].' = "';

		$query2 = $db->query("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND hide=0 AND fid='$rs[id]' ORDER BY list DESC");
		while($rs2 = $db->fetch_array($query2)){
			/*
			if(ereg("^\/",$rs2[linkurl])){
				$url="\$webdb[www_url]$rs2[linkurl]";
			}elseif(!ereg("://",$rs2[linkurl])){
				$url="\$webdb[www_url]/$rs2[linkurl]";
			}
			$show.="<a href='$url'>$rs2[name]</a><br>";
			*/
			$show.="\r\n\$MenuArray[$rs[id]][]='".addslashes("$rs2[name]|$rs2[linkurl]|$rs2[target]|$rs2[color]|$rs2[id]")."';";
		}

		//$show.='";
		//';
	}
	$webdbs[guide_word]=implode("\r\n",$array);
	write_config_cache($webdbs);
}


function select_fupmenu($name='fid',$id=0){
	global $db,$pre;
	$select="<select name='$name'><option value='0'>请选择</option>";
	$query = $db->query("SELECT * FROM {$pre}menu WHERE moduleid=0 AND type=0 AND fid=0 ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$id==$rs[id]?' selected ':'';
		$select.="<option value='$rs[id]' $ckk style='color:blue;'>$rs[name]</option>";
	}
	$select.="</select>";
	return $select;
}