<?php
define('SYS_TYPE','hy');
define('Mpath',dirname(__FILE__).'/');
define( 'Mdirname' , preg_replace("/(.*)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );

require_once(Mpath."../inc/common.inc.php");
require_once(Mpath."data/config.php");			//系统全局变量
@include_once(ROOT_PATH."data/ad_cache.php");	//全站广告变量缓存文件
@include_once(ROOT_PATH."data/label_hf.php");	//标签的头与底的变量值


@include(Mpath."data/guide_fid.php");			//导航条

$Fid_db = include(Mpath."data/all_fid.php");		//栏目的名称

$_pre="{$pre}{$webdb[module_pre]}";					//数据表前缀

$Murl=$webdb[www_url].'/'.Mdirname;					//本模块的访问地址
$Mdomain=$ModuleDB[$webdb[module_pre]][domain]?$ModuleDB[$webdb[module_pre]][domain]:$Murl;



/**
*前台是否开放
**/
if($webdb[module_close]){
	$webdb[Info_closeWhy]=str_replace("\r\n","<br>",$webdb[Info_closeWhy]);
	showerr("本系统暂时关闭:$webdb[Info_closeWhy]");
}


unset($foot_tpl,$head_tpl,$index_tpl,$list_tpl,$bencandy_tpl);
$ch=intval($ch);
$fid=intval($fid);
$id=intval($id);
$page=intval($page);


$fendb=array();

$fendb[fen1][name]="总评";
$fendb[fen2][name]="环境";
$fendb[fen3][name]="服务";
$fendb[fen4][name]="价位";
$fendb[fen5][name]="喜欢程度";

$fendb[fen1][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen2][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen3][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen4][set]="1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵";
$fendb[fen5][set]="1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢";

$choose_class['hy']=true;

$GuideFid[$fid]=" -&gt; <A HREF='$Mdomain/'>黄页</A> {$GuideFid[$fid]}";


/**
*主要提供给城市,区域,地段的选择使用
**/
function select_where($table,$name='fup',$ck='',$fup=''){
	global $db,$city_DB;
	/*
	if($fup){
		$SQL=" WHERE fup='$fup' ";
	}
	$query = $db->query("SELECT * FROM $table $SQL ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$ck==$rs[fid]?" selected ":" ";
		$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
	}
	*/
	if(!$fup){
		foreach( $city_DB[name] AS $key=>$value){
			$ckk=$ck==$key?" selected ":" ";
			$show.="<option value='$key' $ckk>$value</option>";
		}
	}elseif($fup){
		if(strstr($name,'zone')&&is_file(Mpath."php168/zone/$fup.php")){
			include(Mpath."php168/zone/$fup.php");
			foreach( $zone_DB[name] AS $key=>$value){
				$ckk=$ck==$key?" selected ":" ";
				$show.="<option value='$key' $ckk>$value</option>";
			}
		}else{
			$query = $db->query("SELECT * FROM $table WHERE fup='$fup' ORDER BY list DESC");
			while($rs = $db->fetch_array($query)){
				$ckk=$ck==$rs[fid]?" selected ":" ";
				$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
			}
		}
	}
	return "<select id='$table' name=$name><option value=''>请选择</option>$show</select>";
}

/**
*获取模板的函数
**/
function getTpl($html,$tplpath=''){
	global $STYLE;
	if($tplpath&&file_exists($tplpath)){
		return $tplpath;
	}elseif($tplpath&&file_exists(Mpath.$tplpath)){
		return Mpath.$tplpath;
	}elseif(file_exists(Mpath."template/$STYLE/$html.htm")){
		return Mpath."template/$STYLE/$html.htm";
	}else{
		return Mpath."template/default/$html.htm";
	}
}







function fen_value($title,$set,$v){
	global $webdb;
	$shows="";
	$detail=explode("\r\n",$set);
	foreach( $detail AS $key=>$value){
		$d=explode("=",$value);
		if($d[0]==$v){
			$va ="$d[1]";
		}
	}
	$shows.=" <span class='title'>$title:</span>";
	for($i=0;$i<$v;$i++){
		$shows.="<img alt='$va' src='$webdb[www_url]/images/default/icon_star_2.gif'>";
	}
	for($j=(count($detail)-$i);$j>0 ;$j-- ){
		$shows.="<img alt='$va' src='$webdb[www_url]/images/default/icon_star_1.gif'>";
	}
	return $shows;
}
function fen6_value($title,$set,$v){
	$array=explode(",",$v);
	$detail=explode("\r\n",$set);
	foreach( $detail AS $key=>$value){
		if(in_array($value,$array)){
			$va[] ="$value";
		}
	}
	if(!$va){
		return ;
	}
	$shows =" <span class='title'>{$title}：</span>";
	$shows.=implode(" ",$va);
	if($title){
		return $shows;
	}	
}

function get_dianping($rows=5,$leng=80){
	global $_pre,$pre,$db,$fendb,$city_id;
	$query=$db->query("SELECT A.*,C.title,D.icon FROM `{$_pre}dianping` A LEFT JOIN `{$_pre}company` C ON A.id=C.uid LEFT JOIN {$pre}memberdata D ON A.uid=D.uid WHERE C.city_id='$city_id' ORDER BY cid DESC LIMIT  $rows");
	while( $rs=$db->fetch_array($query) ){	
		$rs[fen]='';
		$rs[fen].=fen_value($fendb[fen1][name],$fendb[fen1][set],$rs[fen1]);
		$rs[fen].=fen_value($fendb[fen2][name],$fendb[fen2][set],$rs[fen2]);
		$rs[fen].=fen_value($fendb[fen3][name],$fendb[fen3][set],$rs[fen3]);
		$rs[fen].=fen_value($fendb[fen4][name],$fendb[fen4][set],$rs[fen4]);
		//$rs[fen].=fen_value($fendb[fen5][name],$fendb[fen5][set],$rs[fen5]);
		$rs[fen6]=fen6_value($fendb[fen6][name],$fendb[fen6][set],$rs[fen6]);
	
		$rs[icon] && $rs[icon]=tempdir($rs[icon]);
		if(!$rs[username]){		
			$detail=explode(".",$rs[ip]);
			$rs[username]="$detail[0].$detail[1].$detail[2].*";
		}

		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);

		$rs[full_content]=$rs[content];

		$rs[content]=get_word($rs[content],$leng); 

		$rs[content]=str_replace("<br>","",$rs[content]);

		$listdb[]=$rs;
	}
	return $listdb;
}


function get_company_list($type='new',$rows=10){
	global $db,$_pre,$pre;
	if($type=='new'){
		$order='rid';
	}elseif($type=='hot'){
		$order='hits';
	}elseif($type=='com'){
		$order='levelstime';
		$SQL = " WHERE levels='1' ";
	}
	$query = $db->query("SELECT * FROM {$_pre}company $SQL ORDER BY $order DESC LIMIT $rows");
	while($rs = $db->fetch_array($query)){
		$listdb[]=$rs;
	}
	return $listdb;
}

function seo_eval($a){
	return $a;
}
?>