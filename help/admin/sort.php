<?php
function_exists('html') OR exit('ERR');

$linkdb=array(
			  "栏目管理"=>"$admin_path&job=listsort&type=all"
			);

if($job=="post" && ck_power('sort_post'))
{
	unset($listdb,$linkdb);
	$listdb=array();
	list_m_allsort($fid,0);

	get_admin_html('post');
}
elseif($job=="listsort" && ck_power('sort_listsort'))
{
	$type='all';
	
	$SQL='';
	$fid=intval($fid);
	if($step==2){
		if($Type=='name'){
			$SQL=" S.name LIKE '%$name%' ";
		}else{
			$SQL=" S.fid='$name' ";
		}
	}
	elseif($type=="all"){
		$SQL='1';
	}
	else{
		$SQL=" S.fup='$fid' ";
	}

	$fup_select=select_wn_bigsort("fid",$fid);

	$sortdb=array();
	$rows=500;
	if(!$page){
		$page=1;
	}
	$min=($page-1)*$rows;
	$query = $db->query("SELECT S.* FROM {$_pre}sort S WHERE $SQL ORDER BY S.list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		if($rs[type]==2){
			$rs[_type]="单篇文章";
			$rs[_alert]="onclick=\"alert('单篇文章下不能有栏目,但分类下可以有栏目');return false;\" style='color:#ccc;'";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('单篇文章下不能有多篇文章内容,也不能发表多篇文章内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}elseif($rs[type]==1){
			$rs[_type]="分类";
			$rs[_alert]="";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('分类下不能有内容,也不能发表内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}else{
			$rs[_type]="栏目";
			$rs[color]="";
			$rs[_alert]="onclick=\"alert('栏目下不能有栏目,但分类下可以有栏目');return false;\" style='color:#ccc;'";
			$rs[_ifcontent]="";
		}
		$listdb[]=$rs;
	}
	//$showpage=getpage("{$_pre}sort S","WHERE $SQL","sort.php?job=$job&type=$type&fid=$fid",$rows);

	//@extract($db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}sort"));
	if($type=='all'){
		unset($listdb);
		$listdb=array();
		list_m_allsort($fid,0);
	}


	get_admin_html('sort');
}
elseif($action=="addsort")
{
	$name=filtrate($name);
	$db->query("INSERT INTO {$_pre}sort (name,fup,type,allowcomment,mid) VALUES ('$name','$fid','$Type',1,'1') ");
	@extract($db->get_one("SELECT fid FROM {$_pre}sort ORDER BY fid DESC LIMIT 0,1"));
	mod_sort_class("{$_pre}sort",0,0);		//更新class
	mod_sort_sons("{$_pre}sort",0);			//更新sons
	fid_wn_cache();
	refreshto("$admin_path&job=editsort&fid=$fid","创建成功");
}

//修改栏目信息
elseif($job=="editsort")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT S.* FROM {$_pre}sort S WHERE S.fid='$fid'");
	if($rsdb[type]){
		 $smallsort='none;';
	}else{
		$bigsort='none;';
	}
	


	
	$group_post=group_box("postdb[allowpost]",explode(",",$rsdb[allowpost]));
	//$group_viewtitle=group_box("postdb[allowviewtitle]",explode(",",$rsdb[allowviewtitle]));
	$group_viewcontent=group_box("postdb[allowviewcontent]",explode(",",$rsdb[allowviewcontent]));
	//$group_download=group_box("postdb[allowdownload]",explode(",",$rsdb[allowdownload]));
	$typedb[$rsdb[type]]=" checked ";
	$index_show[$rsdb[index_show]]=" checked ";

	$forbidshow[intval($rsdb[forbidshow])]=" checked ";
	$allowcomment[intval($rsdb[allowcomment])]=" checked ";

	$listorder[$rsdb[listorder]]=" selected ";

	

	$tpl=unserialize($rsdb[template]);

	if($db->get_one(" SELECT * FROM {$_pre}content WHERE fid='$fid' limit 1 ")){
		$moresons="none;";
	}
	
	//$photo_fid=$Guidedb->Select("{$pre}sort","postdb[photo_fid]",$rsdb[photo_fid]);
	//$article_fid=$Guidedb->Select("{$pre}sort","postdb[article_fid]",$rsdb[article_fid]);

	$select_fid=select_wn_bigsort("postdb[fup]",$rsdb[fup]);


	$array=unserialize($rsdb[config]);

	$sonListorder[$array[sonListorder]]=" selected ";
	$ListShowType[$array[ListShowType]]=" selected ";

	$_array=array_flip($array[is_html]);

	foreach( $array[field_db] AS $key=>$rs){
		if(in_array($key,$_array)){
			$array[field_value][$key]=En_TruePath($array[field_value][$key],0);
		}
		$TempLate.=make_post_sort_table($rs,$array[field_value][$key]);
	}
	
	$rsdb[descrip]=En_TruePath($rsdb[descrip],0);

	if($rsdb[type]==2){
		$rsdb[descrip]=editor_replace($rsdb[descrip]);
		$tpl['list'] || $tpl['list']="template/default/alonepage.htm";
	}else{
		$rsdb[descrip]=str_replace("<","&lt;",$rsdb[descrip]);
		$rsdb[descrip]=str_replace(">","&gt;",$rsdb[descrip]);
	}

	get_admin_html('editsort');
}
elseif($action=="editsort")
{
	//检查父栏目是否有问题
	check_fup("{$_pre}sort",$postdb[fid],$postdb[fup]);
	$postdb[allowpost]=@implode(",",$postdb[allowpost]);
	$postdb[allowviewtitle]=@implode(",",$postdb[allowviewtitle]);
	$postdb[allowviewcontent]=@implode(",",$postdb[allowviewcontent]);
	//$postdb[allowdownload]=@implode(",",$postdb[allowdownload]);
	$postdb[template]=@serialize($postdb[tpl]);
	unset($SQL);

	//$rs_fid=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$postdb[fid]'");
	//这样处理是其他地方也修改过这个值.比如标签里

	if($postdb[admin])
	{
		$detail=explode(",",$postdb[admin]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				unset($detail[$key]);
				continue;
			}
			if(!$userDB->get_info($username,'value')){
				showerr("你设置的栏目管理员帐号不存在:$value");
			}
		}
		$admin_str=implode(",",$detail);
		if($admin_str){
			$postdb[admin]=",$admin_str,";
		}else{
			$postdb[admin]='';
		}
	}
	
	
	$_sql='';
	foreach( $Together AS $key=>$value ){
		$_sql.="`$key`='{$postdb[$key]}',";
	}
	if($_sql){
		$_sql.="sons=sons";
		$db->query("UPDATE {$_pre}sort SET $_sql WHERE fup='$postdb[fid]'");
	}

	$rs_fid=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$postdb[fid]'");

	/*缺少对版主有效用户名的检测*/
	$postdb[admin]=str_Replace("，",",",$postdb[admin]);

	$m_config=unserialize($rs_fid[config]);

	$m_config[sonTitleRow]=$sonTitleRow;
	$m_config[sonTitleLeng]=$sonTitleLeng;
	$m_config[cachetime]=$cachetime;
	$m_config[sonListorder]=$sonListorder;
	$m_config[listContentNum]=$listContentNum;
	$m_config[ListShowType]=$ListShowType;

	foreach( $m_config[is_html] AS $key=>$value){
		$cpostdb[$key]=En_TruePath($cpostdb[$key]);
	}
	
	$_array=array_flip($m_config[is_html]);

	foreach( $cpostdb AS $key=>$value){
		$cpostdb[$key]=stripslashes($cpostdb[$key]);
		if(is_array($value))
		{
			$cpostdb[$key]=implode("/",$value);
		}
		elseif(!@in_array($key,$_array))
		{
			//$postdb[$key]=filtrate($value);
		}
	}
	$m_config[field_value]=$cpostdb;
	$postdb[config]=addslashes(serialize($m_config));

	$postdb[descrip]=En_TruePath($postdb[descrip]);
	
	$postdb[name]=filtrate($postdb[name]);

	$db->query("UPDATE {$_pre}sort SET mid='$postdb[mid]',fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',allowdownload='$postdb[allowdownload]',forbidshow='$postdb[forbidshow]',config='$postdb[config]'$SQL WHERE fid='$postdb[fid]' ");

	//修改栏目名称之后,内容的也要跟着修改
	if($rs_fid[name]!=$postdb[name])
	{
		$db->query(" UPDATE {$_pre}content SET fname='$postdb[name]' WHERE fid='$postdb[fid]' ");
	}
	mod_sort_class("{$_pre}sort",0,0);		//更新class
	mod_sort_sons("{$_pre}sort",0);			//更新sons
	fid_wn_cache();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="delete")
{
	$_rs=$db->get_one("SELECT * FROM `{$_pre}sort` WHERE fup='$fid'");
	if($_rs){
		showerr("有子栏目你不能删除,请先删除或移走子栏目,再操作");
	}
	$db->query(" DELETE FROM `{$_pre}sort` WHERE fid='$fid' ");
	$db->query(" DELETE FROM `{$_pre}content` WHERE fid='$fid' ");
	$db->query(" DELETE FROM `{$_pre}content_1` WHERE fid='$fid' ");
	mod_sort_class("{$_pre}sort",0,0);		//更新class
	mod_sort_sons("{$_pre}sort",0);			//更新sons
	fid_wn_cache();
	refreshto("$admin_path&job=listsort","删除成功");
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}sort SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$_pre}sort",0,0);		//更新class
	mod_sort_sons("{$_pre}sort",0);			//更新sons
	fid_wn_cache();
	refreshto("$FROMURL","修改成功",1);
}
elseif($job=="listfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");

	$array=unserialize($rsdb[config]);

	$listdb=$array[field_db];
	

	get_admin_html('listfield');
}
elseif($job=="addfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");

	get_admin_html('editfield');
}
elseif($action=="addfield")
{
	if(!ereg("^([a-z])([a-z0-9_]+)",$postdb[field_name])){
		showerr("-字段ID不符合规则");
	}
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$field_name=$postdb[field_name];
	$array=unserialize($rsdb[config]);
	$array[field_db][$field_name]=$postdb;

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
	$config=addslashes(serialize($array));
	$db->query("UPDATE {$_pre}sort SET config='$config' WHERE fid='$fid' ");

	refreshto("$admin_path&job=editfield&fid=$fid&field_name=$field_name","添加成功");
}
elseif($job=="editfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$array=unserialize($rsdb[config]);
	$_rs=$array[field_db][$field_name];
	$form_type[$_rs[form_type]]=" selected ";
	$field_type[$_rs[field_type]]=" selected ";

	get_admin_html('editfield');
}
elseif($action=="editfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");

	$array=unserialize($rsdb[config]);

	$field_array=$array[field_db][$field_name];

	if(!ereg("^([a-z])([a-z0-9_]+)",$postdb[field_name])){
		showerr("字段ID不符合规则");
	}
	unset($array[field_db][$field_name]);
	$array[field_db]["{$postdb[field_name]}"]=$postdb;

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
	$config=addslashes(serialize($array));
	$db->query("UPDATE {$_pre}sort SET config='$config' WHERE fid='$fid' ");
	refreshto("$admin_path&job=editfield&fid=$fid&field_name=$postdb[field_name]","修改成功",10);
}
elseif($action=="delfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$array=unserialize($rsdb[config]);
	unset($array[field_db][$field_name]);
	unset($array[field_value][$field_name]);
	$config=addslashes(serialize($array));
	$db->query("UPDATE {$_pre}sort SET config='$config' WHERE fid='$fid' ");
	refreshto($FROMURL,"删除成功");
}
elseif($action=="editorder")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$array=unserialize($rsdb[config]);
	$field_db=$array[field_db];

	foreach( $field_db AS $key=>$value){
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
	$array[field_db]=$listdb;


	$config=addslashes(serialize($array));
	$db->query("UPDATE {$_pre}sort SET config='$config' WHERE fid='$fid' ");
	refreshto("$admin_path&job=listfield&fid=$fid","修改成功",10);
}
elseif($action=="copyfield")
{
	$rs=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$ofid=str_replace("，",",",$ofid);
	$detail=explode(",",$ofid);
	$rs[config]=addslashes($rs[config]);
	foreach( $detail AS $key=>$value){
		$db->query("UPDATE {$_pre}sort SET config='$rs[config]' WHERE fid='$value' ");
	}
	
	refreshto("$admin_path&job=listfield&fid=$fid","复制成功",10);
}






