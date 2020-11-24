<?php
/**
*���ļ�����
**/
function read_file($filename,$method="rb"){
	if($handle=@fopen($filename,$method)){
		@flock($handle,LOCK_SH);
		$filedata=@fread($handle,@filesize($filename));
		@fclose($handle);
	}
	return $filedata;
}

/**
*д�ļ�����
**/
function write_file($filename,$data,$method="rb+",$iflock=1){
	@touch($filename);
	$handle=@fopen($filename,$method);
	if(!$handle&&!strstr($filename,'cache/label_cache')){
		echo "���ļ�����д:$filename";
	}
	if($iflock){
		@flock($handle,LOCK_EX);
	}
	@fputs($handle,$data);
	if($method=="rb+") @ftruncate($handle,strlen($data));
	@fclose($handle);
	@chmod($filename,0777);	
	if( is_writable($filename) ){
		return 1;
	}else{
		return 0;
	}
}

/**
*ͼ��������
**/
function gdpic($srcFile,$dstFile,$width,$height,$type=''){
	require_once(ROOT_PATH."inc/waterimage.php");
	if(is_array($type)){
		//��ȡһ����,������ƥ��ߴ�
		cutimg($srcFile,$dstFile,$x=$type[x]?$type[x]:0,$y=$type[y]?$type[y]:0,$width,$height,$x2=$type[x2]?$type[x2]:0,$y2=$type[y2]?$type[y2]:0,$scale=$type[s]?$type[s]:100,$fix=$type[fix]?$type[fix]:'');
	}elseif($type==1){
		//�ɱ���������
		ResizeImage($srcFile,$dstFile,$width,$height);
	}else{
		//��ߴ粻ƥ��ʱ.��ɫ�����
		gdfillcolor($srcFile,$dstFile,$width,$height);
	}
}

/**
*ɾ���ļ�,ֵ��Ϊ�գ��򷵻ز���ɾ�����ļ���
**/
function del_file($path){
	if (file_exists($path)){
		if(is_file($path)){
			if(	!@unlink($path)	){
				$show.="$path,";
			}
		} else{
			$handle = opendir($path);
			while (($file = readdir($handle))!='') {
				if (($file!=".") && ($file!="..") && ($file!="")){
					if (is_dir("$path/$file")){
						$show.=del_file("$path/$file");
					} else{
						if( !@unlink("$path/$file") ){
							$show.="$path/$file,";
						}
					}
				}
			}
			closedir($handle);
			if(!@rmdir($path)){
				$show.="$path,";
			}
		}
	}
	return $show;
}

function Tblank($string,$msg="���ݲ���ȫΪ�ո�"){
	$string=str_replace("&nbsp;","",$string);
	$string=str_replace(" ","",$string);
	$string=str_replace("��","",$string);
	$string=str_replace("\r","",$string);
	$string=str_replace("\n","",$string);
	$string=str_replace("\t","",$string);
	if(!$string){
		showerr($msg);
	}
}

/**
*���ݱ��ֶ���Ϣ��������
**/
function table_field($table,$field=''){
	global $db;
	$query=$db->query(" SELECT * FROM $table limit 1");
	$num=mysql_num_fields($query);
	for($i=0;$i<$num;$i++){
		$f_db=mysql_fetch_field($query,$i);
		$showdb[]=$f_db->name;
	}
	if($field){
		if(in_array($field,$showdb) ){
			return 1;
		}else{
			return 0;
		}
	}else{
		return $showdb;
	}
}
/**
*�ж����ݱ��Ƿ����
**/
function is_table($table){
	global $db;
	$query=$db->query("SHOW TABLE STATUS");
	while( $array=$db->fetch_array($query) ){
		if($table==$array[Name]){
			return 1;
		}
	}
}

/**
*�ϴ��ļ�
**/
function upfile($upfile,$array){
	global $db,$lfjuid,$pre,$webdb,$groupdb,$lfjdb,$timestamp;
	$FY=strtolower(strrchr(basename($upfile),"."));if($FY&&$FY!='.tmp'){die("<SCRIPT>alert('�ϴ��ļ�����');</SCRIPT>");}
	$filename=$array[name];

	$path=makepath(ROOT_PATH.$array[path]);

	if($path=='false')
	{
		showerr("���ܴ���Ŀ¼$array[path]���ϴ�ʧ��",1);
	}
	elseif(!is_writable($path))
	{
		showerr("Ŀ¼����д".$path,1);
	}

	$size=abs($array[size]);

	$filetype=strtolower(strrchr($filename,"."));

	if(!$upfile)
	{
		showerr("�ļ������ڣ��ϴ�ʧ��",1);
	}
	elseif(!$filetype)
	{
		showerr("�ļ������ڣ����ļ��޺�׺��,�ϴ�ʧ��",1);
	}
	else
	{
		if($filetype=='.php'||$filetype=='.asp'||$filetype=='.aspx'||$filetype=='.jsp'||$filetype=='.cgi'){
			showerr("ϵͳ�������ϴ���ִ���ļ�,�ϴ�ʧ��",1);
		}

		if( $groupdb[upfileType] && !in_array($filetype,explode(" ",$groupdb[upfileType])) )
		{
			showerr("�����ϴ����ļ���ʽΪ:$filetype,���������û���������ϴ����ļ���ʽΪ:$groupdb[upfileType]",1);
		}
		elseif( !in_array($filetype,explode(" ",$webdb[upfileType])) )
		{
			showerr("�����ϴ����ļ���ʽΪ:$filetype,��ϵͳ�������ϴ����ļ���ʽΪ:$webdb[upfileType]",1);
		}

		if( $groupdb[upfileMaxSize] && ($groupdb[upfileMaxSize]*1024)<$size )
		{
			showerr("�����ϴ����ļ���СΪ:".($size/1024)."K,���������û���������ϴ����ļ���СΪ:{$groupdb[upfileMaxSize]}K",1);
		}
		if( !$groupdb[upfileMaxSize] && $webdb[upfileMaxSize] && ($webdb[upfileMaxSize]*1024)<$size )
		{
			showerr("�����ϴ����ļ���СΪ:".($size/1024)."K,��ϵͳ�������ϴ����ļ���СΪ:{$webdb[upfileMaxSize]}K",1);
		}
	}
	//$oldname=preg_replace("/(.*)\.([^.]*)/is","\\1",$filename);
	//if(eregi("(.jpg|.png|.gif)$",$filetype)){
		$tempname="{$lfjuid}_".date("YmdHms_").rands(5).$filetype;
	//}else{
	//	$tempname="{$lfjuid}_".date("YmdHms_",time()).base64_encode(urlencode($oldname)).$filetype;
	//	$tempname=str_replace('+','%2B',$tempname);
	//}
	//if(strlen($tempname)>250||strstr($tempname,'+')){
	//	$tempname="{$lfjuid}_".date("YmdHms_",time()).rands(5).$filetype;
	//}
	$newfile="$path/$tempname";

	if(@move_uploaded_file($upfile,$newfile))
	{
		@chmod($newfile, 0777);
		$ck=2;
	}
    if(!$ck)
	{
		if(@copy($upfile,$newfile))
		{
			@chmod($newfile, 0777);
			$ck=2;
		}
	}
	if($ck)
	{	

		if(($array[size]+$lfjdb[usespace])>($webdb[totalSpace]*1048576+$groupdb[totalspace]*1048576+$lfjdb[totalspace])){
			//�е��û��鲻���ƿռ��С,$array[updateTable]
			if(!$groupdb[AllowUploadMax]){
				unlink($newfile);
				showerr("��Ŀռ䲻��,�ϴ�ʧ��,�������ϵ����Ա��������ռ�!",1);
			}
		}
		$db->query("UPDATE {$pre}memberdata SET usespace=usespace+'$size' WHERE uid='$lfjuid' ");

		//�Ը���������,ɾ������ĸ���.�Ը���������¼
		//$url=str_replace("$webdb[updir]/","",$array[path]);
		$oldname=preg_replace("/(.*)\.([^.]*)/is","\\1",$filename);
		$db->query("INSERT INTO `{$pre}upfile` ( `uid` , `posttime` , `url` , `filename`  ) VALUES ('$lfjuid','$timestamp','$tempname','$oldname' )");
		//setcookie("IF_upfile",$timestamp);

		return $tempname;
	}
	else
	{
		showerr("����ռ�����,�ϴ�ʧ��",1);
	}
}

