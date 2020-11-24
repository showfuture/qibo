//点击滑动JS
function ShowTab(theA,Small,main){
	next=theA+1;
	for(var i=Small;i< main;i++ ){
		if(i==theA){
			document.getElementById('Tab'+i).style.display='';
			document.getElementById('Span'+i).className='choose';
		}else if(i==Small){
			document.getElementById('Tab'+i).style.display='none';
			document.getElementById('Span'+i).className='begin';
		}else if(i==next){
			document.getElementById('Tab'+i).style.display='none';
			document.getElementById('Span'+i).className='next';
		}else{
			document.getElementById('Tab'+i).style.display='none';
			document.getElementById('Span'+i).className='';	
		}		
	}
}