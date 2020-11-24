<?php
unset($listdb);
$where=" WHERE uid='$rsdb[uid]' AND yz=1 ";
$query=$db->query("SELECT * FROM {$_pre}news $where ORDER BY posttime DESC LIMIT 10");
while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤
	$rs[content]=get_word(str_replace("&nbsp;","",$rs[content]),200);
	$listdb[]=$rs;
}	
?>
<!--
<?php
print <<<EOT
-->
<div class="sidecont">
	<div class="head"><div class="tag">公司新闻</div></div>
	<div class="cont news">
<!--
EOT;
foreach($listdb as $rs){
$rs[title]=get_word($rs[title_full]=$rs[title],40);
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
?>
-->