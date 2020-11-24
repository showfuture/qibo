<?php
if(!function_exists('html')){
die('F');
}
/*针对每条信息30分钟才允许评分一次*/
$time=$timestamp+30*60;

$pingfenID="pingfenID_$id";
if($_COOKIE[$pingfenID])
{
	showerr("半小时内,不能重复操作!!!");
}
setcookie($pingfenID,"1",$time,"/");

$_web=preg_replace("/http:\/\/([^\/]+)\/(.*)/is","http://\\1",$WEBURL);
if($webdb[Info_forbidOutPost]&&!ereg("^$_web",$FROMURL))
{
	showerr("系统设置不能从外部提交数据");
}

$rsdb=$db->get_one("SELECT M.config AS m_config,C.mid FROM {$_pre}content C LEFT JOIN {$_pre}module M ON C.mid=M.id WHERE C.id='$id' ");

if(!$rsdb[mid])
{
	showerr("此ID有问题");
}
$m_config=unserialize($rsdb[m_config]);
$array=$m_config[field_db];

foreach( $postdb AS $key=>$value)
{
	if($array[$key][form_type]=='pingfen')
	{
		$db->query("UPDATE {$_pre}content_{$rsdb[mid]} SET `$key`=`$key`+'$value' WHERE id='$id' ");
	}
}
header("location:$FROMURL");
exit;
?>