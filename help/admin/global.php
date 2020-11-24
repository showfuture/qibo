<?php
function_exists('html') OR exit('ERR');

define('Mdirname', preg_replace("/(.*)\/([^\/]+)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );
define('Mpath', preg_replace("/(.*)\/([^\/]+)\/([^\/]+)/is","\\1/\\2/",str_replace("\\","/",dirname(__FILE__))) );

define('Madmindir', preg_replace("/(.*)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );

$Mpath = Mpath;
define('Adminpath',dirname(__FILE__).'/');

require(Mpath."data/config.php");
require(Mpath."data/all_fid.php");


$Murl=$Mdomain=$webdb[www_url].'/'.Mdirname;
$_pre="{$pre}{$webdb[module_pre]}";					//数据表前缀



function make_post_table($rs){
	if($rs[mustfill]=='2'||$rs[form_type]=='pingfen'||$rs[field_name]=='content'){
		return ;
	}elseif($rs[mustfill]=='1'){
		$mustfill='<font color=red>(必填)</font>';
	}
	if($rs[form_type]=='text')
	{
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td > <input type='text' name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='50' value='\$rsdb[{$rs[field_name]}]'> $rs[form_units]</td></tr>";
	}
	elseif($rs[form_type]=='upfile')
	{
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td > <input type='text' name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='50' value='\$rsdb[{$rs[field_name]}]'> $rs[form_units]<br><iframe frameborder=0 height=23 scrolling=no src='\$webdb[www_url]/do/upfile.php?fn=upfile&dir=\$_pre\$fid&label=atc_{$rs[field_name]}' width=310></iframe> </td></tr>";
	}
	elseif($rs[form_type]=='upmorefile')
	{
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}<br>增加 <input type='text' size='3' name='nums_{$rs[field_name]}' value='2'> 项 <input type='button' name='Submit2' value='增加' onClick='showinput_{$rs[field_name]}()'></td> <td ><!--
EOT;
\$num=count(\$rsdb[{$rs[field_name]}][url]);
\$num||\$num=1;
for( \$i=0; \$i<\$num ;\$i++ ){
print <<<EOT
--> 名称: <input type=\"text\" name=\"postdb[{$rs[field_name]}][name][]\" id=\"atc_{$rs[field_name]}_name\$i\" size=\"15\" value=\"{\$rsdb[{$rs[field_name]}][name][\$i]}\">
 消耗{\$webdb[MoneyName]}: <input type=\"text\" name=\"postdb[{$rs[field_name]}][fen][]\" id=\"atc_{$rs[field_name]}_fen\$i\" size=\"3\" value=\"{\$rsdb[{$rs[field_name]}][fen][\$i]}\">
 地址: 
                    <input type=\"text\" name=\"postdb[{$rs[field_name]}][url][]\" id=\"atc_{$rs[field_name]}_url\$i\" size=\"30\" value=\"{\$rsdb[{$rs[field_name]}][url][\$i]}\">
                    [<a href='javascript:' onClick='window.open(\"\$webdb[www_url]/do/upfile.php?fn=upfile_{$rs[field_name]}&dir=\$_pre\$fid&label=\$i\",\"\",\"width=350,height=50,top=200,left=400\")'><font color=\"#FF0000\">点击上传文件</font></a>] 
                    <br><!--
EOT;
}
print <<<EOT
--><div id=\"input_{$rs[field_name]}\"></div>
<script LANGUAGE=\"JavaScript\">
totalnum_{$rs[field_name]}=0;
function showinput_{$rs[field_name]}(){
	var str=document.getElementById(\"input_{$rs[field_name]}\").innerHTML;
	var num=2;
	num=document.FORM.nums_{$rs[field_name]}.value;
	for(var i=1;i<=num;i++){
		totalnum_{$rs[field_name]}=totalnum_{$rs[field_name]}+i+\$num-1;
	    str+='名称: <input type=\"text\" name=\"postdb[{$rs[field_name]}][name][]\" id=\"atc_{$rs[field_name]}_name'+totalnum_{$rs[field_name]}+'\" size=\"15\"> 消耗{\$webdb[MoneyName]}: <input type=\"text\" name=\"postdb[{$rs[field_name]}][fen][]\" id=\"atc_{$rs[field_name]}_fen'+totalnum_{$rs[field_name]}+'\" size=\"3\"> 地址: <input type=\"text\" name=\"postdb[{$rs[field_name]}][url][]\" id=\"atc_{$rs[field_name]}_url'+totalnum_{$rs[field_name]}+'\" size=\"30\" > [<a href=\'javascript:\' onClick=\'window.open(\"\$webdb[www_url]/do/upfile.php?fn=upfile_{$rs[field_name]}&dir=\$_pre\$fid&label='+totalnum_{$rs[field_name]}+'\",\"\",\"width=350,height=50,top=200,left=400\")\'><font color=\"#FF0000\">点击上传文件</font></a>]<br>';
	}
	document.getElementById(\"input_{$rs[field_name]}\").innerHTML=str;
}

function upfile_{$rs[field_name]}(url,name,size,label){
	document.getElementById(\"atc_{$rs[field_name]}_url\"+label).value=url;
	arr=name.split('.');
	document.getElementById(\"atc_{$rs[field_name]}_name\"+label).value=arr[0];
}
</SCRIPT></td></tr>";
	}
	elseif($rs[form_type]=='textarea')
	{
		$show="<tr><td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td><td ><textarea name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' cols='70' rows='8'>\$rsdb[{$rs[field_name]}]</textarea>$rs[form_units]</td></tr>";
	}
	elseif($rs[form_type]=='ieedit')
	{
		$show="<tr><td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td><td ><iframe id='eWebEditor1' src='../ewebeditor/ewebeditor.php?id=atc_{$rs[field_name]}&style=standard' frameborder='0' scrolling='no' width='100%' height='350'></iframe>$rs[form_units]<input name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' type='hidden' value='\$rsdb[{$rs[field_name]}]'></td></tr>";
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
			$_show.="<input type='radio' name='postdb[{$rs[field_name]}]' value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2";
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
			$_show.="<input type='checkbox' name='postdb[{$rs[field_name]}][]' value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2";
		}
		$show="<tr> <td >{$rs[title]}:$mustfill<br>{$rs[form_title]}</td> <td >$_show$rs[form_units]</td></tr>";
	}
	return $show;
}

function make_show_table($rs){
	if($rs[mustfill]=='2'||$rs[field_name]=='content'){
		return ;
	}
	if($rs[form_type]=='pingfen'){
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if($value===''){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$selected=$v1==$rs[form_value]?' selected ':'';
			$_show.="<option value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']} $selected>$v2</option>";
		}
		$show="<select name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}'>$_show</select>&nbsp;<input type='submit' value='post'><input type='hidden' name='id' value='\$id'>";
	}
	$show="<tr> <td >{$rs[title]}:</td> <td ><table width='100%' border='0' cellspacing='0' cellpadding='0' style='TABLE-LAYOUT: fixed;WORD-WRAP: break-word;'><tr><td>{\$rsdb[{$rs[field_name]}]}&nbsp;{$rs[form_units]}&nbsp;&nbsp;$show</td></tr></table></td></tr>";
	if($rs[form_type]=='pingfen'){
		$show="<form method='post' action='job.php?action=pingfen'>$show</form>";
	}
	return $show;
}

function make_search_table($rs)
{
	if($rs[form_type]=="select"||$rs[form_type]=="radio"||$rs[form_type]=="checkbox")
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$_show.="<option value='$v1' {\$rsdb[{$rs[field_name]}]['{$v1}']}>$v2</option>";
		}
		$show="<select name='postdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}'><option value=''>ALL</option>$_show</select>";		
	}
	else
	{
		$show="&nbsp;<input type='radio' name='type' value='{$rs[field_name]}' \$typedb[{$rs[field_name]}]>{$rs[title]} ";
	}
	return $show;
}
?>