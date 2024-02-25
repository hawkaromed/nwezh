/* Rename this file to hawa2.js when uploading to your website! */
function hawa2(id="hawa2",dt=5000){
    /* Created with JETA.COM Animated Logo Wizard: https://jeta.com/js-animated-logo.php */
    window.addEventListener("load",function(){
    var logo=document.getElementById(id),style=document.createElement("style");style.type="text/css";
    style.innerHTML="@keyframes jetakey{from{transform:perspective(400px) rotate3d(0,1,0,90deg);animation-timing-function:ease-in;opacity:0}40%{transform:perspective(400px) rotate3d(0,1,0,-20deg);animation-timing-function:ease-in}60%{transform:perspective(400px) rotate3d(0,1,0,10deg);opacity:1}80%{transform:perspective(400px) rotate3d(0,1,0,-5deg)}to{transform:perspective(400px)}}.hawa2{backface-visibility:visible;animation-name:jetakey;animation-duration:1s;animation-fill-mode:both;z-index:1000}";
    document.head.appendChild(style);set();
    function set(){logo.classList.remove("hawa2");setTimeout(function(){logo.classList.add("hawa2");},100);}
    var move=0;logo.addEventListener("mouseover",function(){if(move==0){move=1;set();setTimeout(function(){move=0;},1500);}});
    var time,timer;rtime();["mousedown","mousemove","keypress","scroll","touchstart"].forEach(function(n){document.addEventListener(n,rtime,true);});
    function rtime(g){(g===1)?time+=time:time=dt;clearTimeout(timer);timer=setTimeout(function(){set();rtime(1);},time);}
    });} hawa2();
    