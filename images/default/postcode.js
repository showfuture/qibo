defaultmode = "divmode";
var text = "";


var js_bits 			='已有字节数';
var js_help				='特效 代码 - 帮助信息点击相应的代码按钮即可获得相应的说明和提示';
var js_direct			='特效 代码 - 直接插入点击代码按钮后不出现提示即直接插入相应代码';
var js_remind			='特效 代码 - 提示插入点击代码按钮后出现向导窗口帮助您完成代码插入';
var js_size_help		='文字大小标记设置文字大小.可变范围 1 - 6. 1 为最小 6 为最大.用法:  ';
var js_size				='大小';
var js_font_help		='字体标记给文字设置字体.用法: ';
var js_font				='要设置字体的文字';
var js_word				='文字';
var js_color_help		='颜色标记设置文本颜色.  任何颜色名都可以被使用.用法: ';
var js_color			='选择的颜色是:  ';
var js_bold_help		='加粗标记使文本加粗.用法: [b]这是加粗的文字[/b]';
var js_bold				='文字将被变粗.';
var js_italic_help		='斜体标记使文本字体变为斜体.用法: [i]这是斜体字[/i]';
var js_italic			='文字将变斜体';
var js_quote_help		='引用标记引用一些文字.用法: [quote]引用内容[/quote]';
var js_quote			='被引用的文字';
var js_fly_help			='飞行标记使文字飞行.用法: [fly]文字为这样文字[/fly]';
var js_fly				='飞行文字';
var js_move_help		='移动标记使文字产生移动效果.用法: [move]要产生移动效果的文字[/move]';
var js_move				='要产生移动效果的文字';
var js_shadow_help		='阴影标记使文字产生阴影效果.用法: [SHADOW=宽度, 颜色, 边界]要产生阴影效果的文字[/SHADOW]';
var js_shadow			='要产生阴影效果的文字';
var js_glow_help		='光晕标记使文字产生光晕效果.用法: [GLOW=宽度, 颜色, 边界]要产生光晕效果的文字[/GLOW]';
var js_glow_size		='文字的长度、颜色和边界大小';
var js_glow				='要产生光晕效果的文字';
var js_align_help		='对齐标记使用这个标记, 可以使文本左对齐、居中、右对齐.用法: [align=center|left|right]要对齐的文本[/align]';
var js_align_type		='对齐样式输入 ’center’ 表示居中, ’left’ 表示左对齐, ’right’ 表示右对齐.';
var js_align_error		='错误!类型只能输入 ’center’ 、 ’left’ 或者 ’right’.';
var js_align			='要对齐的文本';
var js_rm				='RM音乐标记插入一个RM链接标记使用方法: [rm]http://www.mmcbbs.com/rm/php.rm[/rm]';
var js_img				='图片标记插入图片用法: [img]http://www.mmcbbs.com/image/php.gif[/img]';
var js_wmv				='wmv标记插入wmv用法: [wmv]http://www.mmcbbs.com/wmv/php.wmv[/wmv]';
var js_url_help			='url标记使用url标记,可以使输入的url地址以超链接的形式在帖子中显示.使用方法: [url]url地址[/url]';
var js_url_name			='URL 名称: 菁菁论坛(可以为空)';
var js_url				='URL 地址';
var js_code_help		='代码标记使用代码标记,可以使你的程序代码里面的 html 等标志不会被破坏.使用方法: [code]这里是代码文字[/code]';
var js_code				='输入代码';
var js_list_help		='列表标记建造一个文字或则数字列表.USE: [list][*]item1[*]item2[*]item3[/list]';
var js_list_type		='列表类型输入 ’a’ 表示字母列表, ’1’ 表示数字列表, 留空表示普通列表.';
var js_list_error		='错误!类型只能输入 ’a’、’A’ 、 ’1’ 或者留空.';
var js_list				='列表项空白表示结束列表';
var js_underline_help	='下划线标记给文字加下划线.用法: [u]要加下划线的文字[/u]';
var js_underline		='下划线文字';
var js_flash			='Flash 动画插入 Flash 动画.用法: [flash=宽度,高度]Flash 文件的地址[/flash]';
var js_height			='宽度,高度';
var js_js_replace		='';
var js_search			='请输入搜寻目标关键字';
var js_keyword			='关键字替换为:';


