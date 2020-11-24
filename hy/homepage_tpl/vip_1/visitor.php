<!--
<?php
print <<<EOT
-->   
    
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo yellowstyle">
  <tr>
    <td class="head"><span class='L'></span>
	<span class='T'>·Ã¿Í×ã¼£</span>
	<span class='R'></span>
	<span class='more'></span></td>
  </tr>
  <tr>
    <td  class="content">
<!--
EOT;
$conf[listnum][visitor]=$conf[listnum][visitor]?$conf[listnum][visitor]:40;
$array=explode("\r\n",$conf[visitor]);
foreach( $array AS $key=>$value){
	if($key>=$conf[listnum][visitor]){
		break;
	}
	list($u_id,$u_name,$u_time)=explode("\t",$value);
	if($u_id==0){
		$u_name=preg_replace("/([\d]+)\.([\d]+)\.([\d]+)\.([\d]+)/is","\\1.\\2.\\3.*",$u_name);
	}
	$u_time=date("m-d H:i",$u_time);
	if(!$u_name){
		continue;
	}
@extract($db->get_one("SELECT icon FROM `{$pre}memberdata` WHERE uid='$u_id'"));
$icon=tempdir($icon);

	if($u_id){
	$uuuu="$webdb[www_url]/member/homepage.php?uid=$u_id";
	}else{
	$uuuu="javascript:;";
	}
if($mod_in=='left'){
print <<<EOT
-->
	¡¤<a href="$uuuu" >{$u_name} ({$u_time})</a><br>
<!--
EOT;
}else{
print <<<EOT
-->
	<table class="listuser">
	<tr>
		<td class="img"><a href="$uuuu"  target="_blank"><img src="$icon"  border="0"  onload="if(this.width>60)this.width=60;"  class="logo" onerror="this.src='$webdb[www_url]/images/default/noface.gif';"/></a></td>
		<td>
		<span class="name"><a href="$uuuu" target="_blank">{$u_name}</a></span>
		<span class="time">{$u_time}</span>
		</td>
	</tr>
	</table>
<!--
EOT;
}}
print <<<EOT
-->
	
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<!--
EOT;
?>
-->