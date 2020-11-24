//点击滑动JS
function ShowTab(theA,Small,main){
	for(var i=Small;i< main;i++ ){
		document.getElementById('Tab'+i).style.display='none';
		document.getElementById('Span'+i).className='';
	}
	document.getElementById('Tab'+theA).style.display='';
	document.getElementById('Span'+theA).className='ck';
}