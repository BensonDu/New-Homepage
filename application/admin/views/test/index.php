
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Test</title>
    <style type="text/css">

        ::selection { background-color: #E13300; color: white; }
        ::-moz-selection { background-color: #E13300; color: white; }

        body {
            background-color: #fff;
            margin: 40px;
            font: 13px/20px normal Helvetica, Arial, sans-serif;
            color: #4F5155;
        }
        #scrollbar{
            width: 50px;
            height: 50px;
            background: #4F5155;
            position: fixed;
            right: 10%;
            bottom: 15%;
            display: none;
        }
        #ex{
            width: 100%;
            height: 3000px;
        }
    </style>
</head>
<body>
<div id="ex"> <div id="scrollbar"></div></div>

</body>
<script>
var bar=document.getElementById('scrollbar');
    window.onscroll=function(){
      var h=document.body.scrollTop,style;
        style=h>0?'block':'none';
        bar.style.display=style;
    };
    /*bar.onclick=function(){
        var t=document.body.scrollTop, s,e;
        if(t>0){e= t/(200/13);
            s=setInterval(function(){
                t=t-e;
                if(t<0){
                    t=0;
                    clearInterval(s);
                }
                document.body.scrollTop=t;
            },13);
        }
    };*/
    (function(){
        var now=function(){
            return ( new Date() ).getTime();
            },
            bounce= function(x, t, b, c, d) {
                return c*((t=t/d-1)*t*t + 1) + b;
            },
            scroll=function(d){
            var st=document.body.scrollTop,
                end= 0,
                s,
                n=now(),
                t=setInterval(function(){
                    var r=now();
                    if(r>n+d){
                        s=1;
                        clearInterval(t);
                    }
                    else{
                        s=bounce((r-n)/d,(r-n),0,1,d);
                    }
                    document.body.scrollTop=st-s*(st-end);
                },13);

        };
        document.getElementById('scrollbar').onclick=function(){scroll(1000);}
        var d= 400,t= 0.5;
        //console.log(bounce(0,t,0,0,d));
        //console.log((t/d-1)*t*t+1);
    }).call(this);
</script>
</html>