function make_post_sort_table($rs,$cvalue){
	if($rs[form_type]=='text')
	{
		$show="<tr> <td >{$rs[title]}:<br>{$rs[form_title]}</td> <td > <input type='text' name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='50' value='$cvalue'> </td></tr>";
	}
	elseif($rs[form_type]=='upfile')
	{
		$show="<tr> <td >{$rs[title]}:<br>{$rs[form_title]}</td> <td > <input type='text' name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' size='50' value='$cvalue'> <br><iframe frameborder=0 height=23 scrolling=no src='upfile.php?fn=upfile&dir=info$fid&label=atc_{$rs[field_name]}' width=310></iframe> </td></tr>";
	}
	elseif($rs[form_type]=='textarea')
	{
		$show="<tr><td >{$rs[title]}:<br>{$rs[form_title]}</td><td ><textarea name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' cols='70' rows='8'>$cvalue</textarea></td></tr>";
	}
	elseif($rs[form_type]=='ieedit')
	{
		$cvalue=editor_replace($cvalue);
		$show="<tr><td >{$rs[title]}:<br>{$rs[form_title]}</td><td ><iframe id='eWebEditor1' src='../../ewebeditor/ewebeditor.php?id=atc_{$rs[field_name]}&style=standard' frameborder='0' scrolling='no' width='100%' height='350'></iframe><input name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' type='hidden' value='$cvalue'></td></tr>";
	}
	elseif($rs[form_type]=='select')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$cvalue==$v1?$ckk=" selected ":$ckk="";
			$_show.="<option value='$v1' $ckk>$v2</option>";
		}
		$show="<tr> <td >{$rs[title]}:<br>{$rs[form_title]}</td><td > <select name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}'>$_show</select> </td> </tr>";
	}
	elseif($rs[form_type]=='radio')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$cvalue==$v1?$ckk=" checked ":$ckk="";
			$_show.="<input type='radio' name='cpostdb[{$rs[field_name]}]' value='$v1' $ckk>$v2";
		}
		$show="<tr> <td >{$rs[title]}:<br>{$rs[form_title]}</td> <td >$_show</td></tr>";
	}
	elseif($rs[form_type]=='checkbox')
	{
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				continue;
			}
			list($v1,$v2)=explode("|",$value);
			$v2 || $v2=$v1;
			$_d=explode("/",$cvalue);
			@in_array($v1,$_d)?$ckk=" checked ":$ckk="";
			$_show.="<input type='checkbox' name='cpostdb[{$rs[field_name]}][]' value='$v1' $ckk>$v2";
		}
		$show="<tr> <td >{$rs[title]}:<br>{$rs[form_title]}</td> <td >$_show</td></tr>";
	}
	return $show;
}


