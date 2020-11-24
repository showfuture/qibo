<?php
require_once(dirname(__FILE__)."/"."global.php");
header('Content-Type: text/html; charset=gb2312');
if($type==2)
{	
	if($ckfid){
		$fdivid="{$fuid}_".rands(5);
		echo $shows=get__sonfid($ckfid,$fdivid,0,"{$pre}area");
	}
	if(!$shows){
		$showThisId="{$fuid}_".rands(5);
		echo "<select name=\"select\" onchange=\"showfid_S('$showThisId',this,'$fuid','$inputid','$type');\"><option value=\"\" style='color:blue;'>«Î—°‘Ò</option>";
		$query = $db->query("SELECT * FROM {$pre}area WHERE fup='$fid'");
		while($rs = $db->fetch_array($query)){
			$_r=$db->get_one("SELECT * FROM {$pre}area WHERE fup='$rs[fid]'");
			if($_r){
				$rs[fid]=-$rs[fid];
			}
			echo " <option value=\"$rs[fid]\">$rs[name]</option>";
		}
		echo "</select>";
		echo "<span id=\"$showThisId\"  style='display:none;'></span>";	
	}
}

function get__sonfid($ckfid,$divid,$num,$table){
	global $db,$pre,$fuid,$inputid,$type;
	$rsdb = $db->get_one("SELECT fup FROM $table WHERE fid='$ckfid'");
	$rsdb[fup]=intval($rsdb[fup]);
	$fdivid="{$fuid}_".rands(5);
	$show.= "<span id=\"$fdivid\" divname='$fuid'><select name=\"select\" onchange=\"showfid_S('$divid',this,'$fuid','$inputid','$type')\"><option value=\"\" style='color:blue;'>«Î—°‘Ò</option>";
	$query = $db->query("SELECT * FROM $table WHERE fup='$rsdb[fup]'");
	while($rs = $db->fetch_array($query)){
		$_r=$db->get_one("SELECT * FROM $table WHERE fup='$rs[fid]'");
		$_c=$ckfid==$rs[fid]?" style='color:red;' selected ":'';
		if($_r){
			$rs[fid]=-$rs[fid];
		}
		
		$show.= " <option value=\"$rs[fid]\" $_c>$rs[name]</option>";
	}
	$show.= "</select></span>";

	if($rsdb[fup]||$num)
	{
		$num++;
		if(!$rsdb[fup]){
			$num=0;
		}
		$shows=get__sonfid($rsdb[fup],$fdivid,$num,$table).$show;
	}
	return $shows;
}

?>