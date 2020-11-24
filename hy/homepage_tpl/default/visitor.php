<!--
<?php
print <<<EOT
-->   
    
<table width="100%" border="0" cellspacing="0" cellpadding="0"  class="rightinfo">
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
	if($u_id){
	$uuuu="?uid=$u_id";
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
	<li class='visitor' style="float:left; width:200px; height:20px; margin:2px; text-align:left; line-height:20px;">¡¤<a href="$uuuu" >{$u_name} ({$u_time})</a></li> 
<!--
EOT;
}}
print <<<EOT
-->
	
	</td>
  </tr>
</table>
<!--
EOT;
?>
-->