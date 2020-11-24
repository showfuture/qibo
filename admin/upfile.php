<?php
error_reporting(0);
if($_POST['action']||$action){	
	require_once (dirname(__FILE__)."/".'global.php');
}
?>
<html>
<head>
<title>Powered by qibosoft.com</title>
<meta name='keywords' content='CMS'>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312">
</head>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0">
<?php
if($postfile){
	if( !ereg("^[0-9a-z_]+$",$dir) ){
		$dir="other";
	}
	$array[name]=is_array($postfile)?$_FILES[postfile][name]:$postfile_name;
	$array[path]=$webdb[updir]."/".$dir;
	$array[size]=is_array($postfile)?$_FILES[postfile][size]:$postfile_size;
	$lfjuid=$userdb[uid];	//处理上传的文件名标志
	$filename=upfile(is_array($postfile)?$_FILES[postfile][tmp_name]:$postfile,$array);
    if(!$filename){
		echo "<CENTER>文件上传失败,请再次上传，如果多次失败，请联系管理员<a href=\"javascript:history.go(-1)\"> 点击返回</a></CENTER>";
		exit;
	}else {
		$newfile="$dir/$filename";
		echo "上传成功,<A HREF=?fn=$fn&label=$label&dir=$dir&label=$_GET[label]>继续上传</A>";
		$fn || $fn="upfile";
		echo "
			<script>
				if(self==top){
					window.opener.$fn('$newfile','$array[name]','$array[size]','$_GET[label]');
					window.self.close();
				}else{
					window.parent.$fn('$newfile','$array[name]','$array[size]','$_GET[label]');
				}
			</script>
			";
		exit;
	}
}
?>
<form name="form1" method="post" action="" enctype="multipart/form-data">
  <input  type="file" name="postfile" style="height:20px; background-color:#EBEBEB; border:1 solid black;" onMouseOver ="this.style.backgroundColor='#F0F0F0'" onMouseOut ="this.style.backgroundColor='#FAFAFA'" >
  <input  type="submit" name="Submit" value="上传文件" style="height:20px; background-color:#EBEBEB; border:1 solid black;" onMouseOver ="this.style.backgroundColor='#F0F0F0'" onMouseOut ="this.style.backgroundColor='#FAFAFA'" >
  <input type="hidden" name="action" value="uploadfile">
</form>
</body>
</html>