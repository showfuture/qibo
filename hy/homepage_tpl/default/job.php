<?php
unset($listdb);

$rows=10;
if($page<1){
	$page=1;
}
$min=($page-1)*$rows;

$query=$db->query("SELECT SQL_CALC_FOUND_ROWS A.*,B.* FROM {$pre}hr_content A LEFT JOIN {$pre}hr_content_1 B ON A.id=B.id WHERE A.uid='$uid' ORDER BY A.id DESC LIMIT $min,$rows");

$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];

while($rs=$db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d",$rs[posttime]);
	$rs[content]=@preg_replace('/<([^>]*)>/is',"",$rs[content]);	//把HTML代码过滤
	$rs[content]=get_word(str_replace("&nbsp;","",$rs[content]),200);
	$listdb[]=$rs;
}	
	
$showpage=getpage('','',"?uid=$uid&m=$m",$rows,$totalNum);
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
	<span class='T'>招聘信息</span>
	<span class='R'></span>
	<span class='more'>
<!--
EOT;
if($lfjuid==$uid && $mod_in=='right'){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$webdb[www_url]/hr/member/listjob.php?job=list' target='_blank'>管理招聘</a> | <a href='$webdb[www_url]/member/?main=$webdb[www_url]/hr/member/post_choose.php' target='_blank'>发布招聘</a> 
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

 ·<a href="$webdb[www_url]/hr/bencandy.php?fid=$rs[fid]&id=$rs[id]" target="_blank">$rs[title]</a><br>

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
    <td > <a href="$webdb[www_url]/hr/bencandy.php?fid=$rs[fid]&id=$rs[id]" target="_blank">$rs[title]</a></td>
	<td > 招聘：{$rs[nums]} 人</td>
	<td > 工作地点：{$rs[workplace]} </td>
  </tr>
 


<!--
EOT;
}
print <<<EOT
-->
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