<?php
if(!$lfjuid){
	showerr("请先登录!");
}

$detail=explode(",",$webdb[group_UpPhoto].',3,4');
if($webdb[group_UpPhoto]&&!in_array($groupdb['gid'],$detail)){
	showerr("你所在用户组无权上传组图!");
}

if( !is_table("{$_pre}pic") ){
	$db->query("CREATE TABLE `{$_pre}pic` (
  `pid` mediumint(7) NOT NULL auto_increment,
  `id` mediumint(10) NOT NULL default '0',
  `fid` mediumint(7) NOT NULL default '0',
  `mid` smallint(4) NOT NULL default '0',
  `uid` mediumint(7) NOT NULL default '0',
  `type` tinyint(1) NOT NULL default '0',
  `imgurl` varchar(150) NOT NULL default '',
  `name` varchar(100) NOT NULL default '',
  PRIMARY KEY  (`pid`),
  KEY `id` (`id`),
  KEY `fid` (`fid`)
) TYPE=MyISAM AUTO_INCREMENT=1");
}

$_erp=$Fid_db[tableid][$fid];
$rsdb=$db->get_one("SELECT A.* FROM `{$_pre}content$_erp` A WHERE A.id='$id'");

if(!$rsdb){
	showerr("资料不存在");
}elseif(!$web_admin&&$rsdb[uid]!=$lfjuid){
	showerr("你没权限");
}

$fid=$rsdb[fid];
$mid=$rsdb[mid];
if($act=="edit")
{
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

			if(!eregi("(gif|jpg|png)$",$array[name])){
				showerr("只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$array[name]");
			}
			$array[path]=$webdb[updir]."/fenlei/$fid";
	
			$array[updateTable]=1;	//统计用户上传的文件占用空间大小
			$filename=upfile($postfile,$array);
			$photodb[$i]="fenlei/$fid/$filename";

			$smallimg=$photodb[$i].'.gif';
			$Newpicpath=ROOT_PATH."$webdb[updir]/$smallimg";
			gdpic(ROOT_PATH."$webdb[updir]/{$photodb[$i]}",$Newpicpath,300,220,array('fix'=>1));

			if(!$rsdb[picurl]){
				$rsdb[picurl]=$smallimg;
				if(!file_exists(ROOT_PATH."$webdb[updir]/$rsdb[picurl]")){
					$rsdb[picurl]=$photodb[$i];
				}
				$db->query("UPDATE `{$_pre}content$_erp` SET picurl='$rsdb[picurl]' WHERE id='$id'");
			}
			/*加水印*/
			if( $webdb[is_waterimg] && $webdb[if_gdimg] )
			{
				include_once(ROOT_PATH."inc/waterimage.php");
				$uploadfile=ROOT_PATH."$webdb[updir]/$photodb[$i]";
				imageWaterMark($uploadfile,$webdb[waterpos],ROOT_PATH.$webdb[waterimg]);
			}
		}
	}

	foreach( $photodb AS $key=>$value){
		if(strlen($value)>4&&!eregi("(gif|jpg|png)$",$value)){
			showerr("只能上传GIF,JPG,PNG格式的文件,你不能上传此文件:$value");
		}
	}
	$num=0;
	foreach( $photodb AS $key=>$value ){
		$titledb[$key]=filtrate($titledb[$key]);
		$value=trim($value);
		$value=filtrate($value);
		if($titledb[$key]>100){
			showerr("标题不能大于50个汉字");
		}
		if(strlen($value)<4){
			$db->query("DELETE FROM `{$_pre}pic` WHERE pid='{$piddb[$key]}' AND id='$id'");
		}elseif($piddb[$key]){
			$num++;
			$db->query("UPDATE `{$_pre}pic` SET name='{$titledb[$key]}',imgurl='$value' WHERE pid='{$piddb[$key]}'");
		}elseif($value){
			$num++;
			$db->query("INSERT INTO `{$_pre}pic` ( `id` , `fid` , `mid` , `uid` , `type` , `imgurl` , `name` ) VALUES ( '$id', '$fid', '$mid', '$lfjuid', '0', '$value', '{$titledb[$key]}')");
		}
	}
	$db->query("UPDATE `{$_pre}content$_erp` SET picnum='$num' WHERE id='$id'");
	refreshto("job.php?job=show_img&fid=$fid&id=$id","修改成功");
	//refreshto("$FROMURL","修改成功",107);
}
else
{
	$query = $db->query("SELECT * FROM {$_pre}pic WHERE id='$id'");
	while($rs = $db->fetch_array($query)){
		$listdb[$rs[pid]]=$rs;
	}
	if(!$listdb){
		$listdb[]='';
	}
	
	require(Mpath."inc/head.php");
	require(html("post_img"));
	require(Mpath."inc/foot.php");
}

?>