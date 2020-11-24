<?php
//修改图片 POST

if(count($pids)<1) showerr("至少选择一项");
foreach($pids as $pid){
	if($pid){
		//执行
		$db->query("update {$_pre}pic set title='".get_word(htmlspecialchars($title[$pid]),32)."',orderlist='".intval($orderlist[$pid])."' where pid='$pid' AND uid='$uid' limit 1");
	}
}
refreshto("?atn=piclist&psid=$psid&uid=$uid","保存成功");

?>