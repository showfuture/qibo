<?php
//设置封面 

if(count($pids)<1) showerr("请选择一张图片");
if(!$psid) showerr("请指定一个图集");

foreach($pids as $pid){
	if($pid){
		$rt=$db->get_one("SELECT url FROM {$_pre}pic WHERE pid='$pid'");
		$db->query("UPDATE {$_pre}picsort SET faceurl='$rt[url]' WHERE psid='$psid' AND uid='$uid'");
		break;
	}
}
refreshto("?atn=piclist&psid=$psid&uid=$uid","设置成功");

?>