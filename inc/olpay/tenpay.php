<?php
if(!function_exists('html') && ($_GET[signMsg]||$_GET[sign])){
	require_once("../common.inc.php");
	$url=str_replace(array('---','--'),array('&','='),substr(strstr($WEBURL,'?'),1));
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>";
	exit;
}
!function_exists('html') && exit('ERR');

if(!$webdb[tenpay_id]){
	showerr('系统没有设置财付通收款帐号,所以不能使用财付通在线支付');
}elseif(!$webdb[tenpay_key]){
	showerr('系统没有设置财付通密钥,所以不能使用财付通在线支付');
}

//☆★☆★☆★☆★☆★☆★财付通测试开关   0 关闭测试    1 开启测试☆★☆★☆★☆★☆★☆★

class tenpay_config
{
	var $beta_switch		="0";



	//☆★☆★☆★☆★☆★☆★财付通支付配置项。☆★☆★☆★☆★☆★☆★

	//以下每一项都必须要配置，并准确
	var $spid 				="1210110601";			//卖家帐号
	var $sp_key				="f1d6a1974041659c8650476dda14bb58";																		//密钥
	var $domain				="http://www.anodize.cn"	;	//商户网站域名
	var $tenpay_dir			="/tenpay2";		//财付通安装目录
	var $site_name			="中国铝氧化网";		//商户网站名称
	var $attach				="tencent_magichu";		//支付附加数据，非中文标准字符
	var $imgtitle			="财付通支付"; 			//图片说明
	var $imgsrc				="/image/tenpay_buy.gif";		//图片地址
	var $pay_url			="https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi"; 	//财付通支付网关地址
	var $return_url			='http://www.anodize.cn';
	function tenpay_config()
	{
		//$this->imgsrc.=$this->tenpay_dir;
		global $webdb;
		$this->spid=$webdb[tenpay_id];
		$this->sp_key=$webdb[tenpay_key];
		$this->domain=$webdb[www];
		$this->site_name=$webdb[webname];
	}
}


$tenpay_conf = new tenpay_config();



class tenpay_online_payment  
{
	var  $tenpay_config;
	function tenpay_online_payment()
	{
		global $tenpay_conf;
		$this->tenpay_config = $tenpay_conf;
	}

	//输出结果函数
	function ShowExitMsg($msg)
	  {
		if ($tenpay_conf->beta_switch =="0")
			{
				$strMsg="<body><html><meta name=\"TENCENT_ONELINE_PAYMENT\" content=\"China TENCENT\">\n";
			    $strMsg.= "<script language=javascript>\n";
			    $strMsg.= "window.location.href='".$domain . $tenpay_dir ."/tenpay_show.php";
			    $strMsg.= $msg;
			    $strMsg.= "';\n";
			    $strMsg.= "</script></body></html>";
			    Exit($strMsg);
			}
		else
			{
				echo  "do something";
			}
	  }
	  
	  
	  
