<?php
//更新公司横幅设置

if(!$step){

	$conf=$db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid' LIMIT 1");

	if(!table_field("{$_pre}home",'metatitle')){
		$db->query("ALTER TABLE  `{$_pre}home` ADD  `metatitle` VARCHAR( 255 ) NOT NULL , ADD  `metakeywords` VARCHAR( 255 ) NOT NULL , ADD  `metadescription` VARCHAR( 255 ) NOT NULL ;");
	}

}else{

	$metatitle = filtrate($metatitle);
	$metakeywords = filtrate($metakeywords);
	$metadescription = filtrate($metadescription);
	
	$db->query("UPDATE {$_pre}home SET `metatitle`='$metatitle',`metakeywords`='$metakeywords',`metadescription`='$metadescription' WHERE uid='$uid'");

	refreshto("?uid=$uid&atn=$atn","修改成功");	
}
?>