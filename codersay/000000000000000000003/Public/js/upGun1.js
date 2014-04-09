// ActionScript Document

	var speed=30;
			marquee_product2.innerHTML=marquee_product1.innerHTML;
			function Marquee(){
			if(marquee_demo.scrollLeft>=marquee_product1.scrollWidth){
			marquee_demo.scrollLeft=0;
			}
			else{
			marquee_demo.scrollLeft++;
			}
			}
			var MyMar=setInterval(Marquee,speed);
			marquee_demo.onmouseover=function(){clearInterval(MyMar);}
			marquee_demo.onmouseout=function(){MyMar=setInterval(Marquee,speed);}