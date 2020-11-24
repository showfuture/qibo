<?php
function_exists('html') OR exit('ERR');

ck_power('city');

if(!table_field("{$_pre}city",'maps')){
	$db->query("ALTER TABLE  `{$_pre}city` ADD  `maps` VARCHAR( 50 ) NOT NULL ;");
}

$linkdb=array("地域/省份管理"=>"$admin_path&job=listsort","城市管理"=>"$admin_path&job=city","城市辖区管理"=>"$admin_path&job=zone","地段管理"=>"$admin_path&job=street","批量操作"=>"$admin_path&job=batch");

if(!function_exists('MODULE_CK')||!in_array('fenlei',$BIZ_MODULEDB)){
	unset($linkdb["批量操作"]);
}

if($job=="listsort")
{

	$fid=intval($fid);
	$sortdb=array();
	list_city_allsort(0,$table='area');
	$sort_fup=$Guidedb->Select("{$_pre}area","fup",$fid);

	get_admin_html('sort');
}
elseif($action=="addsort")
{
	if($fup){
		$rs=$db->get_one("SELECT name,class FROM {$_pre}area WHERE fid='$fup' ");
		$class=$rs['class'];
		$db->query("UPDATE {$_pre}area SET sons=sons+1 WHERE fid='$fup'");
		$type=0;
	}else{
		$class=0;
	}
	$type=0;	/*分类标志*/
	$class++;
	$db->query("INSERT INTO {$_pre}area (name,fup,class,type,allowcomment) VALUES ('$name','$fup','$class','$type',1) ");
	@extract($db->get_one("SELECT fid FROM {$_pre}area ORDER BY fid DESC LIMIT 0,1"));
	
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","创建成功");
}
elseif($action=="addcity")
{
	$rs=$db->get_one("SELECT * FROM {$_pre}area WHERE fid='$fup' ");
	if(!$rs){
		showerr("请选择一个省份");
	}
	$rs=$db->get_one("SELECT COUNT(*) AS NUM FROM {$_pre}area WHERE fup='$fup' ");
	if($rs[NUM]){
		showerr("你不能选择大分类");
	}

	require_once(ROOT_PATH."inc/pinyin.php");

	$detail=explode("\r\n",$name);
	foreach( $detail AS $key=>$name){
		if(!$name){
			continue;
		}
		$letter=change2pinyin($name,1);
		$letter=substr($letter,0,1);
		if(strstr($name,'重庆')&&$letter=='Z'){
			$letter='C';
		}
		$db->query("INSERT INTO {$_pre}city (name,fup,class,type,letter) VALUES ('$name','$fup','0','0','$letter') ");
	}
	refreshto("$FROMURL","创建成功");
}
elseif($job=="city")
{
	if($fup){
		$SQL=" WHERE fup='$fup' ";
	}else{
		$SQL=" ";
	}
	unset($sortdb,$infodb);
	$query = $db->query("SELECT * FROM {$_pre}city $SQL ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$sortdb[]=$rs;
	}

	$query = $db->query("SELECT `city_id`,count(*) AS NUM FROM `{$_pre}db` GROUP BY `city_id`");
	while($rs = $db->fetch_array($query)){
		$infodb[$rs[city_id]]=$rs[NUM];
	}

	$sort_fup=$Guidedb->Select("{$_pre}area","fup",$fup);

	get_admin_html('city');
}
elseif($action=="addzone")
{
	$rs=$db->get_one("SELECT * FROM {$_pre}city WHERE fid='$fup' ");
	if(!$rs){
		showerr("请选择一个城市");
	}
	
	$detail=explode("\r\n",$name);
	foreach( $detail AS $key=>$name){
		if(!$name){
			continue;
		}
		$db->query("INSERT INTO {$_pre}zone (name,fup,class,type,allowcomment) VALUES ('$name','$fup','0','0',1) ");
	}
	
	refreshto("$FROMURL","创建成功",0);
}
elseif($job=="zone")
{
	if($fup){
		$SQL=" WHERE fup='$fup' ";
	}else{
		$SQL=" ";
	}
	if(!$page){
		$page=1;
	}
	$rows=100;
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}zone","$SQL","$admin_path&job=$job&fup=$fup",$rows);
	$query = $db->query("SELECT * FROM {$_pre}zone $SQL ORDER BY list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$sortdb[]=$rs;
	}

	$sort_fup=select_fup("{$_pre}city",'fup',$fup);
	$get_area_guide=get_area_guide($fup);

	get_admin_html('zone');
}
elseif($action=="addstreet")
{
	$rs=$db->get_one("SELECT * FROM {$_pre}zone WHERE fid='$fup' ");
	if(!$rs){
		refreshto("$admin_path&job=zone","请选择一个城市辖区",3);
	}
	
	$detail=explode("\r\n",$name);
	foreach( $detail AS $key=>$name){
		if(!$name){
			continue;
		}
		$db->query("INSERT INTO {$_pre}street (name,fup,class,type,allowcomment) VALUES ('$name','$fup','0','0',1) ");
	}	
	refreshto("$FROMURL","创建成功",0);
}
elseif($job=="street")
{
	if($fup){
		$SQL=" WHERE fup='$fup' ";
	}else{
		$SQL=" ";
	}
	if(!$page){
		$page=1;
	}
	$rows=100;
	$min=($page-1)*$rows;
	$showpage=getpage("{$_pre}street","$SQL","$admin_path&job=$job&fup=$fup",$rows);
	$query = $db->query("SELECT * FROM {$_pre}street $SQL ORDER BY list DESC LIMIT $min,$rows");
	while($rs = $db->fetch_array($query)){
		$_rs=$db->get_one("SELECT name,fup FROM {$_pre}zone WHERE fid='$rs[fup]'");
		$rs[zone]=$_rs[name];
		$_rss=$db->get_one("SELECT name,fid FROM {$_pre}city WHERE fid='$_rs[fup]'");
		$rs[city]=$_rss[name];
		$rs[cityid]=$_rss[fid];
		$rs[city_id]=$_rss[fid];
		$sortdb[]=$rs;
	}
	$rsdb=$db->get_one("SELECT * FROM {$_pre}zone WHERE fid='$fup' ");
	$get_area_guide=get_area_guide(0,$fup);

	get_admin_html('street');
}
//修改栏目信息
elseif($job=="editsort")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT * FROM {$_pre}area WHERE fid='$fid'");

	$sort_fid=$Guidedb->Select("{$_pre}area","postdb[fid]",$fid,"$admin_path&job=$job");
	$sort_fup=$Guidedb->Select("{$_pre}area","postdb[fup]",$rsdb[fup]);

 	$typedb[$rsdb[type]]=" checked ";

	get_admin_html('editsort');
}
elseif($job=="edit_city")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT * FROM {$_pre}city WHERE fid='$fid'");
	$sort_fup=$Guidedb->Select("{$_pre}area","postdb[fup]",$rsdb[fup]);
 
	if(!$rsdb['dirname']){
		require_once(ROOT_PATH."inc/pinyin.php");
		$rsdb['dirname']=change2pinyin($rsdb[name],1);
	}
	list($head,$foot,$index)=explode("|",$rsdb[template]);

	$hits[$rsdb[hits]]=' checked ';

	$Adminpath=Adminpath.'apache.txt ';

	get_admin_html('edit_city');
}
elseif($job=="edit_zone")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT * FROM {$_pre}zone WHERE fid='$fid'");
	$sort_fup=Select_fup("{$_pre}city","postdb[fup]",$rsdb[fup]);

	if(!$rsdb['dirname']){
		require_once(ROOT_PATH."inc/pinyin.php");
		$rsdb['dirname']=change2pinyin($rsdb[name],1);
	}

	get_admin_html('edit_zone');
}
elseif($action=="edit_zone")
{
	if($postdb['dirname']&&!eregi("^([_a-z0-9]+)$",$postdb['dirname'])){
		showerr("目录名只能是英文或数字!");
	}
	if(!$postdb[name]){
		showerr("名称不能为空");
	}
	$db->query("UPDATE {$_pre}zone SET fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',dirname='$postdb[dirname]',forbidshow='$postdb[forbidshow]',config='$postdb[config]'$SQL WHERE fid='$postdb[fid]' ");

	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功");
}
elseif($job=="edit_street")
{
	$postdb[fid] && $fid=$postdb[fid];
	$rsdb=$db->get_one("SELECT * FROM {$_pre}street WHERE fid='$fid'");

	if(!$rsdb['dirname']){
		require_once(ROOT_PATH."inc/pinyin.php");
		$rsdb['dirname']=change2pinyin($rsdb[name],1);
	}

	get_admin_html('edit_street');
}
elseif($action=="edit_street")
{
	if($postdb['dirname']&&!eregi("^([_a-z0-9]+)$",$postdb['dirname'])){
		showerr("目录名只能是英文或数字!");
	}
	if(!$postdb[name]){
		showerr("名称不能为空");
	}
	$db->query("UPDATE {$_pre}street SET name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',dirname='$postdb[dirname]',forbidshow='$postdb[forbidshow]',config='$postdb[config]'$SQL WHERE fid='$postdb[fid]' ");

	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="editsort")
{
	//检查父栏目是否有问题
	check_fup("{$_pre}area",$postdb[fid],$postdb[fup]);
	unset($SQL);
	$rs_fid=$db->get_one("SELECT * FROM {$_pre}area WHERE fid='$postdb[fid]'");
	if($rs_fid[fup]!=$postdb[fup])
	{
		$rs_fup=$db->get_one("SELECT class FROM {$_pre}area WHERE fup='$postdb[fup]' ");
		$newclass=$rs_fup['class']+1;
		$db->query("UPDATE {$_pre}area SET sons=sons+1 WHERE fup='$postdb[fup]' ");
		$db->query("UPDATE {$_pre}area SET sons=sons-1 WHERE fup='$rs_fid[fup]' ");
		$SQL=",class=$newclass";
	}
	$db->query("UPDATE {$_pre}area SET fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',dirname='$postdb[dirname]',forbidshow='$postdb[forbidshow]',config='$postdb[config]'$SQL WHERE fid='$postdb[fid]' ");

	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="edit_city")
{
	if($postdb['dirname']){
		if( !eregi("^[_a-z0-9\.\/]+$",$postdb['dirname']) ){
			showerr("目录名称只能是:数字,字母,下画线");
		}
		if( $db->get_one("SELECT * FROM {$_pre}city WHERE dirname='$postdb[dirname]' AND fid!='$postdb[fid]'") ){
			showerr("目录名称已经存在了,请更换一个");
		}
		if($createdir){
			write_city_file($postdb['dirname'],$postdb[fid]);
		}
	}

	$lettername=basename($postdb['dirname']);
	$letter=strtoupper($lettername{0}); 
	if(!ereg("^[A-Z]$",$letter)){
		require_once(ROOT_PATH."inc/pinyin.php");
		$letter=change2pinyin($postdb[name],1);
		$letter=substr($letter,0,1);
		if(strstr($postdb[name],'重庆')&&$letter=='Z'){
			$letter='C';
		}
	}

	if($postdb[domain]){
		if(!strstr($postdb[domain],"://")){
			$postdb[domain]="http://$postdb[domain]";
		}
		$postdb[domain]=preg_replace("/(.*)\/$/","\\1",$postdb[domain]);;
		
	}
	
	foreach( $postdb[tpl] AS $key=>$value){
		if($value){
			if(!ereg(".htm$",$value)){
				showerr("模板只能是.htm这种格式:$value");
			}elseif(!is_file(Mpath."$value")){
				showerr("模板路径有误:$value");
			}
		}else{
			unset($postdb[tpl][$key]);
		}
	}
	if($postdb[head]&&!is_file(Mpath."$postdb[head]")){
		showerr("头部文件不存在");
	}elseif($postdb[foot]&&!is_file(Mpath."$postdb[foot]")){
		showerr("尾部文件不存在");
	}elseif($postdb[index]&&!is_file(Mpath."$postdb[index]")){
		showerr("主页文件不存在");
	}
	$postdb[template]="$postdb[head]|$postdb[foot]|$postdb[index]|";

	$db->query("UPDATE {$_pre}city SET fup='$postdb[fup]',name='$postdb[name]',type='$postdb[type]',admin='$postdb[admin]',passwd='$postdb[passwd]',logo='$postdb[logo]',descrip='$postdb[descrip]',metakeywords='$postdb[metakeywords]',metadescription='$postdb[metadescription]',style='$postdb[style]',template='$postdb[template]',jumpurl='$postdb[jumpurl]',listorder='$postdb[listorder]',maxperpage='$postdb[maxperpage]',allowcomment='$postdb[allowcomment]',allowpost='$postdb[allowpost]',allowviewtitle='$postdb[allowviewtitle]',allowviewcontent='$postdb[allowviewcontent]',dirname='$postdb[dirname]',forbidshow='$postdb[forbidshow]',letter='$letter',domain='$postdb[domain]',hits='$postdb[hits]',maps='$postdb[maps]' WHERE fid='$postdb[fid]' ");

	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功");
}
elseif($action=="delete")
{
	$db->query(" DELETE FROM `{$_pre}area` WHERE fid='$fid' ");
	
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto($FROMURL,"删除成功");
}
elseif($action=="delete_city")
{
	extract( $db->get_one("SELECT COUNT(*) AS NUM FROM `{$_pre}city`"));
	if($NUM==1){
		showerr("你不能把城市全部删除掉!!");
	}	 
	$db->query(" DELETE FROM `{$_pre}city` WHERE fid='$fid' ");
	
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto($FROMURL,"删除成功");
}
elseif($action=="delete_zone")
{
	$db->query(" DELETE FROM `{$_pre}zone` WHERE fid='$fid' ");
	
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto($FROMURL,"删除成功");
}
elseif($action=="delete_street")
{
	$db->query(" DELETE FROM `{$_pre}street` WHERE fid='$fid' ");
	
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto($FROMURL,"删除成功");
}
elseif($action=="editlist")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}area SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功",1);
}
elseif($action=="editlist_city")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}city SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功",1);
}
elseif($action=="editlist_zone")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}zone SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功",1);
}
elseif($action=="editlist_street")
{
	foreach( $order AS $key=>$value){
		$db->query("UPDATE {$_pre}street SET list='$value' WHERE fid='$key' ");
	}
	mod_sort_class("{$_pre}area",0,0);		//更新class
	mod_sort_sons("{$_pre}area",0);			//更新sons
	/*更新导航缓存*/
	area_cache_guide();
	refreshto("$FROMURL","修改成功",1);
}
elseif($job=="batch")
{
	get_admin_html('batch');
}
elseif($action=="batch")
{
	set_time_limit(0);
	require_once(ROOT_PATH."inc/pinyin.php");
	if($type=="zone_dir"){
		$query = $db->query("SELECT * FROM {$_pre}zone");
		while($rs = $db->fetch_array($query)){
			if($replaceold||!$rs['dirname']){
				$rs['dirname']=$big_letter?change2pinyin($rs[name],1):change2pinyin($rs[name]);
				$rs['dirname']=preg_replace("/(\/|\\\|-| |')/","_",$rs['dirname']);
				$db->query("UPDATE {$_pre}zone SET dirname='{$rs[dirname]}' WHERE fid='$rs[fid]'");
			}
		}
		area_cache_guide();
	}elseif($type=="street_dir"){
		$query = $db->query("SELECT * FROM {$_pre}street");
		while($rs = $db->fetch_array($query)){
			if($replaceold||!$rs['dirname']){
				$rs['dirname']=$big_letter?change2pinyin($rs[name],1):change2pinyin($rs[name]);
				$rs['dirname']=preg_replace("/(\/|\\\|-| |')/","_",$rs['dirname']);
				$db->query("UPDATE {$_pre}street SET dirname='{$rs[dirname]}' WHERE fid='$rs[fid]'");
			}
		}
		area_cache_guide();
	}elseif($type=="city_dir"){
		if($domain2&&!ereg("^([-_a-z0-9\.]+)$",$domain2)){
			showerr("域名有误,只能是这种格式如:abc.com");
		}
		if($page<2){
			if($replaceold||$domain2=='0'){
				$db->query("UPDATE {$_pre}city SET dirname='',domain=''");
			}
		}
		$rows=5;
		$page<1 && $page=1;
		$min=($page-1)*$rows;
		$query = $db->query("SELECT * FROM {$_pre}city ORDER BY fid DESC LIMIT $min,$rows");
		while($rs = $db->fetch_array($query)){

			if($domain2!='0'&&($replaceold||!$rs['dirname'])){
				$rs['dirname']=change2pinyin($rs[name],1);
				$rs['dirname']=str_replace("ZhongQing","ChongQing",$rs['dirname']);
				$rs['dirname']=preg_replace("/(\/|\\\|-| |')/","_",$rs['dirname']);
				if($db->get_one("SELECT * FROM {$_pre}city WHERE dirname='{$rs[dirname]}' AND fid!='$rs[fid]'")){
					$rs['dirname'].=$rs[fid];
				}
				$SQL="";
				if($domain2){
					$domain=strtolower($rs['dirname']).".$domain2";
					$SQL=",domain='http://$domain'";
				}elseif($domain2=='0'){
					$SQL=",domain=''";
				}
				if($citydir==2){
					$rs['dirname']="$rs[dirname]";
				}elseif($citydir==3){
					$rs['dirname']="city/$rs[dirname]";
				}
				$db->query("UPDATE {$_pre}city SET dirname='{$rs[dirname]}'$SQL WHERE fid='$rs[fid]'");
			}

			//生成二级目录
			write_city_file($rs['dirname'],$rs[fid]);
			$ckk++;
		}
		if($ckk){
			$page++;
			echo "请稍候$page....<META HTTP-EQUIV=REFRESH CONTENT='0;URL=$admin_path&action=$action&type=$type&domain2=$domain2&citydir=$citydir&page=$page&replaceold=$replaceold'>";
			exit;
		}else{
			area_cache_guide();
		}		
	}
	refreshto("$admin_path&job=$action","操作成功",1);
}
/**
*更新缓存
**/
function area_cache_guide(){
	global $db,$_pre;
	$show="<?php\r\n";
	$query = $db->query("SELECT fid,fup,name FROM {$_pre}area ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$rs[name]=addslashes($rs[name]);
		$show.="
		\$area_DB[{$rs[fup]}][{$rs[fid]}]='$rs[name]';
		\$area_DB[name][{$rs[fid]}]='$rs[name]';
		\$area_DB[fup][{$rs[fid]}]='$rs[fup]';
		";
	}
	write_file(ROOT_PATH."data/all_area.php",$show);
	city_cache_guide();
}


