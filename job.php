<?php
require(dirname(__FILE__)."/f/global.php");
if(eregi("^([_0-9a-z]+)$",$job)){
	require_once(Mpath."inc/job/$job.php");
}elseif(eregi("^([_0-9a-z]+)$",$action)){
	require_once(Mpath."inc/job/$action.php");
}
?>