if (defaultmode == "nomode") {
        helpmode = false;
        divmode = false;
        nomode = true;
} else if (defaultmode == "helpmode") {
        helpmode = true;
        divmode = false;
        nomode = false;
} else {
        helpmode = false;
        divmode = true;
        nomode = false;
}
function checkmode(swtch){
        if (swtch == 1){
                nomode = false;
                divmode = false;
                helpmode = true;
                alert(js_help);
        } else if (swtch == 0) {
                helpmode = false;
                divmode = false;
                nomode = true;
                alert(js_direct);
        } else if (swtch == 2) {
                helpmode = false;
                nomode = false;
                divmode = true;
                alert(js_remind);
        }
}
function getActiveText(selectedtext) {
  text = (document.all) ? document.selection.createRange().text : document.getSelection();
  if (selectedtext.createTextRange) {	
    selectedtext.caretPos = document.selection.createRange().duplicate();	
  }
	return true;
}
function submitonce(theform)
{
	if (document.all||document.getElementById)
	{
		for (i=0;i<theform.length;i++)
		{
			var tempobj=theform.elements[i];
			if(tempobj.type.toLowerCase()=="submit"||tempobj.type.toLowerCase()=="reset")
				tempobj.disabled=true;
		}
	}
}
/*
function checklength(theform)
{
	alert(js_bits+theform.atc_content.value.length);
}
*/
function AddText(NewCode) 
{
	if (FORM.content.createTextRange && FORM.content.caretPos) 
	{
		var caretPos = FORM.content.caretPos;
		caretPos.text = caretPos.text.charAt(caretPos.text.length - 1) == ' ' ? NewCode + ' ' : NewCode;
	} 
	else 
	{
		FORM.content.value+=NewCode
	}
	setfocus();
}
function setfocus()
{
  FORM.content.focus();
}


function showsize(size) {
	if (helpmode) {
		alert(js_size_help+"[size="+size+"] "+size+js_word+"[/size]");
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[size="+size+"]"+text+"[/size]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_size+size,js_word);
		if (txt!=null) {
			AddTxt="[size="+size+"]"+txt;
			AddText(AddTxt);
			AddTxt="[/size]";
			AddText(AddTxt);
		}
	}
}

function showfont(font) {
 	if (helpmode){
		alert(js_font_help+" [font="+font+"]"+font+"[/font]");
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[font="+font+"]"+text+"[/font]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_font+font,js_word);
		if (txt!=null) {
			AddTxt="[font="+font+"]"+txt;
			AddText(AddTxt);
			AddTxt="[/font]";
			AddText(AddTxt);
		}
	}
}
function showcolor(color) {
	if (helpmode) {
		alert(js_color_help+"[color="+color+"]"+color+"[/color]");
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[color="+color+"]"+text+"[/color]";
		AddText(AddTxt);
	} else {  
     	txt=prompt(js_color+color,js_word);
		if(txt!=null) {
			AddTxt="[color="+color+"]"+txt;
			AddText(AddTxt);
			AddTxt="[/color]";
			AddText(AddTxt);
		}
	}
}

function bold() {
	if (helpmode) {
		alert(js_bold_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[b]"+text+"[/b]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_bold,js_word);
		if (txt!=null) {
			AddTxt="[b]"+txt;
			AddText(AddTxt);
			AddTxt="[/b]";
			AddText(AddTxt);
		}
	}
}

function italicize() {
	if (helpmode) {
		alert(js_italic_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[i]"+text+"[/i]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_italic,js_word);
		if (txt!=null) {
			AddTxt="[i]"+txt;
			AddText(AddTxt);
			AddTxt="[/i]";
			AddText(AddTxt);
		}
	}
}

function quoteme() {
	if (helpmode){
		alert(js_quote_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[quote]"+text+"[/quote]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_quote,js_word);
		if(txt!=null) {
			AddTxt="[quote]"+txt;
			AddText(AddTxt);
			AddTxt="[/quote]";
			AddText(AddTxt);
		}
	}
}
function setfly() {
 	if (helpmode){
		alert(js_fly_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[fly]"+text+"[/fly]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_fly,js_word);
		if (txt!=null) {
			AddTxt="[fly]"+txt;
			AddText(AddTxt);
			AddTxt="[/fly]";
			AddText(AddTxt);
		}
	}
}

