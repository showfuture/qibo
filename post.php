<?php
require_once(dirname(__FILE__)."/f/global.php");
@include(ROOT_PATH."data/guide_fid.php");

if($webdb[post_htmlType]==1){
	//以下是为了兼容?方式POST数据
	$detail=explode("&",substr(strstr($WEBURL,'?'),1));
	foreach($detail AS $value){
		$d=explode("=",$value);
		$d[0] && $$d[0]=addslashes($d[1]);
	}
	if($action){
		unset($job);
	}
}

$rs=$db->get_one("SELECT admin FROM {$_pre}city WHERE fid='$_COOKIE[admin_cityid]'");
$detail=explode(',',$rs[admin]);
if($lfjid && in_array($lfjid,$detail)){
	$web_admin=1;
}

if($action!="del"&&$webdb[Info_ClosePost]&&!$web_admin){
	showerr("网站暂停发布/修改信息,原因如下:<br>$webdb[Info_ClosePostWhy]");
}
if($webdb[ForbidPostMember]&&$lfjid){
	$detail=explode("\r\n",$webdb[ForbidPostMember]);
	if(in_array($lfjid,$detail)){
		showerr("你在黑名单列表,无权发表");
	}
}
if($webdb[ForbidPostIp]){
	$detail=explode("\r\n",$webdb[ForbidPostIp]);
	foreach($detail AS $value){
		if($value && ereg("^".$value,$onlineip)){
			showerr("你所在IP属于黑名单列表内,无权发表");
		}
	}
}

if($action=="postnew" && $webdb[forbidPostHour]){
	$webdb[forbidPostHour] = str_replace(array('24','　'),array('0',' '),$webdb[forbidPostHour]);
	$detail=explode(" ",$webdb[forbidPostHour]);
	if(in_array(ceil(date('H',$timestamp)),$detail)){
		showerr("系统设置当前时间段不允许发布新信息");
	}
}

if($action!="del"&&$webdb[GroupPostInfo]){
	$detail=explode(",",$webdb[GroupPostInfo]);
	if(!$web_admin&&in_array($groupdb['gid'],$detail)){
		if(!$lfjid){
			showerr("注册登录之后,才可以发表!");
		}else{
			showerr("你所在用户组,无权发表");
		}	
	}
}

require(ROOT_PATH."inc/class.inc.php");
$Guidedb=new Guide_DB;

if(!$fid){
	unset($listdb,$linkdb);
	$listdb=array();
	list_allsort($fid,0);


	require(Mpath."inc/head.php");
	require(html("pub"));
	require(Mpath."inc/foot.php");
	exit;
}


/**
*获取栏目配置文件
**/
$fidDB=$db->get_one("SELECT * FROM {$_pre}sort WHERE fid='$fid'");

//SEO
$titleDB[title]		= "$fidDB[name] - $webdb[webname]";

/**
*模型参数配置文件
**/
$field_db = $module_DB[$fidDB[mid]][field];
$ifdp = $module_DB[$fidDB[mid]][ifdp];
$m_config[moduleSet][useMap] = $module_DB[$fidDB[mid]][config][moduleSet][useMap];

if($fidDB[type]){
	showerr("大分类,不允许发表内容");
}elseif( $fidDB[allowpost] && $action!="del" && in_array($groupdb[gid],explode(",",$fidDB[allowpost])) ){
	showerr("你所在用户组,无权在本栏目发布信息");
}

//栏目风格
//$fidDB[style] && $STYLE=$fidDB[style];

/*模板*/
$FidTpl=unserialize($fidDB[template]);

$lfjdb[money]=$lfjdb[_money]=intval(get_money($lfjuid));


if(!$lfjid){
	$AllowPicNum = $webdb[Info_GuestPostPicNum]!=''?intval($webdb[Info_GuestPostPicNum]):3;
}elseif(!$web_admin){
	$AllowPicNum = $groupdb[Info_MemberPostPicNum]!=''?intval($groupdb[Info_MemberPostPicNum]):5;
}else{
	$AllowPicNum = 2;
}


if($action=="postnew"||$action=="edit"){
	if($ifdp&&!$postdb[address]){
		showerr("商家地址不能为空!");
	}
	if($webdb[Info_Musttelephone]&&$webdb[Info_Mustmobphone]&&!$postdb[telephone]&&!$postdb[mobphone]){
		showerr("电话号码与手机号码不能同时为空!");
	}else{
		if($webdb[Info_Musttelephone]&&!$postdb[telephone]){
			showerr("电话号码不能为空");
		}
		if($webdb[Info_Mustmobphone]&&!$postdb[mobphone]){
			showerr("手机号码不能为空");
		}
	}	


	if($webdb[Info_MustQQ]&&!$postdb[oicq]){
		showerr("QQ号码不能为空");
	}
	if($webdb[Info_MustEmail]&&!$postdb[email]){
		showerr("Email不能为空");
	}

	if ($postdb[email]&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$postdb[email])) {
		showerr("邮箱不符合规则");
	}
	if ($postdb[msn]&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$postdb[msn])) {
		showerr("MSN不符合规则");
	}
	if ($postdb[oicq]&&!ereg("^[0-9]{5,11}$",$postdb[oicq])) {
		showerr("QQ不符合规则");
	}
	if ($postdb[mobphone]&&!ereg("^[0-9]{11,12}$",$postdb[mobphone])) {
		showerr("手机号码不符合规则");
	}

	if($webdb[Info_cityPost]&&get_cookie("From_City")!=$postdb[city_id]){
		showerr("系统不允许你把信息发在别的城市,只能发在你所在的城市“".$city_DB[name][get_cookie("From_City")]."”");
	}
	$postdb['title']=filtrate($postdb['title']);
}

