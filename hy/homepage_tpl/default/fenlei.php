<?php
unset($array);
$page>1 || $page=1;
$rows=20;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$pre}fenlei_content WHERE uid='$uid' ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}

$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);
?>

<!--
<?php
print <<<EOT
-->
<style>
.lists{
	line-height:25px;
	height:25px;
	overflow:hidden;
	color:#666;
	border-bottom:#DDD dotted 1px;
}
.lists a,.lists span{
	float:left;
}
.lists a.fm{
	color:#f60;
	padding:0 5px 0 5px;
}
.lists span.time{
	float:right;
	padding-right:5px;
}
.showpage{
	text-align:center;
	padding:10px 0 5px 0;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightinfo">
  <tr>
    <td  class="head">
	<span class='L'></span>
	<span class='T'><a href="?uid=$uid&m=fenlie">商家信息</a></span>
	<span class='R'></span>
	<span class='more'>&nbsp;</span>
	</td>
  </tr>
  <tr>
    <td class="content">
<!--
EOT;
foreach($array AS $rs){
print <<<EOT
-->
	<div class="lists">
	<a href="$webdb[www_url]/list.php?fid=$rs[fid]&city_id=$rs[city_id]" target="_blank" class="fm">[{$rs[fname]}]</a>
	<a href="$webdb[www_url]/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank">$rs[title]</a>
	<span>($rs[hits])</span>
	<span class="time">$rs[posttime]</span>
	</div>	
<!--
EOT;
}
print <<<EOT
-->
	<div class="showpage">$showpage</div>
	</td>
  </tr>
</table>
<!--
EOT;
?>
-->