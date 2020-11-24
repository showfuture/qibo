<?php
unset($listdb);
$query=$db->query("SELECT * FROM {$_pre}friendlink WHERE uid='$uid' AND yz=1 ");
while($rs=$db->fetch_array($query)){
	$listdb[]=$rs;	
}
?>
<!--
<?php
print <<<EOT
-->
<div class="sidecont">
	<div class="head"><div class="tag">”—«È¡¥Ω”</div></div>
	<div class="cont flink">
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
		<a href="{$rs[url]}" target="_blank">$rs[title]</a>
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