/**处理提交的新发表内容**/
if($action=="postnew")
{
	check_postnew_power();
	if($buyfid){
		$IndexDay = intval($IndexDay);
		$SortDay = intval($SortDay);
		$BigSortDay = intval($BigSortDay);
		if(in_array('Index',$buyfid) && $webdb['AdInfoIndexRow']>0){
			if($IndexDay<1||$IndexDay>$webdb['AdInfoShowTime']){
				$IndexDay = 1;
			}
			$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$postdb[city_id]' AND sortid=-1 AND endtime>'$timestamp'");
			if($ts['NUM']>=$webdb['AdInfoIndexRow']){
				showerr('首页焦点信息没位置了!');
			}
		}
		if(in_array('Sort',$buyfid) && $webdb['AdInfoListRow']>0){
			if($SortDay<1||$SortDay>$webdb['AdInfoShowTime']){
				$SortDay = 1;
			}
			$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$postdb[city_id]' AND sortid='$fid' AND endtime>'$timestamp'");
			if($ts['NUM']>=$webdb['AdInfoListRow']){
				showerr('列表页/内容页焦点信息没位置了!');
			}
		}
		if(in_array('BigSort',$buyfid) && $webdb['AdInfoListRow']>0){
			if($BigSortDay<1||$BigSortDay>$webdb['AdInfoShowTime']){
				$BigSortDay = 1;
			}
			$ts = $db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}buyad WHERE cityid='$postdb[city_id]' AND sortid='$fidDB[fup]' AND endtime>'$timestamp'");
			if($ts['NUM']>=$webdb['AdInfoListRow']){
				showerr('大分类焦点信息没位置了!');
			}
		}		
	}

	if(!check_rand_num($_POST["$webdb[rand_num_inputname]"])){
		showerr("系统随机码失效,请返回,刷新一下页面,再重新输入数据,重新提交!");
	}

	if(!$postdb[city_id]){
		showerr("请选择城市");
	}

	/*验证码处理*/
	if($webdb[Info_GroupPostYzImg]&&in_array($groupdb['gid'],explode(",",$webdb[Info_GroupPostYzImg]))){	
		if(!$web_admin&&!check_imgnum($yzimg)){		
			showerr("验证码不符合,发布失败");
		}
	}

	$postdb['list']=$timestamp;
	if($iftop){		//推荐置顶
		$TopDay = intval($TopDay);
		if($TopDay<1 || $TopDay>$webdb[Info_TopDay]){
			$TopDay=1;
		}
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}content$_erp` WHERE list>'$timestamp' AND fid='$fid' AND city_id='$postdb[city_id]'"));
		if($webdb[Info_TopNum]&&$NUM>=$webdb[Info_TopNum]){
			showerr("当前栏目置顶信息已达到上限!");
		}
		$postdb['list']+=3600*24*$TopDay;
		if($lfjdb[money]<$webdb[Info_TopMoney]*$TopDay){
			showerr("你的{$webdb[MoneyName]}不足:".$webdb[Info_TopMoney]*$TopDay."{$webdb[MoneyDW]},不能选择置顶");
		}
		$lfjdb[money]=$lfjdb[money]-$webdb[Info_TopMoney]*$TopDay;	//为下面焦点信息做判断积分是否足够
	}

	$time=$timestamp-3600*24;
	$_erp=$Fid_db[tableid][$fid];
	if(!$lfjid){
		if($webdb[Info_GuestDayPostNum]>0){
			if(count(Info_list_content("WHERE ip='$onlineip' AND posttime>$time","","",array_flip($Fid_db[tableid])))>=$webdb[Info_GuestDayPostNum]){
				showerr("游客24小时内最多只能发布{$webdb[Info_GuestDayPostNum]}条免费信息,要想发布更多免费信息,请先登录!");
			}
		}
		if(!$webdb[Info_GuestPostRepeat]){
			if(count(Info_list_content("WHERE ip='$onlineip' AND posttime>$time AND title='$postdb[title]'","","",array_flip($Fid_db[tableid])))){
				showerr("游客一天内不能重复发表雷同信息");
			}
		}
	}elseif(!$web_admin){
		$groupdb[Info_MemberDayPostNum]=='' && $groupdb[Info_MemberDayPostNum] = 10;
		$groupdb[Info_MemberPostMoney]<1 && $groupdb[Info_MemberPostMoney] = 2;

		if(count(Info_list_content("WHERE uid='$lfjuid' AND posttime>$time","","",array_flip($Fid_db[tableid])))>=$groupdb[Info_MemberDayPostNum]){
			if($lfjdb[money]<$groupdb[Info_MemberPostMoney]){
				showerr("普通会员一天内最多只能发布{$groupdb[Info_MemberDayPostNum]}条免费信息");
			}else{
				$delusermoney=1;
			}
		}

		if(!$groupdb[Info_MemberPostRepeat]){
			if(count(Info_list_content("WHERE uid='$lfjuid' AND posttime>$time AND title='$postdb[title]'","","",array_flip($Fid_db[tableid])))){
				showerr("普通会员一天内不能重复发表雷同信息");
			}
		}
	}

	//积分处理
	$money=0;
	if($buyfid){	
		if(in_array('Index',$buyfid)){
			$money+=$webdb[AdInfoIndexShow]*$IndexDay;
		}
		if(in_array('Sort',$buyfid)){
			$money+=$webdb[AdInfoSortShow]*$SortDay;
		}
		if(in_array('BigSort',$buyfid)){
			$money+=$webdb[AdInfoBigsortShow]*$BigSortDay;
		}
	
		if($money>$lfjdb[money]){
			showerr("你的{$webdb[MoneyName]}不足,你的{$webdb[MoneyName]}为:$lfjdb[_money]{$webdb[MoneyDW]}");
		}
	}

	$_web=preg_replace("/http:\/\/([^\/]+)\/(.*)/is","http://\\1",$WEBURL);
	if($webdb[Info_forbidOutPost]&&!ereg("^$_web",$FROMURL)){
		showerr("系统设置不能从外部提交数据");
	}

	if(!$postdb[title]){
		showerr("标题不能为空");
	}elseif(strlen($postdb[title])>80){
		showerr("标题不能大于40个汉字.");
	}
	if(eregi("[a-z0-9]{15,}",$postdb[title])){
		showerr("请认真写好标题!");
	}
	if(eregi("[a-z0-9]{25,}",$postdb[content])){
		showerr("请认真填写内容!");
	}
	
	//自定义字段进行校正检查是否合法
	$Module_db->checkpost($field_db,$postdb,'');

	//上传本地图片
	post_photo();

	unset($num,$postdb[picurl]);
	foreach( $photodb AS $key=>$value ){
		if(!$value || !eregi("(gif|jpg|png)$",$value)){
			continue;
		}
		if($titledb[$key]>100){
			showerr("标题不能大于50个汉字");
		}
		$num++;
		if(!$postdb[picurl]){
			if(is_file(ROOT_PATH."$webdb[updir]/$value.gif")){
				$postdb[picurl]="$value.gif";
			}else{
				$postdb[picurl]=$value;
			}
		}
	}

	$postdb[ispic]=$postdb[picurl]?1:0;

	/*默认都是通过验证*/
	$postdb[yz]=1;
	if($webdb[GroupPassYz]){
		if(!in_array($groupdb[gid],explode(",",$webdb[GroupPassYz]))){
			$postdb[yz]=0;
		}
	}

	//不符合规定的,就设置为待审核
	$MSG=yz_check();

	if($postdb[yz]==1){
		add_user($lfjdb[uid],$webdb[PostInfoMoney],'发布信息积分变动');
	}
	
	//有效期显示多少天
	if($postdb[showday]){
		$postdb[endtime]=$timestamp+$postdb[showday]*86400;
	}

	if($iftop){
		add_user($lfjuid,-intval($webdb[Info_TopMoney]*$TopDay),'置顶信息扣除积分');
	}

	//普通会员,超过免费信息发布上限,则要收费
	if($delusermoney){
		add_user($lfjuid,-intval($groupdb[Info_MemberPostMoney]),'超过免费信息,要收费');
	}

	$postdb[keywords]=Info_keyword_ck($postdb[keywords]);
	
	//信息库
	$db->query("INSERT INTO `{$_pre}db` (`id`,`fid`,`city_id`,`uid`) VALUES ('','$fid','$postdb[city_id]','$lfjdb[uid]')");
	$id=$db->insert_id();

	/*往标题表插入内容*/
	$db->query("INSERT INTO `{$_pre}content$_erp` (`id`, `title` , `mid` , `spid` , `albumname` , `fid` , `fname` , `info` , `hits` , `comments` , `posttime` , `list` , `uid` , `username` , `titlecolor` , `fonttype` , `picurl` , `ispic` , `yz` , `yzer` , `yztime` , `levels` , `levelstime` , `keywords` , `jumpurl` , `iframeurl` , `style` , `head_tpl` , `main_tpl` , `foot_tpl` , `target` , `ishtml` , `ip` , `lastfid` , `money` , `passwd` , `editer` , `edittime` , `begintime` , `endtime` , `config` , `lastview`, `city_id`, `zone_id`, `street_id`, `editpwd`, `showday`, `telephone`, `mobphone`, `email`, `oicq`, `msn` ,`maps`,`picnum`,`address`,`linkman`) 
	VALUES (
	'$id','$postdb[title]','$fidDB[mid]','$spid','','$fid','$fidDB[name]','','','','$timestamp','$postdb[list]','$lfjdb[uid]','$lfjdb[username]','','','$postdb[picurl]','$postdb[ispic]','$postdb[yz]','','','','','$postdb[keywords]','$postdb[jumpurl]','$postdb[iframeurl]','$postdb[style]','$postdb[head_tpl]','$postdb[main_tpl]','$postdb[foot_tpl]','$postdb[target]','$postdb[ishtml]','$onlineip','0','$postdb[money]','$postdb[passwd]','','','$postdb[begintime]','$postdb[endtime]','','$postdb[lastview]','$postdb[city_id]','$postdb[zone_id]','$postdb[street_id]','$postdb[editpwd]','$postdb[showday]','$postdb[telephone]','$postdb[mobphone]','$postdb[email]','$postdb[oicq]','$postdb[msn]','$postdb[maps]','$num','$postdb[address]','$postdb[linkman]')");


	//插入图片
	foreach( $photodb AS $key=>$value ){
		if(!$value || !eregi("(gif|jpg|png)$",$value)){
			continue;
		}
		$titledb[$key]=filtrate($titledb[$key]);
		$value=filtrate($value);
		$db->query("INSERT INTO `{$_pre}pic` ( `id` , `fid` , `mid` , `uid` , `type` , `imgurl` , `name` ) VALUES ( '$id', '$fid', '$mid', '$lfjuid', '0', '$value', '{$titledb[$key]}')");
	}

	//焦点信息扣除积分处理
	if($buyfid)
	{
		add_user($lfjuid,"-$money",'焦点信息扣除积分');
		
		if(in_array('Index',$buyfid)){
			$endtime=$timestamp+$IndexDay*24*3600;
			$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('-1','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
		}
		if(in_array('Sort',$buyfid)){
			$endtime=$timestamp+$SortDay*24*3600;
			$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$fid','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
		}
		if(in_array('BigSort',$buyfid)){
			$endtime=$timestamp+$BigSortDay*24*3600;
			$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$fidDB[fup]','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
		}
	}

	unset($sqldb);
	$sqldb[]="id='$id'";
	$sqldb[]="fid='$fid'";
	$sqldb[]="uid='$lfjuid'";

	/*检查判断辅信息表要插入哪些字段的内容*/
	foreach( $field_db AS $key=>$value){
		isset($postdb[$key]) && $sqldb[]="`{$key}`='{$postdb[$key]}'";
	}

	$sql=implode(",",$sqldb);

	/*往辅信息表插入内容*/
	$db->query("INSERT INTO `{$_pre}content_$fidDB[mid]` SET $sql");

	if(!$MSG){
		$MSG='发表成功';
	}

	$url=get_info_url($id,$fid,$postdb[city_id]);

	//删除缓存;
	del_file(ROOT_PATH."cache/index/$city_id");
	del_file(ROOT_PATH."cache/list/$city_id-$fid");
	refreshto($url,$MSG,1);

}

/*删除内容,直接删除,不保留*/
elseif($action=="del")
{
	$_erp=$Fid_db[tableid][$fid];
	$rsdb=$db->get_one("SELECT A.*,B.* FROM `{$_pre}content$_erp` A LEFT JOIN `{$_pre}content_$fidDB[mid]` B ON A.id=B.id WHERE A.id='$id'");

	if($rsdb[fid]!=$fidDB[fid])
	{
		showerr("栏目有问题");
	}
	if(!$lfjid)
	{
		check_power($rsdb);
	}
	elseif($rsdb[uid]!=$lfjuid&&!$web_admin&&!in_array($lfjid,explode(",",$fidDB[admin])))
	{
		check_power($rsdb);
	}

	del_info($id,$_erp,$rsdb);
	//$db->query(" UPDATE `{$_pre}sort` SET contents=contents-1 WHERE fid='$rsdb[fid]' ");
	//$db->query(" UPDATE `{$_pre}sort` SET contents=contents-1 WHERE fid='$fidDB[fup]' ");

	if($rsdb[yz]){
		add_user($lfjdb[uid],-$webdb[PostInfoMoney]);
	}

	$url=get_info_url('',$rsdb[fid],$rsdb[city_id]);
	refreshto($url,"删除成功");
}

/*编辑内容*/
elseif($job=="edit")
{
	$_erp=$Fid_db[tableid][$fid];
	$rsdb=$db->get_one("SELECT B.*,A.* FROM `{$_pre}content$_erp` A LEFT JOIN `{$_pre}content_$fidDB[mid]` B ON A.id=B.id WHERE A.id='$id'");

	if(!$lfjid){
		check_power($rsdb);
	}elseif($rsdb[uid]!=$lfjuid&&!$web_admin&&!in_array($lfjid,explode(",",$fidDB[admin]))){	
		check_power($rsdb);
		setcookie("editpwd_$id",$_POST[pwd]);
	}
	
	/*表单默认变量作处理*/
	$Module_db->formGetVale($field_db,$rsdb);

	$atc="edit";

	/*
	$query = $db->query("SELECT * FROM `{$_pre}buyad` WHERE id='$id'");
	while($adrs = $db->fetch_array($query)){
		if($adrs[sortid]=='-1'){
			$buyfid['Index']=' checked ';
		}
		if($adrs[sortid]==$fid){
			$buyfid['Sort']=' checked ';
		}
		if($adrs[sortid]==$fidDB[fup]){
			$buyfid['BigSort']=' checked ';
		}
	}
	*/

	$city_id=$rsdb[city_id];
	$zone_id=$rsdb[zone_id];
	$street_id=$rsdb[street_id];

	$city_fid=select_where("{$_pre}city","'postdb[city_id]'  onChange=\"choose_where('getzone',this.options[this.selectedIndex].value,'','1','')\"",$city_id);

	//$rsdb['list']>$timestamp?($ifTop[1]=' checked '):($ifTop[0]=' checked ');

	$rsdb[price]==0&&$rsdb[price]='';

	$query = $db->query("SELECT * FROM {$_pre}pic WHERE id='$id'");
	while($rs = $db->fetch_array($query)){
		$listdb[$rs[pid]]=$rs;
	}
	if(!$listdb){
		$listdb[]='';
	}

	require(Mpath."inc/head.php");
	require(html("post_$fidDB[mid]",$FidTpl['post']));
	require(Mpath."inc/foot.php");
	$content=ob_get_contents();
	ob_end_clean();
	echo str_replace("document.domain","//document.domain",$content);
}

/*处理提交的内容做修改*/
elseif($action=="edit")
{
	if(!$postdb[city_id]){
		showerr("请选择城市");
	}
	$_erp=$Fid_db[tableid][$fid];
	$rsdb=$db->get_one("SELECT A.*,B.* FROM `{$_pre}content$_erp` A LEFT JOIN `{$_pre}content_$fidDB[mid]` B ON A.id=B.id WHERE A.id='$id'");

	if(!$lfjid){	
		if(!$rsdb[editpwd]){
			showerr("你还没有登录");
		}elseif($rsdb[editpwd]!=$editpwd2){
			showerr("管理密码不对!");
		}
	}elseif($rsdb[uid]!=$lfjuid&&!$web_admin&&!in_array($lfjid,explode(",",$fidDB[admin]))){
		if(!$rsdb[editpwd] || ($rsdb[editpwd]!=$editpwd2&&$rsdb[editpwd]!=$_COOKIE["editpwd_$id"])){
			showerr("你无权修改");
		}	
	}

	if(!$postdb[title]){	
		showerr("标题不能为空");
	}
	
	/*
	if($iftop){
		@extract($db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}content$_erp` WHERE list>'$timestamp' AND fid='$fid' AND city_id='$postdb[city_id]'"));
		if($webdb[Info_TopNum]&&$NUM>=$webdb[Info_TopNum]){
			showerr("当前栏目置顶信息已达到上限!");
		}
		if($rsdb['list']<$timestamp){
			if($lfjdb[money]<$webdb[Info_TopMoney]){
				showerr("你的积分不足:$webdb[Info_TopMoney],不能选择置顶");
			}
			$lfjdb[money]=$lfjdb[money]-$webdb[Info_TopMoney];
		}
	}

	$money=0;
	unset($adrs);
	$query = $db->query("SELECT * FROM `{$_pre}buyad` WHERE id='$id'");
	while($rs = $db->fetch_array($query)){
		$adrs[]=$rs[sortid];
	}	
	if(in_array('Index',$buyfid)&&!in_array('-1',$adrs)){
		$money+=$webdb[AdInfoIndexShow];
	}
	if(in_array('Sort',$buyfid)&&!in_array($fid,$adrs)){
		$money+=$webdb[AdInfoSortShow];
	}
	if(in_array('BigSort',$buyfid)&&!in_array($fidDB[fup],$adrs)){
		$money+=$webdb[AdInfoBigsortShow];
	}
	
	if($money>$lfjdb[money]){	
		showerr("你的{$webdb[MoneyName]}不足,你的{$webdb[MoneyName]}为:$lfjdb[_money]{$webdb[MoneyDW]}");
	}
	*/

	//自定义字段进行校正检查是否合法
	$Module_db->checkpost($field_db,$postdb,$rsdb);

	//上传本地图片
	post_photo();

	unset($num,$postdb[picurl]);
	foreach( $photodb AS $key=>$value ){

		if(!$value&&$piddb[$key]){
			$db->query("DELETE FROM `{$_pre}pic` WHERE pid='{$piddb[$key]}' AND id='$id'");
		}

		if(!$value || !eregi("(gif|jpg|png)$",$value)){
			continue;
		}
		$titledb[$key]=filtrate($titledb[$key]);
		$value=filtrate($value);
		if($titledb[$key]>100){
			showerr("标题不能大于50个汉字");
		}
		$num++;
		if($piddb[$key]){		
			$db->query("UPDATE `{$_pre}pic` SET name='{$titledb[$key]}',imgurl='$value' WHERE pid='{$piddb[$key]}' AND id='$id'");
		}else{
			$db->query("INSERT INTO `{$_pre}pic` ( `id` , `fid` , `mid` , `uid` , `type` , `imgurl` , `name` ) VALUES ( '$id', '$fid', '$mid', '$lfjuid', '0', '$value', '{$titledb[$key]}')");
		}
		if(!$postdb[picurl]){
			if(is_file(ROOT_PATH."$webdb[updir]/$value.gif")){
				$postdb[picurl]="$value.gif";
			}else{
				$postdb[picurl]=$value;
			}
		}
	}

	/*判断是否为图片主题*/
	$postdb[ispic]=$postdb[picurl]?1:0;

	if($postdb[showday]){
		if($rsdb[showday]){
			$postdb[endtime]=$rsdb[posttime]+$postdb[showday]*86400;
		}else{
			$postdb[endtime]=$timestamp+$postdb[showday]*86400;
		}
	}

	$SQL='';
	/*
	if($iftop){
		if($rsdb['list']<$timestamp){
			$list=$timestamp+3600*24*$webdb[Info_TopDay];
			$SQL=",list='$list'";
			add_user($lfjuid,-intval($webdb[Info_TopMoney]));
		}	
	}else{
		if($rsdb['list']>$timestamp){
			$SQL=",list='$rsdb[posttime]'";
		}
	}
	*/


	$postdb[keywords]=Info_keyword_ck($postdb[keywords]);

	if(isset($postdb[editpwd])){
		$SQL.=",editpwd='$postdb[editpwd]'";
	}

	/*更新主信息表内容*/
	$db->query("UPDATE `{$_pre}content$_erp` SET title='$postdb[title]',keywords='$postdb[keywords]',spid='$spid',picurl='$postdb[picurl]',ispic='$postdb[ispic]',showday='$postdb[showday]',endtime='$postdb[endtime]',city_id='$postdb[city_id]',zone_id='$postdb[zone_id]',street_id='$postdb[street_id]',telephone='$postdb[telephone]',mobphone='$postdb[mobphone]',email='$postdb[email]',oicq='$postdb[oicq]',msn='$postdb[msn]',address='$postdb[address]',maps='$postdb[maps]',linkman='$postdb[linkman]',picnum='$num'$SQL WHERE id='$id'");


	/*检查判断辅信息表要插入哪些字段的内容*/
	unset($sqldb);
	foreach( $field_db AS $key=>$value){
		$sqldb[]="`$key`='{$postdb[$key]}'";
	}	
	$sql=implode(",",$sqldb);

	/*更新辅信息表*/
	$db->query("UPDATE `{$_pre}content_$fidDB[mid]` SET $sql WHERE id='$id'");
	$db->query("UPDATE `{$_pre}db` SET city_id='$postdb[city_id]' WHERE id='$id' ");

	/*
	add_user($lfjuid,"-$money");
	$endtime=$timestamp+$webdb[AdInfoShowTime]*24*3600;
	if(in_array('Index',$buyfid)&&!in_array('-1',$adrs)){
		$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('-1','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
	}
	if(in_array('Sort',$buyfid)&&!in_array($fid,$adrs)){
		$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$fid','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
	}
	if(in_array('BigSort',$buyfid)&&!in_array($fidDB[fup],$adrs)){
		$db->query("INSERT INTO `{$_pre}buyad` (`sortid`, `cityid`, `id`, `mid`, `uid`, `begintime`, `endtime`, `money`, `hits`) VALUES ('$fidDB[fup]','$postdb[city_id]','$id','$rsdb[mid]','$lfjuid','$timestamp','$endtime','$money','')");
	}

	if(!in_array('Index',$buyfid)&&in_array('-1',$adrs)){
		$db->query("DELETE FROM `{$_pre}buyad` WHERE `sortid`='-1' AND id='$id'");
	}
	if(!in_array('Sort',$buyfid)&&in_array($fid,$adrs)){
		$db->query("DELETE FROM `{$_pre}buyad` WHERE `sortid`='$fid' AND id='$id'");
	}
	if(!in_array('BigSort',$buyfid)&&in_array($fidDB[fup],$adrs)){
		$db->query("DELETE FROM `{$_pre}buyad` WHERE `sortid`='$fidDB[fup]' AND id='$id'");
	}
	*/
	$url=get_info_url($id,$fid,$postdb[city_id]);

	refreshto($url,"修改成功",1);
}
else
{
	check_postnew_power();

	/*模块设置时,有些字段有默认值*/
	foreach( $field_db AS $key=>$rs){	
		if($rs[form_value]){		
			$rsdb[$key]=$rs[form_value];
		}
	}

	/*表单默认变量作处理*/
	$Module_db->formGetVale($field_db,$rsdb);

	/*备用字段,一般不用*/
	$fid_bak1 && $rsdb[fid_bak1]=$fid_bak1;
	$fid_bak2 && $rsdb[fid_bak2]=$fid_bak2;
	$fid_bak3 && $rsdb[fid_bak3]=$fid_bak3;

	$atc="postnew";
	$buyfid[0]=' checked ';
	if(!$city_id){
		$city_id=get_cookie("city_id");
	}
	$city_fid=select_where("{$_pre}city","'postdb[city_id]'  onChange=\"choose_where('getzone',this.options[this.selectedIndex].value,'','1','')\" ",$city_id);

	$ifTop[0]=' checked ';

	$rsdb[linkman]=$lfjid;
	$rsdb[telephone]=$lfjdb[telephone];
	$rsdb[mobphone]=$lfjdb[mobphone];
	$rsdb[email]=$lfjdb[email];
	$rsdb[oicq]=$lfjdb[oicq];
	$rsdb[msn]=$lfjdb[msn];

	$listdb[]='';

	require(Mpath."inc/head.php");
	require(html("post_$fidDB[mid]",$FidTpl['post']));
	require(Mpath."inc/foot.php");
	$content=ob_get_contents();
	ob_end_clean();
	echo str_replace("document.domain","//document.domain",$content);
}