function movesign() {
	if (helpmode) {
		alert(js_move_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[move]"+text+"[/move]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_move,js_word);
		if (txt!=null) {
			AddTxt="[move]"+txt;
			AddText(AddTxt);
			AddTxt="[/move]";
			AddText(AddTxt);
		}
	}
}

function shadow() {
	if (helpmode) {
		alert(js_shadow_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[SHADOW=255,blue,1]"+text+"[/SHADOW]";
		AddText(AddTxt);
	} else {
		headtxt=prompt(js_glow_size,"255,blue,1");
		if (headtxt!=null) {
			txt=prompt(js_shadow,js_word);
			if (txt!=null) {
				if (headtxt=="") {
					AddTxt="[shadow=255, blue, 1]"+txt;
					AddText(AddTxt);
					AddTxt="[/shadow]";
					AddText(AddTxt);
				} else {
					AddTxt="[shadow="+headtxt+"]"+txt;
					AddText(AddTxt);
					AddTxt="[/shadow]";
					AddText(AddTxt);
				}
			}
		}
	}
}

function glow() {
	if (helpmode) {
		alert(js_glow_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[glow=255,red,2]"+text+"[/glow]";
		AddText(AddTxt);
	} else {
		headtxt=prompt(js_glow_size,"255,red,2");
		if (headtxt!=null) {
			txt=prompt(js_glow,js_word);
			if (txt!=null) {
				if (headtxt=="") {
					AddTxt="[glow=255,red,2]"+txt;
					AddText(AddTxt);
					AddTxt="[/glow]";
					AddText(AddTxt);
				} else {
					AddTxt="[glow="+headtxt+"]"+txt;
					AddText(AddTxt);
					AddTxt="[/glow]";
					AddText(AddTxt);
				}
			}
		}
	}
}

function center() {
 	if (helpmode) {
		alert(js_align_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[align=center]"+text+"[/align]";
		AddText(AddTxt);
	} else {
		headtxt=prompt(js_align_type,"center");
		while ((headtxt!="") && (headtxt!="center") && (headtxt!="left") && (headtxt!="right") && (headtxt!=null)) {
			headtxt=prompt(js_align_error,"");
		}
		txt=prompt(js_align,js_word);
		if (txt!=null) {
			AddTxt="\r[align="+headtxt+"]"+txt;
			AddText(AddTxt);
			AddTxt="[/align]";
			AddText(AddTxt);
		}
	}
}

function rming() {
	if (helpmode) {
		alert(js_rm);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[rm]"+text+"[/rm]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_url,"http://");
		if(txt!=null) {
			AddTxt="\r[rm]"+txt;
			AddText(AddTxt);
			AddTxt="[/rm]";
			AddText(AddTxt);
		}
	}
}

function image() {
	if (helpmode){
		alert(js_img);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[img]"+text+"[/img]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_url,"http://");
		if(txt!=null) {
			AddTxt="\r[img]"+txt;
			AddText(AddTxt);
			AddTxt="[/img]";
			AddText(AddTxt);
		}
	}
}

function wmv() {
	if (helpmode){
		alert(js_wmv);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[wmv]"+text+"[/wmv]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_url,"http://");
		if(txt!=null) {
			AddTxt="\r[wmv]"+txt;
			AddText(AddTxt);
			AddTxt="[/wmv]";
			AddText(AddTxt);
		}
	}
}

