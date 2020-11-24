<?php
!function_exists('html') && exit('ERR');

function mysql_get_table_value($table,$start=0,$row=3000){
	global $db;
	$query=$db->query(" SELECT * FROM $table LIMIT $start,$row ");
	$num=mysql_num_fields($query);
	while ($array=mysql_fetch_row($query)){
		$rows='';
		for($i=0;$i<$num;$i++){
			$rows.="'".mysql_escape_string($array[$i])."',";
		}
		$rows.=")";
		$rows=str_replace(",)","",$rows);
		$show.="INSERT INTO `$table` VALUES ($rows);\r\n";
	}
	return $show;
}

function mysql_bak_out($tabledb){
	global $db,$rowsnum,$fileNUM,$bak_path,$baksize,$tableid,$page;

	//此page指的是每个表数据大的时候.需要多次跳转页面读取
	if(!$page){	
		$page=1;
	}
	$min=($page-1)*$rowsnum;
	$tableid=intval($tableid);

	if( $show=mysql_get_table_value($tabledb[$tableid],$min,$rowsnum) ){	//表中有数据,还要继续读取
		$page++;
	}else{			//表中无数据的情况,继续下一个表
		$page=0;
		$tableid++;
	}

	//分卷是从0开始的
	$fileNUM=intval($fileNUM);
	$filename="$fileNUM.sql";
	$show && write_file("$bak_path/$filename",$show,'a+');


	//对文件做精确大小分卷处理
	$show && cksize("$bak_path/$filename",$baksize);
	
	//如果还存在表时.继续,否则结束
	if($tabledb[$tableid]){
		//不断变化的变量有 $page,$tableid,$fileNUM
		return true;
	}else{
		@unlink(ROOT_PATH."cache/bak_mysql.txt");
		return false;
	}
}


//*备份的分卷文件按固定大小作处理*
function cksize($lastSqlFile,$size){
	global $fileNUM,$bak_path;

	//复制一份最后生成的以方便获取文件大小,否则获取不到真实文件的大小.这里很关键
	copy($lastSqlFile,"{$lastSqlFile}.bak");

	if( @filesize("{$lastSqlFile}.bak")<$size ){	
		unlink("{$lastSqlFile}.bak");
		return ;
	}
	
	$filePre=str_replace(basename($lastSqlFile),"",$lastSqlFile);
	$readfile=read_file("{$lastSqlFile}.bak");
	$detail=explode("\r\n",$readfile);
	unset($readfile); //释放内存
	foreach($detail AS $key=>$value){
		$NewSql.="$value\r\n";
		if(strlen($NewSql)>$size){
			write_file("$filePre/$fileNUM.sql",$NewSql);
			$fileNUM++;
			$NewSql='';
		}
	}
	//余下的再写进新文件,此时step已经累加过了
	if($NewSql){
		write_file("$filePre/$fileNUM.sql",$NewSql);
	}
	@unlink("{$lastSqlFile}.bak");
}


?>