function set_table_value($field_db){
	global $rsdb;
	foreach( $field_db AS $key=>$rs){
		if($rs[form_type]=='select'){
			$detail=explode("\r\n",$rs[form_set]);
			foreach( $detail AS $_key=>$value){
				list($v1,$v2)=explode("|",$value);
				if($rsdb[$key]==$v1){
					unset($rsdb[$key]);
					$rsdb[$key]["$v1"]=' selected ';
				}
			}
		}elseif($rs[form_type]=='radio'){
			$detail=explode("\r\n",$rs[form_set]);
			foreach( $detail AS $_key=>$value){
				list($v1,$v2)=explode("|",$value);
				if($rsdb[$key]==$v1){
					unset($rsdb[$key]);
					$rsdb[$key]["$v1"]=' checked ';
				}
			}
		}elseif($rs[form_type]=='checkbox'){
			$_d=explode("/",$rsdb[$key]);
			unset($rsdb[$key]);
			$detail=explode("\r\n",$rs[form_set]);
			foreach( $detail AS $_key=>$value){
				list($v1,$v2)=explode("|",$value);
				if( @in_array($v1,$_d) ){
					$rsdb[$key]["$v1"]=' checked ';
				}
			}
		}
	}
}


function yz_check(){
	global $webdb,$postdb,$onlineip,$db,$_pre,$timestamp,$lfjuid,$Fid_db,$fid;
	$_erp=$Fid_db[tableid][$fid];
	$Info_YzKeyword=explode("\r\n",$webdb[Info_YzKeyword]);
	$Info_DelKeyword=explode("\r\n",$webdb[Info_DelKeyword]);

	//放入回收站的比较关键,所以要提前先处理
	foreach( $postdb AS $key=>$value){
		foreach( $Info_DelKeyword AS $key2=>$value2){
			if( $value2 && strstr($value,$value2) ){
				$postdb[$key]=str_replace($value2,"**非法文字**",$postdb[$key])."<hr>保持网络纯净，请勿发布非法信息！";
				$postdb[yz]=2;
			}
		}
	}
	if($postdb[yz]==2){
		add_user($lfjuid,-abs($webdb[illInfoMoney]));
		return "内容当中包含有非法文字,本文已被系统自动放入回收站";
	}

	if( $webdb[Info_postCkIp]&&$fromcityid=get_area($onlineip)&&$postdb[city_id] ){
		if($fromcityid!=$postdb[city_id]){
			$postdb[yz]=0;
			return "你选择的城市跟你所在城市不符合,本文需要管理员审核";
		}
	}
	foreach( $postdb AS $key=>$value){
		foreach( $Info_YzKeyword AS $key2=>$value2){
			if(!$value2){
				continue;
			}
			if($webdb[Info_YzKeyword_DO]==1&&strstr(preg_replace("/ |　/is","",$postdb[$key]),$value2)){
				$postdb[yz]=2;
				return "内容当中包含有非法文字,本文已被系统自动放入回收站";
			}elseif($webdb[Info_YzKeyword_DO]==2&&strstr(preg_replace("/ |　/is","",$postdb[$key]),$value2)){
				showerr("内容当中包含有非法文字");
			}else{
				if(strstr(preg_replace("/ |　/is","",$postdb[$key]),$value2)){
					$postdb[$key]=str_replace($value2,"***",preg_replace("/ |　/is","",$postdb[$key]));
				}			
			}		
		}
		if($webdb[Info_PostMaxLeng]&&strlen($value)>$webdb[Info_PostMaxLeng]){
			$postdb[yz]=0;
			return "内容过长,本文需要管理员审核";
		}
	}
	if( $webdb[Info_postCkMob] && $fromcityid=get_mob_cityid($postdb[mobphone]) && $postdb[city_id] ){
		if($fromcityid!=$postdb[city_id]){
			$postdb[yz]=0;
			return "手机号码所在地与你所在城市不符合,本文需要管理员审核";
		}		
	}
}

