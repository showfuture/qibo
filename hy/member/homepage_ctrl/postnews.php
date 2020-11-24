<?php
//发布与修改新闻

if(!$id&&!$web_admin){

	if(!$groupdb[post_news_num]){
		showerr("你所在用户组不允许发布新闻,你还需要发布的话,请升级");
	}

	$r=$db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}news WHERE uid='$uid'");
	if($r[NUM]>=$groupdb[post_news_num]){		
		showerr("你所在用户组最多允许发布{$groupdb[post_news_num]}条新闻,你还需要发布的话,请升级,或者是删除一些旧的.");
	}
}

if(!$step){	
	if($id){
		$news=$db->get_one("SELECT * FROM {$_pre}news WHERE id='$id'");
	
		//真实地址还原
		$news[content]=En_TruePath($news[content],0);
	}
	$rsdb[bd_pics]=$news[bd_pics];
}else{
	$title=filtrate($title);
	if(strlen($title)<10 || strlen($title)>60) showerr("标题只能在5-30个字");
	if(!$content) showerr("内容不能为空");
	if(strlen($content)>50000) showerr("内容过长，最多50000字符(包括HTML代码)");
	
	$content = preg_replace('/javascript/i','java script',$content);//过滤js代码
	$content = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$content);//过滤框架代码
	$content =En_TruePath($content,1);

	$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid' LIMIT 1");
	if(!$rsdb) showerr("商家信息未登记");

	if($id){
	
		$db->query("UPDATE `{$_pre}news` SET `title`='$title',`content`='$content' WHERE id='$id'");
	
	}else{
		$db->query("INSERT INTO `{$_pre}news` ( `id` , `title` , `content` , `hits` , `posttime` , `list` , `uid` , `username` ,  `titlecolor` , `fonttype` , `picurl` , `ispic` , `yz` ) VALUES ('', '$title', '$content', '0', '$timestamp', '0', '$uid', '$lfjid',  '', '0', '', '0', '1');");
		$id=$db->insert_id();
	}
	//更新绑定图片	
	bd_pics("{$_pre}news"," where id='$id' ");

	refreshto("?uid=$uid&atn=news","提交成功");
}

?>