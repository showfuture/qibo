<?php	
!function_exists('html') && exit('ERR');	

//过滤这些字符,为的是防止破坏数组的序列化
foreach( $postdb AS $key=>$value){
	if(is_array($value)){
		continue;
		//$value=implode(",",$value);
	}
	$value = str_replace('"','&quot;',StripSlashes($value));
	$value = str_replace('\\','',$value);
	$postdb[$key] = str_replace("'",'&#39;',$value);
}
	
if($job=="editsort"&&$Apower[regfield])	
{
	$array=unserialize(StripSlashes($webdb[Reg_Field]));
	
	$listdb=$array[field_db];
	
	require("head.php");
	require("template/regfield/editsort.htm");
	require("foot.php");
}	

elseif($action=="editorder"&&$Apower[regfield])
{
	$array=unserialize(StripSlashes($webdb[Reg_Field]));
	$field_db=$array[field_db];
	
	foreach( $field_db AS $key=>$value){
		$postdb[$key]=intval($postdb[$key]);
		$field_db[$key][orderlist]=$postdb[$key];
		$_listdb[$postdb[$key]]=$field_db[$key];
	}
	krsort($_listdb);
	foreach( $_listdb AS $key=>$rs){
		$listdb[$rs[field_name]]=$rs;
	}
	if(is_array($listdb)){
		$field_db=$listdb+$field_db;
	}
	$array[field_db]=$field_db;
	$config=serialize($array);
	write_config_cache( array('Reg_Field'=>$config) );
	member_field($array[field_db]);
	jump("修改成功","?lfj=$lfj&job=editsort",10);
}	
elseif($job=="editfield"&&$Apower[regfield])	
{	
	$array=unserialize(StripSlashes($webdb[Reg_Field]));
	$_rs=$array[field_db][$field_name];	

	$_rs[field_leng]<1 && $_rs[field_leng]='';	
	$mustfill[$_rs[mustfill]]=" checked ";	
	$form_type[$_rs[form_type]]=" selected ";	
	$field_type[$_rs[field_type]]=" selected ";	
	$group_view=group_box("postdb[allowview]",explode(",",$_rs[allowview]));	
	
	require("head.php");	
	require("template/regfield/editfield.htm");	
	require("foot.php");	
}	
elseif($action=="editfield"&&$Apower[regfield])	
{	
	$postdb[allowview]=implode(",",$postdb[allowview]);	
	
	$array=unserialize(StripSlashes($webdb[Reg_Field]));
	
	$field_array=$array[field_db][$field_name];	
	
	if(!ereg("^([a-z])([a-z0-9_]{2,})$",$postdb[field_name])){	
		showmsg("字段ID不符合规则");	
	}	
	if( table_field("{$pre}memberdata",$postdb[field_name])||$postdb[field_name]=='username'||$postdb[field_name]=='password'){
		if($postdb[field_name]!=$field_name){
			showmsg("此字段ID已受保护或已存在,请更换一个");
		}			
	}	

	$postdb[field_leng]=intval($postdb[field_leng]);	
	
	if($postdb[field_type]=='int')	
	{
		if( $postdb[field_leng]>10 || $postdb[field_leng]<1 ){	
			$postdb[field_leng]=10;	
		}	
		$db->query("ALTER TABLE `{$pre}memberdata` CHANGE `{$field_array[field_name]}` `{$postdb[field_name]}` INT( $postdb[field_leng] ) NOT NULL");	
	}	
	elseif($postdb[field_type]=='varchar')	
	{
		if( $postdb[field_leng]>255 || $postdb[field_leng]<1 ){	
			$postdb[field_leng]=255;	
		}	
		$db->query("ALTER TABLE `{$pre}memberdata` CHANGE `{$field_array[field_name]}` `{$postdb[field_name]}` VARCHAR ( $postdb[field_leng] ) NOT NULL");	
	}	
	elseif($postdb[field_type]=='mediumtext')	
	{	
		$db->query("ALTER TABLE `{$pre}memberdata` CHANGE `{$field_array[field_name]}` `{$postdb[field_name]}` MEDIUMTEXT NOT NULL");	
	}	
	unset($array[field_db][$field_name]);	
	$array[field_db]["{$postdb[field_name]}"]=$postdb;	
	
	unset($array[is_html][$field_name]);
	if($postdb[form_type]=='ieedit'){	
		$array[is_html][$postdb[field_name]]=$postdb[title];	
	}else{	
		unset($array[is_html][$postdb[field_name]]);	
	}

	unset($array[is_upfile][$field_name]);
	if($postdb[form_type]=='upfile'){
		$array[is_upfile][$postdb[field_name]]=$postdb[title];
	}else{
		unset($array[is_upfile][$postdb[field_name]]);
	}

	//处理排序
	unset($_listdb,$listdb);
	$field_db=$array[field_db];	
	foreach( $field_db AS $key=>$value){
		$_listdb[$field_db[$key][orderlist]]=$value;
	}
	krsort($_listdb);
	foreach( $_listdb AS $key=>$rs){
		$listdb[$rs[field_name]]=$rs;
	}
	if(is_array($listdb)){
		$field_db=$listdb+$field_db;
	}
	$array[field_db]=$field_db;

	$config=serialize($array);

	write_config_cache( array('Reg_Field'=>$config) );
	member_field($array[field_db]);
	jump("修改成功","index.php?lfj=regfield&job=editsort",10);
}	
elseif($job=="addfield"&&$Apower[regfield])	
{
		
	//$group_view=group_box("postdb[allowview]",explode(",",$rsdb[allowview]));	
	$_rs[field_type]='mediumtext';	
	$field_type[$_rs[field_type]]=" selected ";	
	$_rs[field_name]="my_".rand(1,999);	
	$_rs[title]="我的字段$_rs[field_name]";	
	$mustfill[0]=$search[0]=' checked ';	
	require("head.php");	
	require("template/regfield/editfield.htm");	
	require("foot.php");	
}	
elseif($action=="addfield"&&$Apower[regfield])	
{
	$postdb[allowview]=implode(",",$postdb[allowview]);	
	if(!ereg("^([a-z])([a-z0-9_]{2,})$",$postdb[field_name])){	
		showmsg("字段ID不符合规则");	
	}
	if( table_field("{$pre}memberdata",$postdb[field_name])||$postdb[field_name]=='username'||$postdb[field_name]=='password'){	
		showmsg("此字段ID已受保护或已存在,请更换一个");	
	}
	$postdb[field_leng]=intval($postdb[field_leng]);	
	
	if($postdb[field_type]=='int')	
	{	
		if( $postdb[field_leng]>10 || $postdb[field_leng]<1 ){	
			$postdb[field_leng]=10;	
		}	
		$db->query("ALTER TABLE `{$pre}memberdata` ADD `{$postdb[field_name]}` INT( $postdb[field_leng] ) NOT NULL");	
	}	
	elseif($postdb[field_type]=='varchar')	
	{	
		if( $postdb[field_leng]>255 || $postdb[field_leng]<1 ){	
			$postdb[field_leng]=255;	
		}	
		$db->query("ALTER TABLE `{$pre}memberdata` ADD `{$postdb[field_name]}` VARCHAR( $postdb[field_leng] ) NOT NULL");	
	}	
	elseif($postdb[field_type]=='mediumtext')	
	{	
		$db->query("ALTER TABLE `{$pre}memberdata` ADD `{$postdb[field_name]}` MEDIUMTEXT NOT NULL");	
	}	
	
	$array=unserialize(StripSlashes($webdb[Reg_Field]));

	$array[field_db][$postdb[field_name]]=$postdb;

	if($postdb[form_type]=='ieedit'){
		$array[is_html][$field_name]=$postdb[title];
	}else{
		unset($array[is_html][$field_name]);
	}
	if($postdb[form_type]=='upfile'){
		$array[is_upfile][$field_name]=$postdb[title];
	}else{
		unset($array[is_upfile][$field_name]);
	}
	$config=serialize($array);
	write_config_cache( array('Reg_Field'=>$config) );
	member_field($array[field_db]);
	jump("添加成功","index.php?lfj=$lfj&job=editsort",10);
}	
elseif($action=="delfield"&&$Apower[regfield])	
{	
	if($field_name=="content"){	
		//showmsg("受保护字段,你不能删除");	
	}	
	$array=unserialize(StripSlashes($webdb[Reg_Field]));
	unset($array[field_db][$field_name]);	
	$config=serialize($array);	
	write_config_cache( array('Reg_Field'=>$config) );
	$db->query("ALTER TABLE `{$pre}memberdata` DROP `$field_name`");
	member_field($array[field_db]);
	jump("删除成功",$FROMURL);	
}	
	

