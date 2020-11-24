<?php
function ShowCoupons($uid,$nums){
	global $db,$pre;
	$query = $db->query("SELECT A.*,B.price FROM {$pre}coupon_content A LEFT JOIN {$pre}coupon_content_1 B ON A.id=B.id  WHERE A.uid='$uid' ORDER BY A.id DESC LIMIT $nums");
	while($rs = $db->fetch_array($query)){
		$rs[picurl]=tempdir($rs[picurl]);
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
	<div class="head head1"><div class="tag">商铺促销</div><div class="more"><a href="?m=coupon&uid=$uid">更多</a></div></div>
	<div class="cont">		
		<ul class="liscoupons">
<!--
EOT;
unset($hyconpons);
$hyconpons=ShowCoupons($uid,8);
foreach($hyconpons as $rs){
print <<<EOT
-->
			<li>
				<div class="img"><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]" target="_blank"><img src="$rs[picurl]" onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" height="120"/></a></div>
				<div class="t"><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]" target="_blank">$rs[title]</a></div>
				<div class="p">￥<span>{$rs[price]}</span></div>
			</li>
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