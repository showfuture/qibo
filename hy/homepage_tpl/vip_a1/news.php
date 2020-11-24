<?php
unset($listdb);
if($m){
	$rows=$conf[listnum][Mnewslist]?$conf[listnum][Mnewslist]:20;
}else{
	$rows=$conf[listnum][newslist]?$conf[listnum][newslist]:5;
}
	
$rows=10;
if($page<1){
	$page=1;
}
$min=($page-1)*$rows;
$where=" WHERE uid='$rsdb[uid]' AND yz=1 ";
$query=$db->query("SELECT * FROM {$_pre}news $where ORDER BY posttime DESC LIMIT $min,$rows");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤
	$rs[content]=get_word(str_replace("&nbsp;","",$rs[content]),200);
	$listdb[]=$rs;
}	
	
$showpage=getpage("{$_pre}news",$where,"?uid=$uid&m=$m",$rows);
$mod_in=$mod_in?$mod_in:'right';
?>
<!--
<?php
if($mod_in=='left'){
print <<<EOT
-->
<div class="sidecont">
	<div class="head"><div class="tag">公司新闻</div></div>
	<div class="cont news">
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
		<div class="list"><a href="?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a></div>
<!--
EOT;
}
print <<<EOT
-->
	</div>
</div>
<!--
EOT;
}elseif($mod_in=='right'){
print <<<EOT
-->
<div class="maincont1">
	<div class="head">
		<div class="tag">公司新闻</div>
		<div class="more">&nbsp;
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
		<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=news' target='_blank'>管理新闻</a> | 
		<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews' target='_blank'>发布新闻</a>
<!--
EOT;
}
print <<<EOT
-->
		</div>
	</div>
	<div class="cont">
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
		<dl class="listNews">
			<dt><a href="?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a></dt>
			<dd>$rs[content]</dd>
		</dl>
<!--
EOT;
}
print <<<EOT
-->
		<div class="newspage">$showpage</div>
	</div>
</div>
<!--
EOT;
}
?>
-->