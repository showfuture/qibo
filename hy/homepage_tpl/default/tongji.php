<?php
@extract($db->get_one("SELECT COUNT(*) AS guestbookNUM  FROM {$_pre}guestbook  WHERE cuid='$uid'" ));
?>
<!--
<?php
print <<<EOT
-->   
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="leftinfo">
  <tr>
    <td  class="head">
	<span class='L'></span>
	<span class='T'>统计信息</span>
	<span class='R'></span>
	<span class='more'></span>
	
	</td>
  </tr>
  <tr>
    <td  class="content">

	<li>·访客留言共:{$guestbookNUM} 条</li>
	<li>·页面点击量:{$rsdb[hits]} 次</li>

	
	</td>
  </tr>
</table>
<!--
EOT;
?>
-->