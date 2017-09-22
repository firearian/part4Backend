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

$stmt = $pdo->prepare("SELECT user FROM users WHERE status='lecturer'");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Ask the lecturer</title>
    
 <!-- Latest compiled and minified bootstrap stylesheet -->
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

  <!-- Latest compiled Material Design https://7b0257f4.ngrok.io -->    
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.indigo-pink.min.css">
    
  <link rel="stylesheet" href="SAsk.css">
    
</head>
<body>
   
 <!-----------------------------NAVBAR ----------------------->
   <!-- Always shows a header, even in smaller screens. -->
    <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
      <header class="mdl-layout__header">
          <!-- Title -->
          <br>
          <p id="title">Ask the Lecturer</p>     
          <!-- Add spacer, to align navigation to the right -->
            <p id="LoggedInAs"> You are logged in as ' . $_SESSION['username'] . '</p>
      </header>
        
      <div class="mdl-layout__drawer">
        <nav class="mdl-navigation">
          <a class="mdl-navigation__link" href="StudentMM.php">Main Menu</a>   
          <a class="mdl-navigation__link" href="logout.php">Logout</a>
        </nav>
      </div>
    </div>
        
  <form method="post" id="emailform" action="email.php" enctype="multipart/form-data">    
    <div id="Container">
        <div id="Name">  
            <p>Lecturer name:</p>
                <select class="mdl-selectfield__select" id="LecSel" name="LecSel">
                  <option value=""></option>';

for ($i = 0; $i < count($result); $i++){
    $value = $result[$i]['user'];
    echo '
                        <option value="' . $value . '">' . $value . '</option>';
}
echo '</select>
              </div>      
        </div>
     </div>
    
        <div id="AnswerContainer">
            <p style="text-align: center;font-size: 2vw;"><b> Ask a question or upload a file</b></p> 
        
            <textarea id="Answer" name="Answer" form="emailform" rows="15"></textarea>
        </div>
    
       <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored" type="submit">
        Send
       </button>
   </form>
    
    <img id="UoaLogo" src="/Pictures/uoaLogo.jpg" class="img-responsive" alt="UoaLogo"/>

   <!-- javascript -->
  <script defer src="https://code.getmdl.io/1.3.0/material.min.js"></script>   
  
</body>
</html>'
?>