function showurl() {
 	if (helpmode){
		alert(js_url_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[url="+text+"]"+text+"[/url]";
		AddText(AddTxt);
	} else {
			headtxt=prompt(js_url_name,"");
		if (headtxt!=null) {
			txt=prompt(js_url,"http://");
			if (headtxt!=null) {
				if (headtxt=="") {
					AddTxt="[url]"+txt;
					AddText(AddTxt);
					AddTxt="[/url]";
					AddText(AddTxt);
				} else {
					if(txt==""){
						AddTxt="[url]"+headtxt;
						AddText(AddTxt);
						AddTxt="[/url]";
						AddText(AddTxt);
					} else{
						AddTxt="[url="+txt+"]"+headtxt;
						AddText(AddTxt);
						AddTxt="[/url]";
						AddText(AddTxt);
					}
				}
			}
		}
	}
}

function showcode() {
	if (helpmode) {
		alert(js_code_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="\r\n[code]"+text+"[/code]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_code,"");
		if (txt!=null) { 
			AddTxt="\r[code]"+txt;
			AddText(AddTxt);
			AddTxt="[/code]";
			AddText(AddTxt);
		}
	}
}

function list() {
	if (helpmode) {
		alert(js_list_help);
	} else if (nomode) {
		AddTxt="\r[list]\r[*]\r[*]\r[*]\r[/list]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_list_type,"");
		while ((txt!="") && (txt!="A") && (txt!="a") && (txt!="1") && (txt!=null)) {
			txt=prompt(js_list_error,"");
		}
		if (txt!=null) {
			if (txt==""){
				AddTxt="\r[list]\r\n";
			} else if (txt=="1") {
				AddTxt="\r[list=1]\r\n";
			} else if(txt=="a") {
				AddTxt="\r[list=a]\r\n";
			}
			ltxt="1";
			while ((ltxt!="") && (ltxt!=null)) {
				ltxt=prompt(js_list,"");
				if (ltxt!="") {
					AddTxt+="[*]"+ltxt+"\r";
				}
			}
			AddTxt+="[/list]\r\n";
			AddText(AddTxt);
		}
	}
}
function underline() {
  	if (helpmode) {
		alert(js_underline_help);
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[u]"+text+"[/u]";
		AddText(AddTxt);
	} else {
		txt=prompt(js_underline,js_word);
		if (txt!=null) {
			AddTxt="[u]"+txt;
			AddText(AddTxt);
			AddTxt="[/u]";
			AddText(AddTxt);
		}
	}
}

function setswf() {
 	if (helpmode){
		alert('Flash 动画\n插入 Flash 动画.\n用法: [flash=宽度,高度]Flash 文件的地址[/flash]');
	} else if (nomode || document.selection && document.selection.type == "Text") {
		AddTxt="[flash=400,300]"+text+"[/flash]";
		AddText(AddTxt);
	} else {
			headtxt=prompt("宽 度,高度","400,300");
		if (headtxt!=null) {
			txt=prompt('URL 地址',"http://");
			if (txt!=null) {
				if (headtxt=="") {
					AddTxt="[flash=400,300]"+txt;
					AddText(AddTxt);
					AddTxt="[/flash]";
					AddText(AddTxt);
				} else {
					AddTxt="[flash="+headtxt+"]"+txt;
					AddText(AddTxt);
					AddTxt="[/flash]";
					AddText(AddTxt);
				}
			}
		}
	}
}

function add_title(addTitle) 
{ 
	var revisedTitle; 
	var currentTitle = document.FORM.atc_title.value; 
	revisedTitle = currentTitle+addTitle; 
	document.FORM.atc_title.value=revisedTitle; 
	document.FORM.atc_title.focus(); 
	return;
}

function Addaction(addTitle)
{ 
	var revisedTitle; 
	var currentTitle = FORM.content.value; revisedTitle = currentTitle+addTitle; FORM.content.value=revisedTitle; FORM.content.focus(); 
	return; 
}

function copytext(theField) 
{
	var tempval=eval("document."+theField);
	tempval.focus();
	tempval.select();
	therange=tempval.createTextRange();
	therange.execCommand("Copy");
}

function replac()
{
	if (helpmode)
	{
		alert(js_replace);
	}
	else
	{
		headtxt=prompt(js_search,"");
		if (headtxt != null)
		{
			if (headtxt != "") 
			{
				txt=prompt(js_keyword,headtxt);
			}
			else
			{
				replac();
			}
			var Rtext = headtxt; var Itext = txt;
			Rtext = new RegExp(Rtext,"g");
			FORM.content.value =FORM.content.value.replace(Rtext,Itext);
		}
	}
}

function addsmile(NewCode) {
  FORM.content.value += ' '+NewCode+' '; 
}