/**
*����Ŀ¼
**/
function makepath($path){
	//���\û����
	$path=str_replace("\\","/",$path);
	$ROOT_PATH=str_replace("\\","/",ROOT_PATH);
	$detail=explode("/",$path);
	foreach($detail AS $key=>$value){
		if($value==''&&$key!=0){
			//continue;
		}
		$newpath.="$value/";
		if((eregi("^\/",$newpath)||eregi(":",$newpath))&&!strstr($newpath,$ROOT_PATH)){continue;}
		if( !is_dir($newpath) ){
			if(substr($newpath,-1)=='\\'||substr($newpath,-1)=='/')
			{
				$_newpath=substr($newpath,0,-1);
			}
			else
			{
				$_newpath=$newpath;
			}
			if(!is_dir($_newpath)&&!mkdir($_newpath)&&ereg("^\/",ROOT_PATH)){
				return 'false';
			}
			@chmod($newpath,0777);
		}
	}
	return $path;
}

/**
*ȡ����ʵĿ¼
**/
function tempdir($file,$type=''){
	global $webdb;
	if($type=='pwbbs'){
		global $db_attachname;
		if(is_file(ROOT_PATH."$webdb[passport_path]/$db_attachname/thumb/$file")){
			$file="$webdb[passport_url]/$db_attachname/thumb/$file";
		}else{
			$file="$webdb[passport_url]/$db_attachname/$file";
		}
		return $file;
	}elseif($type=='dzbbs'){
		global $_DCACHE;
		$file="$webdb[passport_url]/{$_DCACHE[settings][attachurl]}/$file";
		return $file;
	}elseif( ereg("://",$file)||ereg("^/./",$file) ){
		return $file;
	}elseif($webdb[mirror]&&!file_exists(ROOT_PATH."$webdb[updir]/$file")){	//FTP�����
		return $webdb[mirror].((eregi('\/$',$webdb[mirror])||eregi('^\/',$file))?'':'/').$file;
	}else{
		return $webdb[www_url].'/'.$webdb[updir].((eregi('\/$',$webdb[updir])||eregi('^\/',$file))?'':'/').$file;
	}
}

/**
*��ȡ�ַ�
**/
function get_word($content,$length,$more=1) {
	if(WEB_LANG=='utf-8'){
		$content = get_utf8_word($content, $length,$more);
		return $content;
	}

	if(WEB_LANG=='big5'){
		$more=1;	//�������Ļ�.��ȡ�ַ�����ʹ��ҳ������
	}

	if(!$more){
		$length=$length+2;
	}
	if($length>10){
		$length=$length-2;
	}
	if($length && strlen($content)>$length){
		$num=0;
		for($i=0;$i<$length-1;$i++) {
			if(ord($content[$i])>127){
				$num++;
			}
		}
		$num%2==1 ? $content=substr($content,0,$length-2):$content=substr($content,0,$length-1);
		$more && $content.='..';
	}
	return $content;
}

/**
*UTF8��ȡ�ַ�
**/
function get_utf8_word($string, $length = 80,$more=1 , $etc = '..')
{
	$strcut = '';
	$strLength = 0;
	$width  = 0;
	if(strlen($string) > $length) {
		//��$length�����ʵ��UTF8��ʽ�������ַ����ĳ���
		for($i = 0; $i < $length; $i++) {
			if ( $strLength >= strlen($string) ){
				break;
			}
			if ( $width>=$length){
				break;
			}
			//����⵽һ�������ַ�ʱ
			if( ord($string[$strLength]) > 127 ){
				$strLength += 3;
				$width     += 2;              //��Ű�һ�����ֿ����൱������Ӣ���ַ��Ŀ���
			}else{
				$strLength += 1;
				$width     += 1;
			}
		}
		return substr($string, 0, $strLength).$etc;
	} else {
		return $string;
	}
}


/**
*���˰�ȫ�ַ�
**/
function filtrate($msg){
	//$msg = str_replace('&','&amp;',$msg);
	//$msg = str_replace(' ','&nbsp;',$msg);
	$msg = str_replace('"','&quot;',$msg);
	$msg = str_replace("'",'&#39;',$msg);
	$msg = str_replace("<","&lt;",$msg);
	$msg = str_replace(">","&gt;",$msg);
	$msg = str_replace("\t","   &nbsp;  &nbsp;",$msg);
	//$msg = str_replace("\r","",$msg);
	$msg = str_replace("   "," &nbsp; ",$msg);
	return $msg;
}

/*���˲���������*/
function replace_bad_word($str){
	global $Limitword;
	@include_once(ROOT_PATH."data/limitword.php");
	foreach( $Limitword AS $old=>$new){
		strlen($old)>2 && $str=str_replace($old,trim($new),$str);
	}
	return $str;
}


/**
*ȡ�̶�ͼƬ��С
**/
function pic_size($pic,$w,$h,$url){
	global $updir,$webdb,$N_path;
	$rand=rands(5);
	$show="<script>
			function resizeimage_$rand(obj) {
				var imageObject;
				var MaxW = $w;
				var MaxH = $h;
				imageObject = obj;
				var oldImage = new Image();
				oldImage.src = imageObject.src;
				var dW = oldImage.width;
				originalw=dW;
				var dH = oldImage.height;
				originalh=dH;
				if (dW>MaxW || dH>MaxH) {
					a = dW/MaxW;
					b = dH/MaxH;
					if (b>a) {
						a = b;
					}
					dW = dW/a;
					dH = dH/a;
				}
				if (dW>0 && dH>0) {
					imageObject.width = dW;
					imageObject.height = dH;
				}
			}
			</script>";
	return "$show<a href='$url' target='_blank'><img onload='resizeimage_$rand(this)' src='$pic' border=0 width='$w' height='$h'></a>";
}

/**
*ģ����غ���
**/
function html($html,$tpl=''){
	global $STYLE;
	if($tpl&&strstr($tpl,substr(ROOT_PATH,0,-1))&&file_exists($tpl))
	{
		return $tpl;
	}
	elseif($tpl&&file_exists(ROOT_PATH.$tpl))
	{
		return ROOT_PATH.$tpl;
	}
	elseif(file_exists(ROOT_PATH."template/".$STYLE."/".$html.".htm"))
	{
		return ROOT_PATH."template/".$STYLE."/".$html.".htm";
	}
	elseif(file_exists(ROOT_PATH."template/default/".$html.".htm"))
	{
		return ROOT_PATH."template/default/".$html.".htm";
	}
}

