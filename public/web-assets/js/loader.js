var locked=false;
var $sentIcon=$(".sent-icon")
    ,$indicatorDots=$(".send-indicator-dot")

send();

function send(){
    if(locked) return;

    locked=true;

    $indicatorDots.each(function(i){
        startCircleAnim($(this),50,0.1,1+(i*0.2),1.1+(i*0.3));
    })
}

function setupCircle($obj){
    if(typeof($obj.data("circle"))=="undefined"){
        $obj.data("circle",{radius:0,angle:0});

        function updateCirclePos(){
            var circle=$obj.data("circle");
            TweenMax.set($obj,{
                x:Math.cos(circle.angle)*circle.radius,
                y:Math.sin(circle.angle)*circle.radius,
            })
            requestAnimationFrame(updateCirclePos);
        }
        updateCirclePos();
    }
}

function startCircleAnim($obj,radius,delay,startDuration,loopDuration){
    setupCircle($obj);
    $obj.data("circle").radius=0;
    $obj.data("circle").angle=0;
    TweenMax.to($obj.data("circle"),startDuration,{
        delay:delay,
        radius:radius,
        ease:Quad.easeInOut
    });
    TweenMax.to($obj.data("circle"),loopDuration,{
        delay:delay,
        angle:Math.PI*2,
        ease:Linear.easeNone,
        repeat:-1
    });
}
function stopCircleAnim($obj,duration){
    TweenMax.to($obj.data("circle"),duration,{
        radius:0,
        ease:Quad.easeInOut,
        onComplete:function(){
            TweenMax.killTweensOf($obj.data("circle"));
        }
    });
}

$(document).ready(function(){
    setTimeout(function(){
        $indicatorDots.each(function(i){
            stopCircleAnim($(this),0.8+(i*0.1));
        });
        TweenMax.fromTo($sentIcon,1,{
            display:"inline-block",
            opacity:0,
            scale:0.1
        },{
            scale:1,
            opacity:1,
            ease:Elastic.easeOut
        });
        setTimeout(function(){
            $(".loader").hide();
        },1000);
    },2000);
})
