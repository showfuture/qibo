<?php
$webdb[company_picsort_Max]=$webdb[company_picsort_Max]?$webdb[company_picsort_Max]:10;
$query=$db->query("SELECT * FROM {$_pre}picsort WHERE uid='$uid' ORDER BY orderlist DESC LIMIT 0,$webdb[company_picsort_Max];");
while($rs=$db->fetch_array($query)){
	$picsortlistdb[]=$rs;
}
if($psid){
	$rows=6;
	$page=$page?$page:1;
	$min=($page-1)*$rows;

	$query=$db->query("SELECT * FROM {$_pre}pic WHERE uid='$uid' AND psid='$psid' ORDER BY pid DESC LIMIT $min,$rows;");
	while($rs=$db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		$rs[url]=tempdir($rs[url]);
		$piddb[]=$rs[pid];
		$picslistdb[]=$rs;
	}
	$showpage=getpage("{$_pre}pic"," where uid='$uid' and psid='$psid'","?uid=$uid&m=pics&psid=$psid",$rows);
}
if($pid){
	$thisPic=$db->get_one("SELECT * FROM {$_pre}pic WHERE uid='$uid' AND pid='$pid'");
	$thisPicurl=tempdir($thisPic['url']);
	$thispid=$thisPic['pid'];
}else{
	$thisPicurl=$picslistdb[0][url];
	$pid=$picslistdb[0][pid];
	$thispid=$pid;	
}
@extract($db->get_one("SELECT pid AS uppid FROM {$_pre}pic WHERE pid>'$thispid' AND uid='$uid' AND psid='$psid' ORDER BY pid ASC LIMIT 1"));
@extract($db->get_one("SELECT pid AS dowpid FROM {$_pre}pic WHERE pid<'$thispid' AND uid='$uid' AND psid='$psid' ORDER BY pid DESC LIMIT 1"));
if($uppid){
	if(!in_array($uppid,$piddb)){
		$page0=$page-1;
	}else{
		$page0=$page;
	}
	$upurl="?uid=$uid&m=pics&psid=$psid&pid=$uppid&page=$page0";
}else{
	$upurl="javascript:alert('已经是第一张了');";
}
if($dowpid){
	if(!in_array($dowpid,$piddb)){
		$page1=$page+1;
	}else{
		$page1=$page;
	}
	$dowurl="?uid=$uid&m=pics&psid=$psid&pid=$dowpid&page=$page1";
}else{
	$dowurl="javascript:alert('已经是最后一张了');";
}
?>

<!--
<?php
print <<<EOT
--> 
<div class="maincont1">
	<div class="head">
		<div class="tag">公司图库</div>
		<div class="more">&nbsp;
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=pic_upload'  target='_blank'>上传图片</a> | <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=pic'  target='_blank'>管理</a> 
<!--
EOT;
}
print <<<EOT
-->
		</div>
	</div>
	<div class="cont">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
<!--
EOT;
if(!$psid){
foreach($picsortlistdb as $rs){
$rs[faceurl]=tempdir($rs[faceurl]);
print <<<EOT
-->
              <div class="Listphoto1">
				<div class="img"><a href="?uid=$uid&psid=$rs[psid]&m=pics&psid=$rs[psid]"><img src="$rs[faceurl].gif"  height="100" onerror="this.src='$Murl/images/default/userpicsortdefault.gif';"/></a></div>
				<div class="t"><a href="?uid=$uid&psid=$rs[psid]&m=pics&psid=$rs[psid]">$rs[name]</a></div>
			  </div>
<!--
EOT;
}}else{
print <<<EOT
-->
			<div class="photoSelect">
				选择其他图集：
				<select onchange="window.location='?uid=$uid&m=pics&psid='+this.options[this.selectedIndex].value;">
<!--
EOT;
foreach($picsortlistdb as $rs){
$ck=$rs[psid]==$psid?" selected":"";
print <<<EOT
-->
                <option value="$rs[psid]" $ck>$rs[name]</option>
<!--
EOT;
}
print <<<EOT
-->
              </select>
			 </div>
<!--
EOT;
if($pid){
print <<<EOT
-->
<script>
$(function(){
	//var picWidth=$(".showMainPic img").width();
	//if(picWidth>650)$(".showMainPic .img img").css("width","650px");
	//var picHight=$(".showMainPic .img").height();
	//$(".showMainPic table").css("height",picHight+"px");
	$(".showMainPic li").mouseover(function(){
		$(this).addClass("over");
	});
	$(".showMainPic li").mouseout(function(){
		$(this).removeClass("over");
	});
	$(".showMainPic li.up").click(function(){
		window.location.href="$upurl";
	});
	$(".showMainPic li.down").click(function(){
		window.location.href="$dowurl";
	});
});
function ShowThisPic(thisPic){
	var PicW=thisPic.width;
	var PicH=thisPic.height;
	if(PicW>650){
		PicH=PicH/PicW*650;
		PicW=650;
	}
	thisPic.width=PicW;
	$(".showMainPic table").css("height",PicH+"px");
}
</script>
			<dl class="pic_act">
				<dt><a href="$upurl">&lt;&lt;上一张</a></dt>
				<dt><a href="$dowurl">下一张&gt;&gt;</a></dt>
			</dl>
			<div class="showMainPic">				
				<div class="img"><img src='$thisPicurl' onload="ShowThisPic(this)"/></div>
				<div class="t">$thisPic[title]</div>
				<li class="up"><table><tr><td><img src="$Murl/images/homepage_style/vip_a1/left1.gif"/></td></tr></table></li>
				<li class="down"><table><tr><td><img src="$Murl/images/homepage_style/vip_a1/right1.gif"/></td></tr></table></li>
			</div>
<!--
EOT;
}
foreach($picslistdb as $rs){
$ckpic=$rs[pid]==$pid?" ck":"";
print <<<EOT
-->
			<div class="listPhoto2">
				<div class="img{$ckpic}"><a href="?uid=$rs[uid]&m=pics&psid=$rs[psid]&pid=$rs[pid]&page=$page"><img src="$rs[url].gif"  height="100" onerror="this.src='$Murl/images/default/userpicdefault.gif';" alt='$rs[title]'/></a></div>
				<div class="t"><a href="?uid=$rs[uid]&m=pics&psid=$rs[psid]&pid=$rs[pid]&page=$page">$rs[title]</a></div>
			</div>
<!--
EOT;
}}
print <<<EOT
-->
		</td>
	  </tr>
	</table>
	<div class="Shoppage">$showpage</div>
	</div>
</div>  
<!--
EOT;
?>
-->