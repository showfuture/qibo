<?php

$filename = dirname(__FILE__)."/../cache/crontab.php";

@ignore_user_abort(TRUE);
if(@set_time_limit(0)){
	$wait_time=1800;
}else{
	$wait_time=30;
}

if(time()-@filemtime($filename)>$wait_time){	//如果某段时间内没被修改过,那就可能线程已死掉

	require_once(dirname(__FILE__)."/global.php");
	$cdo = true;
	do{
		if(!touch($filename)){
			die('文件不可写/cache/crontab.php');
		}
		$cdo = false;
		$times = time();
		$query = $db->query("SELECT * FROM {$pre}crontab WHERE ifstop=0");
		while($rs = $db->fetch_array($query)){
			$cdo = true;
			$run=0;
			if($rs[minutetime]){	//每隔几分钟执行一次
				if($times-$rs[lasttime]>$rs[minutetime]*60){
					$run++;
				}
			}elseif($rs[daytime]){	//每天执行一次,时+分格式如 1403
				if(date("md",$rs[lasttime])!=date("md",$times)&&date("Hi",$times)>$rs[daytime]){
					$run++;
				}

				if(date("md",$rs[lasttime])==date("md",$times)&&date("Hi",$rs[lasttime])<$rs[daytime]){
					$run++;
				}
			}elseif($rs[whiletime]){	//未来某个时间的,只执行一次
				if($rs[lasttime]<$rs[whiletime]&&$times>$rs[whiletime]){
					$run++;
				}
			}
			if($run){
				$db->query("UPDATE {$pre}crontab SET lasttime='$times' WHERE id='$rs[id]'");
				@include(ROOT_PATH."$rs[filepath]");				
			}			
		}

		sleep(50);	//休息50秒执行一次
	}while($cdo);	
}

?>qibo