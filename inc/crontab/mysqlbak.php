<?php
!function_exists('html') && exit('ERR');

require_once(dirname(__FILE__)."/mysqlbak.function.php");	//只能包含一次


$rowsnum=100;		//每次读取多少条数据
$baksize=1024*1024;  //每卷大小

$tabledb=$show=$fileNUM=$page='';

$bak_path=ROOT_PATH.'cache/mysql_bak/'.date("Y-m-d.",time()).strtolower(rands(4));

@mkdir($bak_path,0777);

$db->query("SET SQL_QUOTE_SHOW_CREATE = 1");

$query=$db->query("SHOW TABLE STATUS");
while( $array=$db->fetch_array($query) ){
	if(!ereg("^($pre)",$array[Name])){
		continue;
	}
	$tabledb[]=$array[Name];
	
	//数据表结构
	$show.="DROP TABLE IF EXISTS $array[Name];\r\n";
	$ar=$db->get_one("SHOW CREATE TABLE $array[Name]");
	$show.=$ar['Create Table'].";\r\n\r\n";
}

//数据结构入写入文件
write_file("$bak_path/0.sql",$show,'a+');

$ifdo=true;
do{
	$ifdo=mysql_bak_out($tabledb);
	sleep(1);	//休息一秒执行一次,避免网站负载一时过高
}
while($ifdo);


echo 'qibo';

?>