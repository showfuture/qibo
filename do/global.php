<?php
require(dirname(__FILE__)."/../f/global.php");

$IS_BIZ && Limt_IP('AllowVisitIp');		//允许哪些IP访问

unset($listdb,$rs);

//加载JS时的提示语,你可以换成图片,'号要加\
$Load_Msg="<img alt=\"内容加载中,请稍候...\" src=\"$webdb[www_url]/images/default/ico_loading3.gif\">";


?>