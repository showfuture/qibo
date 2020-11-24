function setCookie(name,value,minPra,path,domain,secure)
{  
	var nameString = name+"="+escape(value);
	var expires=new Date();
	var expiryString=((minPra)?";expires="+expires.toGMTString(expires.setTime(expires.getTime()+minPra*1000*60)):'');
	var pathString=((path)?";path="+path:"");
	var domainString=((domain)?";domain="+domain:"");
	var secureString=((secure)?";secure":"");
	document.cookie=nameString+expiryString+pathString+domainString+secureString;
}

function getCookie(name)
{
    var dc=document.cookie;
    var prefix=name+"=";
    var begin=dc.indexOf("; "+prefix);
    if(begin==-1){
        begin=dc.indexOf(prefix);
        if(begin!=0) return null;
    }
    else{
        begin+=2;
    }
    var end=document.cookie.indexOf(";",begin);
    if(end==-1){
        end=dc.length;
    }
    return unescape(dc.substring(begin+prefix.length,end));
}

function deleteCookie(name,path, domain){
	if(getCookie(name)){
		setCookie(name,"",-1,path, domain);
	}
} 
