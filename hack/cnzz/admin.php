<?php
!function_exists('html') && exit('ERR');
if($job=='set')
{
	if($webdb[cnzz_pwd]=='no'){
		$display='';
		$webdb[cnzz_pwd]='';
	}else{
		$display='none;';
	}
	$cnzz_open[intval($webdb[cnzz_open])]=' checked ';

	hack_admin_tpl('set');
}
elseif($action=='set')
{
	if($webdbs[cnzz_open]&&!$webdbs[cnzz_id]){
		showmsg("统计帐号不存在");
	}
	write_config_cache($webdbs);
	jump("修改成功",$FROMURL,1);
}
elseif($job=='ask')
{
	if($webdb[cnzz_id]&&$webdb[cnzz_pwd]){
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=index.php?lfj=cnzz&job=set'>";
		exit;
	}
	$mydomain=preg_replace("/http:\/\/([^\/]+)\/(.*)/is","\\1",$WEBURL);

	hack_admin_tpl('ask');
}
elseif($action=='ask')
{
	if(!$mydomain)
	{
		showmsg("域名不能为空");
	}
	$key = md5("{$mydomain}A4bkJUxm");
	$url="http://intf.cnzz.com/user/companion/php168.php?domain=$mydomain&key=$key";
	if( ini_get('allow_url_fopen') && $code=file_get_contents($url) )
	{
	}
	elseif( $code=sockOpenUrl($url) )
	{
	}
	
	if(!strstr($code,'@'))
	{
		echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312">';
		if($code=='-1'){
			die("KEY值有误");
		}elseif($code=='-2'){
			die("域名长度有误（1~64）");
		}elseif($code=='-3'){
			die("域名输入有误");
		}elseif($code=='-4'){
			die("域名插入数据库有误");
		}elseif($code=='-5'){
			echo("同一个IP,用户申请次数过多<hr>");
		}else{
			echo $code;
		}
		$webdbs[cnzz_pwd]='no';
		write_config_cache($webdbs);
		echo "<A HREF='$url'>你的服务器不支持远程获取数据,请点击手工获取数据,然后把页面显示的结果复制出来,在<统计帐号管理>那手工输入,@前面的数字是统计代码的帐号,@后面部份的数字是统计代码的管理密码,点击获取资料</A>";
		exit;
	}
	list($webdbs[cnzz_id],$webdbs[cnzz_pwd])=explode("@",$code);

	write_config_cache($webdbs);
	jump("恭喜你,统计帐号申请成功","index.php?lfj=cnzz&job=set",2);
}

?>