/*栏目列表*/
function list_m_allsort($fid,$Class){
	global $db,$_pre,$listdb;
	$Class++;
	$query=$db->query("SELECT S.* FROM {$_pre}sort S WHERE S.fup='$fid' ORDER BY S.list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$Class;$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		//$rs[config]=unserialize($rs[config]);
		$rs[icon]=$icon;
		if($rs[type]==2){
			$rs[_type]="单篇文章";
			$rs[_alert]="onclick=\"alert('单篇文章下不能有栏目,但分类下可以有栏目');return false;\" style='color:#ccc;'";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('单篇文章下不能有多篇文章内容,也不能发表多篇文章内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}elseif($rs[type]==1){
			$rs[_type]="分类";
			$rs[_alert]="";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('分类下不能有内容,也不能发表内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}else{
			$rs[_type]="栏目";
			$rs[_alert]="onclick=\"alert('栏目下不能有栏目,但分类下可以有栏目');return false;\" style='color:#ccc;'";
			$rs[_ifcontent]="";
			$rs[color]="";
		}
		$listdb[]=$rs;
		list_m_allsort($rs[fid],$Class);
	}
}

/*栏目列表*/
function select_wn_bigsort_in($fid,$Class,$ckfid){
	global $db,$_pre,$listdb;
	$Class++;
	$query=$db->query("SELECT * FROM {$_pre}sort WHERE fup='$fid' AND type=1 ORDER BY list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$Class;$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-12);
			$icon.="--";
		}
		
		$rs[icon]=$icon;
		if($rs[type])
		{
			$ck=$ckfid==$rs[fid]?' selected ':'';
			$show.="<option value='$rs[fid]' $ck>$icon$rs[name]</option>";
		}
		$show.=select_wn_bigsort_in($rs[fid],$Class,$ckfid);
	}
	return $show;
}

function select_wn_bigsort($name,$ckfid)
{
	$show="<select name='$name'><option value='0'>请选择</option>";
	$show.=select_wn_bigsort_in(0,0,$ckfid);
	$show.="</select>";
	return $show;
}



function get_wn_sguide($fid,$url){
	global $db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	while($rs = $db->fetch_array($query)){
		$show=" -&gt; <A href='list.php?fid=$rs[fid]'>$rs[name]</A>".$show;
		if($rs[fup]){
			$show=get_wn_sguide($rs[fup],$url).$show;
		}
	}
	return $show;
}

function fid_wn_cache(){
	global $db,$_pre,$webdb;
	$query = $db->query("SELECT * FROM {$_pre}sort ORDER BY list DESC LIMIT 800");
	while($rs = $db->fetch_array($query)){

		if($rs[tableid]){
			$Fid_db[tableid][$rs[fid]]=$rs[tableid];
		}

		$Fid_db[$rs[fup]][$rs[fid]]=$rs[name];
		$Fid_db[name][$rs[fid]]=$rs[name];
		$Fid_db[mid][$rs[fid]]=intval($rs[mid]);

		$GuideFid[$rs[fid]]=get_wn_sguide($rs[fid]);
	}

	write_file(Mpath."data/all_fid.php","<?php\r\n\$Fid_db=".var_export($Fid_db,true).';?>');
	write_file(Mpath."data/guide_fid.php","<?php\r\n\$GuideFid=".var_export($GuideFid,true).';?>');
}
?>