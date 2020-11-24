function load_sort_td(t){
	t=parseInt(t);
	if(t<1)t=20 ;
	t=t+1;
	obj_tr=document.getElementById("list_sort").getElementsByTagName("tr");
	for(var i=0;i<obj_tr.length ;i++ ){
		obj_td=obj_tr[i].getElementsByTagName("td");
		str=obj_td[1].innerHTML;
		ar=str.split('|--');
		ar2=ar[0].split('|');
		vv=ar.length+ar2.length;
		if(t>0){
			if(vv>t){
				obj_tr[i].style.display='none';
			}else{
				obj_tr[i].style.display='';
			}
		}
	}
	set_sort_icon();
}

function set_sort_icon(){
	var kv=2;
	obj_tr=document.getElementById("list_sort").getElementsByTagName("tr");
	for(var i=0;i<obj_tr.length ;i++ ){
		obj_td=obj_tr[i].getElementsByTagName("td");
		obj_span=obj_td[1].getElementsByTagName("span");
		if(obj_span.length>0){
			obj_span[0].id='sort_'+i;
		}
		str=obj_td[1].innerHTML;
		ar=str.split('|--');
		ar2=ar[0].split('|');
		vv=ar.length+ar2.length;
		if(vv>kv){
			j=i-1;
			if(obj_tr[i].style.display=='none'){
				get_obj('sort_'+j).innerHTML='<A HREF="javascript:set_sort_td('+j+',1)"><img src="images/menu_add.gif" border=0></A>';
			}else{
				get_obj('sort_'+j).innerHTML='<A HREF="javascript:set_sort_td('+j+',0)"><img src="images/menu_reduce.gif" border=0></A>';
			}
		}
		kv=vv;
	}
}

function set_sort_td(t,tt){
	var set=0;
	obj_tr=document.getElementById("list_sort").getElementsByTagName("tr");
	for(var i=0;i<obj_tr.length ;i++ ){
		obj_td=obj_tr[i].getElementsByTagName("td");
		obj_span=obj_td[1].getElementsByTagName("span");
		if(obj_span.length>0){
			obj_span[0].id='sort_'+i;
		}
		str=obj_td[1].innerHTML;
		ar=str.split('|--');
		ar2=ar[0].split('|');
		vv=ar.length+ar2.length;
		if(set==1){
			if(vv>kv){
				if(tt==1){
					obj_tr[i].style.display='';
				}else {
					obj_tr[i].style.display='none';
				}
			}else{
				set=0;
			}
		}
		if(t==i){
			kv=vv;
			set=1;
		}
	}
	set_sort_icon();
}