var showlist = 5;
var beginnum = 0;
var obj = document.getElementById("ShowList").getElementsByTagName("li");
var listnum = obj.length;
var endnum = listnum - showlist;
function showup(){
 if(beginnum>0){
  beginnum-=1;
  showlist-=1;
  showstyle();   
 }
}
function showdown(){
 lastnum = listnum - showlist;
 if(lastnum>0){
  beginnum+=1;
  showlist+=1;  
  showstyle();  
 } 
}
function showstyle(){
 for(var i=0;i<listnum;i++ ){
  if(i<beginnum || i>=showlist){
   obj[i].style.display='none';
  }else{
   obj[i].style.display='';
  }
 }
 if(beginnum==0){
 	document.getElementById("showup").className='up0';
	document.getElementById("showdown").className='down';
 }else if(endnum==beginnum){
 	document.getElementById("showdown").className='down0';
	document.getElementById("showup").className='up';
 }else{
 	document.getElementById("showdown").className='down';
  	document.getElementById("showup").className='up'; 
 }
}
showstyle();