function member_field($array){
	$post_tpl="<!--\r\n<?php\r\nprint <<<EOT\r\n--> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\"><tr><td width='28%'></td><td width='72%'></td></tr>";
	$show_tpl="<!--\r\n<?php\r\nprint <<<EOT\r\n--> \r\n<table width=\"100%\" border=\"0\" cellspacing=\"3\" cellpadding=\"3\">";
	foreach( $array AS $key=>$rs){
		if($rs[mustfill]){
			$namedb[]=filtrate($rs[title]);
			$iddb[]="atc_{$rs[field_name]}";
		}
		$post_tpl.=make_post_table($rs);
		$show_tpl.="<tr> <td style='border-bottom:1px dotted #ccc;'>{$rs[title]}:</td> <td  style='border-bottom:1px dotted #ccc;'>{\$rsdb[{$rs[field_name]}]}&nbsp;{$rs[form_units]}&nbsp;&nbsp;</td></tr>";	
	}
	if($namedb){
		$_name=implode(",",$namedb);
		$_id=implode(",",$iddb);
		$post_tpl=str_replace("<table","<table onmouseover=\"ckregdata('$_id','$_name');\"",$post_tpl);
	}
	$post_tpl.="</table>\r\n<!--\r\nEOT;\r\n?>-->";
	$show_tpl.="</table>\r\n<!--\r\nEOT;\r\n?>-->";
	write_file(ROOT_PATH."template/default/regfield_show.htm",$show_tpl);
	write_file(ROOT_PATH."template/default/regfield.htm",$post_tpl);
}
	
