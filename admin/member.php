<?php
!function_exists('html') && exit('ERR');
if($job=="list"&&$Apower[member_list])
{
	if($T=="noyz"){
		$SQL=" WHERE D.yz=0 AND D.uid!=0 ";
	}elseif($T=="yz"){
		$SQL=" WHERE D.yz!=0 AND D.uid!=0 ";
	}elseif($T=="email"){
		$SQL=" WHERE D.email_yz=1 AND D.uid!=0 ";
	}elseif($T=="mob"){
		$SQL=" WHERE D.mob_yz=1 AND D.uid!=0 ";
	}elseif($T=="idcard"){
		$SQL=" WHERE D.idcard_yz=1 AND D.uid!=0 ";
	}elseif($T=="unidcard"){
		$SQL=" WHERE D.idcard_yz=-1 AND D.uid!=0 ";
	}else{
		$SQL=" WHERE 1 ";
	}

	if($groupid){
		$SQL.=" AND D.groupid=$groupid ";
	}
	
	if($keywords&&$type){
		if($type=='username'){
			$SQL.=" AND BINARY D.username LIKE '%$keywords%' ";
		}elseif($type=='uid'){
			$SQL.=" AND D.uid='$keywords' ";
		}
	}
	$select_group=select_group("groupid",$groupid,"index.php?lfj=member&job=list&T=$T");

	if(!$page){
		$page=1;
	}
	$rows=20;
	$min=($page-1)*$rows;
	$showpage=getpage("{$pre}memberdata D","$SQL","index.php?lfj=$lfj&job=$job&type=$type&T=$T&keywords=$keywords&groupid=$groupid",$rows);
	$query=$db->query("SELECT D.* FROM {$pre}memberdata D $SQL ORDER BY D.uid DESC LIMIT $min,$rows ");
	while($rs=$db->fetch_array($query)){
		$rs[lastvist]=$rs[lastvist]?date("Y-m-d H:i:s",$rs[lastvist]):'';
		$rs[regdate]=$rs[regdate]?date("Y-m-d H:i:s",$rs[regdate]):'';
		if(is_file(ROOT_PATH.'inc/ip.dat')){
			$rs[lastip_area] = ipfrom($rs[lastip]);
			$rs[regip_area] = ipfrom($rs[regip]);
		}
		if(!$rs[groupid]){
			$rs[alert]="alert('此用户的资料,还没有在整站激活,你不能进行任何操作!');return false;";
		}else{
			$rs[alert]="";
		}

		if($rs[yz]){
			$rs[yz]="<A HREF='index.php?lfj=$lfj&action=yz&uid_db[0]=$rs[uid]&T=noyz' style='color:red;' onclick=\"$rs[alert]\" title='已经通过审核,点击即可取消审核'><img src='../member/images/check_yes.gif' border='0'></A>";
		}elseif($rs[groupid]){
			$rs[yz]="<A HREF='index.php?lfj=$lfj&action=yz&uid_db[0]=$rs[uid]&T=yz' style='color:blue;' onclick=\"$rs[alert]\" title='还没有通过审核,点击即可通过审核'><img src='../member/images/check_no.gif' border='0'></A>";
		}else{
			$rs[yz]="未激活";
		}
		
		$listdb[]=$rs;
	}
	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/member/menu.htm");
	require(dirname(__FILE__)."/"."template/member/list.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($job=="addmember"&&$Apower[member_addmember])
{
	$select_group=select_group("postdb[groupid]");
	

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/member/menu.htm");
	require(dirname(__FILE__)."/"."template/member/addmember.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="addmember"&&$Apower[member_addmember])
{
	if($postdb[passwd]!=$postdb[passwd2]){
		showmsg("两次输入密码不正确");
	}

	if(!$postdb[groupid]){
		showmsg("请选择一个用户组");
	}elseif($postdb[groupid]=='2'){
		showmsg("你不能选择游客组");
	}elseif($postdb[groupid]=='3'&&$userdb[groupid]!=3&&!$founder){
		showmsg("你无权限选择超级管理员用户组,请更换其他的用户组");
	}elseif($postdb[groupid]=='4'&&$userdb[groupid]!=3&&$userdb[groupid]!=4&&!$founder){
		showmsg("你无权限选择此用户组,请更换其他的用户组");
	}

	$array=array(
		'password' => $postdb[passwd],
		'username' => $postdb[username],
		'groupid' => $postdb[groupid],
		'email' => $postdb[email]
	);
	$uid=$userDB->register_user($array);
	if(!is_numeric($uid)){
		showmsg($uid);
	}	
	
	jump("创建成功","index.php?lfj=member&job=list",3);
}
elseif($job=="editmember"&&$Apower[member_list])
{
	$rsdb=$userDB->get_allInfo($uid);
	
	$rsdb[money]=get_money($rsdb[uid]);
	$select_group=select_group("postdb[groupid]",$rsdb[groupid]);
	$select_group2=group_box("postdb[groups]",explode(",",$rsdb[groups]),1);

	$sexdb[intval($rsdb[sex])]=' checked ';

	$yzdb[intval($rsdb[yz])]=' checked ';

	$ConfigDB=unserialize($rsdb[config]);

	$rsdb[totalspace]=floor($rsdb[totalspace]/(1024*1024));

	$ConfigDB[begintime] && $ConfigDB[begintime]=date("Y-m-d H:i:s",$ConfigDB[begintime]);
	$ConfigDB[endtime]   && $ConfigDB[endtime]=date("Y-m-d H:i:s",$ConfigDB[endtime]);

	$email_yz[$rsdb[email_yz]]=' checked ';
	$mob_yz[$rsdb[mob_yz]]=' checked ';
	$idcard_yz[$rsdb[idcard_yz]]=' checked ';

	require(dirname(__FILE__)."/"."head.php");
	require(dirname(__FILE__)."/"."template/member/menu.htm");
	require(dirname(__FILE__)."/"."template/member/editmember.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="editmember"&&$Apower[member_list])
{
	
	$rsdb=$userDB->get_info($uid);
	if(!$rsdb[username]){
		showmsg("此用户资料不存在,或者帐号还没激活");
	}

	require_once(ROOT_PATH."data/level.php");
	if($memberlevel[$postdb[groupid]]){
		if(!$webdb[groupUpType]&&$postdb[money]<$memberlevel[$postdb[groupid]]){
			showmsg("{$ltitle[$postdb[groupid]]}是会员组,而当前用户的积分不足{$memberlevel[$postdb[groupid]]},所以你不能设置为此组");
		}elseif($webdb[groupUpType]&&!$ConfigDB[endtime]){
			showmsg("{$ltitle[$postdb[groupid]]}是会员组,你必须为他指定有效日期!");
		}
	}
	
	if($rsdb[groupid]=='3'&&$userdb[groupid]!=3&&!$founder&&!$ForceEnter){
		showmsg("你无权限修改超级管理员用户组");
	}elseif($rsdb[groupid]=='4'&&$userdb[groupid]!=3&&$userdb[groupid]!=4&&!$founder&&!$ForceEnter){
		showmsg("你无权限修改此用户组");
	}elseif(!$postdb[groupid]){
		showmsg("请选择一个用户组");
	}elseif($postdb[groupid]=='2'){
		showmsg("你不能选择游客组");
	}elseif($postdb[groupid]=='3'&&$userdb[groupid]!=3&&!$founder&&!$ForceEnter){
		showmsg("你无权限选择超级管理员用户组,请更换其他的用户组");
	}elseif($postdb[groupid]=='4'&&$userdb[groupid]!=3&&$userdb[groupid]!=4&&!$founder&&!$ForceEnter){
		showmsg("你无权限选择此用户组,请更换其他的用户组");
	}

	//自定义用户字段
	require_once("../do/regfield.php");
	ck_regpost($postdb);

	$ConfigDB[begintime]&&$ConfigDB[begintime]=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$ConfigDB[begintime]);

	$ConfigDB[endtime]&&$ConfigDB[endtime]=preg_replace("/([\d]+)-([\d]+)-([\d]+) ([\d]+):([\d]+):([\d]+)/eis","mk_time('\\4','\\5', '\\6', '\\2', '\\3', '\\1')",$ConfigDB[endtime]);

	$array=unserialize($rsdb[config]);
	foreach( $ConfigDB AS $key=>$value){
		$array[$key]=$value;
	}
	$postdb[config]=addslashes(serialize($array));

	if($postdb[newpassword]){
		$postdb[password] = $postdb[newpassword];
	}else{
		unset($postdb[password]);
	}

	$postdb[totalspace]=$postdb[totalspace]*1024*1024;

	$postdb[groups]=implode(",",$postdb[groups]);
	if($postdb[groups]){
		$postdb[groups]=",$postdb[groups],";
	}
	
	$array=$postdb;
	unset($array[money]);
	$array[username]=$rsdb[username];
	$array[email_yz] = $email_yz;
	$array[mob_yz] = $mob_yz;
	$array[idcard_yz] = $idcard_yz;
	$userDB -> edit_user($array);

	$rsdb[money]=get_money($uid);

	add_user( $uid , ($postdb[money]-$rsdb[money]) ,'管理员操作');

	//自定义用户字段
	Reg_memberdata_field($uid,$postdb);

	jump("修改成功","index.php?lfj=member&job=editmember&uid=$uid");
	
}
elseif($action=="delete"&&$Apower[member_list])
{
	if(!$uid_db&&$uid){
		$uid_db[]=$uid;
	}
	foreach($uid_db AS $uid){
		$rsdb=$userDB->get_info($uid);
		if($rsdb[groupid]==3&&$userdb[groupid]!=3){
			showmsg("你无权删除超级管理员");
		}
		if($uid==$lfjdb[uid]){
			showmsg("你不能删除自己");
		}
		$userDB->delete_user($uid);
	}
	jump("删除成功","index.php?lfj=member&job=list");
}
elseif($job=="pwd"&&$Apower[member_list])
{
	require(dirname(__FILE__)."/"."head.php");
	//require("template/member/menu.htm");
	require(dirname(__FILE__)."/"."template/member/pwd.htm");
	require(dirname(__FILE__)."/"."foot.php");
}
elseif($action=="yz"&&$Apower[member_list])
{
	if($T=='yz'){
		$yz=1;
	}else{
		$yz=0;
	}
	foreach( $uid_db AS $key=>$uid){
		$rs=$userDB->get_info($uid);
		if($yz==0){			
			if($rs[groupid]==3||$rs[groupid]==4){
				showmsg("你不可以设置管理员为未审核");
			}
		}
		$array=array('username'=>$rs[username],'yz'=>$yz);		
		$userDB->edit_user($array);;
	}
	jump('处理完毕',$FROMURL,0);
}
elseif($action=="unbind"&&$Apower[member_list])
{
	$db->query("UPDATE {$pre}memberdata SET qq_api='' WHERE uid='$uid'");
	jump('解绑成功!',$FROMURL,0);
}
?>