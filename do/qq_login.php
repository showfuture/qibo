<?php
require_once(dirname(__FILE__)."/global.php");
require_once(ROOT_PATH."/inc/qq.api.php");

if($lfjuid){
	showerr('请不要重复登录!');
}elseif(!$webdb[QQ_login]){
	showerr('该功能已关闭!');
}

if(!table_field("{$pre}memberdata",'qq_api')){
	$db->query("ALTER TABLE `{$pre}memberdata` ADD `qq_api` VARCHAR( 32 ) NOT NULL AFTER `username`;");
	$db->query("ALTER TABLE `{$pre}memberdata` ADD INDEX ( `qq_api` );");
}

//齐博公共接口
if($webdb[QQ_login]==2){
	if($_GET[qq_api]){
		list($token,$secret,$openid,$time) = explode("\t",qqmd5($_GET[qq_api],"DE",$webdb[QQ_QBappkey]));
		if(!$openid){
			showerr('信息不全,出错了!!');
		}elseif($timestamp-$time>60){
			showerr('超时了!!');
		}
		set_cookie('token_secret',mymd5($token."\t".$secret."\t".$openid));

		if($rs=$db->get_one("SELECT * FROM {$pre}memberdata WHERE `qq_api`='$openid'")){
			$userDB->login($rs[username],'',intval($webdb[QQ_logintime]*3600),true);
			$fromurl=get_cookie('qq_fromurl');
			if($fromurl&&!eregi("login\.php",$fromurl)&&!eregi("reg\.php",$fromurl)){
				$jumpto=$fromurl;
			}else{
				$jumpto="$webdb[www_url]/";
			}
			refreshto("$jumpto","QQ方式登录成功{$uc_login_code}",1);
		}else{
			refreshto("qq_bind.php","QQ登录成功,请进行帐号绑定设置",10);
		}

	}else{
		//登录前
		set_cookie('qq_fromurl',$FROMURL);
		$api_md5=qqmd5("$webdb[www_url]\t$timestamp","EN",$webdb[QQ_QBappkey]);
		header("location:http://www.qibosoft.com/qq_login/api.php?api_md5=$api_md5&api_id=$webdb[QQ_QBappid]");
		exit;
	}
}

//以下是QQ私密接口

if($_GET["openid"]){
	//tips//
	/**
	 * QQ互联登录，授权成功后会回调此地址
	 * 必须要用授权的request token换取access token
	 * 访问QQ互联的任何资源都需要access token
	 * 目前access token是长期有效的，除非用户解除与第三方绑定
	 * 如果第三方发现access token失效，请引导用户重新登录QQ互联，授权，获取access token
	 */
	//print_r($_GET);

	//授权成功后，会返回用户的openid
	//检查返回的openid是否是合法id
	//echo $_GET["oauth_signature"];
	if (!is_valid_openid($_GET["openid"], $_GET["timestamp"], $_GET["oauth_signature"]))
	{
		showerr('API帐号有误!');
		//demo对错误简单处理
		echo "###invalid openid\n";
		echo "sig:".$_GET["oauth_signature"]."\n";
		exit;
	}

	//tips
	//这里已经获取到了openid，可以处理第三方账户与openid的绑定逻辑
	//但是我们建议第三方等到获取accesstoken之后在做绑定逻辑
	
	list($token,$secret)=explode("\t",mymd5(get_cookie('token_secret'),'DE'));
	//用授权的request token换取access token

	$access_str = get_access_token($webdb[QQ_appid], $webdb[QQ_appkey], $_GET["oauth_token"], $secret, $_GET["oauth_vericode"]);
	//echo "access_str:$access_str\n";
	$result = array();
	parse_str($access_str, $result);

	//print_r($result);

	//error
	if (isset($result["error_code"]))
	{
		showerr('出错了,请不要重复刷新网页'.$result["error_code"]);
		//echo "error_code = ".$result["error_code"];
		//exit;
	}

	//获取access token成功后也会返回用户的openid
	//我们强烈建议第三方使用此openid
	//检查返回的openid是否是合法id
	if (!is_valid_openid($result["openid"], $result["timestamp"], $result["oauth_signature"]))
	{
		showerr('出错了,超时了!');
		//demo对错误简单处理
		//echo "@@@invalid openid";
		//echo "sig:".$result["oauth_signature"]."\n";
		//exit;
	}
	//echo 'good!!';
	//将access token，openid保存!!
	//XXX 作为demo,临时存放在session中，网站应该用自己安全的存储系统来存储这些信息
	//$_SESSION["token"]   = $result["oauth_token"];
	//$_SESSION["secret"]  = $result["oauth_token_secret"]; 
	//$_SESSION["openid"]  = $result["openid"];
	set_cookie('token_secret',mymd5($result["oauth_token"]."\t".$result["oauth_token_secret"]."\t".$result["openid"]));

	if($rs=$db->get_one("SELECT * FROM {$pre}memberdata WHERE `qq_api`='$result[openid]'")){
		$userDB->login($rs[username],'',3600,true);
		$fromurl=get_cookie('qq_fromurl');
		if($fromurl&&!eregi("login\.php",$fromurl)&&!eregi("reg\.php",$fromurl)){
			$jumpto=$fromurl;
		}else{
			$jumpto="$webdb[www_url]/";
		}
		refreshto("$jumpto","QQ方式登录成功{$uc_login_code}",1);
	}else{
		refreshto("qq_bind.php","QQ登录成功,请进行帐号绑定设置",10);
	}

	//第三方处理用户绑定逻辑
	//将openid与第三方的帐号做关联
	//bind_to_openid();
}else{
	//登录前
	set_cookie('qq_fromurl',$FROMURL);
	redirect_to_login($webdb[QQ_appid], $webdb[QQ_appkey], "$webdb[www_url]/do/qq_login.php");
}




