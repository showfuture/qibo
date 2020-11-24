<?php
class qb_user{
	var $db;			//本系统的数据库连接类
	var $db_uc;			//UC的数据库连接类
	var $db_passport;	//通行证数据表的连接类
	var $pre;
	var $memberTable;	//通行证使用的主表

	function __construct() {
		$this->qb_user();
	}
	
	//初始化
	function qb_user() {
		$this->db =& $GLOBALS[db];
		$this->db_uc =& $GLOBALS[db_uc];
		$this->pre = $GLOBALS[pre];
		$this->memberTable = $this->get_passport_memberTable();
	}
	
	//获取通行证的主表
	function get_passport_memberTable(){
		global $webdb;
		if(eregi("^pwbbs",$webdb[passport_type])){
			$this->db_passport =& $GLOBALS[db];
			return "{$webdb[passport_pre]}members";
		}elseif(defined("UC_CONNECT")){
			$this->db_passport =& $GLOBALS[db_uc];
			return strstr(UC_DBTABLEPRE,'.')?UC_DBTABLEPRE."members":UC_DBNAME.'.'.UC_DBTABLEPRE."members";
		}else{
			$this->db_passport =& $GLOBALS[db];
			return "{$this->pre}members";
		}		
	}
	
	//仅获取用户通行证的邮箱密码信息
	function get_passport($value,$type='id') {
		$sql = $type=='id' ? "uid='$value'" : "username='$value'";
		$rs = $this->db_passport->get_one("SELECT * FROM {$this->memberTable} WHERE $sql");
		return $rs;
	}
	
	//仅获取用户详细信息
	function get_info($value,$type='id'){
		$sql = $type=='id' ? "uid='$value'" : "username='$value'";
		$rs = $this->db->get_one("SELECT * FROM {$this->pre}memberdata WHERE $sql");
		return $rs;
	}
	
	//获取用户所有信息
	function get_allInfo($value,$type='id'){
		global $webdb;
		$array1=$this->get_passport($value,$type);
		if(!$array1){
			return ;
		}
		$array2=$this->get_info($value,$type);
		if($array2){
			$array1=$array2+$array1;
		}else{
			$array=array(
				'uid'=>$array1[uid],
				'username'=>$array1[username],
				'email'=>$array1[email],
				'yz'=>$webdb[RegYz],
			);
			$this->register_data($array);
			add_user($array1[uid],$webdb[regmoney],'注册得分');
			$array1[yz]=$webdb[RegYz];
		}
		return $array1;
	}
	
	//检查密码是否正确
	function check_password($username,$password){
		$rs=$this->get_passport($username,'name');
		if(!$rs){
			return 0;
		}
		if(defined("UC_CONNECT")){
			if(md5(md5($password).$rs[salt])==$rs[password]){
				return $rs;
			}
		}else{
			if(md5($password)==$rs[password]){
				return $rs;
			}
		}
		return -1;
	}
	
