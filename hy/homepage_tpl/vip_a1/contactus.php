<!--
<?php
//echo $rsdb[province_id];
$rsdb[show_qq]=getOnlinecontact('qq',$rsdb[qq]);
$rsdb[show_msn]=getOnlinecontact('msn',$rsdb[msn]);
$rsdb[show_ww]=getOnlinecontact('ww',$rsdb[ww]);
$rsdb[qy_contact_email] =str_replace("@","#",$rsdb[qy_contact_email]);
print <<<EOT
-->
<div class="maincont1">
	<div class="head">
		<div class="tag">联系我们</div>
		<div class="more">&nbsp;
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=contactus' target='_blank'>修改</a>
<!--
EOT;
}
print <<<EOT
-->	
		</div>
	</div>
	<div class="cont">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="contactTable">
		  <tr>
			<td class="tg" width="100">单位名称：</td>
			<td width="250">$rsdb[title]</td>
			<td class="tg" width="100">职位：</td>
			<td>$rsdb[qy_contact_zhiwei]</td>
		  </tr>
		  <tr>
			<td class="tg">联系人：</td>
			<td>$rsdb[qy_contact]</td>
			<td class="tg">电话号码：</td>
			<td>$rsdb[qy_contact_tel]</td>
		  </tr>
		  <tr>
			<td class="tg">传真号码：</td>
			<td>$rsdb[qy_contact_fax]</td>
			<td class="tg">移动号码：</td>
			<td>$rsdb[qy_contact_mobile]</td>
		  </tr>
		  <tr>
			<td class="tg">单位主页：</td>
			<td><a href='$rsdb[qy_website]' target='_blank'>$rsdb[qy_website]</a></td>
			<td class="tg">邮箱地址：</td>
			<td>$rsdb[qy_contact_email] (请手动将‘＃’换成‘@’)</td>
		  </tr>
		  <tr>
			<td class="tg">区域：</td>
			<td>{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]} {$street_DB[name][$rsdb[street_id]]}</td>
			<td class="tg">邮政编码：</td>
			<td>$rsdb[qy_postnum]</td>
		  </tr>
		  <tr>
			<td class="tg">详细地址：</td>
			<td colspan="3">$rsdb[qy_address]</td>
		  </tr>
		  <tr>
			<td class="tg">在线交流：</td>
			<td colspan="3">
				<div>Q Q:$rsdb[show_qq]</div>
				<div>MSN:$rsdb[show_msn]</div>
				<div>阿里旺旺:$rsdb[show_ww]</div>
			</td>
		  </tr>
<!--
EOT;
if($rsdb[gg_maps]){
print <<<EOT
-->
		  <tr>
			<td colspan="4">
				<iframe src="$Mdomain/job.php?job=show_ggmaps&position=$rsdb[gg_maps]&title=$rsdb[title]"  width="100%" height="500" scrolling="no" frameborder="0" ></iframe>
			</td>
		  </tr>
<!--
EOT;
}
print <<<EOT
-->
		</table> 
	</div>
</div> 
<!--
EOT;
?>
-->