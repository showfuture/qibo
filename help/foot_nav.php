<?php
require_once(dirname(__FILE__)."/global.php");
@include(dirname(__FILE__)."/data/guide_fid.php");

$forum_ups="<A HREF='$Murl/'>Ê×Ò³</A>".$GuideFid[$fid];
require_once(getTpl("foot_nav"));
?>