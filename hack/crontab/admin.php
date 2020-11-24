<?php
!function_exists('html') && exit('ERR');

if(is_file(ROOT_PATH."cache/crontab.php")&&!is_writable(ROOT_PATH."cache/crontab.php")){
	showerr('文件不可写/cache/crontab.php,无法执行定时任务');
}

if($job=='docrontab'&& $Apower[crontab]){
	$db->query("UPDATE {$pre}crontab SET lasttime='$timestamp' WHERE id='$id'");
	$rsdb = $db->get_one("SELECT * FROM {$pre}crontab WHERE id=$id");
	@ignore_user_abort(TRUE);
	set_time_limit(0);
	@include(ROOT_PATH.$rsdb['filepath']);
	die('已执行');
}
elseif($job == "list"&& $Apower[crontab]){
	if(time()-@filemtime(ROOT_PATH.'cache/crontab.php')>120){unlink(ROOT_PATH.'cache/crontab.php');}
	$query = $db->query("SELECT * FROM {$pre}crontab ORDER BY id ASC");
	while($rs = $db->fetch_array($query)){
		$rs[ifstop] = $rs[ifstop] ? "<a href='index.php?lfj=crontab&act=open&id=$rs[id]' style='color:#999'>关闭</a>" : "<a href='index.php?lfj=crontab&act=close&id=$rs[id]' style='color:red'>开启</a>" ;
		if($rs[daytime]){
			$daytimea = substr($rs[daytime],0,2);
			$daytimeb = substr($rs[daytime],-2);
			$rs[daytime] = $daytimea.":".$daytimeb;
		}else{
			$rs[daytime] = "<span style='color:#999'></span>";
		}
		$rs[lasttime] = $rs[lasttime] ? date('Y-m-d H:i',$rs[lasttime]):'';
		$rs[whiletime] = $rs[whiletime] ? date("Y-m-d H:i:s",$rs[whiletime]) : "<span style='color:#999'></span>";
		$listdb[] = $rs;
	}	
}
elseif($act == "edit" && $Apower[crontab]){
	$action = "修改";
	$rsdb = $db->get_one("SELECT * FROM {$pre}crontab WHERE id=$id");
	if($rsdb[daytime]){
		$daytimea = substr($rsdb[daytime],0,2);
		$daytimeb = substr($rsdb[daytime],-2);
		$rsdb[daytime] = $daytimea.":".$daytimeb;
	}else{
		$rsdb[daytime] = "";
	}	
	$rsdb[whiletime] = $rsdb[whiletime] ? date("Y-m-d h:m:s",$rsdb[whiletime]) : "";
	$rsdb[lasttime] = $rsdb[lasttime] ? date("Y-m-d h:m:s",$rsdb[lasttime]) : "";
}
elseif($edit == "yes" && $Apower[crontab]){
	//$daytime = explode(':',$daytime);
	$daytimea = substr($daytime,0,2);
	$daytimeb = substr($daytime,-2);
	$daytimec = $daytimea.$daytimeb;
	//die("$daytime<br>$daytimea<br>$daytimeb<br>$daytimec<br>");
	$whiletime && $whiletime = preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$whiletime);
	$lasttime && $lasttime = preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$lasttime);
	if($sel == 1){
		$daytimec = "";
		$whiletime = "";
		if(!$minutetime)
			showmsg("请输入间隔时间");
	}
	elseif($sel == 2){
		$minutetime = "";
		$whiletime = "";
		if(!$daytime)
			showmsg("每天定时执行的时间");
	}
	elseif($sel == 3){
		$minutetime = "";
		$daytimec = "";
		if(!$whiletime)
			showmsg("每天指定执行的时间");
	}
	if(!$filepath||!is_file(ROOT_PATH.$filepath)){
		showmsg("程序文件不存在");
	}
	$db->query("UPDATE `{$pre}crontab` SET `title` = '$title',`minutetime` = '$minutetime',`daytime` = '$daytimec',`whiletime` = '$whiletime',`filepath` = '$filepath',about='$about',lasttime='$lasttime' WHERE `id` = '$id'");
	jump("修改成功","$FROMURL",1);
}
elseif($act == "post" && $Apower[crontab]){
	$action = "添加";
}
elseif($post == "yes" && $Apower[crontab]){
	$daytimea = substr($daytime,0,2);
	$daytimeb = substr($daytime,-2);
	$daytimec = $daytimea.$daytimeb;
	$whiletime && $whiletime = preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$whiletime);
	$lasttime && $lasttime = preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$lasttime);
	if($sel == 1){
		$daytimec = "";
		$whiletime = "";
		if(!$minutetime)
			showmsg("请输入间隔时间");
	}
	elseif($sel == 2){
		$minutetime = "";
		$whiletime = "";
		if(!$daytime)
			showmsg("每天定时执行的时间");
	}
	elseif($sel == 3){
		$minutetime = "";
		$daytimec = "";
		if(!$whiletime)
			showmsg("每天指定执行的时间");
	}
	if(!$filepath||!is_file(ROOT_PATH.$filepath)){
		showmsg("程序文件不存在");
	}
	$db->query("INSERT INTO `{$pre}crontab` (`title` , `minutetime` , `daytime` , `whiletime` ,`filepath` ,lasttime,about, `ifstop` ) VALUES ('$title', '$minutetime', '$daytimec', '$whiletime','$filepath','$lasttime','$about', '0')");
	jump("添加成功","index.php?lfj=crontab&job=list",1);
}
elseif($act == "open" && $Apower[crontab]){
	$db->query("UPDATE `{$pre}crontab` SET `ifstop` = '0' WHERE `id` = '$id'");
	jump("开启成功","$FROMURL",0);
}
elseif($act == "close" && $Apower[crontab]){
	$db->query("UPDATE `{$pre}crontab` SET `ifstop` = '1' WHERE `id` = '$id'");
	jump("关闭成功","$FROMURL",0);
}
elseif($job=='delete' && $Apower[crontab]){
	$db->query("DELETE FROM `{$pre}crontab` WHERE `id` = '$id'");
	jump("删除成功","$FROMURL",1);
}
hack_admin_tpl('list');



?>