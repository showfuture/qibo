<?php
header('Content-Type: text/html; charset='.WEB_LANG);

$_erp=$Fid_db[tableid][$fid];

/**
*处理用户提交的评论
**/
if($action=="post")
{	
	if( !table_field("{$_pre}content$_erp",'replytime') ){
		$db->query("ALTER TABLE `{$_pre}content$_erp` ADD `replytime` INT( 10 ) NOT NULL");
	}

	$_web=preg_replace("/http:\/\/([^\/]+)\/(.*)/is","http://\\1",$WEBURL);
	if($webdb[Info_forbidOutPost]&&!ereg("^$_web",$FROMURL))
	{
		showerr("系统设置不能从外部提交数据");
	}
	
	/*验证码处理*/
	if($webdb[Info_GroupCommentYzImg]&&in_array($groupdb['gid'],explode(",",$webdb[Info_GroupCommentYzImg])))
	{
		if(!check_imgnum($yzimg)){		
			die("验证码不符合,评论失败");
		}
	}

	if(!$content){	
		die("内容不能为空");
	}


	/*是否允许评论判断处理*/
	/*禁止所有人进行评论*/
	if($webdb[forbidComment])
	{
		$allow=0;
	}
	/*禁止游客评论*/
	elseif(!$webdb[allowGuestComment]&&!$lfjid)
	{
		$allow=0;
	}
	/*允许所有人评论*/
	else
	{
		$allow=1;
	}
	
	

	/*是否允许评论自动通过审核判断处理*/
	$yz=1;
	if($webdb[CommentPass_group]&&!in_array($groupdb[gid],explode(",",$webdb[CommentPass_group]))){	
		$yz=0;
	}


	$username=filtrate($username);
	$content=filtrate($content);
	$c_price=filtrate($c_price);
	$c_keywords=filtrate($c_keywords);
	$c_keywords2=filtrate($c_keywords2);

	$content=str_replace("@@br@@","<br>",$content);

	//过滤不健康的字
	$username=replace_bad_word($username);
	$content=replace_bad_word($content);

	//处理有人恶意用他人帐号做署名的
	if($username)
	{
		$rs=$userDB->get_info($username,'username');
		if($rs[uid]!=$lfjuid)
		{
			$username="匿名";
		}
	}
	
	$rss=$db->get_one(" SELECT * FROM {$_pre}content$_erp WHERE id='$id' ");
	if(!$rss){
		die("原数据不存在");
	}
	$fid=$rss[fid];

	$username || $username=$lfjid;

	$fen6==',' && $fen6='';


	/*如果系统做了限制,那么有的评论将不给提交成功,但没做提示评论失败*/
	if($allow)
	{

		if(is_utf8($content)||is_utf8($username)){
			$content=utf82gbk($content);
			$username=utf82gbk($username);
		}
		if(WEB_LANG=='utf-8'){
			$content=gbk2utf8($content);
			$username=gbk2utf8($username);
		}elseif(WEB_LANG=='big5'){
			require_once(ROOT_PATH."inc/class.chinese.php");
			$cnvert = new Chinese("GB2312","BIG5",$content,ROOT_PATH."./inc/gbkcode/");
			$content = $cnvert->ConvertIT();

			$cnvert = new Chinese("GB2312","BIG5",$username,ROOT_PATH."./inc/gbkcode/");
			$username = $cnvert->ConvertIT();
		}

		//关键字检查整理
		//$c_keywords=keyword_ck($c_keywords);
		//$c_keywords2=keyword_ck($c_keywords2);

		$db->query("INSERT INTO `{$_pre}dianping` (`cuid`, `type`, `id`, `fid`, `uid`, `username`, `posttime`, `content`, `ip`, `icon`, `yz`, `fen1`, `fen2`, `fen3`, `fen4`, `fen5`, `price`, `keywords`, `keywords2`, `fen6`) VALUES ('$rss[uid]','0','$id','$fid','$lfjuid','$username','$timestamp','$content','$onlineip','$icon','$yz','$fen1','$fen2','$fen3','$fen4','$fen5','$c_price','$c_keywords','$c_keywords2','$fen6')");

		$db->query(" UPDATE {$_pre}content$_erp SET comments=comments+1,`replytime`='$timestamp' WHERE id='$id' ");
		//关键字标签处理
		//keyword_add($id,$c_keywords,0);
		//keyword_add($id,$c_keywords2,$rss[mid]);
		//if($fen6){
		//	$fen6=str_replace(","," ",$fen6);
		//	keyword_add($id,$fen6,0);
		//}
		//更新分值
		//update_fen($id);
	}
}

