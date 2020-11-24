var currslid = 0;
var slidint;
function setfoc(id){
	document.getElementById("bigimg").src = picarry[id];
	document.getElementById("a_jimg").href = lnkarry[id];
	document.getElementById("div_jtt").innerHTML = '<a href="'+lnkarry[id]+'" target="_blank">'+ttlarry[id]+'</a>';
	if (id==5) {
			document.getElementById("a_jimg").style.background = 'url('+picarry[0]+')';
		}
		else {
			document.getElementById("a_jimg").style.background = 'url('+picarry[id+1]+')';
		}
	currslid = id;
	for(i=0;i<5;i++){
		document.getElementById("li_jimg"+i).className = "li_jimg";
	};
	document.getElementById("li_jimg"+id).className ="li_jimg on";

	var borserInfo=navigator.userAgent.toLowerCase();
	if(/msie/.test(borserInfo))
	{
		document.getElementById("bigimg").style.visibility = "hidden";
		document.getElementById("bigimg").filters[0].Apply();
		document.getElementById("bigimg").filters[0].transition=23;
		if (document.getElementById("bigimg").style.visibility == "visible") {
			document.getElementById("bigimg").style.visibility = "hidden";
		}
		else {
			document.getElementById("bigimg").style.visibility = "visible";
		}
		document.getElementById("bigimg").filters[0].Play();
	}
	stopit();
}

function playnext(){
	if(currslid==4){
		currslid = 0;
	}
	else{
		currslid++;
	};
	setfoc(currslid);
	playit();
}
function playit(){
	slidint = setTimeout(playnext,2500);
}
function stopit(){
	clearTimeout(slidint);
}

window.onload = function(){
	playit();
}

function playit01(){
	document.getElementById("playStop").className = "stop";
	playit();
}
function stopit01(){
	document.getElementById("playStop").className = "play";
	stopit();
}

var picarry = {};
var lnkarry = {};
var ttlarry = {};
function FixCode(str){
    return str.replace("'","=");
}
var t=document.getElementById("pictable");
var rl=t.rows.length;

var txt="";
for(var i=0;i<rl;i++){
      picarry[i]=t.rows[i].cells[0].childNodes[0].src;
      lnkarry[i]=t.rows[i].cells[2].innerHTML;

	  	re = /&amp;/g;
   lnkarry[i] = lnkarry[i].replace(re, "&"); 

       ttlarry[i]=FixCode(t.rows[i].cells[1].innerHTML);

}
   
          
document.write("<div class='div_jimg'><a class='a_jimg' id='a_jimg' href='"+lnkarry[0]+"' title='' style='background:url("+picarry[1]+")' target='_blank'><img id='bigimg' style='filter:RevealTrans (duration='1',transition='23'); visibility:visible;' alt='' src='"+picarry[0]+"'><\/a><ul class='ul_jimg'><li class='li_jimg on' id='li_jimg0' onmouseover='setfoc(0)' onmouseout='playit()'><a href='"+lnkarry[0]+"' target='_blank' class='img'><img src='"+picarry[0]+"'><\/a><\/li><li class='li_jimg' id='li_jimg1' onmouseover='setfoc(1)' onmouseout='playit()'><a href='"+lnkarry[1]+"' target='_blank' class='img'><img src='"+picarry[1]+"'><\/a><\/li><li class='li_jimg' id='li_jimg2' onmouseover='setfoc(2)' onmouseout='playit()'><a href='"+lnkarry[2]+"' target='_blank' class='img'><img src='"+picarry[2]+"'><\/a><\/li><li class='li_jimg' id='li_jimg3' onmouseover='setfoc(3)' onmouseout='playit()'><a href='"+lnkarry[3]+"' target='_blank' class='img'><img src='"+picarry[3]+"'><\/a><\/li><li class='li_jimg' id='li_jimg4' onmouseover='setfoc(4)' onmouseout='playit()'><a href='"+lnkarry[4]+"' target='_blank' class='img'><img src='"+picarry[4]+"'><\/a><\/li><\/ul><\/div><div class='div_jtt' id='div_jtt'><a href='"+lnkarry[0]+"' target='_blank'>"+ttlarry[0]+"<\/a><\/div>");
document.close();
