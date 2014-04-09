// ActionScript Document

              var speed=60;
              var colee2=document.getElementById("colee2");
              var colee1=document.getElementById("colee1");
              var colee=document.getElementById("colee");
              colee2.innerHTML=colee1.innerHTML; //克隆colee1为colee2
              function Marquee1(){
              //当滚动至colee1与colee2交界时
                 if(colee2.offsetTop-colee.scrollTop<=0){
                   colee.scrollTop-=colee1.offsetHeight; //colee跳到最顶端
                 }else{
                     colee.scrollTop++
                     }
                 }
             var MyMar1=setInterval(Marquee1,speed)//设置定时器
            //鼠标移上时清除定时器达到滚动停止的目的
             colee.onmouseover=function() {clearInterval(MyMar1)}
            //鼠标移开时重设定时器
             colee.onmouseout=function(){MyMar1=setInterval(Marquee1,speed)}