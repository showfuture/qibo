<?php
if(!$FROMURL){
	//die();
}
//$urlstring=mymd5($urlstring,'DE');
$urlstring=filtrate(urldecode($urlstring));

echo "
var www_url='$webdb[www_url]';
document.write(\"<SCRIPT LANGUAGE='JavaScript' src='$webdb[www_url]/images/default/player.js'><\/SCRIPT>\");
playurl='$urlstring';
";