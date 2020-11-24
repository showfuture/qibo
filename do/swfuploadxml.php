<?php
require_once(dirname(__FILE__)."/"."global.php");
header("Content-type: application/xml");
$string='';
$detail=explode(",",$filetype);
foreach($detail AS $key=>$value){
	if($value){
		$string.="<items>$value</items>\r\n";
	}
}
$uploadMax=intval(ini_get('upload_max_filesize')?ini_get('upload_max_filesize'):'2');
$str=str_replace('+','%2B',mymd5("$lfjid\t$lfjuid"));
echo '<?xml version="1.0" encoding="utf-8"?>';
print <<<EOT

<sapload>
	<config>
		<upLoadUrl>$webdb[www_url]/do/swfupload.php</upLoadUrl>
		<maxNum>100</maxNum>
		<upMaxbig>$uploadMax</upMaxbig>
		<fileType>
			$string
		</fileType>
		<arguments>
			<items atr="str">$str</items>
		</arguments>
	</config>
</sapload>

EOT;

?>