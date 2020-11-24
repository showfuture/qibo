<?php
!function_exists('html') && exit('ERR');
//$ch && $CHDB=$db->get_one("SELECT * FROM {$pre}channel WHERE id='$ch'");

//处理地址来源.方便浏览效果
if($fromurl){
	$viewurl=str_replace("jobs=show","",$fromurl);
	setcookie('_fromurl',$viewurl);
}else{
	$viewurl=$_COOKIE['_fromurl'];
}

//获取标签模板HTML源代码
if($job=="getTplcode"){
	
	$filepath=str_replace("$webdb[www_url]/","",$filepath);
	$filepath=str_replace(".jpg",".htm",$filepath);

	$code=read_file(ROOT_PATH.$filepath);

	$code2=read_file(str_replace(".htm",".txt",ROOT_PATH.$filepath));

	if(strstr($code,'$content')&&strstr($code,'$picurl')){
		$type='cp';
	}elseif(strstr($code,'$picurl')){
		$type='p';
	}elseif(strstr($code,'$content')){
		$type='c';
	}elseif(ereg('^rollpic',$code)){
		$type='r';
		$code='';
	}else{
		$type='t';
	}
	$code=AddSlashes($code);
	$code=str_replace("\r",'\r',$code);
	$code=str_replace("\n",'\n',$code);
	$code2=AddSlashes($code2);
	$code2=str_replace("\r",'\r',$code2);
	$code2=str_replace("\n",'\n',$code2);
	$code2=preg_replace('/<\/script>/i','<\/script>',$code2);
	$code=preg_replace('/<\/script>/i','<\/script>',$code);
	echo "<SCRIPT LANGUAGE=\"JavaScript\">
	<!--
	parent.puthtmlcode('$type','$code','$code2');
	//-->
	</SCRIPT>";
	exit;
}

if($inc=="NewTag"){
	unset($inc);
	$job="list";
	check_NewTag();
}


