<?php 
!function_exists('html') && exit('ERR');
if($job == "label" && $Apower[labelstyle]){
	hack_admin_tpl('labelstyle');
}
if($job == "out" && $Apower[labelstyle]){
	$filedir=opendir(ROOT_PATH."data/style/");
	while($file=readdir($filedir)){
		if(ereg("\.php$",$file)){
			include ROOT_PATH."data/style/$file";
			$show.="<div class=\"liststyles\"><span>风格名称:<em>".$styledb[name]."</em></span><a href=\"index.php?lfj=$lfj&action=out&style=".$styledb[keywords]."\">点击导出</a></div>\n";
		}
	}
	hack_admin_tpl('labelstyle');
	exit;

}elseif($job == "in" && $Apower[labelstyle]){

	hack_admin_tpl('labelstyle');
	exit;

}elseif($action=='out' && $style && $Apower[labelstyle]){

	$query = $db->query("SELECT * FROM `{$pre}label` WHERE `style`='$style'");
	while($rs = $db->fetch_array($query)){
		$rs[code]=str_replace($pre,'qb_',$rs[code]);
		$rs[code]=preg_replace("/s:([\d]+):\"(.*?)\";/e","strlen_lable('\\1','\\2')",$rs[code]);
		$rs[code]=mysql_escape_string($rs[code]);
		$rs[divcode]=mysql_escape_string($rs[divcode]);
		$code .= "INSERT INTO `qb_label` (`name`,`ch`,`chtype`,`tag`,`type`,`typesystem`,`code`,`divcode`,`hide`,`js_time`,`uid`,`username`,`posttime`,`pagetype`,`module`,`fid`,`if_js`,`style`) VALUES('$rs[name]','$rs[ch]','$rs[chtype]','$rs[tag]','$rs[type]','$rs[typesystem]','$rs[code]','$rs[divcode]','$rs[hide]','$rs[js_time]','$rs[uid]','$rs[username]','$rs[posttime]','$rs[pagetype]','$rs[module]','$rs[fid]','$rs[if_js]','$rs[style]');\r\n";
			
	}
	ob_end_clean();
	header('Last-Modified: '.gmdate('D, d M Y H:i:s',time()).' GMT');
	header('Pragma: no-cache');
	header('Content-Encoding: none');
	header('Content-Disposition: attachment; filename='.$style.'_label.sql');
	header('Content-type: .sql');
	//header('Content-Length: '.strlen($code));
	echo $code;
	exit;
}
elseif($action=='sql' && $Apower[labelstyle]){
	$filesql = read_file(ROOT_PATH."$webdb[updir]/$upsql");
	$filesql = str_replace("qb_", "{$pre}", $filesql);
	$db->insert_file('',$filesql);
	if(strlen($pre)!=3){
		$query = $db->query("SELECT * FROM {$pre}label WHERE typesystem=1");
		while($rs = $db->fetch_array($query)){
			$rs[code]=preg_replace("/s:([\d]+):\"(.*?)\";/e","strlen_lable('\\1','\\2')",$rs[code]);
			$rs[code]=addslashes($rs[code]);
			$db->query("UPDATE {$pre}label SET code='$rs[code]' WHERE lid='$rs[lid]'");
		}	
	}
	@unlink(ROOT_PATH."$webdb[updir]/$upsql");
	jump("如果网页上方没出现乱码，则操作成功","index.php?lfj=$lfj&job=in",10);	
}

function strlen_lable($num,$sring){
	$sring=stripslashes($sring);
	$num=strlen($sring);
	return "s:$num:\"$sring\";";
}

?>