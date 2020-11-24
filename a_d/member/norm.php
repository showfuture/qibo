<?php
require("global.php");
@include(Mpath."function.ad.php");

if(!$lfjid){
	showerr("你还没登录");
}

$linkdb=array(
			"广告位列表"=>"?job=list",
			"我购买的广告"=>"?job=mylist"
			);

$array_adtype=array(
					"word"=>"文字广告",
					"pic"=>"图片广告",
					"swf"=>"FLASH广告",
					"code"=>"代码广告",
					"duilian"=>"对联广告",
					"updown"=>"上下收缩广告",
					);

$lfjdb[money]=intval(get_money($lfjdb[uid]));

if($job=='list')
{
	$query = $db->query("SELECT * FROM {$pre}ad_norm_place WHERE ifsale=1 ORDER BY list DESC");
	while($rs = $db->fetch_array($query))
	{
		if($rs[autoyz]){
			$rs[_ifyz]='不必审核';
		}else{
			$rs[_ifyz]='需要审核';
		}

		if($_r=$db->get_one("SELECT * FROM {$pre}ad_norm_user WHERE u_endtime>'$timestamp' AND id='$rs[id]' AND city_id='$city_id'"))
		{
			$_r[u_endtime]=date("Y-m-d H:i",$_r[u_endtime]);
			$rs[state]="{$_r[u_endtime]}过期";
			$rs[alert]="alert('直到{$_r[u_endtime]}以后才可购买');return false;";
			$rs[color]="#ccc;";
		}
		elseif($_r=$db->get_one("SELECT * FROM {$pre}ad_norm_user WHERE u_yz=0 AND id='$rs[id]' AND city_id='$city_id'"))
		{
			$_r[u_endtime]=date("Y-m-d H:i",$_r[u_endtime]);
			$rs[state]="已有人购买,等待审核当中";
			$rs[alert]="alert('已有人购买,你现在不能购买');return false;";
			$rs[color]="#ccc;";
		}
		elseif($rs[isclose]){
			$rs[state]="广告位已关闭";
		}
		else
		{
			$rs[state]="现在可购买";
			$rs[color]="red;";
		}
		$listdb[]=$rs;
	}
	
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/norm/list.htm");
	require(ROOT_PATH."member/foot.php");
}

elseif($job=='buy')
{
	$_r=$db->get_one("SELECT * FROM {$pre}ad_norm_user WHERE u_endtime>'$timestamp' AND id='$id' AND city_id='$city_id'");
	
	if($_r)
	{
		$_r[u_endtime]=date("Y-m-d H:i",$_r[u_endtime]);
		showerr("直到{$_r[u_endtime]}才可购买");
	}

	$rsdb=$db->get_one("SELECT * FROM {$pre}ad_norm_place WHERE id='$id'");
	if(!$rsdb){
		showerr("广告位不存在!");
	}elseif(!$rsdb[ifsale]){
		showerr("当前广告位禁止购买!");
	}elseif($rsdb[isclose]){
		showerr("当前广告位已关闭!");
	}
	if($rsdb[autoyz]){
		$rsdb[_ifyz]='不需管理员审核,直接显示';
	}else{
		$rsdb[_ifyz]='不能立即显示,需要等待管理员审核';
	}
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/norm/buy.htm");
	require(ROOT_PATH."member/foot.php");
}

