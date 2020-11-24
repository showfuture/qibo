<?php
/**
*过滤HTMLJS 标记
**/
function ReplaceHtmlAndJs($document)
{
 $document = trim($document);
 if (strlen($document) <= 0)
 {
  return $document;
 }
 $search = array ("'<script[^>]*?>.*?</script>'si",  // 去掉 javascript
                  "'<[\/\!]*?[^<>]*?>'si",          // 去掉 HTML 标记
                  "'([\r\n])[\s]+'",                // 去掉空白字符
                  "'&(quot|#34);'i",                // 替换 HTML 实体
                  "'&(amp|#38);'i",
                  "'&(lt|#60);'i",
                  "'&(gt|#62);'i",
                  "'&(nbsp|#160);'i"
                 );                    // 作为 PHP 代码运行

 $replace = array ("",
                   "",
                   "\\1",
                   "\"",
                   "&",
                   "<",
                   ">",
                   " "
                  );

 return @preg_replace($search, $replace, $document);
}
//得到交流在线图片
function getOnlinecontact($type,$number,$jiange=" ")
{
	global $webdb,$Mdomain;
	if(!$type) $type='qq';
	$number=explode(',',$number);
	$return="";
	foreach($number as $id){
		if($id!=''){
			if($type=='qq'){
				$return.='<a target="blank" href="http://wpa.qq.com/msgrd?V=1&Uin='.$id.'&Site='.$webdb[webname].'&Menu=yes"><img border="0" SRC=http://wpa.qq.com/pa?p=1:'.$id.':10 alt="点击这里与我联系" align="absmiddle"></a> '.$id.$jiange;
			}elseif($type=='msn'){
				$return.='<A HREF="msnim:chat?contact='.$id.'"><IMG SRC="'.$Mdomain.'/images/default/msg_ico.gif" align="absmiddle" border="0" ALT="MSN Online Status Indicator"> '.$id.'</A>'.$jiange;
			}elseif($type=='skype'){
				$return.='<a href="skype:'.$id.'?call" onclick="return skypeCheck();"><img src=http://mystatus.skype.com/smallclassic/'.$id.' style="border: none;" alt="Call me!" /></a> '.$id.$jiange;
			}elseif($type=='ww'){
				$return.='<a target="_blank" href="http://amos1.taobao.com/msg.ww?v=2&uid='.urlencode($id).'&s=2" ><img border="0" src="http://amos1.taobao.com/online.ww?v=2&uid='.urlencode($id).'&s=2" alt="点击这里给我发消息" /> '.$id.'</a>'.$jiange;
			}
		}
	}
	return $return;
}



function getrenzheng($re)
{
	global $Murl,$STYLE;
	if($re==1){
		return "<img src='{$Murl}/images/{$STYLE}/jibenrenzheng.gif'  border='0'/>";
	}elseif($re==2){
		return "<img src='{$Murl}/images/{$STYLE}/yinpairenzheng.gif'  border='0'/>";
	}elseif($re==3){
		return "<img src='{$Murl}/images/{$STYLE}/jinpairenzheng.gif'  border='0'/>";
	}else{
		return "<img src='{$Murl}/images/{$STYLE}/meirenzheng.gif'  border='0'/>";
	}
}

/**
*用户绑定图片用
**/
function bd_pics($table,$where){
	global $bd_pics_list,$db,$webdb,$lfjid,$lfjuid,$_pre;
	if(!$where) return false;
	
	if(is_array($bd_pics_list)){
		$bd_pics_list=implode(",",$bd_pics_list);			
		$db->query("UPDATE $table SET bd_pics='$bd_pics_list' $where");
		return true;	
	}	
}


/**
*展示用户绑定的图片
**/

function show_bd_pics($table,$where,$titlelength=0){
	
	global $db,$webdb,$lfjid,$lfjuid,$_pre,$pre,$user_picdir,$Mdomain,$Murl;
	
	if(!$where) return "";
	$rsdb=$db->get_one("SELECT bd_pics FROM  $table  $where LIMIT 1");
	if($rsdb[bd_pics]){
		$show="<div>
		<style>
/*
*网页对话狂
*/

.overlay {
	clear:both;
	position: absolute;
	z-index:999;
	top: 0px;
	left: 0px;
	width:100%;
	background-color:#000000;
	filter:alpha(opacity=50);
	-moz-opacity: 0.6;
	opacity: 0.6;
}
.overlay2 {
	clear:both;
	position: absolute;
	z-index:1000;
	width:200px;
	height:60px;
	border:#F4862C solid 5px;
	background:#ffffff;	
	color:#000000;
	overflow:hidden;
	
}
.overlay2 .Boxtitle{
	clear:both;
	border-bottom:1px #FFB24E solid; line-height:20px; background-color:#FF6A00; color: #ffffff; text-align:right;
}
.overlay2 .Boxcontent{clear:both;color:#FFFFFF; text-align:center; overflow:auto;}
		</style>
		";
		$js="<script src='".$Murl."/images/window_box.js' language='javascript' type='text/javascript'></script>
		<script language='javascript'>
		function showbigbdpic(url){
			unshowLightBox();
			showLightBox('<iframe src=".$Murl."/showpic.php?url='+url+' iframeframeborder=0  width=600 height=600/>','overlay2',600,600);
		}
		
		</script>";
		$query=$db->query("SELECT * FROM {$_pre}pic WHERE pid in($rsdb[bd_pics])");
		while($rs=$db->fetch_array($query)){
			$rs[url]=tempdir($rs[url]);
			$show.='<li style="width:120px; border:0px solid #cecece; height:'.($titlelength?"140px":"120px").';  background-color:#ffffff; float:left; list-style:none;  margin:5px 5px 5px 5px;text-align:center; cursor:hand; padding:5px;"><img src="'.$rs[url].'.gif"   width="120" height="120"  alt="'.$rs[title].'" title="'.$rs[title].'" onclick="showbigbdpic(\''.$rs[url].'\')"/><br>'.($titlelength?get_word($rs[title],$titlelength):"").'</li>';
		}
		return $show.$js."</div>";
	}else{
		return "";
	}

}

?>