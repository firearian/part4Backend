<?php
session_start();
$user = 'root';
$password = '';

$dsn = 'mysql:host=localhost;dbname=part4;charset=utf8mb4';
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$data = $_SERVER['QUERY_STRING'];

$stmt = $pdo->prepare("SELECT time FROM qtests WHERE id='$data'");
$results = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);
//<script type="text/javascript" src="Active.js"></script>

$id = "";
$characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));

for ($i = 0; $i < 5; $i++) {
    $rand = mt_rand(0, count($characters) - 1);
    $id .= $characters[$rand];
}

echo '
<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">
  <title>lecturer main menu</title>
    
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>   
    
  <link rel="stylesheet" href="Active.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        
</head>

<body>
   


<!-- Always shows a header, even in smaller screens. -->
<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
  <header class="mdl-layout__header">
    <div class="mdl-layout__header-row">
      <!-- Title -->
      <span class="mdl-layout-title"> ACTIVE SESSION </span>
      <!-- Add spacer, to align navigation to the right -->
      <div class="mdl-layout-spacer"></div>
      <!-- Navigation. We hide it in small screens. -->
      <nav class="mdl-navigation mdl-layout--large-screen-only">
        <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . ' </p>
      </nav>
    </div>
  </header>
  <div class="mdl-layout__drawer">
    <nav class="mdl-navigation">
      <a class="mdl-navigation__link" href="LectureMM.php">Main Menu</a>    
      <a class="mdl-navigation__link" href="logout.php">Logout</a>
    </nav>
  </div>
</div>

<div id="loginTag">   
    <p id="sessiontag">' . $id . '</p>
</div>    
    
<div id="clock">
    <img src="/Clock/dg8.gif" width="5%" name="hr1">
    <img src="/Clock/dg8.gif" width="5%" name="hr2">
    <img src="/Clock/dgc.gif" width="2.5%">
    <img src="/Clock/dg8.gif" width="5%" name="mn1">
    <img src="/Clock/dg8.gif" width="5%" name="mn2">
    <img src="/Clock/dgc.gif" width="2.5%">
    <img src="/Clock/dg8.gif" width="5%" name="se1">
    <img src="/Clock/dg8.gif" width="5%" name="se2">
</div>

<script type="text/javascript">
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
var ttt;
var d = ' . $result['time'] . ';
var hr = d / 60;
var mn = d % 60;
var se = 0;
var ansdata;
var rowid = 0;

function settime (){
    d = document.getElementById("minutesBox").value;
    hr = d / 60;
    mn = d % 60;
    se = 0;
    console.log(d);
    console.log(hr);
    console.log(mn);
    dotime();
}


function dotime() {

    document.hr1.src = getSrc(hr, 10);
    document.hr2.src = getSrc(hr, 1);
    document.mn1.src = getSrc(mn, 10);
    document.mn2.src = getSrc(mn, 1);
    document.se1.src = getSrc(se, 10);
    document.se2.src = getSrc(se, 1);
}

function realtime() {
    $.ajax({
        url: "answerdata.php",
        data: {info:' . $data . ', row: rowid},
        dataType: "json",
        success: function(ans) {
            if (ans.length != ""){
                $("div#dynamicanswers").append(ans.html);
                rowid = ans.lengthy;
            }
        },
        error: function (jqXHR, exception) {
            var msg = "";
            if (jqXHR.status === 0) {
                msg = "Not connect.\n Verify Network.";
            } else if (jqXHR.status == 404) {
                msg = "Requested page not found. [404]";
            } else if (jqXHR.status == 500) {
                msg = "Internal Server Error [500].";
            } else if (exception === "parsererror") {
                msg = "Requested JSON parse failed";
            } else if (exception === "timeout") {
                msg = "Time out error.";
            } else if (exception === "abort") {
                msg = "Ajax request aborted.";
            } else {
                msg = "Uncaught Error.\n" + jqXHR.responseText;
            }
            console.log(msg);
        }
    });
    ttt = setInterval(realtime, 10000);
}

function activate() {
    $.get("ActiveMethods.php?active&' . $data . '&'. $id .'");
}
    

function countdown() {
    // starts countdown
    if (hr < 1 && mn == 0 && se == 0) {
        clearInterval(tt);
        clearTimeout(t);
        $.get("ActiveMethods.php?deactive&' . $data . '");
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
    clearInterval(ttt);
}




function getSrc(digit,index){
    return dg[(Math.floor(digit/index)%10)].src;
}

window.onload=function() {
    dotime();
    tt = setInterval(dotime, 10);
}
</script>
    
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="startButton" type="button" onclick="countdown(); realtime(); activate()">
      Start
    </button>
    
    <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" id="stopButton" type="button" onclick="reset()">
      Stop
    </button>

    <div id="manuleTimeContainer">
        <p> Set time manually (optional)</p>
        <input id="minutesBox" type="text" value="min" name="QuestionName" size="5" style="text-align:center; color:black;">
        <button id="setManuleTime" type="button" onclick="settime();" >Set</button>
    </div>
    

    <div id="dynamicanswers">
    </div>


    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>

    
    
    
    
    
</body>
</html>';
?>
