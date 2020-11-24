<!--

function Ajax(args)
{
	// 信息显示对像ID
	this.MsgID		= "MsgBox_";
	this.MsgIDOpacity	= 100;
	// 错误字符串
	this.ErrorStr 		= null;
	// 错误事件驱动,当发生错误时触发
	this.OnError 		= null;
	// 状态事件驱动,当状态改变时触发
	this.OnState 		= null;
	// 完成事件驱动,当类操作完成时触发
	this.OnDownloadEnd 	= null;

	// 错误显示容器
	this.OnErrorOBJ		= null;
	// 状态显示容器
	this.OnStateOBJ 	= null;
	// 完成显示容器
	this.OnDownloadEndOBJ 	= null;

	// XMLHTTP 发送数据类型 GET 或 POST
	this.method		= "GET";
	// 将要获取的URL地址
	this.URL		= null;
	// 指定同步或异步读取方式(true 为异步,false 为同步)
	this.sync		= true;
	// 当method 为 POST 时 所要发送的数据
	this.PostData		= null
	// 返回读取完成后的数据
	this.RetData 		= null;

	// 创建XMLHTTP对像
	this.HttpObj 		= this.createXMLHttpRequest();
	if(this.HttpObj == null)
	{
		// 对像创建失败时中止运行
		return;
	}

	// 获取参数
	if(args)
	{
		var iargs = eval(args);
		// 获取事件与事件容器
		if(iargs.Events)
		{
			
			// 获取OnError事件
			if(iargs.Events[0].OnError)
			{
				this.OnError		= iargs.Events[0].OnError;
			}
			// 获取OnState事件
			if(iargs.Events[0].OnState)
			{
				this.OnState		= iargs.Events[0].OnState;
			}
			// 获取OnDownloadEnd事件
			if(iargs.Events[0].OnDownloadEnd)
			{
				this.OnDownloadEnd	= iargs.Events[0].OnDownloadEnd;
			}
		}

		// 获取容器
		if(iargs.Vessels)
		{
			
			// 获取Error容器
			if(document.getElementById(iargs.Vessels[0].OnErrorOBJ))
			{
				this.OnErrorOBJ 	= document.getElementById(iargs.Vessels[0].OnErrorOBJ);
			}
			// 获取State容器
			if(document.getElementById(iargs.Vessels[0].OnStateOBJ))
			{
				this.OnStateOBJ 	= document.getElementById(iargs.Vessels[0].OnStateOBJ);
			}
			// 获取DownloadEnd容器
			if(document.getElementById(iargs.Vessels[0].OnDownloadEndOBJ))
			{
				this.OnDownloadEndOBJ	= document.getElementById(iargs.Vessels[0].OnDownloadEndOBJ);
			}
		}


		// 获取请求参数
		if(iargs.Sender)
		{
			if(iargs.Sender[0].Method)
			{
				this.method	= iargs.Sender[0].Method;
			}

			if(iargs.Sender[0].URL)
			{
				this.URL	= iargs.Sender[0].URL;
			}

			if(iargs.Sender[0].Sync)
			{
				this.Sync	= iargs.Sender[0].Sync;
			}

				
			if(iargs.Sender[0].PostData)
			{
				this.PostData	= iargs.Sender[0].PostData;
			}

			var RxURL = /^http:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?$/;
			if(RxURL.test(this.URL))
			{
				this.send();
			}
		}

	}

	var Obj = this;
	// 调用事件检测
	this.HttpObj.onreadystatechange = function()
	{
		Ajax.handleStateChange(Obj);
	}
}

// 信息显示
Ajax.prototype.MsgBox = function(strMsg)
{
	var Msg = "<table id=\""+ this.MsgID +"\" style=\"width: 100%;height: 100%;background-color: #ffffff;border: 0px solid #a9a9a9;color: #c0c0c0;font-size:12px;text-align: center;filter:alpha(opacity=100);\">";
	    Msg+= "<tr><td align=\"center\">"+ strMsg + "</td></tr>";
	    Msg+= "</table>";

	return Msg;
}

// UTF 转入 GB (by:Rimifon)
Ajax.prototype.UTFTOGB = function(strBody)
{
	var Rec=new ActiveXObject("ADODB.RecordSet");
	Rec.Fields.Append("DDD",201,1);
	Rec.Open();
	Rec.AddNew();
	Rec(0).AppendChunk(strBody);
	Rec.Update();
	var HTML=Rec(0).Value;
	Rec.Close();
	delete Rec;
	return(HTML);
}

// 创建XMLHTTP对像
Ajax.prototype.createXMLHttpRequest = function()
{
	if (window.XMLHttpRequest) 
	{ 
		//Mozilla 浏览器
		return new XMLHttpRequest();
	}
	else if (window.ActiveXObject)
	{
        	var msxmls = new Array('Msxml2.XMLHTTP.5.0','Msxml2.XMLHTTP.4.0','Msxml2.XMLHTTP.3.0','Msxml2.XMLHTTP','Microsoft.XMLHTTP');
        	for (var i = 0; i < msxmls.length; i++)
        	{
                	try 
                	{
                        	return new ActiveXObject(msxmls[i]);
                	}catch (e){}

		}
	}
    	return null;
}

