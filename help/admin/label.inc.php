<?php
!function_exists('html') && exit('ERR');

if($action=='mod'){
	$sqlmin=intval($start_num)-1; $sqlmin<0 && $sqlmin=0;
	
	//模板1是基本的.模板二是辅助的.实现多样化效果
	$postdb[tplpart_1code]=StripSlashes($tplpart_1);
	$postdb[tplpart_2code]=StripSlashes($tplpart_2);

	//使用在线编辑器后,去掉多余的网址
	$weburl=preg_replace("/(.*)\/([^\/]+)/is","\\1/",$WEBURL);
	$postdb[tplpart_1code]=str_replace($weburl,"",$postdb[tplpart_1code]);
	$postdb[tplpart_2code]=str_replace($weburl,"",$postdb[tplpart_2code]);
 
	//针对一些自定义的模板做类型判断
	if(strstr($postdb[tplpart_1code],'$picurl')&&strstr($postdb[tplpart_1code],'$content')){
		$stype="cp";
	}elseif(strstr($postdb[tplpart_1code],'$content')){
		$stype="c";
	}elseif(strstr($postdb[tplpart_1code],'$picurl')){
		$stype="p";
	}

	//选择显示两列以上,这里选择Table,否则不一定能显示效果,选择table指外套一个TABLE,选择div指不套多余的代码
	if($colspan>1){
		$DivTpl=0;
	}else{
		$DivTpl=1;
	}

	if($rowspan<1){
		$rowspan=1;
	}
	if($colspan<1){
		$colspan=1;
	}
	$rows=$rowspan*$colspan;
	
	//有辅助模板时,要加多一条,方便获取其中一条数据
	if($postdb[tplpart_2code]){
		$rows++;
	}

	if($postdb['allcity']){	//调用全国数据
		$SQL=" WHERE 1 ";
	}else{
		$SQL=" WHERE A.city_id='\$GLOBALS[city_id]' ";
	}


	if($yz==1){
		$SQL.=" AND A.yz=1 ";
	}

	if($levels==1){
		$SQL.=" AND A.levels=1 ";
	}
	if($fidtype==1){
		$SQL.=" AND A.fid = '\$GLOBALS[fid]' ";
	}elseif($fiddb[0]){
		//if($webdb[articleNUM]>10000&&count($fiddb)>20){
		//	showmsg("你的内容大于10000条,请不要同时选择超过20个栏目,否则很影响速度!");
		//}
		foreach($fiddb AS $key=>$value){
			if(!is_numeric($value)){
				unset($fiddb[$key]);
			}
		}
		$fids=implode(",",$fiddb);
		$fids && $SQL.=" AND A.fid IN ($fids) ";
	}
	
	//指定显示某些模型的内容
	//if(!$fiddb&&$amodule!='-1'){
		//$SQL.=" AND A.mid='$amodule' ";
	//}



	//$stype=="r"幻灯片,$picurl显示图片,如果主模板有图片的话.辅助模板也自动要有图片
	if($stype=="r"||strstr($postdb[tplpart_1code],'$picurl')){
		$SQL.=" AND A.ispic=1 ";
	}
	
	//特别处理,如果是幻灯片的话,要取消辅助模板
	$stype=="r" && $postdb[tplpart_2code]='';
	
	//有辅助模板的话,要特别处理.如果仅是辅助模板有图片的话,就要读多一条数据,否则的话.都是从主模板获取.
	if(strstr($postdb[tplpart_2code],'$picurl')&&!strstr($postdb[tplpart_1code],'$picurl'))
	{
		if(strstr($postdb[tplpart_2code],'$content')){
			$SQL2=" SELECT A.*,R.content FROM {$_pre}content A LEFT JOIN {$_pre}content_1 R ON A.id=R.id $SQL AND A.ispic=1 ORDER BY $order $asc LIMIT $sqlmin,1 ";
		}else{
			$SQL2=" SELECT A.* FROM {$_pre}content A $SQL AND A.ispic=1 ORDER BY $order $asc LIMIT $sqlmin,1 ";
		}		
	}
	
	//主模板中有图片
	if( strstr($postdb[tplpart_1code],'$picurl') ){
		$SQLPIC=" AND A.ispic=1 ";
	}
	//主模板,即使有辅助模板,不同时为图片的话.都从主表读取,避免多读一次数据库
	if( strstr($postdb[tplpart_1code],'$content')||strstr($postdb[tplpart_2code],'$content') ){
		$SQL=" SELECT A.*,R.content FROM {$_pre}content A LEFT JOIN {$_pre}content_1 R ON A.id=R.id $SQL $SQLPIC ORDER BY $order $asc LIMIT $sqlmin,$rows ";
	}else{
		$SQL=" SELECT A.* FROM {$_pre}content A $SQL $SQLPIC ORDER BY $order $asc LIMIT $sqlmin,$rows ";
	}
	
	$postdb[SYS]='wn';
	$postdb[wninfo]=str_replace("$pre","",$_pre);
	$postdb[noReadMid]='';
	$postdb[RollStyleType]=$RollStyleType;


	$postdb[fidtype]=$fidtype;
	
	$postdb[rolltype]=$rolltype;
	$postdb[rolltime]=$rolltime;
	$postdb[roll_height]=$roll_height;
	$postdb[width]=$width;
	$postdb[height]=$height;
	
	$postdb[newhour]=$newhour;
	$postdb[hothits]=$hothits;
	$postdb[amodule]=$amodule;
	$postdb[tplpath]=$tplpath;
	$postdb[DivTpl]=$DivTpl;
	$postdb[fiddb]=$fids;
	$postdb[stype]=$stype;
	$postdb[yz]=$yz;
	$postdb[hidefid]=$hidefid;
	$postdb[timeformat]=$timeformat;
	$postdb[order]=$order;
	$postdb[asc]=$asc;
	$postdb[levels]=$levels;
	$postdb[rowspan]=$rowspan;
	$postdb[sql]=$SQL;			//主模板
	$postdb[sql2]=$SQL2;		//辅助模板
	$postdb[colspan]=$colspan;
	$postdb[content_num]=$content_num;
	$postdb[content_num2]=$content_num2;
	$postdb[titlenum]=$titlenum;
	$postdb[titlenum2]=$titlenum2;
	$postdb[titleflood]=$titleflood; $postdb[start_num]=$start_num;

	$postdb[c_rolltype]=$c_rolltype;
	//print_r($postdb);exit;
	$code=addslashes(serialize($postdb));
	$div_db[div_w]=$div_w;
	$div_db[div_h]=$div_h;
	$div_db[div_bgcolor]=$div_bgcolor;
	$div=addslashes(serialize($div_db));
	$typesystem=1;
	//插入或更新标签库
	do_post();

}else{

	$rsdb=get_label();
	$div=unserialize($rsdb[divcode]);
	@extract($div);
	$codedb=unserialize($rsdb[code]);
	@extract($codedb);
	
	if(!isset($levels)){
		$levels="all";
	}
	if(!isset($order)){
		$order="list";
	}
	$titleflood=(int)$titleflood;
	$hide=(int)$rsdb[hide];
	if($rsdb[js_time]){
		$js_ck='checked';
	}

	/*默认值*/
	$yz=='all' || $yz=1;
	$asc || $asc='DESC';
	$titleflood!=1		&& $titleflood=0;
	$timeformat			|| $timeformat="Y-m-d H:i:s";
	$rowspan			|| $rowspan=5;
	$colspan			|| $colspan=1;
	$titlenum			|| $titlenum=20;
	$content_num		|| $content_num=80;
	$div_w				|| $div_w=50;
	$div_h				|| $div_h=30;
	$hide!=1			&& $hide=0;
	$DivTpl!=1			&& $DivTpl=0;
	$stype				|| $stype=4;

	$width				|| $width=250;
	$height				|| $height=187;
	$roll_height		|| $roll_height=50;
	
	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;
	$yzdb[$yz]="checked";
	$ascdb[$asc]="checked";
	$orderdb[$order]=" selected ";
	$levelsdb[$levels]=" checked ";
	$titleflooddb["$titleflood"]="checked"; 
	$start_num>0 || $start_num=1;
	$hidedb[$hide]="checked";
	$divtpldb[$DivTpl]="checked";

	$fidtypedb[intval($fidtype)]=' checked ';

	$_hidefid[intval($hidefid)]=" checked ";
	$fiddb=explode(",",$codedb[fiddb]);
	
	$c_rolltype || $c_rolltype=0;
	$newhour	|| $newhour=24;
	$hothits	|| $hothits=100;

	$titlenum2			|| $titlenum2=40;
	$content_num2		|| $content_num2=120;
	$rolltime			|| $rolltime=3;

	$_rolltype[$rolltype]=' selected ';

	$c_rolltypedb[$c_rolltype]=" checked ";

 	$select_news=$Guidedb->Checkbox("{$_pre}sort",'fiddb[]',$fiddb);
	
	$tplpart_1=str_replace("&nbsp;","&amp;nbsp;",$tplpart_1);
	$tplpart_2=str_replace("&nbsp;","&amp;nbsp;",$tplpart_2);
 
	$getLabelTpl=getLabelTpl($inc,array("common_pic","common_content","common_fname","common_zh_title","common_zh_pic","common_zh_content"));


	//幻灯片样式
	$rollpicStyle="<select name='RollStyleType' id='RollStyleType' onChange='rollpictypes(this)'><option value=''>默认</option>";
	$dir=opendir(ROOT_PATH."template/default/rollpic/");
	while($file=readdir($dir)){
		if(eregi("\.htm$",$file)){
			$rollpicStyle.="<option value='$file'>".str_replace(".htm","",$file)."</option>";
		}
	}
	$rollpicStyle.="</select>";
	
	require("head.php");
	require(dirname(__FILE__)."/template/label/article.htm");
	require("foot.php");
}
?>