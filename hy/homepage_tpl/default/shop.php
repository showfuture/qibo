<?php
unset($array);
$page>1 || $page=1;
$rows=16;
$min=($page-1)*$rows;
$query = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM {$pre}shop_content WHERE uid='$uid' ORDER BY id DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
while($rs = $db->fetch_array($query)){
	$rs[picurl]=tempdir($rs[picurl]);
	$rs[posttime]=date("Y-m-d H:i",$rs[posttime]);
	$array[]=$rs;
}

$showpage=getpage("","","?m=$m&uid=$uid",$rows,$RS['FOUND_ROWS()']);
?>

<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
<!--
<?php
print <<<EOT
-->
<style>
.tblist{
	border:1px solid #CCCCCC;
}
.tblist td{
	line-height:18px;
}
.tblist .shoplist{
	width:194px;
	float:left;
	margin-top:10px;
	margin-bottom:5px;
}
.tblist .shoplist .ig a{
	display:block;
	border:1px solid #eee;
	width:160px;
	height:120px;
}
.tblist .shoplist .ig img{
	border:1px solid #fff;
}

.tblist .head{
	border-bottom:1px solid #ccc;
}
.tblist .head .TAG{
	padding-left:10px;
	font-weight:bold;
}
.tblist  .head{
	line-height:23px;
}
</style>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tblist"><tr> 
   <td align="left" bgcolor="#F2F2F2" class="head" ><span class='TAG'>商品展示</span></td>
  </tr>
  <tr> 
    <td colspan="4"><!--
EOT;
foreach($array AS $rs){
$rs[title]=get_word($rs[title],26);
print <<<EOT
-->
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="shoplist">
        <tr>
          <td align="center" class="ig"><a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank"><img src="$rs[picurl]"   onerror="this.src='$webdb[www_url]/images/default/nopic.jpg'" width="160" height="120" border="0"></a></td>
        </tr>
        <tr>
          <td align="center"><font color="#FF0000">价格:{$rs[price]}元</font><br>
            <a href="$webdb[www_url]/shop/bencandy.php?fid=$rs[fid]&id=$rs[id]&city_id=$rs[city_id]" target="_blank">$rs[title]</a></td>
        </tr>
      </table><!--
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