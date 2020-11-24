var t=document.getElementById("pictable");
var rl=t.rows.length;
			   
var picarry = {};
var lnkarry = {};
var ttlarry = {};
function FixCode(str){
	return str.replace("'","=");
}

for(var i=0;i<rl;i++){
	try{
		picarry[i]=t.rows[i].cells[0].childNodes[0].src;
		lnkarry[i]=t.rows[i].cells[2].innerHTML;
		lnkarry[i] = lnkarry[i].replace(/&amp;/g, "&"); 
		ttlarry[i]=FixCode(t.rows[i].cells[1].innerHTML);
	}catch(e){

	}
} 
document.write("<div class='SlidePics'><div class='Pic'>");
for(var j=0;j<rl;j++){
	document.write("<div><a href='"+lnkarry[j]+"' target='_blank'><img src='"+picarry[j]+"' alt='"+ttlarry[j]+"'\/><\/a><\/div>");
}
document.write("<\/div><div class='Title'><ul class='shows'>");
for(var j=1;j<=rl;j++){
	document.write("<li>"+j+"</li>");
}
document.write("</ul><\/div><div class='conertL'></div><div class='conertR'></div><div class='conerdL'></div><div class='conerdR'></div><\/div>");

jQuery(".SlidePics").slide({effect:"leftLoop",autoPlay:true,titCell:".shows li",mainCell:".Pic"});