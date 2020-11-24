<?php
!function_exists('html') && exit('ERR');
if($action=='mod'){
	$sqlmin=intval($start_num)-1; $sqlmin<0 && $sqlmin=0;

	
	$postdb[tplpart_1code]=StripSlashes($tplpart_1);
	$postdb[tplpart_2code]=StripSlashes($tplpart_2);

	$postdb[tplpart_1code]=En_TruePath($postdb[tplpart_1code]);
	
	
	$SQL=StripSlashes($my_sql);
	if(eregi('delete',$SQL)||eregi('update',$SQL)||eregi('TRUNCATE',$SQL)||eregi('DROP',$SQL)||eregi('INSERT',$SQL)){
		showmsg('MYSQL有误!');
	}
	$db->query($SQL);
	$msg=ob_get_contents();
	if(eregi('^数据库连接出错',$msg)){
		ob_end_clean();
		showmsg("Mysql语句有误,错误报告如下:<br><font color=red>$msg</font>");
	}
	if(strstr($postdb[tplpart_1code],'="$url"')){
		showmsg("你需要把\$url变量换成其它的,否则无法访问内容页");
	}

	//使用在线编辑器后,去掉多余的网址
	$weburl=preg_replace("/(.*)\/([^\/]+)/is","\\1/",$WEBURL);
	$postdb[tplpart_1code]=str_replace($weburl,"",$postdb[tplpart_1code]);
	$postdb[tplpart_2code]=str_replace($weburl,"",$postdb[tplpart_2code]);

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

	//有辅助模板时,要加多一条,过滤雷同的记录
	if($postdb[tplpart_2code]){
		$rows++;
	}	


	//指定是什么系统,方便标签函数那里做特别处理
	$postdb[SYS]='mysql';

	$postdb[RollStyleType]=$RollStyleType;
	
	$postdb[show_url]=$show_url;
	$postdb[newhour]=$newhour;
	$postdb[hothits]=$hothits;
	$postdb[tplpath]=$tplpath;
	$postdb[DivTpl]=$DivTpl;
	$postdb[stype]=$stype;
	$postdb[rowspan]=$rowspan;
	$postdb[sql]=$SQL;
	$postdb[colspan]=$colspan;
	$postdb[titlenum]=$titlenum;
	$postdb[titlenum2]=$titlenum2;
	$postdb[titleflood]=$titleflood; $postdb[start_num]=$start_num;
	$postdb[width]=$width;
	$postdb[height]=$height;
	$postdb[content_num]=$content_num;
	$postdb[content_num2]=$content_num2;

	$postdb[c_rolltype]=$c_rolltype;

	$postdb[rolltype]=$rolltype;
	$postdb[rolltime]=$rolltime;
	$postdb[roll_height]=$roll_height;

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
	$titleflood=(int)$titleflood;
	$hide=(int)$rsdb[hide];
	if($rsdb[js_time]){
		$js_ck='checked';
	}

	/*默认值*/
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
	$newhour	|| $newhour=24;
	$hothits	|| $hothits=100;

	$width				|| $width=250;
	$height				|| $height=187;
	$roll_height		|| $roll_height=50;

	$content_num		|| $content_num=80;
	$titlenum2			|| $titlenum2=40;
	$content_num2		|| $content_num2=120;

	$rolltime			|| $rolltime=3;

	$_rolltype[$rolltype]=' selected ';
	$c_rolltype || $c_rolltype=0;
	$c_rolltypedb[$c_rolltype]=" checked ";
	
	$div_width && $div_w=$div_width;
	$div_height && $div_h=$div_height;

	$titleflooddb["$titleflood"]="checked"; 
	$start_num>0 || $start_num=1;
	$hidedb[$hide]="checked";
	$divtpldb[$DivTpl]="checked";
	$stypedb[$stype]=" checked ";
	$fiddb=explode(",",$codedb[fiddb]);

	$getLabelTpl=getLabelTpl($inc,array("common_title","common_pic","common_content","common_fname","common_zh_title","common_zh_pic","common_zh_content"));

	//幻灯片样式
	$rollpicStyle="<select name='RollStyleType' id='RollStyleType' onChange='rollpictypes(this)'><option value=''>默认</option>";
	$dir=opendir(ROOT_PATH."template/default/rollpic/");
	while($file=readdir($dir)){
		if(eregi("\.htm$",$file)){
			$rollpicStyle.="<option value='$file'>".str_replace(".htm","",$file)."</option>";
		}
	}
	$rollpicStyle.="</select>";

	$tplpart_1code = En_TruePath($tplpart_1code,0);

	require("head.php");
	require("template/label/mysql.htm");
	require("foot.php");

}

?>