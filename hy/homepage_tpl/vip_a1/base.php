<!--
<?php
$rsdb[posttime]=date("Y-m-d",$rsdb[posttime]);
$adminlinks=($lfjuid==$uid)?"<a href='$Mdomain/member/?main=homepage_ctrl.php?atn=info&uid=$uid' target='_blank'>管理</a>":"";
$renzhengs=$rsdb[renzheng];
$renzhengwords=array("尚未认证","普通认证","银牌认证","金牌认证");
$rsdb[show_qq]=getOnlinecontact('qq',$rsdb[qq]);
print <<<EOT
-->
<div class="sidecont">
	<div class="head"><div class="tag">基本信息</div><div class="more">$adminlinks</div></div>
	<div class="cont base">
		<div class="ctitle">$rsdb[title]</div>		
		<div class="cyz">企业验证：<span><img src="$Murl/images/homepage_style/vip_a1/rz$renzhengs.gif"></span>$renzhengwords[$renzhengs]</div>
		<div class="carea">地区：<span>{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]}{$street_DB[name][$rsdb[street_id]]}</span></div>
		<div class="caddress">店铺地址：<span>$rsdb[qy_address]</span></div>
		<div class="caddress">主营产品：<span>$rsdb[my_trade]</span></div>		
		<div class="cqq">联系QQ：$rsdb[show_qq] </div>
		<div class="ctel">咨询电话：<span>$rsdb[qy_contact_tel]</span></div>
	</div>
</div>
<!--
EOT;
?>
-->