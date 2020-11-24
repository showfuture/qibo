<?php

function make_ad_cache(){
	global $db,$pre,$timestamp,$webdb;
	$show.="<?php\r\n\$AD_label=\$_AD_label='';\r\n";
	$query = $db->query("SELECT * FROM `{$pre}ad_norm_place` WHERE isclose=0");
	while($rs = $db->fetch_array($query)){

		if(($rs[begintime]&&$rs[begintime]>$timestamp)||($rs[endtime]&&$timestamp>$rs[endtime])){		
			$code=$_code='';
		}else{
			list($_code,$code)=format_ad_code($rs,'',unserialize($rs[adcode]));
			//必须使用'号,当作是字符串,不能使用"号,防止用户放$变量
			$show.="\$AD_label['$rs[keywords]']=stripslashes('".addslashes($code)."');\r\n";
			$show.="\$_AD_label['$rs[keywords]']=stripslashes('".addslashes($_code)."');\r\n";
		}

		if($rs[ifsale]){
			$query2 = $db->query("SELECT * FROM {$pre}ad_norm_user WHERE u_endtime>'$timestamp' AND id='$rs[id]'");
			while($_r = $db->fetch_array($query2)){
				list($_code,$code)=format_ad_code($rs,$_r,unserialize($_r[u_code]));
				if($_r[city_id]){
					$show.="\$_AD_label['$_r[city_id]']['$rs[keywords]']=stripslashes('".addslashes($_code)."');\r\n";
				}else{
					$show.="\$_AD_label['$rs[keywords]']=stripslashes('".addslashes($_code)."');\r\n";
				}
			}
		}
	}
	write_file(ROOT_PATH."data/ad_cache.php",$show);
}


