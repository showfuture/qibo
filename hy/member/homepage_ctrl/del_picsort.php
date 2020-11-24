<?php
//删除分类

if(!$psid) showerr("操作失败");
	
$mypics=$db->get_one("SELECT count(*) AS num FROM {$_pre}pic WHERE psid='$psid'");
if($mypics[num]>0) showerr("图集里边有图片，请先删除图片,再删除图集");
	
$db->query("DELETE FROM {$_pre}picsort WHERE psid='$psid' AND uid='$uid' LIMIT 1");
refreshto("?uid=$uid&atn=pic","删除成功");

?>