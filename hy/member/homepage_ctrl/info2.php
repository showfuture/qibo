<?php
//更新公司介绍
if(!$step){
	@extract($intro=$db->get_one("SELECT * FROM `{$_pre}company` WHERE `uid`='$uid'"));
	//真实地址还原
	$content=En_TruePath($content,0);
	$content=editor_replace($content);
	$rsdb[bd_pics]=$intro[bd_pics];
}else{
	if(!$content){
		showerr("内容不能为空");
	}
	
	$content = preg_replace('/javascript/i','java script',$content);//过滤js代码
	$content =	preg_replace('/<(script)([^<>]*)>/i','&lt;\\1\\2>',$content);
	$content = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$content);//过滤框架代码
	$content=En_TruePath($content,1);
	$db->query("UPDATE `{$_pre}company` SET `content`='$content' WHERE uid='$uid'");

	//更新绑定图片	
	bd_pics("{$_pre}company","WHERE  uid='$uid'");
	
	refreshto("?uid=$uid&atn=$atn","修改成功");
	
}

?>