/**
*��ҳ
**/
function getpage($table,$choose,$url,$rows=20,$total=''){
	global $page,$db;
	if(!$page){
		$page=1;
	}
	//������$total��ʱ��.�Ͳ����ٶ����ݿ�
	if(!$total && $table){
		$query=$db->get_one("SELECT COUNT(*) AS num  FROM $table $choose");
		$total=$query['num'];
	}
	$totalpage=@ceil($total/$rows);
	$nextpage=$page+1;
	$uppage=$page-1;
	if($nextpage>$totalpage){
		$nextpage=$totalpage;
	}
	if($uppage<1){
		$uppage=1;
	}
	$s=$page-3;
	if($s<1){
		$s=1;
	}
	$b=$s;
	for($ii=0;$ii<6;$ii++){
		$b++;
	}
	if($b>$totalpage){
		$b=$totalpage;
	}
	for($j=$s;$j<=$b;$j++){
		if($j==$page){
			$show.=" <a href='#'><font color=red>$j</font></a>";
		}else{
			$show.=" <a href=\"$url&page=$j\" title=\"��{$j}ҳ\">$j</a>";
		}
	}
	$showpage="<a href=\"$url&page=1\" title=\"��ҳ\">��ҳ</A> <a href=\"$url&page=$uppage\" title=\"��һҳ\">��һҳ</A>  {$show}  <a href=\"$url&page=$nextpage\" title=\"��һҳ\">��һҳ</A> <a href=\"$url&page=$totalpage\" title=\"βҳ\">βҳ</A> <a href='#'><font color=red>$page</font>/$totalpage/$total</a>";
    if($totalpage>1){
		return $showpage;
	}
}

/**
*ҳ����ת����
**/
function refreshto($url,$msg,$time=1){
	global $webdb;
	if($time==0){
		header("location:$url");
	}else{
		require(ROOT_PATH."template/default/refreshto.htm");
		$content=ob_get_contents();
		ob_end_clean();
		ob_start();
		if($webdb[www_url]=='/.'){
			$content=str_replace('/./','/',$content);
		}
		echo $content;
	}
	exit;
}


/**
*����ҳ�溯��
**/
function showerr($showerrMsg,$type=''){
	require_once(ROOT_PATH."data/level.php");
	if($type==1){
		$showerrMsg=str_replace("'","\'",$showerrMsg);
		echo "<SCRIPT LANGUAGE=\"JavaScript\">
		<!--
		alert('$showerrMsg');
		if(document.referrer==''&&window.self==window.top){
			window.self.close();
		}else{
			history.back(-1);
		}		
		//-->
		</SCRIPT>";
	}else{
		extract($GLOBALS);
		require(ROOT_PATH."template/default/showerr.htm");
		$content=ob_get_contents();
		ob_end_clean();
		ob_start();
		if($webdb[www_url]=='/.'){
			$content=str_replace('/./','/',$content);
		}
		echo $content;
	}
	exit;
}

 
/**
*ȡ������ַ�
**/
function rands($length,$strtolower=1) {
	$hash = '';
	$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
	$max = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $length; $i++) {
		$hash .= $chars[mt_rand(0, $max)];
	}
	if($strtolower==1){
		$hash=strtolower($hash);
	}
	return $hash;
}

/**
*��������תUTF8����
**/
function gbk2utf8($text) {
	if(function_exists('iconv')){
		$text = iconv('GBK', 'UTF-8',$text);
		return $text;
	}
	$fp = fopen(ROOT_PATH."inc/gbkcode/gbk2utf8.table","r");
	while(! feof($fp)) {
		list($gb,$utf8) = fgetcsv($fp,10);
		$charset[$gb] = $utf8;
	}
	fclose($fp);		//���϶�ȡ���ձ������鱸��wl__hd_sg2_02.gif

	//��ȡ�ı��еĳɷ֣�����Ϊһ��Ԫ�أ������ķǺ���Ϊһ��Ԫ��
	preg_match_all("/(?:[\x80-\xff].)|[\x01-\x7f]+/",$text,$tmp);
	$tmp = $tmp[0];
	//���������
	$ar = array_intersect($tmp, array_keys($charset));
	//�滻���ֱ���
	foreach($ar as $k=>$v)
    $tmp[$k] = $charset[$v];
	//���ػ����Ĵ�
	return join('',$tmp);
}





/**
*��������ܺ���
**/
function mymd5($string,$action="EN",$rand=''){ //�ַ������ܺͽ��� 
	global $webdb;
	if($action=="DE"){//����+����URL���ݹ����л��쳣
		$string = str_replace('QIBO|ADD','+',$string);
	}
    $secret_string = $webdb[mymd5].$rand.'5*j,.^&;?.%#@!'; //�����ַ���,���������趨 
	if(!is_string($string)){
		$string=strval($string);
	}
    if($string==="") return ""; 
    if($action=="EN") $md5code=substr(md5($string),8,10); 
    else{ 
        $md5code=substr($string,-10); 
        $string=substr($string,0,strlen($string)-10); 
    }
    //$key = md5($md5code.$_SERVER["HTTP_USER_AGENT"].$secret_string);
	$key = md5($md5code.$secret_string); 
    $string = ($action=="EN"?$string:base64_decode($string)); 
    $len = strlen($key); 
    $code = "";
    for($i=0; $i<strlen($string); $i++){ 
        $k = $i%$len; 
        $code .= $string[$i]^$key[$k]; 
    }
    $code = ($action == "DE" ? (substr(md5($code),8,10)==$md5code?$code:NULL) : base64_encode($code)."$md5code");
	if($action=="EN"){//����+����URL���ݹ����л��쳣
		$code = str_replace('+','QIBO|ADD',$code);
	}
    return $code; 
}

function pwd_md5($code){
	return md5($code);
}


function set_cookie($name,$value,$cktime=0){
	global $webdb;
	if($cktime!=0){
		$cktime=time()+$cktime;
	}
	if($value==''){
		$cktime=time()-31536000;
	}
	$S = $_SERVER['SERVER_PORT'] == '443' ? 1:0;
	if($webdb[cookiePath]){
		$path=$webdb[cookiePath];
	}else{
		$path="/";
	}
	$domain=$webdb[cookieDomain];
	setCookie("$webdb[cookiePre]$name",$value,$cktime,$path,$domain,$S);
}

function get_cookie($name){
	global $webdb;
    return $_COOKIE["$webdb[cookiePre]$name"];
}

