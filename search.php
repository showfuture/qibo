<?php
require(dirname(__FILE__)."/f/global.php");

$GuideFid[$fid]=" -&gt;  <A HREF='index.php'>{$webdb[webname]}首页</A>";

$field_db = $module_DB[$mid][field];

$type = filtrate($type);
$keyword = filtrate($keyword);

if($action=="search")
{

	$search_url='';
	if(!$webdb[Info_allowGuesSearch]&&!$lfjid)
	{
		showerr("请先登录");
	}

	$keyword=trim($keyword);
	$keyword=str_replace("%",'\%',$keyword);
	$keyword=str_replace("_",'\_',$keyword);

	if(!$keyword)
	{
		showerr("关键字不能为空!");
	}
	if($Fid_db[tableid]&&!$fid){
		showerr("请选择一个栏目!");
	}
	$_erp=$Fid_db[tableid][$fid];

	/*每页显示50条*/
	$rows=50;
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rows;

	/*没指定模块或模块辅信息表不存在时,将搜索所有信息*/
	if(!$mid||!$field_db)
	{
		if($keyword){
			if(in_array($type,array("title","address","username","telephone","mobphone","email","oicq","msn")))
			{
				$field="A.$type";
			}
			else
			{
				$type='title';
				$field="A.title";
			}
			$_SQL=" BINARY $field LIKE '%$keyword%' ";
		}else{
			$_SQL=" 1 ";
		}

		if($postdb[street_id]){
			$_SQL.=" AND A.street_id='$postdb[street_id]' ";
		}elseif($postdb[zone_id]){
			$_SQL.=" AND A.zone_id='$postdb[zone_id]' ";
		}elseif($postdb[city_id]){
			$city_check=' checked ';
			$_SQL.=" AND A.city_id='$postdb[city_id]' ";
		}

		if($fid>0){
			$_SQL.=" AND A.fid='$fid' ";
		}

		foreach( $postdb AS $key=>$value)
		{
			$search_url.="&postdb[{$key}]=$value";
		}

		 

		$SQL="SELECT SQL_CALC_FOUND_ROWS * FROM {$_pre}content$_erp A WHERE $_SQL ORDER BY A.posttime DESC LIMIT $min,$rows ";
	}
	else
	{
		if($keyword){
			if(in_array($type,array("title","address","username","telephone","mobphone","email","oicq","msn")))
			{
				$field="A.$type";
			}
			elseif( $type && $field_db[$type] )
			{
				$field="B.$type";
			}
			else
			{
				$type='title';
				$field="A.title";
			}
			$_SQL=" BINARY $field LIKE '%$keyword%' ";
		}else{
			$_SQL=" 1 ";
		}

		if($postdb[street_id]){
			$_SQL.=" AND A.street_id='$postdb[street_id]' ";
		}elseif($postdb[zone_id]){
			$_SQL.=" AND A.zone_id='$postdb[zone_id]' ";
		}elseif($postdb[city_id]){
			$_SQL.=" AND A.city_id='$postdb[city_id]' ";
		}

		if($fid>0){
			$_SQL.=" AND A.fid='$fid' ";
		}
	
		
		foreach( $postdb AS $key=>$value){		
			if(!$field_db[$key]||$value==''){
				continue;
			}
			if(is_array($value)&&$field_db[$key]['form_type']=='checkbox'){
				$_ASQL='';
				$_BSQL='';
				foreach($value AS $v){
					$v = filtrate($v);
					$_ASQL.=" AND BINARY B.`$key` LIKE '%/#/$v/#/%' ";
					$_BSQL.=($_BSQL?' OR ':'')." BINARY B.`$key` LIKE '%/#/$v/#/%' ";
					$rsdb[$key][$v]=" checked ";
					$v=urlencode($v);
					$search_url.="&postdb[{$key}][]=$v";
				}
				$_SQL.=$check_select_type==1?$_ASQL:" AND ($_BSQL) ";
			}else{	
				$value = filtrate($value);
				$_SQL.="  AND BINARY B.`$key`='$value' ";
				$rsdb[$key][$value]=" selected ";
				$value=urlencode($value);
				$search_url.="&postdb[{$key}]=$value";
			}			
		}	

		$SQL="SELECT SQL_CALC_FOUND_ROWS A.*,B.* FROM {$_pre}content$_erp A LEFT JOIN {$_pre}content_$mid B ON A.id=B.id WHERE A.mid='$mid' AND $_SQL ORDER BY A.posttime DESC LIMIT $min,$rows ";
	}

	$query = $db->query("$SQL");
	$RS=$db->get_one("SELECT FOUND_ROWS()");
	$totalNum=$RS['FOUND_ROWS()'];
	while($rs = $db->fetch_array($query))
	{
		$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
		$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);
		$rs[content]=get_word($rs[content],150);
		if(!$rs[username])
		{
			$detail=explode(".",$rs[ip]);
			$rs[username]="$detail[0].$detail[1].$detail[2].*";
		}
		$field_db && $Module_db->showfield($field_db,$rs,'list');
		$listdb[]=$rs;
	}

	$showpage=getpage("","","?mid=$mid&fid=$fid&keyword=$keyword&action=search&type=$type$search_url",$rows,$totalNum);

	if(!$listdb)
	{
		//showerr("很抱歉，没有找到你要查询的内容");
	}
	$typedb[$type]=" checked ";
}

else
{
	$typedb[title]=" checked ";
}

$mid=intval($mid);

$module_select="<select name='mid' onChange=\"window.location.href='?mid='+this.options[this.selectedIndex].value\"><option value='0'  style='color:#aaa;'>所有模型</option>";
foreach($module_db AS $key=>$value){
	$ckk=$mid==$key?' selected ':' ';
	$module_select.="<option value='$key' $ckk>$value</option>";
}
$module_select.="</select>";

if($mid){
	$SQL=" AND mid='$mid' ";
}else{
	$SQL="";
}

$fid_select="<select name='fid' onChange=\"if(this.options[this.selectedIndex].value=='-1'){alert('你不能选择大分类');}\"><option value='0' style='color:#aaa;'>所有栏目</option>";
foreach( $Fid_db[0] AS $key=>$value){
	$fid_select.="<option value='-1' style='color:red;'>$value</option>";
	foreach( $Fid_db[$key] AS $key2=>$value2){
		$ckk=$fid==$key2?' selected ':' ';
		$fid_select.="<option value='$key2' $ckk>&nbsp;&nbsp;|--$value2</option>";
	}
}
$fid_select.="</select>";

$postdb[city_id]	&&	$city_id	=	$postdb[city_id];
$postdb[street_id]	&&	$street_id	=	$postdb[street_id];
$postdb[zone_id]	&&	$zone_id	=	$postdb[zone_id];

@include_once(ROOT_PATH."data/zone/$city_id.php");

$city_fid=select_where("{$_pre}city","'postdb[city_id]'  onChange=\"choose_where('getzone',this.options[this.selectedIndex].value,'','1','')\"",$city_id);

require(Mpath."inc/head.php");
require(html("search_".intval($mid)));
require(Mpath."inc/foot.php");

//过滤母模板当中的自定义字段
ob_end_clean();
$content=preg_replace("/<!--{choose}-->(.*?)<!--{\/choose}-->/is","",$content);
$content=preg_replace("/<!--{select}-->(.*?)<!--{\/select}-->/is","",$content);
$content=preg_replace("/<!--{template}-->(.*?)<!--{\/template}-->/is","",$content);
echo $content;

?>