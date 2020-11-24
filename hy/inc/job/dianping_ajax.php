<?php
header('Content-Type: text/html; charset='.WEB_LANG);


if($action=="post")
{	
	
	/*验证码处理*/
	if(!$web_admin&&!check_imgnum($yzimg)){	
		die("验证码不符合,点评失败");
	}

	if(!$content){	
		die("内容不能为空");
	}


	/*是否允许评论判断处理*/
	$allow=1;
	

	/*是否允许评论自动通过审核判断处理*/
	$yz=1;


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
	
	$rss=$db->get_one(" SELECT * FROM {$_pre}home WHERE uid='$id' ");
	if(!$rss){
		die("原数据不存在");
	}

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

		$db->query("INSERT INTO `{$_pre}dianping` (`cuid`, `type`, `id`, `uid`, `username`, `posttime`, `content`, `ip`, `icon`, `yz`, `fen1`, `fen2`, `fen3`, `fen4`, `fen5`, `price`, `keywords`, `keywords2`, `fen6`) VALUES ('$rss[uid]','0','$id','$lfjuid','$username','$timestamp','$content','$onlineip','$icon','$yz','$fen1','$fen2','$fen3','$fen4','$fen5','$c_price','$c_keywords','$c_keywords2','$fen6')");

		$db->query(" UPDATE {$_pre}company SET dianping=dianping+1,`dianpingtime`='$timestamp' WHERE uid='$id' ");
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
		add_user($lfjdb[uid],-abs($webdb[DelOtherCommentMoney]),'删除店铺留言扣分');
	}
	$db->query(" DELETE FROM `{$_pre}dianping` WHERE cid='$cid' ");
	$db->query("UPDATE {$_pre}company SET dianping=dianping-1 WHERE uid='$rs[id]' ");
	
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
	$SQL=" AND A.yz=1 ";
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


/*评论字数再多也只限制显示1000个字*/
$leng=1000;

$query=$db->query("SELECT SQL_CALC_FOUND_ROWS A.*,B.icon FROM `{$_pre}dianping` A LEFT JOIN {$pre}memberdata B ON A.uid=B.uid WHERE A.id=$id $SQL ORDER BY A.cid DESC LIMIT $min,$rows");
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

	$rs[posttime]=date("Y-m-d H:i:s",$rs[posttime]);\

	$rs[icon]=tempdir($rs[icon]);

	$rs[full_content]=$rs[content];

	$rs[content]=get_word($rs[content],$leng);

	if($rs[type]){
		$rs[content]="<img style='margin-top:3px;' src=$webdb[www_url]/images/default/good_ico.gif> ".$rs[content];
	}

	$rs[content]=str_replace("\n","<br>",$rs[content]);
	/*
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
	*/
	$listdb[]=$rs;
}

/**
*评论分布功能
**/
$showpage=getpage("","","?fid=$fid&id=$id",$rows,$totalNum);
$showpage=preg_replace("/\?fid=([\d]+)&id=([\d]+)&page=([\d]+)/is","javascript:getdianpings('$Mdomain/job.php?job=dianping_ajax&fid=\\1&id=\\2&page=\\3')",$showpage);


require_once(Mpath."homepage_tpl/default/dianping_ajax.htm");
?>