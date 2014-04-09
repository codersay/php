// ActionScript Document

function show(id){
 var idd="sub"+id;
 var iddd="menu"+id
 document.getElementById(idd).style.display="block";
 document.getElementById(iddd).className="menuHover";
}
function hide(){
	for(var i=1;i<6;i++)
	{
	 var id="sub"+i.toString();
	 var idd="menu"+i.toString();
	 document.getElementById(idd).className="menu";
     document.getElementById(id).style.display="none";	
	}
}