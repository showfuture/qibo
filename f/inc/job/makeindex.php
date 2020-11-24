<?php
if(!function_exists('html')){
	die('F');
}
if($webdb[Info_MakeIndexHtmlTime]>0)
{
	$time=$webdb[Info_MakeIndexHtmlTime]*60;
	if((time()-@filemtime("index.htm"))>$time)
	{
		echo "<div style='display:none'><iframe src=index.php?MakeIndex=1></iframe></div>";
	}
}

?>