function get_mob_cityid($phone){
	global $city_DB;
	$mob_area=get_mob_area($phone);
	foreach( $city_DB[name] AS $key2=>$value2 ){
		$value2=str_replace("市","",$value2);
		if(strstr($mob_area,$value2)){
			return $key2;
		}
	}
}


function list_allsort($fid,$Class){
	global $db,$_pre,$listdb,$web_admin,$lfjdb,$lfjid,$webdb,$groupdb;
	$Class++;
	$query=$db->query("SELECT S.*,M.name AS m_name FROM {$_pre}sort S LEFT JOIN {$_pre}module M ON S.mid=M.id where S.fup='$fid' ORDER BY S.list DESC");
	while( $rs=$db->fetch_array($query) ){
		$icon="";
		for($i=1;$i<$Class;$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		$rs[icon]=$icon;

		$rs[allow]=1;
		if( $webdb[GroupPostInfo]&&in_array($groupdb[gid],explode(",",$webdb[GroupPostInfo])) )
		{
			if( !$web_admin&&(!$lfjid||!in_array($lfjid,explode(",",$rs[admin]))) ){
				$rs[allow]=0;
			}
		
		}
		if($rs[allowpost]&&!in_array($groupdb[gid],explode(",",$rs[allowpost]))){
			if(!$web_admin&&(!$lfjid||!in_array($lfjid,explode(",",$rs[admin])))){
				$rs[allow]=0;
			}
		}
		if($rs[type]==2){
			$rs[_alert]="onclick=\"alert('单篇文章下不能有栏目,但分类下可以有栏目');return false;\" style='color:#ccc;'";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('单篇文章下不能有多篇文章内容,也不能发表多篇文章内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}elseif($rs[type]==1){
			$rs[_alert]="";
			$rs[color]="red";
			$rs[_ifcontent]="onclick=\"alert('分类下不能有内容,也不能发表内容,但栏目下可以有内容');return false;\" style='color:#ccc;'";
		}elseif(!$rs[allow]){
			$rs[_alert]="onclick=\"alert('你没权限在本栏目发表内容');return false;\" style='color:#ccc;'";
			$rs[color]="";
			$rs[_ifcontent]="onclick=\"alert('你没权限在本栏目发表内容');return false;\" style='color:#ccc;'";
		}
		$listdb[]=$rs;
		list_allsort($rs[fid],$Class);
	}
}

//上传图片
function post_photo(){
	global $ftype,$fid,$webdb,$photodb,$AllowPicNum,$_pre;

	foreach( $_FILES AS $key=>$value ){
		$i=(int)substr($key,10);
		if(is_array($value)){
			$postfile=$value['tmp_name'];
			$array[name]=$value['name'];
			$array[size]=$value['size'];
		} else{
			$postfile=$$key;
			$array[name]=${$key.'_name'};
			$array[size]=${$key.'_size'};
		}
		if($ftype[$i]=='in'&&$array[name]){

			$jj++;
			if($jj>$AllowPicNum){
				unset($photodb[$i]);
				continue;
			}

			if(!eregi("(gif|jpg|png)$",$array[name])){
				showerr("只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
			}
			$array[path]=$webdb[updir]."/$_pre/$fid";

			$array[updateTable]=1;	//统计用户上传的文件占用空间大小
			$filename=upfile($postfile,$array);
			$photodb[$i]="$_pre/$fid/$filename";

			$smallimg=$photodb[$i].'.gif';
			$Newpicpath=ROOT_PATH."$webdb[updir]/$smallimg";
			gdpic(ROOT_PATH."$webdb[updir]/{$photodb[$i]}",$Newpicpath,300,220,array('fix'=>1));

			/*加水印*/
			if( $webdb[is_waterimg] && $webdb[if_gdimg] )
			{
				include_once(ROOT_PATH."inc/waterimage.php");
				$uploadfile=ROOT_PATH."$webdb[updir]/$photodb[$i]";
				imageWaterMark($uploadfile,$webdb[waterpos],ROOT_PATH.$webdb[waterimg]);
			}
		}
	}
}


function check_power($rs){
	unset($GLOBALS[rs]);
	extract($GLOBALS);

	if(!$rs[editpwd]){
		if(!$lfjid){
			showerr('请先登录!');
		}
		showerr("你无权操作!");
	}
	if($_POST[pwd]&&$_POST[pwd]!=$rs[editpwd]){
		showerr("密码不正确!");	
	}elseif(!$_POST[pwd]){
		require(Mpath."inc/head.php");
print<<<EOT
<form name="form1" method="post" action="">
  <div align="center" style="margin:20px;">请输入本条信息的管理密码: 
    <input type="password" name="pwd" size="15">
    <input type="submit" name="Submit" value="提交">
    <input type="button" name="Submit2" value="返回" onclick="window.location.href='$FROMURL'">
  </div>
</form>
EOT;
		require(Mpath."inc/foot.php");
		exit;
	}
}


function check_postnew_power(){
	global $webdb,$lfjdb,$timestamp,$web_admin;
	if(!$web_admin && $webdb['Info_RegTimePost']>0){
		if(!$lfjdb){
			showerr("必须要注册会员 ".$webdb['Info_RegTimePost']." 小时候后才能发表信息");
		}
		elseif( ($timestamp-$lfjdb['regdate']) < $webdb['Info_RegTimePost']*3600){
			showerr("新注册会员 ".$webdb['Info_RegTimePost']." 小时候后才能发表信息");
		}
	}
}
?>