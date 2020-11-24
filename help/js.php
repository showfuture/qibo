<?php
require(dirname(__FILE__)."/"."global.php");

$fid=intval($fid);
$rows>0 || $rows=7;
$leng>0 || $leng=60;

unset($SQL,$show);

//热门 ,推荐 ,最新 ,没用使用缓存

if($type=='hot'||$type=='com'||$type=='new'||$type=='lastview'||$type=='like')
{
	if($f_id)
	{
		if(is_numeric($f_id)){
			$SQL=" fid=$f_id ";
		}else{
			$detail=explode(",",$f_id);
			$SQL=" fid IN ( ".implode(",",$detail)." ) ";
		}
	}
	else
	{
		$SQL=" 1 ";
	}

	if($type=='com')
	{
		$SQL.=" AND levels=1 ";
		$ORDER=' list ';
		$_INDEX=" USE INDEX ( list ) ";
	}
	elseif($type=='hot')
	{
		$ORDER=' hits ';
		$_INDEX=" USE INDEX ( hits ) ";
	}
	elseif($type=='new')
	{
		$ORDER=' list ';
		$_INDEX=" USE INDEX ( list ) ";
	}
	elseif($type=='lastview')
	{
		$ORDER=' lastview ';
		$_INDEX=" USE INDEX ( lastview ) ";
	}
	elseif($type=='like')
	{
		
		$SQL.=" AND id!='$id' ";

		if(!$keyword)
		{
			extract($db->get_one("SELECT keywords AS keyword FROM {$_pre}content WHERE id='$id'"));
		}

		if($keyword){
			$SQL.=" AND ( ";
			$keyword=urldecode($keyword);
			$detail=explode(" ",$keyword);
			unset($detail2);
			foreach( $detail AS $key=>$value){
				$detail2[]=" BINARY title LIKE '%$value%' ";
			}
			$str=implode(" OR ",$detail2);
			$SQL.=" $str ) ";
		}else{
			$SQL.=" AND 0 ";
		}
		
		$_INDEX=" USE INDEX ( list ) ";
		$ORDER=' list ';
	}

	$SQL=" $_INDEX WHERE $SQL AND yz=1 ORDER BY $ORDER DESC LIMIT $rows";
	$which='*';
	$_target=$target?'_blank':'_self';
	if($path){
		$_path=preg_replace("/(.*)\/([^\/]+)/is","\\1/",$WEBURL);
	}
	if($icon==1){
		$_icon="·";
	}else{
		$_icon="&nbsp;";
	}
	$listdb=listcontent($SQL,$which,$leng);
	foreach($listdb AS $key=>$rs)
	{
		$show.="$_icon<A target='$_target' HREF='{$_path}bencandy.php?fid=$rs[fid]&id=$rs[id]' title='$rs[full_title]'>$rs[title]</A><br>";
	}
	if(!$show){
		$show="暂无...";
	}
	
	$show=str_Replace("'",'"',$show);
	$show=str_Replace("\r",'',$show);
	$show=str_Replace("\n",'',$show);
	


	$show="document.write('$show');";
	echo $show;
}
elseif($type=='sonfid')
{
	$fid && $rs=$db->get_one("SELECT fup FROM {$_pre}sort WHERE fid='$fid'");
	$show=get_fidsNames($rs[fup],$cType,$rows,$class?$class:3);

	if(!$show){
		$show="暂无...";
	}
	$show="<ul>$show</ul>";
	$show=str_Replace("'",'"',$show);
	$show=str_Replace("\r",'',$show);
	$show=str_Replace("\n",'',$show);
	
	$show="document.write('$show');";
	echo $show;
}
else
{
	die("document.write('指定的类型不存在');");
}


function get_fids($fid,$type){
	global $db,$pre;
	$fid=intval($fid);
	$F[]=" fid=$fid ";
	$query = $db->query("SELECT fid FROM {$_pre}sort WHERE fup=$fid");
	while($rs = $db->fetch_array($query)){
		$F[]=" fid=$rs[fid] ";
	}
	return $F;
}

//$fid,获取本FID的子栏目,$rows=15,只获取多少个子栏目,$class=2,显示多少级子栏目
function get_fidsNames($fid,$type,$rows=15,$class=2,$_Class=0){
	global $db,$pre,$webdb;
	if( !$class ){
		return '';
	}
	$_Class++;
	$class--;
	$query = $db->query("SELECT fid,name,fup,sons FROM {$_pre}sort WHERE fup='$fid' ORDER BY list DESC LIMIT $rows");
	while($rs = $db->fetch_array($query))
	{
		$icon='';
		for($i=1;$i<$_Class;$i++){
			$icon.='&nbsp;&nbsp;';
		}
		if($rs[sons])
		{
			if($class==0){
				$icon.="<A>+</A>";
			}else{
				$icon.="<A onclick=showSonName($rs[fid]) style=cursor:hand>+</A>";
			}
		}
		else
		{
			$icon.='<a>&nbsp;</a>';
		}
		$display=$_Class==1?'':'none';
		if($webdb[NewsMakeHtml]==1){
			$truepath=$webdb["{$type}_url"]."/";
		}else{
			$truepath="";
		}
		$show.="<div style=display:$display class=SonName$rs[fup]>{$icon}【<A HREF='{$truepath}list.php?fid=$rs[fid]'>{$rs[name]}</A>】</div>";
		if($rs[sons])
		{
			$show.=get_fidsNames($rs[fid],$type,$rows,$class,$_Class);
		}
	}
	return $show;
}

function listcontent($SQL,$which='*',$leng=40){
	global $db,$_pre;
	$query=$db->query("SELECT $which FROM {$_pre}content $SQL");
	while( $rs=$db->fetch_array($query) ){
		//$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤掉
		//$rs[content]=get_word($rs[full_content]=$rs[content],100);
		$rs[title]=get_word($rs[full_title]=$rs[title],$leng);
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		if($rs[picurl]){
			$rs[picurl]=tempdir($rs[picurl]);
		}
		$listdb[]=$rs;
	}
	return $listdb;
}



?>