<?php
if(!function_exists('html')){
	die('F');
}

header('Content-Type: text/html; charset='.WEB_LANG);

$newarray = array_flip($Fid_db[0]);
$array = array_chunk($newarray,2);
echo '<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ShowSortTable" onmouseout="HiddenTdBg(this)">';
$j = 0;
foreach($array AS $ar){
	$j++;
	$trdisplaybg = $j%2 == 0 ? "class = 'havebg'" : "";
	echo "<tr ".$trdisplaybg.">";
	$i = 0;
	foreach($ar AS $fup){
		$i++;
		echo "<td onmouseover='ShowTdBg(this)'>				
				<div class='big_name'><a href='$Mdomain/list.php?fid=$fup' target='_blank'>{$Fid_db['name'][$fup]}</a></div>
				<div class='smll_name'>";
		$y = 0;
		foreach($Fid_db[$fup] AS $fid=>$name){
			$y++;
			$listnum = $webdb[Index_listsortnum]?$webdb[Index_listsortnum]:20;
			if($y>$listnum)break;
			echo " <a href='$Mdomain/list.php?fid=$fid' target='_blank'>{$name}</a> | ";
		}
		echo "<a href='$Mdomain/list.php?fid=$fup' target='_blank' class='more'>¸ü¶à..</a>";

		echo "</div></td>";
	}
	if($i<2){
		echo "<td onmouseover='ShowTdBg(this)'><br/></td>";
	}
    echo '</tr>';
}
echo '</table>';

if($webdb[RewriteUrl]==1){	//È«Õ¾Î±¾²Ì¬
	$content=ob_get_contents();
	ob_end_clean();
	rewrite_url($content);
	echo $content;
}
?>     