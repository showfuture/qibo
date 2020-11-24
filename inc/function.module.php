<?php

//表单中获取用户组
function group_box($name="postdb[group]",$ckdb=array(),$Filtrate=array()){
	global $db,$pre;
	$query=$db->query("SELECT * FROM {$pre}group ORDER BY gid ASC");
	while($rs=$db->fetch_array($query))
	{
		if(in_array($rs[gid],$Filtrate)){
			continue;
		}
		$checked=in_array($rs[gid],$ckdb)?"checked":"";
		$show.="<input type='checkbox' name='{$name}[]' value='{$rs[gid]}' $checked>&nbsp;{$rs[grouptitle]}&nbsp;&nbsp;";
	}
	return $show;
}

/**
*检查是否误操作.设置子栏目为自己的父栏目
**/
function check_fup($table,$fid,$fup){
	global $db;
	if(!$fup){
		return ;
	}elseif($fid==$fup){
		showerr("不能设置自身为父栏目");
	}
	$query = $db->query("SELECT * FROM $table WHERE fid='$fup'");
	while($rs = $db->fetch_array($query)){
		if($rs[fup]==$fid){
			showerr("你不能设置本身的子栏目作为父栏目,这是不允许的.但你可以设置其他子栏目作为父栏目");
		}elseif($rs[fup]){
			check_fup($table,$fid,$rs[fup]);
		}
	}
}

/**
*更新栏目级别
**/
function mod_sort_class($table,$class,$fid){
	global $db;
	$db->query("UPDATE $table SET class='$class'+1  WHERE fup='$fid' ");
	$query=$db->query("SELECT * FROM $table WHERE fup='$fid'");
	while( @extract($db->fetch_array($query)) ){
		mod_sort_class($table,$class,$fid);
	}
}

/**
*更新栏目有几个子栏目
**/
function  mod_sort_sons($table,$fid){
	global $db;
	$query=$db->query("SELECT * FROM $table WHERE fup='$fid'");
	$sons=$db->num_rows($query);
	$db->query("UPDATE $table SET sons='$sons' WHERE fid='$fid' ");
	while( @extract($db->fetch_array($query)) ){
		mod_sort_sons($table,$fid);
	}
}

/**
*纠正栏目错误
**/
function sort_error_in($table,$fid){
	global $db;
	$query=$db->query("SELECT fid FROM $table WHERE fup='$fid'");
	while( @extract($db->fetch_array($query)) ){
		$show.="{$fid}\t";
		$show.=sort_error_in($table,$fid);
	}
	return $show;
}
/**
*纠正栏目错误
**/
function sort_error($table,$name='errid'){
	global $db;
	$show="<select name='$name'><option value=''>出错的栏目</option>";
	$array=explode("\t",sort_error_in($table,0));
	$query=$db->query("SELECT * FROM $table");
	while( @extract($db->fetch_array($query)) ){
		if(!in_array($fid,$array)){
			$show.="<option value='$fid'>$name</option>";
		}
	}
	$show.=" </select>";
	return $show;
}

//更新核心设置缓存
function write_config_cache($webdbs)
{
	global $db,$_pre;
	if( is_array($webdbs) )
	{
		foreach($webdbs AS $key=>$value)
		{
			if(is_array($value))
			{
				$webdbs[$key]=$value=implode(",",$value);
			}
			$SQL2.="'$key',";
			$SQL.="('$key', '$value', ''),";
		}
		$SQL=$SQL.";";
		$SQL=str_Replace("'),;","')",$SQL);
		$db->query(" DELETE FROM `{$_pre}config` WHERE c_key IN ($SQL2'') ");
		$db->query(" INSERT INTO `{$_pre}config` VALUES  $SQL ");	
	}
	$writefile="<?php\r\n";
	$query = $db->query("SELECT * FROM {$_pre}config");
	while($rs = $db->fetch_array($query)){
		$rs[c_value]=addslashes($rs[c_value]);
		$writefile.="\$webdb['$rs[c_key]']='$rs[c_value]';\r\n";
	}
	write_file(Mpath."data/config.php",$writefile);
}

/**
*生成栏目缓存
**/
function fid_cache($table){
	global $db,$pre;
	$show="<?php\r\n";
	$query = $db->query("SELECT fid,fup,name FROM $table ORDER BY  list  DESC");
	while($rs = $db->fetch_array($query)){
		$GuideFid[$rs[fid]]=get_guide($rs[fid]);
		$rs[name]=addslashes($rs[name]);
		$show.="
		\$Fid_db[{$rs[fup]}][{$rs[fid]}]='$rs[name]';
		\$Fid_db[name][{$rs[fid]}]='$rs[name]';
		";
	}
	write_file(Mpath."data/all_fid.php",$show.' ?>');
	write_file(Mpath."data/guide_fid.php","<?php\r\n\$GuideFid=".var_export($GuideFid,true).';?>');
}


function module_get_guide($fid,$url='list.php?'){
	global $db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	while($rs = $db->fetch_array($query)){
		$show=" -&gt; <A href='{$url}fid=$rs[fid]'>$rs[name]</A>".$show;
		if($rs[fup]){
			$show=module_get_guide($rs[fup],$url).$show;
		}
	}
	return $show;
}

/**
*选择模块风格
**/
function select_module_style($name='stylekey',$ck='',$url='',$select=''){
	if($url) 
	$reto=" onchange=\"window.location=('{$url}&{$name}='+this.options[this.selectedIndex].value+'')\"";
	$show="<select name='$name' $reto><option value=''>选择风格</option>";
	$filedir=opendir(Mpath."data/style/");
	while($file=readdir($filedir)){
		if(ereg("\.php$",$file)){
			include Mpath."data/style/$file";
			$ck==$styledb[keywords]?$ckk='selected':$ckk='';	//指定的某个
			/*只选定一个
			if($select){
				if($style_web!=$select){
					continue;
				}
			}
			*/
			$show.="<option value='$styledb[keywords]' $ckk style='color=blue'>$styledb[name]</option>";
		}
	}
	return $show." </select>";   
}

?>