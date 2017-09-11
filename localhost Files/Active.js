dg = new Array();
dg[0]=new Image();dg[0].src="/Clock/dg0.gif";
dg[1]=new Image();dg[1].src="/Clock/dg1.gif";
dg[2]=new Image();dg[2].src="/Clock/dg2.gif";
dg[3]=new Image();dg[3].src="/Clock/dg3.gif";
dg[4]=new Image();dg[4].src="/Clock/dg4.gif";
dg[5]=new Image();dg[5].src="/Clock/dg5.gif";
dg[6]=new Image();dg[6].src="/Clock/dg6.gif";
dg[7]=new Image();dg[7].src="/Clock/dg7.gif";
dg[8]=new Image();dg[8].src="/Clock/dg8.gif";
dg[9]=new Image();dg[9].src="/Clock/dg9.gif";
var t;
var tt;
var end = false;
var d = 1;
var hr = d / 60;
var mn = d % 60;
var se = 00;

function dotime() {

    document.hr1.src = getSrc(hr, 10);
    document.hr2.src = getSrc(hr, 1);
    document.mn1.src = getSrc(mn, 10);
    document.mn2.src = getSrc(mn, 1);
    document.se1.src = getSrc(se, 10);
    document.se2.src = getSrc(se, 1);
}

function countdown() {
    // starts countdown
    if (hr < 1 && mn == 0 && se == 0) {
        clearInterval(tt);
        clearTimeout(t);
    }
    if (mn === 0 && se === 0){
        hr--;
        mn = 59;
        se = 60;
    } else if (se === 0) {
        mn--;
        se = 60;
    } else {
        se--;
    }
    t = setTimeout(countdown, 100);

}

function reset (){
    clearTimeout(t);
}


function getSrc(digit,index){
    return dg[(Math.floor(digit/index)%10)].src;
}

window.onload=function() {
    dotime();
    tt = setInterval(dotime, 10);
}
