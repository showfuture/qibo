<?php
define('Mpath',dirname(__FILE__).'/');
define( 'Mdirname' , preg_replace("/(.*)\/([^\/]+)/is","\\2",str_replace("\\","/",dirname(__FILE__))) );

require_once(Mpath."../inc/common.inc.php");
require_once(ROOT_PATH."data/module_db.php");			//模块的名称
require_once(Mpath."inc/function.php");				//仅本模块所用到的函数
@include_once(Mpath."inc/biz.php");
@include_once(ROOT_PATH."data/ad_cache.php");	//全站广告变量缓存文件
@include_once(ROOT_PATH."data/label_hf.php");	//标签的头与底的变量值
@include_once(ROOT_PATH."data/module.php");		//模块系统的参数变量值
require_once(Mpath."inc/module.class.php");			//自定义字段相关的功能
$Fid_db = include(ROOT_PATH."data/all_fid.php");			//栏目的名称

if(!$webdb[web_open])
{
	$webdb[close_why] = str_replace("\n","<br>",$webdb[close_why]);
	showerr("网站暂时关闭:$webdb[close_why]");
}

$_pre="{$pre}{$webdb[module_pre]}";					//数据表前缀

$Module_db=new Module_Field();						//自定义模型相关

$Murl=$webdb[www_url].'/'.Mdirname;					//本模块的访问地址
$Mdomain=$ModuleDB[$webdb[module_pre]][domain]?$ModuleDB[$webdb[module_pre]][domain]:$Murl;

@include_once(ROOT_PATH."data/all_city.php");			//必须要放在$Mdomain变量之后,里边要用到$Mdomain变量


//兼容IIS,多城市域名的处理方法
if(!$_GET[choose_cityID]){
	foreach( $city_DB[domain] AS $key=>$value){
		if($value==preg_replace("/http:\/\/([^\/]+)\/(.*)/is","http://\\1",$WEBURL)){
			$_GET[choose_cityID]=$key;
			setcookie('city_id',$key,$timestamp+3600,'/');
			break;
		}
	}
}

if($city_DB[domain]&&!$webdb[cookieDomain]){
	//showerr('你启用了城市二级域名,请进后台设置一下COOKIE有效域名,否则用户登录前台会不正常!');
}



//普通伪静态
if($stringID&&$webdb[Info_htmlType]==1){
	$detail=explode("-",$stringID);
	for($i=0;$i<count($detail) ;$i++ ){
		$$detail[$i]=$_GET[$detail[$i]]=$detail[++$i];
	}
}

if($_GET[city_id]>0&&!$city_DB[name][$_GET[city_id]]){
	showerr("此地区不存在");
}elseif($_GET[choose_cityID]>0&&!$city_DB[name][$_GET[choose_cityID]]){
	showerr("此地区不存在");
}

unset($foot_tpl,$head_tpl,$index_tpl,$list_tpl,$bencandy_tpl);
$ch=intval($ch);
$fid=intval($fid);
$id=intval($id);
$page=intval($page);
$city_id=intval($city_id);
$zone_id=intval($zone_id);
$street_id=intval($street_id);

@include_once(ROOT_PATH."data/zone/$city_id.php");


if($webdb['Info_htmlType']!=2){	//不是高级伪静态的话.禁止二级目录访问
	$city_DB['dirname']='';
}elseif($webdb['Info_htmlType']==2&&!$city_DB['domain'][$city_id]&&!$city_DB['dirname'][$city_id]){
	showerr('当前城市没绑定二级域名,要使用高级伪静态的话,请先在后台生成城市目录名!');
}

//$city_url为了获取城市目录下的文件路径
if($city_DB[domain][$city_id]){
	$city_url=$city_DB[domain][$city_id];
}elseif($city_DB['dirname'][$city_id]){
	$city_url=substr($city_DB['url'][$city_id],0,-1);
}else{
	$city_url=$webdb[www_url];
}

refurbish_info();//自动刷新分类信息

?>