<?php
require(dirname(__FILE__)."/global.php");
require(dirname(__FILE__)."/bd_pics.php");

require(Mpath."inc/homepage/global.php");
require(Mpath."inc/homepage/function.php");

//伪静态,解释参数
if($webdb['HyRewrite']==1){
	$detail=explode("-",substr($Rurl,0,-5));	//.html去除掉
	for($i=0;$i<count($detail) ;$i++ ){
		$_GET[$detail[$i]]=$$detail[$i]=$detail[++$i];	
	}
	unset($i,$detail);
}


if($uid=intval($uid)){
	$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE uid='$uid'");
}else{
	
	$host=filtrate(preg_replace("/http:\/\/([^\/]+)(.*)/is","\\1",$WEBURL));
	$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE host='$host'");
	if(!$rsdb){	//兼容旧版程序
		$host=filtrate(preg_replace("/http:\/\/([^\.]+)\.(.*)/is","\\1",$WEBURL));
		$rsdb=$db->get_one("SELECT * FROM {$_pre}company WHERE host='$host'");
		if($rsdb){
			$db->query("UPDATE {$_pre}company SET host='{$host}.$webdb[vipselfdomain]' WHERE host='$host'");
		}
	}
	$uid=$rsdb['uid'];

	if(!$uid){
		if(!$lfjuid){
			showerr("抱歉,没有找到您要访问的页面！");
		}else{
			echo "<META HTTP-EQUIV=REFRESH CONTENT='0;URL=?uid=$lfjuid'>";
			exit;
		}
	}
}

if(!$rsdb[if_homepage]){
	if($uid==$lfjuid){
		showerr("您还没有申请商家主页，<a href='$webdb[www_url]/member/index.php?main=$Murl/member/post_company.php'><b>点击这里</b></a>申请");
	}else{
		showerr("商家还没有申请主页");
	}
}


//商铺配置文件
$conf=$db->get_one("SELECT * FROM {$_pre}home WHERE uid='$uid'");
if(!$conf[uid]) {
	caretehomepage($rsdb);		//激活商家信息
}


if($rsdb[yz]!=1 && $lfjuid != $uid && !$web_admin){
	showerr("此店铺未经审核,无法显示");
}
if($rsdb[yz]!=1 && $webdb['ForbidDoHy'] && !$web_admin){
	showerr("当前商家还没通过审核,无法显示");
}


//公司名称,有banner时候隐藏
$banner_show='';
list($banner_url,$banner_width,$banner_height) = explode("\t",$conf['banner']);
if(!$banner_url){
	$rsdb[company_name_big] = $rsdb[title];
}else{
	//$conf[banner]=" style='background:url(".tempdir($banner_url).");'";
	$banner_url = tempdir($banner_url);
	$banner_width>800 || $banner_width=990;
	$banner_height>30 || $banner_height=100;
	if(eregi("\.swf$",$banner_url)){
		$banner_show = "<embed class='edui-faked-video' pluginspage='http://www.macromedia.com/go/getflashplayer' align='none' src='$banner_url' width='$banner_width' height='$banner_height' type='application/x-shockwave-flash' allowfullscreen='true' allowscriptaccess='never' menu='false' loop='false' play='true' wmode='transparent' />";
	}else{
		$banner_show = "<img src='$banner_url' style='border:0;width:{$banner_width}px;height:{$banner_height}px;'>";
	}
}

//风格
$style_tpl = $homepage_tpl = '';
$homepage_style="default";
if(eregi("^([-_a-z0-9]+)$",$conf[style]) && is_dir($tpl_dir.$conf[style])){
	include($tpl_dir.$conf[style].'/style.php');
	$homepage_style=$conf[style];
}

//模块
$conf[bodytpl]=$conf[bodytpl]?$conf[bodytpl]:"left";

//数据处理
$rsdb[logo]=tempdir($rsdb[picurl]);
$conf[listnum]=unserialize($conf[listnum]);

$conf[index_left]=explode(",",$conf[index_left]);
$conf[index_right]=explode(",",$conf[index_right]);

//头部导航 
$head_menu=unserialize($conf[head_menu]);
foreach($head_menu as $key=>$arr){
	if(!$arr[ifshow]){continue;}
	if(!preg_match("/http/i",$arr[url])){
		$arr[url]=str_replace("homepage.php","",$arr[url]).'&uid='.$uid;
	}else{
	$arr[target]='_blank';
	}
	$h_menu[$key]=$arr;
}

//SEO
$titleDB[title]			= $conf['metatitle']?$conf['metatitle']:filtrate(strip_tags($rsdb['title']));
$titleDB[keywords]		= $conf['metakeywords']?$conf['metakeywords']:filtrate(strip_tags($webdb['SEO_keywords']));
$titleDB[description]	= $conf['metadescription']?$conf['metadescription']:strip_tags($webdb['SEO_description']);


//访客
if($lfjuid)
{
	if($lfjuid!=$conf[uid]){
		$conf[visitor]="{$lfjuid}\t{$lfjid}\t{$timestamp}\r\n$conf[visitor]";
	}
}
else
{
	$conf[visitor]="0\t{$onlineip}\t{$timestamp}\r\n$conf[visitor]";
}
$detail=explode("\r\n",$conf[visitor]);
foreach( $detail AS $key=>$value)
{
	if($key>0&&(strstr($value,"{$lfjuid}\t{$lfjid}\t")||strstr($value,"0\t$onlineip")))
	{
		unset($detail[$key]);
	}
	if($key>20||!$value)
	{
		unset($detail[$key]);
	}
}
$conf[visitor]=implode("\r\n",$detail);

$db->query("UPDATE {$_pre}home SET hits=hits+1,visitor='$conf[visitor]' WHERE uid='$uid' ");
$db->query("UPDATE {$_pre}company  set hits=hits+1 WHERE uid='$uid'");


//输出

require(get_homepage_tpl("head"));
require(get_homepage_tpl("main"));
require(get_homepage_tpl("foot"));
$content=ob_get_contents();
$content=str_replace(array('<!---->','<!--include','include-->','?&'),array('','','','?'),$content);
if($webdb['HyRewrite']==1){	//伪静态处理
	//rewrite_url($content);
	$content=preg_replace('/ href=("|\')(\?|homepage\.php)([=&0-9a-z]+)("|\')/eis','home_url_replace("\\3",1)',$content);
	$content=preg_replace('/window.location=\'(\?|homepage\.php)([^\']+)\'\+this\.options\[this\.selectedIndex\]\.value/eis','home_url_replace("\\2",2)',$content);
	if(strstr($WEBURL,'/home/')){	//处理home目录在linux服务器里不能使用伪静态的情况
		header("location:".preg_replace('/\/home\/\?uid=([\d]+)/','/hy/homepage-htm-uid-\\1.html',$WEBURL));
		exit;
	}
}
ob_end_clean();
echo $content;

//商铺伪静态
function home_url_replace($url,$type=1){
	$url=str_replace(array('=','&'),array('-','-'),$url);
	if($type==1){
		return ' href="homepage-htm-'.$url.'.html"';
	}elseif($type==2){
		return 'window.location=\'homepage-htm-'.$url.'\'+this.options[this.selectedIndex].value+\'.html\'';
	}	
}


function get_homepage_module($modulename){
	extract($GLOBALS);
	include get_homepage_php($modulename);
}
?>