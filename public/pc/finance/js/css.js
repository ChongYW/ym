
			   var speed22=50

	 var demo5=document.getElementById("demo5"); 

    var demo4=document.getElementById("demo4"); 

     var demo3=document.getElementById("demo3"); 		   

  // demo5.innerHTML=demo4.innerHTML

   function Marquee22(){

   if(demo5.offsetTop-demo3.scrollTop<=0)

   demo3.scrollTop-=demo4.offsetHeight

   else{

   demo3.scrollTop++

   }

   }

   var MyMar22=setInterval(Marquee22,speed22)

   //demo3.onmouseover=function() {clearInterval(MyMar22)}

   //demo3.onmouseout=function() {MyMar22=setInterval(Marquee22,speed22)}
   
   
   
    var speed=30
  demo2.innerHTML=demo1.innerHTML
  function Marquee(){
  if(demo2.offsetWidth-demo.scrollLeft<=0)
  demo.scrollLeft-=demo1.offsetWidth
  else{
  demo.scrollLeft++
  }
  }
  var MyMar=setInterval(Marquee,speed)
  demo.onmouseover=function() {clearInterval(MyMar)}
  demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)}
  
 var speed2=30
  demo8.innerHTML=demo7.innerHTML
  function Marquee2(){
  if(demo8.offsetWidth-demo6.scrollLeft<=0)
  demo6.scrollLeft-=demo7.offsetWidth
  else{
  demo6.scrollLeft++
  }
  }
  var MyMar2=setInterval(Marquee2,speed2)
  demo6.onmouseover=function() {clearInterval(MyMar2)}
  demo6.onmouseout=function() {MyMar2=setInterval(Marquee2,speed2)}
   
   