var Browser = navigator.userAgent.toLowerCase();
var IF_IE = ((Browser.indexOf("msie") != -1) && (Browser.indexOf("opera") == -1));


function qibo_player(url,width,height,type,ifautostart){
	mp3_RE=/(\.mid|\.mp3|\.wma|\.wav|\.asf|\.aac|\.flac|\.ape)$/i
	avi_RE=/(\.avi|\.avi|\.asf|\.asx|\.wmv|\.mpg|\.mpeg)$/i
	RM_RE=/(\.ra|\.rm|\.ram|\.rmvb)$/i
	SWF_RE=/(\.swf)$/i
	FLV_RE=/(\.flv|\.mp4)$/i
	if (type=='mp3'||mp3_RE.test(url))
	{
		player_avi(url,width,70,ifautostart);
	}
	else if (type=='avi'||type=='wmv'||avi_RE.test(url))
	{
		player_avi(url,width,height,ifautostart);
	}
	else if (type=='rm'||type=='rmvb'||RM_RE.test(url))
	{
		player_rm(url,width,height,ifautostart);
	}
	else if (type=='swf'||type=='flash'||SWF_RE.test(url))
	{
		player_swf(url,width,height);
	}
	else if (type=='flv'||FLV_RE.test(url))
	{
		player_flv(url,width,height,ifautostart);
	}
	else
	{
		document.write("此媒体文件地址:"+url+"有误,请检查之!!!");
	}
}

