<!--
<?php
$rsdb[posttime]=date("Y-m-d",$rsdb[posttime]);
print <<<EOT
-->   
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="leftinfo">
  <tr>
    <td class="head" ><span class='L'></span>
	<span class='T'>商家档案</span>
	<span class='R'></span>
	<span  style='float:right; padding-right:10px;font-weight:100;' class='more'>
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Mdomain/member/homepage_ctrl.php?atn=info&uid=$uid' target='_blank'>管理</a> 
<!--
EOT;
}
print <<<EOT
-->

	</span></td>
  </tr>
  <tr>
    <td class="content base">
<center><a href="?uid=$uid"><img src="$rsdb[logo]"  border="0"  onload="this.width=150;"  class="logo" onerror="this.src='$webdb[www_url]/images/default/noface.gif';"/></a>      </center>

<center>
<img class="renzhengicon" src="$webdb[www_url]/images/default/renzheng/{$rsdb[renzheng]}.png" border="0" />
</center>

<center><B>$rsdb[company_name_big]</B></center>
<center>$rsdb[services]</center>
<center>{$area_DB[name][$rsdb[province_id]]} {$city_DB[name][$rsdb[city_id]]} {$zone_DB[name][$rsdb[zone_id]]} {$street_DB[name][$rsdb[street_id]]}</center>

<center>通行证ID：$rsdb[username]</center>
<center>登记时间：$rsdb[posttime]</center>
<center>		
<a href="javascript:window.external.AddFavorite('$WEBURL','$rsdb[title]')"><img src='$Murl/images/homepage_style/addcoll.gif' border=0 alt="收藏本商铺"></a>
<a href='$webdb[www_url]/member/?main=pm.php?job=send&username=$rsdb[username]' target="_blank"><img src='$Murl/images/homepage_style/sendmsg.gif' border=0 alt='发送站内信'></a>	</center>
	</td>
  </tr>
</table>


<!--
EOT;
?>
-->