function add_user($uid,$money,$about=''){
	global $db,$pre,$timestamp,$webdb,$pre;
	$money = intval($money);
	if(!$money||!$uid){
		return ;
	}
	//$db->query(" UPDATE {$pre}memberdata SET money=money+'$webdb[postArticleMoney]' WHERE uid='$uid' ");
	plus_money($uid,$money,$moneytype='');

	$about = addslashes($about);
	$webdb[moneylog_num] = 100;		//ֻ����ÿ���û������100����¼
	@extract($db->get_one("SELECT COUNT(*) AS NUM FROM `{$pre}moneylog` WHERE uid='$uid'"));
	if($NUM>$webdb[moneylog_num]){
		$num=$NUM-$webdb[moneylog_num]+1;
		$db->query("DELETE FROM `{$pre}moneylog` WHERE uid='$uid' ORDER BY id ASC LIMIT $num");
	}
	//���ӻ��ֱ仯��־
	$db->query("INSERT INTO `{$pre}moneylog` ( `uid` , `money` , `about` , `posttime` ) VALUES ('$uid', '$money', '$about', '$timestamp')");
}

//�����û�����
function plus_money($uid,$money,$moneytype=''){
	global $db,$pre,$_pre,$webdb,$TB_pre,$lfjdb;

	if($moneytype=='')
	{
		$moneytype='money';
	}

	if( $webdb[UseMoneyType]=='bbs' )
	{
		if( eregi("^pwbbs",$webdb[passport_type]) )
		{
			$db->query("UPDATE {$TB_pre}memberdata SET $moneytype=$moneytype+'$money' WHERE uid='$uid'");
		}
		elseif( eregi("^dzbbs",$webdb[passport_type]) )
		{
			$db->query("UPDATE {$TB_pre}members SET extcredits2=extcredits2+'$money' WHERE uid='$uid'");
		}
	}
	else
	{
		$db->query("UPDATE {$pre}memberdata SET money=money+'$money' WHERE uid='$uid'");
	}
}

//sock��ʽ��Զ���ļ�
function sockOpenUrl($url,$method='GET',$postValue='',$Referer='Y'){
	if($Referer=='Y'){
		$Referer=$url;
	}
	$method = strtoupper($method);
	if(!$url){
		return '';
	}elseif(!ereg("://",$url)){
		$url="http://$url";
	}
	$urldb=parse_url($url);
	$port=$urldb[port]?$urldb[port]:80;
	$host=$urldb[host];
	$query='?'.$urldb[query];
	$path=$urldb[path]?$urldb[path]:'/';
	$method=$method=='GET'?"GET":'POST';

	if(function_exists('fsockopen')){
		$fp = fsockopen($host, $port, $errno, $errstr, 30);
	}elseif(function_exists('pfsockopen')){
		$fp = pfsockopen($host, $port, $errno, $errstr, 30);		
	}elseif(function_exists('stream_socket_client')){
		$fp = stream_socket_client($host.':'.$port, $errno, $errstr, 30);	
	}else{
		die("��������֧�����º���:fsockopen,pfsockopen,stream_socket_client����ʧ��!");
	}
	if(!$fp)
	{
		echo "$errstr ($errno)<br />\n";
	}
	else
	{
		$out = "$method $path$query HTTP/1.1\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Cookie: c=1;c2=2\r\n";
		$out .= "Referer: $Referer\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Connection: Close\r\n";
		if ( $method == "POST" ) {
			$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
			$length = strlen($postValue);
			$out .= "Content-Length: $length\r\n";
			$out .= "\r\n";
			$out .= $postValue;
		}else{
			$out .= "\r\n";
		}
		fwrite($fp, $out);
		while (!feof($fp)) {
			$file.= fgets($fp, 256);
		}
		fclose($fp);
		if(!$file){
			return '';
		}
		$ck=0;
		$string='';
		$detail=explode("\r\n",$file);
		foreach( $detail AS $key=>$value){
			if($value==''){
				$ck++;
				if($ck==1){
					continue;
				}
			}
			if($ck){
				$stringdb[]=$value;
			}
		}
		$string=implode("\r\n",$stringdb);
		//$string=preg_replace("/([\d]+)(.*)0/is","\\2",$string);
		return $string;
	}
}


/*ͳ�Ƹ���*/
function get_content_attachment($str){
	global $webdb;
	$rule=str_replace( array(".","/") , array("\.","\/") , $webdb[www_url] );
	preg_match_all("/$rule\/([a-z_\.0-9A-Z]+)\/([a-z_\.\/0-9A-Z=]+)/is",$str,$array);
	$filedb=$array[2];
	foreach($filedb AS $key=>$value){
		if(strstr($value,'baidu/dialogs/attachment/'))unset($filedb[$key]);
	}
	if($webdb[mirror]){
		$rule=str_replace( array(".","/") , array("\.","\/") , $webdb[mirror] );
		preg_match_all("/$rule\/([a-z_\.\/0-9A-Z=]+)/is",$str,$array2);
		if( is_array($filedb) ){
			$filedb+=$array2[1];
		}else{
			$filedb=$array2[1];
		}
	}
	return $filedb;
}

/*ɾ������*/
function delete_attachment($uid,$str){
	global $webdb,$db,$pre;
	if(!$str||!$uid){
		return ;
	}
	//��ʵ��ַ��ԭ
	$str=En_TruePath($str,0);

	$filedb=get_content_attachment($str);
	foreach( $filedb AS $key=>$value){
		$name=basename($value);
		$detail=explode("_",$name);
		//��ȡ�ļ���UID���û���UIDһ��ʱ.��ɾ��.��Ҫ��ɾ��
		
		if($detail[0]&&$detail[0]==$uid){
			$turepath=ROOT_PATH.$webdb[updir]."/".$value;
			
			if($rs=$db->get_one("SELECT * FROM {$pre}upfile WHERE filename='$name'")){
				if($rs[num]>1){
					$db->query("UPDATE `{$pre}upfile` SET `num`=`num`-1 WHERE filename='$name'");
					continue;
				}
				$db->query("DELETE FROM `{$pre}upfile` WHERE filename='$name'");
			}
			$size=@filesize($turepath);
			$size && @unlink($turepath);
			//ɾ��FTP�ϵ���Դ
			if(!$size&&$webdb[ArticleDownloadUseFtp]){
				$value && $size=ftp_delfile($value);
			}
			$db->query(" UPDATE {$pre}memberdata SET usespace=usespace-'$size' WHERE uid='$uid' ");
		}
	}
}

/*�ƶ�����*/
function move_attachment($uid,$str,$newdir,$type=''){
	global $webdb;
	if(!$str||!$uid||!$newdir){
		return $str;
	}
	$filedb = get_content_attachment($str);
	foreach($filedb AS $value){
		$name=basename($value);
		$ture_old_path = ROOT_PATH."$webdb[updir]/$value";
		$ture_new_path = ROOT_PATH."$webdb[updir]/$newdir/$name";

		if(is_file($ture_new_path)||!is_file($ture_old_path)){
			continue;
		}
		$detail=explode("_",$name);
		//��ȡ�ļ���UID���û���UIDһ��ʱ.��ɾ��.��Ҫ��ɾ��
		if($detail[0] && $detail[0]==$uid){
			
			if(!is_dir(ROOT_PATH.$webdb[updir]."/".$newdir)){			
				makepath(ROOT_PATH.$webdb[updir]."/".$newdir);
			}

			//�Զ���С̫���ŵ�ͼƬ
			if( $webdb[ArticlePicWidth] && $webdb[ArticlePicHeight] && eregi("(gif|png|jpg)$",$ture_old_path) ){
				$img_array=getimagesize($ture_old_path);
				if($img_array[0]>$webdb[ArticlePicWidth]||$img_array[1]>$webdb[ArticlePicHeight]){
					gdpic($ture_old_path,$ture_old_path,$webdb[ArticlePicWidth],$webdb[ArticlePicHeight],1);
				}
			}

			//ͼƬ��ˮӡ
			if( $type!='small' && $webdb[is_waterimg] && eregi("(gif|png|jpg)$",$ture_old_path) ){			
				include_once(ROOT_PATH."inc/waterimage.php");
				imageWaterMark($ture_old_path,$webdb[waterpos],ROOT_PATH.$webdb[waterimg]);
			}

			if( @rename($ture_old_path,$ture_new_path) ){			
				$str=str_replace("$value","$newdir/$name",$str);
			}
		}
	}
	return $str;
}

