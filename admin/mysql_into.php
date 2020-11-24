<?php die();
error_reporting(7);
@set_time_limit(0);
$_dbhost='localhost';
$_dbuser='';
$_dbpw='';
$_dbname='';
$_Charset='latin1';


foreach($_POST as $_key=>$_value){
	!ereg("^\_",$_key) && $$_key=$_POST[$_key];
}
foreach($_GET as $_key=>$_value){
	!ereg("^\_",$_key) && $$_key=$_GET[$_key];
}



if(!$job&&!$page){
print <<<EOT

<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<form name="form1" method="post" action="?a">
  <p>数据库主机: 
    <input type="text" name="dbhost" value="$_dbhost">一般为:localhost
    <br>
    数据库帐号: 
    <input type="text" name="dbuser" value="$_dbuser">
    <br>
    数据库密码: 
    <input type="text" name="dbpw" value="$_dbpw">
    <br>
    数据库名: 
    <input type="text" name="dbname" value="$_dbname">
    <br>
    数据库编码: 
    <input type="text" name="Charset" value="$_Charset">
    可供选择的有<font color="#FF0000">latin1</font>,<font color="#FF0000">gbk</font>,<font color="#FF0000">utf8</font>,<font color="#FF0000">big5</font> 
    最好选择 <font color="#FF0000">latin1</font> <br>
  </p>
  <p> 
    <input type="submit" name="Submit" value="开始导入">
    <input type="hidden" name="job" value="1">
  </p>
</form>


EOT;
exit;
}

if($page>0){
	list($dbhost,$dbuser,$dbpw,$dbname,$Charset)=explode("\t",$_COOKIE[mysqlconfig]);
}

if(!@mysql_connect($dbhost, $dbuser, $dbpw)) {
	die('MYSQL 连接数据库失败,请确定数据库用户名,密码设置正确<br><A HREF="#" onclick="history.back(-1)">点击返回</A>');
}
if(!@mysql_select_db($dbname)){
	die("MYSQL 连接成功,但当前使用的数据库 {$dbname} 不存在<br><A HREF=\"#\" onclick=\"history.back(-1)\">点击返回</A>");
}

$mysqlV=mysql_get_server_info();

if($mysqlV>'4.1'){
	mysql_query("SET NAMES '$Charset'");
}

if( mysql_get_server_info() > '5.0' ){
	mysql_query("SET sql_mode=''");
}

if(!$page){
	setcookie("mysqlconfig","$dbhost\t$dbuser\t$dbpw\t$dbname\t$Charset");
}

$page=intval($page);
if(is_file("$page.sql")){
	insert_file("$page.sql");
	$page++;
	echo "正在导入第{$page}卷,请稍候...<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?page=$page'>";
	exit;
}else{
	echo "数据导入完毕,如果你是从旧空间转移数据到新空间,请把旧空间/data/目录下的全部文件移到新空间对应的/data/目录里.但mysql_config.php不必移.因为新的数据库配置与旧的一般不相同,因而你需要手工配置好新空间的这个文件mysql_config.php";
}

function insert_file($file,$replace=''){
	global $Charset;
	$readfiles=read_file($file);
	if($replace){
		$readfiles=str_replace('$timestamp',"$timestamp",$readfiles);
	}
	$detail=explode("\n",$readfiles);
	$count=count($detail);
	for($j=0;$j<$count;$j++){
		$ck=substr($detail[$j],0,4);
		if( ereg("#",$ck)||ereg("--",$ck) ){
			continue;
		}
		$array[]=$detail[$j];
	}
	$read=implode("\n",$array); 
	$sql=str_replace("\r",'',$read);
	$detail=explode(";\n",$sql);
	$count=count($detail);
	for($i=0;$i<$count;$i++){
		$sql=str_replace("\r",'',$detail[$i]);
		$sql=str_replace("\n",'',$sql);
		$sql=trim($sql);
		if($sql){
			if(eregi("CREATE TABLE",$sql)){
				$mysqlV=mysql_get_server_info();
				$sql=preg_replace("/DEFAULT CHARSET=([a-z0-9]+)/is","",$sql);
				$sql=preg_replace("/TYPE=MyISAM/is","ENGINE=MyISAM",$sql);
				if($mysqlV>'4.1'){
					$sql=str_replace("ENGINE=MyISAM"," ENGINE=MyISAM DEFAULT CHARSET=$Charset ",$sql);
				}
			}
			
			$query=mysql_query($sql);
			if (!$query) die("数据库出错:$sql");
			$check++;
		}	
	}
	return $check;
}
function read_file($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		@flock($handle,LOCK_SH);
		$filedata=@fread($handle,@filesize($filename));
		@fclose($handle);
	}
	return $filedata;
}