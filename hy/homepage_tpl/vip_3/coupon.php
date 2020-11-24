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
<style>
.tblist{
	border:1px solid #CCCCCC;
}
.tblist td{
	line-height:25px;
}
.tblist .couponlist{
 	border-bottom:1px dotted #eee;
	margin-top:15px;
	margin-bottom:15px;
	margin-left:15px;
}
.tblist .couponlist .ig{
	padding-right:10px;
}
.tblist .couponlist .ig a{
	display:block;
	border:1px solid #eee;
	width:160px;
	height:120px;
}
.tblist .couponlist .ig img{
	border:1px solid #fff;
}
.tblist .head{
	border-bottom:1px solid #ccc;
}
.tblist .head .TAG{
	padding-left:10px;
	font-weight:bold;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblist"><tr> 
    <td align="left" bgcolor="#F2F2F2" class="head" ><span class='TAG'>优惠促销</span></td>
  </tr>
  <tr> 
    <td ><!--
EOT;
foreach($array AS $rs){
print <<<EOT
-->
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="couponlist">
        <tr> 
          <td align="center" class="ig" width="16%"><a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"><img src="$rs[picurl]"   onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" width="160" height="120" border="0"></a></td>
          <td align="left" width="84%" valign="top" class="des"> <a href="$webdb[www_url]/coupon/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"> 
            <font color="#CC0000"><b>$rs[title]</b></font> </a><br>
             市场价： <strike><span style="color:blue;font-size:21px;">￥{$rs[mart_price]} 元</span></strike> <br>
            优惠价: <span style="color:#FF0000;font-size:21px;">{$rs[price]}元</span> <br>
            截止日期:$rs[end_time]</td>
        </tr>
      </table>
      <!--
EOT;
}
print <<<EOT
-->
    </td>
  </tr>
  
   
  
  <tr> 
    <td align="center">$showpage</td>
  </tr>
</table>
<!--
EOT;
?>
-->