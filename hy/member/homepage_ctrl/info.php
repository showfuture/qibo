<?php

//公司资料修改


if(!$step){
	$intro=$db->get_one("SELECT * FROM `{$_pre}company` WHERE `uid`='$uid'");

	$query = $db->query("SELECT fid FROM `{$_pre}company_fid` WHERE uid = {$intro['uid']}");
	$fids = array(); while($arr = $db->fetch_array($query)) $fids[] = $arr['fid'];
	
	$rsdb[logo]=tempdir($intro[picurl]);//echo $qy_cate;exit;
	$my_trade["$intro[my_trade]"]=" selected ";
	$qy_cate["$intro[qy_cate]"]=" selected ";
	$qy_saletype["$intro[qy_saletype]"]=" selected ";
	
	//得到分类
	//$fid_all=explode("|",$intro[fid_all]);
	
	
	
	//得到地区
	//$city_fid=select_where("{$_pre}city","'city_id'  onChange=\"choose_where('getzone',this.options[this.selectedIndex].value,'','1','')\"",$city_id);
	
	//真实地址还原
	//$content=En_TruePath($content,0);

	$zone_id = $intro[zone_id];
	$street_id = $intro[street_id];
	
	$webdb[maxCompanyFidNum]=$webdb[maxCompanyFidNum]?$webdb[maxCompanyFidNum]:10;

}else{

	$picurl=$oldfile;
	if(is_uploaded_file($_FILES[postfile][tmp_name])){
		$array[name]=is_array($postfile)?$_FILES[postfile][name]:$postfile_name;
		$dirid=ceil($uid/1000);
		$array[path]=$webdb[updir]."/homepage/logo/$dirid/";
		if(!is_dir($array[path])) makepath(ROOT_PATH.$array[path]);
		$array[size]=is_array($postfile)?$_FILES[postfile][size]:$postfile_size;
		//if($array[size]>$webdb[homepage_ico_size]*1024) showerr("图片文件不能超过$webdb[homepage_ico_size] K");
		$picurl_t=upfile(is_array($postfile)?$_FILES[postfile][tmp_name]:$postfile,$array);

		delete_attachment($uid,tempdir($oldfile));
		delete_attachment($uid,tempdir($oldfile.".jpg"));
		delete_attachment($uid,tempdir($oldfile.".jpg.jpg"));
		delete_attachment($uid,tempdir($oldfile.".jpg.jpg.jpg"));
		
		
		$picurl="homepage/logo/$dirid/{$picurl_t}";
		$sizedb=getimagesize(ROOT_PATH."$array[path]/$picurl_t");
		
		if($sizedb[0]>300||$sizedb[1]>300){
			$Newpicpath=ROOT_PATH."$array[path]/logo_{$picurl_t}";
			gdpic(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath,300,225);
			gdpic(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg",225,300);
			gdpic(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg.jpg",300,300);
			gdpic(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg.jpg.jpg",300,100);
			if(file_exists($Newpicpath)){
				delete_attachment($uid,tempdir("homepage/logo/$dirid/{$picurl_t}"));
				$picurl="homepage/logo/$dirid/logo_{$picurl_t}";
			}			
		}else{
			$Newpicpath=ROOT_PATH."$array[path]/{$picurl_t}";
			copy(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg");
			copy(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg.jpg");
			copy(ROOT_PATH."$array[path]/{$picurl_t}",$Newpicpath.".jpg.jpg.jpg");
		}
		
	}


	if(strlen($title) <5 || strlen($title)>60 ) showerr("公司名称必须在5-30个字之间");
		
	if(count($fids)<1)showerr("至少选择一个分类");

	//if(!$city_id) showerr("必须选择城市");

	$intro=$db->get_one("SELECT * FROM `{$_pre}company` WHERE `uid`='$uid'");
	$db->query("DELETE FROM `{$_pre}company_fid` WHERE uid = {$intro['uid']}");
	
	//插入多条关系
	$values = $comma = $fname = '';
	foreach($fids as $key){
		$key = intval($key);
		if($key){
			$values .= $comma ."({$intro['uid']}, $key)";
			$fname .= $comma .$Fid_db['name'][$key];
			$comma = ',';
		}
		//$fid_all[$key]=getFidAll($key);
		//$fname[$key]=$Fid_db[name][$key];
	}
	
	$db->query("INSERT INTO `{$_pre}company_fid` VALUES $values");
	

	foreach( $_POST AS $key=>$value){
		if(!is_array($value)){
			$_POST[$key]=filtrate($value);
		}		
	}
	@extract($_POST);

	$db->query("UPDATE `{$_pre}company` SET 
	`title`='$title',
	`picurl`='$picurl',
	`fname`='$fname',
	`province_id`='{$province_id}',
	`city_id`='{$postdb[city_id]}',
		`zone_id`='{$postdb[zone_id]}',
		`street_id`='{$postdb[street_id]}',
	`my_trade`='$my_trade',
	`qy_cate`='$qy_cate',
	`qy_regmoney`='$qy_regmoney',
	`qy_saletype`='$qy_saletype',
	`qy_createtime`='$qy_createtime',
	`qy_pro_ser`='$qy_pro_ser',
	`my_buy`='$my_buy',
	`qy_regplace`='$qy_regplace'
	WHERE uid='$uid'");
	
	

	
	refreshto("?uid=$uid&atn=$atn","修改成功");

}


?>