// 发送HTTP请求
Ajax.prototype.send = function()
{

	this.MsgID = this.MsgID + ((new Date()).getTime()).toString();

	if(this.HttpObj == null)
	{
		// 对像创建失败时中止运行
		this.ErrorStr = "你的浏览器不支持XMLHttpRequest对象．"
		// 响应到错误事件
		if(this.OnError)
		{
			this.OnError(this.ErrorStr);
		}
		// 响应到错误容器
		if(this.OnErrorOBJ)
		{
			this.OnErrorOBJ.innerHTML = this.MsgBox(this.ErrorStr);
		}
		return;
	}

	if (this.HttpObj !== null)
	{
		this.URL = this.URL + "?t=" + new Date().getTime();
		this.HttpObj.open(this.method, this.URL, this.sync);
		if(this.method.toLocaleUpperCase() == "GET")
		{
			this.HttpObj.send(null);
		}
		else if(this.method.toLocaleUpperCase() == "POST")
		{
			this.HttpObj.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			this.HttpObj.send(this.PostData);
		}
		else
		{
			this.ErrorStr = "错误的[method]命令．"
			// 响应到错误事件
			if(this.OnError)
			{
				this.OnError(this.ErrorStr);
			}
			// 响应到错误容器
			if(this.OnErrorOBJ)
			{
				this.OnErrorOBJ.style.display = "block";
				this.OnErrorOBJ.innerHTML = this.MsgBox(this.ErrorStr);
			}
			return;
		}

	}

}

// 取得状态
Ajax.prototype.GetState = function(State)
{
	var StateValue = null;
	switch (State)
	{
   		case 0:
		StateValue = "未初始化...";
		break;

   		case 1:
		StateValue = "开始读取数据...";
		break;

   		case 2:
		StateValue = "已开始读取数据...";
		break;

   		case 3:
		StateValue = "读取数据中...";
		break;

   		case 4:
		StateValue = "读取完成...";
		break;

   		default: 
		StateValue = "未初始化...";
		break;
	}
	return (StateValue);
}

// 事件检测
Ajax.handleStateChange = function(Obj)
{
	var StateStr = Obj.GetState(Obj.HttpObj.readyState);
	// 响应到状态事件
	if(Obj.OnState)
	{
		Obj.OnState(StateStr);
	}
	// 响应到状态容器
	if(Obj.OnStateOBJ)
	{
		Obj.OnStateOBJ.style.display = "block";
		Obj.OnStateOBJ.innerHTML = Obj.MsgBox(StateStr);
	}

	if (Obj.HttpObj.readyState == 4)
	{
		// 判断对象状态
            	if (Obj.HttpObj.status == 200) 
                { 
					Obj.RetData = Obj.UTFTOGB(Obj.HttpObj.responseBody);
					// 响应到DownloadEnd事件
					if(Obj.OnDownloadEnd)
					{
						Obj.OnDownloadEnd(Obj.RetData);
					}
					// 响应到DownloadEnd容器
					if(Obj.OnDownloadEndOBJ)
					{
		
						Obj.OnErrorOBJ.style.display = "none";
						Obj.OnStateOBJ.style.display = "none";
						Obj.OnDownloadEndOBJ.style.display = "block";
						Obj.OnDownloadEndOBJ.innerHTML = Obj.RetData;
					}
                        return;
                } 
		else 
		{ 
			Obj.ErrorStr = "您所请求的页面有异常．"
			// 响应到错误事件
			if(Obj.OnError)
			{
				Obj.OnError(Obj.ErrorStr);
			}
			// 响应到错误容器
			if(Obj.OnErrorOBJ)
			{
				Obj.OnErrorOBJ.style.display = "block";
				Obj.OnErrorOBJ.innerHTML = Obj.MsgBox(Obj.ErrorStr);
			}
			return;
		}
	}
}
//-->


<!--

// 错误回调事件函数
function EventError(strValue){
	document.getElementById("Events").value = strValue;
}

// 状态回调事件函数
function EventState(strValue){
	document.getElementById("Events").value = strValue;
}

// 完成回调事件函数
function EventDownloadEnd(strValue){
	document.getElementById("Events").value = strValue;
}

function ajax2get(requestfile,data,showdiv){
var A = new Ajax();
// 指定错误容器
A.OnErrorOBJ 		= document.getElementById(showdiv);
// 指定状态容器
A.OnStateOBJ 		= document.getElementById(showdiv);
// 指定完成容器
A.OnDownloadEndOBJ 	= document.getElementById(showdiv);

A.method 	= "POST";
A.URL		= requestfile;
A.Sync		= false;
A.PostData  = data;
A.send();
}
//-->