function format_ad_code($rs,$_r,$code_array){
	global $webdb,$timestamp;
	@extract($code_array);
		if($rs[type]=='word'){
			$url="$webdb[www_url]/a_d/a_d_s.php?job=jump&id=$rs[id]&u_id=$_r[u_id]&url=".base64_encode($linkurl);
			$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			$_code="<a href='$url' target='$wordtarget'>$word</a>";
		}elseif($rs[type]=='pic'){
			$url="$webdb[www_url]/a_d/a_d_s.php?job=jump&id=$rs[id]&u_id=$_r[u_id]&url=".base64_encode($linkurl);
			$picurl=tempdir($picurl);
			$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			$_code="<a href='$url' target='$pictarget'><img width='$width' height='$height' src='$picurl' border=0></a>";
		}elseif($rs[type]=='updown'){
			$second_time>0 || $second_time=5;
			$hour_time!='' || $hour_time=24;
			$url="$webdb[www_url]/a_d/a_d_s.php?job=jump&id=$rs[id]&u_id=$_r[u_id]&url=".base64_encode($linkurl);
			$picurl=tempdir($picurl);
			$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			$_code='<SCRIPT LANGUAGE="JavaScript">
function get_roll_cookie(name)
{
	var arr = document.cookie.split("; ");
	for(var i = 0;i < arr.length;i++){
		var temp = arr[i].split("=");
		if(temp[0] == name) return unescape(temp[1]);
	}
}

function set_roll_cookie(name,value,expire_hours)
{
	var exp_date = new Date();
	exp_date.setHours(exp_date.getHours() + 0 + expire_hours);
	document.cookie = name + "=" +escape(value) + ((expire_hours == null) ? "" : ";expires=" + exp_date.toGMTString()); 
}


var intervalId = null; 

function slideAd(id,nStayTime,sState,nMaxHth,nMinHth)
{ 
				this.stayTime=nStayTime*1000 || 3000; 
				this.maxHeigth=nMaxHth || 100; 
				this.minHeigth=nMinHth || 1; 
				this.state=sState || "down" ; 
				var obj = document.getElementById(id); 
				if(intervalId != null)window.clearInterval(intervalId); 
				function openBox()
				{ 
					var h = obj.offsetHeight;
					obj.style.height = ((this.state == "down") ? (h + 2) : (h - 2))+"px"; 
					if(obj.offsetHeight>this.maxHeigth)
					{ 
						   window.clearInterval(intervalId); 
						   intervalId=window.setInterval(closeBox,this.stayTime); 
					} 
					if (obj.offsetHeight<this.minHeigth)
					{ 
						   window.clearInterval(intervalId); 
						   obj.style.display="none"; 
					} 
				} 
				function closeBox()
				{ 
				    slideAd(id,this.stayTime,"up",nMaxHth,nMinHth); 
				} 
				intervalId = window.setInterval(openBox,30); 
}

</SCRIPT>'."<SCRIPT type=text/javascript>
document.write(\"<DIV style='HEIGHT: 0px; OVERFLOW: hidden' id='scroll_ad'><a href='$url' target='$pictarget'><img width='$width' height='$height' src='$picurl' border=0></a></DIV>\");
var ad = get_roll_cookie('scroll_ad');
if (ad != $timestamp){
	slideAd('scroll_ad',$second_time, 'down',$height, 0); 
	set_roll_cookie('scroll_ad', $timestamp, $hour_time);
}			
</SCRIPT>";
		}elseif($rs[type]=='swf'){
			$flashurl=tempdir($flashurl);
			$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			$_code="<object type='application/x-shockwave-flash' data='$flashurl' width='$width' height='$height' wmode='transparent'><param name='movie' value='$flashurl' /><param name='wmode' value='transparent' /></object>";
		}elseif($rs[type]=='duilian'){
			$lcode=$rcode='';
			if($l_src){
				$l_src=tempdir($l_src);
				if(eregi("swf$",$l_src)){
					$L_Types="flash";
				}else{
					$l_link="$webdb[www_url]/a_d/a_d_s.php?job=jump&id=$rs[id]&url=".base64_encode($l_link);
					$L_Types="photo";
				}
			}
			if($r_src){
				$r_src=tempdir($r_src);
				if(eregi("swf$",$r_src)){
					$R_Types="flash";
				}else{
					$r_link="$webdb[www_url]/a_d/a_d_s.php?job=jump&id=$rs[id]&url=".base64_encode($r_link);
					$R_Types="photo";
				}
			}
			$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			$_code="<script language=\"javascript\" type=\"text/javascript\">
   var adLeftSrc = \"$l_src\"   //图片地址
   var adLeftFlash = \"$L_Types\"
   var adLeftHref = \"$l_link\"
   var adLeftWidth = '$l_width'
   var adLeftHeight = '$l_height'
   var adRightSrc = \"$r_src\"//图片地址
   var adRightFlash = \"$R_Types\"
   var adRightHref = \"$r_link\"
   var adRightWidth = '$r_width'
   var adRightHeight = '$r_height'
   var marginTop = 300 //在这里更改距离浏览器底端的高度
   var marginLeft = 5//在这里更改距离浏览器右端的高度
   var navUserAgent = navigator.userAgent
   function load(){
    judge();
    move();
   }
   function move() {
    judge();
    setTimeout(\"move();\",80)
   }
   function judge(){
    if (navUserAgent.indexOf(\"Firefox\") >= 0 || navUserAgent.indexOf(\"Opera\") >= 0) {
     if (adLeftSrc != \"\") {document.getElementById(\"adLeftFloat\").style.top = (document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop) + ((document.body.clientHeight > document.documentElement.clientHeight)?document.documentElement.clientHeight:document.body.clientHeight) - adLeftHeight - marginTop + 'px';}
     if (adRightSrc != \"\") {
      document.getElementById(\"adRightFloat\").style.top = (document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop) + ((document.body.clientHeight > document.documentElement.clientHeight)?document.documentElement.clientHeight:document.body.clientHeight) - adRightHeight - marginTop + 'px';
      document.getElementById(\"adRightFloat\").style.left = ((document.body.clientWidth > document.documentElement.clientWidth)?document.body.clientWidth:document.documentElement.clientWidth) - adRightWidth - marginLeft + 'px';
     } 
    }
    else{
     if (adLeftSrc != \"\") {document.getElementById(\"adLeftFloat\").style.top = (document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop) + ((document.documentElement.clientHeight == 0)?document.body.clientHeight:document.documentElement.clientHeight) - adLeftHeight - marginTop + 'px';}
     if (adRightSrc != \"\") {
      document.getElementById(\"adRightFloat\").style.top = (document.body.scrollTop?document.body.scrollTop:document.documentElement.scrollTop) + ((document.documentElement.clientHeight == 0)?document.body.clientHeight:document.documentElement.clientHeight) - adRightHeight - marginTop + 'px';
      document.getElementById(\"adRightFloat\").style.left = ((document.documentElement.clientWidth == 0)?document.body.clientWidth:document.documentElement.clientWidth) - adRightWidth - marginLeft + 'px';
     }
    }
    if (adLeftSrc != \"\") {document.getElementById(\"adLeftFloat\").style.left = marginLeft + 'px';}
   }
   
   
   
if (adLeftSrc != \"\") {
	if (adLeftFlash == \"flash\") {
		document.write(\"<div id=\\\"adLeftFloat\\\" style=\\\"position: absolute;width:\" + adLeftWidth + \";height:100px; font-size:12px;\\\"><div id='left_top'><img src=\\\"$webdb[www_url]/images/default/close.gif\\\" width=\\\"12\\\" border=\\\"0\\\" height=\\\"12\\\" onMousedown=\\\"javascript:close_ad('left_top');void(0);\\\";>\");
    
		document.write(\"<div id=\\\"Float\\\" style=\\\"width:\" + adLeftWidth + \";\\\"><embed src=\\\"\" + adLeftSrc + \"\\\" quality=\\\"high\\\"  width=\\\"\" + adLeftWidth + \"\\\" height=\\\"\" + adLeftHeight + \"\\\" type=\\\"application/x-shockwave-flash\\\"></embed></div></div>\");
		document.write(\"</div>\");
    }else{
		document.write(\"<div id=\\\"adLeftFloat\\\" style=\\\"position: absolute;width:\" + adLeftWidth + \";height:100px; font-size:12px;\\\"><img src=\\\"$webdb[www_url]/images/default/close.gif\\\" width=\\\"12\\\" border=\\\"0\\\" height=\\\"12\\\" onMousedown=\\\"javascript:close_float_left();void(0);\\\";>\");
    
		document.write(\"<div id=\\\"Float\\\" style=\\\"width:\" + adLeftWidth + \";\\\"><a href=\\\"\" + adLeftHref +\"\\\" target=_blank><img src=\\\"\" + adLeftSrc + \"\\\"  width=\\\"\" + adLeftWidth + \"\\\" height=\\\"\" + adLeftHeight + \"\\\"  border=\\\"0\\\" \></a></div>\");
		document.write(\"</div>\");
    }
}
   
   
   
if (adRightSrc != \"\") {
	if (adRightFlash == \"flash\") {
		document.write(\"<div id=\\\"adRightFloat\\\" style=\\\"position: absolute;width:\" + adRightWidth + \";height:100px; font-size:12px;text-align:right;\\\"><div id='right_top'><img src=\\\"$webdb[www_url]/images/default/close.gif\\\" width=\\\"12\\\" border=\\\"0\\\" height=\\\"12\\\" onMousedown=\\\"javascript:close_ad('right_top');void(0);\\\";>\");
    
		document.write(\"<div id=\\\"Float\\\" style=\\\"width:\" + adRightWidth + \";\\\"><embed src=\\\"\" + adRightSrc + \"\\\" quality=\\\"high\\\"  width=\\\"\" + adLeftWidth + \"\\\" height=\\\"\" + adRightHeight + \"\\\" type=\\\"application/x-shockwave-flash\\\"></embed></div></div>\");
		document.write(\"</div>\");
    }else{
		document.write(\"<div id=\\\"adRightFloat\\\" style=\\\"position: absolute;width:\" + adRightWidth + \";height:100px; font-size:12px;text-align:right;\\\"><img src=\\\"$webdb[www_url]/images/default/close.gif\\\" width=\\\"12\\\" border=\\\"0\\\" height=\\\"12\\\" onMousedown=\\\"javascript:close_float_right();void(0);\\\";>\");
    
		document.write(\"<div id=\\\"Float\\\" style=\\\"width:\" + adRightWidth + \";\\\"><a href=\\\"\" + adRightHref +\"\\\" target=_blank><img src=\\\"\" + adRightSrc + \"\\\"   width=\\\"\" + adLeftWidth + \"\\\" height=\\\"\" + adRightHeight + \"\\\"  border=\\\"0\\\"  \></a></div>\");
		document.write(\"</div>\");
    }
}
load();
function close_float_right(){
	document.getElementById(\"adRightFloat\").style.display=\"none\";
} 
function close_float_left(){
	document.getElementById(\"adLeftFloat\").style.display=\"none\";
}
function close_ad(d){
	document.getElementById(d).style.display=\"none\";
}
</script>";
		}else{
			if(!eregi("<SCRIPT",$code)){
				$_code=$code;
				$code="<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/a_d/a_d_s.php?job=js&ad_id=$rs[keywords]'></SCRIPT>";
			}else{
				$_code=$code;
			}
		}

		return array($_code,$code);
}
?>