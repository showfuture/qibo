<?php
if(!function_exists('html')){
	die('F');
}
$fup=intval($fup);
$NUM=substr($ID,-1)+1;
$show="<select name='postdb[{$formname}][]' onChange='chooseclass_{$classid}(this.options[this.selectedIndex].value,$NUM)'><option value=''>«Î—°‘Ò</option>";
$listdb = $Module_db->list_classdb($fup);
foreach($listdb AS $rs){
	$ck=$rs[fid]==$fid?' selected ':'';
	$show.="<option value='$rs[fid]|$rs[name]' $ck>$rs[name]</option>";
	$ckk++;
}
$show.="</select>";



$_ID=preg_replace("/(.*)_([\d]+)$/is","\\1_",$ID);
echo "<SCRIPT LANGUAGE='JavaScript'>
<!--
for(var i=($NUM-1);i<10 ;i++ ){
	parent.document.getElementById('{$_ID}'+i).innerHTML=\"\";
}
//-->
</SCRIPT>";
if($fup&&$ckk){
	echo "<SCRIPT LANGUAGE='JavaScript'>
	<!--
	parent.document.getElementById('$ID').innerHTML=\"$show\";
	//-->
	</SCRIPT>";
}

?>