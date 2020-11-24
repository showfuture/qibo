<?php
function Info_keyword_ck($keyword){
	if($keyword){
		$keyword=str_replace("　"," ",$keyword);
		$keyword=str_replace(","," ",$keyword);
		$keyword=str_replace("，"," ",$keyword);
		$keyword=str_replace("、"," ",$keyword);
		$detail=explode(" ",$keyword);
		foreach( $detail AS $key=>$value){
			//大于3个字节的,才列为关键字,一个汉字相当于两个字节
			if(strlen($value)>3){
				 $array[$value]=$value;
			}
		}
		$keyword=implode(" ",$array);
		return $keyword;
	}
}

//评分字段,极少用
function update_fen($id){
	global $db,$_pre;
	return;
	$query = $db->query("SELECT * FROM {$_pre}comments WHERE id='$id'");
	while($rs = $db->fetch_array($query)){
		for($i=1;$i<6 ;$i++ ){
			if($rs["fen{$i}"]){
				${"fen{$i}_num"}++;
				${"fen{$i}_vale"}+=$rs["fen{$i}"];
			}
		}
	}
	for($i=1;$i<6 ;$i++ ){
		if(${"fen{$i}_num"}){
			//放大10倍易于更准确的作比较
			$value=ceil((${"fen{$i}_vale"}/${"fen{$i}_num"})*10);
			$array[]="`f{$i}`='$value'";
		}		
	}
	if($array){
		$SQL=implode(",",$array);
		$db->query("UPDATE {$_pre}content SET $SQL WHERE id='$id'");
	}
}

//发布页静态时得到他的URL
function get_post_url($type,$fid,$id='',$cityid='',$zoneid='',$streetid=''){
	global $webdb,$city_DB;

	$_cityid=$cityid?$cityid:$GLOBALS['city_id'];
	if($city_DB['domain'][$_cityid]){
		$url=$city_DB['domain'][$_cityid].'/';
	}elseif($city_DB['dirname'][$_cityid]&&$city_DB['url'][$_cityid]){
		$url=$city_DB['url'][$_cityid];
	}else{
		$url=$webdb['www_url'].'/';
	}

	if($webdb[post_htmlType]==1){
		if($type=='del'){
			$url.="post-del";
		}elseif($type=='edit'){
			$url.="post-edit";
		}else{
			$url.="post";
		}
		$fid && $url.="-$fid";
		if($type!='del'&&$type!='edit'){	//新发布
			$cityid && $url.="-$cityid";
			$zoneid && $url.="-$zoneid";
			$streetid && $url.="-$streetid";
		}else{
			$url.="-$id";
		}
		//$url.=".htm";
		$url.=$webdb['Info_htmlname']?".$webdb[Info_htmlname]":".htm";		
	}else{
		if($type=='del'){
			$url.="post.php?action=del&fid=$fid&id=$id";
		}elseif($type=='edit'){
			$url.="post.php?job=edit&fid=$fid&id=$id";
		}else{
			$url.="post.php";
			if($street_id){
				$url.="?fid=$fid&city_id=$cityid&zone_id=$zoneid&street_id=$streetid";
			}elseif($zoneid){
				$url.="?fid=$fid&city_id=$cityid&zone_id=$zoneid";
			}elseif($fid&&$cityid){
				$url.="?fid=$fid&city_id=$cityid";
			}elseif($fid){
				$url.="?fid=$fid";
			}
		}
	}
	return $url;
}

