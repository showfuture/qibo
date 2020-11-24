<?php
require(dirname(__FILE__)."/"."global.php");

if($job=='apply'){
	if(!$lfjid){
		showerr('请先登录');
	}
}


$SQL="WHERE yz=1 AND (endtime=0 OR endtime>$timestamp) ";
$SQL.=" AND city_id IN('$city_id',0) ";

$rows=50;
if(1>$page){
	$page=1;
}
$min=($page-1)*$rows;

$showpage=getpage("{$_pre}friendlink","$SQL","?","$rows");
$query = $db->query("SELECT * FROM {$_pre}friendlink $SQL LIMIT $min,$rows");
while($rs = $db->fetch_array($query)){
	$rs[logo]=tempdir($rs[logo]);
	$_listdb[]=$rs;
}

$num=5-count($_listdb)%5;
for($i=0;$i<$num;$i++ ){
	$_listdb[]=array('display'=>'none');
}
$listdb=array_chunk($_listdb,5);


if($_POST)
{
	if(!$lfjid){
		showerr('请先登录');
	}
	if(!check_imgnum($yzimg))
	{
		showerr("验证码不符合");
	}
	
	if(!$postdb[name]){
		showerr("站点名称不能为空");
	}
	if(!$postdb[city_id])
	{
		showerr("请选择一个城市");
	}
	if(!$postdb[url]){
		showerr("站点地址不能为空");
	}

	foreach( $_FILES AS $key=>$value ){

		if(is_array($value)){
			$postfile=$value['tmp_name'];
			$array[name]=$value['name'];
			$array[size]=$value['size'];
		} else{
			$postfile=$$key;
			$array[name]=${$key.'_name'};
			$array[size]=${$key.'_size'};
		}
		if($ftype[1]=='in'&&$array[name]){

			if(!eregi("(gif|jpg|png)$",$array[name])){
				showerr("LOGO,只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
			}
			$array[path]=$webdb[updir]."/friendlink";
	
			$array[updateTable]=1;	//统计用户上传的文件占用空间大小
			$filename=upfile($postfile,$array);
			$postdb[logo]="friendlink/$filename";
		}

	}
	if($postdb[logo]&&!eregi("(gif|jpg|png)$",$postdb[logo])){
		showerr("LOGO,只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
	}
	
	if(!strstr($postdb[url],'htttp://')){
		$postdb[url]="htttp://".$postdb[url];
	}
	$postdb[name]=filtrate($postdb[name]);
	$postdb[url]=filtrate($postdb[url]);
	$postdb[descrip]=filtrate($postdb[descrip]);
	$postdb[logo]=filtrate($postdb[logo]);
}

if($action=='reg')
{
	if(!$lfjid){
		showerr('请先登录');
	}
	$db->query("INSERT INTO `{$_pre}friendlink` (`name` , `url` ,`city_id` , `logo` , `descrip` , `list`,ifhide,yz,iswordlink,uid,username ) VALUES ('$postdb[name]','$postdb[url]','$postdb[city_id]','$postdb[logo]','$postdb[descrip]','0','1','0','0','$lfjuid','$lfjid')");
	refreshto("$webdb[www_url]/","你的申请资料已经提交成功,请等待管理员审核后,才可以显示出来",'10');
}
else
{
	$select_fid=select_fsort("postdb[city_id]","");
	require(ROOT_PATH."inc/head.php");
	require(html("friendlink"));
	require(ROOT_PATH."inc/foot.php");
}




function select_fsort($name,$ckfid){
	global $db,$pre,$_pre;
	$show="<select name='$name'><option value=''>全国</option>";
	$query = $db->query("SELECT * FROM {$_pre}city ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$ckfid==$rs[fid]?' selected ':'';
		$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
	}
	$show.="</select>";
	return $show;
}


?>