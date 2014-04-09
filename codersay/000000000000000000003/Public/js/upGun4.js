// ActionScript Document
 var speed=60;
              var xcolee2=document.getElementById("xcolee2");
              var xcolee1=document.getElementById("xcolee1");
              var xcolee=document.getElementById("xcolee");
              xcolee2.innerHTML=xcolee1.innerHTML; //克隆colee1为colee2
              function xMarquee1(){
              //当滚动至colee1与colee2交界时
                 if(xcolee2.offsetTop-xcolee.scrollTop<=0){
                   xcolee.scrollTop-=xcolee1.offsetHeight; //colee跳到最顶端
                 }else{
                     xcolee.scrollTop++
                     }
                 }
             var xMyMar1=setInterval(xMarquee1,speed)//设置定时器
            //鼠标移上时清除定时器达到滚动停止的目的
             xcolee.onmouseover=function() {clearInterval(xMyMar1)}
            //鼠标移开时重设定时器
             xcolee.onmouseout=function(){xMyMar1=setInterval(xMarquee1,speed)}