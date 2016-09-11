function getData(url, containerId)
{
	
	xmlHttp1=GetXmlHttpObject1();
	if(xmlHttp1==null) 
	{	alert ("Your browser does not support AJAX!");
		return;
	}
		//varStatus = offset;
		//alert(varStatus);
		
		var data = "";
		xmlHttp1.onreadystatechange=function()
		{
			if(xmlHttp1.readyState > 0 && xmlHttp1.readyState < 4)
			{
				document.getElementById(containerId).innerHTML = "<img src='images/loading.gif'>";
			}
			if(xmlHttp1.readyState==4)
			{
				//alert(xmlHttp1.responseText);
				document.getElementById(containerId).innerHTML = xmlHttp1.responseText;
			}
		}
		//alert(url);
		xmlHttp1.open("POST",url,true);
		xmlHttp1.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");                  
		xmlHttp1.send(data);
}


function GetXmlHttpObject1()
{	var xmlHttp1=null;
	try
	{
	// Firefox, Opera 8.0+, Safari
	xmlHttp1=new XMLHttpRequest();
	}
	catch (e)
	{	//Internet Explorer
		try
		{
			xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e)
		{
			xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
		}
	}
	return xmlHttp1;
}

