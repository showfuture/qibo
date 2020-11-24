<?php
require_once(dirname(__FILE__)."/global.php");

if(!$fid){
	showerr("FID不存在");
}

if(!$lfjid){
	refreshto("$webdb[www_url]/do/login.php","你在前台还没登录,请先在前台登录",30);
}

/**
*获取栏目与模块的配置文件
**/

$fidDB=$db->get_one("SELECT A.* FROM {$_pre}sort A WHERE A.fid='$fid'");

if( !$web_admin ){
	if($fidDB[allowpost]){
		if( !in_array($groupdb[gid],explode(",",$fidDB[allowpost])) ){
			showerr("你所在用户组无权发表");
		}
	}elseif($webdb[allowGroupPost]){
		if( !in_array($groupdb[gid],explode(",",$webdb[allowGroupPost])) ){
			showerr("你所在用户组无权发表!");
		}
	}
}



//SEO
$titleDB[title]		= "$fidDB[name] - $webdb[Info_webname] - $titleDB[title]";


if($fidDB[type]){
	showerr("大分类,不允许发表内容");
}




if($_FILES||$postdb[picurl]){
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

			if($i==1&&!eregi("(gif|jpg|png)$",$array[name])){
				showerr("缩略图,只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
			}
			$array[path]=$webdb[updir]."/$_pre/$fid";
	
			$array[updateTable]=1;	//统计用户上传的文件占用空间大小
			$filename=upfile($postfile,$array);
			if($i==1){
				$postdb[picurl]="$_pre/$fid/$filename";
				if($webdb[if_gdimg])
				{
					$Newpicpath=ROOT_PATH."$webdb[updir]/$postdb[picurl]";
					gdpic($Newpicpath,"{$Newpicpath}.jpg",300,400,array('fix'=>1));
					gdpic($Newpicpath,"{$Newpicpath}.jpg.jpg",400,400,array('fix'=>1));
					gdpic($Newpicpath,$Newpicpath,400,300,array('fix'=>1));
				}
			}
		}
	}
	if($postdb[picurl]&&!eregi("(gif|jpg|png)$",$postdb[picurl])){
		showerr("缩略图,只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
	}
}


if($action=="edit"||$action=="postnew")
{
	if(strlen($postdb[title])>150){
		showerr("标题字节个数不能大于150");
	}
	if(strlen($postdb[keywords])>100){
		showerr("关键字字节个数不能大于100");
	}
	if(strlen($postdb[author])>50){
		showerr("作者字节个数不能大于50");
	}
	if(strlen($postdb[copyfrom])>70){
		showerr("来源字节个数不能大于70");
	}
	if(strlen($postdb[copyfromurl])>150){
		showerr("来源网址字节个数不能大于150");
	}

	if(!$postdb[title]){	
		showerr("标题名称不能为空");
	}
}

