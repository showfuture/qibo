<?php
//删除新闻

$rsdb=$db->get_one("SELECT * FROM `{$_pre}news` WHERE id='$id' ");
if($rsdb[uid]!=$uid)
{
	showerr("你无权删除别人的新闻");
}
//删除附件
delete_attachment($rsdb[uid],$rsdb[content]);
//删除附件
delete_attachment($rsdb[uid],tempdir($rsdb[picurl]) );
$db->query("DELETE FROM `{$_pre}news` WHERE id='$id' AND uid='$uid'");
refreshto("?uid=$uid&atn=news","删除成功");

?>