var currslid = 0;
var slidint;
var t=document.getElementById("pictable");
var rl=t.rows.length;
var list=rl-1;
function setfoc(id){
	document.getElementById("bigimg").src = picarry[id];
	document.getElementById("a_jimg").href = lnkarry[id];
	document.getElementById("a_jimg1").href = lnkarry[id];
	document.getElementById("a_jimg1").innerHTML = ttlarry[id];
	currslid = id;
	for(i=0;i<rl;i++){
		document.getElementById("thedl"+i).className = "";
	};
	document.getElementById("thedl"+id).className ="on";
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
	if(currslid==list){
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

var baseu=  document.URL.replace(/(http.*\/)(.*)/, "$1"); 

var txt="";
for(var i=0;i<rl;i++){
	try{
		picarry[i]=t.rows[i].cells[0].childNodes[0].src;
		lnkarry[i]=t.rows[i].cells[2].innerHTML;
		lnkarry[i] = lnkarry[i].replace(/&amp;/g, "&"); 
		ttlarry[i]=FixCode(t.rows[i].cells[1].innerHTML);
		document.getElementById("li_jimg"+i).innerHTML = '<a href="'+lnkarry[id]+'" target="_blank" class="img"><img src="'+picarry[id]+'" alt=""><\/a>';
		alert(picarry[i]);
	}catch(e){

	}
}  
document.write("<div class='showpic'><a class='a_jimg' id='a_jimg' href='"+lnkarry[0]+"' target='_blank'><img id='bigimg' style='filter:RevealTrans (duration='1',transition='23'); visibility:visible;' src='"+picarry[0]+"'><\/a><a class='a_jimg1' id='a_jimg1' href='"+lnkarry[0]+"' target='_blank'>"+ttlarry[0]+"<\/a><\/div>");
document.write("<div class='showlist'>");
for(var j=0;j<rl;j++){
	if(j==0){
		document.write("<div class='on' id='thedl0' onmouseover='setfoc(0)' onmouseout='playit()'><a href='"+lnkarry[0]+"' target='_blank'><img src='"+picarry[0]+"' alt='"+ttlarry[0]+"' width='80' height='60'><\/a><\/div>");	
	}else{
		document.write("<div id='thedl"+j+"' onmouseover='setfoc("+j+")' onmouseout='playit()'><a href='"+lnkarry[j]+"' target='_blank'><img src='"+picarry[j]+"' alt='"+ttlarry[j]+"' width='80' height='60'><\/a><\/div>");	
	}
}
document.write("<\/div>");
document.close();