	function tenpay_check_config ()//检查配置文件项目
	{
			$retcode = "0";
		
		 if (empty($this->tenpay_config->spid))
			 {
			 	$retcode = "09001";
				$retmsg  = "缺少商户号spid";
				
			 }
			 
			 if (empty($this->tenpay_config->sp_key))
			 {
			 	$retcode = "090002";
				$retmsg  = "缺少密钥sp_key";
				
			 }
			 
			 if (empty($this->tenpay_config->domain))
			 {
			 	$retcode = "09003";
				$retmsg  = "缺少网站地址domain";
				
			 }
			 
			 if (empty($this->tenpay_config->tenpay_dir))
			 {
				$retcode = "09004";
				$retmsg  = "缺少财付通安装目录tenpay_dir";
			 }
			 
			 
			 
			 
			 if (empty($this->tenpay_config->site_name))
			 {
			 	$retcode = "09005";
				$retmsg = "缺少网站名称";
			 }
			 
			 if (empty($this->tenpay_config->attach))
			 {
				$retcode = "09006";
				$retmsg = "缺少附加信息，默认设置为空";
				$this->tenpay_config->attach = "";
			 }
			 
			  if (empty($this->tenpay_config->imgtitle))
			 {
				$retcode = "09007";
				$retmsg = "缺少图片说明，默认设置为财付通支付";
				$this->tenpay_config->imgtitle = "财付通支付";
			 }
			 
			 if (empty($this->tenpay_config->imgsrc))
			 {
				$retcode = "09008";
				$retmsg = "缺少图片地址，默认设置为/tenpay/image/tenpay_buy.gif";
				$this->tenpay_config->imgsrc = "/image/tenpay_buy.gif";
			 }
			 
			 if (empty($this->tenpay_config->pay_url))
			 {
				$retcode = "09009";
				$retmsg = "缺少支付网关地址，将被设置为https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi";
				$this->tenpay_config->pay_url = "https://www.tenpay.com/cgi-bin/v1.0/pay_gate.cgi";
			 }
				
			return $retcode;

	}

	

	
	
	
	//产生支付链接
	function tenpay_interface_pay ($bank_type,$desc,$purchaser_id,$sp_billno,$total_fee,$attach,$ip)
	{
		
		$ip =  $ip ? $ip : $_SERVER['REMOTE_ADDR'];
		$config_retcode = $this->tenpay_check_config ();
		if ($config_retcode!="0")
			die("请检查配置文件tenpay_config.php中的各配置项是否正确配置");
			
		if (empty($sp_billno))
			 {
			 	$retcode = "09001";
				$retmsg  = "缺少sp_billno";
				
			 }
			 
			 if (empty($total_fee))
			 {
			 	$retcode = "090012";
				$retmsg  = "缺少total_fee";
				
			 }
			 
			 if ($bank_type=="")
			 {
			 	$retcode = "06001";
				$retmsg  = "缺少bank_type，将被默认设置为0";
				$bank_type = "0";
			 }
			 
			 if ($desc=="")
			 {

				$retcode = "06002";
				$retmsg  = "缺少商品名称desc，将被默认设置为".$this->tenpay_config->site_name."订单：" . $sp_billno;;
				$desc = $this->tenpay_config->site_name."订单：" . $sp_billno;
				}
			 
			 
			 
			 
			 if (empty($purchaser_id))
			 {
			 	$retcode = "06003";
				$retmsg = "缺少买家帐号信息，将被默认设置为空";
				$purchaser_id = "";
			 }
			 
			 if (empty($attach))
			 {
				$retcode = "06004";
				$retmsg = "缺少附加信息，默认设置为空";
				$attach = "";
			 }
				
		
		 		  
		if ($retcode < "09000")//判断是否为严重错误，>09000为严重错误
		{
			if ($beta_switch == "1") //判断测试开关，如果开启测试，支付金额为1分 
			{
				$total_fee = "0";
					
				
				$sign_text ="cmdno=1" . "&date=" . date('Ymd') . "&bargainor_id=" . $this->tenpay_config->spid ."&transaction_id=" . $this->tenpay_config->spid . date('Ymd').time()."&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee . "&fee_type=1"  . "&return_url=" . $this->tenpay_config->return_url . "&attach=" . $attach ;
				
				if($ip != "")
				{
					$sign_text = $sign_text . "&spbill_create_ip=" . $ip;
				}
				$strSign = strtoupper(md5($sign_text."&key=".$this->tenpay_config->sp_key));
				$redurl = $this->tenpay_config->pay_url . "?".$sign_text . "&sign=" . $strSign."&desc=".$desc."&bank_type=".$bank_type;
				
				echo $retcode . "<br></br>".$retmsg."<br></br>";
				echo $redurl;
				
				
				return $redurl;
			}
			else
			{
				$sign_text ="cmdno=1" . "&date=" . date('Ymd') . "&bargainor_id=" . $this->tenpay_config->spid ."&transaction_id=" . $this->tenpay_config->spid . date('Ymd').time()."&sp_billno=" . $sp_billno . "&total_fee=" . $total_fee . "&fee_type=1"  . "&return_url=" . $this->tenpay_config->return_url . "&attach=" . $attach ;

				if($ip != "")
				{
					$sign_text = $sign_text . "&spbill_create_ip=" . $ip;
				}
				$strSign = strtoupper(md5($sign_text."&key=".$this->tenpay_config->sp_key));
				$redurl = $this->tenpay_config->pay_url . "?".$sign_text . "&sign=" . $strSign."&desc=".$desc."&bank_type=".$bank_type;
				return $redurl;
			}
		}
		 
		
		
	}
	
}



