<?php
//联系资料设置

if(!$step){
	
	$address=$db->get_one("SELECT A.*  FROM `{$_pre}company` A  WHERE A.`uid`='$uid'");
	//$city_id=$address[city_id];
	//$zone_id=$address[zone_id];
	//$street_id=$address[street_id];

	//得到地区
	//$city_fid=select_where("{$_pre}city","'city_id'  onChange=\"choose_where('getzone',this.options[this.selectedIndex].value,'','1','')\"",$city_id);
	
}else{
	
	foreach( $_POST AS $key=>$value){
		if(!is_array($value)){
			$_POST[$key]=filtrate($value);
		}		
	}
	@extract($_POST);
	
	if($qy_contact_email&&!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$qy_contact_email)){
		showerr('邮箱不符合规则');
	}
	elseif($qy_website&&!eregi("^http:",$qy_website)){
		showerr('网址有误,必须是http://开头');
	}elseif($qy_postnum&&!eregi("^([0-9]{6})$",$qy_postnum)){
		showerr('邮政编码有误');
	}elseif($qy_contact_mobile&&!eregi("^1([0-9]{10})$",$qy_contact_mobile)){
		showerr('手机号码有误');
	}elseif($qq){
		$arrQQ = explode(",", $qq);
		foreach ($arrQQ as $QQ){
			if (!eregi("^([0-9]{5,11})$",$QQ)){
				showerr('QQ号码有误');
			}
		}
	}elseif($msn){
		$arrMSN = explode(",", $msn);
		foreach ($arrMSN as $MSN){
			if (!ereg("^[-a-zA-Z0-9_\.]+\@([0-9A-Za-z][0-9A-Za-z-]+\.)+[A-Za-z]{2,5}$",$MSN)){
				showerr('msn不符合规则');
			}
		}
	}

	$db->query("UPDATE `{$_pre}company` SET
	`qy_contact`='$qy_contact',
	`qy_contact_zhiwei`='$qy_contact_zhiwei',
	`qy_contact_tel`='$qy_contact_tel',
	`qy_contact_fax`='$qy_contact_fax',
	`qy_contact_mobile`='$qy_contact_mobile',
	`qy_website`='$qy_website',
	`qy_contact_email`='$qy_contact_email',
	`qy_postnum`='$qy_postnum',
	`qy_address`='$qy_address',
	`qq`='$qq',
	`msn`='$msn',
	`skype`='$skype',
	`ww`='$ww',
	`city_id`='{$city_id}',
	`gg_maps`='$gg_maps'
	WHERE uid='$uid'");

	
	refreshto("?uid=$uid&atn=$atn","修改成功");
	
}

?>