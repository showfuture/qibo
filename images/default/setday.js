document.write('<script type="text/javascript" src="'+getweburl()+'/images/default/jquery-calendar.js"><\/script>');
function setday(obj){
	if (arguments[1]==1){
		$.extend(popUpCal, {timeSeparators:null,fitOld:true});
	}else{
		$.extend(popUpCal, {timeSeparators:[' ',':'],fitOld:true});
	}
	$("input[name$='"+obj.name+"']").calendar();
}