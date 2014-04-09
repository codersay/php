// ActionScript Document

  var speed=60;
              var ycolee2=document.getElementById("ycolee2");
              var ycolee1=document.getElementById("ycolee1");
              var ycolee=document.getElementById("ycolee");
              ycolee2.innerHTML=ycolee1.innerHTML; //克隆colee1为colee2
              function yMarquee1(){
              //当滚动至colee1与colee2交界时
                 if(ycolee2.offsetTop-ycolee.scrollTop<=0){
                   ycolee.scrollTop-=ycolee1.offsetHeight; //colee跳到最顶端
                 }else{
                     ycolee.scrollTop++
                     }
                 }
             var yMyMar1=setInterval(yMarquee1,speed)//设置定时器
            //鼠标移上时清除定时器达到滚动停止的目的
             ycolee.onmouseover=function() {clearInterval(yMyMar1)}
            //鼠标移开时重设定时器
             ycolee.onmouseout=function(){yMyMar1=setInterval(yMarquee1,speed)}