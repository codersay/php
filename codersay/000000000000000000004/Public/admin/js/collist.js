/**
 * @栏目列表JS
 * @author: rui <zer0131@hotmail.com>
 * @time: 2013/04/03
 * @Copyright: www.iqishe.com
*/

$(document).ready(function (){
	$("#channeltype").change(function(){
		$.ajax({
			type:"get",
			url:"/iqishe.php",
			data:"m=Columns&a=getValByAjax&mid="+$(this).val(),
			success:function(data){
				$("#colgrade").empty();
				$("#colgrade").append(data);
			}
		});
	});
});



