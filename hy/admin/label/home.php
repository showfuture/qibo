<?php
!function_exists('html') && exit('ERR');

if($action=='mod'){
	$sqlmin=intval($start_num)-1; $sqlmin<0 && $sqlmin=0;

	//选择显示两列以上,这里选择Table,否则不一定能显示效果,选择table指外套一个TABLE,选择div指不套多余的代码
	if($colspan>1){
		$DivTpl=0;
	}else{
		$DivTpl=1;
	}
	$url2='$webdb[www_url]/home/?uid=$uid';
	$postdb[tplpart_1code]=str_replace('$url',$url2,StripSlashes($tplpart_1));
	$postdb[tplpart_2code]=str_replace('$url',$url2,StripSlashes($tplpart_2));

	//使用在线编辑器后,去掉多余的网址
	$weburl=preg_replace("/(.*)\/([^\/]+)/is","\\1/",$WEBURL);
	$postdb[tplpart_1code]=str_replace(array($weburl),array(""),$postdb[tplpart_1code]);
	$postdb[tplpart_2code]=str_replace(array($weburl),array(""),$postdb[tplpart_2code]);

	$postdb[tplpart_1code]=En_TruePath($postdb[tplpart_1code]);
	$postdb[tplpart_2code]=En_TruePath($postdb[tplpart_2code]);


	/*判断是否是显示图片类型
	if($stype=="rollpic"||$stype=="r"||strstr($postdb[tplpart_1code],'$picurl')){
		$SQL=" WHERE picurl!='' ";
	}else{
		$SQL=" WHERE 1 ";
	}*/
	
	if($postdb['allcity']){	//调用全国数据
		$SQL=" WHERE 1 ";
	}else{
		$SQL=" WHERE A.city_id='\$GLOBALS[city_id]' ";
	}

	

	if($rowspan<1){
		$rowspan=1;
	}
	if($colspan<1){
		$colspan=1;
	}
	$rows=$rowspan*$colspan;

	if(is_numeric($yz)){
		$SQL.=" AND A.yz=$yz ";
	}
	if(is_numeric($renzheng)){
		$SQL.=" AND A.renzheng=$renzheng ";
	}
	if(is_numeric($levels)){
		$SQL.=" AND A.levels=$levels ";
	}


	$fiddb_string=$_SQL="";
	if($fiddb){
		foreach($fiddb AS $key=>$value){
			if(!is_numeric($value)){
				unset($fiddb[$key]);
			}
		}
		$fiddb_string=implode(",",$fiddb);

		if($fiddb_string){
			$SQL.=" AND B.fid IN ($fiddb_string) ";
			$_SQL=" LEFT JOIN {$_pre}company_fid B ON A.uid=B.uid ";
		} 
	}


	$SQL="SELECT A.* FROM {$_pre}company A $_SQL $SQL ORDER BY $order $asc LIMIT $sqlmin,$rows ";

	if(strstr($postdb[tplpart_1code],'$picurl')&&strstr($postdb[tplpart_1code],'$content')){
		$stype="cp";
	}elseif(strstr($postdb[tplpart_1code],'$content')){
		$stype="c";
	}elseif(strstr($postdb[tplpart_1code],'$picurl')){
		$stype="p";
	}

	$postdb[SYS]='company';
	//$postdb[wninfo]=str_replace("$pre","",$_pre);
	$postdb[typefid]=$_typefid;
	$postdb[ctype]='home';	//本频道的商家


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
	$postdb[renzheng]=$renzheng;
	$postdb[timeformat]=$timeformat;
	$postdb[order]=$order;
	$postdb[asc]=$asc;
	$postdb[levels]=$levels;
	$postdb[rowspan]=$rowspan;
	$postdb[sql]=$SQL;
	$postdb[colspan]=$colspan;
	$postdb[titlenum]=$titlenum;
	$postdb[titleflood]=$titleflood; $postdb[start_num]=$start_num;

	$postdb[c_rolltype]=$c_rolltype;
	
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
	$renzheng || $renzheng='all';
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

	$c_rolltype || $c_rolltype=0;
	$c_rolltypedb[$c_rolltype]=" checked ";



	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;

	$renzhengdb[$renzheng]="checked";
	$yzdb[$yz]="checked";
	$ascdb[$asc]="checked";
	$orderdb[$order]=" selected ";
	$levelsdb[$levels]=" selected ";
	$titleflooddb["$titleflood"]="checked"; 
	$start_num>0 || $start_num=1;
	$hidedb[$hide]="checked";
	$divtpldb[$DivTpl]="checked";
	$stypedb[$stype]=" checked ";
	$fiddb=$codedb[fiddb];
 	$select_sort=$Guidedb->Checkbox("{$_pre}sort",'fiddb[]',$fiddb);
	



	$tplpart_1code=str_replace("&nbsp;","&amp;nbsp;",En_TruePath($tplpart_1code,0));
	$tplpart_2code=str_replace("&nbsp;","&amp;nbsp;",En_TruePath($tplpart_2code,0));

	$getLabelTpl=getLabelTpl('info',array("common_title","common_pic","common_content","common_fname"));

	require("head.php");
	require(dirname(__FILE__)."/../template/label/home.htm");
	require("foot.php");

}


?>