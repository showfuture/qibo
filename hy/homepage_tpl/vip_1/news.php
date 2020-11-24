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
print <<<EOT
-->
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="{$mod_in}info">
  <tr>
    <td  class="head">
<span class='L'></span>
	<span class='T'>公司新闻</span>
	<span class='R'></span>
	<span class='more'>
<!--
EOT;
if($lfjuid==$uid && $mod_in=='right'){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=news' target='_blank'>管理新闻</a> | <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews' target='_blank'>发布新闻</a> 
<!--
EOT;
}
print <<<EOT
-->
	</span></td>
  </tr>
  <tr>
    <td  class="content">
<!--
EOT;
if($mod_in=='left'){

foreach($listdb as $rs){
$rs[title]=get_word($rs[title_full]=$rs[title],30);
print <<<EOT
-->

 <li><a href="?uid=$uid&m=newsview&id=$rs[id]"  title='$rs[posttime]-$rs[title_full]'>$rs[title]</a></li>


<!--
EOT;
}

}else{
print <<<EOT
-->
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--
EOT;
foreach($listdb as $rs){

print <<<EOT
-->

  <tr>
    <td >【$rs[posttime]】<a href="?uid=$uid&m=newsview&id=$rs[id]"  >$rs[title]</a></td>
  </tr>
  <tr>
    <td style='color:#989898' height=50>$rs[content]</td>
  </tr>


<!--
EOT;
}
print <<<EOT
-->
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center">$showpage</td>
  </tr>
</table>
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
?>
-->