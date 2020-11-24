<?php
error_reporting(0);extract($_GET);
require_once(dirname(__FILE__)."/../data/config.php");
if(!eregi("^([0-9]+)$",$id)){
	die("document.write('ID不存在');");
}
$FileName=dirname(__FILE__)."/../cache/js/";

$FileName.="{$id}.php";
//默认缓存3分钟.
if(!$webdb["cache_time_js"]){
	$webdb["cache_time_js"]=3;
}
if( (time()-filemtime($FileName))<($webdb["cache_time_js"]*60) ){
	@include($FileName);
	$show=str_replace(array("\n","\r","'"),array("","","\'"),stripslashes($show));
	if($iframeID){	//框架方式不会拖慢主页面打开速度,推荐
		//处理跨域问题
		if($webdb[cookieDomain]){
			echo "<SCRIPT LANGUAGE=\"JavaScript\">document.domain = \"$webdb[cookieDomain]\";</SCRIPT>";
		}
		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		parent.document.getElementById('$iframeID').innerHTML='$show';
		</SCRIPT>";
	}else{			//JS式会拖慢主页面打开速度,不推荐
		echo "document.write('$show');";
	}
	exit;
}

require(dirname(__FILE__)."/"."global.php");
require_once(ROOT_PATH."inc/label_funcation.php");


	$query=$db->query(" SELECT * FROM {$pre}label WHERE lid='$id' ");
	while( $rs=$db->fetch_array($query) ){
		//读数据库的标签
		if( $rs[typesystem] )
		{
			$_array=unserialize($rs[code]);
			$value=($rs[type]=='special')?Get_sp($_array):Get_Title($_array);
			if(strstr($value,"(/mv)")){
				$value=get_label_mv($value);
			}
			if($_array[c_rolltype])
			{
				$value="<marquee direction='$_array[c_rolltype]' scrolldelay='1' scrollamount='1' onmouseout='if(document.all!=null){this.start()}' onmouseover='if(document.all!=null){this.stop()}' height='$_array[roll_height]'>$value</marquee>";
			}
		}
		//代码标签
		elseif( $rs[type]=='code' )
		{
			$value=stripslashes($rs[code]);
			//纠正一下不完整的javascript代码,不必做权限判断,普通用户也能删除
			if(eregi("<SCRIPT",$value)&&!eregi("<\/SCRIPT",$value)){
				if($delerror){
					$db->query("UPDATE `{$pre}label` SET code='' WHERE lid='$rs[lid]'");
				}else{
					die("<A HREF='$WEBURL?&delerror=1'>此“{$rs[tag]}”标签有误,点击删除之!</A><br>$value");
				}			
			}
			//真实地址还原
			$value=En_TruePath($value,0);
		}
		//单张图片
		elseif( $rs[type]=='pic' )
		{	
			unset($width,$height);
			$picdb=unserialize($rs[code]);
			$picdb[imgurl]=tempdir("$picdb[imgurl]");
			$picdb[width] && $width=" width='$picdb[width]'";
			$picdb[height] && $height=" height='$picdb[height]'";
			if($picdb['imglink'])
			{
				$value="<a href='$picdb[imglink]' target=_blank><img src='$picdb[imgurl]' $width $height border='0' /></a>";
			}
			else
			{
				$value="<img src='$picdb[imgurl]' $width $height  border='0' />";
			}
		}
		//单个FLASH
		elseif( $rs[type]=='swf' )
		{
			$flashdb=unserialize($rs[code]);
			$flashdb[flashurl]=tempdir($flashdb[flashurl]);
			$flashdb[width] && $width=" width='$flashdb[width]'";
			$flashdb[height] && $height=" height='$flashdb[height]'";
			$value="<object type='application/x-shockwave-flash' data='$flashdb[flashurl]' $width $height wmode='transparent'><param name='movie' value='$flashdb[flashurl]' /><param name='wmode' value='transparent' /></object>";
		}
		//普通幻灯片
		elseif( $rs[type]=='rollpic' )
		{
			$value=rollPic_flash(unserialize($rs[code]));
		}
		//其它形式的
		else
		{
			$value=stripslashes($rs[code]);
			//真实地址还原
			$value=En_TruePath($value,0);
		}
	}

$show=stripslashes($value);

if(!is_dir(dirname($FileName))){
	makepath(dirname($FileName));
}
if( (time()-filemtime($FileName))>($webdb["cache_time_js"]*60) ){
	if($webdb["cache_time_js"]!=-1){
		write_file($FileName,"<?php \r\n\$show=stripslashes('".addslashes($show)."'); ?>");
	}
}

$show=str_replace(array("\r","\n","'"),array("","","\'"),$show);

if($iframeID){	//框架方式不会拖慢主页面打开速度,推荐
	//处理跨域问题
	if($webdb[cookieDomain]){
		echo "<SCRIPT LANGUAGE=\"JavaScript\">document.domain = \"$webdb[cookieDomain]\";</SCRIPT>";
	}
	echo "<SCRIPT LANGUAGE=\"JavaScript\">
	parent.document.getElementById('$iframeID').innerHTML='$show';
	</SCRIPT>";
}else{			//JS式会拖慢主页面打开速度,不推荐
	echo "document.write('$show');";
}
?>