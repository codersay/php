$(function(){
	$.formValidator.initConfig({autotip:true,formid:"myform",onerror:function(msg){}});
	$("#modelid").formValidator({onshow:"请选择模型",onfocus:"请选择模型"}).inputValidator({min:1,max:50,onerror:"请选择模型"});
	$("#catid").formValidator({onshow:"请选择栏目",onfocus:"请选择栏目"}).inputValidator({min:1,max:50,onerror:"请选择栏目"});
	$("#title").formValidator({onshow:"标题不能为空",onfocus:"标题不能为空"}).inputValidator({min:1,max:50,onerror:"标题不能为空"});
	$("#content").formValidator({onshow:"内容不能为空",onfocus:"内容不能为空"}).inputValidator({min:1,max:50,onerror:"内容不能为空"});
	
});