if($inc){
	if($action){
		save_label();
	}
	$inc=str_Replace("/","",$inc);
	if( ereg("^(log|down|photo|mv|shop|music|flash)$",$inc) ){
		include(dirname(__FILE__)."/label/c.php");
	}
	elseif(ereg("^Info_",$inc)){//Info_fenlei_
		$detail=explode("Info_",$inc);
		$_pre="{$pre}$detail[1]";
		$ModuleDB[$detail[1]]['admindir'] || $ModuleDB[$detail[1]]['admindir']='admin';
		$label_file=ROOT_PATH.$ModuleDB[$detail[1]]['dirname'].'/'.$ModuleDB[$detail[1]][admindir].'/label.inc.php';

		
		if( is_file($label_file) ){
			include($label_file);
		}
		else{
			include(dirname(__FILE__)."/label/info.php");
		}
	}
	else{
		if(!@include(dirname(__FILE__)."/label/$inc.php")){
			require(dirname(__FILE__)."/"."head.php");
			require(dirname(__FILE__)."/"."template/label/list.htm");
			require(dirname(__FILE__)."/"."foot.php");
		}
	}
}elseif($job=="list"){
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/label/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}elseif($action=="DeleteTag"){
	label_hf($tag,"");	//头与尾
	$db->query("DELETE FROM {$pre}label WHERE ch='$ch' AND tag='$tag' AND module='$ch_module' AND pagetype='$ch_pagetype' ");
	make_tag_cache();
	jump("删除成功","index.php?lfj=label&job=list&ch=$ch&chtype=$chtype&tag=$tag&ch_module=$ch_module&ch_pagetype=$ch_pagetype",1);
}
elseif($job=="make")
{
	if($step==2){
		if($type=='title'){
			if($istime){
				$_istime="($timeformat)";
			}
			if($isfname){
				$_isfname=' [<A HREF="$list_url">$fname</A>] ';
			}
			if($isauthor){
				$_isauthor=' (<A HREF="$list_url">$username</A>) ';
			}

			$show="<div style=\"widht:100%;height:{$Tdivheight}px;background:$Tdivbgcolor;border-bottom:$Tdivbglinecolor $Tdivbgline;margin-left:{$Tdivmarginleft}px;margin-right:{$Tdivmarginright}px;\"><span style=\"width:100%;background:url($Ticourl) no-repeat;background-position: $Ticopx $Ticopy;padding-left:{$Ticoright}px;\">$_isfname<A target=_blank HREF=\"\$url\" style=\"color:$Tfontcolor;font-weight:$Tfontweight;font-size:{$Tfontsize}px;text-decoration:$Tfontline;\">\$title</A>$_isauthor $_istime</span></div>";
		}elseif($type=='tc'){
			$show="<div style=\"margin-top:$TCtop;margin-left:$TCleft;margin-right:$TCright;\"><div><a target=_blank href=\"\$url\" style=\"color:$TCfontcolor;font-weight:$TCfontweight;font-size:{$TCfontsize}px;text-decoration:$TCfontline;\">\$title</a></div><div style=\"color:$TCCfontcolor;font-size:{$TCCfontsize}px;\">&nbsp;&nbsp;&nbsp;&nbsp;\$content</div></div>";
		}elseif($type=='pic'){
			if($istitle){
				$_istitle="<div style='width:100%;text-align :center;'><a target=_blank href='\$url' style='color:$Pfontcolor;font-weight:$Pfontweight;font-size:{$Pfontsize}px;text-decoration:$Pfontline;'>\$title</a> </div>";
			}
			$show="<div style='width:100%;text-align :center;' align='center'> <div style=\"width:{$Pwidth}px;height:{$Pheight}px;border:{$Pborder}px solid $Pbordercolor;\"><A HREF=\"\$url\" target=_blank><img style=\"width:{$Pwidth}px;height:{$Pheight}px;border:{$Pimgborder}px solid $Pimgbordercolor;\" border=0 src=\"\$picurl\" width=\"100\" height=\"80\"></A></div>$_istitle</div>";
		}
		$show=str_replace("'","\'",$show);
		$show=str_replace("\r",'\r',$show);
		$show=str_replace("\n",'\n',$show);
		$tpl_id || $tpl_id='tplpart_1';
		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		<!--
		window.opener.document.getElementById('$tpl_id').value='$show';
		window.self.close();
		//-->
		</SCRIPT>";
	}
	elseif($step=='getpic')
	{
		$dir=opendir(ROOT_PATH."images/diy.style/title_icon/");
		while( $file=readdir($dir) ){
			if(eregi("jpg$",$file)||eregi("gif$",$file)||eregi("png$",$file)){
				$_listdb[]="$webdb[www_url]/images/diy.style/title_icon/$file";
			}
		}
		$listdb=array_chunk($_listdb,4);
		require("head.php");
		require("template/label/maketpl/pic.htm");
		require("foot.php");
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/label/maketpl/1.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

/*纠正有重复的标签*/
function save_label(){
	global $db,$pre,$ch_pagetype,$ch_module,$ch_fid,$ch,$tag;
	$query = $db->query("SELECT * FROM {$pre}label WHERE  ch='$ch' AND pagetype='$ch_pagetype' AND module='$ch_module' AND fid='$ch_fid' ");
	while($rs = $db->fetch_array($query)){
		if($ckdb[$rs[tag]]){
			$db->query("DELETE FROM {$pre}label WHERE lid='$rs[lid]'");
		}
		$ckdb[$rs[tag]]=1;
	}
}

/**
*插入与更新标签
**/
function do_post(){
	global $db,$pre,$lid,$ch,$chtype,$tag,$type,$code,$div,$hide,$js_time,$userdb,$timestamp,$typesystem,$ch_pagetype,$ch_module,$ch_fid,$ch_ifjs,$CHDB,$webdb,$FROMURL,$viewurl,$mystyle;

	//修复旧版的
	$db->query("UPDATE `{$pre}label` SET chtype=99,module=0 WHERE module='-99'");

	if($lid){
		$db->query("UPDATE `{$pre}label` SET ch='$ch',chtype='$chtype',tag='$tag',type='$type',code='$code',divcode='$div',hide='$hide',js_time='$js_time',uid='$userdb[uid]',username='$userdb[username]',posttime='$timestamp',typesystem='$typesystem',pagetype='$ch_pagetype',module='$ch_module',fid='$ch_fid',if_js='$ch_ifjs',style='$mystyle' WHERE lid='$lid' ");//die("s");
	}else{
		$db->query("INSERT INTO `{$pre}label` ( `ch`, `chtype`, `tag`, `type`, `code`, `divcode`, `hide`, `js_time`, `uid`, `username`, `posttime`,`typesystem`, `pagetype`, `module`, `fid`,`if_js`,`style`) VALUES ('$ch','$chtype','$tag','$type','$code','$div','$hide','$js_time','$userdb[uid]','$userdb[username]','$posttime','$typesystem','$ch_pagetype','$ch_module','$ch_fid','$ch_ifjs','$mystyle')");
	}

	//头与尾
	if($chtype==99){
		label_hf();
	}

	if($ch_ifjs){//返回到JS调用页
		header("location:index.php?lfj=js&job=show&id=$lid&$timestamp");exit;
	}
	make_tag_cache();
	SetModule_config();
	jump("<CENTER>[<A HREF='$viewurl' target='_blank'>点击浏览效果</A>] [<A HREF='$FROMURL'>继续修改</A>]  [<A HREF='$viewurl&jobs=show'>返回频道/专题</A>]</CENTER>","$FROMURL",600);
}

function get_label(){
	global $db,$pre,$ch,$chtype,$tag,$ch_pagetype,$ch_module,$ch_fid;
	if($chtype!=99){
		$SQL=" AND module='$ch_module' ";
	}
	$rsdb=$db->get_one("SELECT * FROM {$pre}label WHERE tag='$tag' AND pagetype='$ch_pagetype' AND fid='$ch_fid' AND chtype='$chtype' $SQL ");
	
	if(!$rsdb){
		$rsdb=check_NewTag();
	}
	return $rsdb;
}


function label_hf($tag,$_value){
	global $db,$pre,$webdb;
	$query = $db->query(" SELECT * FROM {$pre}label WHERE  chtype='99' ");
	while($rs = $db->fetch_array($query)){
		if( $rs[type]=='code' ){
			$rs[code]=En_TruePath($rs[code],0);
			$value=stripslashes($rs[code]);
			//$value=str_replace("$webdb[www_url]/$webdb[updir]",'$webdb[www_url]/$webdb[updir]',$value);
		}elseif( $rs[type]=='pic' ){
			$picdb=unserialize($rs[code]);
			$picdb[imgurl]=tempdir("$picdb[imgurl]");
			$picdb[width] && $width=" width='$picdb[width]'";
			$picdb[height] && $height=" height='$picdb[height]'";
			if($picdb['imglink']){
				$value="<a href='$picdb[imglink]' target=_blank><img src='$picdb[imgurl]' $width $height border='0' /></a>";
			}else{
				$value="<img src='$picdb[imgurl]' $width $height  border='0' />";
			}
			//$value=str_replace("$webdb[www_url]/$webdb[updir]",'$webdb[www_url]/$webdb[updir]',$value);
		}elseif( $rs[type]=='swf' ){
			$flashdb=unserialize($rs[code]);
			$flashdb[flashurl]=tempdir($flashdb[flashurl]);
			$flashdb[width] && $width=" width='$flashdb[width]'";
			$flashdb[height] && $height=" height='$flashdb[height]'";
			$value="<object type='application/x-shockwave-flash' data='$flashdb[flashurl]' $width $height wmode='transparent'><param name='movie' value='$flashdb[flashurl]' /><param name='wmode' value='transparent' /></object>";
			//$value=str_replace("$webdb[www_url]/$webdb[updir]",'$webdb[www_url]/$webdb[updir]',$value);
		}else{
			$value=stripslashes($rs[code]);
			//真实地址还原
			$value=En_TruePath($value,0);
		}
		$label[$rs[tag]]=$value;
	}
	$label[$tag]=stripslashes($_value);
	$show="<?php\r\n";
	foreach( $label AS $key=>$value){
		if($value==''){
			continue;
		}
		$value=addslashes($value);
		$value=str_replace('$','\$',$value);
		//$value=str_replace("$webdb[www_url]/$webdb[updir]",'$webdb[www_url]/$webdb[updir]',$value);
		$value=En_TruePath($value,1);
		$show.="
		\$label[$key]=En_TruePath(stripslashes(\"$value\"),0);";
	}
	write_file(ROOT_PATH."data/label_hf.php",$show);
}

//标签缓存.主要目的是为了风格交流使用

function make_tag_cache(){
	global $db,$pre,$ch,$chtype,$tag,$ch_pagetype,$ch_module,$ch_fid,$mystyle;
	if($ch_module){
		$rsdb=$db->get_one("SELECT dirname FROM {$pre}module WHERE id='$ch_module'");
	}
	$show="<?php\r\n";
	$query = $db->query("SELECT * FROM {$pre}label WHERE module='$ch_module' AND pagetype='$ch_pagetype' GROUP BY `tag` ");
	while($rs = $db->fetch_array($query)){
		$rs[code]=addslashes( $rs[code]);
		$rs[divcode]=addslashes( $rs[divcode]);
		$show.="\r\n\$TagDB['{$rs[tag]}']=array(
				'typesystem'=>'{$rs[typesystem]}',
				'type'=>'{$rs[type]}',
				'code'=>'{$rs[code]}',
				'divcode'=>'{$rs[divcode]}'
				);";
		$i++;
	}
	if(!file_exists(ROOT_PATH."$rsdb[dirname]/cache/label")){
		mkdir(ROOT_PATH."$rsdb[dirname]/cache/label");
		chmod(ROOT_PATH."$rsdb[dirname]/cache/label",0777);
	}
	
	@include(ROOT_PATH."$rsdb[dirname]/cache/label/{$ch_pagetype}.php");
	if(is_dir(ROOT_PATH."$rsdb[dirname]/cache/label/")){
		write_file(ROOT_PATH."$rsdb[dirname]/cache/label/{$ch_pagetype}.php","$show\r\n?>");
	}
	
}

function check_NewTag(){
	global $db,$pre,$ch,$chtype,$tag,$ch_pagetype,$ch_module,$ch_fid,$mystyle,$inc,$job;
	if($ch_module){
		$rsdb=$db->get_one("SELECT dirname FROM {$pre}module WHERE id='$ch_module'");
	}
	@include(ROOT_PATH."$rsdb[dirname]/cache/label/{$ch_pagetype}.php");
	if(!$inc&&$TagDB[$tag]){
		if($TagDB[$tag]['typesystem']){
			$_inc=str_replace("Info_","",$TagDB[$tag]['type']);
			if($rs=$db->get_one("SELECT * FROM {$pre}module WHERE pre='$_inc'")){
				$inc=$TagDB[$tag]['type'];
			}else{
				$inc='article';
			}
		}elseif($TagDB[$tag]['type']){
			$inc=$TagDB[$tag]['type'];
		}else{
			$inc='article';
		}
		$job='mod';
	}
	$TagDB[$tag][code]=stripslashes($TagDB[$tag]['code']);
	$TagDB[$tag][divcode]=stripslashes($TagDB[$tag]['divcode']);
	return $TagDB[$tag];
}


function SetModule_config(){
	global $inc,$typesystem,$db,$pre;
	if(!$typesystem){
		return ;
	}
	$_inc=str_replace("Info_","",$inc);
	$rsdb=$db->get_one("SELECT * FROM {$pre}module WHERE pre='$_inc'");
	if(!$rsdb){
		return ;
	}
	
	if($rsdb[type]){
		$_pre="{$pre}$_inc";
	}else{
		$_pre="{$pre}{$_inc}_";
	}

	if(!is_table("{$_pre}config")||!is_table("{$_pre}sort")){
		return ;
	}

	$module_array=unserialize($rsdb[config]);
	$query = $db->query("SELECT * FROM {$_pre}config");
	while($rs = $db->fetch_array($query)){
		$cf[$rs[c_key]]=$rs[c_value];
	}
	$module_array[list_PhpName]='list.php?&fid=$fid';
	$module_array[show_PhpName]='bencandy.php?&fid=$fid&id=$id';
	
	if(!$rsdb[type]){
		$__iic=ucfirst($_inc);
		$module_array[MakeHtml]=$cf["{$__iic}_NewsMakeHtml"];
		$module_array[list_HtmlName1]=$cf["{$__iic}_list_filename"];
		$module_array[show_HtmlName1]=$cf["{$__iic}_bencandy_filename"];
		$module_array[list_HtmlName2]=$cf["{$__iic}_list_filename2"];
		$module_array[show_HtmlName2]=$cf["{$__iic}_bencandy_filename2"];
	}else{
		$module_array[MakeHtml]=$cf[Info_NewsMakeHtml];
		$module_array[list_HtmlName1]=$cf[Info_list_filename];
		$module_array[show_HtmlName1]=$cf[Info_bencandy_filename];
		$module_array[list_HtmlName2]=$cf[Info_list_filename2];
		$module_array[show_HtmlName2]=$cf[Info_bencandy_filename2];
	}
	$query = $db->query("SELECT * FROM {$_pre}sort");
	while($rs = $db->fetch_array($query)){
		$rs[list_html]		&& $module_array[list_HtmlName][$rs[fid]]=$rs[list_html];
		$rs[bencandy_html]	&& $module_array[show_HtmlName][$rs[fid]]=$rs[bencandy_html];
	}
	$string=addslashes(serialize($module_array));
	$db->query("UPDATE {$pre}module SET config='$string' WHERE pre='$_inc'");
	make_module_cache();
}


//获取标签模板
function getLabelTpl($type,$type_array=array()){
	global $webdb;	
	if(!is_dir(ROOT_PATH."template/default/label_tpl/$type")){
		$type="common_title";
	}	
	$type_array=array('-1'=>$type)+$type_array;
	foreach( $type_array AS $key=>$value){
		$path=ROOT_PATH."template/default/label_tpl/$value";
		$dir=opendir($path);
		while($file=readdir($dir)){
			if(eregi("\.htm$",$file)){
				$pictitledb[]=str_replace(".htm","",$file);
				$picurldb[]=$f2="$webdb[www_url]/template/default/label_tpl/$value/".str_replace(".htm",".jpg",$file);
				$select.="<option value='$f2'>".str_replace(".htm","",$file)."</option>";
			}
		}
		closedir($dir);
	}

	$picurldb=implode('","',$picurldb);
	$pictitledb=implode('","',$pictitledb);
	$myurl=str_replace(array(".","/"),array("\.","\/"),$webdb[www_url]);
$show=<<<EOT
<table  border="0" cellspacing="0" cellpadding="0">
<tr><td style="padding-left:20px;padding-bottom:10px;"><select id="selectTyls" onChange="selectTpl(this)">
    <option value='0'>快速选择</option><option value='1' style='color:blue;'>新建一个模板</option>$select
  </select> [<a href="#LOOK" onclick="show_MorePic(-1)">上一个</a>] 
      【<span id="upfile_PicNum">1/2</span>】[<a href="#LOOK" onclick="show_MorePic(1)">下一个</a>]  
       <span id="clickput"></span> 	
</td></tr>
  <tr>
    <td height="30" style="padding-left:20px;"><div id="showpicdiv" class="showpicdiv" ><A style="border:2px solid #fff;display:block;" HREF="#" onclick="show_MorePic(1)"  id="showPicID"><img border="0" onerror="this.src=replace_img(this.src);" onload="if(this.height>200)this.height='200';" id="upfile_PicUrl"></A></div><div id="MSG_say"></div></td>
  </tr>
</table>
<SCRIPT LANGUAGE="JavaScript">
var ImgLinks= new Array("$picurldb");
var ImgTitle= new Array("$pictitledb");
function replace_img(url){
	//如果图片不存在,就去官方获取图片,如果还是不存在,就使用默认的无图片.
	reg=/http:\/\/down\.qibosoft\.com/g
	if(reg.test(url)){
		return "$webdb[www_url]/images/default/nopic.jpg";
	}
	re   = /$myurl/g;
	link_s = url.replace(re, "http://down.qibosoft.com");
	return link_s;
}
</SCRIPT>
EOT;
	return $show;
}

?>