/*删除留言*/
elseif($action=="del")
{
	$rs=$db->get_one("SELECT * FROM `{$_pre}dianping` WHERE cid='$cid'");
	if(!$lfjuid)
	{
		die("你还没登录,无权限");
	}
	elseif(!$web_admin&&$rs[uid]!=$lfjuid&&$rs[cuid]!=$lfjuid)
	{
		die("你没权限");
	}
	if(!$web_admin&&$rs[uid]!=$lfjuid){
		$lfjdb[money]=get_money($lfjdb[uid]);
		if(abs($webdb[DelOtherCommentMoney])>$lfjdb[money]){
			die("你的{$webdb[MoneyName]}不足");
		}
		add_user($lfjdb[uid],-abs($webdb[DelOtherCommentMoney]));
	}
	$db->query(" DELETE FROM `{$_pre}dianping` WHERE cid='$cid' ");
	$db->query("UPDATE {$_pre}content$_erp SET comments=comments-1 WHERE id='$rs[id]' ");
	
	//标签处理
	//if($rs[fen6]){
	//	$rs[fen6]=str_replace(","," ",$rs[fen6]);
	//}
	//keyword_del($rs[id],"$rs[keywords] $rs[keywords2] $rs[fen6]");
	//更新分值
	//update_fen($rs[id]);
}
/*鲜花鸡蛋处理*/
elseif($action=="flowers"||$action=="egg")
{
	if(get_cookie("{$action}_$cid")){
		echo "请不要重复操作!!<hr>";
	}else{
		set_cookie("{$action}_$cid",1,3600);
		$db->query("UPDATE `{$_pre}dianping` SET `$action`=`$action`+1 WHERE cid='$cid'");
	}
}
/**
*是否只显示通过验证的评论,或者是全部显示
**/
if(!$webdb[showNoPassComment])
{
	$SQL=" AND yz=1 ";
}
else
{
	$SQL="";
}

/**
*每页显示评论条数
**/
$rows=$webdb[showCommentRows]?$webdb[showCommentRows]:8;

if($page<1)
{
	$page=1;
}
$min=($page-1)*$rows;


//$rsdb=$db->get_one("SELECT M.* FROM {$_pre}sort S LEFT JOIN {$_pre}module M ON S.mid=M.id WHERE S.fid='$fid'");

$fendb = $module_DB[$Fid_db[mid][$fid]][config2];
$fendb[fen1][name] || $fendb[fen1][name]="总评";
$fendb[fen2][name] || $fendb[fen2][name]="环境";
$fendb[fen3][name] || $fendb[fen3][name]="服务";
$fendb[fen4][name] || $fendb[fen4][name]="价位";
$fendb[fen5][name] || $fendb[fen5][name]="喜欢程度";

$fendb[fen1][set] || $fendb[fen1][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen2][set] || $fendb[fen2][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen3][set] || $fendb[fen3][set]="1=差\r\n2=一般\r\n3=好\r\n4=很好\r\n5=非常好";
$fendb[fen4][set] || $fendb[fen4][set]="1=便宜\r\n2=适中\r\n3=贵\r\n4=很贵";
$fendb[fen5][set] || $fendb[fen5][set]="1=不喜欢\r\n2=无所谓\r\n3=喜欢\r\n4=很喜欢";


/*评论字数再多也只限制显示1000个字*/
$leng=1000;