/**
 * @brief get a access token 
 *        rfc1738 urlencode
 * @param $appid
 * @param $appkey
 * @param $request_token
 * @param $request_token_secret
 * @param $vericode
 *
 * @return a string, as follows:
 *      oauth_token=xxx&oauth_token_secret=xxx&openid=xxx&oauth_signature=xxx&oauth_vericode=xxx&timestamp=xxx
 */
function get_access_token($appid, $appkey, $request_token, $request_token_secret, $vericode)
{
    //获取access token接口，不要随便更改!!
    $url    = "http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token?";
    //构造签名串.源串:方法[GET|POST]&uri&参数按照字母升序排列
    $sigstr = "GET"."&".rawurlencode("http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token")."&";

    //必要参数，不要随便更改!!
    $params = array();
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;
    $params["oauth_token"]            = $request_token;
    $params["oauth_vericode"]         = $vericode;

    //对参数按照字母升序做序列化
    $normalized_str = get_normalized_string($params);
    $sigstr        .= rawurlencode($normalized_str);

    //echo "sigstr = $sigstr";

    //签名,确保php版本支持hash_hmac函数
    $key = $appkey."&".$request_token_secret;
    $signature = get_signature($sigstr, $key);
    //构造请求url
    $url      .= $normalized_str."&"."oauth_signature=".rawurlencode($signature);

    return file_get_contents($url);
}




 /**
 * @brief get a request token by appid and appkey
 *        rfc1738 urlencode
 * @param $appid
 * @param $appkey
 *
 * @return a string, the format as follow: 
 *      oauth_token=xxx&oauth_token_secret=xxx
 */
function get_request_token($appid, $appkey)
{
    //获取request token接口, 不要随便更改!!
    $url    = "http://openapi.qzone.qq.com/oauth/qzoneoauth_request_token?";
    //构造签名串.源串:方法[GET|POST]&uri&参数按照字母升序排列
    $sigstr = "GET"."&".rawurlencode("http://openapi.qzone.qq.com/oauth/qzoneoauth_request_token")."&";

    //必要参数,不要随便更改!!
    $params = array();
    $params["oauth_version"]          = "1.0";
    $params["oauth_signature_method"] = "HMAC-SHA1";
    $params["oauth_timestamp"]        = time();
    $params["oauth_nonce"]            = mt_rand();
    $params["oauth_consumer_key"]     = $appid;

    //对参数按照字母升序做序列化
    $normalized_str = get_normalized_string($params);
    $sigstr        .= rawurlencode($normalized_str);

    //签名,需要确保php版本支持hash_hmac函数
    $key = $appkey."&";
    $signature = get_signature($sigstr, $key);
    //构造请求url
    $url      .= $normalized_str."&"."oauth_signature=".rawurlencode($signature);

    //echo "$sigstr\n";
    //echo "$url\n";

    return file_get_contents($url);
}

//for test
//echo get_request_token($_SESSION["appid"], $_SESSION["appkey"]);


/**
 * @brief redirect to QQ login page
 *        rfc1738 urlencode
 * @param $appid
 * @param $appkey
 * @param $callback
 */
function redirect_to_login($appid, $appkey, $callback)
{
    //授权登录页
    $redirect = "http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize?oauth_consumer_key=$appid&";

    //获取request token
    $result = array();
    $request_token = get_request_token($appid, $appkey);
    parse_str($request_token, $result);

    //request token, request token secret 需要保存起来
    //在demo演示中，直接保存在全局变量中.真实情况需要网站自己处理
    //$_SESSION["token"]        = $result["oauth_token"];
    //$_SESSION["secret"]       = $result["oauth_token_secret"];
	set_cookie('token_secret',mymd5($result["oauth_token"]."\t".$result["oauth_token_secret"]));

    if ($result["oauth_token"] == "")
    {
		showerr('API信息不对!');
        //demo中不对错误情况做处理
        //网站需要自己处理错误情况
       // exit;
    }

    //302跳转到授权页面
    $redirect .= "oauth_token=".$result["oauth_token"]."&oauth_callback=".rawurlencode($callback);
    header("Location:$redirect");
}



?>