elseif($action=="buy")
{
	if($atc_day<1)
	{
		showerr("购买的广告不能小于一天");
	}
	$_r=$db->get_one("SELECT * FROM {$pre}ad_norm_user WHERE u_endtime>'$timestamp' AND id='$id' AND city_id='$city_id'");
	if($_r)
	{
		$_r[u_endtime]=date("Y-m-d H:i",$_r[u_endtime]);
		showerr("直到{$_r[u_endtime]}才可购买");
	}
	
	$rsdb=$db->get_one("SELECT * FROM {$pre}ad_norm_place WHERE id='$id'");
	if(!$rsdb){
		showerr("广告位不存在!");
	}elseif(!$rsdb[ifsale]){
		showerr("当前广告位禁止购买!");
	}elseif($rsdb[isclose]){
		showerr("当前广告位已关闭!");
	}

	$totalmoneycard=$u_moneycard=$rsdb[moneycard]*$atc_day;


	if($totalmoneycard>$lfjdb[money])
	{
		showerr("你的{$webdb[MoneyName]}不足$totalmoneycard,你仅有{$webdb[MoneyName]}:$lfjdb[money]");
	}
	$cdb=unserialize($rsdb[adcode]);
	if($rsdb[type]=='pic'){
		//自动截图,把图片截小
		$imgdb=getimagesize(ROOT_PATH."$webdb[updir]/$atc_img");
		if( $imgdb[0]>$cdb[width] || $imgdb[1]>$cdb[height] ){
			gdpic(ROOT_PATH."$webdb[updir]/$atc_img",ROOT_PATH."$webdb[updir]/$atc_img",$cdb[width],$cdb[height],array('fix'=>1));
		}
	}
	
	if($rsdb[type]=='word'){
		$cdb[word]=filtrate($atc_word);
		$cdb[linkurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='pic'||$rsdb[type]=='updown'){
		$cdb[picurl]=filtrate($atc_img);
		$cdb[linkurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='swf'){
		$cdb[flashurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='duilian'){
		$cdb[l_src]=filtrate($l_src);
		$cdb[l_link]=filtrate($l_link);
		$cdb[r_src]=filtrate($r_src);
		$cdb[r_link]=filtrate($r_link);
	}
	$cdb[code]=stripslashes($atc_code);
	$u_code=addslashes(serialize($cdb));

	$u_yz=$rsdb[autoyz];
	if($u_yz)
	{
		$u_begintime=$timestamp-1;
		$u_endtime=$u_begintime+$atc_day*24*3600;
		add_user($lfjuid,-$totalmoneycard,'购买普通广告位');
	}
	else
	{
		$u_begintime=$u_endtime=0;
	}
	$u_hits=0;
	$db->query("INSERT INTO `{$pre}ad_norm_user` ( `id` , `u_uid` , `u_username` , `u_day` , `u_begintime` , `u_endtime` , `u_hits` , `u_yz` , `u_code` , `u_money` , `u_moneycard` , `u_posttime`, `city_id` ) VALUES ('$id','$lfjuid','$lfjid','$atc_day','$u_begintime','$u_endtime','$u_hits','$u_yz','$u_code','$u_money','$u_moneycard','$timestamp','$city_id')");
	make_ad_cache();
	refreshto("?job=list","购买成功,你共支付了{$u_moneycard}{$webdb[MoneyName]}","3");
}

elseif($job=='mylist')
{
	$query = $db->query("SELECT A.*,B.* FROM {$pre}ad_norm_user B LEFT JOIN {$pre}ad_norm_place A ON A.id=B.id WHERE B.u_uid='$lfjuid' ORDER BY B.u_id DESC");
	while($rs = $db->fetch_array($query))
	{
		if($rs[u_yz]&&($rs[u_endtime]-$timestamp)<24*3600)
		{
			$rs[alert]="alert('过期或一天内将要过期的广告不能再修改');return false;";
			$rs[color]="#ccc;";
		}
		else
		{
			$rs[alert]="";
			$rs[color]="red;";
		}

		if($rs[u_yz]){
			$rs[_ifyz]='已审核';
		}else{
			$rs[_ifyz]='<font color=blue>未审核</font>';
		}
		if($rs[u_begintime])
		{
			$rs[u_begintime]=date("Y-m-d H:i",$rs[u_begintime]);
		}
		else
		{
			$rs[u_begintime]='';
		}
		if($rs[u_endtime])
		{
			$rs[u_endtime]=date("Y-m-d H:i",$rs[u_endtime]);
		}
		else
		{
			$rs[u_endtime]='';
		}
		$listdb[]=$rs;
	}
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/norm/mylist.htm");
	require(ROOT_PATH."member/foot.php");
}
elseif($action=="del")
{
	$db->query("DELETE FROM {$pre}ad_norm_user WHERE u_id='$u_id' AND u_uid='$lfjuid'");
	make_ad_cache();
	refreshto("?job=mylist","删除成功","3");
}
elseif($job=='edit')
{
	$rsdb=$db->get_one("SELECT A.*,B.* FROM {$pre}ad_norm_user B LEFT JOIN {$pre}ad_norm_place A ON A.id=B.id WHERE B.u_id='$u_id'");
	@extract(unserialize($rsdb[u_code]));
	if($rsdb[autoyz]){
		$rsdb[_ifyz]='自动通过审核';
	}else{
		$rsdb[_ifyz]='手工审核';
	}
	$id=$rsdb[id];
	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/norm/buy.htm");
	require(ROOT_PATH."member/foot.php");
}

elseif($action=="edit")
{
	if($atc_day<1)
	{
		showerr("购买的广告不能小于一天");
	}
	
	$rsdb=$db->get_one("SELECT A.*,B.* FROM {$pre}ad_norm_user B LEFT JOIN {$pre}ad_norm_place A ON A.id=B.id WHERE B.u_id='$u_id'");

	if($rsdb[u_endtime]<$timestamp)
	{
		showerr("过期广告不能再修改");
	}
	elseif((($rsdb[u_endtime]-$timestamp)<24*3600)&&$atc_day<$rsdb[u_day])
	{
		showerr("今天内将要过期的广告不能把日期改小");
	}
	//$rsdb=$db->get_one("SELECT * FROM {$pre}ad_norm_place WHERE id='$id'");

	$totalmoneycard=$rsdb[moneycard]*$atc_day;
	
	
	$cdb=unserialize($rsdb[adcode]);
	
	if($rsdb[type]=='word'){
		$cdb[word]=filtrate($atc_word);
		$cdb[linkurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='pic'||$rsdb[type]=='updown'){
		$cdb[picurl]=filtrate($atc_img);
		$cdb[linkurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='swf'){
		$cdb[flashurl]=filtrate($atc_url);
	}elseif($rsdb[type]=='duilian'){
		$cdb[l_src]=filtrate($l_src);
		$cdb[l_link]=filtrate($l_link);
		$cdb[r_src]=filtrate($r_src);
		$cdb[r_link]=filtrate($r_link);
	}
	$cdb[code]=stripslashes($atc_code);
	$u_code=addslashes(serialize($cdb));

	$u_yz=$rsdb[autoyz];
	if($rsdb[autoyz])
	{
		$u_begintime=$rsdb[u_begintime];
		$u_endtime=$rsdb[u_endtime]+($atc_day-$rsdb[u_day])*3600*24;

		if(!$rsdb[u_yz])
		{
			if($totalmoneycard>$lfjdb[moneycard])
			{
				showerr("你的{$webdb[MoneyName]}不足$totalmoneycard,你仅有{$webdb[MoneyName]}:$lfjdb[moneycard]");
			}
			
			//$db->query("UPDATE {$pre}memberdata SET moneycard=moneycard-'$totalmoneycard' WHERE uid='$lfjuid'");
		}
		else
		{
			if( $totalmoneycard>($lfjdb[moneycard]+$rsdb[u_moneycard]) )
			{
				showerr("你的{$webdb[MoneyName]}不足,你仅有{$webdb[MoneyName]}:$lfjdb[money]");
			}
			$money=abs($totalmoneycard-$rsdb[u_moneycard]);
			add_user($lfjuid,-$money,'购买普通广告位');
		}			
	}
	else
	{
		if($totalmoneycard>$lfjdb[moneycard])
		{
			showerr("你的{$webdb[MoneyName]}不足$totalmoneycard,你仅有{$webdb[MoneyName]}:$lfjdb[money]");
		}
		$u_begintime=$u_endtime=0;
	}

	$u_hits=0;
	$db->query("UPDATE `{$pre}ad_norm_user` SET `u_day`='$atc_day',`u_begintime`='$u_begintime',`u_endtime`='$u_endtime',`u_yz`='$u_yz',`u_code`='$u_code',`u_moneycard`='$totalmoneycard' WHERE u_id='$u_id' AND u_uid='$lfjuid'");
	
	make_ad_cache();
	refreshto("?job=mylist","修改成功","3");
}


?>