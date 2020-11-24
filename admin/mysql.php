<?php
!function_exists('html') && exit('ERR');
@set_time_limit(0);
$db->query("SET SQL_QUOTE_SHOW_CREATE = 1");

/**
*列出数据表
**/
if($job=='out'&&$Apower[mysql_out]){
	$query=$db->query("SHOW TABLE STATUS");
	while( $array=$db->fetch_array($query) ){
		if($choose!='all'){
			if($choose=='out'){
				if(ereg("^($pre)",$array[Name])){
					continue;
				}
			}else{
				if(!ereg("^($pre)",$array[Name])){
					continue;
				}
			}
		}
		$j++;
		$totalsize=$totalsize+$array['Data_length'];
		$array['Data_length']=number_format($array['Data_length']/1024,3);
		$array[j]=$j;
		$listdb2[$array[Name]]=$array;
	}

	@include("tablename.php");$array='';
	foreach($tableName AS $key=>$value){
		$listdb2[$key] && $array[$key]=$listdb2[$key];
	}
	$listdb=$array?$array+$listdb2:$listdb2;

	$totalsize=number_format($totalsize/(1024*1024),3);
	if(file_exists(ROOT_PATH."cache/bak_mysql.txt"))
	{
		$breakbak=read_file(ROOT_PATH."cache/bak_mysql.txt");
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mysql/menu.htm");
	require(dirname(__FILE__)."/"."template/mysql/out.htm");
	require(dirname(__FILE__)."/"."foot.php");
	
}
//数据库优化与修复
elseif($job=='do'&&$Apower[mysql_out]){
	if($step=='yh'){
		$db->query("OPTIMIZE TABLE `$table`");
	}elseif($step=='xf'){
		$db->query("REPAIR TABLE `$table`");
	}
	jump("操作成功，点击返回",$FROMURL,1);
}

/**
*导出备份数据
**/
elseif($action=='out'&&$Apower[mysql_out]){
	if(!$tabledb&&!$tabledbreto){
		showmsg('请选择一个数据表');
	}
	if(!$tabledb&&$tabledbreto){
		$detail=explode("|",$tabledbreto);
		$num=count($detail);
		for($i=0;$i<$num-1;$i++){
			$tabledb[]=$detail[$i];
		}
	}
	$rsdb=bak_out($tabledb);
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mysql/menu.htm");
	require(dirname(__FILE__)."/"."template/mysql/outaction.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

/**
*选择要导入还原的数据
**/
elseif($job=='into'&&$Apower[mysql_into]){
	$selectname=bak_time();
	if(file_exists(ROOT_PATH."cache/mysql_insert.txt")){
		echo "<CENTER><table><tr bgcolor=#FF0000><td colspan=5 height=30><div align=center><A HREF=".read_file(ROOT_PATH."cache/mysql_insert.txt")."><b><font color=ffffff>上次还原数据被中断是否继续,点击继续</font></b></A></div></td></tr></table></CENTER>";
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mysql/menu.htm");
	require(dirname(__FILE__)."/"."template/mysql/into.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

/**
*处理导入还原数据
**/
elseif($action=='into'&&$Apower[mysql_into])
{
	bak_into();
}

/**
*选择要删除的备份数据
**/
elseif($job=='del'&&$Apower[mysql_del]){
	$selectname=bak_time();
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mysql/menu.htm");
	require(dirname(__FILE__)."/"."template/mysql/del.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

/**
*删除选定的备份数据
**/
elseif($action=='del'&&$Apower[mysql_del]){
	if(!$baktime){
		showmsg('请选择一个');
	}
	del_file(ROOT_PATH."cache/mysql_bak/$baktime");
	if(!is_dir(ROOT_PATH."cache/mysql_bak/$baktime")){
		jump("数据删除成功","index.php?lfj=mysql&job=del",5);
	}else{
		jump("数据删除失败,请确认目录属性为0777","index.php?lfj=mysql&job=del",5);
	}
}


/**
*从本机上传SQL文本导入数据
**/
elseif($job=='sql'&&$Apower[mysql_sql]){
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/mysql/menu.htm");
	require(dirname(__FILE__)."/"."template/mysql/sql.htm");
	require(dirname(__FILE__)."/"."foot.php");
}

/**
*处理本机上传的SQL数据
**/
elseif($action=='sql'&&$Apower[mysql_sql]){
	if($t==2){
		$sqlfile=ROOT_PATH."$webdb[updir]/$upsql";
		$db->insert_file($sqlfile);
		@unlink($sqlfile);
	}elseif($t==1){
		$sql=StripSlashes($sql);
		if($pre!='qb_'){
			$sql=str_replace("qb_",$pre,$sql);
		}
		write_file(ROOT_PATH."cache/$timestamp.sql",$sql);
		$db->insert_file(ROOT_PATH."cache/$timestamp.sql");
		unlink(ROOT_PATH."cache/$timestamp.sql");
		//$db->query("$sql");


		if(eregi("^select ",$sql)){
			$query=$db->query($sql);
			$num=mysql_num_fields($query);
			for($i=0;$i<$num;$i++){
				$f_db=mysql_fetch_field($query,$i);
				$titledb[]=$f_db->name;	
			}

			while ($array=mysql_fetch_row($query)){
				for($i=0;$i<$num;$i++){			
					if(strlen($array[$i])>32){
						$array[$i] = str_replace(array('<','>','&nbsp;'),array('&lt;','&gt;','&amp;nbsp;'),$array[$i]);
						$array[$i] = "<textarea name='textfield' style='width:300px;height:50px'>{$array[$i]}</textarea>";
					}elseif(is_null($array[$i])){
						$array[$i] = 'NULL';
					}elseif($array[$i] == ''){
						$array[$i] = '&nbsp;';
					}
				}
				$listdb[]=$array;
			}
			require(dirname(__FILE__)."/"."template/mysql/showtable.htm");
			exit;
		}


	}
	jump("如果网页上方没出现乱码，则操作成功","index.php?lfj=mysql&job=sql",10);
	
}

elseif($job=='showtable'){
	$listdb = $titledb = '';
	$rows=50;
	if($page<1){
		$page=1;
	}
	$min = ($page-1)*$rows;
	$query=$db->query("SELECT * FROM `$table` limit $min,$rows");
	$num=mysql_num_fields($query);
	for($i=0;$i<$num;$i++){
		$f_db=mysql_fetch_field($query,$i);
		$titledb[]=$f_db->name;	
	}

	while ($array=mysql_fetch_row($query)){
		for($i=0;$i<$num;$i++){
			if(strlen($array[$i])>32){
				$array[$i] = str_replace(array('<','>','&nbsp;'),array('&lt;','&gt;','&amp;nbsp;'),$array[$i]);
				$array[$i] = "<textarea name='textfield' style='width:300px;height:50px'>{$array[$i]}</textarea>";
			}elseif(is_null($array[$i])){
				$array[$i] = 'NULL';
			}elseif($array[$i] == ''){
				$array[$i] = '&nbsp;';
			}
		}
		$listdb[]=$array;
	}

	if(!$listdb){
		//showmsg('当前数据表内容为空!');
	}

	$showpage = getpage("`$table`","","index.php?lfj=$lfj&job=$job&table=$table",$rows);

	require(dirname(__FILE__)."/"."template/mysql/showtable.htm");
}

function show_field($table){
	global $db;
	$query=$db->query(" SELECT * FROM $table limit 0,1");
	$num=mysql_num_fields($query);
	for($i=0;$i<$num;$i++){
		$f_db=mysql_fetch_field($query,$i);
		$field=$f_db->name;
		$show.="`$field`,";
	}
	$show.=")";
	$show=str_replace(",)","",$show);
	return $show;
}


function create_table($table){
	global $db,$repair,$mysqlversion,$Charset;
	$show="DROP TABLE IF EXISTS $table;\n";
	if($repair){
		$db->query("OPTIMIZE TABLE `$table`");
	}
	$array=$db->get_one("SHOW CREATE TABLE $table");

	if(!$mysqlversion){
		$show.=$array['Create Table'].";\n\n";
		return $show;
	}

	$array['Create Table']=preg_replace("/DEFAULT CHARSET=([0-9a-z]+)/is","",$array['Create Table']);

	if($mysqlversion=='new'){
		$Charset || $Charset='latin1';
		$array['Create Table'].=" DEFAULT CHARSET=$Charset";
	}
	$show.=$array['Create Table'].";\n\n";
	return $show;
}


function bak_table($table,$start=0,$row=3000){
	global $db;
	$limit=" limit $start,$row ";
	//$field=show_field($table);
	$query=$db->query(" SELECT * FROM $table $limit ");
	$num=mysql_num_fields($query);
	while ($array=mysql_fetch_row($query)){
		$rows='';
		for($i=0;$i<$num;$i++){
			$rows.=(is_null($array[$i])?'NULL':"'".mysql_escape_string($array[$i])."'").",";
		}
		$rows=substr($rows,0,-1);
		//$rows.=")";
		//$rows=str_replace(",)","",$rows);
		//$show.="INSERT INTO `$table` ($field) VALUES ($rows);\n";
		$show.="INSERT INTO `$table` VALUES ($rows);\n";
	}
	return $show;
}


function create_table_all($tabledb){
	foreach($tabledb as $table){
		$show.=create_table($table)."\n";
	}
	return $show;
}


function bak_out($tabledb){
	global $db,$pre,$rowsnum,$tableid,$page,$timestamp,$step,$rand_dir,$lfj,$baksize;
	//还没有随机生成目录之前
	if(!$rand_dir){
		/*特地处理有些服务器不能创建目录的情况,此时必须手工创建mysql目录*/
		if( file_exists(ROOT_PATH."cache/mysql_bak/mysql") )
		{
			if( !is_writable(ROOT_PATH."cache/mysql_bak/mysql") ){
				showmsg(ROOT_PATH."cache/mysql_bak/mysql目录不可写,请改属性为0777");
			}
			$rand_dir="mysql";

			$d=opendir(ROOT_PATH."cache/mysql_bak/mysql/");
			while($f=readdir($d)){
				if(eregi("\.sql$",$f)){
					unlink(ROOT_PATH."cache/mysql_bak/mysql/$f");
				}
			}
			
			write_file(ROOT_PATH."cache/mysql_bak/mysql/index.php",str_replace('<?php die();','<?php',read_file('mysql_into.php')));
			$show=create_table_all($tabledb);	//备份数据表结构
			//$db->query("TRUNCATE TABLE {$pre}bak");
			//bak_dir('../data/');		//备份缓存
		}else{
			$rand_dir=date("Y-m-d.",time()).strtolower(rands(3));
			$show=create_table_all($tabledb);	//备份数据表结构
			if( !file_exists(ROOT_PATH."cache/mysql_bak") ){
				if( !@mkdir(ROOT_PATH."cache/mysql_bak",0777) ){
					showmsg(ROOT_PATH."cache/mysql_bak目录不能创建");
				}
			}
			if(	!@mkdir(ROOT_PATH."cache/mysql_bak/$rand_dir",0777)	)
			{
				showmsg(ROOT_PATH."cache/mysql_bak/$rand_dir,目录不可写,请改属性为0777");
			}
			//复制一个自动还原的文件到SQL目录.方便日后还原
			write_file(ROOT_PATH."cache/mysql_bak/$rand_dir/index.php",str_replace('<?php die();','<?php',read_file('mysql_into.php')));
			//$db->query("TRUNCATE TABLE {$pre}bak");
			//bak_dir('../data/');		//备份缓存
		}
	}
	!$rowsnum && $rowsnum=500;	//每次读取多少条数据
	//此page指的是每个表大的时候.需要多次跳转页面读取
	if(!$page)
	{
		$page=1;
	}
	$min=($page-1)*$rowsnum;
	$tableid=intval($tableid);

	//$show.=$tablerows=bak_table($tabledb[$tableid],$min,$rowsnum);
	//当前表能取到数据时,继续此表下一页取数据,否则从下一个表的0开始

	if( $tablerows=bak_table($tabledb[$tableid],$min,$rowsnum) )
	{
		$show.=$tablerows;
		unset($tablerows);	//释放内存
		$page++;
	}
	else
	{
		$page=0;
		$tableid++;
	}

	//分卷是从0开始的
	$step=intval($step);
	$filename="$step.sql";
	write_file(ROOT_PATH."cache/mysql_bak/".$rand_dir."/".$filename,$show,'a+');

	//如果不指定每卷大小.将默认为1M
	$baksize=$baksize?$baksize:1024;
	
	//对文件做精确大小分卷处理
	$step=cksize(ROOT_PATH."cache/mysql_bak/".$rand_dir."/".$filename,$step,1024*$baksize);
	
	//如果还存在表时.继续,否则结束
	if($tabledb[$tableid])
	{
		foreach($tabledb as $value)
		{
			$Table.="$value|";
		}
		//记录下来.防止中途备份失败
		write_file(ROOT_PATH."cache/bak_mysql.txt","index.php?lfj=$lfj&action=out&page=$page&rowsnum=$rowsnum&tableid=$tableid&rand_dir=$rand_dir&step=$step&tabledbreto=$Table&baksize=$baksize");

		echo "<CENTER>已备份 <font color=red>$step</font> 卷, 进度条 <font color=blue>{$page}</font> 当前正在备份数据库 <font color=red>$tabledb[$tableid]</font></CENTER>";

print<<<EOT
<form name="form1" method="post" action="index.php?lfj=$lfj&action=out&page=$page&rowsnum=$rowsnum&tableid=$tableid&rand_dir=$rand_dir&step=$step&baksize=$baksize">
  <input type="hidden" name="tabledbreto" value="$Table">
</form>
<SCRIPT LANGUAGE="JavaScript">
<!--
function autosub(){
	document.form1.submit();
}
autosub();
//-->
</SCRIPT>
EOT;
		//echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php?lfj=$lfj&action=out&page=$page&rowsnum=$rowsnum&tableid=$tableid&rand_dir=$rand_dir&step=$step&tabledbreto=$Table&baksize=$baksize'>";
		exit;
	}
	else
	{
		$dir=opendir(ROOT_PATH."cache/mysql_bak/$rand_dir");
		while($file=readdir($dir)){
			if(eregi('.sql$',$file))
			{
				$totalsize+=$sqlfilesize=@filesize(ROOT_PATH."cache/mysql_bak/$rand_dir/$file");
				$rs[sqlsize][]=number_format($sqlfilesize/1024,3);
			}
			
		}
		$totalsize=number_format($totalsize/1048576,3);
		@unlink(ROOT_PATH."cache/bak_mysql.txt");
		$rs[totalsize]=$totalsize;
		$rs[timedir]=$rand_dir;
		if( !@is_writable(ROOT_PATH."cache/mysql_bak/$rand_dir/0.sql") ){
			showmsg("备份失败，请在cache/mysql_bak/目录下创建一个目录mysql然后改其属性为0777,如果此目录已存在，请删除他，重新创建，并改属性为0777");
		}
		return $rs;
	}
}

function bak_time(){
	$show="<select  name='baktime'><option value='' selected>请选择备份文件</option>";
	$dir=opendir(ROOT_PATH."cache/mysql_bak/");
	while( $file=readdir($dir) ){
		if( is_dir(ROOT_PATH."cache/mysql_bak/$file")&&$file!='.'&&$file!='..' ){
			$show.="<option value='$file'>$file</option>";
		}
	}
	$show.="</select>";
	return $show;
}

function bak_into(){
	global $step,$baktime,$db,$pre;
	$step=intval($step);
	$file=ROOT_PATH."cache/mysql_bak/$baktime/{$step}.sql";
	if( file_exists($file) ){
		$db->insert_file($file);
	}
	$step++;
	if( file_exists(ROOT_PATH."cache/mysql_bak/$baktime/{$step}.sql") ){
		write_file(ROOT_PATH."cache/mysql_insert.txt","?lfj=mysql&action=into&baktime=$baktime&step=$step");
		echo "已导入第 {$step} 卷<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php?lfj=mysql&action=into&baktime=$baktime&step=$step'>";
		exit;
	}else{
		//$query=$db->query("SELECT * FROM {$pre}bak ");
		//while(@extract($db->fetch_array($query))){
		//	write_file(ROOT_PATH."A/$bak_dir",$bak_txt);
		//}
		@unlink(ROOT_PATH."cache/mysql_insert.txt");
		jump("导入完毕",'index.php?lfj=mysql&job=into','5');
	}
}
/*
function bak_dir($path){
	global $db,$filedb,$pre;
	if (file_exists($path)){
		if(is_file($path)){
			$files=read_file($path);
			$files=mysql_escape_string($files);
			$db->query("INSERT INTO {$pre}bak (bak_dir,bak_txt) VALUES ('$path','$files') ");
		} else{
			$handle = opendir($path);
			while ($file = readdir($handle)) {
				if( ($file!=".") && ($file!="..") && ($file!="") ){
					if (is_dir("$path/$file")){
						bak_dir("$path/$file");
					} else{
						$files=read_file("$path/$file");
						$files=mysql_escape_string($files);
						if("mysql_config.php"!=$file){
							$db->query("INSERT INTO {$pre}bak (bak_dir,bak_txt) VALUES ('$path/$file','$files') ");
						}
					}
				}
			}
			closedir($handle);
		}
	}
}
*/

/*备份的分卷文件按固定大小作处理*/
function cksize($lastSqlFile,$step,$size){
	if( @filesize($lastSqlFile)<($size+10*1024) )
	{
		return $step;
	}
	//复制一份最后生成的大于指定大小的SQL文件做处理
	copy($lastSqlFile,"{$lastSqlFile}.bak");
	$filePre=str_replace(basename($lastSqlFile),"",$lastSqlFile);
	$readfile=read_file("{$lastSqlFile}.bak");
	$detail=explode("\n",$readfile);
	unset($readfile); //释放内存
	foreach($detail AS $key=>$value){
		$NewSql.="$value\n";
		if(strlen($NewSql)>$size){
			write_file("$filePre/$step.sql",$NewSql);
			$step++;
			$NewSql='';
		}
	}
	//余下的再写进新文件,此时step已经累加过了
	if($NewSql){
		write_file("$filePre/$step.sql",$NewSql);
	}
	@unlink("{$lastSqlFile}.bak");
	return $step;
}
?>