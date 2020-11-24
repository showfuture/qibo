<?php
unset($listdb);

$rows=15;
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
<div class="maincont1">
	<div class="head">
		<div class="tag">招聘信息</div>
		<div class="more">&nbsp;
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
		</div>
	</div>
	<div class="cont">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" class="ListJobs">
<!--
EOT;
foreach($listdb as $rs){
print <<<EOT
-->

	  <tr>
		<td width="40%"> <a href="$webdb[www_url]/hr/bencandy.php?fid=$rs[fid]&id=$rs[id]" target="_blank">$rs[title]</a></td>
		<td width="30%"> 招聘：<span>{$rs[nums]} </span>人</td>
		<td width="30%"> 工作地点：<span>{$rs[workplace]}</span> </td>
	  </tr>
<!--
EOT;
}
print <<<EOT
-->
	</table>
	<div class="Shoppage">$showpage</div>
	</div>
</div> 
<!--
EOT;
?>
-->