//����ʵ��ַ������
function En_TruePath($content,$type=1,$ifgetplayer=0){
	global $webdb;
	if($type==1)
	{
		//ʹ����Զ�̸�������,Ҫ���ر���,��������ʹ��FTP
		if($webdb[mirror]){
			$content=str_replace("$webdb[mirror]","http://www_qibosoft_com/Tmp_updir",$content);
		}
		$content=str_replace("$webdb[www_url]/$webdb[updir]","http://www_qibosoft_com/Tmp_updir",$content);		
		$content=str_replace("$webdb[www_url]","http://www_qibosoft_com",$content);
	}
	else
	{
		//ʹ����Զ�̸�������,Ҫ���ر���,��������ʹ��FTP
		if($webdb[mirror]){
			$content=preg_replace("/http:\/\/www_php168_com\/Tmp_updir([-_=\/\.A-Za-z0-9]+)/eis","tempdir('\\1')",$content);
			$content=preg_replace("/http:\/\/www_qibosoft_com\/Tmp_updir([-_=\/\.A-Za-z0-9]+)/eis","tempdir('\\1')",$content);
		}else{
			$content=str_replace("http://www_php168_com/Tmp_updir","$webdb[www_url]/$webdb[updir]",$content);
			$content=str_replace("http://www_qibosoft_com/Tmp_updir","$webdb[www_url]/$webdb[updir]",$content);
		}		
				
		$content=str_replace("http://www_php168_com","$webdb[www_url]",$content);
		$content=str_replace("http://www_qibosoft_com","$webdb[www_url]",$content);
		if($ifgetplayer){

			//��԰ٶȱ༭��
			$content=preg_replace("/<embed([^>]+)class=\"edui-faked-video\"([^>]+)\/>/eis","get_play_element('\\2')",$content);
			$content=preg_replace("/\[(mp3|flv|wmv|flash|rmvb),([\d]+),([\d]+)\]([^\[]+)\[\/(mp3|flv|wmv|flash|rmvb)\]/eis","player('\\4','\\2','\\3','true','\\1')",$content);
		}
		//�Զ���ȫһЩ���ԳƵ�TABLE,TD,DIV��ǩ
		//$content=check_html_format($content);
	}
	return $content;
}

//��԰ٶȱ༭��
function get_play_element($str){
	$str = stripslashes($str);
	preg_match_all("/ ([\w]+)=\"([^\"]+)\"/is",$str,$array);
	$Ar = array('src','width','height','play','vtype');
	foreach($array[1] AS $key=>$value){
		if(in_array($value,$Ar)){
			$$value = $array[2][$key];	
		}
	}
	$code = player($src,$width,$height,$play,$vtype);
	return $code;
}

//��ȡ��������Ŀ
function Get_SonFid($table,$fid=0){
	global $db;
	$query = $db->query("SELECT fid,sons FROM $table WHERE fup=$fid");
	while($rs = $db->fetch_array($query)){
		if($rs[sons]){
			$array2=Get_SonFid($table,$rs[fid]);
			if($array2){
				foreach( $array2 AS $key=>$value){
					$array[]=$value;
				}
			}
		}
		$array[]=$rs[fid];
	}
	return $array;
}

//��̬��ҳ����
function Explain_HtmlUrl(){
	global $fid,$aid,$id,$page,$WEBURL;
	$detail=explode("fid-",$WEBURL);
	$detail2=explode(".",$detail[1]);
	$rs=explode("-",$detail2[0]);
	$fid=$rs[0];					//LISTҳ��fid,bencandyҳ��fid
	$rs[1] && $$rs[1]=$rs[2];		//������LISTҳ��PAGE,Ҳ������bencandyҳ��id
	$rs[3] && $$rs[3]=$rs[4];		//bencandyҳ��page
}


//��ȡ�û�����
function get_money($uid,$moneytype=''){
	global $db,$pre,$_pre,$webdb,$TB_pre,$lfjdb;
	
	if($moneytype=='')
	{
		$moneytype='money';
	}

	if( $webdb[UseMoneyType]=='bbs'&&$webdb[passport_type] )
	{
		if( eregi("^pwbbs",$webdb[passport_type]) )
		{
			$rs=$db->get_one("SELECT * FROM {$TB_pre}memberdata WHERE uid='$uid'");
			return $rs[$moneytype];
		}
		elseif( eregi("^dzbbs",$webdb[passport_type]) )
		{
			$rs=$db->get_one("SELECT * FROM {$TB_pre}members WHERE uid='$uid'");
			return $rs[extcredits2];
		}
	}
	else
	{
		if($lfjdb[uid]==$uid)
		{
			return $lfjdb[money];
		}
		else
		{
			$rs=$db->get_one("SELECT * FROM {$pre}memberdata WHERE uid='$uid'");
			return $rs[money];
		}
	}
}



/*ҳ����ʾ,ǿ�ƹ��˹ؼ���*/
function kill_badword($content){
	global $webdb,$Limitword;
	if($webdb[kill_badword])
	{
		if(!$content)
		{
			$content=@ob_get_contents();
			$ck++;
		}
		
		@include_once(ROOT_PATH."data/limitword.php");

		foreach( $Limitword AS $key=>$value){
			$content=str_replace($key,$value,$content);
		}
		if($ck)
		{
			ob_end_clean();
			ob_start();
			echo $content;
		}
		else
		{
			return $content;
		}
	}
	else
	{
		return $content;
	}
}

function send_msg($uid,$title,$content,$fromuid=0){
	global $lfjid;
	$fromer = $fromuid?$lfjid:'SYSTEM';
	$array = array(
		'touid' => $uid,
		'fromuid' => $fromuid,
		'title' => $title,
		'content' => $content,
		'fromer' => $fromer,
		);
	pm_msgbox($array);
}

//��վ����Ϣ
function pm_msgbox($array){
	global $db,$pre,$timestamp,$webdb,$TB_pre,$TB,$userDB,$db_modes;
	$array[content] = addslashes($array[content]);
	$array[title] = addslashes($array[title]);

	if(strlen($array[title])>130){
		showerr("���ⲻ�ܴ���65������");
	}
	$db->query("INSERT INTO `{$pre}pm` (`touid`,`fromuid`, `username`, `type`, `ifnew`, `title`, `mdate`, `content`) VALUES ('$array[touid]','$array[fromuid]', '$array[fromer]', 'rebox', '1', '$array[title]', '$timestamp', '$array[content]')");
}


//����ϵͳģ�黺��
function make_module_cache(){
	global $db,$pre;
	$query = $db->query("SELECT * FROM {$pre}module ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){	
		$listdb[$rs['pre']]=$rs;
	}
	write_file(ROOT_PATH."data/module.php",'<?php  $ModuleDB = '.var_export($listdb,true).';?>');
}

