<?php
require_once(dirname(__FILE__)."/"."global.php");
$etype=$etype?'simple':'full';
print <<<EOT

<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=gb2312">
<title>齐博整站系统</title>
</head>
<body leftmargin="0" topmargin="0">
<SCRIPT LANGUAGE="JavaScript">
<!--
var bokecc_id='$webdb[bokecc_id]';
var KE_EDITOR_TYPE = "$etype";
//-->
 </SCRIPT>
<script type="text/javascript" src="$webdb[www_url]/ewebeditor/KindEditor.js"></script>
<input type="hidden" name="content" id="content">
<script type="text/javascript">
var editor = new KindEditor("editor");
editor.hiddenName = "content";
editor.skinPath = "$webdb[www_url]/ewebeditor/skins/default/";
editor.iconPath = "$webdb[www_url]/images/default/faceicon/";
editor.imageAttachPath = "upload_files";
editor.imageUploadCgi = "upfile_eweb.php";
editor.cssPath = "$webdb[www_url]/ewebeditor/common.css";
editor.editorWidth = "100%";
editor.parentID = "$_GET[id]";

function get_height(){
	h=0;
	if(parent.document.getElementById("eWebEditor1")!=null){
		h=(parent.document.getElementById("eWebEditor1").height-60);
	}
	if(h<10){
		h=100;
	}
	return (h+'px');
}
function show_edit(){
	editor.editorHeight =get_height();
	editor.show();
}
setcode();
show_edit();

function setcode(){
	document.getElementById('content').value=parent.document.getElementById('$_GET[id]').value;
}
document.onmousemove=editor.code;

function set_input(){
	editor.code();
	setTimeout("set_input()",30);
}
set_input();

</script>
 
</body>
</html>

EOT;
?>