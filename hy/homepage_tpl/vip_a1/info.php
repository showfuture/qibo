<?php
$rsdb[content] = En_TruePath($rsdb[content],0);
$rsdb[qy_contact_email] =str_replace("@","#",$rsdb[qy_contact_email]);
$rsdb[show_qq]=getOnlinecontact('qq',$rsdb[qq]);
$rsdb[show_msn]=getOnlinecontact('msn',$rsdb[msn]);
$rsdb[show_ww]=getOnlinecontact('ww',$rsdb[ww]);
$rsdb[fname]=str_replace("|",",",$rsdb[fname]);
?>

<!--
<?php
if(!$m){
print <<<EOT
--> 
<div class="maincont1">
	<div class="head"><div class="tag">商家简介</div><div class="more">$updateinfo</div></div>
	<div class="cont">
		<div class="showcInfo">
			<dl class="baseinfo">
				<dt>$rsdb[title]<span>概况</span></dt>
				<dd>$rsdb[content]</dd>
			</dl>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="moreinfo">
					<div class="nofl">主营分类：<span>$rsdb[fname]</span></div>
					<div>所属行业：<span>$rsdb[my_trade]</span></div>
					<div>企业类型：<span>$rsdb[qy_cate]</span></div>
					<div>注册资本：<span>$rsdb[qy_regmoney]万</span></div>
					<div>经营模式：<span>$rsdb[qy_saletype]</span></div>
					<div>注册地址：<span>$rsdb[qy_regplace]</span></div>
					<div>成立时间：<span>$rsdb[qy_createtime]</span></div>
					<div class="nofl">主营产品或服务：<span>$rsdb[qy_pro_ser]</span></div>
					<div>主要采购产品：<span>$rsdb[my_buy]</span></div>
				</td>
				<td class="contacts">
					<div>$rsdb[qy_contact_email]</div>
					<div class="bold">$rsdb[qy_contact_tel]</div>
					<div class="bold">$rsdb[qy_contact_mobile]</div>
				</td>
			  </tr>
			</table>
		</div>
	</div>
</div>
<!--
EOT;
}else{
$updateinfo=($lfjuid==$uid)?"<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?&atn=info2' target='_blank'>修改公司介绍</a>":"<br/>";
print <<<EOT
-->
<div class="maincont1">
	<div class="head"><div class="tag">商家简介</div><div class="more">$updateinfo</div></div>
	<div class="cont">
		<div class="showcInfo">
			<dl class="baseinfo">
				<dt>$rsdb[title]<span>概况</span></dt>
				<dd>$rsdb[content]</dd>
			</dl>
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			  <tr>
				<td class="moreinfo">
					<div class="nofl">主营分类：<span>$rsdb[fname]</span></div>
					<div>所属行业：<span>$rsdb[my_trade]</span></div>
					<div>企业类型：<span>$rsdb[qy_cate]</span></div>
					<div>注册资本：<span>$rsdb[qy_regmoney]万</span></div>
					<div>经营模式：<span>$rsdb[qy_saletype]</span></div>
					<div>注册地址：<span>$rsdb[qy_regplace]</span></div>
					<div>成立时间：<span>$rsdb[qy_createtime]</span></div>
					<div class="nofl">主营产品或服务：<span>$rsdb[qy_pro_ser]</span></div>
					<div>主要采购产品：<span>$rsdb[my_buy]</span></div>
				</td>
				<td class="contacts">
					<div>$rsdb[qy_contact_email]</div>
					<div class="bold">$rsdb[qy_contact_tel]</div>
					<div class="bold">$rsdb[qy_contact_mobile]</div>
				</td>
			  </tr>
			</table>
		</div>
	</div>
</div>
<div class="MoreContact">
	<div>联系电话：<span>$rsdb[qy_contact_tel]</span></div>
	<div>传真：<span>$rsdb[qy_contact_fax]</span></div>
	<div>电子邮件：<span>$rsdb[qy_contact_email]</span>(请手动将‘＃’换成‘@’)</div>
	<div>联系地址：<span>$rsdb[qy_address]</span></div>
	<div>商铺地址：<span>$webdb[www_url]/home/?uid=$uid</span></div>
	<h3>在线沟通工具</h3>
	<div>客服QQ：<span>$rsdb[show_qq]</span></div>
	<div>客服MSN：<span>$rsdb[show_msn]</span></div>
	<div>客服旺旺：<span>$rsdb[show_ww]</span></div>
</div>
<!--
EOT;
}
?>
-->