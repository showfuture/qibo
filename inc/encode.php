<?php
!function_exists('html') && exit('ERR');

$db_code['pic']='1';		// 写1显示图片,写0不显示
$db_code['flash']='1';		// 写1显示flash,写0不显示
$db_code['mpeg']='1';		// 写1显示音乐影片,写0不显示
$db_code['iframe']='1';		// 写1显示框架,写0不显示

function format_text($message){
	return convert($message);
}
function convert($message,$allow='',$type="post") 
{
	global $code_num,$code_htm,$updir,$powerck,$N_path,$badword,$usr_style,$webdb;
	$code_num=0;
	$code_htm=array();
	if(strpos($message,"[code]") !== false && strpos($message,"[/code]") !== false){
		$message=preg_replace("/\[code\](.+?)\[\/code\]/eis","phpcode('\\1')",$message);
	}else{//1
		$message=str_replace("\r","",$message);
		$message=str_replace(">\n",">",$message);
		$message=preg_replace("/(>)([^<]*)(<td)/","\\1\\3",$message);
		$message=preg_replace("/(\/td>)([^<]*)(<\/tr)/","\\1\\3",$message);
		$message=preg_replace("/(>)([^<]*)(<tr)/","\\1\\3",$message);
		$message=str_replace("\n","<br>",$message);
		$message =str_replace("[u]","<u>",$message);
		$message =str_replace("[/u]","</u>",$message);
		$message =str_replace("[b]","<b>",$message);
		$message =str_replace("[/b]","</b>",$message);
		$message =str_replace("[i]","<i>",$message);
		$message =str_replace("[/i]","</i>",$message);
		$message =str_replace("[list]","<ul>",$message);
		$message =str_replace('[list=1]', '<ol type=1>', $message);
		$message =str_replace('[list=a]', '<ol type=a>', $message);
		$message =str_replace('[list=A]', '<ol type=A>', $message);
		$message =str_replace('[*]', '<li>', $message);
		$message =str_replace("[/list]","</ul>",$message);
		//$message =str_replace("><IMG","><IMG onload='if(this.width>screen.width-460)this.width=screen.width-460'  onmousewheel='return bbimg(this)' ",$message);
		$message = autoimg($message);

		//主要是为了兼容旧版本的
		//$message = str_replace("[www_mmcbbs_com]",$webdb[www_url]."/".$webdb[updir]."/",$message);
		//$message= preg_replace("/\[UploadFile=\s*(\S+?)\s*\]/is","<IMG onload='if(this.width>screen.width-460)this.width=screen.width-460'  src=./oldpic\/\\1  ><br>",$message);
		/*
		if($webdb['filtrate_content']){
			$detail=explode("\r\n",$webdb['filtrate_content']);
			for($i=0;$i<count($detail);$i++){
				$detail2=explode("|",$detail[$i]);
				$message =str_replace($detail2[0],"<font color=#FF00FF>$detail2[1]</font>",$message);
			}
		}
		*/
		$searcharray = array(
			"/\[font=([^\[]*)\](.+?)\[\/font\]/is",
			"/\[color=([#0-9a-z]{1,10})\](.+?)\[\/color\]/is",
			"/\[email=([^\[]*)\](.+?)\[\/email\]/is",
			"/\[email\]([^\[]*)\[\/email\]/is",
			"/\[size=([^\[]*)\](.+?)\[\/size\]/is",
			"/(\[fly\])(.+?)(\[\/fly\])/is",
			"/(\[move\])(.+?)(\[\/move\])/is",
			"/(\[align=)(left|center|right)(\])(.+?)(\[\/align\])/is",
			"/(\[glow=)(\S+?)(\,)(.+?)(\,)(.+?)(\])(.+?)(\[\/glow\])/is"
			//"/\[url=([^\[]*)\](.+?)\[\/url\]/is",
			//"/\[url\]([^\[]*)\[\/url\]/is"
		);
		$replacearray = array(
			"<font face='\\1'>\\2</font>",
			"<font color='\\1'>\\2</font>",
			"<a href='mailto:\\1'>\\2</a>",
			"<a href='mailto:\\1'>\\1</a>",
			"<font size='\\1'>\\2</font>",
			"<marquee width=90% behavior=alternate scrollamount=3>\\2</marquee>",
			"<marquee scrollamount=3>\\2</marquee>",
			"<DIV Align=\\2>\\4</DIV>",
			"<span style='WIDTH:\\2;filter:glow(color=\\4, strength=\\6)'>\\8</span>"
			//"<a target=_blank href='\\1'>\\2</a>",
			//"<a target=_blank href='\\1'>\\1</a>"
		);
		$message=preg_replace($searcharray,$replacearray,$message);


		//if ($allow['pic']){
			$message = preg_replace("/\[img\](.+?)\[\/img\]/eis","cvpic('\\1')",$message);
		//} else{
		//	$message = preg_replace("/\[img\](.+?)\[\/img\]/eis","nopic('\\1')",$message);
		//}

		if(strpos($message,'[/URL]')!==false || strpos($message,'[/url]')!==false){
			$searcharray = array(
				"/\[url=(https?|ftp|gopher|news|telnet|mms|rtsp)([^\[]*)\](.+?)\[\/url\]/eis",			
				"/\[url\]www\.([^\[]*)\[\/url\]/eis",
				//"/\[url\][^www\.]([^\[]*)\[\/url\]/eis",
				"/\[url\](https?|ftp|gopher|news|telnet|mms|rtsp)([^\[]*)\[\/url\]/eis"
			);
			$replacearray = array(
				"cvurl('\\1','\\2','\\3')",
				"cvurl('\\1')",
				//"cvurl('\\1')",
				"cvurl('\\1','\\2')",
			); 
			$message=preg_replace($searcharray,$replacearray,$message);
		}

		//if ($allow['flash']){
			$message = preg_replace("/(\[flash=)(\S+?)(\,)(\S+?)(\])(\S+?)(\[\/flash\])/is","<OBJECT CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" WIDTH=\\2 HEIGHT=\\4><PARAM NAME=MOVIE VALUE=\\6><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=\\6 WIDTH=\\2 HEIGHT=\\4 PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT><br />[<a target=_blank href=\\6>Full Screen</a>] ",$message);
			//$message = preg_replace("/(\[swf\])(\S+?)(\[\/swf\])/is","<OBJECT CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" WIDTH=600 HEIGHT=400><PARAM NAME=MOVIE VALUE=\\1><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=\\1 WIDTH=600 HEIGHT=400 PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT><br />[<a target=_blank href=\\1>Full Screen</a>] ",$message);
			$message= preg_replace("/\[swf\]\s*(\S+?)\s*\[\/swf\]/is","<OBJECT CLASSID=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" WIDTH=600 HEIGHT=400><PARAM NAME=MOVIE VALUE=\\1><PARAM NAME=PLAY VALUE=TRUE><PARAM NAME=LOOP VALUE=TRUE><PARAM NAME=QUALITY VALUE=HIGH><EMBED SRC=\\1 WIDTH=600 HEIGHT=400 PLAY=TRUE LOOP=TRUE QUALITY=HIGH></EMBED></OBJECT><br />[<a target=_blank href=\\1>Full Screen</a>] <br>",$message);

		//}else{
		//	$message = preg_replace("/(\[flash=)(\S+?)(\,)(\S+?)(\])(\S+?)(\[\/flash\])/is","<img src='./images/default/swf.gif' align='absbottom'> <a target=_blank href=\\6>flash: \\6</a>",$message);
		//}

		if($type=="post"){
			if($allow['mpeg']){
				$message = preg_replace("/\[wmv\]\s*(\S+?)\s*\[\/wmv\]/is","<CENTER><object classid='clsid:22D6F312-B0F6-11D0-94AB-0080C74C7E95' type='application/x-oleobject' width=350  height=280 align='middle' standby='Loading Microsoft?Windows?Media Player components...' id='MediaPlayer1'>
				<param name='transparentAtStart' value='True'>
				<param name='transparentAtStop' value='True'>
				<param name='AnimationAtStart' value='Ture'>
				<param name='AutoStart' value='True'>
				<param name='AutoRewind' value='true'>
				<param name='DisplaySize' value='0'>
				 <param name='AutoSize' value='false'>
				<param name='ShowDisplay' value='false'>
				<param name='ShowStatusBar' value='1'>
				<param name='ShowControls' value='ture'>
				<param name='FileName' value='\\1'>
				<param name='Volume' value='0'>
				<embed src='' width='350' height=280 autostart='True' align='middle' transparentatstart='True' transparentatstop='True' animationatstart='Ture' autorewind='true' displaysize='0' autosize='false' showdisplay='False' showstatusbar='-1' showcontrols='ture' filename='\\1' volume='0'>
				</embed> 
				</object></CENTER>",$message);
				$message = preg_replace("/\[rm\]\s*(\S+?)\s*\[\/rm\]/is","<object classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA height=241 id=Player width=316 VIEWASTEXT><param name=\"_ExtentX\" value=\"12726\"><param name=\"_ExtentY\" value=\"8520\"><param name=\"AUTOSTART\" value=\"0\"><param name=\"SHUFFLE\" value=\"0\"><param name=\"PREFETCH\" value=\"0\"><param name=\"NOLABELS\" value=\"0\"><param name=\"CONTROLS\" value=\"ImageWindow\"><param name=\"CONSOLE\" value=\"_master\"><param name=\"LOOP\" value=\"0\"><param name=\"NUMLOOP\" value=\"0\"><param name=\"CENTER\" value=\"0\"><param name=\"MAINTAINASPECT\" value=\"\\1\"><param name=\"BACKGROUNDCOLOR\" value=\"#000000\"></object><br><object classid=clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA height=32 id=Player width=316 VIEWASTEXT><param name=\"_ExtentX\" value=\"18256\"><param name=\"_ExtentY\" value=\"794\"><param name=\"AUTOSTART\" value=\"1\"><param name=\"SHUFFLE\" value=\"0\"><param name=\"PREFETCH\" value=\"0\"><param name=\"NOLABELS\" value=\"0\"><param name=\"CONTROLS\" value=\"controlpanel\"><param name=\"CONSOLE\" value=\"_master\"><param name=\"LOOP\" value=\"0\"><param name=\"NUMLOOP\" value=\"0\"><param name=\"CENTER\" value=\"0\"><param name=\"MAINTAINASPECT\" value=\"0\"><param name=\"BACKGROUNDCOLOR\" value=\"#000000\"><param name=\"SRC\" value=\"\\1\"></object>",$message);
			}else{
				$message = preg_replace("/(\[wmv\])(\S+?)(\[\/wmv\])/is","<img src='./images/default/music.gif' align='absbottom'> <a target=_blank href='\\2'>\\2</a>",$message);
				$message = preg_replace("/(\[rm\])(\S+?)(\[\/rm\])/is","<img src='./images/default/music.gif' align='absbottom'> <a target=_blank href='\\2'>\\2</a>",$message);
			}
			if ($allow['iframe']) {
				$message = preg_replace("/\[iframe\]\s*(\S+?)\s*\[\/iframe\]/is","<IFRAME SRC=\\1 FRAMEBORDER=0 ALLOWTRANSPARENCY=true SCROLLING=YES WIDTH=97% HEIGHT=340></IFRAME>",$message);
			}else{
				$message = preg_replace("/(\[iframe\])(\S+?)(\[\/iframe\])/is","Iframe Close: <a target=_blank href='\\2'>\\2</a>",$message);
			}
			//此处位置不可调换
			if (strpos($message,"[quote]") !== false && strpos($message,"[/quote]") !== false){
				$message=preg_replace("/\[quote\](.+?)\[\/quote\]/eis","qoute('\\1')",$message);
			}
		}
	}//1
	if(is_array($code_htm)){
		krsort($code_htm);
		foreach($code_htm as $key1=>$codehtm){
			foreach($codehtm as $key=>$value){
				$message=str_replace("[\tbbs_code_$key\t]",$value,$message);
				
			}
		}
	}
    return $message;
}
function qoute($code){
	global $code_num,$code_htm;
	$code_num++;
	$code_htm[6][$code_num]="<table cellpadding=0 cellspacing=0 border=0 WIDTH=95% bgcolor=#E3E3E3 align=center><tr><td><table width=100% cellpadding=5 cellspacing=1 border=0 style='TABLE-LAYOUT: fixed;WORD-WRAP: break-word'><TR><TD class='r_one'>$code</td></tr></table></td></tr></table>";
	return "[\tbbs_code_$code_num\t]";
}
function cvurl($http,$url='',$name=''){
	global $code_num,$code_htm;
	$code_num++;
	if(!$url){
		$url="<a href='http://www.$http' target=_blank>www.$http</a>";
	} elseif(!$name){
		$url="<a href='$http$url' target=_blank>$http$url</a>";
	} else{
		$url="<a href='$http$url' target=_blank>$name</a>";
	}
	$code_htm[0][$code_num]=$url;
	return "[\tbbs_code_$code_num\t]";
}
function nopic($url){
	global $code_num,$code_htm,$N_path;
	$code_num++;
	$code_htm[-1][$code_num]="<img src='./images/default/img.gif' align='absbottom' border=0> <a target=_blank href='$url'>img: $url</a>";
	return "[\tbbs_code_$code_num\t]";
}
function cvpic($url,$type='')
{
	global $code_num,$code_htm;
	$code_num++;
	//if(strtolower(substr($url,0,4))!='http' && !$type)$url='http'.$url;
	$code="<img src='$url' border=0 onclick=\"window.open(this.src);\" onload='if(this.width>screen.width-460)this.width=screen.width-460'  onmousewheel='return bbimg(this)'>";
	$code_htm[-1][$code_num]=$code;
	if($type){
		return $code;
	} else{
		return "[\tbbs_code_$code_num\t]";
	}
}
function phpcode($code){
	global $code_num,$code_htm;
	$code=str_replace("<br>","\n",$code);
	$code=str_replace("<br />","\n",$code);
	$code_num++;
	$code_htm[1][$code_num]="<br><br><font color=red>Code:</font><br><TEXTAREA name=textfield rows=10 style='WIDTH:100%;'>$code</textarea><br><font color=red>[Ctrl+A Select All]</font><br><br>";
	return "[\tbbs_code_$code_num\t]";
}
//
function autoimg($message){
	if($message){
	$message= preg_replace(array(
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+\.gif)/i",
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+\.jpg)/i"
				), array(
					"[img]\\1\\3[/img]",
					"[img]\\1\\3[/img]"
				), ' '.$message);
	}
	$message= preg_replace(	array(
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp|gopher|news|telnet|mms|rtsp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",
					"/(?<=[^\]a-z0-9\/\-_.~?=:.])([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
				), array(
					"[url]\\1\\3[/url]",
					"[email]\\0[/email]"
				), ' '.$message);

	return $message;
}

function format_download($content,$download){
	$detail=explode("\r\n",$download);
	foreach( $detail AS $key=>$value){
		if(!$value){
			continue;
		}
		list($did,$fid,$aid,$rid,$fileurl,$filename,$filesize,$loadnums,$posttime)=explode("|",$value);
		$d=format_attachment($fileurl,$did,$filename,$filesize,$loadnums,$posttime);
		$content=str_replace("[MMCBBS]$fileurl",$d,$content);
	}
	return $content;
}

function encode_fileurl($img,$url,$name){
	global $id,$webdb;
	$url=base64_encode($url);
	if($img){
		return "<IMG src=\"$img\" border=0><A href=\"$webdb[www_url]/do/job.php?job=download&id=$id&url=$url\" target='_blank' $code>$name</A>";
	}else{
		return "<a href=\"$webdb[www_url]/do/job.php?job=download&id=$id&url=$url\" target='_blank' style='color:red;'><IMG src=\"$webdb[www_url]/images/default/downpic.gif\" border=0> $name</A>";
	}
	
}

function format_attachment($url,$d_id='',$name='',$size='',$hits='',$time=''){
	global $fid,$id,$webdb;
	$url=tempdir($url);
	$size=ceil($size/1024);
	if( eregi("jpg$",$url)||eregi("gif$",$url)||eregi("bmp$",$url)||eregi("png$",$url) )
	{
		$show="<CENTER><img src=\"$url\" onload=\"makesmallpic(this,500,600);\" width=\"500\" height=\"600\" border=\"0\" onerror=\"this.src='$webdb[www_url]/images/default/nopic.jpg'\" ></CENTER>";
	}
	
	elseif (eregi('\.mid$',$url) || eregi('\.mp3$',$url) || eregi('\.avi$',$url) || eregi('\.asf$',$url) ||eregi('\.asx$',$url) || eregi('\.wmv$',$url) || eregi('\.wma$',$url)|| eregi('\.mpg$',$url)|| eregi('\.mpeg$',$url))
		
	{
         $show=player($url,$width=400,$height=300,$autostart='false');
	}
	
	elseif((eregi('\.ra$',$url) || eregi('\.rm$',$url) || eregi('\.ram$',$url) ))
		
	{
         $show=player($url,$width=400,$height=300,$autostart='false');

	}
	
	elseif(eregi('\.swf$',$url)) 
		
	{
          $show=player($url,$width=400,$height=300,$autostart='false');
	}
	
	else
		
	{
		$size=number_format($size/1024,3);
		$time=date("Y-m-d H:i",$time);
		$show="		<br>
				   <table width=450 cellspacing=1 cellpadding=3 bgcolor=#2286D0 style='background: #afd0fc; border: 1px solid #3475b3 ;'>
				   <tr bgcolor=#2E7CCB> 
				   <td colspan=2><b><a href='$webdb[www_url]/do/job.php?job=download&id=$d_id' target=_blank><font color=#FFFFFF>附件名称:$name</font></a></b></td>
				   </tr>
				   <tr bgcolor=#FBFDFF> 
				   <td width=50%><font color=#FF0000>附件名称:</font><a href='$webdb[www_url]/do/job.php?job=download&id=$d_id' target=_blank>$name</a></td>
				   <td width=50%><font color=#FF0000>上传时间:</font>$time</td>
				   </tr>
				   <tr bgcolor=#FBFDFF> 
				   <td ><font color=#FF0000>附件大小:</font>$size M</td>
				   <td ><font color=#FF0000>下载次数:</font>$hits</td>
				   </tr>
				   </table>";
	}
	return $show;
}

function autourl($message){
	global $db_autoimg;
	if($db_autoimg==1){
		$message= preg_replace(array(
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+\.gif)/i",
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+\.jpg)/i"
				), array(
					"[img]\\1\\3[/img]",
					"[img]\\1\\3[/img]"
				), ' '.$message);
	}
	$message= preg_replace(	array(
					"/(?<=[^\]a-z0-9-=\"'\\/])((https?|ftp|gopher|news|telnet|mms|rtsp):\/\/|www\.)([a-z0-9\/\-_+=.~!%@?#%&;:$\\│]+)/i",
					"/(?<=[^\]a-z0-9\/\-_.~?=:.])([_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4}))/i"
				), array(
					"[url]\\1\\3[/url]",
					"[email]\\0[/email]"
				), ' '.$message);

	return $message;
}


?>