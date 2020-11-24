<?php
function_exists('html') OR exit('ERR');

ck_power('module');

$linkdb["模块管理"]="$admin_path&job=listsort";
if($id){
	$linkdb["全部字段"]="$admin_path&job=editsort&id=$id";
	$linkdb["增加字段"]="$admin_path&job=addfield&id=$id";
	$linkdb["生成模块"]="$admin_path&job=tpl&id=$id";
}

//列出现有模型
if($job=="listsort")
{
	if(!table_field("{$_pre}module","template")){
		$db->query("ALTER TABLE `{$_pre}module` ADD `template` TEXT NOT NULL");
	}
	if($page<1){
		$page=1;
	}
	$rows=100;
	$min=($page-1)*$rows;
	$SQL=" WHERE 1 ";
	if($sort_id ){
		$SQL .=" AND A.sort_id='$sort_id' ";
	}
	$showpage=getpage("{$_pre}module A","$SQL","$admin_path&job=$job&sort_id=$sort_id","$rows");
	$query = $db->query("SELECT A.*,B.sort_name FROM {$_pre}module A LEFT JOIN {$_pre}module_sort B ON A.sort_id=B.sort_id $SQL ORDER BY A.sort_id ASC,A.list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$rss=$db->get_one("SELECT count(*) AS NUM FROM {$_pre}sort WHERE mid='$rs[id]' ");
		$rs[NUM]=$rss[NUM];
		$listdb[]=$rs;
	}
	$selectsortid="<select name='sort_id'><option value=''>请选择</option>";
	$query = $db->query("SELECT * FROM {$_pre}module_sort");
	while($rs = $db->fetch_array($query)){
		$selectsortid.="<option value='$rs[sort_id]'>$rs[sort_name]</option>";
	}
	$selectsortid.="</select>";

	get_admin_html('sort');
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}module SET list='$value' WHERE id='$key' ");
	}
	write_module_cache();
	refreshto("$FROMURL","修改成功",1);
}
elseif($action=="addsort")
{
	unset($SQL);
	if( $dbcharset && mysql_get_server_info() > '4.1' ){
		$SQL=" DEFAULT CHARSET=$dbcharset ";
	}

	if($fid){
		$type=0;
	}else{
		$type=1;
	}
	$field_db[content]=array(
		'title'=>'详情',
		'field_name'=>'content',
		'form_type'=>'textarea',
		'field_inputwidth'=>'400',
		'field_inputheight'=>'50',
		'field_type'=>'mediumtext'
		);
	$field_db[sortid]=array(
		'title'=>'类别',
		'field_name'=>'sortid',
		'field_type'=>'int',
		'field_leng'=>'3',
		'form_type'=>'radio',
		'form_set'=>"1|类别一\r\n2|类别二\r\n3|类别三",
		'listshow'=>'1',
		'listfilter'=>'1',
		'search'=>'1'
		);

	if($ifdp){
		$fendb[fen1][name]="总评";
		$fendb[fen2][name]="环境";
		$fendb[fen3][name]="服务";
		$fendb[fen4][name]="价位";
		$fendb[fen5][name]="喜欢程度";

		$fendb[fen1][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
		$fendb[fen2][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
		$fendb[fen3][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
		$fendb[fen4][set]="1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵";
		$fendb[fen5][set]="1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢";
		$config2=addslashes(serialize($fendb));
		$array[moduleSet]=array('useMap'=>1);
	
		$field_db[sortid]=array(
			'title'=>'人均消费',
			'field_name'=>'sortid',
			'field_type'=>'int',
			'field_leng'=>'3',
			'form_type'=>'radio',
			'form_set'=>"1|30元以下\r\n2|30~50元\r\n3|50~100元\r\n4|100~150元\r\n5|150~200元\r\n6|200~300元\r\n7|300元以上",
			'listshow'=>'1',
			'listfilter'=>'1',
			'search'=>'1'
		);

		$field_db[sortid2]=array(
			'title'=>'人均消费',
			'field_name'=>'sortid2',
			'field_type'=>'int',
			'field_leng'=>'3',
			'form_type'=>'radio',
			'form_set'=>"1|家庭聚会\r\n2|随便吃吃\r\n3|情侣约会\r\n4|商务洽谈\r\n5|朋友聚会\r\n6|工作午餐\r\n7|大型聚会",
			'listshow'=>'1',
			'listfilter'=>'1',
			'search'=>'1'
		);

		$sortid2_sql="`sortid2` tinyint(3) NOT NULL default '0',";
		$sortid2_sqlkey=",KEY `sortid2` (`sortid2`)";
	}
	$config=addslashes(serialize($array));
	$db->query("INSERT INTO {$_pre}module (name,config,sort_id,ifdp,config2) VALUES ('$name','$config','$sort_id','$ifdp','$config2') ");
	$id=$db->insert_id();

	foreach( $field_db AS $ar){
		$ar[mid]=$id;
		$sql_ar='';
		foreach($ar AS $key=>$value){
			$sql_ar[]="`$key`='$value'";
		}
		$sql=implode(",",$sql_ar);
		$db->query("INSERT INTO `{$_pre}field` SET $sql");
	}

	$SQL="CREATE TABLE `{$_pre}content_{$id}` (
		`rid` mediumint(7) NOT NULL auto_increment,
		`id` int(10) NOT NULL default '0',
		`fid` mediumint(7) NOT NULL default '0',
		`uid` mediumint(7) NOT NULL default '0',
		`content` mediumtext NOT NULL,
		`sortid` tinyint(3) NOT NULL default '0',	
		$sortid2_sql
		PRIMARY KEY  (`rid`),
		KEY `fid` (`fid`),
		KEY `id` (`id`),
		KEY `uid` (`uid`),
		KEY `sortid` (`sortid`) $sortid2_sqlkey
		) TYPE=MyISAM {$SQL} AUTO_INCREMENT=1 ;";
	$db->query($SQL);
	$Module_db->make_template($id);
	write_module_cache();
	refreshto("$admin_path&job=editsort&id=$id","创建成功");
}

//列出所有字段信息
elseif($job=="editsort")
{
	$rsdb = $Module_db->module_info($id);
	$listdb = $Module_db->list_field($id);

	get_admin_html('editsort');
}

elseif($action=="editsort")
{
	$db->query(" UPDATE {$_pre}module SET name='$name' WHERE id='$id' ");
	write_module_cache();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="editorder")
{
	foreach( $postdb AS $key=>$value){
		$db->query("UPDATE {$_pre}field SET orderlist='$value' WHERE mid='$id' AND field_name='$key'");
	}

	write_module_cache();
	$Module_db->make_template($id);
	refreshto("$admin_path&job=editsort&id=$id","修改成功",10);
}
elseif($job=="editfield")
{
	$rsdb = $Module_db->module_info($id);
	$field_db = $Module_db->list_field($id);
	$_rs = $field_db[$field_name];

	if($_rs[field_name]=='content'){
		$readonly=" readony ";
	}
	$_rs[field_leng]<1 && $_rs[field_leng]='';
	$search[$_rs[search]]=" checked ";
	$mustfill[$_rs[mustfill]]=" checked ";
	$form_type[$_rs[form_type]]=" selected ";
	$field_type[$_rs[field_type]]=" selected ";
	$listshow[intval($_rs[listshow])]=" checked ";
	$listfilter[intval($_rs[listfilter])]=" checked ";
	$group_view = group_box("postdb[allowview]",explode(",",$_rs[allowview]));
	$group_post=group_box("postdb[allowpost]",explode(",",$_rs[allowpost]));
	$select_db = $Module_db->list_class("postdb[classid]",$_rs[classid]);

	get_admin_html('editfield');
}
elseif($action=="editfield")
{
	$Module_db->edit_field($id,$field_name,$postdb);
	$Module_db->make_template($id);
	write_module_cache();

	refreshto("$admin_path&job=editsort&id=$id","修改成功",1);
}
elseif($job=="addfield")
{
	$rsdb = $Module_db->module_info($id);

	$group_view = group_box("postdb[allowview]");
	$group_post = group_box("postdb[allowpost]");
	$_rs[field_type]='mediumtext';
	$field_type[$_rs[field_type]]=" selected ";
	$_rs[field_name]="my_".rand(1,999);
	$_rs[title]="我的字段$_rs[field_name]";
	$mustfill[0]=$search[0]=' checked ';
	$listshow[intval($_rs[listshow])]=" checked ";
	$select_db = $Module_db->list_class("postdb[classid]",$_rs[classid]);

	get_admin_html('editfield');
}
elseif($action=="addfield")
{
	$Module_db->creat_field($id,$postdb);

	//重新生成模板
	$Module_db->make_template($id);

	write_module_cache();
	refreshto("$admin_path&job=editsort&id=$id",'创建成功',10);
}
elseif($action=="delfield")
{
	$Module_db->delete_field($id,$field_name);
	//重新生成模板
	$Module_db->make_template($id);
	write_module_cache();
	refreshto($FROMURL,"删除成功");
}
elseif($job=='tpl')
{
	if($automaketpl){	//批量生成模板
		$page=intval($page);
		$rsdb=$db->get_one("SELECT * FROM {$_pre}module LIMIT $page,1 ");
		$id=$rsdb[id];	
		if(!$id){
			refreshto("$admin_path&job=listsort","模板生成完毕",3);
		}else{
			$Module_db->make_template($id);
			$page++;
			echo "正在生成模板:$rsdb[name]<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$admin_path&job=$job&automaketpl=$automaketpl&page=$page'>";
			exit;
		}	
	}else{
		$Module_db->make_template($id);
		refreshto("$admin_path&job=listsort","模板生成完毕",1);
	}

}
elseif($action=="delete")
{
	$Module_db->delete_module($id);
	write_module_cache();
	refreshto("$admin_path&job=listsort","删除成功");
}
elseif($job=="editmodule")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}module WHERE id='$id'");
	$array=unserialize($rsdb[config]);
	@extract($array[moduleSet]);
	$useMapDB[intval($useMap)]=' checked ';

	$allowpost=group_box("postdb[allowpost]",explode(",",$rsdb[allowpost]));

	$tpldb=unserialize($rsdb[template]);

	get_admin_html('editmodule');
}
elseif($action=="editmodule")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}module WHERE id='$id' ");
	$array=unserialize($rsdb[config]);
	$array[moduleSet]=$postdb;
	$config=addslashes(serialize($array));
	foreach($tpldb  AS $key=>$value){
		if($value&&!is_file(ROOT_PATH.$value)&&!is_file(ROOT_PATH."template/default/$value")&&!is_file(ROOT_PATH."template/$webdb[style]/$value")){
			showerr("模板文件不存在:$value !");
		}
	}
	$template=addslashes(serialize($tpldb));
	$db->query(" UPDATE {$_pre}module SET name='$name',config='$config',template='$template' WHERE id='$id' ");
	write_module_cache();
	$Module_db->make_template($id);
	refreshto("$FROMURL","修改成功",1);
}
elseif($job=="setcomment")
{
	$rsdb=$db->get_one("SELECT * FROM {$_pre}module WHERE id='$id' ");
	$ifdianpin[intval($rsdb[comment_type])]=' checked ';
	$fendb=unserialize($rsdb[config2]);
	$fendb[fen1][name] || $fendb[fen1][name]="总评";
	$fendb[fen2][name] || $fendb[fen2][name]="环境";
	$fendb[fen3][name] || $fendb[fen3][name]="服务";
	$fendb[fen4][name] || $fendb[fen4][name]="价位";
	$fendb[fen5][name] || $fendb[fen5][name]="喜欢程度";
	$fendb[fen6][name] || $fendb[fen6][name]="环境氛围";

	$fendb[fen1][set] || $fendb[fen1][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
	$fendb[fen2][set] || $fendb[fen2][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
	$fendb[fen3][set] || $fendb[fen3][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
	$fendb[fen4][set] || $fendb[fen4][set]="1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵";
	$fendb[fen5][set] || $fendb[fen5][set]="1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢";
	$fendb[fen6][set] || $fendb[fen6][set]="家庭聚会\r\n随便吃吃\r\n情侣约会\r\n商务洽谈\r\n朋友聚会\r\n工作午餐\r\n大型聚会";

	get_admin_html('setcomment');
}
elseif($action=="setcomment")
{
	$config2=addslashes(serialize($fendb));
	$db->query("UPDATE {$_pre}module SET config2='$config2' WHERE id='$id' ");
	write_module_cache();
	refreshto($FROMURL,"修改成功",1);
}

function write_module_cache(){
	global $_pre,$db;
	$show='<?php unset($module_DB);'."\r\n";
	$query = $db->query("SELECT * FROM {$_pre}module ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		unset($field_array);
		//字段信息
		$query2 = $db->query("SELECT * FROM {$_pre}field WHERE mid='$rs[id]'");
		while($rs2 = $db->fetch_array($query2)){
			$field_array[$rs2[field_name]]=$rs2;
		}
		$rs[field]=$field_array;
		//
		$rs[config]=unserialize($rs[config]);
		$rs[config2]=unserialize($rs[config2]);

		$string=var_export($rs,true);

		$show.="\$module_DB[{$rs[id]}]=$string;\r\n";
		$show.="\$module_db[{$rs[id]}]=\"$rs[name]\";\r\n";
	}
	write_file(ROOT_PATH."data/module_db.php",$show.'?>');
}
?>