if($_GET[signMsg]||$_GET[sign]){
	$tenpay = new tenpay_online_payment;

	import_request_variables("gpc", "frm_");

	  /*取返回参数*/
	  $strCmdno			= $frm_cmdno;
	  $strPayResult		= $frm_pay_result;
	  $strPayInfo		= $frm_pay_info;
	  $strBillDate		= $frm_date;
	  $strBargainorId	= $frm_bargainor_id;
	  $strTransactionId	= $frm_transaction_id;
	  $strSpBillno		= $frm_sp_billno;
	  $strTotalFee		= $frm_total_fee;
	  $strFeeType		= $frm_fee_type;
	  $strAttach			= $frm_attach;
	  $strMd5Sign		= $frm_sign;

	$retcode = "0";
	$retmsg ="支付成功";


	//错误码信息
	//retcode = "0"					 支付成功	
	//retmsg = "支付成功"				

	//retcode = "1"					 商户号错误
	//retmsg = " 商户号错误"				

	//retcode = "2"					签名错误
	//retmsg = "签名错误"				

	//retcode = "3"					 财付通返回支付失败	
	//retmsg = "财付通返回支付失败"	  



	  /*验签*/
	$strResponseText  = "cmdno=" . $strCmdno . "&pay_result=" . $strPayResult . 
							  "&date=" . $strBillDate . "&transaction_id=" . $strTransactionId .
								"&sp_billno=" . $strSpBillno . "&total_fee=" . $strTotalFee .
								"&fee_type=" . $strFeeType . "&attach=" . $strAttach .
								"&key=" . $tenpay_conf->sp_key;
	$strLocalSign = strtoupper(md5($strResponseText));     
	  
	if( $strLocalSign  != $strMd5Sign)
	{
		//验证MD5签名失败
		//植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理
		$retcode = "2";
		$retmsg = "验证MD5签名失败";
		die( "验证MD5签名失败 "); 
	}  

	if($tenpay_conf->spid != $strBargainorId )
	 {
		//错误的商户号
		//植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理

		echo $strBargainorId,"<br/>";
		echo $tenpay_conf->spid;
		$retcode = "1";
		$retmsg = "错误的商户号";
		die( "错误的商户号 "); 
	}

	if( $strPayResult != "0" )
	{
		//支付失败，系统错误
		//植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理

		$retcode = "3";
		$retmsg = "支付失败，系统错误";
		die( "支付失败，系统错误 "); 
	}
	  
	if ($retcode == "0")
	{
		//支付成功
		//植入业务逻辑处理，请注意金额单位是分，财付通有可能多次通知商户支付成功，需要对财付通的重复通知做去重处理
		olpay_end($strSpBillno);
		die( "支付成功. "); 
	}

	
	
}
else
{
	$array=olpay_send();

	//URL不支持=与&字符,所以要特别处理,比较麻烦
	$tenpay_conf->return_url="$webdb[www]/inc/olpay/tenpay.php?".str_replace(array("=","&"),array("--","---"),$array[return_url]);

	$tenpay = new tenpay_online_payment;

	$url=$tenpay->tenpay_interface_pay ("0",$array[title],"",$array[numcode],$array[money]*100,"",'');

	header("location:$url");
	exit;
}

?>