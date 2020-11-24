<?php
function ShowPics($uid,$nums){
	global $db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}pic WHERE uid='$uid' ORDER BY orderlist DESC LIMIT $nums");
	while($rs = $db->fetch_array($query)){
		$rs[url]=tempdir($rs[url]);
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		$listdb[]=$rs;
	}
	return $listdb;
}
@extract($db->get_one("SELECT COUNT(*) AS hypicnums FROM {$_pre}pic WHERE uid='$uid'"));
?>

<!--
<?php
print <<<EOT
-->
<SCRIPT type=text/javascript>
$(document).ready(function(){
	var lists=$(".ShowPics .cont ul li").index()+1;
	var start=0;
	var shows=3;
	$(".ShowPics .cont .showLeft").click(function(){
		if(start>0){
			start-=1;
			shows-=1;
			whowtypes(start,shows,lists);
		}
	});
	$(".ShowPics .cont .showRight").click(function(){
		if(shows<lists){
			start+=1;
			shows+=1;
			whowtypes(start,shows,lists);
		}
	});
	whowtypes(start,shows,lists);
});
function whowtypes(start,shows,lists){
	if(start==0){
		$(".ShowPics .cont .showLeft span").addClass("no");
	}else if(shows==lists){
		$(".ShowPics .cont .showRight span").addClass("no");
	}else{
		$(".ShowPics .cont .showLeft span").removeClass("no");
		$(".ShowPics .cont .showRight span").removeClass("no");		
	}
	for(var i=0;i<lists;i++){
		if(i<start||i>=shows)
		$(".ShowPics .cont ul li:eq("+i+")").css("display","none");
		else
		$(".ShowPics .cont ul li:eq("+i+")").css("display","block");
	}
}
</SCRIPT>
<div class="maincont1 ShowPics">
	<div class="head"><div class="tag">商铺图片</div><div class="more">共有图片：<span>{$hypicnums}</span>张</div></div>
	<div class="cont">
		<div class="showLeft"><span><br/></span></div>
		<div class="showRight"><span><br/></span></div>
		<ul>
<!--
EOT;
unset($hypicdbs);
$hypicdbs=ShowPics($uid,10);
foreach($hypicdbs as $rs){
print <<<EOT
-->
			<li><a href="?uid=$uid&m=pics&psid=$rs[psid]&pid=$rs[pid]"><img src="$rs[url]" height="150" onerror="this.src='$Murl/images/default/userpicdefault.gif';"/></a></li>
<!--
EOT;
}print <<<EOT
-->
		</ul>
	</div>
</div> 
<!--
EOT;
?>
-->