function city_cache_guide(){
	global $db,$_pre,$webdb;
	$dir=opendir(ROOT_PATH."data/zone/");
	while($f=readdir($dir)){
		if(eregi(".php$",$f)){
			unlink(ROOT_PATH."data/zone/$f");
		}
	}
	$show="<?php\r\nunset(\$city_DB);";
	$query = $db->query("SELECT fid,fup,name,domain,dirname,template,descrip,metakeywords,metadescription,hits FROM {$_pre}city ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$rs[name]=addslashes($rs[name]);
		unset($_dirname,$_domain,$_tpl,$_T,$_K,$_D,$_HITS,$_maps);

		if($rs['dirname']&&is_dir(ROOT_PATH."$rs[dirname]")){	//生成目录的时候

			$rs[domain]=preg_replace("/^http:\/\/(.*)\/$/is","http://\\1",$rs[domain]);
			$_dirname="\$city_DB['dirname'][{$rs[fid]}]='$rs[dirname]';";

			if($rs[domain]){	//有二级域名的时候

				$_domain="\$city_DB[domain][{$rs[fid]}]='$rs[domain]';";
				$_url="\$city_DB[url][{$rs[fid]}]='$rs[domain]/';";
				$conf.='
<VirtualHost *:80>
DocumentRoot '.ROOT_PATH."$rs[dirname]".'
ServerName '.preg_replace("/^http:\/\/(.*)/is","\\1",$rs[domain]).'
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^/([^\/]+)/f([^\/]+)\.([a-zA-Z0-9]+)$ /bencandy\.php\?Fid=$1&Id=$2
RewriteRule ^/([^\/]+)/$ /list\.php\?Fid=$1
RewriteRule ^/([^\/]+)/([^\/]+)/$ /list\.php\?Fid=$2&zone_street=$1
RewriteRule ^(.*)/(list|bencandy)-([^\/]+)\.([a-zA-Z0-9]+)$ $1/$2\.php\?stringID=$3
RewriteRule ^(.*)/post\.([a-z]+)$ $1/post\.php
RewriteRule ^(.*)/post-([0-9]+)-([0-9]+)\.([a-z]+)$ $1/post\.php\?fid=$2&city_id=$3
RewriteRule ^(.*)/post-edit-([0-9]+)-([0-9]+)\.([a-z]+)$ $1/post\.php\?job=edit&fid=$2&id=$3
RewriteRule ^(.*)/post-del-([0-9]+)-([0-9]+)\.([a-z]+)$ $1/post\.php\?action=del&fid=$2&id=$3
</IfModule>
</VirtualHost>
';
			}else{	//没二级域名的时候
				$_url="\$city_DB[url][{$rs[fid]}]=\$webdb['www_url'].'/$rs[dirname]/';";
			}

		}else{	//不生成目录的时候
			$_url="\$city_DB[url][{$rs[fid]}]=\$webdb[www_url].'/index.php?choose_cityID=$rs[fid]';";			
		}
		if($rs[template]&&$rs[template]!='|||'){
			$rs[template]=addslashes($rs[template]);
			$_tpl="\$city_DB[tpl][{$rs[fid]}]='$rs[template]';";
		}
		if($rs[descrip]){
			$rs[descrip]=addslashes($rs[descrip]);
			$_T="\$city_DB[metaT][{$rs[fid]}]='$rs[descrip]';";
		}
		if($rs[metakeywords]){
			$rs[metakeywords]=addslashes($rs[metakeywords]);
			$_K="\r\n\$city_DB[metaK][{$rs[fid]}]='$rs[metakeywords]';";
		}
		if($rs[metadescription]){
			$rs[metadescription]=addslashes($rs[metadescription]);
			$_D="\r\n\$city_DB[metaD][{$rs[fid]}]='$rs[metadescription]';";
		}
		if($rs[hits]){
			$_HITS="\r\n\$city_DB[hits][{$rs[fid]}]='$rs[hits]';";
		}
		if($rs[maps]){
			$_maps="\r\n\$city_DB[maps][{$rs[fid]}]='$rs[maps]';";
		}
		
		$show.="
\$city_DB[{$rs[fup]}][{$rs[fid]}]='$rs[name]';
\$city_DB[name][{$rs[fid]}]='$rs[name]';
\$city_DB[fup][{$rs[fid]}]='$rs[fup]';
$_url
$_dirname
$_domain
$_tpl
$_T$_K$_D$_HITS$_maps
";
		zone_cache_guide($rs[fid]);
		//$letter=change2pinyin($rs[name],1);
		//$letter=substr($letter,0,1);
		//$db->query("UPDATE {$_pre}city SET letter='$letter' WHERE fid='$rs[fid]'");
	}
	write_file(ROOT_PATH."data/all_city.php",$show.'?>');
	$conf && write_file(dirname(__FILE__)."/apache.txt",$conf);
}
function zone_cache_guide($fup){
	global $db,$_pre;
	if(!$fup){
		return ;
	}
	$show="<?php\r\n";
	$query = $db->query("SELECT fid,fup,name,dirname FROM {$_pre}zone WHERE fup='$fup' ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$rs[name]=addslashes($rs[name]);
		$show.="
		\$zone_DB[name][{$rs[fid]}]='$rs[name]';
		\$zone_DB[fup][{$rs[fid]}]='$rs[fup]';
		\$zone_DB['dirname'][{$rs[fid]}]='$rs[dirname]';
		";
		$query2 = $db->query("SELECT fid,fup,name,dirname FROM {$_pre}street WHERE fup='$rs[fid]' ORDER BY list DESC");
		while($rs2 = $db->fetch_array($query2)){
			$rs2[name]=addslashes($rs2[name]);
			$show.="
			\$street_DB[{$rs2[fup]}][{$rs2[fid]}]='$rs2[name]';
			\$street_DB[name][{$rs2[fid]}]='$rs2[name]';
			\$street_DB[fup][{$rs2[fid]}]='$rs2[fup]';
			\$street_DB['dirname'][{$rs2[fid]}]='$rs2[dirname]';
			";
		}
		$ckkk++;
	}
	if(!$ckkk){
		return ;
	}
	if(!is_dir(ROOT_PATH."data/zone/")){
		mkdir(ROOT_PATH."data/zone/");
		chmod(ROOT_PATH."data/zone/",0777);
	}
	write_file(ROOT_PATH."data/zone/$fup.php",$show.'?>');
}

