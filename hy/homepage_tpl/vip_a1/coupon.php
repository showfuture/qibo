<?php
unset($array);
$page>1 || $page=1;
$rows=10;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS B.*,A.* FROM {$pre}coupon_content A LEFT JOIN {$pre}coupon_content_1 B ON A.id=B.id WHERE A.uid='$uid' ORDER BY A.id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}
$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);
?>
<!--
<?php
print <<<EOT
-->
<div class="maincont1">
	<div class="head">
		<div class="tag">优惠促销</div>
		<div class="more">&nbsp;</div>
	</div>
	<div class="cont">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td>
<!--
EOT;
foreach($array AS $rs){
print <<<EOT
-->
		<dl class="listCoupon">
			<dt><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"><img src="$rs[picurl]" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" height="120"/></a></dt>
			<dd>
				<div class="t"><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank">$rs[title]</a></div>
				<div>市场价：<strike>￥{$rs[mart_price]} 元</strike> </div>
				<div>优惠价: <span>{$rs[price]}元</span></div>
				<div>截止日期:$rs[end_time]</div>
			</dd>
		</dl>
<!--
EOT;
}
print <<<EOT
-->	
		</td>
	  </tr>
	</table>
	<div class="Shoppage">$showpage</div>
	</div>
</div>
<!--
EOT;
?>
-->