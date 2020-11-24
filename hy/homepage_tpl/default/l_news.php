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
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="{$mod_in}info">
  <tr>
    <td class="head">
	<span class='L'></span>
	<span class='T'>公司新闻</span>
	<span class='R'></span>
	<span class='more'>&nbsp;</span></td>
  </tr>
  <tr>
    <td class="content">
<!--
EOT;
foreach($listdb as $rs){
$rs[title]=get_word($rs[title_full]=$rs[title],26);
print <<<EOT
-->
 <div>·<a href="?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a></div>
<!--
EOT;
}
print <<<EOT
-->
	</td>
  </tr>
  <tr>
    <td  class="foot"></td>
  </tr>
</table>
<!--
EOT;
?>
-->