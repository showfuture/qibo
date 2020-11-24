<?php
!function_exists('html') && exit('ERR');

if($action=='mod'){
	$sqlmin=intval($start_num)-1; $sqlmin<0 && $sqlmin=0;

	$Fid_db = include(ROOT_PATH."data/all_fid.php");

	//选择显示两列以上,这里选择Table,否则不一定能显示效果,选择table指外套一个TABLE,选择div指不套多余的代码
	if($colspan>1){
		$DivTpl=0;
	}else{
		$DivTpl=1;
	}	
	
	$postdb[tplpart_1code]=str_replace($url1,$url2,StripSlashes($tplpart_1));
	$postdb[tplpart_2code]=str_replace($url1,$url2,StripSlashes($tplpart_2));

	//使用在线编辑器后,去掉多余的网址
	$weburl=preg_replace("/(.*)\/([^\/]+)/is","\\1/",$WEBURL);
	$postdb[tplpart_1code]=str_replace($weburl,"",$postdb[tplpart_1code]);
	$postdb[tplpart_2code]=str_replace($weburl,"",$postdb[tplpart_2code]);

	/*判断是否是显示图片类型*/
	if($stype=="rollpic"||$stype=="r"||strstr($postdb[tplpart_1code],'$picurl')){
		$SQL=" WHERE ispic=1 AND city_id='\$GLOBALS[city_id]' ";
	}else{
		$SQL=" WHERE city_id='\$GLOBALS[city_id]' ";
	}

	if($rowspan<1){
		$rowspan=1;
	}
	if($colspan<1){
		$colspan=1;
	}
	$rows=$rowspan*$colspan;

	if(is_numeric($yz)){
		$SQL.=" AND yz=$yz ";
	}
	if(is_numeric($levels)){
		$SQL.=" AND levels=$levels ";
	}
	if($moduleid){
		$SQL.=" AND mid='$moduleid' ";
	}

	$cityId='$GLOBALS[city_id]';	//限制只能显示当前城市的信息
	if($cityId){
		$SQL.=" AND city_id='$cityId' ";
	}
	$fiddb_string="";
	if($fiddb){
		foreach($fiddb AS $key=>$value){
			if(!is_numeric($value)){
				unset($fiddb[$key]);
			}
		}
		$fiddb_string=implode(",",$fiddb);

		$fiddb_string && $SQL.=" AND fid IN ($fiddb_string) ";
	}
	$i=$sql_DB='';
	$sql_DB[]="(SELECT * FROM {$_pre}content $SQL)";
	foreach( $Fid_db[tableid] AS $key=>$value){
		if($fiddb&&!in_array($key,$fiddb)){
			continue;
		}
		$i++;
		$sql_DB[$value]="(SELECT * FROM {$_pre}content$value $SQL)";
	}
	if($i&&$i==count($fiddb)){
		unset($sql_DB[0]);
	}
	
	$SQL=implode(" UNION ALL ",$sql_DB)." ORDER BY $order $asc LIMIT $sqlmin,$rows ";

	if(count($sql_DB)>1){
		extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}db"));
		if($NUM>10000){
			showerr("大于指定信息量时,你只能选择同类分表的栏目,不同类分表的栏目不允许同时调用,否则极其影响速度");
		}
	}

	if($yz=='ad'){
		if($cityId){
			$SQL=" AND A.cityid='$cityId' ";
		}else{
			$SQL=" ";
		}
		$SQL="SELECT C.*,D.* FROM {$_pre}buyad A LEFT JOIN {$_pre}db D ON A.id=D.id LEFT JOIN {$_pre}content C  ON D.id=C.id WHERE A.sortid=-1 AND A.endtime>\$GLOBALS[timestamp] $SQL LIMIT $sqlmin,$rows";
	}

	if(strstr($postdb[tplpart_1code],'$picurl')&&strstr($postdb[tplpart_1code],'$content')){
		$stype="cp";
	}elseif(strstr($postdb[tplpart_1code],'$content')){
		$stype="c";
	}elseif(strstr($postdb[tplpart_1code],'$picurl')){
		$stype="p";
	}

	$postdb[SYS]='fenlei';
	$postdb[wninfo]=str_replace("$pre","",$_pre);
	$postdb[typefid]=$_typefid;

	$postdb[cityId]=$cityId;

	$postdb[width]=$width;
	$postdb[height]=$height;
	$postdb[rolltype]=$rolltype;
	$postdb[rolltime]=$rolltime;
	$postdb[roll_height]=$roll_height;

	$postdb[content_num]=$content_num;
	
	$postdb[newhour]=$newhour;
	$postdb[hothits]=$hothits;

	$postdb[tplpath]=$tplpath;
	$postdb[DivTpl]=$DivTpl;
	$postdb[fiddb]=$fiddb;
	$postdb[moduleid]=$moduleid;
	$postdb[stype]=$stype;
	$postdb[yz]=$yz;
	$postdb[timeformat]=$timeformat;
	$postdb[order]=$order;
	$postdb[asc]=$asc;
	$postdb[levels]=$levels;
	$postdb[rowspan]=$rowspan;
	$postdb[sql]=$SQL;
	$postdb[colspan]=$colspan;
	$postdb[titlenum]=$titlenum;
	$postdb[titleflood]=$titleflood; $postdb[start_num]=$start_num;
	
	$code=addslashes(serialize($postdb));
	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=1;
	
	//插入或更新标签库
	do_post();

}else{
	$modulename=$ModuleDB[str_replace("Info_","",$inc)][name];
	$rsdb=get_label();
	$div=unserialize($rsdb[divcode]);
	@extract($div);
	$codedb=unserialize($rsdb[code]);
	@extract($codedb);
	if(!isset($yz)){
		$yz="all";
	}
	if(!isset($is_com)){
		$is_com="all";
	}
	if(!isset($order)){
		$order="posttime";
	}
	$titleflood=(int)$titleflood;
	$hide=(int)$rsdb[hide];
	if($rsdb[js_time]){
		$js_ck='checked';
	}

	/*默认值*/
	$yz || $yz='all';
	$asc || $asc='DESC';
	$titleflood!=1		&& $titleflood=0;
	$timeformat			|| $timeformat="Y-m-d H:i:s";
	$rowspan			|| $rowspan=5;
	$colspan			|| $colspan=1;
	$titlenum			|| $titlenum=20;
	$div_w				|| $div_w=50;
	$div_h				|| $div_h=30;
	$hide!=1			&& $hide=0;
	$DivTpl!=1			&& $DivTpl=0;
	$stype				|| $stype=4;
	$content_num		|| $content_num=80;
	$width				|| $width=250;
	$height				|| $height=187;
	$roll_height		|| $roll_height=50;
	$newhour	|| $newhour=24;
	$hothits	|| $hothits=30;

	$rolltime			|| $rolltime=3;

	$_rolltype[$rolltype]=' selected ';



	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;

	$yzdb[$yz]="checked";
	$ascdb[$asc]="checked";
	$orderdb[$order]=" selected ";
	$levelsdb[$levels]=" selected ";
	$titleflooddb["$titleflood"]="checked"; 
	$start_num>0 || $start_num=1; $start_num>0 || $start_num=1;
	$hidedb[$hide]="checked";
	$divtpldb[$DivTpl]="checked";
	$stypedb[$stype]=" checked ";
	$fiddb=$codedb[fiddb];
	
	if( is_table("{$_pre}module") ){
		$select_module="<select name='moduleid'><option value=''>请选择</option>";
		$query = $db->query("SELECT * FROM {$_pre}module ORDER BY id DESC");
		while($rs = $db->fetch_array($query)){
			$ck=$rs[id]==$codedb[moduleid]?' selected ':' ';
			$select_module.="<option value='$rs[id]' $ck>$rs[name]</option>";
		}
		$select_module.="</select>";
	}
	
	@extract($db->get_one("SELECT COUNT(*) AS SORTNUM FROM {$_pre}sort"));
	if($SORTNUM<2000)
	{
		update_class(0,0);
		$select_sort=$Guidedb->Checkbox("{$_pre}sort",'fiddb[]',$fiddb);
	}
	
	$ck_typefid[fid]=' checked ';

	
	$tplpart_1=str_replace("&nbsp;","&amp;nbsp;",$tplpart_1);
	$tplpart_2=str_replace("&nbsp;","&amp;nbsp;",$tplpart_2);

	$getLabelTpl=getLabelTpl('info',array("common_title","common_pic","common_content","common_fname"));


	require("head.php");
	require(dirname(__FILE__)."/"."template/label/set.htm");
	require("foot.php");

}


/*更新栏目的CLASS数值*/
function update_class($fid,$Class){
	global $db,$_pre,$IS_BIZ;
	//$IS_BIZ || die();
	$Class++;
	$db->query("UPDATE {$_pre}sort SET class=$Class WHERE fid='$fid'");
	$query=$db->query("SELECT fid FROM {$_pre}sort WHERE fup='$fid'");
	while( $rs=$db->fetch_array($query) ){
		update_class($rs[fid],$Class);
	}
}


?>