/*栏目列表*/
function list_city_allsort($fid,$table='sort'){
	global $db,$_pre,$sortdb;
	$query=$db->query("SELECT * FROM {$_pre}$table where fup='$fid' ORDER BY list DESC");
	while( $rs=$db->fetch_array($query) ){
		$_rs=$db->get_one("SELECT COUNT(*) AS sons FROM {$_pre}$table where fup='$rs[fid]'");
		$rs[sons]=$_rs[sons];
		$_rs=$db->get_one("SELECT COUNT(*) AS num FROM {$_pre}city where fup='$rs[fid]'");
		$rs[num]=$_rs[num];
		$icon="";
		for($i=1;$i<$rs['class'];$i++){
			$icon.="&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;";
		}
		if($icon){
			$icon=substr($icon,0,-24);
			$icon.="--";
		}
		$rs[config]=unserialize($rs[config]);
		$rs[icon]=$icon;
		$sortdb[]=$rs;
		list_city_allsort($rs[fid],$table);
	}
}

function select_fup($table,$name='fup',$ck=''){
	global $db;
	$query = $db->query("SELECT * FROM $table ORDER BY list DESC");
	while($rs = $db->fetch_array($query)){
		$ckk=$ck==$rs[fid]?" selected ":" ";
		$show.="<option value='$rs[fid]' $ckk>$rs[name]</option>";
	}
	return "<select name='$name'><option value=''>请选择</option>$show</select>";
}

