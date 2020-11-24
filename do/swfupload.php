<?php
require(dirname(__FILE__)."/".'global.php');
if($_POST){
	if( !ereg("^[0-9a-z_]+$",$dir) ){
		$dir="other";
	}
	$array[name]=is_array($Filedata)?$_FILES[Filedata][name]:$Filedata_name;
	$array[path]=$webdb[updir]."/".$dir;
	$array[size]=is_array($Filedata)?$_FILES[Filedata][size]:$Filedata_size;
	$array[updateTable]=1;
	//统计用户上传的文件占用空间大小
	list($lfjid,$lfjuid)=explode("\t",mymd5($_POST[str],'DE'));
	$filename=upfile(is_array($Filedata)?$_FILES[Filedata][tmp_name]:$Filedata,$array);
    /*
	ob_end_clean();
	ob_start();
	print_r($_POST);
	$c=ob_get_contents();ob_end_clean();
	write_file('a.txt',$c);
	 */
	if(!$filename){
		echo "";
	}else {
		$newfile="$dir/$filename";
		echo "$newfile|$array[name]|$array[size]";
	}
	
}
?>