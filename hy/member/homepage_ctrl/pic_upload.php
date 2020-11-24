<?php
//上传图库
$r=$db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}pic` WHERE uid='$uid'");
if(!$web_admin&&$r[NUM]>$groupdb[post_photo_num]){
	if(!$groupdb[post_photo_num]){
		showerr("你所在用户组不允许发布图片,你还需要发布的话,请升级");
	}else{
		showerr("你所在用户组最多允许发布{$groupdb[post_sell_num]}张图片,你还需要发布的话,请升级,或者是删除一些旧的.");
	}
}

if($step==2){
	if(!$psid){
		showerr('请选择一个图集!');
	}
	$ck=0;
	foreach($photoDB[url] AS $key=>$value){
		if(!eregi("\.(gif|jpg|jpeg|png|bmp)$",$value)){
			delete_attachment($uid,tempdir($value));
			continue;
		}
		$picpath = "homepage/pic/".ceil($uid/1000)."/";
		$picurl = $picpath.basename($value);
		move_attachment($uid,tempdir($value),$picpath);	//图片转移目录与加水印
		if(!is_file(ROOT_PATH."$webdb[updir]/$picurl")){
			$picurl=$value;
		}
		
		$Newpicpath=ROOT_PATH."$webdb[updir]/{$picurl}.gif";
		gdpic(ROOT_PATH."$webdb[updir]/$picurl",$Newpicpath,150,150);
		if(!is_file($Newpicpath)){
			copy(ROOT_PATH."$webdb[updir]/{$picurl}",$Newpicpath);
		}

		$title = filtrate($photoDB[name][$key]);
		$title = get_word($title,32);
		$db->query("INSERT INTO `{$_pre}pic` (`psid` , `uid` , `username` ,  `title` , `url` , `level` , `yz` , `posttime` , `isfm` , `orderlist`  ) VALUES ('$psid', '$uid', '$lfjid', '$title', '$picurl', '0', '1', '$timestamp', '0', '0')");
		$ck++;
	}
	if(!$ck){
		showerr('上传图片失败!');
	}
	refreshto("?atn=piclist&uid=$uid&psid=$psid","成功上传{$ck}张图片!",1);
}else{
	$query=$db->query("SELECT * FROM {$_pre}picsort WHERE uid='$uid' ORDER BY orderlist DESC");
	while($rs=$db->fetch_array($query)){
		$listdb[]=$rs;
	}
	$webdb[company_upload_max]=$webdb[company_upload_max]?$webdb[company_upload_max]:8;
	$webdb[company_uploadnum_max]=$webdb[company_uploadnum_max]?$webdb[company_uploadnum_max]:100;	
}


?>