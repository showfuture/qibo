<?php
function_exists('html') OR exit('ERR');


$linkdb=array(
//"核心设置"=>"$admin_path&job=config",

);
if($job)
{
	$query=$db->query("SELECT * FROM {$_pre}config ");
	while( $rs=$db->fetch_array($query) ){
		$webdb[$rs[c_key]]=$rs[c_value];
	}
}

if($job=="config" && ck_power('center_config'))
{
	$webdb[Info_webOpen]?$Info_webOpen1='checked':$Info_webOpen0='checked';
	$Info_forbidOutPost[intval($webdb[Info_forbidOutPost])]=' checked ';
	$Info_NewsMakeHtml[$webdb[Info_NewsMakeHtml]]=' checked ';
	$UseArea[intval($webdb[UseArea])]=' checked ';
	$allowGroupPost=group_news_box("webdbs[allowGroupPost]",explode(",",$webdb[allowGroupPost]),1);

	//$GroupPostpassyz=group_news_box("webdbs[GroupPostYZ]",explode(",",$webdb[GroupPostYZ]),1);

	$Info_GroupPostYZ=group_news_box("webdbs[Info_GroupPostYZ]",explode(",",$webdb[Info_GroupPostYZ]),1);

 	$InfoShowComment[intval($webdb[InfoShowComment])]=" checked ";
	$Info_PassCommentType[intval($webdb[Info_PassCommentType])]=" checked ";
	$Info_ShowCommentType[intval($webdb[Info_ShowCommentType])]=" checked ";
	$Info_PostCommentType[intval($webdb[Info_PostCommentType])]=" checked ";
	$yzImgComment[intval($webdb[yzImgComment])]=" checked ";
 
	$module_close[intval($webdb[module_close])]=" checked ";	

	get_admin_html('config');
}

elseif($action=="config" && ck_power('center_config'))
{
	if(isset($webdbs['module_close'])){
		$db->query("UPDATE {$pre}module SET ifclose='$webdbs[module_close]' WHERE id='$webdb[module_id]'");
		make_module_cache();
	}
	if(isset($webdbs[Info_MakeIndexHtmlTime])&&!$webdbs[Info_MakeIndexHtmlTime]&&$webdb[Info_MakeIndexHtmlTime]){
		@unlink(Mpath."index.htm.bak");
		rename(Mpath."index.htm",Mpath."index.htm.bak");
	}
	module_write_config_cache($webdbs);
	refreshto($FROMURL,"修改成功");

}elseif($job=="label" && ck_power('center_label')){
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$Murl/index.php?jobs=show'>";
	exit;
}


function group_news_box($name="postdb[group]",$ckdb=array(),$type=''){
	global $db,$pre;
	if($type==1){
		$SQL=" WHERE gid NOT IN(2) ";
	}
	$query=$db->query("SELECT * FROM {$pre}group $SQL ORDER BY gid ASC");
	while($rs=$db->fetch_array($query))
	{
		$checked=in_array($rs[gid],$ckdb)?"checked":"";
		$show.="<input type='checkbox' name='{$name}[]' value='{$rs[gid]}' $checked>&nbsp;{$rs[grouptitle]}&nbsp;&nbsp;";
	}
	return $show;
}

?>