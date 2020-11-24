<?php
//删除图片 POST

if(count($pids)<1) showerr("至少选择一项");
foreach($pids as $pid){
	if($pid){
		$rt=$db->get_one("SELECT url FROM {$_pre}pic WHERE pid='$pid'");
		delete_attachment($uid,tempdir($rt[url]));
		delete_attachment($uid,tempdir("$rt[url].gif"));
		$db->query("DELETE FROM {$_pre}pic WHERE pid='$pid' AND uid='$uid'");
	}
}
refreshto("?atn=piclist&psid=$psid&uid=$uid","删除成功");

?>