	//检查用户名是否合法
	function check_username($username) {
		$guestexp = '\xA1\xA1|\xAC\xA3|^Guest|^\xD3\xCE\xBF\xCD|\xB9\x43\xAB\xC8';
		$len = strlen($username);
		if($len > 15 || $len < 3 || preg_match("/\s+|^c:\\con\\con|[%,\*\'\"\s\<\>\&]|$guestexp/is", $username)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	//检查用户名是否存在
	function check_userexists($username) {
		$rs = $this->db_passport->get_one("SELECT username FROM {$this->memberTable} WHERE username='$username'");
		return $rs;
	}

	//检查邮箱是否存在
	function check_emailexists($email) {
		global $webdb;
		if($webdb[passport_type]){
			$rs = $this->db_passport->get_one("SELECT * FROM {$this->memberTable} WHERE email='$email'");
		}else{
			$rs = $this->db->get_one("SELECT * FROM {$this->pre}memberdata WHERE email='$email'");
		}		
		return $rs;
	}
	
	//注册用户通行证邮箱密码必须信息
	function register_passport($array) {
		global $webdb,$timestamp,$onlineip;
		if(eregi("^pwbbs",$webdb[passport_type])){
			$array[password] = md5($array[password]);
			$this->db->query("INSERT INTO {$webdb[passport_pre]}members SET uid='$array[uid]',username='$array[username]',password='$array[password]',email='$array[email]',groupid='-1',memberid=8,regdate='$timestamp',yz=1");
			$uid=$this->db->insert_id();
			$this->db->query("INSERT INTO {$webdb[passport_pre]}memberdata SET uid='$uid',lastvisit='$array[lastvisit]',thisvisit='$array[thisvisit]',onlineip='$onlineip'");
		}elseif(defined("UC_CONNECT")){
			$uid=uc_user_register($array[username], $array[password], $array[email]);
			if($uid=='-1'){
				showerr('用户名不合法');
			}elseif($uid=='-2'){
				showerr('包含不允许注册的词语');
			}elseif($uid=='-3'){
				showerr('用户名已经存在');
			}elseif($uid=='-4'){
				showerr('email 格式有误');
			}elseif($uid=='-5'){
				showerr('email 不允许注册');
			}elseif($uid=='-6'){
				showerr('该 email 已经被注册');
			}
			if($uid&&eregi("^dzbbs7",$webdb[passport_type])){
				$this->db->query("INSERT INTO {$webdb[passport_pre]}memberfields SET uid='$uid'");
				$pwd=md5($array[password]);
				$this->db->query("INSERT INTO {$webdb[passport_pre]}members SET uid='$uid',username='$array[username]',password='$pwd',groupid=10,regip='$onlineip',regdate='$timestamp',email='$array[email]',newsletter='1',timeoffset='9999',editormode=2,customshow=26");
			}
		}else{
			$array[password] = md5($array[password]);
			$this->db->query("INSERT INTO {$this->pre}members SET uid='$array[uid]',username='$array[username]',password='$array[password]'");
			$uid=$this->db->insert_id();
		}
		
		return $uid;
	}
	
	//注册用户详细信息
	function register_data($array){
		global $webdb,$timestamp,$onlineip;
		if(!$array[uid]||!$array[username]){
			return false;
		}
		$array[groupid] || $array[groupid]=8;
		isset($array[yz]) || $array[yz]=1;
		$array[regdate] = $timestamp;
		$array[lastvist] = $timestamp;
		$array[regip] = $onlineip;
		$array[lastip] = $onlineip;

		$fieldArry=table_field("{$this->pre}memberdata");
		foreach($array AS $key=>$value){
			if(!in_array($key,$fieldArry)){
				continue;
			}
			$sqlDB[]="`{$key}`='$value'";
		}
		$this->db->query("INSERT INTO {$this->pre}memberdata SET ".implode(",",$sqlDB));
	}
	
	//用户注册
	function register_user($array){
		global $webdb;
		if($this->get_passport($array[username],'name')){
			return '当前用户已经存在了';
		}
		if(!$array[username]){
			return '用户名不能为空';
		}elseif(!$array[email]){
			return '邮箱不能为空';
		}elseif(!$array[password]){
			return '密码不能为空';
		}elseif(strlen($array[username])>15||strlen($array[username])<3){
			return '用户名不能小于3个字节或大于15个字节';
		}elseif (strlen($array[password])>30 || strlen($array[password])<5){
			return '密码不能小于5个字符或大于30个字符';
		}elseif(!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$array[email])){
			return '邮箱不符合规则';
		}elseif( $webdb[emailOnly] && $this->check_emailexists($array[email])){
			return '当前邮箱已被注册了,请更换一个邮箱!';
		}
		$S_key=array('|',' ','',"'",'"','/','*',',','~',';','<','>','$',"\\","\r","\t","\n","`","!","?","%","^");
		foreach($S_key as $value){
			if (strpos($array[username],$value)!==false){ 
				return "用户名中包含有禁止的符号“{$value}”"; 
			}
			if (strpos($password,$value)!==false){
				return "密码中包含有禁止的符号“{$value}”";
			}
		}
		
		foreach($array AS $key=>$value){
			$array[$key]=filtrate($value);
		}
		$array[uid]=$this->register_passport($array);		
		$this->register_data($array);
		return $array[uid];
	}
	
	//修改用户任意信息
	function edit_user($array) {
		if(!$array[username]){
			$rs = $this->get_info($array[uid]);
			if(!$rs[username]){
				return ;
			}
			$array[username] = $rs[username];			
		}
		$this->edit_passport($array);
		$fieldArry=table_field("{$this->pre}memberdata");
		foreach($array AS $key=>$value){
			if($key=='uid'||$key=='password'||$key=='username'||!in_array($key,$fieldArry)){
				continue;
			}
			$sqlDB[]="`{$key}`='$value'";
		}
		if($sqlDB){
			$this->db->query("UPDATE {$this->pre}memberdata SET ".implode(",",$sqlDB)." WHERE username='$array[username]'");
		}		
	}

	//仅修改通行证邮箱与密码
	function edit_passport($array) {
		global $webdb;

		if( $webdb[emailOnly]&&$array[email] ){
			$r=$this->check_emailexists($array[email]);
			if($r && $r[username]!=$array[username]){				
				showerr("当前邮箱存在了,请更换一个!");
			}
		}

		if(eregi("^pwbbs",$webdb[passport_type])){
			if($array[password]){
				$array[password] = md5($array[password]);
				$sql[]="password='$array[password]'";
			}
			if($array[email]){
				$sql[]="email='$array[email]'";
			}
			if($sql){
				$this->db->query("UPDATE {$webdb[passport_pre]}members SET ".implode(",",$sql)." WHERE username='$array[username]' ");
				return 1;
			}
		}elseif(defined("UC_CONNECT")){
			$rs = uc_user_edit($array[username] , '' , $array[password] , $array[email] , 1 );
			return $rs;
		}else{
			if($array[password]){
				$array[password] = md5($array[password]);
				$this->db->query("UPDATE {$this->pre}members SET password='$array[password]' WHERE username='$array[username]' ");
				return 1;
			}			
		}
	}
	
	//删除会员
	function delete_user($uid) {
		global $webdb;
		if(eregi("^pwbbs",$webdb[passport_type])){
			$this->db->query("DELETE FROM {$webdb[passport_pre]}members WHERE uid='$uid'");
			$this->db->query("DELETE FROM {$webdb[passport_pre]}memberdata WHERE uid='$uid'");
		}elseif(defined("UC_CONNECT")){
			$rs = $this->get_passport($uid);
			uc_user_delete($rs[username]);
		}else{
			$this->db->query("DELETE FROM {$this->pre}members WHERE uid='$uid'");
		}
		$this->db->query("DELETE FROM {$this->pre}memberdata WHERE uid='$uid'");
		//$this->db->query("DELETE FROM {$this->pre}memberdata_1 WHERE uid='$uid'");		
	}
	
	//获取会员总数
	function total_num($sql = '') {
		$rs = $this->db_passport->get_one("SELECT COUNT(*) AS NUM FROM {$this->memberTable} $sql");
		return $rs[NUM];
	}
	
	//获取一批会员资料信息
	function get_list($start, $num, $sql) {
		$query = $this->db_passport->query("SELECT * FROM {$this->memberTable} $sql LIMIT $start, $num");
		while($rs = $this->db_passport->fetch_array($query)){
			$listdb[]=$rs;
		}
		return $listdb;
	}
	
	//对于高版本数据库,获取数据库的编码
	function get_passport_charset(){
		$array=$this->db_passport->get_one("SHOW CREATE TABLE {$this->memberTable}");
		preg_match("/DEFAULT CHARSET=([-0-9a-z]+)/is",$array['Create Table'],$ar);
		return $ar[1];
	}
	
	//修改PW论坛资料,主要用在短消息提示音的修改
	function edit_pw_member($array){
		if(!$array[uid]){
			return false;
		}
		$fieldArry=table_field("{$this->memberTable}");
		foreach($array AS $key=>$value){
			if($key=='uid'||$key=='username'||!in_array($key,$fieldArry)){
				continue;
			}
			$sqlDB[]="`{$key}`='$value'";
		}
		if($sqlDB){
			$this->db_passport->query("UPDATE {$this->memberTable} SET ".implode(",",$sqlDB)." WHERE uid='$array[uid]'");
		}
	}
	
	//用户登录
	function login($username,$password,$cookietime,$not_pwd=false){
		extract($GLOBALS);
		if($not_pwd){	//不需要知道原始密码就能登录
			$rs=$this->get_passport($username,'name');
		}else{
			$rs = $this->check_password($username,$password);
			if(!is_array($rs)){
				return $rs;		//0为用户不存在,-1为密码不正确
			}
		}
		if(eregi("^pwbbs",$webdb[passport_type])){
			if($db_ifsafecv){
				$_r = $this->get_passport($username,'name');
				$safecv = $_r[safecv];
			}
			set_cookie(CookiePre().'_winduser',StrCode($rs[uid]."\t".PwdCode($rs[password])."\t$safecv"),$cookietime);
			set_cookie('lastvisit','',0);			
		}else{
			set_cookie("passport","$rs[uid]\t$username\t".mymd5("$rs[password]"),$cookietime);
		}
		if(defined("UC_CONNECT")){
			global $uc_login_code;
			$uc_login_code=uc_user_synlogin($rs[uid]);
		}
		return $rs[uid];
	}
	
	//用户退出
	function quit(){
		extract($GLOBALS);		
		if( ereg("^pwbbs",$webdb[passport_type]) ){
			set_cookie(CookiePre().'_winduser',"");
		}else{
			set_cookie("passport","");
		}
		set_cookie("token_secret","");
		setcookie("adminID","",0,"/");	//同步后台退出
		if(defined("UC_CONNECT")){
			global $uc_login_code;
			$uc_login_code = uc_user_synlogout();
		}
	}
	
	//用户登录状态的信息
	function login_info(){
		list($uid,$name,$pwd) = explode("\t",get_cookie('passport'));
		if( !$uid || !$pwd )
		{
			return '';
		}
		$detail = $this->get_allInfo($uid);
		if( mymd5($detail[password]) != $pwd ){
			$this->quit();
			return ;
		}
		return $detail;
	}

	//服务端通行证
	function passport_server($username,$url){
		global $WEBURL;
		if(eregi("^$WEBURL",$url)){
			showerr("网址有误!");
		}
		if(!strstr($url,'?')){
			$url.='?';
		}else{
			$url.='&';
		}
		$rs=$this->get_allInfo($username,'name');
		$md5code="uid=$rs[uid]&username=$rs[username]&password=$rs[password]&email=$rs[email]";
		$md5code=urlencode(mymd5($md5code));
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL={$url}md5code=$md5code'>";
		exit;
	}
}
?>