function make_post_table($rs){	
	if($rs[mustfill]=='2'||$rs[form_type]=='pingfen'){	
		return ;	
	}elseif($rs[mustfill]=='1'){	
		$mustfill='<font color=red>(必填)</font>';	
	}	
	if($rs[form_type]=='text')	
	{	
		$rs[field_inputleng] || $rs[field_inputleng]=30;
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td > <input type='text' name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='$rs[field_inputleng]' value='\$rsdb[{$rs[field_name]}]'> $rs[form_units]</td></tr>";	
	}
	elseif($rs[form_type]=='time')	
	{	
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td > <input  onclick=\"setday(this,1)\" type='text' name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='20' value='\$rsdb[{$rs[field_name]}]'> $rs[form_units]</td></tr>";	
	}
	elseif($rs[form_type]=='upfile')	
	{	
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td > <input type='text' name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='50' value='\$rsdb[{$rs[field_name]}]'> $rs[form_units]<br><iframe frameborder=0 height=23 scrolling=no src='upfile.php?fn=upfile&dir=\$_pre\$fid&label=atc_{$rs[field_name]}' width=310></iframe> </td></tr>";	
	}
	elseif($rs[form_type]=='textarea')
	{
		$show="<tr><td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td><td ><textarea name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' cols='70' rows='8'>\$rsdb[{$rs[field_name]}]</textarea>$rs[form_units]</td></tr>";	
	}
	elseif($rs[form_type]=='ieedit')
	{
		$show="<tr><td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td><td ><iframe id='eWebEditor1' src='ewebeditor/ewebeditor.php?id=atc_{$rs[field_name]}&style=standard' frameborder='0' scrolling='no' width='100%' height='350'></iframe>$rs[form_units]<input name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' type='hidden' value='\$rsdb[{$rs[field_name]}]'></td></tr>";	
	}
	elseif($rs[form_type]=='select')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$_show.="<option value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2</option>";
		}
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td><td > <select name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}'>$_show</select>$rs[form_units]</td> </tr>";	
	}
	elseif($rs[form_type]=='radio')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$_show.="<input type='radio' style='border:0px' name='postdb[{$rs[field_name]}]' value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2";	
		}
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td >$_show$rs[form_units]</td></tr>";	
	}
	elseif($rs[form_type]=='checkbox')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;	
			$_show.="<input type='checkbox' style='border:0px' name='postdb[{$rs[field_name]}][]' value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2";	
		}	
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td >$_show$rs[form_units]</td></tr>";	
	}
	return $show;
}

?>