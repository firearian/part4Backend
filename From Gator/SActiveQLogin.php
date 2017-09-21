<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true && $_SESSION['status'] == "s") {} else {
        echo '<script type="text/javascript"> window.location = "index.html" </script>';
}
date_default_timezone_set('Pacific/Auckland');

$user = 'pomufoq_root';
$password = 'password';

$dsn = 'mysql:host=localhost;dbname=pomufoq_part4;charset=utf8mb4';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $password, $opt);

$stmt = $pdo->prepare("SELECT id FROM qtests WHERE deleted='0' AND active=TRUE LIMIT 1");
$results = $stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$valid = false;

if ($result != null){
    $valid = true;
}



echo '<!doctype html>

<html lang="en">
<head>
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1">

 <title>Login to Quiz</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="SActiveQLogin.css">    
   
            
</head>

<body> 
  
  
    <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Login to Quiz</p>     
          <!-- Add spacer, to align navigation to the right -->
          <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
      </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
            <a class="mdl-navigation__link" href="StudentMM.php">Main menu</a>
            <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>
    
    <div class=container-fluid>
      <div id="QuizText">
      </div>
    </div>

    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" alt="UoaLogo"/>

          <!-- javascript -->
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script> 
    
</body>

<script type="text/javascript">
function page(){
    var v = ' . json_encode($valid) . ';
    console.log(v);

    if (v == true){
        document.getElementById("QuizText").innerHTML = "<div id=\"QuizFound\"><h1>Active quiz found!</h1><p>Please enter below the login tag provided by your lecturer.</p><form method=\"post\" action=\"SActiveQuiz.php\"><div id=\"Login\"><input id=\"NameTfield\" type=\"text\" name=\"Qname\" style=\"text-align:center; color:black; required\"></div><br><button class=\"mdl-button mdl-js-button mdl-button--raised mdl-button--colored\" type=\"submit\">Login to quiz</button></form></div>";
    console.log("here");
    }
    else {
        document.getElementById("QuizText").innerHTML = "<div id=\"QuizFound\"><h1>Active quiz not found!</h1><p style=\"font-size: 1.7vw;\">Please wait till your lecturer publishes a Quiz.</p></div>";
    console.log("there");
    }
}

window.onload=function() {
    page();
}
</script>

</html>'
?>