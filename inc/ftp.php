<?php
set_time_limit(1000);
Class FTP {
	var $sock;
	var $resp;

	function FTP($ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_dir='') {
		$this->resp = "";
		if($this->connect($ftp_server,$ftp_port)){
			$this->login($ftp_user,$ftp_pass);
			if($ftp_dir){
				$this->cwd($ftp_dir);
			}
		}
	}
	function connect($ftp_server,$ftp_port) {
		$this->sock = @fsockopen($ftp_server, $ftp_port, $errno, $errstr, 30);

		if (!$this->sock || !$this->check()) {
			exit("Error : Cannot connect to remote host.\nError : fsockopen() ".$errstr." (".$errno.")\n");
		}
		return true;
	}

	function login($user,$pass){
		$this->command("USER",$user);
		if (!$this->check()) {
			exit("Error : USER command failed\n");
		}

		$this->command("PASS",$pass);
		if (!$this->check()) {
			exit("Error : PASS command failed\n");
		}
		return true;
	}

	function pwd(){
		$this->command("PWD");
		if (!$this->check()) {
			exit("Error : PWD command failed\n");
		}

		return preg_replace("/^[0-9]{3} \"(.+)\" .+\r\n/", "\\1", $this->resp);
	}

	function cwd($pathname){
		$this->command("CWD", $pathname);
		$response = $this->check();
		if (!$response) {
			exit("Error : CWD command failed\n");
		}
		return $response;
	}

	function rmd($pathname){
		$this->command("RMD", $pathname);
		$response = $this->check();
		if (!$response) {
			exit("Error : RMD command failed\n");
		}
		return $response;
	}

	function mkd($pathname){
		$this->command("MKD", $pathname);
		if ($this->check()) {
			$this->site("CHMOD 0777 $pathname");
		}
		return true;
	}

	function type($mode=''){
		if ($mode) {
			$type = "I"; //Binary mode
		} else {
			$type = "A"; //ASCII mode
		}
		$this->command("TYPE", $type);
		$response = $this->check();
		if (!$response) {
			exit("Error : TYPE command failed\n");
		}
		return true;
	}

	function size($pathname,$msg=1){
		$this->command("SIZE", $pathname);
		if (!$this->check()&&$msg) {
			exit("Error : SIZE command failed\n");
		}

		return preg_replace("/^[0-9]{3} ([0-9]+)\r\n/", "\\1", $this->resp);
	}

	function upload($filename,$source,$mode=''){

		if(strpos($source,'..')!==false || strpos($source,'.php.')!==false || eregi("\.php$",$source)){
			exit('illegal file type!');
		}
		if($GLOBALS['db_attachdir'] && $GLOBALS['savedir']){
			$this->mkd($GLOBALS['savedir']);
		}		
		$fp = @fopen($filename, "r");
		if (!$fp) {
			exit("Error : Cannot read file \"".$filename."\"\n");
		}

		$this->type($mode);
		if (!($string = $this->pasv())) {
			return false;
		}
		$this->command("STOR", $source);

		$sock_data = $this->open_data_connection($string);
		if (!$sock_data || !$this->check()) {
			exit("Error : Cannot connect to remote host\nError : PUT command failed\n");
		}

		while (!feof($fp)) {
			fputs($sock_data, fread($fp, 4096));
		}
		fclose($fp);

		$this->close_data_connection($sock_data);

		$response = $this->check();
		if (!$response) {
			exit("Error : PUT command failed\n");
		}else{
			$this->site("CHMOD 0777 $source");
		}

		return $this->size($source);
	}

	function delete($pathname){
		$this->command("DELE", $pathname);
		/**
		$response = $this->check();
		if (!$response) {
			exit("Error : DELE command failed\n");
		}
		return true;
		**/
		return $this->check();
	}

	function command($cmd,$arg = ""){
		if ($arg != "") {
			$cmd = $cmd." ".$arg;
		}
		fputs($this->sock,$cmd."\r\n");

		return true;
	}

	function site($command){
		$this->command("SITE",$command);
		$response = $this->check();
		if (!$response) {
			exit("Error : SITE command failed\n");
		}
		return $response;
	}

	function check(){
		$this->resp = "";
		do {
			$res = fgets($this->sock, 512);
			$this->resp .= $res;
		} while (substr($res, 3, 1) != " ");

		if (!ereg("^[123]", $this->resp)) {
			return false;
		}
		return true;
	}

	function dir_exists($pathname){
		if(!$pathname) return false;
		$list = $this->nlist();
		
		if(in_array($pathname,$list)){
			return true;
		}		
		return false;
	}

	function nlist($pathname = ""){
		if (!($string = $this->pasv())) {
			return false;
		}

		$this->command("NLST", $pathname);
		
		$sock_data = $this->open_data_connection($string);

		if (!$sock_data || !$this->check()) {
			exit("Error : Cannot connect to remote host\nError : LIST command failed\n");
		}

		while (!feof($sock_data)) {
			$sock_get = preg_replace("[\r\n]", "", fgets($sock_data, 512));
			if($sock_get && strpos($sock_get,".")===false){
				$list[] = $sock_get;
			}
		}

		$this->close_data_connection($sock_data);

		if (!$this->check()) {
			exit("Error : LIST command failed\n");
		}

		return $list;
	}

	function pasv(){
		$this->command("PASV");
		if (!$this->check()) {
			exit("Error : PASV command failed\n");
		}
		$ip_port = preg_replace("/^.+\s\(?([0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]+,[0-9]+)\)?.*\r\n$/i","\\1",$this->resp);
		return $ip_port;
	}

	function open_data_connection($ip_port){
		if (!ereg("[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]{1,3},[0-9]+,[0-9]+", $ip_port)) {
			exit("Error : Illegal ip-port format(".$ip_port.")\n");
		}

		$DATA = explode(",", $ip_port);
		$ipaddr = $DATA[0].".".$DATA[1].".".$DATA[2].".".$DATA[3];
		$port   = $DATA[4]*256 + $DATA[5];

		$data_connection = @fsockopen($ipaddr, $port, $errno, $errstr);
		if (!$data_connection) {
			exit("Error : Cannot open data connection to ".$ipaddr.":".$port."\nError : ".$errstr." (".$errno.")\n");
		}

		return $data_connection;
	}

	function close_data_connection($sock){
		return fclose($sock);
	}

	function close(){
		$this->command("QUIT");
		if (!$this->check() || !fclose($this->sock)) {
			//exit("Error : QUIT command failed\n");
		}
		return true;
	}
}

//$ftp = new FTP($ftp_server,$ftp_port,$ftp_user,$ftp_pass,$ftp_dir);

?>