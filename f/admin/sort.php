<?php
function_exists('html') OR exit('ERR');

ck_power('sort');

$linkdb=array(
			  "栏目管理"=>"$admin_path&job=listsort","批量操作"=>"$admin_path&job=batch"
			);

if($fid){
	$linkdb["修改栏目"]="$admin_path&job=editsort&fid=$fid";
	$linkdb["全部字段"]="$admin_path&job=listfield&fid=$fid";
	$linkdb["增加字段"]="$admin_path&job=addfield&fid=$fid";
}

if($job=="listsort")
{
	foreach( $Fid_db[0] AS $key=>$value){
		$cityid=$key;
		break;
	}

	$labelUrl="$webdb[www_url]/list.php?choose_cityID=$cityid&jobs=show";

	if(is_file(ROOT_PATH."cache/table.txt")){
		$url=read_file(ROOT_PATH."cache/table.txt");
		die("注意:<A HREF='$url'>上一次分表中途失败,请点击继续</A>");
	}
	$fup_select=choose_sort(0,0,0);

	$listdb=array();
	M_list_allsort(intval($fup),0);
	$module_select=select_module($name="mid",$rsdb[mid]);
	//$gudie=get_guide($fid,"?job=listsort&fid=");

	get_admin_html('sort');
}
elseif($action=="addsort")
{
	if(!$Type&&!$mid){
		showerr("创建栏目,必须要选择一个模型");
	}

	$detail=explode("\r\n",$name);
	foreach( $detail AS $key=>$name){
		if(!$name){
			continue;
		}
		$name=filtrate($name);
		$db->query("INSERT INTO {$_pre}sort (name,fup,type,allowcomment,mid) VALUES ('$name','$fid','$Type',1,'$mid') ");
	}
	//@extract($db->get_one("SELECT fid FROM {$_pre}sort ORDER BY fid DESC LIMIT 0,1"));
	fid_cache();
	//refreshto("?job=editsort&fid=$fid","创建成功");
	refreshto("$admin_path&job=listsort","创建成功");
}