/**处理提交的新发表内容**/
if($action=="postnew")
{
	/*验证码处理*/
	if(!$web_admin){
		if(!check_imgnum($yzimg)){
			showerr("验证码不符合");
		}
	}

	if($isiframe==1){
		$postdb[jumpurl]='';
	}elseif($isiframe==2){
		$postdb[iframeurl]='';
	}else{
		$postdb[iframeurl]=$postdb[jumpurl]='';
	}

	//设法生成缩略图
	if( !$postdb[picurl] && $file_db=get_content_attachment($postdb[content]) ){
		if( $file_db[0] && eregi("(jpg|gif|png)$",$file_db[0]) && !eregi("sysimage\/file",$file_db[0]) ){
			$postdb[picurl]=$file_db[0];
			if($webdb[if_gdimg]){			
				$postdb[picurl]=str_replace(".","_",$file_db[0]).'.gif';
				$Newpicpath=ROOT_PATH."$webdb[updir]/$postdb[picurl]";
				gdpic(ROOT_PATH."$webdb[updir]/$file_db[0]",$Newpicpath,200,150);
				if(!file_exists($Newpicpath)){
					$postdb[picurl]=$file_db[0];
				}
			}
		}
	}

	if($postdb[picurl]){	
		$postdb[ispic]=1;
	}else{	
		$postdb[ispic]=0;
	}
	
	$postdb[yz]=1;
	if(!$web_admin){
		if( $webdb[Info_GroupPostYZ] && !in_array($groupdb['gid'],explode(",",$webdb[Info_GroupPostYZ])) ){		
			$postdb[yz]=0;
		}
	}

	
	//图片目录转移
	$postdb[content]=move_attachment($lfjdb[uid],$postdb[content],"{$_pre}/$fid");
	//获取远程图片
	$postdb[content] = get_outpic($postdb[content],$fid,$GetOutPic);
	$postdb[content] = En_TruePath($postdb[content]);
	$postdb[content] = preg_replace('/javascript/i','java script',$postdb[content]);	//过滤js代码
	$postdb[content] = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$postdb[content]);	//过滤框架代码

	
 	foreach($postdb AS $key=>$value){	
		if($key=='content'){		
			continue;
		}
		$postdb[$key]=filtrate($value);
	}

	$db->query("INSERT INTO `{$_pre}content` ( `title` , `mid` , `fid` , `fname` , `city_id` , `posttime` , `list` , `uid` , `username` ,  `picurl` , `ispic` , `yz` ,`keywords` , `jumpurl` , `iframeurl` , `ip` ,`author`, `copyfrom`, `copyfromurl`) VALUES ('$postdb[title]','1','$fid','$fidDB[name]','$postdb[city_id]','$timestamp','$timestamp','$lfjdb[uid]','$lfjdb[username]','$postdb[picurl]','$postdb[ispic]','$postdb[yz]','$postdb[keywords]','$postdb[jumpurl]','$postdb[iframeurl]','$onlineip','$postdb[author]','$postdb[copyfrom]','$postdb[copyfromurl]')");

	$id=$db->insert_id();

	$db->query("INSERT INTO `{$_pre}content_1` (`id` , `fid` , `uid` , `topic` , `content`) VALUES ('$id', '$fid', '$lfjdb[uid]', '1', '$postdb[content]')");

 	refreshto("list.php?job=list","<a href='$Mdomain/bencandy.php?fid=$fid&id=$id' target='_blank'>查看效果</a> <a href='post.php?fid=$fid'>继续发表</a> <a href='list.php?job=list'>返回列表</a>",300);
}

/*删除内容,直接删除,不保留*/
elseif($action=="del")
{
	$rsdb=$db->get_one("SELECT B.*,A.* FROM `{$_pre}content` A LEFT JOIN `{$_pre}content_1` B ON A.id=B.id WHERE A.id='$id'");

	if($rsdb[fid]!=$fidDB[fid]){	
		showerr("栏目有问题");
	}

	if($rsdb[uid]!=$lfjuid&&!$web_admin)
	{
		showerr("你无权操作");
	}


	$db->query("DELETE FROM `{$_pre}content` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}content_1` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}comments` WHERE id='$id' ");
	//缺少对附件的删除
	refreshto("list.php?job=list",'删除成功',1);
}

/*编辑内容*/
elseif($job=="edit")
{
	$rsdb=$db->get_one("SELECT B.*,A.* FROM `{$_pre}content` A LEFT JOIN `{$_pre}content_1` B ON A.id=B.id WHERE A.id='$id'");

	if($rsdb["jumpurl"]){
		$chooseiframe='2';
		$isiframe[2]=" checked ";
	}elseif($rsdb["iframeurl"]){
		$chooseiframe='1';
		$isiframe[1]=" checked ";
	}else{
		$chooseiframe='0';
		$isiframe[0]=" checked ";
	}

	$rsdb[content]=En_TruePath($rsdb[content],0);
	$rsdb[content]=editor_replace($rsdb[content]);

	$atc="edit";

	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/post.htm");
	require(ROOT_PATH."member/foot.php");
}

