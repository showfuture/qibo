<!--
<?php
$conf[page_content] = En_TruePath($conf[page_content],0,1);
print <<<EOT
-->

<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
  <tr>
    <td  class="head">
	<span class=L></span>
	<span class=T>$conf[page_title]</span>
	<span class=R></span>
	<span class='more'>
<!--
EOT;
if($lfjuid==$uid){
print <<<EOT
-->
	<a href='$webdb[www_url]/member/?main=$Murl/member/homepage_ctrl.php?atn=page' target='_blank'>ÐÞ¸Ä</a>
<!--
EOT;
}
print <<<EOT
-->	
	</span>

	</td>
  </tr>
  <tr>
    <td  class="content">

 
	<div>
	$conf[page_content]
 </div>
<br>
	
	</td>
  </tr>
</table>

 
<!--
EOT;
?>
-->