function get_area_guide($cityid=0,$zoneid=0){
	global $db,$_pre,$admin_path;
	if($zoneid){
		$SQL="SELECT A.name AS city,A.fid AS cityid,B.name AS zone,B.fid AS zoneid FROM {$_pre}city A LEFT JOIN {$_pre}zone B ON A.fid=B.fup WHERE B.fid='$zoneid'";
		$rs=$db->get_one($SQL);
		$show="<A HREF='$admin_path&job=zone&fup=$rs[cityid]'>$rs[city]</A> -> <A HREF='$admin_path&job=street&fup=$rs[zoneid]'>$rs[zone]</A>";
	}elseif($cityid){
		$SQL="SELECT A.name AS city,A.fid AS cityid,B.name AS pro,B.fid AS proid FROM {$_pre}area B LEFT JOIN {$_pre}city A ON A.fup=B.fid WHERE A.fid='$cityid'";
		$rs=$db->get_one($SQL);
		$show="<A HREF='$admin_path&job=city&fup=$rs[proid]'>$rs[pro]</A> -> <A HREF='$admin_path&job=zone&fup=$rs[cityid]'>$rs[city]</A>";
	}
	return $show;
}


function write_city_file($dirname,$cityid){
	if(!$dirname||!$cityid){
		return ;
	}
	makepath(ROOT_PATH.$dirname);
	if(!is_dir(ROOT_PATH.$dirname)){
		showerr(ROOT_PATH.$dirname."目录创建失败,请确认分类目录权限可写");
	}
	if( eregi("^\.\.",$dirname) ){
		$p=basename(dirname(dirname(__FILE__))).'/';
	}
	elseif(strstr($dirname,'/')){
		$p='../';
	}
	$string="<?php\r\n\$_GET['choose_cityID']=$cityid;\r\nrequire dirname(__FILE__).'/../$p'.basename(__FILE__);\r\n?>";
	write_file(ROOT_PATH."$dirname/index.php",$string);
	write_file(ROOT_PATH."$dirname/list.php",$string);
	write_file(ROOT_PATH."$dirname/bencandy.php",$string);
	write_file(ROOT_PATH."$dirname/post.php",$string);
	write_file(ROOT_PATH."$dirname/job.php",$string);
	write_file(ROOT_PATH."$dirname/search.php",$string);	
}

?>