/*处理提交的内容做修改*/
elseif($action=="edit")
{
	$rsdb=$db->get_one("SELECT A.*,B.* FROM `{$_pre}content` A LEFT JOIN `{$_pre}content_1` B ON A.id=B.id WHERE A.id='$id' LIMIT 1");

	if($rsdb[uid]!=$lfjuid&&!$web_admin)
	{
		showerr("你无权修改");
	}

	if($isiframe==1){
		$postdb[jumpurl]='';
	}elseif($isiframe==2){
		$postdb[iframeurl]='';
	}else{
		$postdb[iframeurl]=$postdb[jumpurl]='';
	}

	
	//设法生成缩略图
	if( !$postdb[picurl] && $file_db=get_content_attachment($postdb[content]) ){
		if( $file_db[0] && eregi("(jpg|gif)$",$file_db[0]) && !eregi("sysimage\/file",$file_db[0]) ){
			$postdb[picurl]=$file_db[0];
			if($webdb[if_gdimg])
			{
				$postdb[picurl]=str_replace(".","_",$file_db[0]).'.gif';
				$Newpicpath=ROOT_PATH."$webdb[updir]/$postdb[picurl]";
				gdpic(ROOT_PATH."$webdb[updir]/$file_db[0]",$Newpicpath,200,150);
				if(!file_exists($Newpicpath)){
					$postdb[picurl]=$file_db[0];
				}
			}
		}
	}

	if($postdb[picurl]){	
		$postdb[ispic]=1;
	}else{	
		$postdb[ispic]=0;
	}
	
	//图片目录转移
	$postdb[content] = move_attachment($lfjdb[uid],$postdb[content],"{$_pre}/$fid");

	//获取远程图片
	$postdb[content] = get_outpic($postdb[content],$fid,$GetOutPic);

	$postdb[content] = En_TruePath($postdb[content]);
	$postdb[content] = preg_replace('/javascript/i','java script',$postdb[content]);	//过滤js代码
	$postdb[content] = preg_replace('/<iframe ([^<>]+)>/i','&lt;iframe \\1>',$postdb[content]);	//过滤框架代码

	foreach($postdb AS $key=>$value){
		if($key=='content'){		
			continue;
		}
		$postdb[$key]=filtrate($value);
	}	
	

	$db->query("UPDATE `{$_pre}content` SET title='$postdb[title]',keywords='$postdb[keywords]',picurl='$postdb[picurl]',ispic='$postdb[ispic]',city_id='$postdb[city_id]',iframeurl='$postdb[iframeurl]',jumpurl='$postdb[jumpurl]',author='$postdb[author]',copyfrom='$postdb[copyfrom]',copyfromurl='$postdb[copyfromurl]' WHERE id='$id'");

	$db->query("UPDATE `{$_pre}content_1` SET content='$postdb[content]' WHERE id='$id'");

	refreshto("list.php?job=list","<a href='$Mdomain/bencandy.php?fid=$fid&id=$id&rid=$rid' target='_blank'>查看效果</a> <a href='list.php?job=list'>返回列表</a> <a href='$FROMURL'>继续修改</a>",600);	

}
else
{
	$atc="postnew";

 	$isiframe[0]=" checked ";

	require(ROOT_PATH."member/head.php");
	require(dirname(__FILE__)."/template/post.htm");
	require(ROOT_PATH."member/foot.php");
}

//采集外部图片
function get_outpic($str,$fid=0,$getpic=1){
	global $webdb,$_pre;
	if(!$getpic){
		return $str;
	}
	preg_match_all("/http:\/\/([^ '\"<>]+)\.(gif|jpg|png)/is",$str,$array);
	$filedb=$array[0];
	foreach( $filedb AS $key=>$value){
		if( strstr($value,$webdb[www_url]) ){
			continue;
		}
		$listdb["$value"]=$value;
	}
	unset($filedb);
	foreach( $listdb AS $key=>$value){
		$filedb[]=$value;
		$name=rands(5)."__".basename($value);
		if(!is_dir(ROOT_PATH."$webdb[updir]/$_pre")){
			makepath(ROOT_PATH."$webdb[updir]/$_pre");
		}
		if(!is_dir(ROOT_PATH."$webdb[updir]/$_pre/$fid")){
			makepath(ROOT_PATH."$webdb[updir]/$_pre/$fid");
		}
		$ck=0;
		if( @copy($value,ROOT_PATH."$webdb[updir]/$_pre/$fid/$name") ){
			$ck=1;
		}elseif($filestr=file_get_contents($value)){
			$ck=1;
			write_file(ROOT_PATH."$webdb[updir]/$_pre/$fid/$name",$filestr);
		}
	
		/*加水印*/
		if($ck&&$webdb[is_waterimg]&&$webdb[if_gdimg])
		{
			include_once(ROOT_PATH."inc/waterimage.php");
			$uploadfile=ROOT_PATH."$webdb[updir]/$_pre/$fid/$name";
			imageWaterMark($uploadfile,$webdb[waterpos],ROOT_PATH.$webdb[waterimg]);
		}

		if($ck){
			$str=str_replace("$value","http://www_qibosoft_com/Tmp_updir/$_pre/$fid/$name",$str);
		}
	}
	return $str;
}

?>