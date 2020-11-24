<?php
require_once(dirname(__FILE__)."/"."global.php");
//header('Content-Type: text/html; charset=utf-8'); 
if($fileData){
	if(!$lfjid){
		//showerr("你还没登录",1);
	}
	//其中..与/开头都是不允许的
	if( !ereg("^[0-9a-z_/]+$",$dir)||ereg("^/",$dir) ){
		$dir="other";
	}
	$updir='';
	$path="$updir/$dir";
	$array[name]=is_array($fileData)?$_FILES[fileData][name]:$fileData_name;
	require_once(ROOT_PATH."inc/class.chinese.php");
	$cnvert = new Chinese("UTF8","GB2312",$array[name],ROOT_PATH."./inc/gbkcode/");
	$array[name] = $cnvert->ConvertIT();
	$array[path]=$webdb[updir]."/".$path;
	$array[size]=is_array($fileData)?$_FILES[fileData][size]:$fileData_size;
	
	//$array[updateTable]=1;	//统计用户上传的文件占用空间大小
	$lfjuid=$userdb[uid];	//处理上传的文件名标志
	$filename=upfile(is_array($fileData)?$_FILES[fileData][tmp_name]:$fileData,$array);
	
	$newfile="$webdb[www_url]/$webdb[updir]/$dir/$filename";
	
	//插入数据，关闭层
	echo '<html>';
	echo '<head>';
	echo '<title>Insert Image</title>';
	echo '<meta http-equiv="content-type" content="text/html; charset=gb2312">';
	echo '</head>';
	echo '<body>';
	if(!$_GET[Ctype])
	{
		echo "<SCRIPT LANGUAGE=\"JavaScript\">parent.KindInsertImage('$newfile','$imgWidth','$imgHeight','$imgBorder','$imgTitle','$imgAlign','$imgHspace','$imgVspace')</SCRIPT>";
	}
	else
	{
		echo "<SCRIPT LANGUAGE=\"JavaScript\">parent.KindInsertImageP8FLV('$newfile','$imgWidth','$imgHeight','$_GET[Ctype]')</SCRIPT>";
	}
	echo '</body>';
	echo '</html>';
	exit;
}

 

//提示，关闭层
function alert($msg)
{
	echo '<html>';
	echo '<head>';
	echo '<title>error</title>';
	echo '<meta http-equiv="content-type" content="text/html; charset=gb2312">';
	echo '</head>';
	echo '<body>';
	echo '<script type="text/javascript">alert("'.$msg.'");parent.KindDisableMenu();parent.KindReloadIframe();</script>';
	echo '</body>';
	echo '</html>';
	exit;
}
?>