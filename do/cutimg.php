<?php
require(dirname(__FILE__)."/"."global.php");

if(!$lfjid){
	showerr('请先登录!!');
}

if($action=="cutimg"){
	$NewPic=str_replace($webdb[www_url],"",$uploadfile);
	$NewPic=ROOT_PATH.$NewPic;
	if(!getimagesize($NewPic)){
		showerr("图片有误!!");
	}
	include(ROOT_PATH."inc/waterimage.php");
	if($nextpic<3){
		copy($NewPic,$NewPic.'.jpg');
	}
	cutimg($NewPic,$NewPic,$x,$y,$rw,$rh,$w,$h,$scale);
	if($reurl){
		$reurl=base64_decode($reurl);
		header("location:$reurl");
		exit;
	}
	if($nextpic==1){
		$url="?nextpic=2&job=cutimg&width=$rh&height=$rw&srcimg=$uploadfile.jpg";
	}elseif($nextpic==2){
		$url="?nextpic=3&job=cutimg&width=$rw&height=$rw&srcimg=$uploadfile.jpg";
	}elseif($nextpic==3){
		$pic1="$uploadfile?$timestamp";
		$pic2=str_replace(".jpg?","?",$pic1);
		$pic3=str_replace(".jpg?","?",$pic2);
		echo '<meta http-equiv="Content-Type" content="text/html; charset=gb2312">';
		die("剪裁成功,你可以点击查看三种截图效果:<br><A HREF='$pic3' target=_blank>样式1</A> <A HREF='$pic2' target=_blank>样式2</A> <A HREF='$pic1' target=_blank>样式3</A><br> <a href='javascript:window.self.close()'>点击关闭</a>");
	}else{
		$url="$uploadfile?$timestamp";
	}
	echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>";
	exit;
}
if(!ereg("^http:",$srcimg)){
	$srcimg="$weburl_array[upfiles]/$srcimg";
}
require(html("cutimg"));
?>