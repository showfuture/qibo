function thumbImg(obj, method) {
	if(!obj) {
		return;
	}
	obj.onload = null;
	file = obj.src;
	zw = obj.offsetWidth;
	zh = obj.offsetHeight;
	if(zw < 2) {
		if(!obj.id) {
			obj.id = 'img_' + Math.random();
		}
		setTimeout("thumbImg(document.getElementById('" + obj.id + "'), " + method + ")", 100);
		return;
	}
	zr = zw / zh;
	method = !method ? 0 : 1;
	if(method) {
		fixw = obj.getAttribute('_width');
		fixh = obj.getAttribute('_height');
		if(zw > fixw) {
			zw = fixw;
			zh = zw / zr;
		}
		if(zh > fixh) {
			zh = fixh;
			zw = zh * zr;
		}
	} else {
		var imagemaxwidth = isUndefined(imagemaxwidth) ? '600' : imagemaxwidth;
		var widthary = imagemaxwidth.split('%');
		if(widthary.length > 1) {
			fixw = document.getElementById('wrap').clientWidth - 200;
			if(widthary[0]) {
				fixw = fixw * widthary[0] / 100;
			} else if(widthary[1]) {
				fixw = fixw < widthary[1] ? fixw : widthary[1];
			}
		} else {
			fixw = widthary[0];
		}
		if(zw > fixw) {
			zw = fixw;
			zh = zw / zr;
			obj.style.cursor = 'pointer';
			if(!obj.onclick) {
				obj.onclick = function() {
					zoom(obj, obj.src);
				};
			}
		}
	}
	obj.width = zw;
	obj.height = zh;
}

var zoomclick = 0, zoomstatus = 1;

function ctrlEnter(event, btnId, onlyEnter) {
	if(isUndefined(onlyEnter)) onlyEnter = 0;
	if((event.ctrlKey || onlyEnter) && event.keyCode == 13) {
		document.getElementById(btnId).click();
		return false;
	}
	return true;
}

function hasClass(elem, className) {
	return elem.className && (" " + elem.className + " ").indexOf(" " + className + " ") != -1;
}

function runslideshow() {
	var slideshows = [];
	var elements = document.getElementsByTagName('ul');
	for(var i=0,L=elements.length; i<L; i++) {
		if(hasClass(elements[i], 'slideshow')) {
			slideshows.push(elements[i]);
		}
	}
	var elements = document.getElementsByTagName('div');
	for(var i=0,L=elements.length; i<L; i++) {
		if(hasClass(elements[i], 'slideshow')) {
			slideshows.push(elements[i]);
		}
	}
	for(var i=0,L=slideshows.length; i<L; i++) {
		new slideshow(slideshows[i]);
	}
}
function slideshow(el) {
	var obj = this;
	var parent = el;
	while ((parent = parent.parentNode) && parent != document.body) {
		if (hasClass(parent,'content')) {
			this.blockid = parent.id.replace(/_content/g,'');
			break;
		}
	}
	this.blockid = this.blockid ? this.blockid : el.parentNode.parentNode.id;
	if(typeof slideshow.entities == 'undefined') {
		slideshow.entities = [];
	}
	for(var i=0,L=slideshow.entities.length; i<L;i++) {
		if(slideshow.entities[i].blockid == this.blockid) {
			return ;
		}
	}
	this.id = slideshow.entities.length;
	slideshow.entities[this.id] = this;
	this.container = el;
	this.elements = [];
	this.imgs = [];
	this.imgLoad = [];
	this.imgLoaded = 0;
	this.index = this.length = 0;
	var nodes = el.childNodes;
	for(var i=0, L=nodes.length; i<L; i++) {
		if (nodes[i].nodeType == 1) {
			this.elements[this.length] = nodes[i];
			this.length += 1;
		}
	}
	for(var i=0, L=this.elements.length; i<L; i++) {
		this.elements[i].style.display = "none";
	}
	this.container.parentNode.style.position = 'relative';
	this.slidebar = document.createElement('div');
	this.slidebar.className = 'slidebar';
	this.slidebar.style.display = 'none';
	var html = '<ul>';
	for(var i=0; i<this.length; i++) {
		html += '<li onmouseover="slideshow.entities[' + this.id + '].xactive(' + i + '); return false;">' + (i + 1).toString() + '</li>';
	}
	html += '</ul>';
	this.slidebar.innerHTML = html;
	this.container.parentNode.appendChild(this.slidebar);
	this.controls = this.slidebar.getElementsByTagName('li');

	this.active = function(index) {
		this.elements[this.index].style.display = "none";
		this.elements[index].style.display = "block";
		this.controls[this.index].className = '';
		this.controls[index].className = 'on';
		this.index = index;
	};
	this.xactive = function(index) {
		clearTimeout(this.timer);
		this.active(index);
		var ss = this;
		this.timer = setTimeout(function(){
			ss.run();
		}, 8000);
	};
	this.run = function() {
		var index = this.index + 1 < this.length ? this.index + 1 : 0;
		this.active(index);
		var ss = this;
		this.timer = setTimeout(function(){
			ss.run();
		}, 2500);
	};

	var imgs = el.getElementsByTagName('img');
	for(i=0, L=imgs.length; i<L; i++) {
		this.imgs.push(imgs[i]);
		this.imgLoad.push(new Image());
		this.imgLoad[i].src = this.imgs[i].src;
		this.imgLoad[i].onerror = function (){obj.imgLoaded ++;};
	}

	this.getSize = function (img) {
		if (!img) return false;
		this.width = img.width ? parseInt(img.width) : 0;
		this.height = img.height ? parseInt(img.height) : 0;
		var ele = img.parentNode;
		while ((!this.width || !this.height) && !hasClass(ele,'slideshow') && ele != document.body) {
			this.width = ele.style.width ? parseInt(ele.style.width) : 0;
			this.height = ele.style.height ? parseInt(ele.style.height) : 0;
			ele = ele.parentNode;
		}
		return true;
	};

	this.getSize(imgs[0]);

	this.checkLoad = function () {
		var obj = this;
		for(i = 0;i < this.imgs.length;i++) {
			if(this.imgLoad[i].complete && !this.imgLoad[i].status) {
				this.imgLoaded++;
				this.imgLoad[i].status = 1;
			}
		}
		if(this.imgLoaded < this.imgs.length) {
			if (!document.getElementById(this.blockid+'_percent')) {
				var dom = document.createElement('div');
				dom.id = this.blockid+"_percent";
				dom.style.width = this.width ? this.width+'px' : '150px';
				dom.style.height = this.height ? this.height+'px' : '150px';
				dom.style.lineHeight = this.height ? this.height+'px' : '150px';
				dom.style.backgroundColor = '#ccc';
				dom.style.textAlign = 'center';
				dom.style.top = '0';
				dom.style.left = '0';
				el.parentNode.appendChild(dom);
			}
			el.parentNode.style.position = 'relative';
			document.getElementById(this.blockid+'_percent').innerHTML = (parseInt(this.imgLoaded / this.imgs.length * 100)) + '%';
			setTimeout(function () {obj.checkLoad();}, 100)
		} else {
			if (document.getElementById(this.blockid+'_percent')) el.parentNode.removeChild(document.getElementById(this.blockid+'_percent'));
			this.container.style.display = 'block';
			this.slidebar.style.display = '';
			this.index = this.length -1;
			this.run();
		}
	};
	this.checkLoad();
}