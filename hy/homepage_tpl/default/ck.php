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
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
  <tr>
    <td  class="head">
	<span class='L'></span>
	<span class='T'>”—«È¡¥Ω”</span>
	<span class='R'></span>
	<span class='more'></span>
	
	</td>
  </tr>
  <tr>
    <td  class="content">


<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->
<div style='padding-left:20px;'>
<div>°§<a href="{$rs[url]}" target="_blank">$rs[title]</a>
</div>
</div>

<!--
EOT;
}
print <<<EOT
-->
	
	</td>
  </tr>
</table>

   
 
<!--
EOT;
unset($listdb);
?>
-->