//下拉菜单
 var h;
 var w;
 var l;
 var t;
 var topMar = 1;
 var leftMar = -2;
 var space = 1;
 var isvisible;
 var MENU_SHADOW_COLOR='#fff';//定义下拉菜单阴影色
 var global = window.document
 global.fo_currentMenu = null
 global.fo_shadows = new Array

function HideMenu_mmc() 
{
	var mX;
	var mY;
	var vDiv;
	var mDiv;
	if (isvisible == true)
	{
		var scrollPosTOP; 
		if (typeof window.pageYOffset != 'undefined') { 
			scrollPosTOP = window.pageYOffset; 
		} 
		else if (typeof document.compatMode != 'undefined' && 
			document.compatMode != 'BackCompat') { 
			scrollPosTOP = document.documentElement.scrollTop; 
		} 
		else if (typeof document.body != 'undefined') { 
			scrollPosTOP = document.body.scrollTop; 
		}

		var scrollPosLeft; 
		if (typeof window.pageXOffset != 'undefined') { 
			scrollPosLeft = window.pageXOffset; 
		} 
		else if (typeof document.compatMode != 'undefined' && 
			document.compatMode != 'BackCompat') { 
			scrollPosLeft = document.documentElement.scrollLeft; 
		} 
		else if (typeof document.body != 'undefined') { 
			scrollPosLeft = document.body.scrollLeft; 
		}
		mX = window.event.clientX + scrollPosLeft;
		mY = window.event.clientY + scrollPosTOP;

		vDiv = document.getElementById("menuDiv");
		
		if ((mX < (parseInt(vDiv.style.left)+3)) || (mX > parseInt(vDiv.style.left)+vDiv.offsetWidth) || (mY < (parseInt(vDiv.style.top)-h+3)) || (mY > parseInt(vDiv.style.top)+vDiv.offsetHeight)){
			
			isvisible = false;
			vDiv.style.visibility = "hidden";
		}
	}
}


function ShowMenu_mmc(vMnuCode,tWidth) {
	if (vMnuCode=='')
	{
		return ;
	}
	vSrc = window.event.srcElement;
	vMnuCode = "<table id='menuTable' cellspacing=0 cellpadding=0 width="+tWidth+"'  onmouseout='HideMenu_mmc()'><tr><td align='left'>" + vMnuCode + "</td></tr></table>";

	h = vSrc.offsetHeight;
	w = vSrc.offsetWidth;
	l = vSrc.offsetLeft + leftMar+4;
	t = vSrc.offsetTop + topMar + h + space-2;
	vParent = vSrc.offsetParent;
	while (vParent.tagName.toUpperCase() != "BODY")
	{
		l += vParent.offsetLeft;
		t += vParent.offsetTop;
		vParent = vParent.offsetParent;
	}

	menuDiv.innerHTML = vMnuCode;
	menuDiv.style.top = t;
	menuDiv.style.left = l;
	menuDiv.style.visibility = "visible";
	isvisible = true;
   // makeRectangularDropShadow(document.getElementById("menuTable"), MENU_SHADOW_COLOR, 4)
}

function makeRectangularDropShadow(el, color, size)
{
	var i;
	for (i=size; i>0; i--)
	{
		var rect = document.createElement('div');
		var rs = rect.style
		rs.position = 'absolute';
		rs.left = (el.style.posLeft + i) + 'px';
		rs.top = (el.style.posTop + i) + 'px';
		rs.width = el.offsetWidth + 'px';
		rs.height = el.offsetHeight + 'px';
		rs.zIndex = el.style.zIndex - i;
		rs.backgroundColor = color;
		var opacity = 1 - i / (i + 1);
		rs.filter = 'alpha(opacity=' + (100 * opacity) + ')';
		el.insertAdjacentElement('afterEnd', rect);
		global.fo_shadows[global.fo_shadows.length] = rect;
	}
}

document.write("<div id='menuDiv' style='Z-INDEX: 999; VISIBILITY: hidden; POSITION: absolute; '></div>");
