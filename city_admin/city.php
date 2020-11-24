<?php
require_once(dirname(__FILE__)."/global.php");

$postdb[descrip]=filtrate($postdb[descrip]);
$postdb[metakeywords]=filtrate($postdb[metakeywords]);
$postdb[metadescription]=filtrate($postdb[metadescription]);

if($step==2){
	$db->query("UPDATE {$pre}fenlei_city SET descrip='$postdb[descrip]',metakeywords='$postdb[metakeywords]',metadescription='$postdb[metadescription]' WHERE fid='$city_id'");
	refreshto("$FROMURL","ÉèÖÃ³É¹¦",1);
}

require(dirname(__FILE__)."/head.php");
require(dirname(__FILE__)."/template/city.htm");
require(dirname(__FILE__)."/foot.php");
?>