<?php
if($id){
	$data=$db->get_one("SELECT * FROM {$_pre}news WHERE id='$id'");
	//真实地址还原
	$data[content]=En_TruePath($data[content],0);
	$data[posttime] =date("Y-m-d",$data[posttime] );

	//得到绑定的图片
	$show_bd_pics=show_bd_pics("{$_pre}news"," WHERE id=$id");
	$db->query("UPDATE `{$_pre}news` SET hits=hits + 1  WHERE id='$id'");
}
?>

<!--
<?php
if($id){
if($data[uid]!=$lfjuid && !$data[yz]){
print <<<EOT
-->   
    
信息正在审核中...
<!--
EOT;
	}else{
print <<<EOT
-->   
    
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
  <tr>
    <td class="head"><span class='L'></span>
	<span class='T'>公司新闻</span>
	<span class='R'></span>
	<span class='more'>
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=postnews&uid=$uid&id=$id' target='_blank'>编辑</a> | <a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=delnews&uid=$uid&id=$id' target='_blank'>删除</a> 
<!--
EOT;
}
print <<<EOT
-->
	</span></td>
  </tr>
  <tr>
    <td  class="content">
<center style='font-size:16px;'><strong>$data[title]</strong></center>
<center style='border-bottom:1px #454646 dotted'>时间：$data[posttime] 点击：$data[hits]次 </center>
<br>
<div>$show_bd_pics</div>
<div><table class="content" width="100%" cellspacing="0" cellpadding="0" style='TABLE-LAYOUT: fixed;WORD-WRAP: break-word'>
              <tr> 
                <td>$data[content]</td>
              </tr>
            </table></div>

	</td>
  </tr>
  <tr>
    <td  class="foot"></td>
  </tr>
</table>

 
<!--
EOT;
}
}
?>
-->