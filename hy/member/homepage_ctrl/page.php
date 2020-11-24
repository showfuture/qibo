<?php
//更新公司横幅设置

if(!$step){

	$conf=$db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid' LIMIT 1");

	if(!table_field("{$_pre}home",'page_title')){
		$db->query("ALTER TABLE `{$_pre}home` ADD `page_title` VARCHAR( 100 ) NOT NULL ,ADD `page_content` TEXT NOT NULL ;");
	}

}else{

	$page_content = En_TruePath($page_content,1);	//附件地址转义	
	
	if(!$web_admin){
		//以下三行是过滤JS相关的恶意代码,如果你要使用框架或JS特效的话,就把以下三段删除他
		$page_content = preg_replace('/<(script)([^<>]*)>/i','&lt;\\1\\2>',$page_content);	//过滤js代码
		$page_content = preg_replace('/javascript/i','java script',$page_content);	//过滤js代码
		$page_content = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$page_content);	//过滤框架代码
	}

	$page_title = filtrate($page_title);
	$db->query("UPDATE {$_pre}home SET `page_title`='$page_title',`page_content`='$page_content' WHERE uid='$uid'");

	refreshto("?uid=$uid&atn=$atn","修改成功");	
}
?>