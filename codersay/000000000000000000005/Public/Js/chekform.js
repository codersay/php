  <!--
    $(function(){
        $('#form1').ajaxForm({
		    beforeSubmit:  check,  // pre-submit callback
            success:       complete,  // post-submit callback
            dataType: 'json'
        });
        function check(){
            if( '' == $.trim($('#username').val())){
                $('#result').html('标题不能为空').show();
                return false;
            }
			if($('#username').val().length >=6 || $('#username').val().length <=2){
			   $('#result').html('昵称的长度要在2-5个字之间').show();
                return false;
			}
			if($('#content').val().length >=500 || $('#content').val().length <=3){
			   $('#result').html('内容字数要在2-500之间').show();
                return false;
			}
			if($('#email').val().match(/\w+@\w+\.\w/)){
			   
               return true;
			}else{
			  $('#result').html('要按邮箱规则输入').show();
			  return false;
			}

			
        }
        function complete(data){
            if (data.status==1){
                $('#result').html(data.info).show();
                // 更新列表
                data = data.data;
                var html =  '<div class="result" style=\'font-weight:normal;background:#A6FF4D\'><div style="border-bottom:1px dotted silver">'+data.username+'  ['+data.email+data.url+']</div><div class="content">'+data.content+'</div></div>';
                $('#list').prepend(html);
				$('#reset').click(); 
				
				//window.setTimeout(function (){window.location.reload(),50000});
				$('#result').html('表发成功!').show(); 
				window.setTimeout(function (){window.location.reload()},2000);
				window.setTimeout(function (){window.location.href = "#comment"},500);
				//window.location = "#comment";
            }else{
                $('#result').html(data.info).show();
            }
        }

    });