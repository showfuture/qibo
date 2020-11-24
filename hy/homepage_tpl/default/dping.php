<?php
unset($listdb);
function setfen($name,$title,$set){
	$detail=explode("\r\n",$set);
	foreach( $detail AS $key=>$value){
		$d=explode("=",$value);
		$shows.="<option value='$d[0]'>$d[1]</option>\n";
	}
	$shows="<select name='$name' id='$name'>\n<option value=''>-{$title}-</option>\n$shows</select>\n";
	return $shows;
}

$fen1=setfen("fen1",$fendb[fen1][name],$fendb[fen1][set]);
$fen2=setfen("fen2",$fendb[fen2][name],$fendb[fen2][set]);
$fen3=setfen("fen3",$fendb[fen3][name],$fendb[fen3][set]);
$fen4=setfen("fen4",$fendb[fen4][name],$fendb[fen4][set]);
$fen5=setfen("fen5",$fendb[fen5][name],$fendb[fen5][set]);
?>
<!--
<?php
print <<<EOT
-->
<script language="JavaScript">
$(function(){
	$.get("./job.php?job=dianping_ajax&fid=$fid&id=$uid&"+Math.random(),function(d){
		$(".ShowDianpings").html(d);
	});
	$("input[type='radio']").css("border",0); 
	$("input[type='checkbox']").css("border",0); 
});
function getdianpings(url){
	$.get(url+"&"+Math.random(),function(d){
		$(".ShowDianpings").html(d);
	});
}
var limitTime=10;
function post_dianping(){
	var fen1=$("#fen1 option:selected").val();
	var fen2=$("#fen2 option:selected").val();
	var fen3=$("#fen3 option:selected").val();
	var fen4=$("#fen4 option:selected").val();
	var fen5 = $("input[name='fen5']:checked").val()?$("input[name='fen5']:checked").val():"";
	var fen6=",";
	$("input[name='fen6']:checkbox").each(function(){ 
		if($(this).attr("checked")){
			fen6 += $(this).val()+","
		}
	})
	var c_price=$("#c_price").val();
	var yzimg=$("#yzImgNum").val()?$("#yzImgNum").val():"";
	var username=$("#comment_username").val();
	var content=$("#comment_content").val();
	if(content==""){
		alert("内容不能为空");
		return false;
	}
	var urls="./job.php?job=dianping_ajax&action=post&fid=$fid&id=$uid&fen1="+fen1+"&fen2="+fen2+"&fen3="+fen3+"&fen4="+fen4+"&fen5="+fen5+"&fen6="+fen6+"&c_price="+c_price+"&yzimg="+yzimg+"&username="+username+"&content="+content;
	
	limitTime=10;
	limitComment();
	
	$.get(urls+"&"+Math.random(),function(d){
		$(".ShowDianpings").html(d);
		
	});
}
</script>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="rightinfo">
  <tr>
    <td  class="head">
	<span class='L'></span>
	<span class='T'><a href="?uid=$uid&m=dianping">顾客点评</a></span>
	<span class='R'></span>
	<span class='more'>({$rsdb[dianping]}条) <a href='?uid=$uid&m=dianping' >我要点评</a></span>

	
	</td>
  </tr>
  <tr>
    <td class="content contmiddle">

 	
		<div class="ShowDianpings"><div style="padding:10px;text-align:center;"><img src="$webdb[_www_url]/images/default/ico_loading3.gif"/></div></div>
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="postdianping">
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
<!--
EOT;
$display1=$lfjid?" style=\"display:none;\"":"";
print <<<EOT
-->
		  <tr{$display1}>
			<td class="tdL">称呼：</td>
			<td class="tdR"><input type="text" id="comment_username" value="$lfjid"></td>
		  </tr>
		  <tr>
			<td class="tdL">点评：</td>
			<td class="tdR">{$fen1} {$fen2} {$fen3} {$fen4}</td>
		  </tr>
<!--
EOT;
if(!$web_admin){
$webdb[yzImgComment]=1;
print <<<EOT
-->
		  <tr>
			<td class="tdL">验证码：</td>
			<td class="tdR">
				<input id="yzImgNum" type="text" name="yzimg" size="8" onFocus="commentyzimg()">
<SCRIPT LANGUAGE="JavaScript">
<!--
function commentyzimg(){
	if(/yzimg\.php/.test(document.getElementById("yz_Img").src)==false){
		document.getElementById("yz_Img").style.display='';
		document.getElementById("yz_Img").src='$webdb[www_url]/do/yzimg.php?'+Math.random();
	}	
}
document.write('<img border="0" id="yz_Img" name="imageField" onclick="this.src=this.src+Math.random();" src="" style="display:none;">');
//-->
</SCRIPT>
			</td>
		  </tr>
<!--
EOT;
}
print <<<EOT
-->
		  <tr>
			<td class="tdL">内容：</td>
			<td class="tdR">
				<textarea name="textfield" cols="65" rows="8" id="comment_content"></textarea>
			</td>
		  </tr>
<!--
EOT;
if($fendb[fen5][set]&&$fendb[fen5][name]){
print <<<EOT
-->
		  <tr>
			<td class="tdL">{$fendb[fen5][name]}：</td>
			<td class="tdR">
<!--
EOT;
$detail=explode("\r\n",$fendb[fen5][set]);
foreach($detail AS $key=>$value){
$d=explode("=",$value);
print <<<EOT
-->
                  <input type="radio" name="fen5" class="fen5" value="$d[0]"> $d[1] 
<!-- 
EOT;
}
print <<<EOT
-->
			</td>
		  </tr>
<!-- 
EOT;
}print <<<EOT
-->
		  <tr>
			<td class="tdL">人均消费：</td>
			<td class="tdR"><input type="text" name="textfield4" size="5" id="c_price"> 元/人</td>
		  </tr>
<!--
EOT;
if($fendb[fen6][set]&&$fendb[fen6][name]){
print <<<EOT
-->		  <tr>
			<td class="tdL">{$fendb[fen6][name]}：</td>
			<td class="tdR">
<!--
EOT;
$detail=explode("\r\n",$fendb[fen6][set]);
foreach($detail AS $key=>$value){
print <<<EOT
-->
                  <input type="checkbox" name="fen6" value="$value"> $value 
<!-- 
EOT;
}
print <<<EOT
-->
			</td>
		  </tr>
<!-- 
EOT;
}
print <<<EOT
-->
		  <tr>
			<td class="tdL"><br/></td>
			<td class="tdR"><input type="button" id="comment_submit" value="提交" onClick="post_dianping();"/></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		</table> 
	 
</td>
  </tr>
  <tr><td class="foot_td">&nbsp;</td>
  </tr>
</table>
<!--
EOT;
?>
-->