//����IP��ȡ��Դ��
function ipfrom($ip) {
	if(!preg_match("/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/", $ip)) {
		return '';
	}
	if( !is_file(ROOT_PATH.'inc/ip.dat') ){
		return '<a title><A HREF="http://down.qibosoft.com/ip.rar" title="������غ�,��ѹ�ŵ���վ/inc/Ŀ¼����">IP�ⲻ����,��������һ��!</A></a>';
	}
	if($fd = @fopen(ROOT_PATH.'inc/ip.dat', 'rb')) {

		$ip = explode('.', $ip);
		$ipNum = $ip[0] * 16777216 + $ip[1] * 65536 + $ip[2] * 256 + $ip[3];

		$DataBegin = fread($fd, 4);
		$DataEnd = fread($fd, 4);
		$ipbegin = implode('', unpack('L', $DataBegin));
		if($ipbegin < 0) $ipbegin += pow(2, 32);
		$ipend = implode('', unpack('L', $DataEnd));
		if($ipend < 0) $ipend += pow(2, 32);
		$ipAllNum = ($ipend - $ipbegin) / 7 + 1;

		$BeginNum = 0;
		$EndNum = $ipAllNum;

		while($ip1num > $ipNum || $ip2num < $ipNum) {
			$Middle= intval(($EndNum + $BeginNum) / 2);

			fseek($fd, $ipbegin + 7 * $Middle);
			$ipData1 = fread($fd, 4);
			if(strlen($ipData1) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip1num = implode('', unpack('L', $ipData1));
			if($ip1num < 0) $ip1num += pow(2, 32);

			if($ip1num > $ipNum) {
				$EndNum = $Middle;
				continue;
			}

			$DataSeek = fread($fd, 3);
			if(strlen($DataSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$DataSeek = implode('', unpack('L', $DataSeek.chr(0)));
			fseek($fd, $DataSeek);
			$ipData2 = fread($fd, 4);
			if(strlen($ipData2) < 4) {
				fclose($fd);
				return '- System Error';
			}
			$ip2num = implode('', unpack('L', $ipData2));
			if($ip2num < 0) $ip2num += pow(2, 32);

			if($ip2num < $ipNum) {
				if($Middle == $BeginNum) {
					fclose($fd);
					return '- Unknown';
				}
				$BeginNum = $Middle;
			}
		}

		$ipFlag = fread($fd, 1);
		if($ipFlag == chr(1)) {
			$ipSeek = fread($fd, 3);
			if(strlen($ipSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipSeek = implode('', unpack('L', $ipSeek.chr(0)));
			fseek($fd, $ipSeek);
			$ipFlag = fread($fd, 1);
		}

		if($ipFlag == chr(2)) {
			$AddrSeek = fread($fd, 3);
			if(strlen($AddrSeek) < 3) {
				fclose($fd);
				return '- System Error';
			}
			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}

			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr2 .= $char;

			$AddrSeek = implode('', unpack('L', $AddrSeek.chr(0)));
			fseek($fd, $AddrSeek);

			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr1 .= $char;
		} else {
			fseek($fd, -1, SEEK_CUR);
			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr1 .= $char;

			$ipFlag = fread($fd, 1);
			if($ipFlag == chr(2)) {
				$AddrSeek2 = fread($fd, 3);
				if(strlen($AddrSeek2) < 3) {
					fclose($fd);
					return '- System Error';
				}
				$AddrSeek2 = implode('', unpack('L', $AddrSeek2.chr(0)));
				fseek($fd, $AddrSeek2);
			} else {
				fseek($fd, -1, SEEK_CUR);
			}
			while(($char = fread($fd, 1)) != chr(0))
				$ipAddr2 .= $char;
		}
		fclose($fd);

		if(preg_match('/http/i', $ipAddr2)) {
			$ipAddr2 = '';
		}
		$ipaddr = "$ipAddr1 $ipAddr2";
		$ipaddr = preg_replace('/CZ88\.NET/is', '', $ipaddr);
		$ipaddr = preg_replace('/^\s*/is', '', $ipaddr);
		$ipaddr = preg_replace('/\s*$/is', '', $ipaddr);
		if(preg_match('/http/i', $ipaddr) || $ipaddr == '') {
			$ipaddr = '- Unknown';
		}

		if(WEB_LANG=='big5'){
			require_once(ROOT_PATH."inc/class.chinese.php");
			$cnvert = new Chinese("GB2312","BIG5",$ipaddr,ROOT_PATH."./inc/gbkcode/");
			$ipaddr = $cnvert->ConvertIT();
		}elseif(WEB_LANG=='utf-8'){
			require_once(ROOT_PATH."inc/class.chinese.php");
			$cnvert = new Chinese("GB2312","UTF8",$ipaddr,ROOT_PATH."./inc/gbkcode/");
			$ipaddr = $cnvert->ConvertIT();
		}

		return $ipaddr;
	}
}

function ftp_upfile($source,$file,$ifdel=1){
	global $webdb;
	if(!$webdb[FtpHost]||!$webdb[FtpName]||!$webdb[FtpPwd]||!$webdb[FtpPort]||!$webdb[FtpDir]){
		return ;
	}
	require_once(ROOT_PATH."inc/ftp.php");
	$ftp = new FTP($webdb[FtpHost],$webdb[FtpPort],$webdb[FtpName],$webdb[FtpPwd],$webdb[FtpDir]);
	$path=dirname($file);
	$detail=explode("/",$path);
	//$pathname=$webdb[FtpDir];
	foreach( $detail AS $key=>$value){
		$pathname.="$value/";
		if(!$ftp->dir_exists($pathname)){
			$ftp->mkd($pathname);
		}
	}
	$ifput=$ftp->upload($source,$file);
	$ftp->close();
	if($ifput){
		$ifdel && unlink($source);
		return "$webdb[mirror]/$file";
	}else{
		return "$webdb[www_url]/$webdb[updir]/$file";
	}
}

function ftp_delfile($file){
	global $webdb;
	if(!$webdb[FtpHost]||!$webdb[FtpName]||!$webdb[FtpPwd]||!$webdb[FtpPort]||!$webdb[FtpDir]){
		return ;
	}
	require_once(ROOT_PATH."inc/ftp.php");
	$ftp = new FTP($webdb[FtpHost],$webdb[FtpPort],$webdb[FtpName],$webdb[FtpPwd],$webdb[FtpDir]);
	$size = $ftp->size($file,0);
	$ftp->delete($file);
	$ftp->close();
	return $size;
}

//�����ֻ�����
function sms_send($mob,$content){
	global $webdb;
	if($webdb[fetion_id]&&$webdb[fetion_pwd]&&in_array($mob,explode("\r\n",$webdb[fetion_friend]))){
		$url="http://sms.api.bz/fetion.php?username=$webdb[fetion_id]&password=$webdb[fetion_pwd]&sendto=$mob&message=$content";
		$msg=sockOpenUrl($url);die("$msg-$url");
		return 1;
	}elseif($webdb[sms_type]=='eshang8'){
		//$url="http://http.chinasms.com.cn/tx/?uid=$webdb[sms_es_name]&key=".strtolower(md5($webdb[sms_es_key]))."&msg=$content&phone=$mob&smskind=1";
		$url="http://http.chinasms.com.cn/tx/?uid=$webdb[sms_es_name]&pwd=".strtolower(md5($webdb[sms_es_key]))."&content=$content&mobile=$mob&smskind=1";
		if( !$msg=sockOpenUrl($url) ){
			//$msg=file_get_contents($url);
		}
		if($msg===''){
			return 0;
		}elseif($msg==='100'){
			return 1;			//���ͳɹ�
		}else{
			return $msg;
		}
	}elseif($webdb[sms_type]=='winic'){
		$url="http://service.winic.org/sys_port/gateway/?id=$webdb[sms_wi_id]&pwd=$webdb[sms_wi_pwd]&to=$mob&content=$content&time=";
		if( !$msg=sockOpenUrl($url) ){
			//$msg=file_get_contents($url);
		}
		if($msg===''){
			return 0;
		}
		$detail=explode("/",$msg);
		if($detail[0]==='000'){
			return 1;			//���ͳɹ�
		}else{
			return $detail[0];
		}
	}elseif($webdb[sms_type]=='ccell'){
		if(WEB_LANG!='utf-8'){
			$content = gbk2utf8($content);
		}			
		$url="http://211.147.244.114:9801/CASServer/SmsAPI/SendMessage.jsp?userid=$webdb[sms_ccell_id]&password=$webdb[sms_ccell_pwd]&destnumbers=$mob&msg=$content&sendtime=";
		if( !$msg=file_get_contents($url) ){
			//$msg=file_get_contents($url);
		}
		if($msg===''){
			return 0;
		}
		if(strstr($msg,'messages="1"')){
			return 1;			//���ͳɹ�
		}else{
			return $msg;
		}
	}else{
		showerr("ϵͳû��ѡ����Žӿ�ƽ̨!");
	}
}


/**
�Զ���ģ�͵���,��ȡ������select,radio,checkbox���������ơ�
1|�й�
2|����
����ʵֵ
**/
function SRC_true_value($rs,$rsdb_v){
	if($rs[form_type]=='radio'||$rs[form_type]=='select'){
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $_key=>$value){
			list($v1,$v2)=explode("|",$value);
			if($v1==$rsdb_v&&$v2){
				$rsdb_v=$v2;
				break;
			}
		}
	}elseif($rs[form_type]=='checkbox'){
		$detail2=explode("/",$rsdb_v);
		$detail=explode("\r\n",$rs[form_set]);
		foreach( $detail AS $_key=>$value){
			list($v1,$v2)=explode("|",$value);
			if(in_array($v1,$detail2)&&$v2){
				foreach( $detail2 AS $key2=>$value2){
					if($value2==$v1){
						$detail2[$key2]=$v2;
						break;
					}
				}
			}
		}
		$rsdb_v=implode(" , ",$detail2);
	}
	return $rsdb_v;
}



//�û���¼
function user_login($username,$password,$cookietime){
	global $userDB;
	$rs = $userDB->login($username,$password,$cookietime);
	return $rs;
}

//��ȡUNIXʱ��,��Ҫ���ر����������.��������08��8�᲻һ���Ľ��,��������������
function mk_time($h,$i, $s, $m, $d, $y){
	$time=@mktime(intval($h),intval($i),intval($s),intval($m),intval($d),intval($y));
	return $time;
}


//���ĳ���ؼ����Ƿ�������������
function ifin_array($array,$filename,$ISin=''){
	foreach($array as $key=>$value){
		if(!is_array($value)){
			if(strstr($value,$filename)){
				$ISin=1;
				break;
			}
		}elseif(!$ISin){
			$ISin=ifin_array($array[$key],$filename,$ISin);
		}
	}
	return $ISin;
}


/*Ѷ������*/
function Thunder_Encode($url) 
{
	$thunderPrefix="AA";
	$thunderPosix="ZZ";
	$thunderTitle="thunder://";
	$thunderUrl=$thunderTitle.base64_encode($thunderPrefix.$url.$thunderPosix);
	return $thunderUrl;
}


/*�쳵����*/
function Flashget_Encode($t_url,$uid) 
{
	$prefix= "Flashget://";
	$FlashgetURL=$prefix.base64_encode("[FLASHGET]".$t_url."[FLASHGET]")."&".$uid;
	return $FlashgetURL;
}

//������
function player($url,$width=400,$height=300,$autostart='false',$force=''){
	global $webdb;
	//$urlstring=mymd5($url);
	$urlstring=urlencode($url);
	$string="
<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/do/job.php?job=playurl&urlstring=$urlstring'></SCRIPT>
<SCRIPT LANGUAGE=\"JavaScript\">
qibo_player(playurl,'$width','$height','$force','$autostart');
</SCRIPT>
";
	return $string;
}






function delete_cache_file($fid,$id){
	del_file(ROOT_PATH."cache/jsarticle_cache");
	del_file(ROOT_PATH."cache/label_cache");
	del_file(ROOT_PATH."cache/list_cache");
	del_file(ROOT_PATH."cache/bencandy_cache");
	del_file(ROOT_PATH."cache/showsp_cache");
}

//�˶���֤��
function check_imgnum($yzimg){
	global $db,$pre,$timestamp,$webdb,$usr_sid;
	$time=$timestamp-1800;	//��Сʱǰ����֤��ʧЧ.

	if($webdb[YzImg_letter_differ]){	//������ĸ��Сд
		$SQL=" BINARY ";
	}
	if($db->get_one("SELECT * FROM {$pre}yzimg WHERE $SQL imgnum='$yzimg' AND sid='$usr_sid'")){
		$db->query("DELETE FROM {$pre}yzimg WHERE (imgnum='$yzimg' AND sid='$usr_sid') OR posttime<$time");
		return true;
	}else{
		$db->query("DELETE FROM {$pre}yzimg WHERE sid='$usr_sid' OR posttime<$time");
		return false;
	}
}


//��ģ��,���º������û���
function module_write_config_cache($webdbs)
{
	global $db,$_pre,$atc_webdbs;
	
	//checkboxҪ�ر���
	foreach($atc_webdbs AS $key=>$value){
		if(!$webdbs[$key]){
			$webdbs[$key]='';
		}
	}

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
		$db->query(" DELETE FROM {$_pre}config WHERE c_key IN ($SQL2'') ");
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

//�����ʼ�
function send_mail($email,$title,$content,$ifcheck=1){
	global $webdb;
	if($webdb[MailType]=='smtp'){	
		if(!$webdb[MailServer]||!$webdb[MailPort]||!$webdb[MailId]||!$webdb[MailPw]){
			if($ifcheck){
				showerr("���������ʼ�������");
			}else{
				return false;
			}			
		}
		require_once(ROOT_PATH."inc/class.mail.php");
		$smtp = new smtp($webdb[MailServer],$webdb[MailPort],true,$webdb[MailId],$webdb[MailPw]);
		$smtp->debug = false;
		if($smtp->sendmail($email,$webdb[MailId], $title, $content, "HTML")){
			$succeeNUM++;
		}else{
			$failNUM++;
		}
	}else{
		if(mail($email, $title, $content)){
			$succeeNUM++;
		}else{
			$failNUM++;
		}
	}	
	if($succeeNUM){
		return true;
	}else{
		if($ifcheck){
			showerr('�ʼ�����ʧ��,�����Ա������������');
		}else{
			return false;
		}
	}
}


//����˵�д����
function write_hackmenu_cache(){
	global $db,$pre;
	$show="<?php\r\n";
	$query = $db->query("SELECT * FROM {$pre}hack ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		if(!$rs[class2]||!$rs[class1]){
			$rs[class1]='other';
			$rs[class2]='�����ȫ';
		}
		$rs[adminurl]=addslashes($rs[adminurl]);
		$rs[linkname] && $rs[name]=$rs[linkname];
		$rs[name]=addslashes($rs[name]);
		$s="\r\n\$menu_partDB['{$rs[class1]}'][]='{$rs[class2]}';\r\n\$menudb['{$rs[class2]}']['{$rs[name]}']=array('power'=>'{$rs[keywords]}','link'=>'{$rs[adminurl]}');\r\n";
		if($rs[isbiz]){
			$show.="\r\nif(\$IS_BIZPhp168||\$GLOBALS[IS_BIZPhp168]){".$s."}\r\n";
		}else{
			$show.=$s;
		}
	}
	write_file(ROOT_PATH."data/hack.php",$show.'?>');
}


//��Ա����ģ��
function get_member_tpl($type){
	global $webdb;	
	if(!$webdb[style_member]||!is_file($file=ROOT_PATH."member/template/$webdb[style_member]/$type.htm")){
		$file = ROOT_PATH."member/template/default/$type.htm";
	}
	return $file;
}



//ȫվα��̬
function rewrite_url(&$content){
	$content=preg_replace("/<a([^>]+)href=([\'\"]?)([^\'\"> ]+)([\'\"]?)/eis","rewrite_replace_url('\\3','\\1','\\2','\\4')",$content);
}
function rewrite_replace_url($code3,$code1,$code2,$code4){
	$code3=preg_replace("/(.*)(list|bencandy|listsp|showsp|listall|listhomepage|joinshow)\.php\?(.*)/eis","rewrite_replace_parameter('\\1','\\2','\\3')",$code3);
	return stripslashes("<a{$code1}href={$code2}{$code3}{$code4}");
}
function rewrite_replace_parameter($path,$filename,$parameter){
	if($path&&substr($path,-1)!='/'){
		return "{$path}{$filename}.php?{$parameter}";	//�������־Ͳ��ܴ�����XXlist.php
	}
	$re='-htm-';
	$filetype='.html';
	$parameter=preg_replace("/^([&]+)(.*)/is","\\2",$parameter);
	$parameter=str_replace(array('&&','&','='),array('&','-','-'),$parameter);
	return "$path$filename$re$parameter$filetype";
}

function select_city($name,$fid='',$value=false){
	global $db,$pre;	
	$show.="<select name='$name'><option value=''>��ѡ��</option>";
	if($value){
		$ck=$fid=='$GLOBALS[city_id]'?'selected':'';
		$show.="<option value='\$GLOBALS[city_id]' $ck>��Ӧ����</option>";
	}
	$query = $db->query("SELECT * FROM {$pre}fenlei_city ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ck=$fid==$rs[fid]?'selected':'';
		$show.="<option value='$rs[fid]' $ck>$rs[name]</option>";
	}
	$show.="</select>";
	return $show;
}


//�����߱༭���������ַ��滻ʹ�õ�
function editor_replace($content){
	$content = str_replace(
		array('"',"'",'&lt;','&gt;','<','>','&nbsp;'),
		array("&quot;",'&#39;','&amp;lt;','&amp;gt;','&lt;','&gt;',"&amp;nbsp;"),
		$content);
	return $content;
}

function delete_home($uid){
	global $db,$pre;
	$db->query("DELETE FROM {$pre}hy_company WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_company_fid WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_friendlink WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_guestbook WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_home WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_news WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_pic WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_picsort WHERE uid='$uid'");
	$db->query("DELETE FROM {$pre}hy_picsort WHERE uid='$uid'");
	$db->query("UPDATE {$pre}memberdata SET grouptype=0 WHERE uid='$uid'");
}

//UTF8�ַ�תGBK
function utf82gbk($text){
	if(function_exists('iconv')){
		$text = iconv('UTF-8', 'GBK//IGNORE',$text);
		return $text;
	}
	require_once(ROOT_PATH."inc/class.chinese.php");
	$cnvert = new Chinese("UTF8","GB2312",$text,ROOT_PATH."./inc/gbkcode/");
	$text = $cnvert->ConvertIT();
	unset($cnvert);
	return $text;
}
//�ж��ǲ���UTF8�ַ�
function is_utf8($text) { 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$text) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$text) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$text) == true) 
	{ 
		return true; 
	} 
	else 
	{ 
		return false; 
	}
}


