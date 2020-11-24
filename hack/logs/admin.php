<?php
!function_exists('html') && exit('ERR');

if($job=="admin_logs"&&$Apower[logs_admin_do_logs])
{
	@include(ROOT_PATH."cache/admin_logs.php");
	if(!$page){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	$max=$min+$rows;
	$total=count($logdb);
	$showpage=getpage("","","index.php?lfj=$lfj&job=$job",$rows,$total);
	for($i=$min;$i<$max;$i++){
		if(!$logdb[$i]){
			break;
		}
		list($rs[uid],$rs[username],$rs[posttime],$rs[ip],$rs[fromurl],$rs[weburl])=explode("\t",$logdb[$i]);
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		$rs[id]=$i;
		$listdb[]=$rs;
	}

	hack_admin_tpl('admin_logs',false);
}
elseif($action=="delete_admin_logs"&&$Apower[logs_admin_do_logs])
{
	if(!$iddb){
		showmsg("请选择一条");
	}
	unset($logdb);
	@include(ROOT_PATH."cache/admin_logs.php");
	$writefile="<?php	\r\n";
	for($i=0;$i<count($logdb);$i++){
		if(!$iddb[$i]){
			$writefile.="\$logdb[]=\"$logdb[$i]\";\r\n";
		}else{
		}
	}
	write_file(ROOT_PATH."cache/admin_logs.php",$writefile);
	jump("删除成功","$FROMURL",1);
}
elseif($job=="login_logs"&&$Apower[logs_login_logs])
{
	@include(ROOT_PATH."cache/adminlogin_logs.php");
	if(!$page){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	$max=$min+$rows;
	$total=count($logdb);
	$showpage=getpage("","","index.php?lfj=$lfj&job=$job",$rows,$total);
	for($i=$min;$i<$max;$i++){
		if(!$logdb[$i]){
			break;
		}
		list($rs[username],$rs[password],$rs[posttime],$rs[ip])=explode("\t",$logdb[$i]);
		$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);
		$rs[id]=$i;
		$listdb[]=$rs;
	}

	hack_admin_tpl('login_logs',false);

}
elseif($action=="delete_adminlogin"&&$Apower[logs_login_logs])
{
	if(!$iddb){
		showmsg("请选择一条");
	}
	unset($logdb);
	@include(ROOT_PATH."cache/adminlogin_logs.php");
	$writefile="<?php	\r\n";
	for($i=0;$i<count($logdb);$i++){
		if(!$iddb[$i]){
			$writefile.="\$logdb[]=\"$logdb[$i]\";\r\n";
		}
	}
	write_file(ROOT_PATH."cache/adminlogin_logs.php",$writefile);
	jump("删除成功","$FROMURL",1);
}
elseif($action=="delalldo"&&$Apower[logs_admin_do_logs])
{
	unlink(ROOT_PATH."cache/admin_logs.php");
	jump("删除成功","$FROMURL",1);
}