function player_rm(url,width,height,ifautostart){
	if (IF_IE) {
		document.write( "<object classid=\"CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"Imagewindow\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object><br /><object classid=\"CLSID:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\""+width+"\" height=\"44\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"ControlPanel,StatusBar\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object>");
	} else if (Browser.indexOf('firefox')!=-1) {
		document.write( "<object data=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" width=\""+width+"\" height=\""+height+"\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"Imagewindow\"><embed src=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"Imagewindow\" width=\""+width+"\" height=\""+height+"\"></embed></object><br /><object data=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" width=\""+width+"\" height=\"44\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"ControlPanel,StatusBar\"><embed src=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"ControlPanel,StatusBar\" width=\""+width+"\" height=\"44\"></embed></object>");
	} else if (Browser.indexOf('safari')!=-1) {
		document.write( "<object type=\"audio/x-pn-realaudio-plugin\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"Imagewindow\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object><br /><object type=\"audio/x-pn-realaudio-plugin\" width=\""+width+"\" height=\"44\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"ControlPanel,StatusBar\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object>");
	} else {
		document.write( "<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"Imagewindow\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /><embed src=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"Imagewindow\" width=\""+width+"\" height=\""+height+"\"></embed></object><br /><object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" width=\""+width+"\" height=\"44\"><param name=\"src\" value=\""+url+"\" /><param name=\"controls\" value=\"ControlPanel\" /><param name=\"console\" value=\"clip1\" /><param name=\"autostart\" value=\""+ifautostart+"\" /><embed src=\""+url+"\" type=\"audio/x-pn-realaudio-plugin\" autostart=\""+ifautostart+"\" console=\"clip1\" controls=\"ControlPanel,StatusBar\" width=\""+width+"\" height=\"44\"></embed></object>");
	}
}
function player_swf(url,width,height,ifautostart){
	if (IF_IE) {
		document.write( "<object classid=\"CLSID:D27CDB6E-AE6D-11cf-96B8-444553540000\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"autostart\" value=\""+ifautostart+"\" /><param name=\"loop\" value=\"true\" /><param name=\"quality\" value=\"high\" /></object>");
	} else {
		document.write( "<object data=\""+url+"\" type=\"application/x-shockwave-flash\" width=\""+width+"\" height=\""+height+"\"><param name=\"autostart\" value=\""+ifautostart+"\" /><param name=\"loop\" value=\"true\" /><param name=\"quality\" value=\"high\" /><EMBED src=\""+url+"\" quality=\"high\" width=\""+width+"\" height=\""+height+"\" TYPE=\"application/x-shockwave-flash\" PLUGINSPAGE=\"http://www.macromedia.com/go/getflashplayer\"></EMBED></object>");
	}
}

function player_avi(url,width,height,ifautostart) {
	if (height<70) height = 70;
	if (IF_IE) {
		document.write( "<object classid=\"CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object>");
	} else if (Browser.indexOf('firefox')!=-1) {
		document.write( "<object data=\""+url+"\" type=\"application/x-mplayer2\" width=\""+width+"\" height=\""+height+"\" ShowStatusBar=\"true\"><embed type=\"application/x-mplayer2\" src=\""+url+"\" width=\""+width+"\" height=\""+height+"\" ShowStatusBar=\"true\"></embed></object>");
	} else if (Browser.indexOf('safari')!=-1) {
		document.write( "<object type=\"application/x-mplayer2\" width=\""+width+"\" height=\""+height+"\"><param name=\"src\" value=\""+url+"\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"autostart\" value=\""+ifautostart+"\" /></object>");
	} else {
		document.write( "<object classid=\"CLSID:22D6F312-B0F6-11D0-94AB-0080C74C7E95\" width=\""+width+"\" height=\""+height+"\"><param name=\"autostart\" value=\""+ifautostart+"\" /><param name=\"src\" value=\""+url+"\" /><param name=\"ShowStatusBar\" value=\"true\" /><embed type=\"application/x-mplayer2\" src=\""+url+"\" width=\""+width+"\" height=\""+height+"\" ShowStatusBar=\"true\"></embed></object>");
	}
}

function player_flv(url,width,height,ifautostart){
	if (ifautostart=='false'||ifautostart=='0')
	{
		ifautostart='0';
	}
	else 
	{
		ifautostart='1';
	}
	var swf_width=width;
	var swf_height=height;
	var IsAutoPlay=ifautostart;
	var BarPosition=1;
	var IsShowBar=1;
	var LogoUrl='';
	var files=url;
	//var www_url='';
		
	document.write('<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="'+ swf_width +'" height="'+ swf_height +'">');
	document.write('<param name="movie" value="'+ www_url +'/images/default/player.swf"><param name="quality" value="high"><param name="menu" value="false"><param name="allowFullScreen" value="true" />');
	document.write('<param name="FlashVars" value="vcastr_file='+files+'&vcastr_title=&IsAutoPlay='+IsAutoPlay+'&BarPosition='+BarPosition+'&IsShowBar='+IsShowBar+'&LogoUrl='+LogoUrl+'">');
	document.write('<embed src="'+ www_url +'/images/default/player.swf" allowFullScreen="true" FlashVars="vcastr_file='+files+'&vcastr_title=&IsAutoPlay='+IsAutoPlay+'&BarPosition='+BarPosition+'&IsShowBar='+IsShowBar+'&LogoUrl='+LogoUrl+'" menu="false" quality="high" width="'+ swf_width +'" height="'+ swf_height +'" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></object>');
}

/*
FLV播放器参数名称
参数说明 默认值 
vcastr_file 方法2传递影片flv文件地址参数，多个使用|分开 空 
vcastr_title 影片标题参数，多个使用|分开，与方法2配合使用 空 
vcastr_xml 方法3 传递影片flv文件地址参数，样板参考 http://www.ruochi.com/product/vcastr2/vcastr.xml  vcastr.xml 
IsAutoPlay 影片自动播放参数：0表示不自动播放，1表示自动播放 0 
IsContinue 影片连续播放参数：0表示不连续播放，1表示连续循环播 1 
IsRandom 影片随机播放参数：0表示不随机播放，1表示随机播放 0 
DefaultVolume 默认音量参数 ：0-100 的数值，设置影片开始默认音量大小 100 
BarPosition 控制栏位置参数 ：0表示在影片上浮动显示，1表示在影片下方显示 0 
IsShowBar 控制栏显示参数 ：0表示不显示；1表示一直显示；2表示鼠标悬停时显示；3表示开始不显示，鼠标悬停后显示 2 
BarColor 播放控制栏颜色，颜色都以0x开始16进制数字表示 0x000033 
BarTransparent 播放控制栏透明度 60 
GlowColor 按键图标颜色，颜色都以0x开始16进制数字表示 0x66ff00 
IconColor 鼠标悬停时光晕颜色，颜色都以0x开始16进制数字表示 0xFFFFFF 
TextColor 播放器文字颜色，颜色都以0x开始16进制数字表示 0xFFFFFF 
LogoText 可以添加自己网站名称等信息(英文) 空 
LogoUrl 可以从外部读取logo图片,注意自己调整logo大小,支持图片格式和swf格式 空 
EndSwf 影片播放结束后,从外部读取swf文件，可以添加相关影片信息，影片分享等信息，需自己制作 空 
BeginSwf 影片开始播放之前,从外部读取swf文件，可以添加广告，或者网站信息，需自己制作 空 
IsShowTime 是否显示时间 : 0表示不显示时间，1表示显示时间 1 
BufferTime 影片缓冲时间，单位（秒） 2 
*/