
              var speed=60;
              var pcolee2=document.getElementById("pcolee2");
              var pcolee1=document.getElementById("pcolee1");
              var pcolee=document.getElementById("pcolee");
              pcolee2.innerHTML=pcolee1.innerHTML; //克隆colee1为colee2
              function pMarquee1(){
              //当滚动至colee1与colee2交界时
                 if(pcolee2.offsetTop-pcolee.scrollTop<=0){
                   pcolee.scrollTop-=pcolee1.offsetHeight; //colee跳到最顶端
                 }else{
                     pcolee.scrollTop++
                     }
                 }
             var pMyMar1=setInterval(pMarquee1,speed)//设置定时器
            //鼠标移上时清除定时器达到滚动停止的目的
             pcolee.onmouseover=function() {clearInterval(pMyMar1)}
            //鼠标移开时重设定时器
             pcolee.onmouseout=function(){pMyMar1=setInterval(pMarquee1,speed)}
	  