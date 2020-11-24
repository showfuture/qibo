



var jumpto=true;
function showlabel_(obj,mouse,inc,chtype){
	if(mouse=='over'){
		obj.style.filter='Alpha(Opacity=80)';
		obj.style.cursor='hand';
		obj.title='µã»÷ÐÞ¸Ä';
	}else if(mouse=='out'){
		obj.style.filter='Alpha(Opacity=50)';
	}else if(mouse=='click'&&jumpto==true){
		window.self.location=admin_url+'/index.php?lfj=label&inc='+inc+'&job=mod&ch='+ch+'&chtype='+chtype+'&tag='+obj.id+'&div_width='+parseInt(obj.style.width)+'&div_height='+parseInt(obj.style.height)+"&ch_fid="+ch_fid+"&ch_pagetype="+ch_pagetype+"&ch_module="+ch_module+"&mystyle="+mystyle+"&fromurl="+fromurl;
	}
}
function ckjump_(type){
	if(type==1){
		jumpto=true;
	}else{
		jumpto=false;
	}
}
var layobj=null;
var potype=null;
var ifchange=null;
function change_po_(type,t,tag){
	ifchange=t;
	layobj=document.getElementById(tag);
	potype=type;
	change_ls_();
}

function change_ls_(){
 
	var obj=layobj;
	var type=potype;
	if(type=='up'){
		num=(parseInt(obj.style.height)-1);
		obj.style.height=num+'px';
	}else if(type=='left'){
		num=(parseInt(obj.style.width)-1);
		obj.style.width=num+'px';
	}else if(type=='down'){
		num=(parseInt(obj.style.height)+1);
		obj.style.height=num+'px';
	}else if(type=='right'){
		num=(parseInt(obj.style.width)+1);
		obj.style.width=num+'px';
	}

	if(ifchange==1){
		window.setTimeout('change_ls_()',40);
	}
}