//����Ƿ�Ϊ�ֻ�����
function is_mobile(){    
	$regex_match="/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|";    
	$regex_match.="htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|";    
	$regex_match.="blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|";        
	$regex_match.="symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|";    
	$regex_match.="jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220";    
	$regex_match.=")/i";            
	return isset($_SERVER['HTTP_X_WAP_PROFILE']) or isset($_SERVER['HTTP_PROFILE']) or preg_match($regex_match, strtolower($_SERVER['HTTP_USER_AGENT']));
}



//�����û�ע�ά������
function propagandize_reg($newuid,$propagandize_man=''){
	global $db,$pre,$onlineip,$timestamp,$userDB,$webdb;
	if($propagandize_man){	//�û�ע��ʱ�ֹ���д���Ƽ���
		$rs = $userDB->get_passport($propagandize_man,'name');
		if(!$rs){
			return ;
		}
		$today = date("z",$timestamp);
		$ip=sprintf("%u",ip2long($onlineip));
		$db->query("INSERT INTO `{$pre}propagandize` ( `uid` , `ip` , `day` , `posttime` , `newuid` ,`fromurl`) VALUES ( '$rs[uid]', '$ip', '$today', '$timestamp', '$newuid','ע���Ƽ���')");
		
		//�������ڵ�ͬһIP�ظ�ע���Ƽ����˲��������֣���ֹ����
		$daytime = $today-$webdb['propagandize_LogDay'];
		if(!$db->get_one("SELECT * FROM {$pre}propagandize WHERE day>'$daytime' AND ip='$ip'")){
			propagandize_money_reg($newuid);
		}

	}else{	//�Ƽ�������ַ��¼�µ�UID
		$id = get_cookie('propagandize_id');
		if(!$id){
			return ;
		}
		extract($db->get_one("SELECT uid FROM {$pre}propagandize WHERE id='$id'"));
		if(!$uid){
			return ;
		}
		set_cookie('propagandize_id','');
		$db->query("UPDATE {$pre}propagandize SET newuid='$newuid' WHERE id='$id'");
		propagandize_money_reg($newuid);
	}
}
//�����û�ע�ά������
function propagandize_money_reg($newuid){
	global $db,$pre,$webdb;
	extract($db->get_one("SELECT uid FROM {$pre}propagandize WHERE newuid='$newuid'"));
	if($uid){
		add_user($uid,$webdb[propagandize_Reg_Money],"�ƹ�������û�ע�ά��,��uidΪ:$newuid");
		propagandize_money_reg($uid);
	}
}


?>