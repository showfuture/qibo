//发布页选择类目JS动作
function changeClassName(slevel,my,fid,next,ctype,Murl)
{
	if(slevel>4) return false;
	for(var i=slevel+1;i<=2;i++){
		document.getElementById('cate_menu_'+String(i)).innerHTML="";
			
	}
	

	document.getElementById("likeajaxform").src='job.php?job=post&action=getfidsonslist&fup='+fid+'&class='+String(slevel+1)+"&ctype="+ctype;
	var mydiv =document.getElementById('cate_menu_'+String(slevel));
	var mydivs=mydiv.getElementsByTagName('a');
	for(var i=0;i<mydivs.length;i++)
	{	
		mydivs[i].className='unselected';
	}
	my.className='selected';
	document.getElementById('fid').value=fid;
	if(next==false){
		document.getElementById('nextdo').disabled=false;
	}else{
		document.getElementById('nextdo').disabled="disabled";
	}
	
	create_mycate(slevel);
	
	if(ctype>0 && next==false ){
	document.getElementById("parameters_postform_load").src='job.php?job=post&action=oladparametersform&fid='+fid+'&showid=parameters_postform&id='+document.getElementById('id').value;
	}
}
function create_mycate(slevel)
{
	var str='您当前选择的是:<font color="#232323">';

	for(var i=1;i<=slevel;i++)
	{
		var str2=getmydivs_choosedName(i);
		if(str2!=''){
		str+=" &gt; ";
		str+=str2;
		}
		
	}
	document.getElementById('choosed').innerHTML=str+"</font>";
}
function getmydivs_choosedName(myi)
{
	var mydiv =document.getElementById('cate_menu_'+String(myi));
	var mydivs=mydiv.getElementsByTagName('a');
	for(var i=0;i<mydivs.length;i++)
	{	
		if(mydivs[i].className=='selected'){
			return mydivs[i].innerHTML;
		}
	}
	return "";
}
function inputcontent(content,slevel){
	inputcontent_to(content,'cate_menu_'+String(slevel))
}
function inputcontent_to(content,id){
	document.getElementById(id).innerHTML=content;
}

/*
* 设置选过的分类
*/
function setOldFid(me,Murl, ctype){
	var option=me.options[me.selectedIndex];
	if(me.value!='0'){ 
		document.getElementById('fid').value=option.value;
		document.getElementById('choosed').innerHTML='您当前选择的是:<font color="#232323"> '+option.text+"</font>";
		me.selectedIndex=0;
		document.getElementById("parameters_postform_load").src='job.php?job=post&action=oladparametersform&fid='+option.value+'&showid=parameters_postform&id='+document.getElementById('id').value;
	}
}


 
