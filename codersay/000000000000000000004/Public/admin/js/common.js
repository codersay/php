/**
 * @公共JS
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/03/20
 * @Copyright: www.iqishe.com
*/

//根据Id获取元素
function $Id(id)
{
	return document.getElementById(id);
}

//根据Name获取元素
function $Name(name)
{
	return document.getElementsByName(name);
}

//根据Tag获取元素
function $Tag(tag)
{
	return document.getElementsByTagName(tag);
}

//获取浏览器信息
function $Nav()
{
	if(window.navigator.userAgent.indexOf("MSIE")>=1)
	{
		return 'IE';
	}
	else if(window.navigator.userAgent.indexOf("Firefox")>=1)
	{
		return 'FF';
	}
	else 
	{
		return "OT";
	}
}

//全选or反选
function selOrNoSel(name)
{
	var checkboxs = $Name(name);
	for (var i=0;i<checkboxs.length;i++) 
	{
		var e = checkboxs[i];
		e.checked = !e.checked;
	}
}

//显示or隐藏table
function ShowHideT(objid)
{
	var obj = $Id(objid);
	if(obj.style.display != "none" )
	{
		obj.style.display = "none";
	}
	else
	{
		obj.style.display = ($Nav()=="IE" ? "block" : "table");
	}
}

//删除确认
function del(url,myform)
{
	if(confirm("确定删除记录吗?")){
		return $Id(myform).action = url;
	}
	else{
		return false;
	}
} 

//系统参数配置Tab切换
function ShowConfig(em,allgr)
{
	for(var i=1;i<=allgr;i++)
	{
		if(i==em) $Id('td'+i).style.display = ($Nav()=='IE' ? 'block' : 'table');
		else $Id('td'+i).style.display = 'none';
	}
	$Id('addvar').style.display = 'none';
}