//修改栏目信息
elseif($job=="editsort")
{

	$rsdb=$db->get_one("SELECT S.*,M.name AS m_name FROM {$_pre}sort S LEFT JOIN {$_pre}module M ON S.mid=M.id WHERE S.fid='$fid'");

	if($rsdb[type]){
		 $smallsort='none;';
	}else{
		$bigsort='none;';
	}

	$_module="<select name='postdb[mid]'><option value=''>请选择所属模型</option>";
	$query = $db->query("SELECT * FROM {$_pre}module ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$rs[id]==$rsdb[mid]?' selected ':'';
		$_module.="<option value='$rs[id]' $ckk>$rs[name]</option>";
	}
	$_module.="</select>";


	$group_post=group_box("postdb[allowpost]",explode(",",$rsdb[allowpost]));
	//$group_viewtitle=group_box("postdb[allowviewtitle]",explode(",",$rsdb[allowviewtitle]));
	//$group_viewcontent=group_box("postdb[allowviewcontent]",explode(",",$rsdb[allowviewcontent]));
	//$group_download=group_box("postdb[allowdownload]",explode(",",$rsdb[allowdownload]));
	$typedb[$rsdb[type]]=" checked ";
	$index_show[$rsdb[index_show]]=" checked ";

	$forbidshow[intval($rsdb[forbidshow])]=" checked ";
	$allowcomment[intval($rsdb[allowcomment])]=" checked ";
	$ifcolor[intval($rsdb[ifcolor])]=" checked ";

	$listorder[$rsdb[listorder]]=" selected ";

	$tpl=unserialize($rsdb[template]);

	$select_style=select_style('postdb[style]',$rsdb[style]);


	$array=unserialize($rsdb[config]);

	$_array=array_flip($array[is_html]);

	foreach( $array[field_db] AS $key=>$rs){
		if(in_array($key,$_array)){
			$array[field_value][$key]=En_TruePath($array[field_value][$key],0);
		}
		$TempLate.=make_post_sort_table($rs,$array[field_value][$key]);
	}

	$fup_select=choose_sort(0,0,$rsdb[fup]);

	if(!$rsdb[dir_name]){
		require_once(ROOT_PATH."inc/pinyin.php");
		$rsdb[dir_name]=change2pinyin($rsdb[name],0);
	}
	$rsdb[dir_name]=preg_replace("/(\/|\\\|-)/","_",$rsdb[dir_name]);

	get_admin_html('editsort');
}
elseif($action=="editsort")
{
	if($postdb[dir_name]&&!eregi("^([_a-z0-9]+)$",$postdb[dir_name])){
		showerr("目录名只能是英文或数字或下画线");
	}
	$_erp=$Fid_db[tableid][$postdb[fid]];
	if($postdb[type]&&$db->get_one(" SELECT * FROM {$_pre}content$_erp WHERE fid='$postdb[fid]' limit 1 ")){
		 showerr("当前栏目已经有内容了,你要修改成分类的话,请先删除本栏目里的内容或把内容移走");
	}
	if($postdb[dir_name]&&$db->get_one("SELECT * FROM {$_pre}sort WHERE dir_name='$postdb[dir_name]' AND fid!='$postdb[fid]' ")){
		 showerr("当前目录名已经存在了,请更换一个.");
	}

	$rs_fid=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$postdb[fid]'");

	if($postdb[mid]!=$rs_fid[mid]&&$db->get_one(" SELECT * FROM {$_pre}content WHERE fid='$postdb[fid]' limit 1 ")){
		 showerr("当前栏目已经有内容了,你要修改成其他模型的话,请先删除本栏目里的内容或把内容移走");
	}

	//检查父栏目是否有问题
	check_fup("{$_pre}sort",$postdb[fid],$postdb[fup]);
	$postdb[allowpost]=@implode(",",$postdb[allowpost]);
	//$postdb[allowviewtitle]=@implode(",",$postdb[allowviewtitle]);
	//postdb[allowviewcontent]=@implode(",",$postdb[allowviewcontent]);
	//$postdb[allowdownload]=@implode(",",$postdb[allowdownload]);
	$postdb[template]=@serialize($postdb[tpl]);
	unset($SQL);

	$postdb[admin]=str_Replace("，",",",$postdb[admin]);
	if($postdb[admin])
	{
		$detail=explode(",",$postdb[admin]);
		foreach( $detail AS $key=>$value){
			if(!$value){
				unset($detail[$key]);
				continue;
			}
			if( !$userDB->get_info($username,'value') ){
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



	$m_config=unserialize($rs_fid[config]);

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

	$postdb[name]=filtrate($postdb[name]);
	$postdb[dir_name]=preg_replace("/(\/|\\\|-)/","_",$postdb[dir_name]);
	$db->query("UPDATE {$_pre}sort SET mid='$postdb[mid]',fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',metatitle='$postdb[metatitle]',metakeywords='$postdb[metakeywords]',metadescription='$postdb[metadescription]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',allowdownload='$postdb[allowdownload]',forbidshow='$postdb[forbidshow]',config='$postdb[config]',index_show='$postdb[index_show]',ifcolor='$postdb[ifcolor]',dir_name='$postdb[dir_name]'$SQL WHERE fid='$postdb[fid]' ");

	//修改栏目名称之后,内容的也要跟着修改
	if($rs_fid[name]!=$postdb[name])
	{
		$_erp=$rs_fid[tableid];
		$db->query(" UPDATE {$_pre}content$_erp SET fname='$postdb[name]' WHERE fid='$postdb[fid]' ");
	}
	fid_cache();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="delete")
{
	if($fid){
		$fiddb[$fid]=$fid;
	}else{
		foreach( $fiddb AS $key=>$value){
			$i++;
			$fiddb[$key]=$i;
		}
	}
	arsort($fiddb);
	foreach( $fiddb AS $fid=>$value){
		$_rs=$db->get_one("SELECT * FROM `{$_pre}sort` WHERE fup='$fid'");
		if($_rs){
			showerr("分类有子栏目你不能删除,请先删除或移走子栏目,再删除分类");
		}
		$rs=$db->get_one("SELECT * FROM `{$_pre}sort` WHERE fid='$fid'");
		$db->query(" DELETE FROM `{$_pre}sort` WHERE fid='$fid' ");
		$db->query(" DELETE FROM `{$_pre}content{$rs[tableid]}` WHERE fid='$fid' ");
		$db->query(" DELETE FROM `{$_pre}content_{$rs[mid]}` WHERE fid='$fid' ");
		$db->query(" DELETE FROM `{$_pre}db` WHERE fid='$fid' ");

		if($rs[tableid]!='' && !$db->get_one("SELECT * FROM `{$_pre}sort` WHERE tableid='$rs[tableid]'") ){
			$db->query(" DROP TABLE IF EXISTS `{$_pre}content{$rs[tableid]}`");
		}

	}
	fid_cache();
	refreshto("$admin_path&job=listsort","删除成功");
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}sort SET list='$value' WHERE fid='$key' ");
	}
	fid_cache();
	refreshto("$FROMURL","修改成功",1);
}
elseif($job=="listfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");

	$array=unserialize($rsdb[config]);

	$listdb=$array[field_db];

	//$gudie=get_guide($fid,"?job=listsort&fid=");

	get_admin_html('listfield');
}
elseif($job=="addfield")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	//$gudie=get_guide($fid,"?job=listsort&fid=");
	
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
	//$gudie=get_guide($fid,"?job=listsort&fid=");
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
elseif($job=="batch")
{
	get_admin_html('batch');
}
elseif($action=="batch")
{
	$ck=0;
	require_once(ROOT_PATH."inc/pinyin.php");
	if($type=="sort_dir"){
		$query = $db->query("SELECT * FROM {$_pre}sort");
		while($rs = $db->fetch_array($query)){
			if(!$rs['dir_name']||$re_write_dir){
				$rs['dir_name']=$big_letter?change2pinyin($rs[name],1):change2pinyin($rs[name]);
				$rs['dir_name']=preg_replace("/(\/|\\\|-|'| )/","_",$rs['dir_name']);
				if($db->get_one("SELECT * FROM {$_pre}sort WHERE dir_name='{$rs[dir_name]}' AND fid!='$rs[fid]' ")){
					$rs[dir_name]="$rs[dir_name]$rs[fid]";
				}
				$db->query("UPDATE {$_pre}sort SET dir_name='{$rs[dir_name]}' WHERE fid='$rs[fid]'");
				$ck++;
			}
		}
		fid_cache();
	}
	refreshto("$admin_path&job=$action","执行完毕,共设置了 {$ck} 个栏目",3);
}
//分表
elseif($job=='table')
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	$tableid=$rsdb[tableid]?$rsdb[tableid]:$fid;

	get_admin_html('table');
}
elseif($action=='table')
{
	if($tableid=='0'){
		showerr("分表名不能为0!");
	}
	if($tableid0==$tableid){
		showerr("提交失败,原分表名不能与新表名雷同!");
	}
	if($page<2){
		if( $tableid!='' && !ereg("^([a-z0-9]{1,30})$",$tableid) ){
			showerr("分表名不符合规则");
		}
		if( $dbcharset && mysql_get_server_info() > '4.1' ){
			$SQL=" DEFAULT CHARSET=$dbcharset ";
		}
		if( $tableid!='' && !is_table("{$_pre}content{$tableid}") ){
			$rs=$db->get_one("SHOW CREATE TABLE {$_pre}content ");
			$sql=str_replace(array("{$_pre}content",";"),array("{$_pre}content{$tableid}",""),$rs['Create Table']);
			if(mysql_get_server_info() > '4.1'){
				if(!strstr($sql,'DEFAULT CHARSET')){
					$sql.=$SQL;
				}		
			}
			$db->query($sql);
		}
		$db->query("UPDATE `{$_pre}sort` SET tableid='$tableid' WHERE fid='$fid'");
		fid_cache();
	}
	if(!$page){
		$page=1;
	}
	$rows=50;
	$min=($page-1)*$rows;
	$fieldDB=table_field("{$_pre}content{$tableid0}");
	$query = $db->query("SELECT * FROM {$_pre}content{$tableid0} WHERE fid='$fid' ORDER BY id ASC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
	
		$SQL="INSERT INTO {$_pre}content$tableid SET ";
		foreach( $fieldDB AS $key=>$value){
			if( $rs[$value] && !is_numeric($rs[$value]) ){
				$rs[$value]=addslashes($rs[$value]);
			}
			$SQL.="`{$value}`='{$rs[$value]}',";
		}
		$SQL=substr($SQL,0,-1);
		$db->query($SQL);
		$ckk++;
	}
	if($ckk){
		$page++;
		write_file(ROOT_PATH."cache/table.txt","$admin_path&action=$action&tableid=$tableid&tableid0=$tableid0&fid=$fid&page=$page");
		echo "请稍候...$page<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$admin_path&action=$action&tableid=$tableid&tableid0=$tableid0&fid=$fid&page=$page'>";
		exit;
	}else{
		$db->query("DELETE FROM {$_pre}content{$tableid0} WHERE fid='$fid'");
		$db->query(" OPTIMIZE TABLE {$_pre}content{$tableid0} ");
		if($tableid0!='' && !$db->get_one("SELECT * FROM `{$_pre}sort` WHERE tableid='$tableid0'") ){
			$db->query(" DROP TABLE IF EXISTS `{$_pre}content{$tableid0}`");
		}
		unlink(ROOT_PATH."cache/table.txt");
		refreshto("$admin_path&job=listsort","操作成功","1");
	}
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
		$show="<tr><td >{$rs[title]}:<br>{$rs[form_title]}</td><td ><iframe id='eWebEditor1' src='ewebeditor/ewebeditor.php?id=atc_{$rs[field_name]}&style=standard' frameborder='0' scrolling='no' width='100%' height='350'></iframe><input name='cpostdb[{$rs[field_name]}]' id='atc_{$rs[field_name]}' type='hidden' value='$cvalue'></td></tr>";
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
function M_list_allsort($fid,$Class){
	global $db,$_pre,$listdb;
	$Class++;
	$query=$db->query("SELECT S.*,M.name AS m_name FROM {$_pre}sort S LEFT JOIN {$_pre}module M ON S.mid=M.id where S.fup='$fid' ORDER BY S.list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$Class;$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($rs['class']!=$Class){
			$db->query("UPDATE {$_pre}sort SET class='$Class' WHERE fid='$rs[fid]'");
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		//$rs[config]=unserialize($rs[config]);
		$rs[icon]=$icon;
		if($rs[type]){
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
		if($Class>1&&$rs[type]&&$db->get_one("SELECT fid FROM {$_pre}sort WHERE fup='$rs[fid]'")){
			global $admin_path;
			$rs[more] = " <A HREF='$admin_path&&job=listsort&fup=$rs[fid]' target='_blank' style='color:red;'>+</A> ";
		}else{
			$rs[more] = "";
		}

		$listdb[]=$rs;

		//只显示多少级的栏目
		if($Class<2)M_list_allsort($rs[fid],$Class);
	}
}

function choose_sort($fid,$class,$ck=0)
{
	global $db,$_pre;
	for($i=0;$i<$class;$i++){
		$icon.="&nbsp;&nbsp;&nbsp;&nbsp;";
	}
	$class++;
	$query = $db->query("SELECT * FROM {$_pre}sort WHERE fup='$fid' AND type=1 ORDER BY list DESC LIMIT 500");
	while($rs = $db->fetch_array($query)){
		$ckk=$ck==$rs[fid]?' selected ':'';
		$fup_select.="<option value='$rs[fid]' $ckk>$icon|-$rs[name]</option>";
		$fup_select.=choose_sort($rs[fid],$class,$ck);
	}
	return $fup_select;
}
?>