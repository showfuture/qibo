<!--
<?php
$conf[page_content] = En_TruePath($conf[page_content],0,1);
print <<<EOT
-->
<div class="maincont1">
	<div class="head">
		<div class="tag">$conf[page_title]</div>
		<div class="more">&nbsp;
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
		</div>
	</div>
	<div class="cont">
		 $conf[page_content]
	</div>
</div> 
<!--
EOT;
?>
-->