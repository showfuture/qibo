function RollingImages(g){
//s:a进,b退,c当前,d数组,e导航宽,f等待小,g前数,h大高,i索引,k最大,l预载,n首,o,等待大,p尾,r切换,tAT,u自动,w大宽,xA宽,z原始
//l:Loading图片
var s={i:0,d:g.data.slice(0)},d=document,w=window,m,k=0,j='javascript:;',
o={o:$(g.main),m:C('div'),p:$(g.prev),n:$(g.next),z:$(g.thum),t:I(g.timeout),x:undefined!=g.interval?I(g.interval):5000},
e='Netscape'!=navigator.appName;s.k=s.d.length-1;
s.w=o.o.offsetWidth;s.h=o.o.offsetHeight;s.u=I(g.interval);
m=C('a');A(o.z,o.m);A(o.m,m);
o.h=m.offsetHeight;o.w=o.h/0.75;
D(m);o.z=o.z.offsetWidth;m=this;
function $(i){return d.getElementById(i)}
function A(p,c){p.appendChild(c)}
function B(t){//大图树连接
	clearInterval(t.t);
	t.t=W()-t.b;
	var e,i,x,y,z,n=t.n;
	if(0!=this){//加载成功
		i=this,x=i.width/s.w,y=i.height/s.h,z=i.width/i.height;
		if(x>1||y>1){i.width=x<y?s.h*z:s.w;i.height=x<y?s.h:s.w/z;}
		with(i.style){left=(s.w-i.width)/2+'px';top=(s.h-i.height)/2+'px'}
		i.alt=(t.d[2]?t.d[2]:'');
		t.b=i;
	}else{
		e=C('p');
		with(e.style){
			marginTop=s.h*0.618+'px';
			textAlign='center'
		}
		e.innerHTML='图片加载失败，自动加载下一张 <a href="'+t.d[0]+'" target="_blank">点击打开本图片</a>';
		t.b=e;
		t.e=1;
	}
	if(t==s.c)S();
	if(n){if(!n.b){L(n.d[0],arguments.callee,n)}}else s.f=1
}
function C(n){return d.createElement(n)}
function D(c){c.parentNode.removeChild(c)}
function I(i){var v=parseInt(i);return isNaN(v)?0:v}
function L(u,f,a){//LoadImage
	var i=new Image(),t;
	if(o.t)t=setTimeout(function(){f.call(0,a)},o.t);
	a.t=setInterval(function(){
		if(i.complete){clearTimeout(t);if(i.width)f.call(i,a);else if(!e)f.call(0,a)}
	},100);
	if(e)i.onerror=function(){clearTimeout(t);f.call(0,a)};
	if(B==f||V==f){a.b=W();s.l=a}
	i.src=u
}
function O(o,i){with(o.style){KhtmlOpacity=MozOpacity=pacity=i;filter='alpha(opacity='+(i*100)+')'}}
function Q(){if(s.o){s.a=s.o;s.o=0;R()}else{s.r=0;if(s.u&&!o.u)s.t=setTimeout(m.next,o.x)}}
function R(){
	if(s.b!=s.a){
		var i=0,b=s.b;
		if(s.a){
			A(o.o,s.a);
			O(s.a,i);
		}
		s.r=setInterval(function(){
			i+=0.1;
			if(s.a)O(s.a,i);if(b)O(b,1-i);
			if(i>=1){
				clearInterval(s.r);
				if(b)D(b);
				s.b=s.a;
				Q();
			}
		},50);
	}else Q()
}
function S(){
	clearTimeout(s.t);
	if(s.c){
		if(s.z)s.z.s.className='';
		s.z=s.c;
		s.z.s.className='current';
		if('object'==typeof s.z.b){
			if(s.g){
				if(s.e>o.z){
					var w=s.z.w-s.g*s.x;
					if(w<0)w=0;else if(w>s.e-o.z)w=s.e-o.z;
					o.m.style.marginLeft='-'+w+'px';
				}
			}else if(s.x){
				s.g=parseInt(o.z/s.x/2);
			}
			if(s.r)s.o=s.z.b;else{s.a=s.z.b;R()}
			if(s.z.e&&s.z.n){
				s.z.p.n=s.z.n;//修改连接表，删除此结点
				s.z.n.p=s.z.p;
			}
		}else{s.a=0;R();L(s.z.d[0],B,s.z)}
	}else{s.a=0;R()}
}
function T(t){//小图树连接
	clearInterval(t.t);
	var i=this;
	if(0!=i){//加载成功
		var a=C('a'),x=i.width/o.w,y=i.height/o.h,z=i.width/i.height;
		if(x>1||y>1){
			i.width=x<y?o.h*z:o.w;
			i.height=x<y?o.h:o.w/z
		}
		if(!s.n)s.n=s.p=t;
		t.d=s.d[k];
		t.s=a;
		t.p=s.p;
		if(t.p)t.p.n=t;else s.n=t;
		s.p=t;
		a.onclick=function(){m.goto(t)	};
		a.href=j;
		A(a,i);
		A(o.m,a);
		if(!s.x){
			if(undefined!=s.e){
				s.x=a.offsetLeft-s.e;
				t.w=s.e=s.x;
				s.e*=2;
			}else{
				s.e=a.offsetLeft;
				t.w=0
			}
		}else{
			t.w=s.e;
			s.e+=s.x;
			o.m.style.width=s.e+'px'
		}
		if(t.d[2])i.alt=t.d[2];
		if(s.i==k||s.f){if(s.f){s.f=0;L(t.d[0],B,t)}else L(t.d[0],V,t);s.l=t}
	}else{
		if(s.i==k)s.i++;
	}
	k++;X();
}
function V(t){s.c=t;B.call(this,t)}
function W(){return (new Date).getTime()}
function X(){//开始
	var i=s.d[k];
	if(k>s.k){s.p.n=s.n;s.n.p=s.p}else L(i[1]?i[1]:i[0],T,{})
}
X();
m.start=function(i){if(!s.u){s.u=1;i=I(i);if(i>k)s.i=i;else{var a=0;s.c=s.n;while(a++<i)s.c=s.c.n;S()}}};
m.stop=function(){s.u=0};
o.o.onmouseover=function(){clearTimeout(s.t);o.u=1};
o.o.onmouseout=function(){o.u=0;if(s.u)s.t=setTimeout(m.next,o.x)};
o.p.onclick=m.prev=function(){if(s.c&&s.c.p){s.c=s.c.p;S()}};
o.n.onclick=m.next=function(){if(s.c&&s.c.n){s.c=s.c.n;S()}};
m.goto=function(o){s.c=o;S()};
}