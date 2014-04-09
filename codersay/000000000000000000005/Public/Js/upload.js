$(document).ready(function(){
	$("#getAtr").click(function(){             
         $str='';  
         $str+="<tr align='center' bgcolor='#FFFFFF'>";          
         $str+="<td><input type='file' name='img[]' /></td>";  
         $str+="<td onClick='getDel(this)'><a href='#'>ㄨ</a></td>";       
         $str+="</tr>";  
         $("#addTr").append($str);      
    });  
});
function getDel(k){  
     $(k).parent().remove();       
 } 
