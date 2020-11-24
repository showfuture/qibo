<?php
//更新公司横幅设置


$conf = $db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid' LIMIT 1");
list($banner_url,$width,$height) = explode("\t",$conf['banner']);
$banner_show = tempdir($banner_url);


if($step){
	$banner = $banner_url;
	//图片处理
	if($del_banner==1){
		delete_attachment($uid,$banner_show);
		$banner="";
	}elseif($_FILES[postfile][size]){

		$array[name]=is_array($postfile)?$_FILES[postfile][name]:$postfile_name;
		if(!eregi("\.(jpg|jpeg|gif|png|bmp|swf)$",$array[name])){
			showerr('你所上传的格式有误!');
		}
		$array[path]=$webdb[updir]."/homepage/banner/";
		$array[size]=is_array($postfile)?$_FILES[postfile][size]:$postfile_size;
		//if($array[size]>$webdb[homepage_banner_size]*1024) showerr("图片文件不能超过$webdb[homepage_banner_size] K");
		$picurl_t=upfile(is_array($postfile)?$_FILES[postfile][tmp_name]:$postfile,$array);
		if($picurl_t){
			$banner="homepage/banner/$picurl_t";
			if($banner_url)delete_attachment($uid,$banner_show);
		}	
	}

	$db->query("UPDATE {$_pre}home SET `banner`='$banner\t$atc_width\t$atc_height' WHERE uid='$uid'");	

	refreshto("?uid=$uid&atn=$atn","设置成功");	
}
?>