$query=$db->query("SELECT SQL_CALC_FOUND_ROWS * FROM `{$_pre}dianping` WHERE id=$id $SQL ORDER BY cid DESC LIMIT $min,$rows");
$RS=$db->get_one("SELECT FOUND_ROWS()");
$totalNum=$RS['FOUND_ROWS()'];
while( $rs=$db->fetch_array($query) )
{
	$rs[fen]='';
	$rs[fen].=fen_value($fendb[fen1][name],$fendb[fen1][set],$rs[fen1]);
	$rs[fen].=fen_value($fendb[fen2][name],$fendb[fen2][set],$rs[fen2]);
	$rs[fen].=fen_value($fendb[fen3][name],$fendb[fen3][set],$rs[fen3]);
	$rs[fen].=fen_value($fendb[fen4][name],$fendb[fen4][set],$rs[fen4]);
	$rs[fen].=fen_value($fendb[fen5][name],$fendb[fen5][set],$rs[fen5]);
	$rs[fen6]=fen6_value($fendb[fen6][name],$fendb[fen6][set],$rs[fen6]);

	if(!$rs[username])
	{
		$detail=explode(".",$rs[ip]);
		$rs[username]="$detail[0].$detail[1].$detail[2].*";
	}

	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);

	$rs[full_content]=$rs[content];

	$rs[content]=get_word($rs[content],$leng);

	if($rs[type]){
		$rs[content]="<img style='margin-top:3px;' src=$webdb[www_url]/images/default/good_ico.gif> ".$rs[content];
	}

	$rs[content]=str_replace("\n","<br>",$rs[content]);

	if($rs[keywords]){
		unset($array);
		$detail=explode(" ",$rs[keywords]);
		foreach( $detail AS $key=>$value){
			$_value=urlencode($value);
			$array[]="<A HREF='search.php?action=search&type=keyword&keyword=$_value' target=_blank>$value</A>";
		}
		$rs[keywords]=implode(" ",$array);
	}
	if($rs[keywords2]){
		unset($array);
		$detail=explode(" ",$rs[keywords2]);
		foreach( $detail AS $key=>$value){
			$_value=urlencode($value);
			$array[]="<A HREF='search.php?action=search&type=keyword&keyword=$_value' target=_blank>$value</A>";
		}
		$rs[keywords2]=implode(" ",$array);
	}

	$listdb[]=$rs;
}

/**
*评论分布功能
**/
$showpage=getpage("","","?fid=$fid&id=$id",$rows,$totalNum);
$showpage=preg_replace("/\?fid=([\d]+)&id=([\d]+)&page=([\d]+)/is","javascript:getcomment('$city_url/job.php?job=dianping_ajax&fid=\\1&id=\\2&page=\\3')",$showpage);


require_once(html('dianping_ajax'));

function fen_value($title,$set,$v){
	global $Murl,$webdb;
	$shows="";
	$detail=explode("\r\n",$set);
	foreach( $detail AS $key=>$value){
		$d=explode("=",$value);
		if($d[0]==$v){
			$va ="$d[1]";
		}
	}
	$shows.=" <span class='title'>$title:</span>";
	for($i=0;$i<$v;$i++){
		$shows.="<img alt='$va' src='$webdb[www_url]/images/default/icon_star_2.gif'>";
	}
	for($j=(count($detail)-$i);$j>0 ;$j-- ){
		$shows.="<img alt='$va' src='$webdb[www_url]/images/default/icon_star_1.gif'>";
	}
	return $shows;
}
function fen6_value($title,$set,$v){
	$array=explode(",",$v);
	$detail=explode("\r\n",$set);
	foreach( $detail AS $key=>$value){
		if(in_array($value,$array)){
			$va[] ="$value";
		}
	}
	if(!$va){
		return ;
	}
	$shows =" <span class='title'>{$title}：</span>";
	$shows.=implode(" ",$va);
	if($title){
		return $shows;
	}	
}
?>