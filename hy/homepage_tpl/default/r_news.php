<?php
function ShowNews($uid,$nums){
	global $db,$_pre;
	$query=$db->query("SELECT * FROM {$_pre}news WHERE uid='$uid' AND yz=1 ORDER BY posttime DESC LIMIT $nums");
	while($rs=$db->fetch_array($query)){
		$rs[posttime]=date("Y-m-d",$rs[posttime]);
		$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤
		$rs[content]=get_word(str_replace("&nbsp;","",$rs[content]),200);
		$listdb[]=$rs;
	}
	return $listdb;
}
?>

<!--
<?php
print <<<EOT
-->
<div class="maincont1">
	<div class="head"><div class="tag">商铺新闻</div><div class="more"><a href="?m=news&uid=$uid">更多</a></div></div>
	<div class="cont">		
		<ul class="listnews">
<!--
EOT;
unset($hynews);
$hynews=ShowNews($uid,8);
foreach($hynews as $rs){
print <<<EOT
-->
			<li><a href="?uid=$uid&m=newsview&id=$rs[id]">$rs[title]</a></li>
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