//得到信息的URL
function get_info_url($id,$fid,$cityid='',$zoneid='',$streetid='',$array=array()){
	global $webdb,$Fid_db,$zone_DB,$street_DB,$city_DB,$BIZ_MODULEDB;
	$webdb[Info_htmlname] || $webdb[Info_htmlname]='html';
	if( count($city_DB[name])>2 ){
		if(!function_exists('MODULE_CK')||!in_array('fenlei',$BIZ_MODULEDB)){
			die("Free!");
		}		
	}
	if($city_DB[domain][$cityid]){
		$url=$city_DB[domain][$cityid].'/';
	}elseif($city_DB['dirname'][$cityid]&&$city_DB['url'][$cityid]){
		$url=$city_DB['url'][$cityid];
	}else{
		$url=$webdb[www_url].'/';
	}
	if($webdb[Info_htmlType]==2){
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
	}elseif($webdb[Info_htmlType]==1){
		if($id){
			$url.="bencandy-city_id-$cityid-fid-$fid-id-$id.$webdb[Info_htmlname]";
		}else{
			$url.="list-city_id-$cityid-fid-$fid";
			$array[zone_id]=$zoneid;
			$array[street_id]=$streetid;
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


//分表的情况
function get_id_info($IDstring){
	global $db,$_pre,$Fid_db,$webdb;
	if(!$IDstring){
		return ;
	}
	if(!$webdb[Info_ShowNoYz]){
		$SQL =" AND yz='1' ";
	}
	$query = $db->query("SELECT * FROM {$_pre}db WHERE id IN ($IDstring) ORDER BY id DESC");
	while($rs = $db->fetch_array($query)){
		$_erp=$Fid_db[tableid][$rs[fid]];
		$listdb[$rs[id]]=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id=$rs[id] $SQL");
	}
	//krsort($listdb);
	return $listdb;
}

//自动删除过期信息
function del_EndTimeInfo($rs){
	global $db,$_pre,$Fid_db,$timestamp,$webdb;
	if($webdb[Info_DelEndtime]&&$rs[endtime]&&$rs[endtime]<$timestamp){
		$_erp=$Fid_db[tableid][$rs[fid]];
		del_info($rs[id],$_erp,$rs);
		return 1;
	}
}

//删除信息
function del_info($id,$_erp,$rs){
	global $db,$_pre;
	$db->query("DELETE FROM `{$_pre}db` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}content$_erp` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}content_$rs[mid]` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}buyad` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}report` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}collection` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}comments` WHERE id='$id' ");
	$db->query("DELETE FROM `{$_pre}dianping` WHERE id='$id' ");
	//删除缓存
	$rs[city_id] && del_file(ROOT_PATH."cache/index/$rs[city_id]");
	del_file(ROOT_PATH."cache/list/$rs[city_id]-$rs[fid]");

	
	$query = $db->query("SELECT * FROM `{$_pre}pic` WHERE id='$id'");
	while($rs = $db->fetch_array($query)){
		delete_attachment($rs[uid],tempdir($rs[imgurl]));
		delete_attachment($rs[uid],tempdir("$rs[imgurl].gif"));
	}
}


/**
*获取信息内容
**/
function Info_list_content($where_sql,$order_sql,$leng=40,$fid_array,$_erp=''){
	global $db,$_pre,$Fid_db;
	if(is_array($fid_array)){
		$SQL_db[""]="(SELECT * FROM {$_pre}content $where_sql)";
		foreach($fid_array AS $key=>$value){
			$_erp=$Fid_db[tableid][$value];
			$SQL_db["$_erp"]="(SELECT * FROM {$_pre}content$_erp $where_sql)";
		}
		$SQL=implode(" UNION ALL ",$SQL_db).$order_sql;
	}else{
		$SQL="SELECT * FROM {$_pre}content$_erp $where_sql $order_sql";
	}
	$query=$db->query($SQL);
	while( $rs=$db->fetch_array($query) ){
		if(del_EndTimeInfo($rs)){	//自动删除过期信息
			continue;
		}
		$leng && $rs[title]=get_word($rs[full_title]=$rs[title],$leng);
		$rs[posttime]=date("Y-m-d",$rs[full_time]=$rs[posttime]);
		if($rs[picurl]){
			$rs[picurl]=tempdir($rs[picurl]);
		}
		$rs[url] = get_info_url($rs[id],$rs[fid],$rs[city_id],$rs[zone_id],$rs[street_id]);
		$listdb[]=$rs;
	}
	return $listdb;
}

/*
获取某个人的信息
*/
function user_info($uid,$rows,$min=0){
	global $Fid_db,$db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}db WHERE uid='$uid' ORDER BY id DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$_erp=$Fid_db[tableid][$rs[fid]];
		$rs=$db->get_one("SELECT * FROM {$_pre}content$_erp WHERE id='$rs[id]'");
		if(del_EndTimeInfo($rs)){	//自动删除过期信息
			continue;
		}
		$rs[posttime]=date("y-m-d H:i:s",$rs[posttime]);
		if($rs[picurl]){
			$rs[picurl]=tempdir($rs[picurl]);
		}
		$rs[url] = get_info_url($rs[id],$rs[fid],$rs[city_id],$rs[zone_id],$rs[street_id]);
		$listdb[]=$rs;
	}
	return $listdb;
}



/**
*获取信息内容
**/
function Get_Info($type,$rows=5,$leng=20,$fid=0,$mid=0,$cityid='city',$zoneid='city',$streetid='city'){
	global $Fid_db,$city_id,$zone_id,$street_id,$webdb,$timestamp;

	if($fid){
		$fidstring=$fid;
		foreach( $Fid_db[$fid] AS $keyfid=>$value){
			$fidstring .=",$keyfid";
			$fid_array[]=$keyfid;
		}
		$fid_array && $fid_array[]=$fid;
		$SQL .=" AND fid IN ($fidstring) ";
	}elseif($mid>0){
		$SQL=" AND mid='$mid' ";
	}

	$cityid=='city'		&&	$cityid=$city_id;
	$zoneid=='city'		&&	$zoneid=$zone_id;
	$streetid=='city'	&&	$streetid=$street_id;

	if($streetid>0){
		$SQL .=" AND street_id='$streetid' ";
	}elseif($zoneid>0){
		$SQL .=" AND zone_id='$zoneid' ";
	}elseif($cityid>0){
		$SQL .=" AND city_id='$cityid' ";
	}

	if(!$webdb[Info_ShowNoYz]){
		$SQL .=" AND yz='1' ";
	}

	if($type=='hot'){
		$SQL=" WHERE 1 $SQL";
		$SQL_ORDER=" ORDER BY hits DESC LIMIT $rows ";
	}elseif($type=='lastview'){
		$SQL=" WHERE 1 $SQL ";
		$SQL_ORDER=" ORDER BY lastview DESC LIMIT $rows ";
	}elseif($type=='new'){
		$SQL=" WHERE 1 $SQL ";
		$SQL_ORDER=" ORDER BY list DESC LIMIT $rows ";
	}elseif($type=='level'){
		$SQL=" WHERE levels=1 $SQL ";
		$SQL_ORDER=" ORDER BY list DESC LIMIT $rows ";
	}elseif($type=='pic'){
		$SQL=" WHERE ispic=1 $SQL ";
		$SQL_ORDER=" ORDER BY list DESC LIMIT $rows ";
	}else{
		return ;
	}
	$_erp=$Fid_db[tableid][$fid];
	$listdb=Info_list_content(" $SQL ",$SQL_ORDER,$leng=40,$fid_array,$_erp);
	return $listdb;
}

/**
*获取焦点信息内容
**/
function Get_AdInfo($sortid=0,$rows=10,$leng=40,$cityid='city'){
	global $db,$_pre,$timestamp,$city_id;

	$cityid=='city' && $cityid=$city_id;
	$cityid>0 && $SQL =" AND cityid = '$cityid' ";

	$query = $db->query("SELECT * FROM {$_pre}buyad WHERE sortid='$sortid' AND endtime>$timestamp $SQL ORDER BY money DESC,aid DESC LIMIT $rows");
	while($rs = $db->fetch_array($query)){
		$iddb[]=$rs[id];
	}
	$listdb=get_id_info(implode(",",$iddb));
	return $listdb;
}

 
function highlight_keyword($content){
	global $db,$pre,$keywordDB,$webdb,$Mdomain;
	return $content;
}

/**
*获取用户的来源城市
**/
function get_area($ip){
	global $city_DB;
	$area=ipfrom($ip);
	foreach( $city_DB[name] AS $key2=>$value2)
	{
		$value2=str_replace(array("市","区"," "),array("","",""),$value2);
		if(strstr($area,$value2)){
			return $key2;
		}
	}
}

/**
*主要提供给城市,区域,地段的选择使用
**/
function select_where($table,$name='fup',$ck='',$fup=''){
	global $db,$city_DB;
	/*
	if($fup){
		$SQL=" WHERE fup='$fup' ";
	}
	$query = $db->query("SELECT * FROM $table $SQL ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$ck==$rs[fid]?" selected ":" ";
		$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
	}
	*/
	if(!$fup){
		foreach( $city_DB[name] AS $key=>$value){
			$ckk=$ck==$key?" selected ":" ";
			$show.="<option value='$key' $ckk>$value</option>";
		}
	}elseif($fup){
		if(strstr($name,'zone')&&is_file(ROOT_PATH."data/zone/$fup.php")){
			include(ROOT_PATH."data/zone/$fup.php");
			foreach( $zone_DB[name] AS $key=>$value){
				$ckk=$ck==$key?" selected ":" ";
				$show.="<option value='$key' $ckk>$value</option>";
			}
		}else{
			$query = $db->query("SELECT * FROM $table WHERE fup='$fup' ORDER BY list DESC");
			while($rs = $db->fetch_array($query)){
				$ckk=$ck==$rs[fid]?" selected ":" ";
				$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
			}
		}
	}
	return "<select id='$table' name=$name><option value=''>请选择</option>$show</select>";
}




/**
*选择自定义二级域名或二级目录
**/
function choose_domain(){
	global $city_id,$city_DB,$WEBURL,$Mdomain,$jobs;
	if($jobs=='show'){
		return ;	//更新标签的时候,不需要判断域名
	}
	$_dirname=$city_DB['dirname'][$city_id];
	if($_dirname&&is_dir(Mpath."$_dirname"))
	{
		$_domain=$city_DB[domain][$city_id];
		if($_domain){
			if(!strstr($WEBURL,$_domain)){
				if(eregi("index\.php$",$WEBURL)){
					$url=preg_replace("/(.*)\/([^\/]*)/is","$_domain/",$WEBURL);
					echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>";
					exit;
				}
				$url=preg_replace("/(.*)\/([^\/]*)/is","$_domain/\\2",$WEBURL);
				echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$url'>";
				exit;
			}
		}else{/*
			$__dirname=preg_replace("/(.*)\/([^\/]*)\/([^\/]*)/is","\\2",$WEBURL);
			if(!strstr($__dirname,'.')&&$__dirname!=$_dirname){
				$___name=preg_replace("/(.*)\/([^\/]*)\/([^\/]*)/is","\\3",$WEBURL);
				echo "META HTTP-EQUIV=REFRESH CONTENT='0;URL=$Mdomain/$_dirname/$___name'>";
				exit;
			}*/
		}
	}
}


/**
*显示首页推荐栏目的功能函数
**/
function Info_ListMoreSort($rows,$leng,$cityid='city'){
	global $db,$_pre,$fid,$city_id,$zone_id,$street_id,$timestamp,$webdb,$Fid_db;
	$rows>0 || $rows=7;
	$leng>0 || $leng=30;
	$cityid=='city' && $cityid=$city_id;
	if($cityid>0){
		$_SQL .=" AND city_id='$cityid' ";
	}
	if(!$webdb[Info_ShowNoYz]){
		$_SQL .=" AND yz='1' ";
	}
	foreach( $Fid_db[index_show] AS $key=>$value){
		$_erp=$Fid_db[tableid][$key];
		$rs[name]=$value;
		$rs[fid]=$key;
		$rs[article]=Info_list_content(" WHERE fid=$key $_SQL "," ORDER BY list DESC LIMIT $rows ",$leng,'',$_erp);
		$listdb[]=$rs;
	}
	return $listdb;
}

/**
*获取每个栏目有几条信息
**/
function get_infonum($cityid){
	global $db,$_pre;
	if($cityid>0){
		$SQL=" AND city_id = '$cityid' ";
	}
	$query = $db->query("SELECT count(id) AS NUM, `fid` FROM `{$_pre}db` WHERE 1 $SQL GROUP BY `fid`");
	while($rs = $db->fetch_array($query)){
		$InfoNum[$rs[fid]]=$rs[NUM];
	}
	return $InfoNum;
}

//SEO变量
function seo_eval($string){
	global $city_DB,$fidDB,$city_id,$zone_id,$street_id,$zone_DB,$street_DB;
	$string=str_replace(
		array('{city_name}','{zoon_name}','{street_name}','{sort_name}'),
		array($city_DB['name'][$city_id],$zone_DB['name'][$zone_id],$street_DB['name'][$street_id],$fidDB['name']),
		$string);
	return $string;
}


//一般是后台使用的得到栏目的导航
function get_guide($fid,$url){
	global $db,$_pre;
	$query = $db->query("SELECT * FROM {$_pre}sort WHERE fid='$fid' ");
	while($rs = $db->fetch_array($query)){
		$show=" -&gt; <A href='list.php?fid=$rs[fid]'>$rs[name]</A>".$show;
		if($rs[fup]){
			$show=get_guide($rs[fup],$url).$show;
		}
	}
	return $show;
}

//一般是后台使用的生成栏目相关缓存
function fid_cache(){
	global $db,$_pre,$webdb;
	$query = $db->query("SELECT * FROM {$_pre}sort ORDER BY list DESC LIMIT 800");
	while($rs = $db->fetch_array($query)){
		if($rs[index_show]){
			$Fid_db[index_show][$rs[fid]]=$rs[name];
		}
		if($rs[tableid]){
			$Fid_db[tableid][$rs[fid]]=$rs[tableid];
		}
		if($rs[dir_name]){
			$Fid_db[dir_name][$rs[fid]]=$rs[dir_name];
		}
		if($rs[ifcolor]){
			$Fid_db[ifcolor][$rs[fid]]=$rs[ifcolor];
		}
		$Fid_db[$rs[fup]][$rs[fid]]=$rs[name];
		$Fid_db[name][$rs[fid]]=$rs[name];
		$Fid_db[mid][$rs[fid]]=intval($rs[mid]);

		$GuideFid[$rs[fid]]=get_guide($rs[fid]);
	}

	write_file(ROOT_PATH."data/all_fid.php","<?php\r\nreturn ".var_export($Fid_db,true).';?>');
	write_file(ROOT_PATH."data/guide_fid.php","<?php\r\n\$GuideFid=".var_export($GuideFid,true).';?>');
}

//一般是后台使用的列出模型供选择使用
function select_module($name,$ck=0){
	global $db,$_pre;
	$show="<select name='$name' $reto>";
	$query = $db->query("SELECT * FROM {$_pre}module ORDER BY LIST DESC");
	while($rs = $db->fetch_array($query)){
		$ck==$rs[id]?$ckk='selected':$ckk='';
		$show.="<option value='$rs[id]' $ckk>$rs[name]</option>";
	}
	return $show." </select>";   
}


//发布页的随机变量处理，防止发贴机
function check_rand_num($rand_num){
	global $webdb,$timestamp,$db,$pre;
	if($webdb['rand_num_mktime']<1){
		return true;
	}
	if($webdb['rand_num'] && $rand_num!=$webdb['rand_num']){
		return false;
		//die('系统随机码失效,请返回,刷新一下页面,再重新输入数据,重新提交!');
	}
	if(($timestamp-$webdb['rand_num'])>$webdb['rand_num_mktime']*3600){
		
		$source = 'QWERTYUIOPLKJHGFDSAZXCVBNM';
		for($i=0;$i<rand(1,5);$i++)
		$ck .= $source{mt_rand(0, strlen($source) -1)};
		$webdb['rand_num_inputname']=$ck;
		$webdb['rand_num']=$timestamp;
		$db->query("REPLACE INTO `{$pre}config` (`c_key` ,`c_value` )VALUES ('rand_num', '{$webdb[rand_num]}')");
		$db->query("REPLACE INTO `{$pre}config` (`c_key` ,`c_value` )VALUES ('rand_num_inputname', '{$webdb[rand_num_inputname]}')");
		$writefile="<?php\r\n";
		$query = $db->query("SELECT * FROM {$pre}config");
		while($rs = $db->fetch_array($query)){
			$rs[c_value]=addslashes($rs[c_value]);
			$writefile.="\$webdb['$rs[c_key]']='$rs[c_value]';\r\n";
		}

		write_file(ROOT_PATH."data/config.php",$writefile.'?>');
	}
	return true;
}



//自动刷新功能
function refurbish_info($update=false){
	global $db,$_pre,$Fid_db,$timestamp;
	if(!$_pre){
		return ;
	}
	$Tdb = array();
	if($update){
		$query = $db->query("SELECT A.*,B.id AS tid FROM {$_pre}refurbish A LEFT JOIN {$_pre}db B ON A.id=B.id");
		while($rs = $db->fetch_array($query)){
			if(!$rs['tid']){	//信息被删除后，这里也要删除掉
				$db->query("DELETE FROM {$_pre}refurbish WHERE id='$rs[id]'");
				continue;
			}
			$detail=explode("#",$rs['times']);
			foreach($detail AS $value){
				if($value){
					while($Tdb["$value"]){	//雷同刷新的时间要特别处理
						$value++;
					}
					$Tdb["$value"]=intval($rs[id]);
				}
			}
			if($rs['refurbish_time']){
				$Rdb[intval($rs[id])]=$rs['refurbish_time'];
			}
		}
	}else{
		@include(ROOT_PATH.'data/refurbish_id.php');
	}

	refurbish_info_run($Tdb,$Rdb,$_pre,$Fid_db,$update);
}


?>