<?php
Class MYSQL_DB {
	var $SQLlink;
	var $connet_nums = 0;	//数据库当前页面连接次数
	var $IsConnet = 0;		//数据库是否已链接
	function connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect = '' ,$ifUC='') {
		global $dbcharset;
		if($pconnect) {
			if(!$this->SQLlink=@mysql_pconnect($dbhost, $dbuser, $dbpw)) {
				$this->Err('MYSQL 不能永久连接数据库,请确定数据库用户名,密码设置正确,并且服务器支持永久连接<br>');
				if($ifUC){
					$this->uc_err();
				}
				exit;
			}
		} else {
			if(!$this->SQLlink=@mysql_connect($dbhost, $dbuser, $dbpw)) {				
				$this->Err('MYSQL 连接数据库失败,请确定数据库用户名,密码设置正确<br>');
				if($ifUC){
					$this->uc_err();
				}
				exit;
			}
		}
		if(!@mysql_select_db($dbname,$this->SQLlink)){			
			$this->Err("MYSQL 连接成功,但当前使用的数据库 {$dbname} 不存在<br>");
			if($ifUC){
				$this->uc_err();
			}
			exit;
		}
		if( mysql_get_server_info($this->SQLlink) > '4.1' ){
			if($dbcharset){
				//mysql_query("SET NAMES '$dbcharset'");
				mysql_query("SET character_set_connection=$dbcharset,character_set_results=$dbcharset,character_set_client=binary",$this->SQLlink);
			}else{
				mysql_query("SET character_set_client=binary",$this->SQLlink);
			}
			if( mysql_get_server_info($this->SQLlink) > '5.0' ){
				mysql_query("SET sql_mode=''",$this->SQLlink);
			}
		}
		$this->IsConnet=1;
	}

	function close() {
		$this->IsConnet=0;
		return mysql_close($this->SQLlink);
	}

	function query($SQL,$method='',$showerr='1') {
		if($this->IsConnet==0){
			global $dbhost, $dbuser, $dbpw, $dbname, $pconnect;
			$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		}

		if(eregi("CREATE TABLE",$SQL))$SQL = str_replace('TYPE=MyISAM','ENGINE=MyISAM',$SQL);
		
		//分析统计查询时间
		$speed_headtime=explode(' ',microtime());
		$speed_headtime=$speed_headtime[0]+$speed_headtime[1];

		if($method=='U_B' && function_exists('mysql_unbuffered_query')){
			$query = mysql_unbuffered_query($SQL,$this->SQLlink);
		}else{
			$query = mysql_query($SQL,$this->SQLlink);
		}
		
		//分析统计查询时间
		$speed_endtime=explode(' ',microtime());
		$totaltime=number_format((($speed_endtime[0]+$speed_endtime[1]-$speed_headtime)/1),6);
		$speed_totaltime="TIME $totaltime second(s)\t$SQL\r\n";
		if($totaltime>0.3){
			//write_file(ROOT_PATH."/cache/MysqlTime.txt",$speed_totaltime,'a');
			//大于3M,自动删除
			if(filesize(ROOT_PATH."/cache/MysqlTime.txt")>1024*1024*3){
				unlink(ROOT_PATH."/cache/MysqlTime.txt");
			}
		}
		$this->connet_nums++;

		if (!$query&&$showerr=='1')  $this->Err("数据库连接出错:$SQL<br>");
		return $query;
	}

	function get_one($SQL){

		$query=$this->query($SQL,'U_B');
		
		$rs =& mysql_fetch_array($query, MYSQL_ASSOC);

		return $rs;
	}

	function update($SQL) {
		if($this->IsConnet==0){
			global $dbhost, $dbuser, $dbpw, $dbname, $pconnect;
			$this->connect($dbhost, $dbuser, $dbpw, $dbname, $pconnect);
		}

		if(function_exists('mysql_unbuffered_query')){
			$query = mysql_unbuffered_query($SQL,$this->SQLlink);
		}else{
			$query = mysql_query($SQL,$this->SQLlink);
		}
		$this->connet_nums++;

		if (!$query)  $this->Err("数据库连接出错:$SQL<br>");
		return $query;
	}

	function fetch_array($query, $result_type = MYSQL_ASSOC) {
		return mysql_fetch_array($query, $result_type);
	}

	function num_rows($query) {
		$rows = mysql_num_rows($query);
		return $rows;
	}

	function free_result($query) {
		return mysql_free_result($query);
	}

	function insert_id() {
		$id = mysql_insert_id($this->SQLlink);
		return $id;
	}

	function insert_file($file,$readfiles=''){
		$readfiles || $readfiles=read_file($file);
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
				if(eregi("^CREATE TABLE",$sql)){
					if( mysql_get_server_info() > '4.1'){
						$sql = str_replace('TYPE=MyISAM','ENGINE=MyISAM',$sql);
						$sql = str_replace('TYPE=HEAP','ENGINE=HEAP',$sql);
						$sql = str_replace(';','',$sql);
						if(!eregi('DEFAULT CHARSET=',$sql)){
							$sql="$sql DEFAULT CHARSET=".($GLOBALS[dbcharset]?$GLOBALS[dbcharset]:'gbk');
						}						
					}elseif(eregi('DEFAULT CHARSET=',$sql)){
						$sql=preg_replace("/DEFAULT CHARSET=([^ ]+)/is",'',$sql);
					}
				}
				$this->query($sql);
				$check++;
			}
			
	
		}
		return $check;
	}
	function Err($msg='') {
		$sqlerror = mysql_error($this->SQLlink);
		$sqlerrno = mysql_errno($this->SQLlink);
		if(strstr($sqlerror,"Can't open file: '")){
			preg_match("/Can't open file: '([^']+)\.MYI'/is",$sqlerror,$array);
			echo "系统已自动修复数据库,请再次刷新网页,如果修复不成功,请重启数据库再修复<br>";
			$this->query("REPAIR TABLE `$array[1]`");
		}
		if(strstr($sqlerror,"should be repaired")){
			$sqlerror=str_replace("\\","/",$sqlerror);
			preg_match("/([^\/]+)' is marked as/is",$sqlerror,$array);
			echo "系统已自动修复数据库,请再次刷新网页,如果修复不成功,请重启数据库再修复<br>";
			$this->query("REPAIR TABLE `$array[1]`");
		}
		echo "$msg<br>$sqlerror<br>$sqlerrno";
		//die("");
	}

	function uc_err(){
		echo '<hr><A HREF="http://bbs.qibosoft.com/read-bbs-tid-270806.html" target="_blank">整合DZ/UC出错,请点击查看错误原因:http://bbs.qibosoft.com/read-forum-tid-270806.htm</A>';
		exit;
	}
}

?>