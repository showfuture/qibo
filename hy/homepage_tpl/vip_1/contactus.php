<!--
<?php
//echo $rsdb[province_id];
$rsdb[show_qq]=getOnlinecontact('qq',$rsdb[qq]);
$rsdb[show_msn]=getOnlinecontact('msn',$rsdb[msn]);
$rsdb[show_ww]=getOnlinecontact('ww',$rsdb[ww]);
$rsdb[qy_contact_email] =str_replace("@","#",$rsdb[qy_contact_email]);

print <<<EOT
-->

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
  <tr>
    <td  class="head">
	<span class=L></span>
	<span class=T><a href="?uid=$uid&m=contactus">联系我们</a></span>
	<span class=R></span>
	<span class='more'>
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
	</span>

	</td>
  </tr>
  <tr>
    <td  class="content contmiddle">

 
	<div style="line-height:180%;margin:5px 0px 0px 10px;clear:both;color:#454545">
	<table width="97%" border="0" cellpadding="5" cellspacing="2" bgcolor="#ffffff" style="clear:both; line-height:200%; color:#454545">
  <tr>
    <td width="15%" align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;';>单位名称：</td>
    <td  align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[title]</td>
	<td width="15%" align="center" bgcolor="#F9F9F9" style='color:#454545;font-weight:bold;'> 职 位：</td>
    <td width="35%" align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact_zhiwei]</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'>联 系 人：</td>
    <td width="35%" align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact]</td>
    <td width="15%" align="center" bgcolor="#F9F9F9" style='color:#454545;font-weight:bold;'> 电话号码：</td>
    <td width="35%" align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact_tel]</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'>传真号码：</td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact_fax]</td>
    <td align="center" bgcolor="#F9F9F9" style='color:#454545;font-weight:bold;'> 移动号码：</td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact_mobile]</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'>单位主页：</td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;<a href='$rsdb[qy_website]' target='_blank' style='color:#454545'>$rsdb[qy_website]</a></td>
    <td align="center" bgcolor="#F9F9F9" style='color:#454545;font-weight:bold;'>邮箱地址：</td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_contact_email]<br>(请手动将‘＃’换成‘@’)</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'></td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]} {$street_DB[name][$rsdb[street_id]]}</td>
    <td align="center" bgcolor="#F9F9F9" style='color:#454545;font-weight:bold;'>邮政编码：</td>
    <td align="left" bgcolor="#FFFFFF" style='color:#454545'>&nbsp;$rsdb[qy_postnum]</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'>详细地址：</td>
    <td colspan="3" align="left" bgcolor="#FFFFFF" style='color:#454545' >&nbsp;$rsdb[qy_address]</td>
  </tr>
  <tr>
    <td align="center" bgcolor="#F9f9f9" style='color:#454545;font-weight:bold;'>在线交流：</td>
    <td colspan="3" align="left" bgcolor="#FFFFFF" style='padding:10px;'>
	<p style='color:#454545;height:20px;'>Q Q:$rsdb[show_qq]</p>
	<p style='color:#454545;height:20px;'>MSN:$rsdb[show_msn]</p>
	<p style='color:#454545;height:20px;'>阿里旺旺:$rsdb[show_ww]</p>
	</td>
  </tr>
  <!--
EOT;
if($rsdb[gg_maps]){
print <<<EOT
-->
  <tr align="left" bgcolor="#FFFFFF"> 
            <td style='color:#454545' colspan="4"> 
              <p style='color:#454545;height:500px;'>

<iframe src="$Mdomain/job.php?job=show_ggmaps&position=$rsdb[gg_maps]&title=$rsdb[title]"  width="100%" height="500" scrolling="no" frameborder="0" ></iframe>
</p>
            </td>
          </tr>

<!--
EOT;
}
print <<<EOT
-->	
</table>
 </div>
<br>
	
	</td>
  </tr>
  <tr><td style="height:5px;"></td></tr>
</table>

 
<!--
EOT;
?>
-->